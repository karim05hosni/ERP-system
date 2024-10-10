<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\traits\Api_Response_Trait;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use Api_Response_Trait;
    public function store(Request $request)
    {
        // decode json
        $data = json_decode($request->getContent(), true);
        $product_data =[];
        $user = auth('sanctum')->user();
        // check if user have cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        foreach ($data["products"] as $productData) {
        $product = Product::find($productData['product_id']);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        // dd($cart);
        if ($cart->products()->find($product->id)) {
            // Product already exists in the cart, update the quantity
            $cart->products()->updateExistingPivot($product->id, ['quantity' => $cart->products()->find($product->id)->pivot->quantity + $productData['quantity']]);
        } else {
            // Product doesn't exist in the cart, add it
            $cart->products()->attach($product->id, ['quantity' => $productData['quantity']]);
        } 
        $pivot = $cart->products()->find($product->id)->pivot;
        $product_data[]= [
            'cart_id'=> $cart->id,
            'product_id' => $productData['product_id'],
            'quantity' => $pivot->quantity,
        ];
        }
        return $this->Api_Response(
            message: 'Added to cart successfuly !',
            data: $product_data 
        );
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth('sanctum')->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $product_data = $cart->products()->get();

        $cart_data = [
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'products' => $product_data->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name_en' => $product->name_en,
                    'quantity' => $product->pivot->quantity,
                ];
            }),
        ];
        return $cart_data;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // decod json request
        $data = json_decode($request->getContent(), true);
        // dd($data);
        $user = auth('sanctum')->user();
        $cart = Cart::where('user_id', $user->id)->first();
        foreach ($data["products"] as $item){
            $pivot = $cart->products()->find($item['id'])->pivot;
            $pivot->quantity -= $item['quantity'];
            if($pivot->quantity <= 0){
                $cart->products()->detach($item['id']);
            }else{
                $pivot->save();
            }
        }
        return $this->Api_Response(message:'item removed successfuly !');
    }
}

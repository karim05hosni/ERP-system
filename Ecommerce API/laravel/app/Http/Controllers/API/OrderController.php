<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Order\PlaceOrderRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    use Api_Response_Trait;
    
    public function placeOrder(PlaceOrderRequest $request){
        $data = $request->except('products');
        // dd(auth('sanctum')->user());
        $data['status'] = 'Pending';
        $data['price']= 0;
        $user = User::find(auth('sanctum')->user()->id);
        $order = Order::create($data);
        foreach ($request->products as $productData) {
            # code...
            $product = Product::find($productData['id']);
            $data['price'] += $productData['quantity'] * $product->price;
            // check inventory
            if ($product->quantity >= $productData['quantity']){
                $product->quantity -= $productData['quantity'];
                $product->save();
            } else {
                return $this->Api_Response(message:'Product '.$product->name_en.' Sold Out !');
            }
            // record pivot table
            $order->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);
        }
        // validate payment
        $payment = true;
        // update order status
        if($payment){
            Order::where('id', $order->id)->update(['status' => 'Confirmed', 'price'=>$data['price']]);
            // notify user
            FacadesNotification::send($user, new OrderConfirmed($order));
            // return response
            return $this->Api_Response(message:'Order Confirmed !', data: Order::where('id', $order->id)->first()->toArray());
        } else {
            Order::where('id', $data['id'])->update(['status' => 'Canceled']);
            // notify user
            // return response
            return $this->Api_Response(message:'Order Canceled !', errors: 'Invalid Payment');
        }
    }
}

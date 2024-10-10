<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Order\PlaceOrderRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\Warehouse;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    use Api_Response_Trait;

    public function placeOrder(PlaceOrderRequest $request)
    {
        $data = $request->except('products');
        $data['status'] = 'Pending';
        $data['price'] = 0;
        $user = User::find(auth('sanctum')->user()->id);
        $order = Order::create($data);
        $warehouse = Warehouse::where('location', $data['address'])->get('id')->first()->id;
        // validate payment
        $payment = true;
        foreach ($request->products as $productData) {
            # code
            $product = Product::find($productData['id']);
            $data['price'] += $productData['quantity'] * $product->price;
            // check if product exists in warehouse
            if (Inventory::where('product_id', $product->id)->where('warehouse_id', $warehouse)->first()) {
                // check quantity in warehouse
                if (Inventory::where('warehouse_id', $warehouse)->first()->quantity >= $productData['quantity']) {
                    // update quantity in warehouse
                    Inventory::where('warehouse_id', $warehouse)->where('product_id', $productData['id'])->first()->update([
                        'quantity' => Inventory::where('warehouse_id', $warehouse)->where('product_id', $product->id)->first()->quantity - $productData['quantity']
                    ]);
                } else {
                    // check other warehouses
                    $warehouse = Inventory::where('product_id', $productData['id'])
                        ->where('quantity', '>', $productData['quantity'])
                        ->first()->warehouse_id;
                    $u = Inventory::where('warehouse_id', $warehouse)
                    ->where('product_id', $productData['id'])->first()
                    ->decrement('quantity', $productData['quantity']); 
                }
            } else {
                $warehouse = Inventory::where('product_id', $product->id)
                    ->where('quantity', '>', $productData['quantity'])
                    ->get('warehouse_id')->first()->warehouse_id;
                Inventory::where('warehouse_id', $warehouse)->where('product_id', $product->id)->first()->update([
                    'quantity' => Inventory::where('warehouse_id', $warehouse)->where('product_id', $product->id)->first()->quantity - $productData['quantity']
                ]);
            }
            // record pivot table
            // check if product in warehouse
            $order->products()->attach($productData['id'], [
                'quantity' => $productData['quantity'],
                'warehouse_id' => $warehouse
            ]);
            $sale = new Sale();
            $sale->product_id = $product->id;
            $sale->quantity = $productData['quantity'];
            $sale->price_per_unit = $product->price;
            $sale->cost_per_unit = $product->cost_per_unit;
            $sale->total_price = $productData['quantity'] * $product->price;
            $sale->sale_date = date('Y-m-d');
            if ($payment) {
                $sale->save();
            }
        }
        // update order status
        if ($payment) {
            Order::where('id', $order->id)->update(['status' => 'Confirmed', 'price' => $data['price']]);
            // notify user
            FacadesNotification::send($user, new OrderConfirmed($order));
            // return response
            return $this->Api_Response(message: 'Order Confirmed !', data: Order::where('id', $order->id)->first()->toArray());
        } else {
            Order::where('id', $data['id'])->update(['status' => 'Canceled']);
            // notify user
            // return response
            Inventory::where('warehouse_id', $warehouse)->first()->update([
                'quantity' => Inventory::where('warehouse_id', $warehouse)->first()->quantity + $productData['quantity']
            ]);
            return $this->Api_Response(message: 'Order Canceled !', errors: 'Invalid Payment');
        }
    }
}

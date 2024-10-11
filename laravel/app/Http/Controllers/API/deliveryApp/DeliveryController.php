<?php

namespace App\Http\Controllers\API\deliveryApp;

use App\Http\Controllers\Controller;
use App\Http\traits\Api_Response_Trait;
use App\Models\Order;
use App\Models\ShippedOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    use Api_Response_Trait;
    //
    public function showOrders()
    {
        $ready_orders = Order::where('process', 'Ready')
            ->get(['id', 'user_Id', 'price', 'address']);
        foreach ($ready_orders as $order) {
            $coordinates = Order::query()->select([
                DB::raw('ST_X(coordinates) AS lat'),
                DB::raw('ST_Y(coordinates) AS lng')
            ])->where('id', $order->id)->first();
            $order->coordinates = $coordinates->lat . ',' . $coordinates->lng;
        }
        return $this->Api_Response(message: 'Orders Retrieved Succcessfuly !', data: $ready_orders->toArray());
    }
}

<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));  // Get Stripe API key from .env
    }

    // Handle the creation of a Stripe Checkout Session
    public function createCheckoutSession(array $data, $success_url='https://your-payment-gateway.com/payment-success',$cancel_url='https://your-payment-gateway.com/payment-failed')
    {
        // Save the order directly using Eloquent
        $order = Order::create([
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        $order_data = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $order->product_name,
                    ],
                    'unit_amount' => $order->price*100,  // Amount in cents (e.g., 2000 = $20)
                ],
                'quantity' => $order->quantity,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,  // Pass the order_id here
            ],
            'success_url' => route('success',$order->id).'?redirect_url=' . urlencode($success_url),
            'cancel_url' => $cancel_url,
        ];
        // Create a Stripe Checkout Session
        return Session::create($order_data);
    }
}

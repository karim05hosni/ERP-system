<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class PaymentService
{
    public function createCheckoutSession($lineItems)
    {
        $stripe = new \Stripe\StripeClient('sk_test_51Q3O7vA9AuhZk2XNTPOS5rJcKcrTXTCncRDjfnXELOmJuXR9mpBJYFBztFqSjes6KPd2aGvLxk6Mr18xsb9ZWWTT00rtSfsCqG');
        $response = $stripe->checkout->sessions->create([
            'success_url' => url('/api/checkout-success?session_id={CHECKOUT_SESSION_ID}'),
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);
        return $response;
    }
}

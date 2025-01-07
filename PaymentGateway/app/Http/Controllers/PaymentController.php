<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCheckoutRequest;
use App\Models\Order;
use App\Services\PaymentService;
use App\traits\Api_Response_Trait;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class PaymentController extends Controller
{
    use Api_Response_Trait;
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // Show the checkout form
    public function create()
    {
        return view('checkout');  // Return a view with a form for checkout
    }
    public function PaymentEvent(Request $request) {}

    public function CheckoutSessionRequest()
    {
        // dd(env('STRIPE_SECRET_KEY'));
        $order = [
            [
                'name' => 'Product A',
                'quantity' => 2,
                'price' => 500 * 100, // Amount in cents (e.g., $50.00)
            ],
            [
                'name' => 'Product B',
                'quantity' => 1,
                'price' => 300 * 100, // Amount in cents (e.g., $30.00)
            ],
        ];

        // Map order items to Stripe line items
        $lineItems = array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'egp',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'],
                ],
                'quantity' => $item['quantity'],
            ];
        }, $order);
        $PSP = new PaymentService();
        $response = $PSP->createCheckoutSession($lineItems);
        return response()->json($response);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $session = StripeSession::retrieve($sessionId);
        $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
        dd([
            'session' => $session,
            'paymentIntent' => $paymentIntent,
        ]);
        try {
            // Store transaction details in your database
            DB::table('transactions')->insert([
                'user_id' => 22,
                'order_id' => $session->client_reference_id,
                'transaction_id' => $paymentIntent->id,
                'payment_method'=>$paymentIntent->payment_method_types[0],
                'amount' => $paymentIntent->amount_total / 100, // Convert cents to dollars
                'currency' => $paymentIntent->currency,
                'status' => $paymentIntent->status,
                'created_at' => now(),
            ]);
            return view('checkout.success', ['session' => $session]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function status($order_id)
    {
        $order = Order::find($order_id);

        if (!$order) {
            return $this->Api_Response(400,  'Order not found');
        }

        return $this->Api_Response(message: 'Retrieved Successfuly', data: [
            'order_id' => $order->id,
            'status' => $order->status,
        ]);
    }
}

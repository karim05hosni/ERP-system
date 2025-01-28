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
use Illuminate\Support\Facades\Http;
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

    public function CheckoutSessionRequest(Request $request)
{
    // Get order data from request (products, user_id, address, etc.)
    $orderData = $request->all();
    // dd($orderData);

    // Build line items for Stripe
    $lineItems = array_map(function ($item) {
        return [
            'price_data' => [
                'currency' => 'egp',
                'product_data' => ['name' => $item['name']],
                'unit_amount' => $item['price'],
            ],
            'quantity' => $item['quantity'],
        ];
    }, $orderData['products']);

    // Store metadata for later use in the success callback
    $metadata = [
        'user_id' => $orderData['user_id'],
        'products' => json_encode($orderData['products']),
        'address' => 'Giza',//$orderData['address'],
        'latitude' => 30.004579502081093,//$orderData['latitude'],
        'longitude' => 31.19829147095168,//$orderData['longitude'],
    ];

    // Create the Stripe session with metadata
    $PSP = new PaymentService();
    $response = $PSP->createCheckoutSession($lineItems, $metadata);
    // dd('sss');

    return response()->json($response);
}

    // public function CheckoutSessionRequest(Request $request)
    // {
    //     // dd(env('STRIPE_SECRET_KEY'));
    //     // dd($request->all());
    //     // get order data fro request
    //     $order = $request->all();
    //     // dd($order);
    //     // $order = [
    //     //     [
    //     //         'name' => 'Product A',
    //     //         'quantity' => 2,
    //     //         'price' => 500 * 100, // Amount in cents (e.g., $50.00)
    //     //     ],
    //     //     [
    //     //         'name' => 'Product B',
    //     //         'quantity' => 1,
    //     //         'price' => 300 * 100, // Amount in cents (e.g., $30.00)
    //     //     ],
    //     // ];
    //     // Map order items to Stripe line items
    //     $lineItems = array_map(function ($item) {
    //         return [
    //             'price_data' => [
    //                 'currency' => 'egp',
    //                 'product_data' => [
    //                     'name' => $item['name'],
    //                 ],
    //                 'unit_amount' => $item['price'],
    //             ],
    //             'quantity' => $item['quantity'], 
    //         ];
    //     }, $order);
    //     $PSP = new PaymentService();
    //     $response = $PSP->createCheckoutSession($lineItems);
    //     return response()->json($response);
    // }

    // public function success(Request $request)
    // {
    //     $sessionId = $request->query('session_id');
    //     $session = StripeSession::retrieve($sessionId);
    //     $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
    //     dd([
    //         'session' => $session,
    //         'paymentIntent' => $paymentIntent,
    //     ]);
    //     // send request to place order
    //     try {
    //         // Store transaction details in your database
    //         DB::table('transactions')->insert([
    //             'user_id' => 22,
    //             'order_id' => $session->client_reference_id,
    //             'transaction_id' => $paymentIntent->id,
    //             'payment_method'=>$paymentIntent->payment_method_types[0],
    //             'amount' => $paymentIntent->amount_total / 100, // Convert cents to dollars
    //             'currency' => 'EGP',
    //             'status' => $paymentIntent->status,
    //             'created_at' => now(),
    //         ]);
    //         return view('checkout.success', ['session' => $session]);
    //     } catch (\Exception $e) {
    //         return response()->json($e);
    //     }
    // }


public function success(Request $request)
{
    $sessionId = $request->query('session_id');
    $session = StripeSession::retrieve($sessionId);
    $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
    try {
        // Extract metadata from the Stripe session
        $metadata = $session->metadata;
        $user_id = $metadata->user_id;
        $products = json_decode($metadata->products, true); // Decode JSON to array
        $address = $metadata->address;
        $latitude = $metadata->latitude;
        $longitude = $metadata->longitude;

        // Prepare the data for the Ecommerce API
        $data = [
            'products' => $products,
            'user_id' => $user_id,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        // Send POST request to the Ecommerce API
        $response = Http::withHeaders([
            // 'Accept' => 'application/json',
        ])->post('http://enterprisesoftware.root/EcommerceAPI/laravel/public/api/user/order/place-order', $data);

        // Check if the API request was successful
        if ($response->successful()) {
            $order = $response->json();
            // Insert transaction into the database
            DB::table('transactions')->insert([
                'user_id' => $user_id,
                'order_id' => $order['Ecommerce_api']['data']['id'], // Use the order ID from the API response
                'transaction_id' => $paymentIntent->id,
                'payment_method' => $paymentIntent->payment_method_types[0],
                'amount' => $paymentIntent->amount / 100, // Convert cents to EGP
                'currency' => 'EGP',
                'status' => $paymentIntent->status,
                'created_at' => now(),
            ]);

            return view('checkout.success', ['session' => $session]);
        } else {
            // Handle API errors (e.g., log the error)
            // \Log::error('Order placement failed: ' . $response->body());
            return redirect()->route('payment.failed')->with('error', 'Order placement failed.');
        }
    } catch (\Exception $e) {
        // \Log::error('Payment success error: ' . $e->getMessage());
        throw $e;
        // return redirect()->route('payment.failed')->with('error', 'Payment processing failed.');
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

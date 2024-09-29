<?php 
namespace App\Http\Controllers;

use App\Http\Requests\CreateCheckoutRequest;
use App\Models\Order;
use App\Services\PaymentService;
use App\traits\Api_Response_Trait;
use Illuminate\Http\Request;

class checkoutController extends Controller
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

    // Process the payment

    
    public function process(Request $request)
    {
        
        // Use the payment service to handle the payment process
        $checkoutSession = $this->paymentService->createCheckoutSession($request->all(), $request->success_url);        
        return $this->Api_Response(message: 'created successfully',data:[
            'checkout_url' => $checkoutSession->url,
            'order_id' => $checkoutSession->metadata['order_id']
        ]);  // Redirect to Stripe checkout page
    }

    public function success($order_id){
        $order = Order::find($order_id);
        if (!$order) {
            return $this->Api_Response(400,  'Order not found');
        }
        $order->status = 'paid';
        $order->save();
        return redirect(request()->input('redirect_url'));
    }

    public function status($order_id)
    {
        $order = Order::find($order_id);

        if (!$order) {
            return $this->Api_Response(400,  'Order not found');
        }

        return $this->Api_Response(message: 'Retrieved Successfuly', data:[
            'order_id' => $order->id,
            'status' => $order->status,
        ]);
    }
}

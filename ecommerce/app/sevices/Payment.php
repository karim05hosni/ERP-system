<?php
require '../../vendor/autoload.php';  // Include Composer's autoloader

use GuzzleHttp\Client;
class payment {
    
    protected $client;
    protected $response;

    public function checkout($data) {
        $this->client = new Client();
        $this->response = json_decode( $this->client->post('http://127.0.0.1:8000/api/payments/create', [
            'json' => [
                'product_name' => $data['name'],
                'price' =>$data['price'] ,  // Amount in dollars
                'quantity'=>$data['quantity'],
                'success_url' => 'http://localhost/Product-mangment-system/ecommerce/app/post/Purchase.php?qty='.$data['quantity'],
                // 'cancel_url' => $cancelUrl,
            ]
        ])->getBody());
        header('location:'.$this->response->data->checkout_url);
        // header($this->response->success_url);
    }
}


// $response = $client->post();
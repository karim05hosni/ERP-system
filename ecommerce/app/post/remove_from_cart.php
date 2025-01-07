<?php
// // Include the cart class and initialize it
require_once __DIR__.'\\..\\models\\Cart.php';
$cart = new Cart();

// // Start session to get user_id
// session_start();
// $user_id = $_SESSION['user_id']; // Replace with your session logic

// // Handle AJAX requests
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get the raw POST data
//     $data = json_decode(file_get_contents('php://input'), true);

//     // Initialize response
//     $response = ['success' => false];

//     // Handle Remove Item
//     if ($data['action'] === 'remove') {
//         $product_id = $data['product_id'];
//         if ($cart->removeItem($product_id)) {
//             $response['success'] = true;
//         }
//     }

//     // Handle Update Quantity
//     if ($data['action'] === 'update') {
//         $product_id = $data['product_id'];
//         $quantity = $data['quantity'];
//         if ($cart->updateQuantity($product_id, $quantity)) {
//             $response['success'] = true;
//         }
//     }

//     // Return JSON response
//     header('Content-Type: application/json');
//     echo json_encode($response);
//     exit();
// }

session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Debugging: Log the request method
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');

    // Debugging: Log the raw POST data
    error_log("Raw POST data: " . $rawData);

    // Decode the JSON data
    $data = json_decode($rawData, true);

    // Debugging: Log the decoded data
    error_log("Decoded data: " . print_r($data, true));

    if (isset($data['action'])) {
        if ($data['action'] === 'remove' && isset($data['product_id'])) {
            // Logic to remove the product from the cart
            $productId = $data['product_id'];
            // Example: $cart->removeItem($productId);
            try {
                //code...
                $cart->removeItem($productId);
            } catch (Exception $th) {
                $response['message'] = $th->getMessage();
            }
            $response['success'] = true;
            $response['message'] = 'Product removed successfully.';
        } elseif ($data['action'] === 'update' && isset($data['quantities'])) {
            // Logic to update the cart with new quantities
            foreach ($data['quantities'] as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];
                try {
                    //code...
                    $cart->updateQuantity($productId, $quantity);
                } catch (Exception $th) {
                    $response['message'] = $th->getMessage();
                }
                // Example: $cart->updateQuantity($productId, $quantity);
            }
            $response['success'] = true;
            $response['message'] = 'Cart updated successfully.';
        } else {
            $response['message'] = 'Invalid action or missing parameters.';
        }
    } else {
        $response['message'] = 'No action specified.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Debugging: Log the response
error_log("Response: " . print_r($response, true));

echo json_encode($response);

?>
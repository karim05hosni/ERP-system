<?php
// Include necessary files
require_once __DIR__.'\\..\\database\\config.php';
require_once __DIR__.'\\..\\models\\cart.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => 'An error occurred.',
    'cart_id' => null
];

$input = json_decode(file_get_contents('php://input'), true);
// print_r($input['user_id']);die;
try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get JSON input from the request body

    // Validate input
    if (empty($input['user_id']) || empty($input['product_id']) || empty($input['quantity'])) {
        throw new Exception('Missing required fields: user_id, product_id, or quantity.');
    }

    $user_id = intval($input['user_id']);
    $product_id = intval($input['product_id']);
    $quantity = intval($input['quantity']);

    if ($user_id <= 0 || $product_id <= 0 || $quantity <= 0) {
        throw new Exception('Invalid input values.');
    }

    $cart = new cart();
    $exist_cart = $cart->retrieveCardByUserId($user_id);
    // If the user does not have a cart, create one
    // print_r($exist_cart);die;
    if (empty($exist_cart)) {
        // Set cart properties
        $cart->setUserId($user_id);
        $cart->setProductId($product_id);
        $cart->setQuantity($quantity);
        // Add product to cart
        $cart_id = $cart->creat();
    } else {
        $exist_cart = $exist_cart->fetch_array(MYSQLI_ASSOC);
        // Use the existing cart ID
        $cart_id = $exist_cart['id'];
    }

    // Insert the product into the cart_product table
    $inserted = $cart->insertProducts($cart_id, $product_id, $quantity);

    if ($inserted) {
        $response['success'] = true;
        $response['message'] = 'Product added to cart successfully.';
        $response['cart_id'] = $cart_id;
    } else {
        throw new Exception('Failed to add product to cart.');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <label for="product_name">Product Name: </label>
        <input type="text" name="product_name" required>
        <label for="quantity">Qty: </label>
        <input type="text" name="quantity" required>
        <label for="amount">price: </label>
        <input type="number" name="price" required>
        
        <button type="submit">Pay with Stripe</button>
    </form>
</body>
</html>

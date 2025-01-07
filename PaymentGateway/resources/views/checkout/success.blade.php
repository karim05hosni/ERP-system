<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Payment Successful!</h4>
            <p>Thank you for your purchase. Your payment has been successfully processed.</p>
            <hr>
            <p class="mb-0">Transaction ID: {{ $session->payment_intent }}</p>
            <p class="mb-0">Amount: {{ $session->amount_total / 100 }} {{ $session->currency }}</p>
        </div>
        <a href="/" class="btn btn-primary">Return to Home</a>
    </div>
</body>
</html>
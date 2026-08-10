<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm border-0 p-4 text-center">
            <h1 class="text-success mb-3">✅ Order Placed Successfully</h1>
            <p class="text-muted">Your order has been received and will be processed shortly.</p>
            <a href="/products" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    </div>
<x-ai-hub-sidebar />
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <img src="{{ asset('products/' . $product->image) }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $product->name }}">
        </div>
        <div class="col-lg-6">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category }}</p>
            <p class="fs-4 fw-semibold">₹{{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>
            <div class="d-flex gap-2 mt-4">
                <a href="/products" class="btn btn-outline-dark">Back to products</a>
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Add to wishlist</button>
                </form>
            </div>
        </div>
    </div>
</div>
<x-ai-hub-sidebar />
</body>
</html>

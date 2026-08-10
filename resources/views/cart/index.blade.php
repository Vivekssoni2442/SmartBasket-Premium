<!DOCTYPE html>
<html>
<head>
<title>My Cart | Smart Basket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">🛒 My Cart</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('profile') }}" class="btn btn-outline-dark">Profile</a>
            <a href="/products" class="btn btn-outline-dark">Continue Shopping</a>
        </div>
    </div>

    @if($cartItems->count())
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                    <div class="card mb-3 p-3 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ asset('products/' . $item->product?->image) }}" width="100" class="rounded">
                            </div>
                            <div class="col-md-6">
                                <h4 class="h5 mb-2">{{ $item->product?->name }}</h4>
                                <p class="mb-1">₹ {{ number_format((float) $item->product?->price, 2) }}</p>
                                <p class="mb-0 text-muted">Stock: {{ $item->product?->stock ?? 0 }}</p>
                            </div>
                            <div class="col-md-4">
                                <form method="POST" action="{{ route('cart.update', $item->product_id) }}" class="d-flex gap-2 mb-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="max-width:90px;">
                                    <button class="btn btn-outline-primary">Update</button>
                                </form>
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-3">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>₹ {{ number_format((float) $subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>₹ {{ number_format((float) $subtotal, 2) }}</span>
                    </div>
                    <a href="/checkout" class="btn btn-primary w-100 mt-3">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-light border">Your cart is empty.</div>
    @endif
</div>
<x-ai-hub-sidebar />
</body>
</html>

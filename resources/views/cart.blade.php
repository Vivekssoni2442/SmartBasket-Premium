<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KDP SMART MART | Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); min-height: 100vh; }
        .card { border: 0; border-radius: 1rem; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); }
    </style>
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-0">🛒 Your Cart</h1>
            <a href="/products" class="btn btn-outline-dark">Continue Shopping</a>
        </div>

        @php $cart = session('cart', []); @endphp

        @if(count($cart) == 0)
            <div class="alert alert-light border text-center py-5">
                <h3 class="fw-semibold">Cart is Empty 😔</h3>
                <p class="text-muted">Add some products from the catalog to begin checkout.</p>
            </div>
        @else
            @foreach($cart as $id => $item)
                @php $product = \App\Models\Product::find($id); @endphp
                @if($product)
                    <div class="card p-4 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-semibold mb-1">{{ $product->name }}</h4>
                                <p class="mb-1 text-muted">Quantity: {{ $item['quantity'] }}</p>
                                <p class="mb-0 fw-bold text-success">₹{{ number_format($product->price * $item['quantity'], 2) }}</p>
                            </div>
                            <div class="text-muted">₹{{ number_format($product->price, 2) }} each</div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="text-end mt-4">
                <a href="/checkout" class="btn btn-success btn-lg">Proceed To Checkout 🚀</a>
            </div>
        @endif
    </div>
</body>
</html>

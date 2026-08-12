<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">
</head>
<body>
    <main class="order-page">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <p class="text-primary fw-semibold mb-1">SMART BASKET</p>
                    <h1 class="h2 fw-bold mb-1">My Orders</h1>
                    <p class="text-muted mb-0">Follow every order from checkout to delivery.</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Continue Shopping</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @forelse($orders as $order)
                <article class="order-card">
                    <div class="d-flex justify-content-between flex-wrap gap-3 mb-3">
                        <div>
                            <strong>Order #{{ $order->id }}</strong>
                            <span class="order-meta ms-2">{{ $order->created_at?->format('d M Y, h:i A') }}</span>
                        </div>
                        <span class="status-pill">{{ $order->deliveryDetail?->status ?? $order->order_status ?? 'Order Placed' }}</span>
                    </div>

                    @foreach($order->items ?? [] as $item)
                        @php($product = $products[$item['product_id'] ?? null] ?? null)
                        <div class="order-product mb-3">
                            <img src="{{ $product && $product->image ? asset('products/'.$product->image) : 'https://placehold.co/160x160/1E293B/FFFFFF?text=Product' }}" alt="{{ $item['name'] ?? 'Product' }}">
                            <div class="flex-grow-1">
                                <h2 class="h6 mb-1">{{ $item['name'] ?? $product?->name ?? 'Product' }}</h2>
                                <div class="order-meta">Quantity: {{ $item['quantity'] ?? 1 }} &middot; &#8377;{{ number_format((float) ($item['price'] ?? 0), 2) }}</div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between align-items-center border-top pt-3" style="border-color:#334155!important">
                        <strong>Total: &#8377;{{ number_format((float) ($order->amount ?? $order->total), 2) }}</strong>
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-sm">Track Order</a>

                            @if($order->isCancellable())
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Cancel this order? This cannot be undone.');">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm">Cancel Order</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="order-card text-center py-5">
                    <i class="fa-solid fa-box-open fs-2 text-primary d-block mb-3"></i>
                    <h2 class="h5">No orders yet</h2>
                    <p class="text-muted">Your placed orders will appear here.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>

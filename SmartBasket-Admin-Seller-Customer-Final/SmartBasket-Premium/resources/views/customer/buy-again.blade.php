<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <title>Buy Again</title>
</head>
<body class="bg-light">
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Buy Again</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">My Orders</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse ($items as $id => $item)
            @php($product = $products[$id] ?? null)

            @if ($product)
                <div class="col-md-6">
                    <article class="card h-100 p-3">
                        <div class="d-flex gap-3">
                            <img src="{{ asset('products/'.$product->image) }}" alt="{{ $product->name }}" width="90" height="90" style="object-fit:cover">
                            <div>
                                <h2 class="h5">{{ $product->name }}</h2>
                                <div>₹{{ number_format($product->sellingPrice(), 2) }} · {{ $product->seller?->shop_name ?? 'Seller unavailable' }}</div>
                                <small>Purchased {{ \Illuminate\Support\Carbon::parse($item['purchased_at'])->format('d M Y') }} · Qty {{ $item['quantity'] ?? 1 }}</small>
                                <div class="mt-2">
                                    @if ((int) $product->stock > 0)
                                        <form class="d-inline" method="POST" action="{{ route('cart.add', $product) }}">
                                            @csrf
                                            <button class="btn btn-primary btn-sm">Add to Cart</button>
                                        </form>
                                        <a class="btn btn-success btn-sm" href="{{ url('/buy-now/'.$product->id) }}">Buy Again</a>
                                    @else
                                        <span class="text-danger">Currently unavailable</span>
                                    @endif
                                    <a class="btn btn-outline-dark btn-sm" href="{{ route('product.show', $product) }}">View Product</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endif
        @empty
            <div class="alert alert-info">No previous purchases yet.</div>
        @endforelse
    </div>
</main>
</body>
</html>

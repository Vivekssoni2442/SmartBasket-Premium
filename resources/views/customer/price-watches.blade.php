<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <title>Price Watches</title>
</head>
<body class="bg-light">
<main class="container py-4">
    <h1 class="h3 mb-4">Tracked Products</h1>
    <div class="row g-3">
        @forelse ($watches as $watch)
            @php($product = $watch->product)

            @if ($product)
                <div class="col-md-6">
                    <article class="card p-3">
                        <h2 class="h5">{{ $product->name }}</h2>
                        <p>Tracked: ₹{{ number_format($watch->previous_price ?? $watch->tracked_price, 2) }} · Current: ₹{{ number_format($product->sellingPrice(), 2) }}</p>
                        @if ($watch->previous_price)
                            <p class="text-success">Price dropped by ₹{{ number_format((float) $watch->previous_price - $product->sellingPrice(), 2) }}</p>
                        @endif
                        <div>
                            <a href="{{ route('product.show', $product) }}" class="btn btn-outline-dark btn-sm">View</a>
                            <form class="d-inline" method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button class="btn btn-primary btn-sm" @disabled((int) $product->stock < 1)>Cart</button>
                            </form>
                            <form class="d-inline" method="POST" action="{{ route('price-watches.destroy', $watch) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">Stop Tracking</button>
                            </form>
                        </div>
                    </article>
                </div>
            @endif
        @empty
            <div class="alert alert-info">You are not tracking any products.</div>
        @endforelse
    </div>
</main>
</body>
</html>

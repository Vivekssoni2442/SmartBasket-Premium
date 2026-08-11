<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products | Smart Basket Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body class="bg-dark text-white">
<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><p class="text-primary fw-semibold mb-1">SELLER PANEL</p><h1 class="h2 mb-1">My Products</h1><p class="text-muted mb-0">Products in your seller account only.</p></div>
        <div class="d-flex gap-2"><a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary">Dashboard</a><a href="{{ route('seller.product.add') }}" class="btn btn-primary">Add Product</a></div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-sm-6 col-lg-4">
                <article class="card h-100 bg-black text-white border-secondary">
                    @if($product->image)<img src="{{ asset('products/'.$product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height:220px;object-fit:cover;">@endif
                    <div class="card-body d-flex flex-column"><h2 class="h5">{{ $product->name }}</h2><p class="text-muted mb-2">{{ $product->category }}</p><p class="mb-1">₹{{ number_format((float) $product->price, 2) }}</p><p class="text-muted small">Stock: {{ $product->stock }}</p><div class="mt-auto d-flex gap-2"><a href="{{ route('seller.product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a><form action="{{ route('seller.product.delete', $product->id) }}" method="POST">@csrf<button class="btn btn-danger btn-sm">Delete</button></form></div></div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="card bg-black text-center text-muted border-secondary p-5">No products have been added to your seller account yet.</div></div>
        @endforelse
    </div>
</main>
</body>
</html>

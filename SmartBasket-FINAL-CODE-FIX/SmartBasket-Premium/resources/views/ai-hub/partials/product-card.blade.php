<article class="ai-product-card">
    <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
    <div class="ai-product-card-body">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->category ?: 'Smart Basket product' }} · <span class="text-warning">★</span> {{ number_format((float) ($product->rating ?? 0), 1) }}</p>
        <div class="d-flex justify-content-between align-items-center gap-2"><span class="ai-price">₹{{ number_format((float) $product->price, 2) }}</span><a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a></div>
    </div>
</article>

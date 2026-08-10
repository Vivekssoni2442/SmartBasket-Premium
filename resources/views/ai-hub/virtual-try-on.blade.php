<!DOCTYPE html>
<html lang="en">
<head>
    @include('ai-hub.partials.head', ['title' => 'Virtual Try-On'])
    <link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
</head>
<body>
<div class="ai-hub-layout">
    @include('ai-hub.partials.navigation')
    <main class="ai-hub-main">
        <header class="ai-hub-heading ai-ca-heading">
            <div>
                <span class="ai-hub-eyebrow">Preview outfits on yourself</span>
                <h1>Virtual Try-On 👗</h1>
                <p>Your uploaded photo is forwarded here. Explore Smart Basket outfits that suit your analysis.</p>
            </div>
            <a href="{{ route('ai-camera-assistant') }}" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left me-1"></i> Back to Camera Assistant</a>
        </header>

        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}</div>
        @endif

        <div class="ai-ca-privacy">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
                <strong>Your privacy matters.</strong>
                <span>Your image is only used in this session for preview and is never stored.</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="ai-ca-card ai-ca-camera-card">
                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon"><i class="fa-solid fa-user-large"></i></span>
                        <div>
                            <h2>Your Photo</h2>
                            <small>Uploaded image used for virtual try-on</small>
                        </div>
                    </div>
                    <div class="ai-ca-viewport ai-ca-vto-viewport">
                        <img id="vtoImage" class="ai-ca-vto-img" alt="Your photo for try-on" src="{{ asset('products/1785564606.jpg') }}">
                    </div>
                    <div class="ai-ca-capture-tools">
                        <input type="file" id="vtoFile" accept="image/*" class="d-none">
                        <button type="button" class="btn btn-outline-secondary" id="vtoUploadBtn"><i class="fa-solid fa-upload me-1"></i> Upload a photo</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ai-ca-card ai-ca-result-card">
                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon ai-ca-icon-ai"><i class="fa-solid fa-shirt"></i></span>
                        <div>
                            <h2>Outfits To Try On</h2>
                            <small>Click a product to preview it on your photo</small>
                        </div>
                    </div>
                    <div class="ai-ca-products">
                        @forelse($recommendations as $product)
                            <div class="ai-ca-product" data-vto-product="{{ $product->image }}">
                                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
                                <div class="ai-ca-product-body">
                                    <h4>{{ $product->name }}</h4>
                                    <p>{{ $product->category ?: 'Smart Basket product' }} · <span class="text-warning">★</span> {{ number_format((float) ($product->rating ?? 0), 1) }}</p>
                                </div>
                                <div class="ai-ca-product-actions">
                                    <span class="ai-ca-price">₹{{ number_format((float) $product->price, 2) }}</span>
                                    <div class="ai-ca-product-btn-group">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-cart-plus me-1"></i> Add to Cart</button>
                                        </form>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-1"></i> View Product</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="ai-ca-empty">
                                <i class="fa-solid fa-sparkles"></i>
                                <p>No products available for virtual try-on yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<x-ai-hub-sidebar />
<script>
document.addEventListener('DOMContentLoaded', function () {
    const vtoImage = document.getElementById('vtoImage');
    const vtoFile = document.getElementById('vtoFile');
    const vtoUploadBtn = document.getElementById('vtoUploadBtn');

    // Use the image passed from the camera assistant if available.
    if (vtoImage) {
        try {
            const stored = sessionStorage.getItem('vto_image');
            if (stored) {
                vtoImage.src = stored;
            }
        } catch (e) { /* storage unavailable */ }
    }

    if (vtoUploadBtn && vtoFile) {
        vtoUploadBtn.addEventListener('click', function () { vtoFile.click(); });
        vtoFile.addEventListener('change', function (e) {
            const f = e.target.files && e.target.files[0];
            if (f && vtoImage) {
                vtoImage.src = URL.createObjectURL(f);
            }
        });
    }

    // Click a product to highlight it (simple try-on preview).
    document.querySelectorAll('[data-vto-product]').forEach(function (card) {
        card.addEventListener('click', function () {
            document.querySelectorAll('[data-vto-product]').forEach(function (c) { c.classList.remove('is-selected'); });
            card.classList.add('is-selected');
        });
    });
});
</script>
</body>
</html>

<link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
<div class="ai-panel-fragment">
    <h2>👗 Virtual Try-On</h2>
    <p>Preview outfits from Smart Basket on your photo.</p>

    <div class="ai-ca-viewport ai-ca-viewport-sm">
        <img id="vtoImage" class="ai-ca-vto-img" alt="Your photo" src="{{ asset('products/1785564606.jpg') }}">
    </div>

    <div class="ai-ca-capture-tools ai-ca-capture-tools-sm mt-2">
        <input type="file" id="vtoFile" accept="image/*" class="d-none">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="vtoUploadBtn"><i class="fa-solid fa-upload me-1"></i> Upload</button>
    </div>

    <h3 class="ai-ca-section-title"><i class="fa-solid fa-shirt me-1"></i> Outfits</h3>
    <div class="ai-drawer-products">
        @forelse($recommendations as $product)
            <div class="ai-ca-product ai-ca-product-sm" data-vto-product="{{ $product->image }}">
                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="ai-ca-product-body">
                    <h4>{{ $product->name }}</h4>
                    <b>₹{{ number_format((float) $product->price, 2) }}</b>
                    <div class="ai-ca-product-btn-group">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-cart-plus me-1"></i></button>
                        </form>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-1"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div class="ai-ca-empty"><i class="fa-solid fa-sparkles"></i><p>No products available yet.</p></div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const vtoImage = document.getElementById('vtoImage');
    const vtoFile = document.getElementById('vtoFile');
    const vtoUploadBtn = document.getElementById('vtoUploadBtn');
    if (vtoUploadBtn && vtoFile && vtoImage) {
        vtoUploadBtn.addEventListener('click', function () { vtoFile.click(); });
        vtoFile.addEventListener('change', function (e) {
            const f = e.target.files && e.target.files[0];
            if (f) vtoImage.src = URL.createObjectURL(f);
        });
    }
});
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <style>.product-main-image{width:100%;height:min(62vw,520px);object-fit:contain;background:var(--sb-card);transition:opacity .2s ease}.quantity-control{width:150px}.related-image{height:155px;object-fit:cover}</style>
</head>
<body class="bg-light" data-sb-theme="{{ auth()->user()?->dark_mode ?? 'dark' }}">
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            @php($gallery = collect([['url' => asset('products/' . $product->image), 'label' => 'Main', 'image_id' => null]])->merge($product->images->map(fn($image) => ['url' => asset('storage/'.$image->path), 'label' => 'Product view', 'image_id' => $image->id])))
            <img id="mainProductImage" src="{{ $gallery->first()['url'] }}" class="product-main-image img-fluid rounded-4 shadow-sm" alt="{{ $product->name }}" onerror="this.style.opacity='.25';">
            @if($gallery->count() > 1)<div class="d-flex gap-2 flex-wrap mt-3">@foreach($gallery as $image)<button type="button" class="btn p-0 border product-thumb" data-image="{{ $image['url'] }}" data-product-image-id="{{ $image['image_id'] }}"><img src="{{ $image['url'] }}" alt="{{ $image['label'] }}" width="74" height="74" style="object-fit:cover"></button>@endforeach</div>@endif
        </div>
        <div class="col-lg-6">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category }}</p>
            <p class="fs-4 fw-semibold">₹{{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>
            @php($hasDiscount = $product->discount_price !== null && (float) $product->discount_price < (float) $product->price)
            @if($hasDiscount)<p class="mb-2"><span class="fw-bold">Now ₹{{ number_format((float) $product->discount_price, 2) }}</span> <s class="text-muted">₹{{ number_format((float) $product->price, 2) }}</s> <span class="text-success">{{ round((1 - ((float) $product->discount_price / (float) $product->price)) * 100) }}% off</span></p>@endif
            <div class="row small g-2">@if($product->brand)<div class="col-6"><strong>Brand:</strong> {{ $product->brand }}</div>@endif @if($product->rating !== null)<div class="col-6"><strong>Rating:</strong> {{ number_format((float) $product->rating, 1) }}</div>@endif @if($product->stock !== null)<div class="col-6"><strong>Available stock:</strong> {{ $product->stock }}</div>@endif @if($product->size)<div class="col-6"><strong>Size:</strong> {{ $product->size }}</div>@endif @if($product->color)<div class="col-6"><strong>Color:</strong> {{ $product->color }}</div>@endif @if($product->status)<div class="col-6"><strong>Status:</strong> {{ ucfirst($product->status) }}</div>@endif</div>
            @if($product->seller)<div class="border rounded p-3 mt-3"><h2 class="h6 mb-2">Sold by</h2><div class="fw-semibold">{{ $product->seller->shop_name ?: $product->seller->seller_name }}</div><div class="text-muted small">{{ $product->seller->seller_name }}@if($product->seller->city) · {{ $product->seller->city }}@endif</div></div>@endif
            <div class="d-flex gap-2 mt-4">
                <a href="/products" class="btn btn-outline-dark">Back to products</a>
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Add to wishlist</button>
                </form>
            </div>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3 d-flex gap-2 align-items-end flex-wrap">
                @csrf
                <div><label for="quantity" class="form-label mb-1">Quantity</label><div class="input-group quantity-control"><button class="btn btn-outline-secondary" type="button" id="quantityMinus">−</button><input id="quantity" class="form-control text-center" name="quantity" value="1" min="1" @if($product->stock !== null) max="{{ max(1, (int) $product->stock) }}" @endif type="number"><button class="btn btn-outline-secondary" type="button" id="quantityPlus">+</button></div></div>
                <button class="btn btn-primary" {{ $product->stock !== null && (int) $product->stock < 1 ? 'disabled' : '' }}>Add to Cart</button>
                <a class="btn btn-success" href="{{ url('/buy-now/' . $product->id) }}">Buy Now</a>
            </form>
            <section class="card border-0 shadow-sm mt-4" id="virtualTryOn">
                <div class="card-body">
                    <h2 class="h4 mb-1">✨ AI Virtual Try-On</h2>
                    <p class="small text-muted mb-3">Upload a photo or use your camera to create an AI-generated visual preview. It is not a guarantee of size or fit.</p>
                    <div id="tryOnMessage" class="alert d-none" role="alert"></div>
                    <form id="tryOnForm" action="{{ route('products.virtual-try-on.generate', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="tryOnProductImageId" name="product_image_id">
                        <input class="form-control" id="tryOnPhoto" name="photo" type="file" accept="image/jpeg,image/png,image/webp" capture="user" required>
                        <div class="mt-2 d-flex gap-2">
                            <button class="btn btn-dark" type="submit" id="tryOnSubmit">Try Product On Me</button>
                            <button class="btn btn-outline-secondary d-none" type="button" id="tryOnRemove">Remove Photo</button>
                        </div>
                    </form>
                    <img id="tryOnPreview" class="img-fluid rounded mt-3 d-none" alt="Customer photo preview" style="max-height: 320px">
                    <div class="mt-3 d-none" id="tryOnResultWrap">
                        <h3 class="h5">AI Virtual Try-On Result</h3>
                        <img id="tryOnResult" class="img-fluid rounded" alt="AI-generated virtual try-on preview" style="max-height: 520px">
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-outline-dark" type="button" id="tryOnAgain">Try Again</button>
                            <label class="btn btn-outline-secondary mb-0" for="tryOnPhoto">Change Photo</label>
                            <button class="btn btn-outline-secondary" type="button" id="tryOnProductImage">Change Product Image</button>
                            <form action="{{ route('cart.add', $product) }}" method="POST">@csrf<button class="btn btn-primary">Add to Cart</button></form>
                            <a class="btn btn-success" href="{{ url('/buy-now/' . $product->id) }}">Buy Now</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@if($relatedProducts->isNotEmpty())<section class="container pb-5"><h2 class="h3 mb-3">Related products</h2><div class="row g-3">@foreach($relatedProducts as $related)<div class="col-6 col-md-3"><a href="{{ route('product.show', $related) }}" class="card h-100 text-decoration-none text-reset shadow-sm"><img class="card-img-top related-image" src="{{ asset('products/'.$related->image) }}" alt="{{ $related->name }}" onerror="this.style.opacity='.25';"><div class="card-body"><h3 class="h6">{{ $related->name }}</h3><div class="fw-semibold">₹{{ number_format((float) ($related->discount_price && $related->discount_price < $related->price ? $related->discount_price : $related->price), 2) }}</div></div></a></div>@endforeach</div></section>@endif
<x-ai-hub-sidebar />
<script>
(() => {
    const form = document.getElementById('tryOnForm'), input = document.getElementById('tryOnPhoto'), preview = document.getElementById('tryOnPreview');
    const message = document.getElementById('tryOnMessage'), submit = document.getElementById('tryOnSubmit'), remove = document.getElementById('tryOnRemove');
    const resultWrap = document.getElementById('tryOnResultWrap'), result = document.getElementById('tryOnResult');
    const showMessage = (text, ok = false) => { message.textContent = text; message.className = `alert alert-${ok ? 'success' : 'warning'}`; };
    input.addEventListener('change', () => { const file = input.files[0]; if (!file) return; preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); remove.classList.remove('d-none'); });
    remove.addEventListener('click', () => { input.value = ''; preview.removeAttribute('src'); preview.classList.add('d-none'); remove.classList.add('d-none'); });
    document.getElementById('tryOnAgain').addEventListener('click', () => { resultWrap.classList.add('d-none'); form.scrollIntoView({behavior: 'smooth'}); });
    document.getElementById('tryOnProductImage').addEventListener('click', () => { document.querySelector('.product-thumb')?.focus(); showMessage('Select an image thumbnail above to use that real product view for try-on.', true); });
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); submit.disabled = true; showMessage('Creating your AI virtual try-on preview…', true);
        try {
            const response = await fetch(form.action, {method: 'POST', headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': form.querySelector('[name=_token]').value}, body: new FormData(form)});
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'AI Virtual Try-On is temporarily unavailable. Please try again later.');
            result.src = data.result_url; resultWrap.classList.remove('d-none'); showMessage(data.message, true);
        } catch (error) { showMessage(error.message); } finally { submit.disabled = false; }
    });
})();
</script>
<script>document.querySelectorAll('.product-thumb').forEach(button=>button.addEventListener('click',()=>{document.getElementById('mainProductImage').src=button.dataset.image;document.getElementById('tryOnProductImageId').value=button.dataset.productImageId||'';}));</script>
<script>(()=>{const input=document.getElementById('quantity');if(!input)return;const limit=Number(input.max)||Infinity;document.getElementById('quantityMinus').onclick=()=>input.value=Math.max(1,Number(input.value||1)-1);document.getElementById('quantityPlus').onclick=()=>input.value=Math.min(limit,Number(input.value||1)+1);input.onchange=()=>input.value=Math.max(1,Math.min(limit,Number(input.value||1)));})();</script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART BASKET | Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root{
            --wish-bg:#f4f7fb;--wish-bg2:#ffffff;--wish-card:rgba(255,255,255,.90);--wish-surface:rgba(248,250,252,.86);
            --wish-text:#0f172a;--wish-heading:#020617;--wish-muted:#64748b;--wish-border:rgba(15,23,42,.09);
            --wish-blue:#2563eb;--wish-purple:#7c3aed;--wish-green:#16a34a;--wish-red:#dc2626;
            --wish-shadow:0 24px 70px rgba(15,23,42,.11);
        }
        html[data-sb-theme="dark"]{
            --wish-bg:#020617;--wish-bg2:#0b1220;--wish-card:rgba(15,23,42,.90);--wish-surface:rgba(30,41,59,.72);
            --wish-text:#e2e8f0;--wish-heading:#f8fafc;--wish-muted:#94a3b8;--wish-border:rgba(148,163,184,.15);
            --wish-blue:#60a5fa;--wish-purple:#a78bfa;--wish-green:#22c55e;--wish-red:#f87171;
            --wish-shadow:0 30px 90px rgba(0,0,0,.48);
        }
        *{box-sizing:border-box} body{margin:0;min-height:100vh;color:var(--wish-text);font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:
        radial-gradient(circle at 8% 8%,rgba(37,99,235,.16),transparent 28%),radial-gradient(circle at 92% 10%,rgba(124,58,237,.14),transparent 28%),radial-gradient(circle at 50% 100%,rgba(14,165,233,.08),transparent 35%),var(--wish-bg);transition:background .3s,color .3s}
        html[data-sb-theme="dark"] body{background:radial-gradient(circle at 8% 8%,rgba(59,130,246,.18),transparent 28%),radial-gradient(circle at 92% 10%,rgba(139,92,246,.16),transparent 28%),#020617}
        .wishlist-page{width:100%;padding:34px 18px 80px}.wishlist-shell{width:100%;max-width:none;margin:0 auto}
        .hero-copy{position:relative;z-index:1}.eyebrow{display:inline-flex;align-items:center;gap:7px;color:var(--wish-blue);font-size:10px;font-weight:950;letter-spacing:1.8px}.wishlist-title{margin:7px 0 6px;color:var(--wish-heading);font-size:38px;font-weight:950;letter-spacing:-1px}.wishlist-subtitle{margin:0;color:var(--wish-muted);font-size:13px;max-width:680px}
        .hero-stat{position:relative;z-index:1;min-width:150px;padding:16px 18px;border:1px solid var(--wish-border);border-radius:18px;background:var(--wish-card);text-align:center;box-shadow:0 12px 30px rgba(15,23,42,.07)}.hero-stat strong{display:block;color:var(--wish-heading);font-size:25px;font-weight:950}.hero-stat span{color:var(--wish-muted);font-size:10px;font-weight:800;letter-spacing:.5px}
        .flash{margin-bottom:20px;padding:13px 16px;border-radius:14px;font-size:12px;font-weight:800;border:1px solid}.flash-success{color:var(--wish-green);background:rgba(34,197,94,.09);border-color:rgba(34,197,94,.20)}.flash-error{color:var(--wish-red);background:rgba(239,68,68,.08);border-color:rgba(239,68,68,.20)}
        .wishlist-panel{padding:24px;border:1px solid var(--wish-border);border-radius:28px;background:var(--wish-card);box-shadow:var(--wish-shadow);backdrop-filter:blur(22px)}
        .panel-head{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:22px}.panel-label{color:var(--wish-heading);font-size:16px;font-weight:900}.panel-muted{color:var(--wish-muted);font-size:11px;margin-top:4px}
        .panel-cart{display:inline-flex;align-items:center;gap:8px;padding:10px 15px;border-radius:12px;background:linear-gradient(135deg,var(--wish-blue),var(--wish-purple));color:#fff;text-decoration:none;font-size:11px;font-weight:900;box-shadow:0 10px 24px rgba(37,99,235,.22);transition:.22s}.panel-cart:hover{color:#fff;transform:translateY(-2px)}
        .wish-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(255px,1fr));gap:18px}.wish-card{position:relative;overflow:hidden;border:1px solid var(--wish-border);border-radius:21px;background:var(--wish-surface);box-shadow:0 10px 28px rgba(15,23,42,.06);transition:.25s}.wish-card:hover{transform:translateY(-5px);border-color:rgba(37,99,235,.30);box-shadow:0 20px 42px rgba(37,99,235,.12)}
        .wish-image-link{display:block;height:230px;overflow:hidden;background:var(--wish-bg2)}.wish-image-link img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s}.wish-card:hover .wish-image-link img{transform:scale(1.045)}.wish-placeholder{height:100%;display:grid;place-items:center;color:var(--wish-muted);font-size:42px}
        .wish-body{padding:17px}.wish-name{margin:0 0 6px;font-size:16px;font-weight:900;color:var(--wish-heading)}.wish-name a{color:inherit;text-decoration:none}.wish-meta{margin:0 0 11px;color:var(--wish-muted);font-size:11px;line-height:1.5}.wish-price{color:var(--wish-blue);font-size:19px;font-weight:950;margin-bottom:14px}.wish-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px}.wish-btn{min-height:40px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:11px;font-size:11px;font-weight:900;text-decoration:none;cursor:pointer;transition:.2s}.buy-btn{border:0;color:#fff;background:linear-gradient(135deg,var(--wish-blue),var(--wish-purple));box-shadow:0 8px 20px rgba(37,99,235,.20)}.buy-btn:hover{color:#fff;transform:translateY(-2px)}.add-btn{border:1px solid rgba(37,99,235,.22);color:var(--wish-blue);background:rgba(37,99,235,.08)}.add-btn:hover{color:#fff;background:var(--wish-blue);transform:translateY(-2px)}
        .remove-row{margin-top:9px}.remove-btn{width:100%;min-height:34px;border:1px solid rgba(220,38,38,.16);border-radius:10px;background:rgba(220,38,38,.06);color:var(--wish-red);font-size:10px;font-weight:850;transition:.2s}.remove-btn:hover{background:var(--wish-red);color:#fff}
        .empty{padding:72px 20px;text-align:center}.empty-icon{width:82px;height:82px;margin:0 auto 17px;display:grid;place-items:center;border-radius:23px;background:linear-gradient(135deg,rgba(37,99,235,.10),rgba(124,58,237,.11));border:1px solid var(--wish-border);color:var(--wish-blue);font-size:34px}.empty h2{margin:0 0 8px;color:var(--wish-heading);font-size:22px;font-weight:950}.empty p{max-width:520px;margin:0 auto 22px;color:var(--wish-muted);font-size:12px}.browse{display:inline-flex;align-items:center;gap:8px;padding:12px 18px;border-radius:12px;background:linear-gradient(135deg,var(--wish-blue),var(--wish-purple));color:#fff;text-decoration:none;font-size:11px;font-weight:900}.browse:hover{color:#fff;transform:translateY(-2px)}
        @media(max-width:700px){.wishlist-page{padding:22px 10px 55px}.wishlist-title{font-size:29px}.hero-stat{width:100%;min-width:0}.wishlist-panel{padding:15px;border-radius:22px}.panel-head{align-items:flex-start;flex-direction:column}.panel-cart{width:100%;justify-content:center}.wish-grid{grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:13px}.wish-image-link{height:205px}}
    </style>
<body data-sb-theme="light" data-customer-theme="{{ auth()->user()->dark_mode ?? 'system' }}">

<x-products-customer-taskbar />

<main class="wishlist-page">
<div class="wishlist-shell">
    <x-customer-page-hero :stat="$wishlistItems->count()" :stat-label="$wishlistItems->count() === 1 ? 'Saved product' : 'Saved products'">
        <div class="hero-copy">
            <span class="eyebrow"><i class="fa-solid fa-heart"></i> SAVED FOR LATER</span>
            <h1 class="wishlist-title sb-customer-page-title">Your Wishlist ❤️</h1>
            <p class="wishlist-subtitle">Save your favourite products and move them to your Smart Basket cart whenever you're ready.</p>
        </div>
    </x-customer-page-hero>

    @if(session('success'))<div class="flash flash-success"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash flash-error"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>@endif

    <section class="wishlist-panel">
        @if($wishlistItems->isNotEmpty())
            <div class="panel-head">
                <div><div class="panel-label">Saved Products</div><div class="panel-muted">Your selected products are ready whenever you are.</div></div>
                @if(Route::has('cart.index'))@endif
            </div>
            <div class="wish-grid">
                @foreach($wishlistItems as $wishlistItem)
                    @php $product = $wishlistItem->product; @endphp
                    @if($product)
                        <article class="wish-card" data-product-url="{{ route('products.show', $product->id) }}">
                            <a href="{{ route('products.show', $product->id) }}" class="wish-image-link" aria-label="View {{ $product->name }}">
                                @if(!empty($product->image))<img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">@else<div class="wish-placeholder"><i class="fa-solid fa-image"></i></div>@endif
                            </a>
                            <div class="wish-body">
                                <h3 class="wish-name"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h3>
                                <p class="wish-meta">{{ $product->category ?: 'Smart Basket product' }} <span class="mx-1">·</span> <span class="text-warning">★</span> {{ number_format((float)($product->rating ?? 0),1) }}</p>
                                <div class="wish-price">₹{{ number_format((float)$product->price,2) }}</div>
                                <div class="wish-actions">
                                    @if(Route::has('checkout'))
                                        <a href="{{ route('checkout') }}?product={{ $product->id }}" class="wish-btn buy-btn"><i class="fa-solid fa-bolt"></i> Buy Now</a>
                                    @else
                                        <a href="{{ route('products.show', $product->id) }}" class="wish-btn buy-btn"><i class="fa-solid fa-bolt"></i> Buy Now</a>
                                    @endif
                                    @if(Route::has('cart.add'))
                                        <form method="POST" action="{{ route('cart.add', $product->id) }}" style="margin:0">@csrf<button type="submit" class="wish-btn add-btn w-100"><i class="fa-solid fa-cart-plus"></i> Add Cart</button></form>
                                    @endif
                                </div>
                                @if(Route::has('wishlist.remove'))<form method="POST" action="{{ route('wishlist.remove', $wishlistItem) }}" class="remove-row">@csrf @method('DELETE')<button type="submit" class="remove-btn" onclick="return confirm('Remove this product from your wishlist?');"><i class="fa-solid fa-trash me-1"></i> Remove from Wishlist</button></form>@endif
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty"><div class="empty-icon"><i class="fa-regular fa-heart"></i></div><h2>Your Wishlist is Empty</h2><p>Save your favourite products from the Smart Basket catalog and they will appear here.</p>@if(Route::has('products.index'))<a href="{{ route('products.index') }}" class="browse"><i class="fa-solid fa-store"></i> Explore Products</a>@endif</div>
        @endif
    </section>
</div>
</main>

<x-ai-hub-sidebar :without-menu="true" />

<script>
(function(){
    const serverTheme=@json(auth()->check() ? (auth()->user()->dark_mode ?? 'system') : 'system');
    function resolve(t){ if(t===true||t===1||t==='1'||t==='true') return 'dark'; if(t===false||t===0||t==='0'||t==='false') return 'light'; if(t==='light'||t==='dark') return t; return window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'; }
    function apply(t){ const theme=resolve(t); document.documentElement.setAttribute('data-sb-theme',theme);document.documentElement.setAttribute('data-theme',theme);document.body.setAttribute('data-sb-theme',theme);document.documentElement.classList.remove('dark','light');document.documentElement.classList.add(theme);document.body.classList.remove('dark','light');document.body.classList.add(theme); }
    apply(localStorage.getItem('sb-theme') || serverTheme);
    const media=window.matchMedia('(prefers-color-scheme: dark)'); if(media.addEventListener) media.addEventListener('change',()=>{if(serverTheme==='system') apply('system');});
    window.addEventListener('storage',e=>{if(['sb-theme','smartbasket-theme','theme','appearance','darkMode'].includes(e.key)) apply(e.key==='sb-theme'?e.newValue:serverTheme);});
    window.addEventListener('sb-theme-changed',e=>{if(e.detail?.theme) apply(e.detail.theme);});
    window.addEventListener('smartbasket-theme-changed',e=>{if(e.detail?.theme) apply(e.detail.theme);});
})();
</script>



</body>
</html>

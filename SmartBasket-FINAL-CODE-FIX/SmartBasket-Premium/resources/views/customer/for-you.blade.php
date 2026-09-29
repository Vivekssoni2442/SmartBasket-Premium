<!doctype html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Smart Basket</title>
    <script>
        (() => {
            const saved = localStorage.getItem('sb-theme') || @json($user->dark_mode ?? 'light');
            const theme = saved === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : saved;
            document.documentElement.dataset.theme = ['dark', 'light'].includes(theme) ? theme : 'light';
            document.documentElement.dataset.sbTheme = document.documentElement.dataset.theme;
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-premium.css') }}">
    <style>
        body { font-family: 'Manrope', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
        .customer-page { min-height: 100vh; }
    </style>
</head>
<body>
    @include('customer.partials.sidebar')

    <main class="customer-page">
        <header class="customer-topbar">
            <div>
                <span class="customer-eyebrow">SMART BASKET / HOME</span>
                <h1>Good to see you, {{ $user->name }}.</h1>
                <p>Your smarter shopping journey starts here.</p>
            </div>
            <a href="{{ route('products.index') }}" class="customer-action"><i class="fa-solid fa-magnifying-glass"></i> Explore Products</a>
        </header>

        <section class="customer-hero">
            <span class="customer-eyebrow">CURATED FOR YOUR EVERYDAY</span>
            <h2>Find something <span>worth bringing home.</span></h2>
            <p>Quality picks, useful intelligence, and better prices in one considered shopping experience.</p>
            <div class="customer-hero-actions">
                <a href="{{ route('products.index') }}"><i class="fa-solid fa-arrow-right"></i> Explore Products</a>
                <a href="{{ route('ai-hub') }}"><i class="fa-solid fa-wand-magic-sparkles"></i> Open AI HUB</a>
            </div>
        </section>

        <section class="customer-grid" aria-label="Shopping overview">
            <div class="customer-stat"><i class="fa-solid fa-cart-shopping"></i><strong>{{ $cartCount }}</strong><span>Items in your cart</span></div>
            <div class="customer-stat"><i class="fa-solid fa-heart"></i><strong>{{ $wishlistCount }}</strong><span>Saved favourites</span></div>
            <div class="customer-stat"><i class="fa-solid fa-box"></i><strong>{{ $orderCount }}</strong><span>Orders placed</span></div>
            <div class="customer-stat"><i class="fa-solid fa-shield-heart"></i><strong>Secure</strong><span>Shopping protected</span></div>
        </section>

        <section class="customer-section">
            <div class="customer-ai-feature">
                <div><span class="customer-eyebrow">SMART AI</span><h3>Meet your shopping assistant</h3><p>Find products, compare prices, discover deals and shop with a little more confidence.</p></div>
                <div class="customer-hero-actions"><a href="{{ route('ai-hub') }}" class="customer-action"><i class="fa-solid fa-sparkles"></i> Open AI HUB</a><a href="{{ route('ai-camera-assistant') }}" class="customer-action" style="color:var(--customer-text)!important;background:transparent;border:1px solid var(--customer-border);"><i class="fa-solid fa-camera"></i> Try AI Camera</a></div>
            </div>
        </section>

        <section class="customer-section">
            <div class="customer-section-head"><div><span class="customer-eyebrow">SELECTED FOR YOU</span><h3>Recommended products</h3></div><a href="{{ route('products.index') }}">View all <i class="fa-solid fa-arrow-right"></i></a></div>
            <div class="customer-product-grid">
                @forelse($products as $product)
                    @php $price = $product->sellingPrice(); @endphp
                    <article class="customer-product-card">
                        <a href="{{ route('products.show', $product) }}" class="media"><img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" onerror="this.style.opacity='.2'"></a>
                        <div class="body"><h4 title="{{ $product->name }}">{{ $product->name }}</h4><div class="meta">{{ $product->category ?: 'Smart Basket pick' }} · <span style="color:var(--customer-gold)">★</span> {{ number_format((float) ($product->rating ?? 0), 1) }}</div><div class="price">₹{{ number_format((float) $price, 2) }}</div><div class="actions"><a href="{{ route('products.show', $product) }}">Details</a><form method="POST" action="{{ route('cart.add', $product) }}">@csrf<button type="submit"><i class="fa-solid fa-cart-plus"></i> Cart</button></form></div></div>
                    </article>
                @empty
                    <div class="customer-empty"><i class="fa-solid fa-bag-shopping"></i>No products are available right now.</div>
                @endforelse
            </div>
        </section>

        <section class="customer-section">
            <div class="customer-section-head"><div><span class="customer-eyebrow">YOUR ACTIVITY</span><h3>Recent orders</h3></div><a href="{{ route('orders.index') }}">View orders <i class="fa-solid fa-arrow-right"></i></a></div>
            <div class="customer-orders">
                @forelse($orders as $order)
                    @php $orderItems = is_array($order->items) ? $order->items : []; $firstItem = $orderItems[0] ?? []; @endphp
                    <div class="customer-order-row"><strong>#{{ $order->id }}</strong><span>{{ $firstItem['name'] ?? 'Smart Basket order' }}</span><span>{{ optional($order->created_at)->format('d M Y') }}</span><strong>₹{{ number_format((float) ($order->total_amount ?? $order->total ?? $order->amount ?? 0), 2) }}</strong><a href="{{ route('orders.show', $order) }}">View</a></div>
                @empty
                    <div class="customer-empty"><i class="fa-solid fa-box-open"></i><strong>No orders yet</strong><div>Your next great purchase is waiting.</div><a href="{{ route('products.index') }}" class="customer-action" style="display:inline-flex;margin-top:15px;">Start Shopping</a></div>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        window.addEventListener('storage', event => {
            if (event.key === 'sb-theme' && ['light', 'dark'].includes(event.newValue)) {
                document.documentElement.dataset.theme = event.newValue;
                document.documentElement.dataset.sbTheme = event.newValue;
            }
        });
    </script>
</body>
</html>

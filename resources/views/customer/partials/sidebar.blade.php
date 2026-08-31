<link rel="stylesheet" href="{{ asset('css/customer-premium.css') }}">

<div class="customer-sidebar-overlay" data-customer-sidebar-close></div>
<aside class="customer-sidebar" data-customer-sidebar aria-label="Customer navigation">
    <div class="customer-sidebar-head">
        <a href="{{ route('dashboard') }}" class="customer-brand">
            <span class="customer-brand-mark"><i class="fa-solid fa-basket-shopping"></i></span>
            <span><strong>SMART</strong> BASKET<small>PREMIUM SHOPPING</small></span>
        </a>
        <button type="button" class="customer-sidebar-close" data-customer-sidebar-close aria-label="Close navigation"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <nav class="customer-nav" aria-label="Customer pages">
        <span class="customer-nav-label">Shop</span>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}"><i class="fa-solid fa-house"></i><span>Home</span></a>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'is-active' : '' }}"><i class="fa-solid fa-store"></i><span>Products</span></a>
        <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'is-active' : '' }}"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>
        <a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist*') ? 'is-active' : '' }}"><i class="fa-solid fa-heart"></i><span>Wishlist</span></a>
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'is-active' : '' }}"><i class="fa-solid fa-box"></i><span>My Orders</span></a>

        <span class="customer-nav-label">Smart tools</span>
        <div class="customer-ai-panel">
            <span class="customer-ai-badge"><i class="fa-solid fa-sparkles"></i> SMART AI</span>
            <strong>Your shopping assistant</strong>
            <small>Discover, compare and choose with confidence.</small>
            <a href="{{ route('ai-hub') }}"><i class="fa-solid fa-wand-magic-sparkles"></i> Open AI HUB <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
        <a href="{{ route('ai-camera-assistant') }}"><i class="fa-solid fa-camera-retro"></i><span>AI Camera</span></a>
        <a href="{{ route('budget-shopping') }}"><i class="fa-solid fa-wallet"></i><span>Budget Shopping</span></a>
        <a href="{{ route('gift-finder') }}"><i class="fa-solid fa-gift"></i><span>Gift Finder</span></a>
        <a href="{{ route('trending-products') }}"><i class="fa-solid fa-fire"></i><span>Trending Products</span></a>
        <a href="{{ route('compare-products') }}"><i class="fa-solid fa-scale-balanced"></i><span>Compare Products</span></a>

        <span class="customer-nav-label">Account</span>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile*') ? 'is-active' : '' }}"><i class="fa-solid fa-user"></i><span>Profile</span></a>
        <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings*') ? 'is-active' : '' }}"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
        <a href="{{ route('security.verify.page') }}"><i class="fa-solid fa-shield-halved"></i><span>Security</span></a>
    </nav>

    <div class="customer-sidebar-foot">
        @auth
            <div class="customer-user-chip"><span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }}</small></div></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button></form>
        @else
            <a href="{{ route('login') }}" class="customer-login-link"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
        @endauth
    </div>
</aside>

<button type="button" class="customer-mobile-toggle" data-customer-sidebar-open aria-label="Open customer navigation"><i class="fa-solid fa-bars"></i></button>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('[data-customer-sidebar]');
    const open = document.querySelector('[data-customer-sidebar-open]');
    const closes = document.querySelectorAll('[data-customer-sidebar-close]');
    if (!sidebar || !open) return;
    const setOpen = (value) => { sidebar.classList.toggle('is-open', value); document.body.classList.toggle('customer-nav-open', value); };
    open.addEventListener('click', () => setOpen(true));
    closes.forEach((item) => item.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') setOpen(false); });
});
</script>

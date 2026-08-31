{{-- Reusable customer navigation: links are rendered only when their existing route is available. --}}
@if (request()->path() !== '/')
<link rel="stylesheet" href="{{ asset('css/smartbasket-theme.css') }}">
<div class="site-menu" data-site-menu>
    <button type="button" class="site-menu__trigger" data-site-menu-trigger aria-label="Open navigation menu" aria-expanded="false" aria-controls="site-menu-panel">
        <span aria-hidden="true">&#8942;</span>
    </button>

    <div class="site-menu__panel" id="site-menu-panel" data-site-menu-panel hidden>
        <div class="site-menu__heading">
            @auth
                <strong>{{ auth()->user()->name ?? 'My account' }}</strong>
                <span>Smart Basket account</span>
            @else
                <strong>Smart Basket</strong>
                <span>Shop smarter, every day</span>
            @endauth
        </div>

        @if(Route::has('products.index'))
            <a href="{{ url('/') }}" class="site-menu__link {{ request()->is('/') ? 'is-active' : '' }}"><span>&#8962;</span>Home</a>
            <a href="{{ route('products.index') }}" class="site-menu__link {{ request()->routeIs('products.*', 'product.show') ? 'is-active' : '' }}"><span>&#9638;</span>Products</a>
        @endif
        @if(Route::has('cart.index'))
            <a href="{{ route('cart.index') }}" class="site-menu__link {{ request()->routeIs('cart.*') ? 'is-active' : '' }}"><span>&#128722;</span>Cart</a>
        @endif
        @auth
            @if(Route::has('wishlist'))
                <a href="{{ route('wishlist') }}" class="site-menu__link {{ request()->routeIs('wishlist*') ? 'is-active' : '' }}"><span>&#9825;</span>Wishlist</a>
            @endif
            @if(Route::has('orders.index'))
                <a href="{{ route('orders.index') }}" class="site-menu__link {{ request()->routeIs('orders.*') ? 'is-active' : '' }}"><span>&#9633;</span>Orders</a>
            @endif
            @if(Route::has('profile'))
                <a href="{{ route('profile') }}" class="site-menu__link {{ request()->routeIs('profile*') ? 'is-active' : '' }}"><span>&#9673;</span>Profile / Account</a>
            @endif
            @if(Route::has('settings'))
                <a href="{{ route('settings') }}" class="site-menu__link {{ request()->routeIs('settings*') ? 'is-active' : '' }}"><span>&#9881;</span>Settings</a>
            @endif
        @endauth

        <div class="site-menu__appearance" aria-label="Theme preference">
            <span>Appearance</span>
            <div class="site-menu__theme-options" role="group" aria-label="Choose theme">
                <button type="button" data-site-theme="light" aria-label="Use light theme">&#9728; Light</button>
                <button type="button" data-site-theme="dark" aria-label="Use dark theme">&#9790; Dark</button>
                <button type="button" data-site-theme="system" aria-label="Follow system theme">&#9635; System</button>
            </div>
        </div>
        <div class="site-menu__divider"></div>

        @guest
            @if(Route::has('login')) <a href="{{ route('login') }}" class="site-menu__link"><span>&#8594;</span>Login</a> @endif
            @if(Route::has('register')) <a href="{{ route('register') }}" class="site-menu__link"><span>+</span>Register</a> @endif
        @else
            @if(Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="site-menu__link site-menu__logout"><span>&#8592;</span>Logout</button></form>
            @endif
        @endguest
    </div>
</div>

<style>
    .site-menu{position:fixed;top:18px;right:18px;z-index:2140;font-family:inherit}.site-menu__trigger{width:46px;height:46px;border:1px solid color-mix(in srgb,currentColor 14%,transparent);border-radius:14px;background:var(--card,var(--sb-card-bg,#fff));color:var(--text,var(--sb-text-primary,#102033));box-shadow:var(--sb-shadow,0 10px 28px rgba(15,23,42,.15));font-size:25px;line-height:1;cursor:pointer}.site-menu__trigger:hover,.site-menu__trigger[aria-expanded="true"]{background:var(--primary,var(--sb-primary-color,#2563eb));border-color:var(--primary,var(--sb-primary-color,#2563eb));color:#fff}.site-menu__panel{position:absolute;top:58px;right:0;width:min(300px,calc(100vw - 28px));padding:8px;border:1px solid var(--border,var(--sb-border-color,#e2e8f0));border-radius:18px;background:var(--card,var(--sb-card-bg,#fff));color:var(--text,var(--sb-text-primary,#102033));box-shadow:0 20px 55px rgba(15,23,42,.20);transform:translateY(-8px);opacity:0;transition:opacity .18s ease,transform .18s ease}.site-menu__panel.is-open{opacity:1;transform:translateY(0)}.site-menu__heading{padding:11px 12px 12px;margin-bottom:5px;border-bottom:1px solid var(--border,var(--sb-border-color,#e2e8f0))}.site-menu__heading strong,.site-menu__heading span{display:block}.site-menu__heading span{margin-top:3px;font-size:12px;color:var(--muted,var(--sb-text-secondary,#718096))}.site-menu__link{width:100%;display:flex;align-items:center;gap:11px;padding:10px 11px;border:0;border-radius:11px;background:transparent;color:inherit;font:inherit;font-size:14px;font-weight:700;text-align:left;text-decoration:none;cursor:pointer}.site-menu__link>span:first-child{width:20px;text-align:center;font-size:17px}.site-menu__link:hover,.site-menu__link.is-active{background:color-mix(in srgb,var(--primary,var(--sb-primary-color,#2563eb)) 11%,transparent);color:var(--primary,var(--sb-primary-color,#2563eb))}.site-menu__appearance{margin:7px 4px;padding:10px;border-radius:12px;background:var(--sb-bg-secondary,#f5f7fb)}.site-menu__appearance>span{display:block;margin-bottom:8px;font-size:12px;font-weight:800;color:var(--sb-text-secondary,#64748b)}.site-menu__theme-options{display:grid;grid-template-columns:repeat(3,1fr);gap:5px}.site-menu__theme-options button{padding:7px 3px;border:1px solid var(--sb-border-color,#dbe4ef);border-radius:8px;background:var(--sb-card-bg,#fff);color:inherit;font:700 11px/1.1 inherit;cursor:pointer}.site-menu__theme-options button:hover,.site-menu__theme-options button.is-active{border-color:var(--sb-primary-color,#2563eb);background:color-mix(in srgb,var(--sb-primary-color,#2563eb) 12%,transparent);color:var(--sb-primary-color,#2563eb)}.site-menu__divider{height:1px;margin:7px 5px;background:var(--border,var(--sb-border-color,#e2e8f0))}.site-menu__logout{color:var(--danger,#dc3545)}.site-menu__logout:hover{color:var(--danger,#dc3545);background:color-mix(in srgb,var(--danger,#dc3545) 10%,transparent)}.site-menu form{margin:0}@media(max-width:576px){.site-menu{top:12px;right:12px}.site-menu__trigger{width:44px;height:44px}.site-menu__panel{top:54px}}
</style>

<script>
    (() => { if (window.__smartBasketSiteMenu) return; window.__smartBasketSiteMenu = true;
        setTimeout(() => document.querySelectorAll('[data-site-menu]').forEach((menu, index) => { if (index) menu.remove(); }), 0);
        const root = document.querySelector('[data-site-menu]'); if (!root) return;
        const trigger = root.querySelector('[data-site-menu-trigger]'), panel = root.querySelector('[data-site-menu-panel]');
        const close = () => { panel.classList.remove('is-open'); trigger.setAttribute('aria-expanded', 'false'); setTimeout(() => { if (!panel.classList.contains('is-open')) panel.hidden = true; }, 180); };
        const open = () => { panel.hidden = false; requestAnimationFrame(() => panel.classList.add('is-open')); trigger.setAttribute('aria-expanded', 'true'); };
        trigger.addEventListener('click', () => trigger.getAttribute('aria-expanded') === 'true' ? close() : open());
        document.addEventListener('click', event => { if (!root.contains(event.target)) close(); });
        document.addEventListener('keydown', event => { if (event.key === 'Escape') close(); });
        root.querySelectorAll('a').forEach(link => link.addEventListener('click', close));
        const media = window.matchMedia?.('(prefers-color-scheme: dark)');
        const preferredTheme = () => localStorage.getItem('sb-theme') || localStorage.getItem('smartbasket-theme') || 'system';
        const applyTheme = preference => {
            if (!['light', 'dark', 'system'].includes(preference)) return;
            const resolved = preference === 'system' ? (media?.matches ? 'dark' : 'light') : preference;
            localStorage.setItem('sb-theme', preference);
            localStorage.setItem('smartbasket-theme', preference);
            document.documentElement.setAttribute('data-theme', resolved);
            document.documentElement.setAttribute('data-sb-theme', resolved);
            document.documentElement.setAttribute('data-theme-preference', preference);
            document.body?.setAttribute('data-sb-theme', resolved);
            document.body?.setAttribute('data-customer-theme', preference);
            document.documentElement.style.colorScheme = resolved;
            root.querySelectorAll('[data-site-theme]').forEach(button => button.classList.toggle('is-active', button.dataset.siteTheme === preference));
            window.dispatchEvent(new CustomEvent('sb-theme-changed', { detail: { theme: resolved, preference } }));
            window.dispatchEvent(new CustomEvent('smartbasket-theme-changed', { detail: { theme: resolved, preference } }));
        };
        window.SmartBasketTheme = window.SmartBasketTheme || {};
        const previousSet = window.SmartBasketTheme.set;
        window.SmartBasketTheme.set = preference => { if (previousSet && previousSet !== window.SmartBasketTheme.set) previousSet(preference); applyTheme(preference); };
        applyTheme(preferredTheme());
        root.querySelectorAll('[data-site-theme]').forEach(button => button.addEventListener('click', () => { applyTheme(button.dataset.siteTheme); close(); }));
        media?.addEventListener?.('change', () => { if (preferredTheme() === 'system') applyTheme('system'); });
    })();
</script>
@endif

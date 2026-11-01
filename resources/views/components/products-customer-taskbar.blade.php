@props(['includeRobot' => true])

@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
    $isProductsPage = request()->routeIs('dashboard', 'products.*');
    $isOrdersPage = is_string($currentRoute) && str_starts_with($currentRoute, 'orders.');
    $isCartPage = is_string($currentRoute) && str_starts_with($currentRoute, 'cart.');
    $isAiHubPage = request()->routeIs('ai-hub', 'overview', 'ai-camera', 'budget-shopping', 'gift-finder', 'trending-products', 'compare-products', 'ai.*', 'customer-ai.*', 'ai-camera*');
@endphp

<style>
:root{--sb-customer-title-top:#5143a2;--sb-customer-title-mid:#34307f;--sb-customer-title-bottom:#241a5e;--sb-customer-title-border:rgba(218,210,255,.42);--sb-customer-title-text:#fff;--sb-customer-title-shadow:0 16px 38px rgba(31,25,91,.3),inset 0 1px 0 rgba(255,255,255,.17)}
html[data-theme="dark"],html[data-sb-theme="dark"]{--sb-customer-title-top:#4385e8;--sb-customer-title-mid:#2057ae;--sb-customer-title-bottom:#12366f;--sb-customer-title-border:rgba(177,210,255,.42);--sb-customer-title-shadow:0 5px 0 #0b2854,0 11px 0 #071d3e,0 20px 34px rgba(0,0,0,.42)}
h1.sb-customer-page-title{position:relative!important;display:flex!important;align-items:center!important;gap:13px!important;width:100%!important;min-width:0!important;min-height:78px!important;box-sizing:border-box!important;padding:20px 28px!important;margin:0 0 34px!important;color:var(--sb-customer-title-text)!important;background:linear-gradient(112deg,#241a5e 0%,#34307f 52%,#24518c 100%)!important;border:1px solid var(--sb-customer-title-border)!important;border-radius:17px!important;box-shadow:var(--sb-customer-title-shadow)!important;font-size:clamp(1.35rem,2.2vw,1.75rem)!important;font-weight:850!important;line-height:1.2!important;letter-spacing:-.025em!important;text-wrap:balance;overflow-wrap:anywhere;isolation:isolate}
h1.sb-customer-page-title .sb-customer-page-icon{display:inline-grid;flex:0 0 50px;width:50px;height:50px;place-items:center;border:1px solid rgba(255,255,255,.32);border-radius:15px;background:linear-gradient(145deg,rgba(255,255,255,.24),rgba(255,255,255,.08));box-shadow:inset 0 1px 0 rgba(255,255,255,.24),0 7px 18px rgba(7,28,75,.2);font-family:"Apple Color Emoji","Segoe UI Emoji","Noto Color Emoji",sans-serif;font-size:30px;line-height:1}
h1.sb-customer-page-title::before{content:"";position:absolute;inset:1px 1px auto;height:44%;border-radius:15px 15px 50% 50%/15px 15px 20% 20%;background:linear-gradient(180deg,rgba(255,255,255,.24),rgba(255,255,255,0));pointer-events:none;z-index:-1}
@media(max-width:600px){h1.sb-customer-page-title{min-height:68px!important;padding:17px 19px!important;margin-bottom:29px!important;border-radius:15px!important;gap:10px!important}h1.sb-customer-page-title .sb-customer-page-icon{flex-basis:44px;width:44px;height:44px;border-radius:13px;font-size:27px}}
/* =========================================================
   PRODUCTS PAGE — FULL WIDTH PREMIUM TASKBAR
========================================================= */

:root{
    --sb-tbar-bg:rgba(255,255,255,.92);
    --sb-tbar-panel:#ffffff;
    --sb-tbar-text:#102033;
    --sb-tbar-muted:#64748b;
    --sb-tbar-border:rgba(37,99,235,.13);
    --sb-tbar-blue:#2563eb;
    --sb-tbar-blue2:#4f46e5;
    --sb-tbar-soft:#eef4ff;
    --sb-tbar-shadow:0 16px 45px rgba(15,23,42,.12);
}

html[data-theme="dark"],html[data-sb-theme="dark"]{
    --sb-tbar-bg:rgba(5,11,22,.94);
    --sb-tbar-panel:#0b1728;
    --sb-tbar-text:#f7fbff;
    --sb-tbar-muted:#9aacbf;
    --sb-tbar-border:rgba(101,165,255,.20);
    --sb-tbar-blue:#65a5ff;
    --sb-tbar-blue2:#8b7cff;
    --sb-tbar-soft:rgba(37,99,235,.16);
    --sb-tbar-shadow:0 20px 60px rgba(0,0,0,.42);
}

.sb-products-taskbar{
    position:sticky;top:0;left:0;right:0;z-index:99990;
    width:100%;min-height:76px;padding:8px 12px;
    display:flex;align-items:center;gap:9px;
    background:var(--sb-tbar-bg);
    border-bottom:1px solid var(--sb-tbar-border);
    box-shadow:var(--sb-tbar-shadow);
    backdrop-filter:blur(24px) saturate(155%);
    -webkit-backdrop-filter:blur(24px) saturate(155%);
}

.sb-products-taskbar:before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:-2px;
    height:2px;
    background:linear-gradient(
        90deg,
        #00e5ff,
        #287bff,
        #8b35ff,
        #ff20c8,
        #ff405d,
        #ffe45c,
        #00e5ff
    );
    background-size:600% 100%;
    animation:sbTaskbarRGB 8s linear infinite;
    pointer-events:none;
}

@keyframes sbTaskbarRGB{
    to{
        background-position:600% 50%
    }
}

.sb-products-brand{
    flex:0 0 208px;
    min-width:190px;
    height:58px;
    padding:5px 10px 5px 6px;
    display:flex;
    align-items:center;
    gap:10px;
    border-radius:18px;
    color:var(--sb-tbar-text)!important;
    text-decoration:none!important;
    border:1px solid transparent;
    transition:.22s ease;
}

.sb-products-brand:hover{
    background:var(--sb-tbar-soft);
    border-color:var(--sb-tbar-border);
    transform:translateY(-1px)
}

.sb-brand-mark{
    width:45px;
    height:45px;
    display:grid;
    place-items:center;
    border-radius:14px;
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    box-shadow:
        0 8px 22px rgba(37,99,235,.30),
        inset 0 1px rgba(255,255,255,.25);
    font-size:17px
}

.sb-brand-copy{
    display:flex;
    flex-direction:column;
    line-height:1.05;
    min-width:0
}

.sb-brand-copy strong{
    font-size:14px;
    letter-spacing:.4px
}

.sb-brand-copy small{
    margin-top:5px;
    font-size:8px;
    letter-spacing:1.25px;
    color:var(--sb-tbar-muted);
    font-weight:900
}

.sb-products-nav{
    display:flex;
    align-items:center;
    gap:6px;
    flex:1;
    min-width:0
}

.sb-pnav-btn{
    position:relative;
    flex:1;
    min-width:82px;
    height:50px;
    padding:0 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    border:1px solid rgba(37,99,235,.13);
    border-radius:14px;
    background:linear-gradient(
        180deg,
        var(--sb-tbar-panel),
        var(--sb-tbar-soft)
    );
    color:var(--sb-tbar-muted)!important;
    font-size:11px;
    font-weight:900;
    text-decoration:none!important;
    white-space:nowrap;
    cursor:pointer;
    box-shadow:0 5px 16px rgba(37,99,235,.06);
    transition:.2s ease;
}

.sb-pnav-btn i{
    font-size:13px;
    width:16px;
    text-align:center
}

.sb-pnav-btn:hover{
    color:var(--sb-tbar-blue)!important;
    border-color:rgba(37,99,235,.32);
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(37,99,235,.13)
}

.sb-pnav-btn.is-active{
    color:#fff!important;
    border-color:transparent;
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    box-shadow:0 10px 28px rgba(37,99,235,.28)
}

.sb-pnav-aihub{
    color:#2563eb!important
}

.sb-pnav-aihub:hover{
    color:#fff!important;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent
}

.sb-pnav-smart-ai{
    color:#4f46e5!important
}

.sb-pnav-smart-ai:hover{
    color:#fff!important;
    background:linear-gradient(135deg,#4f46e5,#9333ea);
    border-color:transparent
}

.sb-smart-orb{
    width:25px;
    height:25px;
    display:grid;
    place-items:center;
    border-radius:8px;
    color:#fff;
    background:linear-gradient(135deg,#4f46e5,#9333ea);
    box-shadow:0 5px 14px rgba(79,70,229,.25);
    font-size:11px
}

.sb-online-dot{
    position:absolute;
    top:7px;
    right:8px;
    width:6px;
    height:6px;
    border-radius:50%;
    background:#22c55e;
    box-shadow:0 0 0 3px rgba(34,197,94,.13)
}

.sb-taskbar-user{
    flex:0 1 145px;
    min-width:105px;
    height:50px;
    padding:0 10px;
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid var(--sb-tbar-border);
    border-radius:14px;
    background:var(--sb-tbar-panel);
    box-shadow:0 5px 16px rgba(37,99,235,.05);
    animation:sbHiFloat 3s ease-in-out infinite
}

@keyframes sbHiFloat{
    0%,100%{
        transform:translateY(0)
    }

    50%{
        transform:translateY(-2px)
    }
}

.sb-user-dot{
    width:31px;
    height:31px;
    display:grid;
    place-items:center;
    border-radius:10px;
    background:var(--sb-tbar-soft);
    color:var(--sb-tbar-blue);
    flex:0 0 31px
}

.sb-user-text{
    display:flex;
    flex-direction:column;
    min-width:0;
    line-height:1.05
}

.sb-user-text small{
    font-size:8px;
    color:var(--sb-tbar-muted);
    font-weight:800
}

.sb-user-text strong{
    margin-top:4px;
    font-size:10px;
    color:var(--sb-tbar-text);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    max-width:92px
}

.sb-products-more{
    flex:0 0 52px;
    height:50px;
    border:1px solid var(--sb-tbar-border);
    border-radius:14px;
    background:var(--sb-tbar-panel);
    color:var(--sb-tbar-text);
    cursor:pointer;
    font-size:17px;
    transition:.2s ease;
    box-shadow:0 5px 16px rgba(37,99,235,.06)
}

.sb-products-more:hover{
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent;
    transform:translateY(-2px)
}

.sb-products-more-menu{
    position:fixed;
    z-index:100000;
    top:84px;
    right:12px;
    width:290px;
    max-height:calc(100vh - 100px);
    overflow:auto;
    padding:10px;
    border:1px solid var(--sb-tbar-border);
    border-radius:22px;
    background:var(--sb-tbar-bg);
    box-shadow:0 30px 90px rgba(0,0,0,.28);
    backdrop-filter:blur(28px);
    -webkit-backdrop-filter:blur(28px);
    display:none
}

.sb-products-more-menu.is-open{
    display:block;
    animation:sbMenuIn .2s ease
}

.sb-more-heading{
    padding:9px 10px 11px;
    border-bottom:1px solid var(--sb-tbar-border);
    margin-bottom:5px
}

.sb-more-heading span{
    display:block;
    color:var(--sb-tbar-text);
    font-size:11px;
    font-weight:950;
    letter-spacing:.7px
}

.sb-more-heading small{
    display:block;
    margin-top:4px;
    color:var(--sb-tbar-muted);
    font-size:8px
}

.sb-more-link{
    width:100%;
    min-height:42px;
    padding:0 11px;
    display:flex;
    align-items:center;
    gap:10px;
    border:0;
    border-radius:12px;
    background:transparent;
    color:var(--sb-tbar-text)!important;
    text-decoration:none!important;
    font-size:10px;
    font-weight:850;
    cursor:pointer
}

.sb-more-link i{
    width:18px;
    text-align:center;
    color:var(--sb-tbar-blue)
}

.sb-more-link:hover{
    background:var(--sb-tbar-soft);
    color:var(--sb-tbar-blue)!important;
    transform:translateX(2px)
}

.sb-more-separator{
    height:1px;
    margin:7px 5px;
    background:var(--sb-tbar-border)
}

.sb-more-title{
    display:flex;
    gap:8px;
    align-items:center;
    padding:5px 10px 7px;
    color:var(--sb-tbar-muted);
    font-size:9px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.08em
}

.sb-theme-switcher{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:6px
}

.sb-theme-choice{
    height:38px;
    border:1px solid var(--sb-tbar-border);
    border-radius:11px;
    background:var(--sb-tbar-panel);
    color:var(--sb-tbar-text);
    font-size:10px;
    font-weight:850;
    cursor:pointer
}

.sb-theme-choice:hover,
.sb-theme-choice.is-selected{
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent
}

.sb-theme-choice i{
    margin-right:5px
}

.sb-more-action{
    font-family:inherit;
    text-align:left
}

.sb-logout-form{
    margin:0
}

.sb-logout{
    color:#e05b72!important
}

.sb-logout i{
    color:#e05b72!important
}

@keyframes sbMenuIn{
    from{
        opacity:0;
        transform:translateY(-8px) scale(.98)
    }

    to{
        opacity:1;
        transform:none
    }
}

/* AI HUB */
.ai-hub-fab{
    z-index:99980!important
}

.ai-hub-drawer{
    z-index:99999!important
}

html[data-theme="light"] .ai-hub-drawer{
    background:linear-gradient(
        145deg,
        rgba(255,255,255,.99),
        rgba(242,246,252,.99)
    )!important;
    color:#101828!important;
    border-right-color:rgba(37,99,235,.14)!important;
    box-shadow:24px 0 70px rgba(15,23,42,.20)!important
}

html[data-theme="light"] .ai-hub-drawer-header strong,
html[data-theme="light"] .ai-hub-tool-text strong{
    color:#101828!important
}

html[data-theme="light"] .ai-hub-drawer-header small,
html[data-theme="light"] .ai-hub-tool-text small{
    color:#667085!important
}

html[data-theme="light"] .ai-hub-fab{
    background:linear-gradient(145deg,#fff,#eef4ff)!important;
    color:#172033!important;
    border-color:rgba(37,99,235,.25)!important
}

html[data-theme="dark"] .ai-hub-drawer{
    background:linear-gradient(145deg,#09111f,#020711)!important
}

html[data-theme="dark"] .ai-hub-fab{
    background:linear-gradient(145deg,#1e293b,#050a14)!important
}

.sb-products-smart-ai-host>.smart-ai>.smart-ai__launch{
    opacity:0!important;
    visibility:hidden!important;
    pointer-events:none!important;
    position:fixed!important;
    width:1px!important;
    height:1px!important;
    overflow:hidden!important;
    clip:rect(0,0,0,0)!important
}

@media(max-width:1350px){
    .sb-products-brand{
        flex-basis:185px;
        min-width:175px
    }

    .sb-pnav-btn{
        min-width:70px;
        padding:0 7px;
        font-size:10px
    }

    .sb-taskbar-user{
        flex-basis:125px
    }
}

@media(max-width:1120px){
    .sb-brand-copy{
        display:none
    }

    .sb-products-brand{
        flex-basis:65px;
        min-width:65px;
        justify-content:center;
        padding:5px
    }

    .sb-pnav-btn span{
        display:none
    }

    .sb-pnav-btn{
        min-width:52px;
        padding:0
    }

    .sb-taskbar-user{
        flex-basis:90px;
        min-width:90px
    }

    .sb-user-text strong{
        max-width:52px
    }
}

@media(max-width:700px){
    .sb-products-taskbar{
        padding:7px;
        gap:5px;
        overflow-x:auto;
        scrollbar-width:none
    }

    .sb-products-taskbar::-webkit-scrollbar{
        display:none
    }

    .sb-products-brand{
        position:sticky;
        left:0;
        z-index:2;
        flex-basis:52px;
        min-width:52px;
        height:48px
    }

    .sb-brand-mark{
        width:39px;
        height:39px
    }

    .sb-products-nav{
        flex:0 0 auto
    }

    .sb-pnav-btn{
        height:46px;
        min-width:48px;
        flex:0 0 48px;
        border-radius:12px
    }

    .sb-taskbar-user{
        flex:0 0 110px;
        height:46px
    }

    .sb-products-more{
        flex:0 0 46px;
        height:46px
    }

    .sb-products-more-menu{
        top:66px;
        right:7px;
        width:min(290px,calc(100vw - 14px))
    }
}

/* Keep the shared customer taskbar identical on pages with different body styles. */
.sb-products-taskbar,
.sb-products-taskbar *,
.sb-products-more-menu,
.sb-products-more-menu *{
    box-sizing:border-box
}

.sb-products-taskbar,
.sb-products-taskbar a,
.sb-products-taskbar button,
.sb-products-more-menu,
.sb-products-more-menu a,
.sb-products-more-menu button{
    font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif
}

.sb-products-taskbar,
.sb-products-more-menu{
    margin:0;
    line-height:1.2
}

</style>

<style data-visual-design>{!! app(\App\Services\WebsiteDesignService::class)->renderCss('customer.shared') !!}</style>

@auth
<nav class="sb-products-taskbar" id="sbProductsTaskbar" data-ve="customer.shared.taskbar" aria-label="Customer Navigation">
    <a href="{{ route('products.index') }}" class="sb-products-brand" aria-label="Smart Basket Products">
        <span class="sb-brand-mark"><i class="fa-solid fa-basket-shopping"></i></span>
        <span class="sb-brand-copy">
            <strong>SMART BASKET</strong>
            <small>CUSTOMER PANEL</small>
        </span>
    </a>

    <div class="sb-products-nav">
        @if(Route::has('products.index'))
            <a href="{{ route('products.index') }}" class="sb-pnav-btn {{ $isProductsPage ? 'is-active' : '' }}">
                <i class="fa-solid fa-store"></i><span>Products</span>
            </a>
        @endif

        @if($ordersRoute)
            <a href="{{ route($ordersRoute) }}" class="sb-pnav-btn {{ $isOrdersPage || $currentRoute === $ordersRoute ? 'is-active' : '' }}">
                <i class="fa-solid fa-box"></i><span>Orders</span>
            </a>
        @endif

        @if(Route::has('cart.index'))
            <a href="{{ route('cart.index') }}" class="sb-pnav-btn {{ $isCartPage ? 'is-active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
            </a>
        @endif

        @if(Route::has('wishlist'))
            <a href="{{ route('wishlist') }}" class="sb-pnav-btn {{ $currentRoute === 'wishlist' ? 'is-active' : '' }}">
                <i class="fa-regular fa-heart"></i><span>Wishlist</span>
            </a>
        @endif

        @if(Route::has('profile'))
            <a href="{{ route('profile') }}" class="sb-pnav-btn {{ $currentRoute === 'profile' ? 'is-active' : '' }}">
                <i class="fa-regular fa-user"></i><span>Profile</span>
            </a>
        @endif

        @if(Route::has('settings'))
            <a href="{{ route('settings') }}" class="sb-pnav-btn {{ $currentRoute === 'settings' ? 'is-active' : '' }}">
                <i class="fa-solid fa-gear"></i><span>Settings</span>
            </a>
        @endif

        <button type="button" class="sb-pnav-btn sb-pnav-aihub {{ $isAiHubPage ? 'is-active' : '' }}" id="sbProductsAIHub" data-sb-ai-hub-open title="Open AI Hub">
            <i class="fa-solid fa-wand-magic-sparkles"></i><span>AI HUB</span>
        </button>

        <button type="button" class="sb-pnav-btn sb-pnav-smart-ai" id="sbProductsSmartAI" title="Open Smart AI">
            <span class="sb-smart-orb"><i class="fa-solid fa-robot"></i></span><span>Smart AI</span><b class="sb-online-dot"></b>
        </button>
    </div>

    <div class="sb-taskbar-user">
        <span class="sb-user-dot"><i class="fa-regular fa-user"></i></span>
        <span class="sb-user-text"><small>Hi,</small><strong>{{ auth()->user()->name ?? 'Customer' }}</strong></span>
    </div>

    <button type="button" class="sb-products-more" id="sbProductsMore" aria-expanded="false" aria-controls="sbProductsMoreMenu" title="More options">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
</nav>

<div class="sb-products-more-menu" id="sbProductsMoreMenu" aria-hidden="true">
    <div class="sb-more-heading"><span>SMART BASKET</span><small>More options</small></div>

    @if(Route::has('products.index'))
        <a href="{{ route('products.index') }}" class="sb-more-link"><i class="fa-solid fa-house"></i><span>Products Home</span></a>
    @endif
    @if($ordersRoute)
        <a href="{{ route($ordersRoute) }}" class="sb-more-link"><i class="fa-solid fa-box"></i><span>My Orders</span></a>
    @endif
    @if(Route::has('cart.index'))
        <a href="{{ route('cart.index') }}" class="sb-more-link"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>
    @endif
    @if(Route::has('wishlist'))
        <a href="{{ route('wishlist') }}" class="sb-more-link"><i class="fa-regular fa-heart"></i><span>Wishlist</span></a>
    @endif
    @if(Route::has('profile'))
        <a href="{{ route('profile') }}" class="sb-more-link"><i class="fa-regular fa-user"></i><span>Profile</span></a>
    @endif
    @if(Route::has('settings'))
        <a href="{{ route('settings') }}" class="sb-more-link"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
    @endif

    <div class="sb-more-separator"></div>
    <div class="sb-more-title"><i class="fa-solid fa-palette"></i><span>Theme</span></div>
    <div class="sb-theme-switcher">
        <button type="button" class="sb-theme-choice" data-sb-set-theme="light"><i class="fa-solid fa-sun"></i><span>Light</span></button>
        <button type="button" class="sb-theme-choice" data-sb-set-theme="dark"><i class="fa-solid fa-moon"></i><span>Dark</span></button>
    </div>

    <div class="sb-more-separator"></div>
    <button type="button" class="sb-more-link sb-more-action" data-sb-more-aihub><i class="fa-solid fa-wand-magic-sparkles"></i><span>Open AI HUB</span></button>
    <button type="button" class="sb-more-link sb-more-action" data-sb-more-smart-ai><i class="fa-solid fa-robot"></i><span>Open Smart AI</span></button>

    @if(Route::has('logout'))
        <div class="sb-more-separator"></div>
        <form method="POST" action="{{ route('logout') }}" class="sb-logout-form">
            @csrf
            <button type="submit" class="sb-more-link sb-logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
        </form>
    @endif
</div>
@endauth

@if($includeRobot)
    <div class="sb-products-smart-ai-host" aria-hidden="false"><x-smart-ai-robot /></div>
@endif
@once
    <script src="{{ asset('js/customer-page-title.js') }}?v=20261019-purple-blue-4" defer></script>
@endonce
<script>
(function(){
    'use strict';
    if(window.__SBProductsPremiumTaskbar) return;
    window.__SBProductsPremiumTaskbar=true;

    const more=document.getElementById('sbProductsMore');
    const menu=document.getElementById('sbProductsMoreMenu');
    const aiHubBtn=document.getElementById('sbProductsAIHub');
    const smartAiBtn=document.getElementById('sbProductsSmartAI');

    function closeMore(){
        if(menu){menu.classList.remove('is-open');menu.setAttribute('aria-hidden','true');}
        if(more) more.setAttribute('aria-expanded','false');
    }
    // Profile page actions also close the shared taskbar menu through this hook.
    window.closeMenu=closeMore;
    function openMore(){
        if(menu){menu.classList.add('is-open');menu.setAttribute('aria-hidden','false');}
        if(more) more.setAttribute('aria-expanded','true');
    }
    if(more){
        more.addEventListener('click',function(e){e.preventDefault();e.stopPropagation();menu&&menu.classList.contains('is-open')?closeMore():openMore();});
    }
    document.addEventListener('click',function(e){if(menu&&more&&!menu.contains(e.target)&&!more.contains(e.target))closeMore();});
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closeMore();});

    function openHub(){
        const trigger=document.querySelector('[data-ai-hub-open]');
        if(trigger) trigger.click();
        closeMore();
    }
    function openRobot(){
        const robot=window.SmartBasketAI;
        if(robot && typeof robot.open==='function'){
            robot.open();
        }else{
            const trigger=document.querySelector('[data-smart-ai-open]');
            if(trigger) trigger.click();
        }
        closeMore();
    }
    if(aiHubBtn) aiHubBtn.addEventListener('click',openHub);
    if(smartAiBtn) smartAiBtn.addEventListener('click',openRobot);
    document.querySelectorAll('[data-sb-more-aihub]').forEach(b=>b.addEventListener('click',openHub));
    document.querySelectorAll('[data-sb-more-smart-ai]').forEach(b=>b.addEventListener('click',openRobot));

    function setTheme(theme, persist=true){
        if(!['light','dark'].includes(theme)) return;
        if(persist) localStorage.setItem('sb-theme',theme);
        document.documentElement.setAttribute('data-theme',theme);
        document.documentElement.setAttribute('data-sb-theme',theme);
        document.body.setAttribute('data-sb-theme',theme);
        window.SB_THEME=theme;
        try{window.dispatchEvent(new CustomEvent('sb-theme-changed',{detail:{theme:theme}}));}catch(e){}
        try{window.dispatchEvent(new CustomEvent('smartbasket-theme-changed',{detail:{theme:theme}}));}catch(e){}
        updateThemeButtons(theme);
    }
    function updateThemeButtons(theme){
        document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.classList.toggle('is-selected',btn.getAttribute('data-sb-set-theme')===theme);});
    }
    document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.addEventListener('click',function(){setTheme(btn.getAttribute('data-sb-set-theme'));});});
    const savedTheme=localStorage.getItem('sb-theme');
    const userTheme=@auth @json(auth()->user()->dark_mode ?? auth()->user()->theme ?? 'system') @else 'system' @endauth;
    const systemTheme=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';
    const currentTheme=document.documentElement.getAttribute('data-theme')||document.documentElement.getAttribute('data-sb-theme');
    const initialTheme=['light','dark'].includes(savedTheme)?savedTheme:(['light','dark'].includes(userTheme)?userTheme:(userTheme==='system'?systemTheme:(['light','dark'].includes(currentTheme)?currentTheme:'dark')));
    setTheme(initialTheme,false);
})();
</script>

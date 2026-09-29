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
        .wishlist-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:22px;margin-bottom:24px;padding:28px 30px;border:1px solid var(--wish-border);border-radius:26px;background:linear-gradient(135deg,rgba(255,255,255,.76),rgba(239,246,255,.62));box-shadow:var(--wish-shadow);backdrop-filter:blur(20px)}
        html[data-sb-theme="dark"] .wishlist-hero{background:linear-gradient(135deg,rgba(15,23,42,.88),rgba(30,41,59,.68))}
        .wishlist-hero:after{content:"";position:absolute;width:210px;height:210px;right:-80px;top:-100px;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.18),rgba(124,58,237,.18));filter:blur(8px)}
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
        @media(max-width:700px){.wishlist-page{padding:22px 10px 55px}.wishlist-hero{align-items:flex-start;flex-direction:column;padding:22px 18px}.wishlist-title{font-size:29px}.hero-stat{width:100%;min-width:0}.wishlist-panel{padding:15px;border-radius:22px}.panel-head{align-items:flex-start;flex-direction:column}.panel-cart{width:100%;justify-content:center}.wish-grid{grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:13px}.wish-image-link{height:205px}}
    </style>
    <style>
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
    backdrop-filter:blur(24px) saturate(155%);-webkit-backdrop-filter:blur(24px) saturate(155%);
}
.sb-products-taskbar:before{
    content:"";position:absolute;left:0;right:0;bottom:-2px;height:2px;
    background:linear-gradient(90deg,#00e5ff,#287bff,#8b35ff,#ff20c8,#ff405d,#ffe45c,#00e5ff);
    background-size:600% 100%;animation:sbTaskbarRGB 8s linear infinite;pointer-events:none;
}
@keyframes sbTaskbarRGB{to{background-position:600% 50%}}
.sb-products-brand{
    flex:0 0 208px;min-width:190px;height:58px;padding:5px 10px 5px 6px;
    display:flex;align-items:center;gap:10px;border-radius:18px;
    color:var(--sb-tbar-text)!important;text-decoration:none!important;
    border:1px solid transparent;transition:.22s ease;
}
.sb-products-brand:hover{background:var(--sb-tbar-soft);border-color:var(--sb-tbar-border);transform:translateY(-1px)}
.sb-brand-mark{width:45px;height:45px;display:grid;place-items:center;border-radius:14px;color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);box-shadow:0 8px 22px rgba(37,99,235,.30),inset 0 1px rgba(255,255,255,.25);font-size:17px}
.sb-brand-copy{display:flex;flex-direction:column;line-height:1.05;min-width:0}.sb-brand-copy strong{font-size:14px;letter-spacing:.4px}.sb-brand-copy small{margin-top:5px;font-size:8px;letter-spacing:1.25px;color:var(--sb-tbar-muted);font-weight:900}
.sb-products-nav{display:flex;align-items:center;gap:6px;flex:1;min-width:0}
.sb-pnav-btn{
    position:relative;flex:1;min-width:82px;height:50px;padding:0 10px;
    display:flex;align-items:center;justify-content:center;gap:7px;
    border:1px solid rgba(37,99,235,.13);border-radius:14px;
    background:linear-gradient(180deg,var(--sb-tbar-panel),var(--sb-tbar-soft));
    color:var(--sb-tbar-muted)!important;font-size:11px;font-weight:900;
    text-decoration:none!important;white-space:nowrap;cursor:pointer;
    box-shadow:0 5px 16px rgba(37,99,235,.06);transition:.2s ease;
}
.sb-pnav-btn i{font-size:13px;width:16px;text-align:center}.sb-pnav-btn:hover{color:var(--sb-tbar-blue)!important;border-color:rgba(37,99,235,.32);transform:translateY(-2px);box-shadow:0 10px 25px rgba(37,99,235,.13)}
.sb-pnav-btn.is-active{color:#fff!important;border-color:transparent;background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 10px 28px rgba(37,99,235,.28)}
.sb-pnav-aihub{color:#2563eb!important}.sb-pnav-aihub:hover{color:#fff!important;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}
.sb-pnav-smart-ai{color:#4f46e5!important}.sb-pnav-smart-ai:hover{color:#fff!important;background:linear-gradient(135deg,#4f46e5,#9333ea);border-color:transparent}
.sb-smart-orb{width:25px;height:25px;display:grid;place-items:center;border-radius:8px;color:#fff;background:linear-gradient(135deg,#4f46e5,#9333ea);box-shadow:0 5px 14px rgba(79,70,229,.25);font-size:11px}.sb-online-dot{position:absolute;top:7px;right:8px;width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.13)}
.sb-taskbar-user{flex:0 1 145px;min-width:105px;height:50px;padding:0 10px;display:flex;align-items:center;gap:8px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);box-shadow:0 5px 16px rgba(37,99,235,.05);animation:sbHiFloat 3s ease-in-out infinite}
@keyframes sbHiFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-2px)}}
.sb-user-dot{width:31px;height:31px;display:grid;place-items:center;border-radius:10px;background:var(--sb-tbar-soft);color:var(--sb-tbar-blue);flex:0 0 31px}.sb-user-text{display:flex;flex-direction:column;min-width:0;line-height:1.05}.sb-user-text small{font-size:8px;color:var(--sb-tbar-muted);font-weight:800}.sb-user-text strong{margin-top:4px;font-size:10px;color:var(--sb-tbar-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:92px}
.sb-products-more{flex:0 0 52px;height:50px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);cursor:pointer;font-size:17px;transition:.2s ease;box-shadow:0 5px 16px rgba(37,99,235,.06)}.sb-products-more:hover{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent;transform:translateY(-2px)}
.sb-products-more-menu{position:fixed;z-index:100000;top:84px;right:12px;width:290px;max-height:calc(100vh - 100px);overflow:auto;padding:10px;border:1px solid var(--sb-tbar-border);border-radius:22px;background:var(--sb-tbar-bg);box-shadow:0 30px 90px rgba(0,0,0,.28);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);display:none}.sb-products-more-menu.is-open{display:block;animation:sbMenuIn .2s ease}.sb-more-heading{padding:9px 10px 11px;border-bottom:1px solid var(--sb-tbar-border);margin-bottom:5px}.sb-more-heading span{display:block;color:var(--sb-tbar-text);font-size:11px;font-weight:950;letter-spacing:.7px}.sb-more-heading small{display:block;margin-top:4px;color:var(--sb-tbar-muted);font-size:8px}.sb-more-link{width:100%;min-height:42px;padding:0 11px;display:flex;align-items:center;gap:10px;border:0;border-radius:12px;background:transparent;color:var(--sb-tbar-text)!important;text-decoration:none!important;font-size:10px;font-weight:850;cursor:pointer}.sb-more-link i{width:18px;text-align:center;color:var(--sb-tbar-blue)}.sb-more-link:hover{background:var(--sb-tbar-soft);color:var(--sb-tbar-blue)!important;transform:translateX(2px)}.sb-more-separator{height:1px;margin:7px 5px;background:var(--sb-tbar-border)}.sb-more-title{display:flex;gap:8px;align-items:center;padding:5px 10px 7px;color:var(--sb-tbar-muted);font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.sb-theme-switcher{display:grid;grid-template-columns:1fr 1fr;gap:6px}.sb-theme-choice{height:38px;border:1px solid var(--sb-tbar-border);border-radius:11px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);font-size:10px;font-weight:850;cursor:pointer}.sb-theme-choice:hover,.sb-theme-choice.is-selected{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}.sb-theme-choice i{margin-right:5px}.sb-more-action{font-family:inherit;text-align:left}.sb-logout-form{margin:0}.sb-logout{color:#e05b72!important}.sb-logout i{color:#e05b72!important}
@keyframes sbMenuIn{from{opacity:0;transform:translateY(-8px) scale(.98)}to{opacity:1;transform:none}}

/* AI HUB left button: existing project component remains the single left-side AI HUB launcher */
.ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}
html[data-theme="light"] .ai-hub-drawer{background:linear-gradient(145deg,rgba(255,255,255,.99),rgba(242,246,252,.99))!important;color:#101828!important;border-right-color:rgba(37,99,235,.14)!important;box-shadow:24px 0 70px rgba(15,23,42,.20)!important}
html[data-theme="light"] .ai-hub-drawer-header strong,html[data-theme="light"] .ai-hub-tool-text strong{color:#101828!important}html[data-theme="light"] .ai-hub-drawer-header small,html[data-theme="light"] .ai-hub-tool-text small{color:#667085!important}
html[data-theme="light"] .ai-hub-fab{background:linear-gradient(145deg,#fff,#eef4ff)!important;color:#172033!important;border-color:rgba(37,99,235,.25)!important}
html[data-theme="dark"] .ai-hub-drawer{background:linear-gradient(145deg,#09111f,#020711)!important}html[data-theme="dark"] .ai-hub-fab{background:linear-gradient(145deg,#1e293b,#050a14)!important}

/* Robot launcher is hidden; its original panel remains fully functional */
.sb-products-smart-ai-host>.smart-ai>.smart-ai__launch{opacity:0!important;visibility:hidden!important;pointer-events:none!important;position:fixed!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important}.sb-products-smart-ai-host [data-smart-ai-panel]{z-index:100001!important}

@media(max-width:1350px){.sb-products-brand{flex-basis:185px;min-width:175px}.sb-pnav-btn{min-width:70px;padding:0 7px;font-size:10px}.sb-taskbar-user{flex-basis:125px}}
@media(max-width:1120px){.sb-brand-copy{display:none}.sb-products-brand{flex-basis:65px;min-width:65px;justify-content:center;padding:5px}.sb-pnav-btn span{display:none}.sb-pnav-btn{min-width:52px;padding:0}.sb-taskbar-user{flex-basis:90px;min-width:90px}.sb-user-text strong{max-width:52px}}
@media(max-width:700px){.sb-products-taskbar{padding:7px;gap:5px;overflow-x:auto;scrollbar-width:none}.sb-products-taskbar::-webkit-scrollbar{display:none}.sb-products-brand{position:sticky;left:0;z-index:2;flex-basis:52px;min-width:52px;height:48px}.sb-brand-mark{width:39px;height:39px}.sb-products-nav{flex:0 0 auto}.sb-pnav-btn{height:46px;min-width:48px;flex:0 0 48px;border-radius:12px}.sb-taskbar-user{flex:0 0 110px;height:46px}.sb-products-more{flex:0 0 46px;height:46px}.sb-products-more-menu{top:66px;right:7px;width:min(290px,calc(100vw - 14px))}}
</style
</head>
<body data-sb-theme="light" data-customer-theme="{{ auth()->user()->dark_mode ?? 'system' }}">

@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
@endphp

@auth
<nav class="sb-products-taskbar" id="sbProductsTaskbar" aria-label="Customer Navigation">
    <a href="{{ route('products.index') }}" class="sb-products-brand" aria-label="Smart Basket Products">
        <span class="sb-brand-mark"><i class="fa-solid fa-basket-shopping"></i></span>
        <span class="sb-brand-copy">
            <strong>SMART BASKET</strong>
            <small>CUSTOMER PANEL</small>
        </span>
    </a>

    <div class="sb-products-nav">
        @if(Route::has('products.index'))
            <a href="{{ route('products.index') }}" class="sb-pnav-btn {{ $currentRoute === 'products.index' ? 'is-active' : '' }}">
                <i class="fa-solid fa-store"></i><span>Products</span>
            </a>
        @endif

        @if($ordersRoute)
            <a href="{{ route($ordersRoute) }}" class="sb-pnav-btn {{ $currentRoute === $ordersRoute ? 'is-active' : '' }}">
                <i class="fa-solid fa-box"></i><span>Orders</span>
            </a>
        @endif

        @if(Route::has('cart.index'))
            <a href="{{ route('cart.index') }}" class="sb-pnav-btn {{ $currentRoute === 'cart.index' ? 'is-active' : '' }}">
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

        <button type="button" class="sb-pnav-btn sb-pnav-aihub" id="sbProductsAIHub" data-sb-ai-hub-open title="Open AI Hub">
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

<main class="wishlist-page">
<div class="wishlist-shell">
    <section class="wishlist-hero">
        <div class="hero-copy">
            <span class="eyebrow"><i class="fa-solid fa-heart"></i> SAVED FOR LATER</span>
            <h1 class="wishlist-title">Your Wishlist ❤️</h1>
            <p class="wishlist-subtitle">Save your favourite products and move them to your Smart Basket cart whenever you're ready.</p>
        </div>
        <div class="hero-stat"><strong>{{ $wishlistItems->count() }}</strong><span>{{ $wishlistItems->count() === 1 ? 'SAVED PRODUCT' : 'SAVED PRODUCTS' }}</span></div>
    </section>

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

<div class="sb-products-smart-ai-host" aria-hidden="false"><x-smart-ai-robot /></div>
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
        const trigger=document.querySelector('[data-smart-ai-open]');
        if(trigger) trigger.click();
        closeMore();
    }
    if(aiHubBtn) aiHubBtn.addEventListener('click',openHub);
    if(smartAiBtn) smartAiBtn.addEventListener('click',openRobot);
    document.querySelectorAll('[data-sb-more-aihub]').forEach(b=>b.addEventListener('click',openHub));
    document.querySelectorAll('[data-sb-more-smart-ai]').forEach(b=>b.addEventListener('click',openRobot));

    function setTheme(theme){
        if(!['light','dark'].includes(theme)) return;
        localStorage.setItem('sb-theme',theme);
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
    updateThemeButtons(document.documentElement.getAttribute('data-theme')||localStorage.getItem('sb-theme')||'dark');
})();
</script>

</body>
</html>

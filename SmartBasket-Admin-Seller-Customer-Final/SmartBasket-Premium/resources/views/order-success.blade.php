@php
    $customerTheme = auth()->check() ? (auth()->user()->dark_mode ?? 'system') : 'system';
    if (!in_array($customerTheme, ['dark', 'light', 'system'], true)) {
        $customerTheme = 'system';
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2563eb">
    <title>SMART BASKET | Order Placed</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =========================================================
           SMART BASKET — ORDER SUCCESS / PREMIUM CELEBRATION
        ========================================================= */
        :root{
            --success-bg:#f5f8ff;
            --success-card:rgba(255,255,255,.90);
            --success-surface:rgba(248,250,252,.88);
            --success-text:#172033;
            --success-heading:#071225;
            --success-muted:#64748b;
            --success-border:rgba(37,99,235,.13);
            --success-green:#16a34a;
            --success-blue:#2563eb;
            --success-purple:#7c3aed;
            --success-cyan:#06b6d4;
            --success-shadow:0 35px 100px rgba(15,23,42,.15);
        }
        html[data-theme="dark"],html[data-sb-theme="dark"],body[data-sb-theme="dark"]{
            --success-bg:#020617;
            --success-card:rgba(8,18,34,.90);
            --success-surface:rgba(20,34,55,.76);
            --success-text:#dbeafe;
            --success-heading:#f8fbff;
            --success-muted:#94a3b8;
            --success-border:rgba(101,165,255,.18);
            --success-green:#22c55e;
            --success-blue:#60a5fa;
            --success-purple:#a78bfa;
            --success-cyan:#22d3ee;
            --success-shadow:0 35px 110px rgba(0,0,0,.52);
        }
        *{box-sizing:border-box}
        html,body{min-height:100%;scroll-behavior:smooth}
        body{
            margin:0;color:var(--success-text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            background:
                radial-gradient(circle at 7% 12%,rgba(37,99,235,.17),transparent 27%),
                radial-gradient(circle at 94% 16%,rgba(124,58,237,.16),transparent 28%),
                radial-gradient(circle at 50% 96%,rgba(34,197,94,.10),transparent 32%),
                var(--success-bg);
            transition:background .35s ease,color .35s ease;overflow-x:hidden;
        }

        /* =========================================================
           CANONICAL CUSTOMER TASKBAR — SAME AS PRODUCTS PAGE
        ========================================================= */
        :root{--sb-tbar-bg:rgba(255,255,255,.92);--sb-tbar-panel:#fff;--sb-tbar-text:#102033;--sb-tbar-muted:#64748b;--sb-tbar-border:rgba(37,99,235,.13);--sb-tbar-blue:#2563eb;--sb-tbar-blue2:#4f46e5;--sb-tbar-soft:#eef4ff;--sb-tbar-shadow:0 16px 45px rgba(15,23,42,.12)}
        html[data-theme="dark"],html[data-sb-theme="dark"]{--sb-tbar-bg:rgba(5,11,22,.94);--sb-tbar-panel:#0b1728;--sb-tbar-text:#f7fbff;--sb-tbar-muted:#9aacbf;--sb-tbar-border:rgba(101,165,255,.20);--sb-tbar-blue:#65a5ff;--sb-tbar-blue2:#8b7cff;--sb-tbar-soft:rgba(37,99,235,.16);--sb-tbar-shadow:0 20px 60px rgba(0,0,0,.42)}
        .sb-products-taskbar{position:sticky;top:0;left:0;right:0;z-index:99990;width:100%;min-height:76px;padding:8px 12px;display:flex;align-items:center;gap:9px;background:var(--sb-tbar-bg);border-bottom:1px solid var(--sb-tbar-border);box-shadow:var(--sb-tbar-shadow);backdrop-filter:blur(24px) saturate(155%);-webkit-backdrop-filter:blur(24px) saturate(155%)}
        .sb-products-taskbar:before{content:"";position:absolute;left:0;right:0;bottom:-2px;height:2px;background:linear-gradient(90deg,#00e5ff,#287bff,#8b35ff,#ff20c8,#ff405d,#ffe45c,#00e5ff);background-size:600% 100%;animation:sbTaskbarRGB 8s linear infinite;pointer-events:none}
        @keyframes sbTaskbarRGB{to{background-position:600% 50%}}
        .sb-products-brand{flex:0 0 208px;min-width:190px;height:58px;padding:5px 10px 5px 6px;display:flex;align-items:center;gap:10px;border-radius:18px;color:var(--sb-tbar-text)!important;text-decoration:none!important;border:1px solid transparent;transition:.22s ease}
        .sb-products-brand:hover{background:var(--sb-tbar-soft);border-color:var(--sb-tbar-border);transform:translateY(-1px)}
        .sb-brand-mark{width:45px;height:45px;display:grid;place-items:center;border-radius:14px;color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);box-shadow:0 8px 22px rgba(37,99,235,.30),inset 0 1px rgba(255,255,255,.25);font-size:17px}
        .sb-brand-copy{display:flex;flex-direction:column;line-height:1.05;min-width:0}.sb-brand-copy strong{font-size:14px;letter-spacing:.4px}.sb-brand-copy small{margin-top:5px;font-size:8px;letter-spacing:1.25px;color:var(--sb-tbar-muted);font-weight:900}
        .sb-products-nav{display:flex;align-items:center;gap:6px;flex:1;min-width:0}
        .sb-pnav-btn{position:relative;flex:1;min-width:82px;height:50px;padding:0 10px;display:flex;align-items:center;justify-content:center;gap:7px;border:1px solid rgba(37,99,235,.13);border-radius:14px;background:linear-gradient(180deg,var(--sb-tbar-panel),var(--sb-tbar-soft));color:var(--sb-tbar-muted)!important;font-size:11px;font-weight:900;text-decoration:none!important;white-space:nowrap;cursor:pointer;box-shadow:0 5px 16px rgba(37,99,235,.06);transition:.2s ease}
        .sb-pnav-btn i{font-size:13px;width:16px;text-align:center}.sb-pnav-btn:hover{color:var(--sb-tbar-blue)!important;border-color:rgba(37,99,235,.32);transform:translateY(-2px);box-shadow:0 10px 25px rgba(37,99,235,.13)}.sb-pnav-btn.is-active{color:#fff!important;border-color:transparent;background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 10px 28px rgba(37,99,235,.28)}
        .sb-pnav-aihub{color:#2563eb!important}.sb-pnav-aihub:hover{color:#fff!important;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}.sb-pnav-smart-ai{color:#4f46e5!important}.sb-pnav-smart-ai:hover{color:#fff!important;background:linear-gradient(135deg,#4f46e5,#9333ea);border-color:transparent}
        .sb-smart-orb{width:25px;height:25px;display:grid;place-items:center;border-radius:8px;color:#fff;background:linear-gradient(135deg,#4f46e5,#9333ea);box-shadow:0 5px 14px rgba(79,70,229,.25);font-size:11px}.sb-online-dot{position:absolute;top:7px;right:8px;width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.13)}
        .sb-taskbar-user{flex:0 1 145px;min-width:105px;height:50px;padding:0 10px;display:flex;align-items:center;gap:8px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);box-shadow:0 5px 16px rgba(37,99,235,.05);animation:sbHiFloat 3s ease-in-out infinite}@keyframes sbHiFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-2px)}}
        .sb-user-dot{width:31px;height:31px;display:grid;place-items:center;border-radius:10px;background:var(--sb-tbar-soft);color:var(--sb-tbar-blue);flex:0 0 31px}.sb-user-text{display:flex;flex-direction:column;min-width:0;line-height:1.05}.sb-user-text small{font-size:8px;color:var(--sb-tbar-muted);font-weight:800}.sb-user-text strong{margin-top:4px;font-size:10px;color:var(--sb-tbar-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:92px}
        .sb-products-more{flex:0 0 52px;height:50px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);cursor:pointer;font-size:17px;transition:.2s ease;box-shadow:0 5px 16px rgba(37,99,235,.06)}.sb-products-more:hover{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent;transform:translateY(-2px)}
        .sb-products-more-menu{position:fixed;z-index:100000;top:84px;right:12px;width:290px;max-height:calc(100vh - 100px);overflow:auto;padding:10px;border:1px solid var(--sb-tbar-border);border-radius:22px;background:var(--sb-tbar-bg);box-shadow:0 30px 90px rgba(0,0,0,.28);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);display:none}.sb-products-more-menu.is-open{display:block;animation:sbMenuIn .2s ease}.sb-more-heading{padding:9px 10px 11px;border-bottom:1px solid var(--sb-tbar-border);margin-bottom:5px}.sb-more-heading span{display:block;color:var(--sb-tbar-text);font-size:11px;font-weight:950;letter-spacing:.7px}.sb-more-heading small{display:block;margin-top:4px;color:var(--sb-tbar-muted);font-size:8px}.sb-more-link{width:100%;min-height:42px;padding:0 11px;display:flex;align-items:center;gap:10px;border:0;border-radius:12px;background:transparent;color:var(--sb-tbar-text)!important;text-decoration:none!important;font-size:10px;font-weight:850;cursor:pointer}.sb-more-link i{width:18px;text-align:center;color:var(--sb-tbar-blue)}.sb-more-link:hover{background:var(--sb-tbar-soft);color:var(--sb-tbar-blue)!important;transform:translateX(2px)}.sb-more-separator{height:1px;margin:7px 5px;background:var(--sb-tbar-border)}.sb-more-title{display:flex;gap:8px;align-items:center;padding:5px 10px 7px;color:var(--sb-tbar-muted);font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.sb-theme-switcher{display:grid;grid-template-columns:1fr 1fr;gap:6px}.sb-theme-choice{height:38px;border:1px solid var(--sb-tbar-border);border-radius:11px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);font-size:10px;font-weight:850;cursor:pointer}.sb-theme-choice:hover,.sb-theme-choice.is-selected{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}.sb-theme-choice i{margin-right:5px}.sb-more-action{font-family:inherit;text-align:left}.sb-logout-form{margin:0}.sb-logout{color:#e05b72!important}.sb-logout i{color:#e05b72!important}@keyframes sbMenuIn{from{opacity:0;transform:translateY(-8px) scale(.98)}to{opacity:1;transform:none}}
        .ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}.sb-products-smart-ai-host>.smart-ai>.smart-ai__launch{opacity:0!important;visibility:hidden!important;pointer-events:none!important;position:fixed!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important}.sb-products-smart-ai-host [data-smart-ai-panel]{z-index:100001!important}
        @media(max-width:1350px){.sb-products-brand{flex-basis:185px;min-width:175px}.sb-pnav-btn{min-width:70px;padding:0 7px;font-size:10px}.sb-taskbar-user{flex-basis:125px}}
        @media(max-width:1120px){.sb-brand-copy{display:none}.sb-products-brand{flex-basis:65px;min-width:65px;justify-content:center;padding:5px}.sb-pnav-btn span{display:none}.sb-pnav-btn{min-width:52px;padding:0}.sb-taskbar-user{flex-basis:90px;min-width:90px}.sb-user-text strong{max-width:52px}}
        @media(max-width:700px){.sb-products-taskbar{padding:7px;gap:5px;overflow-x:auto;scrollbar-width:none}.sb-products-taskbar::-webkit-scrollbar{display:none}.sb-products-brand{position:sticky;left:0;z-index:2;flex-basis:52px;min-width:52px;height:48px}.sb-brand-mark{width:39px;height:39px}.sb-products-nav{flex:0 0 auto}.sb-pnav-btn{height:46px;min-width:48px;flex:0 0 48px;border-radius:12px}.sb-taskbar-user{flex:0 0 110px;height:46px}.sb-products-more{flex:0 0 46px;height:46px}.sb-products-more-menu{top:66px;right:7px;width:min(290px,calc(100vw - 14px))}}

        /* =========================================================
           PREMIUM SUCCESS EXPERIENCE
        ========================================================= */
        .success-page{position:relative;min-height:calc(100vh - 76px);display:flex;align-items:center;justify-content:center;padding:54px 18px 90px;isolation:isolate}
        .success-container{width:100%;max-width:820px;position:relative;z-index:3}
        .success-brand{display:flex;align-items:center;justify-content:center;gap:10px;margin:0 0 18px;color:var(--success-heading);font-size:18px;font-weight:950;letter-spacing:.2px;text-shadow:0 5px 25px rgba(37,99,235,.12)}
        .brand-icon{width:42px;height:42px;display:grid;place-items:center;border-radius:14px;color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);box-shadow:0 12px 32px rgba(37,99,235,.30),inset 0 1px rgba(255,255,255,.3);font-size:17px;animation:brandPulse 2.5s ease-in-out infinite}@keyframes brandPulse{50%{transform:translateY(-3px) rotate(-2deg)}}
        .success-card{position:relative;overflow:hidden;padding:52px 48px 40px;text-align:center;border:1px solid var(--success-border);border-radius:36px;background:linear-gradient(145deg,var(--success-card),rgba(255,255,255,.52));box-shadow:var(--success-shadow);backdrop-filter:blur(28px) saturate(135%);-webkit-backdrop-filter:blur(28px);animation:cardAppear .7s cubic-bezier(.2,.8,.2,1);}
        html[data-sb-theme="dark"] .success-card{background:linear-gradient(145deg,rgba(9,20,37,.94),rgba(10,25,48,.72))}
        .success-card:before{content:"";position:absolute;inset:0 0 auto;height:4px;background:linear-gradient(90deg,#2563eb,#7c3aed,#06b6d4,#22c55e,#2563eb);background-size:300% 100%;animation:rainbowLine 5s linear infinite}@keyframes rainbowLine{to{background-position:300% 50%}}
        .success-card:after{content:"";position:absolute;width:280px;height:280px;left:50%;top:-180px;transform:translateX(-50%);border-radius:50%;background:rgba(34,197,94,.10);filter:blur(8px);pointer-events:none}
        @keyframes cardAppear{from{opacity:0;transform:translateY(28px) scale(.965)}to{opacity:1;transform:none}}
        .success-icon-wrapper{position:relative;width:116px;height:116px;margin:0 auto 25px;display:grid;place-items:center;border-radius:50%;background:radial-gradient(circle,rgba(34,197,94,.16),rgba(34,197,94,.04));border:1px solid rgba(34,197,94,.22);animation:iconPop .7s cubic-bezier(.2,.9,.2,1) .1s both}
        .success-icon-wrapper:before,.success-icon-wrapper:after{content:"";position:absolute;border-radius:50%;border:1px solid rgba(34,197,94,.22);animation:successPulse 2.2s ease-out infinite}.success-icon-wrapper:before{inset:-9px}.success-icon-wrapper:after{inset:-20px;animation-delay:.65s;opacity:.55}
        .success-icon{width:82px;height:82px;display:grid;place-items:center;border-radius:50%;color:#fff;font-size:40px;font-weight:1000;background:linear-gradient(135deg,#16a34a,#22c55e);box-shadow:0 18px 42px rgba(34,197,94,.34),inset 0 2px rgba(255,255,255,.28);text-shadow:0 2px 8px rgba(0,0,0,.12)}
        @keyframes iconPop{from{opacity:0;transform:scale(.35) rotate(-18deg)}to{opacity:1;transform:none}}@keyframes successPulse{0%{transform:scale(.82);opacity:.65}70%{transform:scale(1.18);opacity:0}100%{opacity:0}}
        .success-title{margin:0;color:var(--success-heading);font-size:clamp(30px,4vw,44px);line-height:1.08;font-weight:950;letter-spacing:-1.5px}.success-title span{display:block;margin-top:5px;background:linear-gradient(90deg,#16a34a,#22c55e,#06b6d4);-webkit-background-clip:text;background-clip:text;color:transparent}
        .success-description{max-width:590px;margin:15px auto 0;color:var(--success-muted);font-size:14px;line-height:1.75}.success-description strong{color:var(--success-heading)}
        .status-pill{display:inline-flex;align-items:center;gap:8px;margin-top:20px;padding:10px 15px;border-radius:999px;color:var(--success-green);background:rgba(34,197,94,.09);border:1px solid rgba(34,197,94,.18);font-size:12px;font-weight:900;box-shadow:0 7px 22px rgba(34,197,94,.07)}.status-dot{width:8px;height:8px;border-radius:50%;background:var(--success-green);box-shadow:0 0 0 5px rgba(34,197,94,.10);animation:statusBlink 1.5s ease-in-out infinite}@keyframes statusBlink{50%{opacity:.45;transform:scale(.82)}}
        .success-info{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:31px}.info-card{position:relative;padding:19px 13px;border:1px solid var(--success-border);border-radius:18px;background:var(--success-surface);transition:.25s ease;overflow:hidden}.info-card:before{content:"";position:absolute;inset:0;background:linear-gradient(135deg,rgba(37,99,235,.08),transparent 55%);opacity:0;transition:.25s}.info-card:hover{transform:translateY(-5px);border-color:rgba(37,99,235,.28);box-shadow:0 15px 35px rgba(37,99,235,.09)}.info-card:hover:before{opacity:1}.info-icon{font-size:23px;margin-bottom:8px;position:relative}.info-title{color:var(--success-heading);font-size:12px;font-weight:900;position:relative}.info-text{margin-top:4px;color:var(--success-muted);font-size:10px;position:relative}
        .shopping-btn{position:relative;overflow:hidden;display:inline-flex;align-items:center;justify-content:center;gap:10px;min-width:245px;min-height:56px;margin-top:31px;padding:13px 24px;border:0;border-radius:16px;color:#fff!important;text-decoration:none!important;background:linear-gradient(135deg,#2563eb,#4f46e5 50%,#7c3aed);font-size:14px;font-weight:950;box-shadow:0 16px 38px rgba(37,99,235,.30);transition:.22s ease}.shopping-btn:before{content:"";position:absolute;top:0;left:-80%;width:50%;height:100%;transform:skewX(-22deg);background:rgba(255,255,255,.22);transition:.6s ease}.shopping-btn:hover{transform:translateY(-4px);box-shadow:0 23px 48px rgba(37,99,235,.40)}.shopping-btn:hover:before{left:130%}.shopping-btn .arrow{transition:.2s}.shopping-btn:hover .arrow{transform:translateX(4px)}
        .security-row{display:flex;justify-content:center;flex-wrap:wrap;gap:20px;margin-top:24px;color:var(--success-muted);font-size:10px;font-weight:800}.security-row span{display:inline-flex;align-items:center;gap:6px}.security-row i{color:var(--success-blue)}

        /* =========================================================
           CELEBRATION — CONFETTI / BALLOONS / FIREWORK BURSTS
        ========================================================= */
        .celebration-layer{position:fixed;inset:0;z-index:9990;pointer-events:none;overflow:hidden}
        .celebrate-piece{position:absolute;top:-12vh;left:50%;font-size:22px;will-change:transform,opacity;animation:confettiFall var(--dur,4.8s) cubic-bezier(.15,.72,.3,1) var(--delay,0s) forwards;filter:drop-shadow(0 5px 8px rgba(15,23,42,.12))}
        @keyframes confettiFall{0%{transform:translate3d(var(--x0),-10vh,0) rotate(0) scale(.7);opacity:0}8%{opacity:1}50%{transform:translate3d(var(--x1),48vh,0) rotate(210deg) scale(1)}100%{transform:translate3d(var(--x2),112vh,0) rotate(620deg) scale(.8);opacity:0}}
        .celebrate-burst{position:absolute;left:50%;top:39%;width:8px;height:8px;border-radius:50%;transform:translate(-50%,-50%);animation:burstPop 1.1s ease-out forwards;opacity:0}.celebrate-burst i{position:absolute;left:50%;top:50%;font-style:normal;font-size:25px;transform:translate(-50%,-50%) rotate(var(--r));animation:burstFly 1.1s cubic-bezier(.2,.8,.2,1) forwards;animation-delay:var(--d)}@keyframes burstPop{0%,100%{opacity:0}20%{opacity:1}}@keyframes burstFly{0%{transform:translate(-50%,-50%) rotate(var(--r)) scale(.35);opacity:0}15%{opacity:1}100%{transform:translate(calc(-50% + var(--dx)),calc(-50% + var(--dy))) rotate(calc(var(--r) + 180deg)) scale(1);opacity:0}}
        .celebrate-banner{position:fixed;left:50%;top:calc(76px + 16px);z-index:9991;transform:translateX(-50%) translateY(-15px);padding:9px 15px;border:1px solid rgba(34,197,94,.22);border-radius:999px;background:rgba(255,255,255,.82);color:#15803d;font-size:11px;font-weight:950;box-shadow:0 14px 40px rgba(34,197,94,.13);backdrop-filter:blur(18px);opacity:0;animation:bannerIn 4.2s ease .35s both;white-space:nowrap}.celebrate-banner i{margin-right:6px}@keyframes bannerIn{0%,100%{opacity:0;transform:translateX(-50%) translateY(-15px) scale(.96)}12%,82%{opacity:1;transform:translateX(-50%) translateY(0) scale(1)}}
        html[data-sb-theme="dark"] .celebrate-banner{background:rgba(7,18,32,.82);color:#4ade80;border-color:rgba(74,222,128,.18)}

        @media(max-width:700px){
            .success-page{min-height:calc(100vh - 62px);padding:38px 10px 70px}.success-card{padding:43px 18px 32px;border-radius:27px}.success-title{font-size:30px}.success-description{font-size:13px}.success-info{grid-template-columns:1fr}.info-card{display:flex;align-items:center;gap:12px;text-align:left}.info-icon{margin:0;font-size:21px}.shopping-btn{width:100%}.celebrate-banner{top:70px;font-size:10px;max-width:calc(100vw - 28px);overflow:hidden;text-overflow:ellipsis}}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important}}
    </style>
</head>

<body data-sb-theme="{{ $customerTheme }}" data-customer-theme="{{ $customerTheme }}">

    {{-- =========================================================
         SAME PREMIUM CUSTOMER TASKBAR
    ========================================================== --}}
    @auth
    @php
        $currentRoute = request()->route()?->getName();
        $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
    @endphp
    <nav class="sb-products-taskbar" id="sbProductsTaskbar" aria-label="Customer Navigation">
        <a href="{{ route('products.index') }}" class="sb-products-brand" aria-label="Smart Basket Products">
            <span class="sb-brand-mark"><i class="fa-solid fa-basket-shopping"></i></span>
            <span class="sb-brand-copy"><strong>SMART BASKET</strong><small>CUSTOMER PANEL</small></span>
        </a>
        <div class="sb-products-nav">
            @if(Route::has('products.index'))
                <a href="{{ route('products.index') }}" class="sb-pnav-btn {{ $currentRoute === 'products.index' ? 'is-active' : '' }}"><i class="fa-solid fa-store"></i><span>Products</span></a>
            @endif
            @if($ordersRoute)
                <a href="{{ route($ordersRoute) }}" class="sb-pnav-btn {{ $currentRoute === $ordersRoute ? 'is-active' : '' }}"><i class="fa-solid fa-box"></i><span>Orders</span></a>
            @endif
            @if(Route::has('cart.index'))
                <a href="{{ route('cart.index') }}" class="sb-pnav-btn {{ $currentRoute === 'cart.index' ? 'is-active' : '' }}"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>
            @endif
            @if(Route::has('wishlist'))
                <a href="{{ route('wishlist') }}" class="sb-pnav-btn {{ $currentRoute === 'wishlist' ? 'is-active' : '' }}"><i class="fa-regular fa-heart"></i><span>Wishlist</span></a>
            @endif
            @if(Route::has('profile'))
                <a href="{{ route('profile') }}" class="sb-pnav-btn {{ $currentRoute === 'profile' ? 'is-active' : '' }}"><i class="fa-regular fa-user"></i><span>Profile</span></a>
            @endif
            @if(Route::has('settings'))
                <a href="{{ route('settings') }}" class="sb-pnav-btn {{ $currentRoute === 'settings' ? 'is-active' : '' }}"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
            @endif
            <button type="button" class="sb-pnav-btn sb-pnav-aihub" id="sbProductsAIHub" data-sb-ai-hub-open title="Open AI Hub"><i class="fa-solid fa-wand-magic-sparkles"></i><span>AI HUB</span></button>
            <button type="button" class="sb-pnav-btn sb-pnav-smart-ai" id="sbProductsSmartAI" title="Open Smart AI"><span class="sb-smart-orb"><i class="fa-solid fa-robot"></i></span><span>Smart AI</span><b class="sb-online-dot"></b></button>
        </div>
        <div class="sb-taskbar-user"><span class="sb-user-dot"><i class="fa-regular fa-user"></i></span><span class="sb-user-text"><small>Hi,</small><strong>{{ auth()->user()->name ?? 'Customer' }}</strong></span></div>
        <button type="button" class="sb-products-more" id="sbProductsMore" aria-expanded="false" aria-controls="sbProductsMoreMenu" title="More options"><i class="fa-solid fa-ellipsis-vertical"></i></button>
    </nav>
    <div class="sb-products-more-menu" id="sbProductsMoreMenu" aria-hidden="true">
        <div class="sb-more-heading"><span>SMART BASKET</span><small>More options</small></div>
        @if(Route::has('products.index'))<a href="{{ route('products.index') }}" class="sb-more-link"><i class="fa-solid fa-house"></i><span>Products Home</span></a>@endif
        @if($ordersRoute)<a href="{{ route($ordersRoute) }}" class="sb-more-link"><i class="fa-solid fa-box"></i><span>My Orders</span></a>@endif
        @if(Route::has('cart.index'))<a href="{{ route('cart.index') }}" class="sb-more-link"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>@endif
        @if(Route::has('wishlist'))<a href="{{ route('wishlist') }}" class="sb-more-link"><i class="fa-regular fa-heart"></i><span>Wishlist</span></a>@endif
        @if(Route::has('profile'))<a href="{{ route('profile') }}" class="sb-more-link"><i class="fa-regular fa-user"></i><span>Profile</span></a>@endif
        @if(Route::has('settings'))<a href="{{ route('settings') }}" class="sb-more-link"><i class="fa-solid fa-gear"></i><span>Settings</span></a>@endif
        <div class="sb-more-separator"></div>
        <div class="sb-more-title"><i class="fa-solid fa-palette"></i><span>Theme</span></div>
        <div class="sb-theme-switcher"><button type="button" class="sb-theme-choice" data-sb-set-theme="light"><i class="fa-solid fa-sun"></i><span>Light</span></button><button type="button" class="sb-theme-choice" data-sb-set-theme="dark"><i class="fa-solid fa-moon"></i><span>Dark</span></button></div>
        <div class="sb-more-separator"></div>
        <button type="button" class="sb-more-link sb-more-action" data-sb-more-aihub><i class="fa-solid fa-wand-magic-sparkles"></i><span>Open AI HUB</span></button>
        <button type="button" class="sb-more-link sb-more-action" data-sb-more-smart-ai><i class="fa-solid fa-robot"></i><span>Open Smart AI</span></button>
        @if(Route::has('logout'))
            <div class="sb-more-separator"></div>
            <form method="POST" action="{{ route('logout') }}" class="sb-logout-form">@csrf<button type="submit" class="sb-more-link sb-logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button></form>
        @endif
    </div>
    @endauth

    {{-- =========================================================
         CELEBRATION LAYER
    ========================================================== --}}
    <div class="celebration-layer" id="celebrationLayer" aria-hidden="true"></div>
    <div class="celebrate-banner"><i class="fa-solid fa-party-horn"></i> Order celebration activated • Thank you for shopping!</div>

    <main class="success-page">
        <div class="success-container">
            <div class="success-brand"><div class="brand-icon"><i class="fa-solid fa-basket-shopping"></i></div>SMART BASKET</div>

            <section class="success-card" aria-label="Order placed successfully">
                <div class="success-icon-wrapper"><div class="success-icon"><i class="fa-solid fa-check"></i></div></div>

                <h1 class="success-title">Order <span>Placed Successfully!</span></h1>
                <p class="success-description">Thank you for shopping with <strong>SMART BASKET</strong>. Your order has been received successfully and will be processed shortly.</p>

                <div class="status-pill"><span class="status-dot"></span><span>Order Received</span></div>

                <div class="success-info">
                    <div class="info-card"><div class="info-icon">📦</div><div><div class="info-title">Order Confirmed</div><div class="info-text">Your order is being processed</div></div></div>
                    <div class="info-card"><div class="info-icon">🚚</div><div><div class="info-title">Fast Delivery</div><div class="info-text">We'll keep you updated</div></div></div>
                    <div class="info-card"><div class="info-icon">🔒</div><div><div class="info-title">Secure Order</div><div class="info-text">Your information is protected</div></div></div>
                </div>

                <a href="{{ route('products.index') }}" class="shopping-btn"><span>🛍️</span><span>Continue Shopping</span><span class="arrow">→</span></a>

                <div class="security-row">
                    <span><i class="fa-solid fa-lock"></i> Secure</span>
                    <span><i class="fa-solid fa-shield-halved"></i> Protected</span>
                    <span><i class="fa-solid fa-bolt"></i> SMART BASKET</span>
                </div>
            </section>
        </div>
    </main>

    <div class="sb-products-smart-ai-host" aria-hidden="false"><x-smart-ai-robot /></div>
    <x-ai-hub-sidebar :without-menu="true" />

    <script>
    (function(){
        'use strict';
        if(window.__SBProductsPremiumTaskbar) return;
        window.__SBProductsPremiumTaskbar=true;
        const more=document.getElementById('sbProductsMore');
        const menu=document.getElementById('sbProductsMoreMenu');
        const aiHubBtn=document.getElementById('sbProductsAIHub');
        const smartAiBtn=document.getElementById('sbProductsSmartAI');
        function closeMore(){if(menu){menu.classList.remove('is-open');menu.setAttribute('aria-hidden','true')}if(more)more.setAttribute('aria-expanded','false')}
        function openMore(){if(menu){menu.classList.add('is-open');menu.setAttribute('aria-hidden','false')}if(more)more.setAttribute('aria-expanded','true')}
        if(more)more.addEventListener('click',function(e){e.preventDefault();e.stopPropagation();menu&&menu.classList.contains('is-open')?closeMore():openMore()});
        document.addEventListener('click',function(e){if(menu&&more&&!menu.contains(e.target)&&!more.contains(e.target))closeMore()});
        document.addEventListener('keydown',function(e){if(e.key==='Escape')closeMore()});
        function openHub(){const trigger=document.querySelector('[data-ai-hub-open]');if(trigger)trigger.click();closeMore()}
        function openRobot(){const trigger=document.querySelector('[data-smart-ai-open]');if(trigger)trigger.click();closeMore()}
        if(aiHubBtn)aiHubBtn.addEventListener('click',openHub);if(smartAiBtn)smartAiBtn.addEventListener('click',openRobot);
        document.querySelectorAll('[data-sb-more-aihub]').forEach(b=>b.addEventListener('click',openHub));document.querySelectorAll('[data-sb-more-smart-ai]').forEach(b=>b.addEventListener('click',openRobot));
        function setTheme(theme){if(!['light','dark'].includes(theme))return;localStorage.setItem('sb-theme',theme);document.documentElement.setAttribute('data-theme',theme);document.documentElement.setAttribute('data-sb-theme',theme);document.body.setAttribute('data-sb-theme',theme);window.SB_THEME=theme;try{window.dispatchEvent(new CustomEvent('sb-theme-changed',{detail:{theme:theme}}))}catch(e){}try{window.dispatchEvent(new CustomEvent('smartbasket-theme-changed',{detail:{theme:theme}}))}catch(e){}updateThemeButtons(theme)}
        function updateThemeButtons(theme){document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.classList.toggle('is-selected',btn.getAttribute('data-sb-set-theme')===theme)})}
        document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.addEventListener('click',function(){setTheme(btn.getAttribute('data-sb-set-theme'))})});
        updateThemeButtons(document.documentElement.getAttribute('data-theme')||localStorage.getItem('sb-theme')||'dark');
    })();
    </script>

    <script>
    (function(){
        'use strict';
        const body=document.body;
        const savedTheme=body.dataset.customerTheme||'system';
        function getSystemTheme(){return window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'}
        function applyTheme(theme){const finalTheme=theme==='system'?getSystemTheme():theme;document.documentElement.setAttribute('data-theme',finalTheme);document.documentElement.setAttribute('data-sb-theme',finalTheme);body.setAttribute('data-sb-theme',finalTheme)}
        applyTheme(savedTheme);
        const media=window.matchMedia('(prefers-color-scheme: dark)');
        function handleThemeChange(){if(body.dataset.customerTheme==='system')applyTheme('system')}
        if(media.addEventListener)media.addEventListener('change',handleThemeChange);else if(media.addListener)media.addListener(handleThemeChange);
    })();
    </script>

    <script>
    (function(){
        'use strict';
        const layer=document.getElementById('celebrationLayer');
        if(!layer)return;
        const reduce=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if(reduce)return;
        const emojis=['🎉','🎊','🎈','✨','🎉','🎈','🎊','⭐','🥳'];
        function rand(min,max){return Math.random()*(max-min)+min}
        function createPiece(index){
            const el=document.createElement('span');el.className='celebrate-piece';el.textContent=emojis[index%emojis.length];
            const x0=rand(-48,48)+'vw',x1=rand(-58,58)+'vw',x2=rand(-70,70)+'vw';
            el.style.setProperty('--x0',x0);el.style.setProperty('--x1',x1);el.style.setProperty('--x2',x2);el.style.setProperty('--dur',rand(4.2,6.8)+'s');el.style.setProperty('--delay',rand(0,.7)+'s');el.style.left=rand(3,97)+'%';el.style.fontSize=rand(16,29)+'px';
            layer.appendChild(el);el.addEventListener('animationend',()=>el.remove(),{once:true});
        }
        function burst(){
            const wrap=document.createElement('div');wrap.className='celebrate-burst';
            ['🎉','🎊','🎈','✨','🥳','🎉','🎊','✨'].forEach((emoji,i)=>{const e=document.createElement('i');e.textContent=emoji;e.style.setProperty('--r',(i*45)+'deg');e.style.setProperty('--dx',(Math.cos(i*Math.PI/4)*rand(90,175))+'px');e.style.setProperty('--dy',(Math.sin(i*Math.PI/4)*rand(70,145))+'px');e.style.setProperty('--d',(i*.025)+'s');wrap.appendChild(e)});
            layer.appendChild(wrap);wrap.addEventListener('animationend',()=>wrap.remove(),{once:true});
        }
        for(let i=0;i<34;i++)setTimeout(()=>createPiece(i),i*28);
        setTimeout(burst,350);setTimeout(burst,1050);setTimeout(burst,1900);
        setTimeout(()=>{for(let i=0;i<20;i++)setTimeout(()=>createPiece(i+4),i*40)},2300);
        window.setTimeout(burst,4300);
    })();
    </script>
</body>
</html>

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


















        .ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}




        /* =========================================================
           PREMIUM SUCCESS EXPERIENCE
        ========================================================= */
        .success-page{position:relative;min-height:calc(100vh - 76px);display:flex;align-items:center;justify-content:center;padding:54px 18px 90px;isolation:isolate}
        .success-container{width:100%;max-width:none;position:relative;z-index:3}
        .success-brand{display:flex;align-items:center;justify-content:center;gap:10px;margin:0 0 18px;color:var(--success-heading);font-size:18px;font-weight:950;letter-spacing:.2px;text-shadow:0 5px 25px rgba(37,99,235,.12)}
        .brand-icon{width:42px;height:42px;display:grid;place-items:center;border-radius:14px;color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);box-shadow:0 12px 32px rgba(37,99,235,.30),inset 0 1px rgba(255,255,255,.3);font-size:17px;animation:brandPulse 2.5s ease-in-out infinite}@keyframes brandPulse{50%{transform:translateY(-3px) rotate(-2deg)}}
        .success-card{width:100%;max-width:820px;margin-inline:auto;position:relative;overflow:hidden;padding:52px 48px 40px;text-align:center;border:1px solid var(--success-border);border-radius:36px;background:linear-gradient(145deg,var(--success-card),rgba(255,255,255,.52));box-shadow:var(--success-shadow);backdrop-filter:blur(28px) saturate(135%);-webkit-backdrop-filter:blur(28px);animation:cardAppear .7s cubic-bezier(.2,.8,.2,1);}
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
        .bill-list{display:grid;gap:18px;width:min(100%,920px);margin:24px auto 0;text-align:left}
        .bill-card{overflow:hidden;border:1px solid var(--success-border);border-radius:24px;background:var(--success-card);box-shadow:var(--success-shadow);backdrop-filter:blur(24px);animation:cardAppear .6s ease both}
        .bill-head{display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:12px;padding:20px 23px;border-bottom:1px solid var(--success-border);background:linear-gradient(120deg,rgba(37,99,235,.08),rgba(124,58,237,.06))}
        .bill-title{margin:0;color:var(--success-heading);font-size:17px;font-weight:950}.bill-seller{margin-top:4px;color:var(--success-muted);font-size:12px}
        .bill-order-tag{padding:7px 11px;border:1px solid var(--success-border);border-radius:999px;color:var(--success-blue);font-size:11px;font-weight:900}
        .bill-items{display:grid;gap:0;padding:6px 22px}.bill-item{display:grid;grid-template-columns:68px minmax(0,1fr) auto;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid var(--success-border)}.bill-item:last-child{border-bottom:0}
        .bill-image{width:68px;height:68px;object-fit:cover;border:1px solid var(--success-border);border-radius:15px;background:var(--success-surface)}
        .bill-image-placeholder{display:grid;place-items:center;color:var(--success-muted);font-size:20px}.bill-product-name{color:var(--success-heading);font-size:13px;font-weight:900}.bill-product-meta,.bill-line-total{margin-top:4px;color:var(--success-muted);font-size:11px}.bill-line-total{color:var(--success-heading);font-weight:850}
        .bill-meta{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;padding:0 22px 19px}.bill-meta-item{min-width:0;padding:12px;border:1px solid var(--success-border);border-radius:13px;background:var(--success-surface)}.bill-meta-label{display:block;margin-bottom:4px;color:var(--success-muted);font-size:9px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}.bill-meta-value{display:block;overflow-wrap:anywhere;color:var(--success-heading);font-size:11px;font-weight:850}
        .bill-total{display:flex;justify-content:space-between;gap:12px;padding:14px 22px;border-top:1px solid var(--success-border);color:var(--success-heading);font-size:13px;font-weight:950}
        .bill-delivery-status{display:flex;align-items:flex-start;gap:11px;margin:0 22px 14px;padding:13px;border:1px solid var(--success-border);border-radius:13px;background:var(--success-surface);color:var(--success-muted);font-size:10px;line-height:1.6}.bill-delivery-status i{margin-top:2px;font-size:16px}.bill-delivery-status strong{display:block;margin-bottom:2px;color:var(--success-heading);font-size:11px}.bill-delivery-status[data-status="sent"]{border-color:rgba(34,197,94,.28);background:rgba(34,197,94,.08);color:var(--success-green)}.bill-actions{display:flex;flex-wrap:wrap;gap:10px;padding:0 22px 18px}.bill-download{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:45px;padding:0 16px;border:1px solid rgba(255,255,255,.18);border-radius:13px;background:linear-gradient(120deg,#176b5b,#2361d4 58%,#6846c7);box-shadow:0 9px 22px rgba(37,99,235,.2);color:#fff!important;font-size:11px;font-weight:900;text-decoration:none!important}
        .bill-hint{padding:0 22px 18px;color:var(--success-muted);font-size:10px;line-height:1.6}
        @media(max-width:700px){.bill-head{padding:16px}.bill-items{padding:4px 15px}.bill-item{grid-template-columns:55px minmax(0,1fr);gap:11px}.bill-image{width:55px;height:55px;border-radius:12px}.bill-line-total{grid-column:2}.bill-meta{grid-template-columns:1fr;padding:0 15px 15px}.bill-total{padding:13px 15px}.bill-delivery-status{margin:0 15px 12px}.bill-actions{padding:0 15px 14px}.bill-download{width:100%}.bill-hint{padding:0 15px 15px}}
            </style>
    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
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
    <x-products-customer-taskbar :include-robot="false" />
    @endauth

    {{-- =========================================================
         CELEBRATION LAYER
    ========================================================== --}}
    <div class="celebration-layer" id="celebrationLayer" aria-hidden="true"></div>
    <div class="celebrate-banner"><i class="fa-solid fa-party-horn"></i> Order celebration activated • Thank you for shopping!</div>

    <main class="success-page">
        <div class="success-container">
            <div class="success-brand"><div class="brand-icon"><i class="fa-solid fa-basket-shopping"></i></div>SMART BASKET</div>

            <x-customer-page-hero title="Order Placed Successfully!" />

            <section class="success-card" aria-label="Order placed successfully">
                <div class="success-icon-wrapper"><div class="success-icon"><i class="fa-solid fa-check"></i></div></div>

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

            @if($receipts->isNotEmpty())
                <section class="bill-list" aria-label="Order bills and WhatsApp sharing">
                    @foreach($receipts as $receipt)
                        @php
                            $order = $receipt['order'];
                        @endphp
                        <article class="bill-card">
                            <header class="bill-head">
                                <div>
                                    <h2 class="bill-title"><i class="fa-solid fa-receipt me-2" aria-hidden="true"></i>Order bill</h2>
                                    <div class="bill-seller">{{ $receipt['seller_name'] }} &middot; Seller-specific bill</div>
                                </div>
                                <span class="bill-order-tag">ORDER #{{ $order->id }}</span>
                            </header>

                            <div class="bill-items">
                                @foreach($receipt['items'] as $item)
                                    <div class="bill-item">
                                        @if($item['image'])
                                            <img class="bill-image" src="{{ $item['image'] }}" alt="{{ $item['name'] }}" loading="lazy">
                                        @else
                                            <span class="bill-image bill-image-placeholder" aria-hidden="true"><i class="fa-solid fa-box"></i></span>
                                        @endif
                                        <div>
                                            <div class="bill-product-name">{{ $item['name'] }}</div>
                                            <div class="bill-product-meta">Qty {{ $item['quantity'] }} &middot; &#8377;{{ number_format($item['price'], 2) }} each</div>
                                        </div>
                                        <div class="bill-line-total">&#8377;{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bill-meta">
                                <div class="bill-meta-item"><span class="bill-meta-label">Customer</span><span class="bill-meta-value">{{ $order->name }}</span></div>
                                <div class="bill-meta-item"><span class="bill-meta-label">Customer mobile</span><span class="bill-meta-value">{{ $order->mobile }}</span></div>
                                <div class="bill-meta-item"><span class="bill-meta-label">Payment</span><span class="bill-meta-value">{{ $order->payment_method }} &middot; {{ $order->payment_status_label }}</span></div>
                                <div class="bill-meta-item"><span class="bill-meta-label">Transaction / reference ID</span><span class="bill-meta-value">{{ $receipt['transaction_id'] ?: 'Not available' }}</span></div>
                                <div class="bill-meta-item" style="grid-column:1/-1"><span class="bill-meta-label">Delivery address</span><span class="bill-meta-value">{{ $order->address }}@if($order->city), {{ $order->city }}@endif</span></div>
                            </div>

                            <div class="bill-total"><span>Order total</span><span>&#8377;{{ number_format((float) ($order->amount ?? $order->total), 2) }}</span></div>
                            <div class="bill-actions">
                                <a class="bill-download" href="{{ $receipt['receipt_url'] }}"><i class="fa-solid fa-file-pdf" aria-hidden="true"></i>Download PDF invoice</a>
                            </div>
                            <p class="bill-hint mb-0">COD bills are marked <strong>Cash on Delivery</strong>. Paid UPI or card invoices include the payment transaction reference.</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </div>
    </main>

    <div class="sb-products-smart-ai-host" aria-hidden="false"><x-smart-ai-robot /></div>
    <x-ai-hub-sidebar :without-menu="true" />



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

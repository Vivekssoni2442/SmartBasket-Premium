@php

    /*
    |--------------------------------------------------------------------------
    | SMART BASKET CUSTOMER THEME
    |--------------------------------------------------------------------------
    | Same theme source used by Track Order page.
    |
    | dark  = dark mode
    | light = light mode
    | system = browser system theme
    |--------------------------------------------------------------------------
    */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';

    /*
    |--------------------------------------------------------------------------
    | Normalize theme value
    |--------------------------------------------------------------------------
    */

    if ($customerTheme === true || $customerTheme === 1 || $customerTheme === '1' || $customerTheme === 'true') {
        $customerTheme = 'dark';
    }

    if ($customerTheme === false || $customerTheme === 0 || $customerTheme === '0' || $customerTheme === 'false') {
        $customerTheme = 'light';
    }

    if (!in_array($customerTheme, ['dark', 'light', 'system'], true)) {
        $customerTheme = 'system';
    }

@endphp


<!DOCTYPE html>
<html
    lang="en"
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Orders | SMART BASKET</title>


    <!-- ==========================================================
         IMPORTANT:
         APPLY THEME BEFORE PAGE PAINT
         ========================================================== -->

    <script>

        (function () {

            const serverTheme =
                @json($customerTheme);


            function getSystemTheme() {

                return window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';

            }


            const finalTheme =
                serverTheme === 'system'
                    ? getSystemTheme()
                    : serverTheme;


            /*
            |--------------------------------------------------------------------------
            | Apply BEFORE CSS/page renders
            |--------------------------------------------------------------------------
            */

            document.documentElement.setAttribute(
                'data-sb-theme',
                finalTheme
            );


            document.documentElement.setAttribute(
                'data-bs-theme',
                finalTheme
            );


            document.documentElement.classList.remove(
                'dark',
                'light'
            );


            document.documentElement.classList.add(
                finalTheme
            );


            /*
            |--------------------------------------------------------------------------
            | Save current theme for other Smart Basket pages
            |--------------------------------------------------------------------------
            */

            try {

                localStorage.setItem(
                    'smartbasket-theme',
                    finalTheme
                );

            } catch (e) {}

        })();

    </script>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        /* ==========================================================
           SMART BASKET - MY ORDERS THEME
        ========================================================== */

        :root {

            --sb-bg: #f4f7fb;

            --sb-bg-secondary: #ffffff;

            --sb-card: rgba(255, 255, 255, 0.94);

            --sb-card-hover: #ffffff;

            --sb-surface: rgba(248, 250, 252, 0.95);

            --sb-text: #0f172a;

            --sb-heading: #020617;

            --sb-muted: #64748b;

            --sb-border: rgba(15, 23, 42, 0.09);

            --sb-border-strong: rgba(15, 23, 42, 0.16);

            --sb-primary: #2563eb;

            --sb-primary-hover: #1d4ed8;

            --sb-primary-soft: rgba(37, 99, 235, 0.08);

            --sb-success: #16a34a;

            --sb-success-soft: rgba(22, 163, 74, 0.09);

            --sb-danger: #dc2626;

            --sb-danger-soft: rgba(220, 38, 38, 0.08);

            --sb-shadow:
                0 20px 60px rgba(15, 23, 42, 0.10);

            --sb-image-bg: #e2e8f0;
        }


        /* ==========================================================
           DARK THEME
        ========================================================== */

        html[data-sb-theme="dark"] {

            --sb-bg: #020617;

            --sb-bg-secondary: #0f172a;

            --sb-card: rgba(15, 23, 42, 0.94);

            --sb-card-hover: #111c32;

            --sb-surface: rgba(30, 41, 59, 0.82);

            --sb-text: #e2e8f0;

            --sb-heading: #f8fafc;

            --sb-muted: #94a3b8;

            --sb-border: rgba(148, 163, 184, 0.14);

            --sb-border-strong: rgba(148, 163, 184, 0.25);

            --sb-primary: #3b82f6;

            --sb-primary-hover: #60a5fa;

            --sb-primary-soft: rgba(59, 130, 246, 0.14);

            --sb-success: #22c55e;

            --sb-success-soft: rgba(34, 197, 94, 0.11);

            --sb-danger: #ef4444;

            --sb-danger-soft: rgba(239, 68, 68, 0.11);

            --sb-shadow:
                0 30px 90px rgba(0, 0, 0, 0.50);

            --sb-image-bg: #1e293b;
        }


        /* ==========================================================
           GLOBAL
        ========================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        html {
            background: var(--sb-bg);
        }


        body {

            min-height: 100vh;

            margin: 0;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(37, 99, 235, 0.14),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 10%,
                    rgba(124, 58, 237, 0.10),
                    transparent 30%
                ),

                var(--sb-bg);

            transition:
                background 0.3s ease,
                color 0.3s ease;
        }


        /* ==========================================================
           DARK BODY
        ========================================================== */

        html[data-sb-theme="dark"] body {

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(59, 130, 246, 0.18),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 10%,
                    rgba(139, 92, 246, 0.15),
                    transparent 30%
                ),

                #020617;

            color: #e2e8f0;
        }


        /* ==========================================================
           PAGE
        ========================================================== */

        .orders-page {

            min-height: 100vh;

            padding:
                40px 18px 80px;
        }


        .orders-container {

            width: 100%;

            max-width:
                none;

            margin: 0 auto;
        }


        /* ==========================================================
           HEADER
        ========================================================== */

        .orders-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
        }


        .brand-label {

            color:
                var(--sb-primary);

            font-size:
                11px;

            font-weight:
                900;

            letter-spacing:
                1.8px;

            margin-bottom:
                7px;
        }


        .orders-title {

            margin:
                0 0 6px;

            color:
                var(--sb-heading);

            font-size:
                34px;

            line-height:
                1.15;

            font-weight:
                950;

            letter-spacing:
                -0.8px;
        }


        .orders-subtitle {

            margin: 0;

            color:
                var(--sb-muted);

            font-size:
                13px;
        }

        .orders-history-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 46px;
            margin-top: 14px;
            padding: 0 19px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 15px;
            background: linear-gradient(120deg,#142c61,#315bc7 58%,#6545bd);
            box-shadow: 0 10px 24px rgba(35,69,151,.2), inset 0 1px 0 rgba(255,255,255,.18);
            color: #fff !important;
            font-size: 12px;
            font-weight: 850;
            text-decoration: none;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .orders-history-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 28px rgba(35,69,151,.27), inset 0 1px 0 rgba(255,255,255,.22);
        }

        .orders-history-btn:focus-visible {
            outline: 3px solid #8adbd2;
            outline-offset: 3px;
        }


        /* ==========================================================
           CONTINUE SHOPPING
        ========================================================== */

        .continue-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            min-height:
                44px;

            padding:
                0 17px;

            border:
                1px solid
                var(--sb-border-strong);

            border-radius:
                12px;

            color:
                var(--sb-text);

            background:
                var(--sb-card);

            text-decoration:
                none;

            font-size:
                12px;

            font-weight:
                850;

            box-shadow:
                0 8px 25px
                rgba(15, 23, 42, 0.06);

            transition:
                all 0.22s ease;
        }


        .continue-btn:hover {

            color:
                var(--sb-primary);

            border-color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            transform:
                translateY(-2px);
        }


        /* ==========================================================
           SUCCESS
        ========================================================== */

        .theme-alert {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-bottom:
                20px;

            padding:
                14px 17px;

            border:
                1px solid
                rgba(34, 197, 94, 0.25);

            border-radius:
                14px;

            color:
                var(--sb-success);

            background:
                var(--sb-success-soft);

            font-size:
                13px;

            font-weight:
                800;
        }


        /* ==========================================================
           ORDER CARD
        ========================================================== */

        .order-card {

            margin-bottom:
                18px;

            padding:
                22px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                22px;

            background:
                var(--sb-card);

            color:
                var(--sb-text);

            box-shadow:
                var(--sb-shadow);

            backdrop-filter:
                blur(22px);

            -webkit-backdrop-filter:
                blur(22px);

            transition:
                background 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .order-card:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--sb-border-strong);

            background:
                var(--sb-card-hover);

            box-shadow:
                var(--sb-shadow);
        }


        /* ==========================================================
           ORDER HEADER
        ========================================================== */

        .order-number {

            color:
                var(--sb-heading);

            font-size:
                15px;

            font-weight:
                900;
        }


        .order-meta {

            color:
                var(--sb-muted);

            font-size:
                11px;
        }


        /* ==========================================================
           STATUS
        ========================================================== */

        .status-pill {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            min-height:
                30px;

            padding:
                5px 12px;

            border:
                1px solid
                rgba(59, 130, 246, 0.20);

            border-radius:
                999px;

            color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            font-size:
                10px;

            font-weight:
                900;

            text-transform:
                capitalize;
        }


        /* ==========================================================
           PRODUCT
        ========================================================== */

        .order-product {

            display: flex;

            align-items: center;

            gap: 15px;

            padding:
                14px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                17px;

            background:
                var(--sb-surface);

            transition:
                background 0.25s ease,
                border-color 0.25s ease;
        }


        .order-product:hover {

            border-color:
                var(--sb-border-strong);

            background:
                var(--sb-card-hover);
        }


        .order-product img {

            width:
                76px;

            height:
                76px;

            flex-shrink:
                0;

            object-fit:
                cover;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                13px;

            background:
                var(--sb-image-bg);
        }


        .product-name {

            margin-bottom:
                5px;

            color:
                var(--sb-heading);

            font-size:
                14px;

            font-weight:
                850;
        }


        /* ==========================================================
           FOOTER
        ========================================================== */

        .order-footer {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-top:
                5px;

            padding-top:
                18px;

            border-top:
                1px solid
                var(--sb-border);
        }


        .order-total {

            color:
                var(--sb-heading);

            font-size:
                15px;

            font-weight:
                900;
        }


        /* ==========================================================
           ACTIONS
        ========================================================== */

        .action-buttons {

            display: flex;

            align-items: center;

            gap: 8px;
        }


        /* ==========================================================
           TRACK BUTTON
        ========================================================== */

        .track-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            min-height:
                38px;

            padding:
                0 15px;

            border:
                0;

            border-radius:
                11px;

            color:
                #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            text-decoration:
                none;

            font-size:
                11px;

            font-weight:
                900;

            box-shadow:
                0 8px 22px
                rgba(37, 99, 235, 0.25);

            transition:
                all 0.22s ease;
        }


        html[data-sb-theme="dark"] .track-btn {

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #6366f1
                );

            box-shadow:
                0 10px 30px
                rgba(37, 99, 235, 0.40);
        }


        .track-btn:hover {

            color:
                #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #4338ca
                );

            transform:
                translateY(-2px);
        }


        /* ==========================================================
           CANCEL BUTTON
        ========================================================== */

        .cancel-btn {

            min-height:
                38px;

            padding:
                0 14px;

            border:
                1px solid
                var(--sb-danger);

            border-radius:
                11px;

            color:
                var(--sb-danger);

            background:
                var(--sb-danger-soft);

            font-size:
                11px;

            font-weight:
                900;

            transition:
                all 0.22s ease;
        }


        .cancel-btn:hover {

            color:
                #ffffff;

            background:
                var(--sb-danger);

            border-color:
                var(--sb-danger);

            transform:
                translateY(-1px);
        }


        /* ==========================================================
           EMPTY
        ========================================================== */

        .empty-card {

            text-align:
                center;

            padding:
                70px 25px;
        }


        .empty-icon {

            width:
                68px;

            height:
                68px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin:
                0 auto 18px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                18px;

            color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            font-size:
                26px;
        }


        .empty-title {

            margin-bottom:
                7px;

            color:
                var(--sb-heading);

            font-size:
                18px;

            font-weight:
                900;
        }


        .empty-text {

            margin:
                0;

            color:
                var(--sb-muted);

            font-size:
                12px;
        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 768px) {

            .orders-page {

                padding:
                    22px 12px 55px;
            }


            .orders-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .orders-title {

                font-size:
                    27px;
            }


            .continue-btn {

                width:
                    100%;
            }


            .order-card {

                padding:
                    16px;

                border-radius:
                    18px;
            }


            .order-footer {

                align-items:
                    stretch;

                flex-direction:
                    column;
            }


            .action-buttons {

                width:
                    100%;
            }


            .track-btn,
            .cancel-btn {

                flex:
                    1;
            }


            .order-product img {

                width:
                    64px;

                height:
                    64px;
            }


            .product-name {

                font-size:
                    13px;
            }

        }



        /* ==========================================================
           PRODUCTS PAGE — FULL WIDTH PREMIUM CUSTOMER TASKBAR
           Exact same taskbar styling used by Products page.
        ========================================================== */

/* =========================================================
   PRODUCTS PAGE — FULL WIDTH PREMIUM TASKBAR
========================================================= */
























/* AI HUB left button: existing project component remains the single left-side AI HUB launcher */
.ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}
html[data-theme="light"] .ai-hub-drawer{background:linear-gradient(145deg,rgba(255,255,255,.99),rgba(242,246,252,.99))!important;color:#101828!important;border-right-color:rgba(37,99,235,.14)!important;box-shadow:24px 0 70px rgba(15,23,42,.20)!important}
html[data-theme="light"] .ai-hub-drawer-header strong,html[data-theme="light"] .ai-hub-tool-text strong{color:#101828!important}html[data-theme="light"] .ai-hub-drawer-header small,html[data-theme="light"] .ai-hub-tool-text small{color:#667085!important}
html[data-theme="light"] .ai-hub-fab{background:linear-gradient(145deg,#fff,#eef4ff)!important;color:#172033!important;border-color:rgba(37,99,235,.25)!important}
html[data-theme="dark"] .ai-hub-drawer{background:linear-gradient(145deg,#09111f,#020711)!important}html[data-theme="dark"] .ai-hub-fab{background:linear-gradient(145deg,#1e293b,#050a14)!important}

/* Robot launcher is hidden; its original panel remains fully functional */







    </style>

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


@auth
{{-- =========================================================
     SMART BASKET — PRODUCTS PAGE PREMIUM CUSTOMER TASKBAR
     Core navigation is kept here so this page has ONE taskbar.
========================================================= --}}
@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
@endphp

<x-products-customer-taskbar :include-robot="false" />
@endauth



<main class="orders-page">

    <div class="orders-container">


        <!-- ======================================================
             HEADER
        ======================================================= -->

        <div class="orders-header">

            <div>



                <x-customer-page-hero>
<h1 class="orders-title sb-customer-page-title">
                    My Orders
                </h1>
</x-customer-page-hero>

                <p class="orders-subtitle">
                    Follow every order from checkout to delivery.
                </p>
                <a href="{{ route('returns.index') }}" class="orders-history-btn">
                    <i class="fa-solid fa-clock-rotate-left me-1" aria-hidden="true"></i> Returns &amp; cancellations
                </a>

            </div>




        </div>


        <!-- ======================================================
             SUCCESS
        ======================================================= -->

        @if(session('success'))

            <div class="theme-alert">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- ======================================================
             ORDERS
        ======================================================= -->

        @forelse($orders as $order)

            <article class="order-card">


                <!-- ORDER HEADER -->

                <div
                    class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3"
                >

                    <div>

                        <div class="order-number">

                            <i class="fa-solid fa-receipt me-2"></i>

                            Order #{{ $order->id }}

                        </div>

                        <span class="order-meta">

                            {{ $order->created_at?->format('d M Y, h:i A') }}

                        </span>

                    </div>


                    <span class="status-pill">

                        <i
                            class="fa-solid fa-circle"
                            style="font-size:6px;"
                        ></i>

                        {{
                            $order->deliveryDetail?->status
                            ?? $order->order_status
                            ?? 'Order Placed'
                        }}

                    </span>

                </div>


                <!-- PRODUCTS -->

                @foreach($order->items ?? [] as $item)

                    @php

                        $product =
                            $products[$item['product_id'] ?? null]
                            ?? null;

                    @endphp


                    <div class="order-product mb-3">


                        <img
                            src="{{
                                $product && $product->image
                                    ? asset(
                                        'products/' .
                                        $product->image
                                    )
                                    : 'https://placehold.co/160x160/1E293B/FFFFFF?text=Product'
                            }}"
                            alt="{{ $item['name'] ?? 'Product' }}"
                        >


                        <div class="flex-grow-1">

                            <div class="product-name">

                                {{
                                    $item['name']
                                    ?? $product?->name
                                    ?? 'Product'
                                }}

                            </div>


                            <div class="order-meta">

                                Quantity:
                                {{ $item['quantity'] ?? 1 }}

                                <span class="mx-1">·</span>

                                ₹{{ number_format(
                                    (float) ($item['price'] ?? 0),
                                    2
                                ) }}

                            </div>

                        </div>


                    </div>

                @endforeach


                <!-- ORDER FOOTER -->

                <div class="order-footer">


                    <div class="order-total">

                        Total:

                        ₹{{ number_format(
                            (float) ($order->amount ?? $order->total),
                            2
                        ) }}

                    </div>


                    <div class="action-buttons">


                        <a
                            href="{{ route('orders.show', $order) }}"
                            class="track-btn"
                        >

                            <i class="fa-solid fa-location-dot"></i>

                            Track Order

                        </a>


                        <a href="{{ route('returns.options', $order) }}" class="cancel-btn">
                            <i class="fa-solid fa-arrow-right-arrow-left me-1"></i>Return / Cancel
                        </a>


                    </div>

                </div>


            </article>

        @empty


            <div class="order-card empty-card">

                <div class="empty-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>

                <div class="empty-title">

                    No orders yet

                </div>

                <p class="empty-text">

                    Your placed orders will appear here.

                </p>

            </div>


        @endforelse


    </div>

</main>




{{-- =========================================================
     SMART BASKET AI COMPONENTS
     Existing AI HUB drawer remains on the left.
     Existing Smart AI panel remains functional.
========================================================= --}}

<div class="sb-products-smart-ai-host" aria-hidden="false">
    <x-smart-ai-robot />
</div>

<x-ai-hub-sidebar :without-menu="true" />

{{-- =========================================================
     PREMIUM CUSTOMER TASKBAR JAVASCRIPT
     Exact same 3-dots / AI HUB / Smart AI / theme behavior.
========================================================= --}}



<!-- ==========================================================
     FINAL THEME SYNC
     ========================================================== -->

<script>

(function () {

    const serverTheme =
        @json($customerTheme);


    function getSystemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    function applyTheme() {

        const theme =
            serverTheme === 'system'
                ? getSystemTheme()
                : serverTheme;


        document.documentElement.setAttribute(
            'data-sb-theme',
            theme
        );


        document.documentElement.setAttribute(
            'data-bs-theme',
            theme
        );


        document.body.setAttribute(
            'data-sb-theme',
            theme
        );


        document.body.setAttribute(
            'data-customer-theme',
            serverTheme
        );


        document.documentElement.classList.remove(
            'dark',
            'light'
        );


        document.body.classList.remove(
            'dark',
            'light'
        );


        document.documentElement.classList.add(theme);

        document.body.classList.add(theme);

    }


    applyTheme();


    /*
    |--------------------------------------------------------------------------
    | System theme change
    |--------------------------------------------------------------------------
    */

    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    if (media.addEventListener) {

        media.addEventListener(
            'change',
            function () {

                if (serverTheme === 'system') {

                    applyTheme();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Cross-tab Smart Basket theme change
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key === 'smartbasket-theme'
                ||
                event.key === 'theme'
                ||
                event.key === 'appearance'
                ||
                event.key === 'darkMode'
            ) {

                /*
                IMPORTANT:
                Server setting remains authoritative
                on next page load.
                */

                applyTheme();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Custom Smart Basket event
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'smartbasket-theme-changed',
        function () {

            applyTheme();

        }
    );


})();

</script>

</body>

</html>

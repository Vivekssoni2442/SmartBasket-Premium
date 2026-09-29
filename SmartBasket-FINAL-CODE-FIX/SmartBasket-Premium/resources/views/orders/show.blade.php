<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Order #{{ $order->id }} | SMART BASKET
    </title>

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
           SMART BASKET
           PREMIUM THEME SYSTEM
        ========================================================== */

        :root {

            --order-bg: #f5f8fc;

            --order-bg-secondary: #eef3f9;

            --order-card: #ffffff;

            --order-surface: #f8fafc;

            --order-text: #334155;

            --order-heading: #0f172a;

            --order-muted: #64748b;

            --order-border: rgba(15,23,42,.09);

            --order-border-strong: rgba(37,99,235,.18);

            --order-primary: #2563eb;

            --order-primary-hover: #1d4ed8;

            --order-primary-soft: rgba(37,99,235,.08);

            --order-purple: #6366f1;

            --order-success: #16a34a;

            --order-warning: #f59e0b;

            --order-danger: #dc2626;

            --order-shadow:
                0 20px 60px rgba(15,23,42,.09);

            --order-header-shadow:
                0 25px 75px rgba(15,23,42,.11);
        }


        /* ==========================================================
           PREMIUM DARK BLUE THEME
        ========================================================== */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --order-bg: #050b18;

            --order-bg-secondary: #081120;

            --order-card: #0b1426;

            --order-surface: #101d33;

            --order-text: #cbd5e1;

            --order-heading: #f8fbff;

            --order-muted: #94a3b8;

            --order-border:
                rgba(96,165,250,.15);

            --order-border-strong:
                rgba(59,130,246,.35);

            --order-primary: #3b82f6;

            --order-primary-hover: #60a5fa;

            --order-primary-soft:
                rgba(59,130,246,.12);

            --order-purple: #6366f1;

            --order-success: #22c55e;

            --order-warning: #f59e0b;

            --order-danger: #ef4444;

            --order-shadow:
                0 25px 80px rgba(0,0,0,.52);

            --order-header-shadow:
                0 30px 90px rgba(0,0,0,.60);
        }


        /* ==========================================================
           RESET
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


        /* ==========================================================
           BODY
        ========================================================== */

        body {

            color:
                var(--order-text);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                var(--order-bg);

            transition:
                background .3s ease,
                color .3s ease;
        }


        /* ==========================================================
           LIGHT BACKGROUND
        ========================================================== */

        html[data-sb-theme="light"] body,
        body[data-sb-theme="light"] {

            background:

                radial-gradient(
                    circle at 5% 0%,
                    rgba(37,99,235,.10),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 5%,
                    rgba(99,102,241,.08),
                    transparent 30%
                ),

                var(--order-bg);
        }


        /* ==========================================================
           DARK BACKGROUND
        ========================================================== */

        html[data-sb-theme="dark"] body,
        body[data-sb-theme="dark"] {

            background:

                radial-gradient(
                    circle at 8% 0%,
                    rgba(37,99,235,.20),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 92% 8%,
                    rgba(59,130,246,.11),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(30,64,175,.08),
                    transparent 35%
                ),

                #050b18;
        }


        /* ==========================================================
           PAGE
        ========================================================== */

        .order-page {

            min-height: 100vh;

            padding:
                35px 15px 80px;

            background:
                transparent;
        }


        .order-container {

            max-width:
                1180px;

            margin:
                auto;
        }


        /* ==========================================================
           TOP BAR
        ========================================================== */

        .order-topbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 25px;
        }


        /* ==========================================================
           BACK BUTTON
        ========================================================== */

        .back-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding:
                10px 16px;

            border:
                1px solid
                var(--order-border);

            border-radius:
                12px;

            color:
                var(--order-text);

            background:
                var(--order-card);

            text-decoration:
                none;

            font-size:
                13px;

            font-weight:
                800;

            box-shadow:
                0 10px 30px
                rgba(15,23,42,.07);

            transition:
                all .22s ease;
        }


        .back-btn:hover {

            color:
                var(--order-primary);

            background:
                var(--order-primary-soft);

            border-color:
                var(--order-primary);

            transform:
                translateY(-2px);
        }


        /* ==========================================================
           SECURE PILL
        ========================================================== */

        .secure-pill {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding:
                9px 14px;

            border-radius:
                999px;

            color:
                var(--order-success);

            background:
                rgba(34,197,94,.08);

            border:
                1px solid
                rgba(34,197,94,.18);

            font-size:
                11px;

            font-weight:
                850;
        }


        /* ==========================================================
           ORDER HEADER
        ========================================================== */

        .order-header {

            position:
                relative;

            overflow:
                hidden;

            padding:
                30px;

            margin-bottom:
                25px;

            border:
                1px solid
                var(--order-border);

            border-radius:
                25px;

            background:
                var(--order-card);

            box-shadow:
                var(--order-header-shadow);

            backdrop-filter:
                blur(25px);

            transition:
                all .3s ease;
        }


        .order-header::before {

            content: "";

            position:
                absolute;

            top:
                0;

            left:
                0;

            right:
                0;

            height:
                3px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #3b82f6,
                    #6366f1
                );
        }


        .order-label {

            color:
                var(--order-primary);

            font-size:
                11px;

            font-weight:
                850;

            text-transform:
                uppercase;

            letter-spacing:
                1.4px;
        }


        .order-title {

            margin:
                6px 0 5px;

            color:
                var(--order-heading);

            font-size:
                31px;

            font-weight:
                950;

            letter-spacing:
                -.8px;
        }


        .order-date {

            color:
                var(--order-muted);

            font-size:
                13px;
        }


        /* ==========================================================
           STATUS
        ========================================================== */

        .order-status {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            margin-top:
                15px;

            padding:
                9px 15px;

            border-radius:
                999px;

            color:
                var(--order-primary);

            background:
                var(--order-primary-soft);

            border:
                1px solid
                var(--order-border-strong);

            font-size:
                12px;

            font-weight:
                850;
        }


        .status-dot {

            width:
                7px;

            height:
                7px;

            border-radius:
                50%;

            background:
                currentColor;

            box-shadow:
                0 0 0 4px
                rgba(59,130,246,.12);
        }


        /* ==========================================================
           PREMIUM CARD
        ========================================================== */

        .premium-card {

            overflow:
                hidden;

            border:
                1px solid
                var(--order-border);

            border-radius:
                24px;

            background:
                var(--order-card);

            box-shadow:
                var(--order-shadow);

            backdrop-filter:
                blur(22px);

            transition:
                border-color .25s ease,
                box-shadow .25s ease,
                transform .25s ease;
        }


        .premium-card:hover {

            border-color:
                var(--order-border-strong);

            box-shadow:
                var(--order-header-shadow);
        }


        /* ==========================================================
           CARD HEADER
        ========================================================== */

        .card-header-premium {

            padding:
                20px 22px;

            border-bottom:
                1px solid
                var(--order-border);

            background:
                var(--order-surface);
        }


        .card-title {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            margin:
                0;

            color:
                var(--order-heading);

            font-size:
                16px;

            font-weight:
                900;
        }


        .card-icon {

            width:
                36px;

            height:
                36px;

            display:
                grid;

            place-items:
                center;

            border-radius:
                11px;

            color:
                #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 9px 25px
                rgba(37,99,235,.28);

            font-size:
                14px;
        }


        .card-body-premium {

            padding:
                22px;
        }


        /* ==========================================================
           PRODUCT
        ========================================================== */

        .product-row {

            display:
                flex;

            align-items:
                center;

            gap:
                15px;

            padding:
                14px;

            margin-bottom:
                12px;

            border:
                1px solid
                var(--order-border);

            border-radius:
                17px;

            background:
                var(--order-surface);

            transition:
                all .22s ease;
        }


        .product-row:last-child {

            margin-bottom:
                0;
        }


        .product-row:hover {

            transform:
                translateX(3px);

            border-color:
                var(--order-border-strong);

            background:
                var(--order-primary-soft);
        }


        .product-image {

            width:
                75px;

            height:
                75px;

            flex-shrink:
                0;

            object-fit:
                cover;

            border-radius:
                14px;

            border:
                1px solid
                var(--order-border);

            background:
                var(--order-bg-secondary);
        }


        .product-info {

            flex:
                1;
        }


        .product-name {

            margin-bottom:
                5px;

            color:
                var(--order-heading);

            font-size:
                14px;

            font-weight:
                850;
        }


        .product-meta {

            color:
                var(--order-muted);

            font-size:
                12px;

            line-height:
                1.6;
        }


        .product-total {

            color:
                var(--order-primary);

            font-size:
                14px;

            font-weight:
                900;

            white-space:
                nowrap;
        }


        /* ==========================================================
           TOTAL
        ========================================================== */

        .total-box {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            margin-top:
                18px;

            padding:
                18px;

            border:
                1px solid
                var(--order-border-strong);

            border-radius:
                17px;

            background:
                linear-gradient(
                    135deg,
                    var(--order-primary-soft),
                    rgba(99,102,241,.06)
                );
        }


        .total-label {

            color:
                var(--order-primary);

            font-size:
                11px;

            font-weight:
                800;

            letter-spacing:
                .6px;
        }


        .total-amount {

            color:
                var(--order-heading);

            font-size:
                23px;

            font-weight:
                950;
        }


        /* ==========================================================
           DETAIL ROW
        ========================================================== */

        .detail-row {

            display:
                flex;

            align-items:
                flex-start;

            gap:
                12px;

            padding:
                13px 0;

            border-bottom:
                1px solid
                var(--order-border);
        }


        .detail-row:last-child {

            border-bottom:
                0;

            padding-bottom:
                0;
        }


        .detail-icon {

            width:
                35px;

            height:
                35px;

            flex-shrink:
                0;

            display:
                grid;

            place-items:
                center;

            border-radius:
                10px;

            color:
                var(--order-primary);

            background:
                var(--order-primary-soft);

            border:
                1px solid
                var(--order-border);

            font-size:
                13px;
        }


        .detail-label {

            color:
                var(--order-muted);

            font-size:
                10px;

            font-weight:
                800;

            text-transform:
                uppercase;

            letter-spacing:
                .5px;
        }


        .detail-value {

            margin-top:
                3px;

            color:
                var(--order-heading);

            font-size:
                13px;

            font-weight:
                750;
        }


        /* ==========================================================
           DELIVERY PARTNER
        ========================================================== */

        .partner-box {

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

            padding:
                15px;

            border:
                1px solid
                var(--order-border);

            border-radius:
                17px;

            background:
                var(--order-surface);
        }


        .partner-image {

            width:
                62px;

            height:
                62px;

            object-fit:
                cover;

            border-radius:
                15px;

            border:
                1px solid
                var(--order-border);

            background:
                var(--order-bg-secondary);
        }


        .partner-name {

            color:
                var(--order-heading);

            font-size:
                14px;

            font-weight:
                900;
        }


        .partner-meta {

            margin-top:
                4px;

            color:
                var(--order-muted);

            font-size:
                11px;
        }


        /* ==========================================================
           LOCATION
        ========================================================== */

        .tracking-location {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

            margin-bottom:
                25px;

            padding:
                16px;

            border:
                1px solid
                var(--order-border-strong);

            border-radius:
                17px;

            background:
                var(--order-primary-soft);
        }


        .location-icon {

            width:
                43px;

            height:
                43px;

            display:
                grid;

            place-items:
                center;

            flex-shrink:
                0;

            border-radius:
                13px;

            color:
                #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 10px 28px
                rgba(37,99,235,.30);
        }


        .location-label {

            color:
                var(--order-muted);

            font-size:
                10px;

            font-weight:
                800;

            text-transform:
                uppercase;
        }


        .location-value {

            margin-top:
                3px;

            color:
                var(--order-heading);

            font-size:
                13px;

            font-weight:
                850;
        }


        /* ==========================================================
           TIMELINE
        ========================================================== */

        .timeline {

            position:
                relative;

            margin:
                0;

            padding:
                5px 0 5px 35px;

            list-style:
                none;
        }


        .timeline::before {

            content:
                "";

            position:
                absolute;

            left:
                10px;

            top:
                13px;

            bottom:
                13px;

            width:
                2px;

            background:
                var(--order-border);
        }


        .timeline-item {

            position:
                relative;

            min-height:
                50px;

            padding:
                2px 0 22px;
        }


        .timeline-item:last-child {

            padding-bottom:
                0;
        }


        .timeline-dot {

            position:
                absolute;

            left:
                -31px;

            top:
                2px;

            width:
                22px;

            height:
                22px;

            display:
                grid;

            place-items:
                center;

            border-radius:
                50%;

            color:
                var(--order-muted);

            background:
                var(--order-card);

            border:
                2px solid
                var(--order-border);

            font-size:
                8px;

            z-index:
                2;
        }


        .timeline-item.active
        .timeline-dot {

            color:
                #ffffff;

            background:
                var(--order-primary);

            border-color:
                var(--order-primary);

            box-shadow:
                0 0 0 5px
                rgba(59,130,246,.14);
        }


        .timeline-name {

            color:
                var(--order-muted);

            font-size:
                12px;

            font-weight:
                700;
        }


        .timeline-item.active
        .timeline-name {

            color:
                var(--order-heading);

            font-weight:
                900;
        }


        /* ==========================================================
           CANCEL
        ========================================================== */

        .cancel-box {

            margin-top:
                18px;

            padding:
                18px;

            border:
                1px solid
                rgba(220,38,38,.18);

            border-radius:
                17px;

            background:
                rgba(220,38,38,.05);
        }


        .cancel-title {

            color:
                var(--order-heading);

            font-size:
                13px;

            font-weight:
                850;
        }


        .cancel-description {

            margin-top:
                4px;

            color:
                var(--order-muted);

            font-size:
                11px;
        }


        .cancel-btn {

            margin-top:
                12px;

            border:
                1px solid
                rgba(220,38,38,.28);

            border-radius:
                11px;

            color:
                var(--order-danger);

            background:
                transparent;

            padding:
                9px 13px;

            font-size:
                11px;

            font-weight:
                850;

            transition:
                all .2s ease;
        }


        .cancel-btn:hover {

            color:
                #ffffff;

            background:
                var(--order-danger);

            border-color:
                var(--order-danger);

            transform:
                translateY(-1px);
        }


        /* ==========================================================
           MUTED
        ========================================================== */

        .muted-text {

            color:
                var(--order-muted);

            font-size:
                12px;
        }


        /* ==========================================================
           BOOTSTRAP DARK OVERRIDES
        ========================================================== */

        html[data-sb-theme="dark"] .text-dark,
        body[data-sb-theme="dark"] .text-dark {

            color:
                var(--order-heading) !important;
        }


        html[data-sb-theme="dark"] .bg-white,
        body[data-sb-theme="dark"] .bg-white {

            background:
                var(--order-card) !important;
        }


        html[data-sb-theme="dark"] .border,
        body[data-sb-theme="dark"] .border {

            border-color:
                var(--order-border) !important;
        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 767px) {

            .order-page {

                padding:
                    20px 10px 60px;
            }


            .order-topbar {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .secure-pill {

                align-self:
                    flex-start;
            }


            .order-header {

                padding:
                    23px 18px;

                border-radius:
                    21px;
            }


            .order-title {

                font-size:
                    26px;
            }


            .card-header-premium,
            .card-body-premium {

                padding:
                    18px;
            }


            .product-row {

                align-items:
                    flex-start;
            }


            .product-image {

                width:
                    62px;

                height:
                    62px;
            }


            .product-total {

                font-size:
                    12px;
            }


            .total-box {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .total-amount {

                font-size:
                    20px;
            }
        }

    </style>

</head>


@php

    /* ==========================================================
       CUSTOMER THEME
    ========================================================== */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'light')
        : 'light';

    if (!in_array(
        $customerTheme,
        ['dark', 'light', 'system'],
        true
    )) {
        $customerTheme = 'light';
    }

    /*
    | System is intentionally resolved on client side.
    | If user has selected Dark/Light, that exact setting wins.
    */


    /* ==========================================================
       TRACKING STEPS
    ========================================================== */

    $steps = [
        'Order Placed',
        'Seller Confirmed',
        'Packed',
        'Picked By Delivery Partner',
        'Out For Delivery',
        'Near Customer',
        'Delivered'
    ];


    $current =
        $order->deliveryDetail?->status
        ?? $order->order_status
        ?? 'Order Placed';


    $currentIndex =
        array_search(
            $current,
            $steps,
            true
        );


    if ($currentIndex === false) {
        $currentIndex = 0;
    }


    /* ==========================================================
       ORDER TOTAL
    ========================================================== */

    $orderTotal = 0;

    foreach ($order->items ?? [] as $item) {

        $price =
            (float) ($item['price'] ?? 0);

        $quantity =
            (int) ($item['quantity'] ?? 1);

        $orderTotal +=
            $price * $quantity;
    }

@endphp


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


<main class="order-page">

    <div class="order-container">


        <!-- ======================================================
             TOP BAR
        ======================================================= -->

        <div class="order-topbar">

            <a
                href="{{ route('orders.index') }}"
                class="back-btn"
            >

                <i class="fa-solid fa-arrow-left"></i>

                My Orders

            </a>


            <div class="secure-pill">

                <i class="fa-solid fa-shield-halved"></i>

                Secure Order

            </div>

        </div>


        <!-- ======================================================
             ORDER HEADER
        ======================================================= -->

        <section class="order-header">

            <div class="order-label">
                SMART BASKET ORDER
            </div>


            <h1 class="order-title">

                Order #{{ $order->id }}

            </h1>


            <div class="order-date">

                <i class="fa-regular fa-calendar"></i>

                Order tracking & details

            </div>


            <div class="order-status">

                <span class="status-dot"></span>

                {{ $current }}

            </div>

        </section>


        <!-- ======================================================
             MAIN GRID
        ======================================================= -->

        <div class="row g-4">


            <!-- ==================================================
                 LEFT
            =================================================== -->

            <div class="col-lg-7">


                <!-- ORDER ITEMS -->

                <section class="premium-card">

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-box"></i>

                            </span>

                            Order Items

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        @forelse($order->items ?? [] as $item)

                            @php

                                $product =
                                    $products[
                                        $item['product_id'] ?? null
                                    ]
                                    ?? null;

                                $quantity =
                                    (int)
                                    ($item['quantity'] ?? 1);

                                $price =
                                    (float)
                                    ($item['price'] ?? 0);

                                $lineTotal =
                                    $price * $quantity;

                            @endphp


                            <div class="product-row">


                                <img
                                    src="{{
                                        $product && $product->image
                                            ? asset(
                                                'products/' .
                                                $product->image
                                            )
                                            : 'https://placehold.co/160x160/0B1426/FFFFFF?text=Product'
                                    }}"
                                    alt="{{
                                        $item['name']
                                        ?? $product?->name
                                        ?? 'Product'
                                    }}"
                                    class="product-image"
                                >


                                <div class="product-info">

                                    <div class="product-name">

                                        {{
                                            $item['name']
                                            ?? $product?->name
                                            ?? 'Product'
                                        }}

                                    </div>


                                    <div class="product-meta">

                                        ₹{{ number_format(
                                            $price,
                                            2
                                        ) }}

                                        ×

                                        {{ $quantity }}

                                        quantity

                                    </div>

                                </div>


                                <div class="product-total">

                                    ₹{{ number_format(
                                        $lineTotal,
                                        2
                                    ) }}

                                </div>


                            </div>

                        @empty

                            <div class="muted-text">

                                No products found for this order.

                            </div>

                        @endforelse


                        <div class="total-box">

                            <div>

                                <div class="total-label">
                                    ORDER TOTAL
                                </div>

                                <div class="muted-text">
                                    Final payable amount
                                </div>

                            </div>


                            <div class="total-amount">

                                ₹{{ number_format(
                                    $orderTotal,
                                    2
                                ) }}

                            </div>

                        </div>

                    </div>

                </section>


                <!-- TRACKING -->

                <section
                    class="premium-card mt-4"
                >

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </span>

                            Track Your Order

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        <div class="tracking-location">

                            <div class="location-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>


                            <div>

                                <div class="location-label">

                                    CURRENT LOCATION

                                </div>


                                <div class="location-value">

                                    {{
                                        $order
                                            ->deliveryDetail
                                            ?->current_location
                                        ?? 'Seller Warehouse'
                                    }}

                                </div>

                            </div>

                        </div>


                        <ol class="timeline">

                            @foreach($steps as $index => $step)

                                <li
                                    class="
                                        timeline-item
                                        {{
                                            $index <= $currentIndex
                                                ? 'active'
                                                : ''
                                        }}
                                    "
                                >

                                    <span class="timeline-dot">

                                        @if($index <= $currentIndex)

                                            <i
                                                class="fa-solid fa-check"
                                            ></i>

                                        @else

                                            <i
                                                class="fa-solid fa-circle"
                                            ></i>

                                        @endif

                                    </span>


                                    <div class="timeline-name">

                                        {{ $step }}

                                    </div>

                                </li>

                            @endforeach

                        </ol>

                    </div>

                </section>


            </div>


            <!-- ==================================================
                 RIGHT
            =================================================== -->

            <div class="col-lg-5">


                <!-- DELIVERY PARTNER -->

                <section class="premium-card">

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-truck-fast"></i>

                            </span>

                            Delivery Partner

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        @if(
                            $order->deliveryDetail?->deliveryPartner
                        )

                            @php

                                $partner =
                                    $order
                                        ->deliveryDetail
                                        ->deliveryPartner;

                            @endphp


                            <div class="partner-box">


                                <img
                                    src="{{
                                        $partner->image
                                            ? asset(
                                                'delivery-partners/' .
                                                $partner->image
                                            )
                                            : 'https://placehold.co/120x120/0B1426/FFFFFF?text=DP'
                                    }}"
                                    alt="{{ $partner->name }}"
                                    class="partner-image"
                                >


                                <div>

                                    <div class="partner-name">

                                        {{ $partner->name }}

                                    </div>


                                    @if($partner->phone)

                                        <div class="partner-meta">

                                            <i
                                                class="fa-solid fa-phone"
                                            ></i>

                                            {{ $partner->phone }}

                                        </div>

                                    @endif


                                    @if($partner->vehicle_number)

                                        <div class="partner-meta">

                                            <i
                                                class="fa-solid fa-motorcycle"
                                            ></i>

                                            {{ $partner->vehicle_number }}

                                        </div>

                                    @endif

                                </div>

                            </div>


                            <div class="detail-row mt-3">

                                <div class="detail-icon">

                                    <i
                                        class="fa-solid fa-location-crosshairs"
                                    ></i>

                                </div>


                                <div>

                                    <div class="detail-label">
                                        Current Location
                                    </div>

                                    <div class="detail-value">

                                        {{
                                            $order
                                                ->deliveryDetail
                                                ->current_location
                                            ?? $partner->current_location
                                            ?? 'Updating soon'
                                        }}

                                    </div>

                                </div>

                            </div>


                        @else

                            <div class="tracking-location">

                                <div class="location-icon">

                                    <i
                                        class="fa-solid fa-truck"
                                    ></i>

                                </div>


                                <div>

                                    <div class="location-label">

                                        DELIVERY PARTNER

                                    </div>


                                    <div class="location-value">

                                        Will be assigned soon

                                    </div>

                                </div>

                            </div>


                            <div class="muted-text">

                                A delivery partner will appear here
                                after seller assignment.

                            </div>

                        @endif

                    </div>

                </section>


                <!-- ORDER INFORMATION -->

                <section
                    class="premium-card mt-4"
                >

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-receipt"></i>

                            </span>

                            Order Information

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-hashtag"
                                ></i>

                            </div>

                            <div>

                                <div class="detail-label">
                                    Order ID
                                </div>

                                <div class="detail-value">

                                    #{{ $order->id }}

                                </div>

                            </div>

                        </div>


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-credit-card"
                                ></i>

                            </div>

                            <div>

                                <div class="detail-label">
                                    Payment
                                </div>

                                <div class="detail-value">

                                    {{
                                        $order->payment_method
                                        ?? 'Payment information available in order record'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-box-open"
                                ></i>

                            </div>

                            <div>

                                <div class="detail-label">
                                    Order Status
                                </div>

                                <div class="detail-value">

                                    {{
                                        $order->order_status
                                        ?? $current
                                    }}

                                </div>

                            </div>

                        </div>


                    </div>

                </section>


                <!-- CANCEL ORDER -->

                @if($order->isCancellable())

                    <section class="cancel-box">

                        <div class="cancel-title">

                            <i
                                class="fa-solid fa-circle-exclamation"
                            ></i>

                            Need to cancel this order?

                        </div>


                        <div class="cancel-description">

                            You can cancel this order while it is
                            still eligible for cancellation.

                        </div>


                        <form
                            action="{{
                                route(
                                    'orders.cancel',
                                    $order
                                )
                            }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="cancel-btn"
                                onclick="
                                    return confirm(
                                        'Are you sure you want to cancel this order?'
                                    );
                                "
                            >

                                <i
                                    class="fa-solid fa-xmark"
                                ></i>

                                Cancel Order

                            </button>

                        </form>

                    </section>

                @endif


            </div>

        </div>

    </div>

</main>


<!-- ==============================================================
     AI HUB
=============================================================== -->

<x-ai-hub-sidebar />


<!-- ==============================================================
     SMART BASKET THEME ENGINE
=============================================================== -->

<script>

(function () {

    'use strict';


    const body =
        document.body;


    /*
    |--------------------------------------------------------------------------
    | Theme saved by Laravel user setting
    |--------------------------------------------------------------------------
    */

    const customerTheme =
        body.dataset.customerTheme || 'light';


    /*
    |--------------------------------------------------------------------------
    | System theme
    |--------------------------------------------------------------------------
    */

    function getSystemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    /*
    |--------------------------------------------------------------------------
    | Apply theme
    |--------------------------------------------------------------------------
    */

    function applyTheme(theme) {

        let finalTheme =
            theme;


        if (
            finalTheme !== 'dark' &&
            finalTheme !== 'light'
        ) {

            finalTheme =
                getSystemTheme();

        }


        /*
        |--------------------------------------------------------------------------
        | HTML
        |--------------------------------------------------------------------------
        */

        document.documentElement.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        document.documentElement.setAttribute(
            'data-theme',
            finalTheme
        );


        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        */

        body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        body.setAttribute(
            'data-theme',
            finalTheme
        );


        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        document.documentElement.classList.remove(
            'dark',
            'light'
        );

        document.documentElement.classList.add(
            finalTheme
        );


        body.classList.remove(
            'dark',
            'light'
        );

        body.classList.add(
            finalTheme
        );


        /*
        |--------------------------------------------------------------------------
        | Synchronize localStorage
        |--------------------------------------------------------------------------
        */

        try {

            localStorage.setItem(
                'smartbasket-theme',
                finalTheme
            );

        } catch (error) {

            // Ignore storage errors.

        }

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    applyTheme(
        customerTheme
    );


    /*
    |--------------------------------------------------------------------------
    | Storage synchronization
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key ===
                'smartbasket-theme'
            ) {

                if (
                    event.newValue === 'dark' ||
                    event.newValue === 'light'
                ) {

                    applyTheme(
                        event.newValue
                    );

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Same-tab synchronization
    |--------------------------------------------------------------------------
    */

    let lastTheme =
        localStorage.getItem(
            'smartbasket-theme'
        );


    setInterval(function () {

        try {

            const savedTheme =
                localStorage.getItem(
                    'smartbasket-theme'
                );


            if (
                savedTheme &&
                savedTheme !== lastTheme
            ) {

                lastTheme =
                    savedTheme;

                applyTheme(
                    savedTheme
                );

            }

        } catch (error) {

            // Ignore storage errors.

        }

    }, 250);


    /*
    |--------------------------------------------------------------------------
    | System theme listener
    |--------------------------------------------------------------------------
    */

    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    function systemThemeChanged() {

        if (
            body.dataset.customerTheme ===
            'system'
        ) {

            applyTheme(
                'system'
            );

        }

    }


    if (
        media.addEventListener
    ) {

        media.addEventListener(
            'change',
            systemThemeChanged
        );

    } else if (
        media.addListener
    ) {

        media.addListener(
            systemThemeChanged
        );

    }

})();

</script>


</body>

</html>


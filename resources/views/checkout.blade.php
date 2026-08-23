<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SMART BASKET | Premium Checkout</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>
        /* ==========================================================
           SMART BASKET PREMIUM CHECKOUT
        ========================================================== */

        :root {
            --sb-bg: #f5f7fb;
            --sb-bg-secondary: #eef2ff;

            --sb-card: rgba(255,255,255,.88);
            --sb-card-solid: #ffffff;
            --sb-surface: rgba(248,250,252,.88);

            --sb-text: #0f172a;
            --sb-heading: #020617;
            --sb-muted: #64748b;

            --sb-border: rgba(15,23,42,.09);
            --sb-border-strong: rgba(15,23,42,.14);

            --sb-primary: #2563eb;
            --sb-primary-2: #7c3aed;

            --sb-success: #16a34a;
            --sb-danger: #ef4444;

            --sb-input: #ffffff;
            --sb-payment: #f8fafc;

            --sb-shadow:
                0 30px 90px rgba(15,23,42,.13);

            --sb-small-shadow:
                0 12px 35px rgba(15,23,42,.08);

            --sb-radius-xl: 30px;
            --sb-radius-lg: 22px;
            --sb-radius-md: 15px;
        }


        /* ==========================================================
           DARK
        ========================================================== */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --sb-bg: #020617;
            --sb-bg-secondary: #0b1120;

            --sb-card: rgba(15,23,42,.88);
            --sb-card-solid: #0f172a;
            --sb-surface: rgba(30,41,59,.72);

            --sb-text: #e2e8f0;
            --sb-heading: #f8fafc;
            --sb-muted: #94a3b8;

            --sb-border: rgba(255,255,255,.08);
            --sb-border-strong: rgba(255,255,255,.14);

            --sb-input: #0b1220;
            --sb-payment: #111c2e;

            --sb-shadow:
                0 35px 100px rgba(0,0,0,.48);

            --sb-small-shadow:
                0 15px 45px rgba(0,0,0,.30);
        }


        /* ==========================================================
           RESET
        ========================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {

            margin: 0;

            color: var(--sb-text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:

                radial-gradient(
                    circle at 8% 5%,
                    rgba(37,99,235,.18),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 92% 8%,
                    rgba(124,58,237,.15),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(14,165,233,.08),
                    transparent 35%
                ),

                var(--sb-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }


        /* ==========================================================
           AMBIENT BACKGROUND
        ========================================================== */

        .premium-bg {

            position: fixed;

            inset: 0;

            pointer-events: none;

            overflow: hidden;

            z-index: -1;
        }

        .orb {

            position: absolute;

            border-radius: 50%;

            filter: blur(70px);

            opacity: .22;

            animation:
                orbFloat 10s ease-in-out infinite;
        }

        .orb-one {

            width: 260px;
            height: 260px;

            background: #2563eb;

            top: 8%;
            left: -80px;
        }

        .orb-two {

            width: 300px;
            height: 300px;

            background: #7c3aed;

            right: -100px;
            bottom: 12%;

            animation-delay: -4s;
        }

        .orb-three {

            width: 180px;
            height: 180px;

            background: #06b6d4;

            left: 45%;
            bottom: -80px;

            animation-delay: -7s;
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translate3d(0,0,0);
            }

            50% {
                transform: translate3d(20px,-25px,0);
            }
        }


        /* ==========================================================
           MAIN
        ========================================================== */

        .checkout-wrapper {

            min-height: 100vh;

            padding:
                45px 18px 80px;
        }

        .checkout-container {

            width: 100%;

            max-width: 980px;

            margin: auto;
        }


        /* ==========================================================
           TOP BRAND
        ========================================================== */

        .brand-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 18px;

            padding: 0 5px;
        }

        .brand {

            display: flex;

            align-items: center;

            gap: 10px;

            color: var(--sb-heading);

            font-size: 18px;

            font-weight: 900;

            letter-spacing: -.3px;
        }

        .brand-logo {

            width: 38px;
            height: 38px;

            display: grid;

            place-items: center;

            border-radius: 12px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-2)
                );

            box-shadow:
                0 10px 25px rgba(37,99,235,.25);
        }

        .secure-mini {

            display: flex;

            align-items: center;

            gap: 6px;

            color: var(--sb-success);

            font-size: 12px;

            font-weight: 800;
        }


        /* ==========================================================
           MAIN CARD
        ========================================================== */

        .checkout-card {

            position: relative;

            overflow: hidden;

            background: var(--sb-card);

            border:
                1px solid var(--sb-border);

            border-radius: var(--sb-radius-xl);

            box-shadow: var(--sb-shadow);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);

            padding: 34px;

            transition:
                background .35s ease,
                border-color .35s ease,
                box-shadow .35s ease;
        }

        .checkout-card::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;
            right: 0;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed,
                    #06b6d4
                );
        }


        /* ==========================================================
           HEADER
        ========================================================== */

        .checkout-header {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 25px;

            margin-bottom: 32px;
        }

        .title-wrap {

            display: flex;

            gap: 15px;

            align-items: flex-start;
        }

        .title-icon {

            width: 54px;
            height: 54px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 17px;

            font-size: 25px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.14),
                    rgba(124,58,237,.14)
                );

            border:
                1px solid rgba(99,102,241,.18);
        }

        .checkout-title {

            margin: 0;

            color: var(--sb-heading);

            font-size: 34px;

            line-height: 1.1;

            font-weight: 900;

            letter-spacing: -1px;
        }

        .checkout-subtitle {

            margin:
                7px 0 0;

            color: var(--sb-muted);

            font-size: 14px;
        }

        .secure-badge {

            display: flex;

            align-items: center;

            gap: 8px;

            padding:
                10px 15px;

            border-radius: 999px;

            background:
                rgba(34,197,94,.10);

            color: var(--sb-success);

            border:
                1px solid rgba(34,197,94,.18);

            font-size: 12px;

            font-weight: 850;

            white-space: nowrap;
        }


        /* ==========================================================
           SECTION HEADER
        ========================================================== */

        .section-heading {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 15px;
        }

        .section-number {

            width: 28px;
            height: 28px;

            display: grid;

            place-items: center;

            border-radius: 9px;

            color: white;

            font-size: 12px;

            font-weight: 900;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-2)
                );
        }

        .section-title {

            margin: 0;

            color: var(--sb-heading);

            font-size: 16px;

            font-weight: 850;
        }


        /* ==========================================================
           ORDER SUMMARY
        ========================================================== */

        .order-summary {

            padding: 20px;

            margin-bottom: 30px;

            border:
                1px solid var(--sb-border);

            border-radius: var(--sb-radius-lg);

            background:
                linear-gradient(
                    135deg,
                    var(--sb-surface),
                    transparent
                );

            box-shadow:
                var(--sb-small-shadow);
        }

        .order-item {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 15px 0;

            border-bottom:
                1px solid var(--sb-border);
        }

        .order-item:last-child {

            border-bottom: 0;
        }

        .product-name {

            color: var(--sb-heading);

            font-size: 14px;

            font-weight: 750;
        }

        .quantity {

            display: inline-flex;

            margin-top: 5px;

            padding: 4px 8px;

            border-radius: 7px;

            color: var(--sb-muted);

            background:
                rgba(148,163,184,.09);

            font-size: 11px;

            font-weight: 700;
        }

        .product-price {

            color: var(--sb-heading);

            font-size: 14px;

            font-weight: 850;

            white-space: nowrap;
        }

        .total-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 14px;

            padding-top: 18px;

            border-top:
                1px solid var(--sb-border);

            color: var(--sb-heading);

            font-size: 21px;

            font-weight: 900;
        }

        .total-price {

            background:
                linear-gradient(
                    90deg,
                    var(--sb-primary),
                    var(--sb-primary-2)
                );

            -webkit-background-clip: text;

            background-clip: text;

            color: transparent;
        }


        /* ==========================================================
           FORM
        ========================================================== */

        .form-section {

            margin-top: 28px;
        }

        .form-label {

            display: block;

            margin-bottom: 7px;

            color: var(--sb-text);

            font-size: 13px;

            font-weight: 750;
        }

        .form-control,
        .form-select {

            min-height: 51px;

            padding:
                12px 14px;

            color: var(--sb-text) !important;

            background:
                var(--sb-input) !important;

            border:
                1px solid var(--sb-border-strong) !important;

            border-radius:
                var(--sb-radius-md) !important;

            box-shadow:
                inset 0 1px 2px rgba(15,23,42,.03) !important;

            transition:
                border .2s ease,
                box-shadow .2s ease,
                transform .2s ease,
                background .3s ease;
        }

        .form-control:hover,
        .form-select:hover {

            border-color:
                rgba(37,99,235,.30) !important;
        }

        .form-control:focus,
        .form-select:focus {

            border-color:
                var(--sb-primary) !important;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.11) !important;
        }

        .form-control::placeholder {

            color: var(--sb-muted);

            opacity: .75;
        }

        textarea.form-control {

            min-height: 115px;

            resize: vertical;
        }

        html[data-sb-theme="dark"] .form-select option {

            background: #0f172a;

            color: #f8fafc;
        }


        /* ==========================================================
           PAYMENT
        ========================================================== */

        .payment-section {

            margin-top: 32px;
        }

        .payment-select-wrap {

            position: relative;
        }

        .payment-box {

            position: relative;

            overflow: hidden;

            margin-top: 16px;

            padding: 24px;

            color: var(--sb-text);

            background:
                linear-gradient(
                    145deg,
                    var(--sb-payment),
                    var(--sb-surface)
                );

            border:
                1px solid var(--sb-border-strong);

            border-radius:
                var(--sb-radius-lg);

            box-shadow:
                var(--sb-small-shadow);

            animation:
                paymentIn .28s ease;

            transition:
                background .35s ease,
                border-color .35s ease,
                box-shadow .35s ease;
        }

        .payment-box::before {

            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            right: -50px;
            top: -50px;

            border-radius: 50%;

            background:
                rgba(37,99,235,.10);

            filter: blur(25px);

            pointer-events: none;
        }

        html[data-sb-theme="dark"] .payment-box {

            background:
                linear-gradient(
                    145deg,
                    #0f172a,
                    #111c2e
                );

            border-color:
                rgba(255,255,255,.10);

            box-shadow:
                0 20px 55px rgba(0,0,0,.25),
                inset 0 1px 0 rgba(255,255,255,.035);
        }

        @keyframes paymentIn {

            from {

                opacity: 0;

                transform:
                    translateY(10px)
                    scale(.99);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }

        .payment-title {

            display: flex;

            align-items: center;

            gap: 11px;

            color: var(--sb-heading);

            font-size: 18px;

            font-weight: 900;
        }

        .payment-title-icon {

            width: 40px;
            height: 40px;

            display: grid;

            place-items: center;

            border-radius: 12px;

            background:
                rgba(37,99,235,.12);

            border:
                1px solid rgba(37,99,235,.16);
        }

        .payment-description {

            margin:
                8px 0 18px;

            color: var(--sb-muted);

            font-size: 13px;

            line-height: 1.6;
        }


        /* ==========================================================
           PAYMENT PROVIDERS
        ========================================================== */

        .payment-icons {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 10px;

            margin-bottom: 20px;
        }

        .payment-icon {

            display: flex;

            align-items: center;

            justify-content: center;

            min-height: 43px;

            padding: 8px;

            border-radius: 11px;

            color: var(--sb-text);

            background:
                rgba(37,99,235,.07);

            border:
                1px solid rgba(37,99,235,.13);

            font-size: 11px;

            font-weight: 800;

            transition:
                transform .2s ease,
                background .2s ease;
        }

        .payment-icon:hover {

            transform:
                translateY(-2px);

            background:
                rgba(37,99,235,.13);
        }


        /* ==========================================================
           QR
        ========================================================== */

        .qr-card {

            position: relative;

            margin-top: 22px;

            padding: 24px;

            border-radius: 20px;

            text-align: center;

            background: #ffffff;

            color: #0f172a;

            border:
                1px solid rgba(15,23,42,.08);

            box-shadow:
                0 18px 50px rgba(0,0,0,.14);
        }

        .qr-label {

            display: inline-flex;

            padding: 6px 11px;

            margin-bottom: 12px;

            border-radius: 999px;

            color: #2563eb;

            background: #eff6ff;

            font-size: 11px;

            font-weight: 850;
        }

        .qr-card img {

            display: block;

            width: 220px;
            height: 220px;

            max-width: 100%;

            margin: auto;

            padding: 8px;

            object-fit: contain;

            border-radius: 16px;

            background: white;

            box-shadow:
                0 12px 35px rgba(15,23,42,.16);
        }

        .qr-pay-title {

            margin-top: 15px;

            margin-bottom: 4px;

            font-size: 15px;

            font-weight: 900;
        }

        .qr-note {

            color: #64748b;

            font-size: 12px;
        }


        /* ==========================================================
           CARD PAYMENT
        ========================================================== */

        .card-visual {

            position: relative;

            overflow: hidden;

            width: 100%;

            max-width: 390px;

            height: 205px;

            margin:
                0 auto 24px;

            padding: 24px;

            border-radius: 22px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #1e3a8a 55%,
                    #7c3aed
                );

            box-shadow:
                0 20px 45px rgba(37,99,235,.25);
        }

        .card-visual::after {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -70px;
            bottom: -80px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.13);
        }

        .card-chip {

            width: 42px;
            height: 31px;

            border-radius: 7px;

            background:
                linear-gradient(
                    135deg,
                    #e2e8f0,
                    #94a3b8
                );
        }

        .card-visual-number {

            margin-top: 27px;

            font-size: 18px;

            letter-spacing: 3px;

            font-weight: 700;
        }

        .card-visual-brand {

            position: absolute;

            right: 22px;
            top: 20px;

            font-size: 14px;

            font-weight: 900;
        }

        .card-payment-title {

            text-align: center;

            color: var(--sb-heading);

            font-size: 18px;

            font-weight: 900;
        }


        /* ==========================================================
           COD
        ========================================================== */

        .cod-icon {

            width: 55px;
            height: 55px;

            display: grid;

            place-items: center;

            margin-bottom: 12px;

            border-radius: 16px;

            font-size: 25px;

            background:
                rgba(34,197,94,.11);

            border:
                1px solid rgba(34,197,94,.15);
        }


        /* ==========================================================
           BUTTON
        ========================================================== */

        .confirm-btn {

            position: relative;

            overflow: hidden;

            width: 100%;

            min-height: 58px;

            margin-top: 30px;

            border: 0;

            border-radius: 16px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5 50%,
                    #7c3aed
                );

            font-size: 15px;

            font-weight: 900;

            letter-spacing: .1px;

            box-shadow:
                0 16px 35px rgba(37,99,235,.28);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                filter .2s ease;
        }

        .confirm-btn::before {

            content: "";

            position: absolute;

            top: 0;
            left: -100%;

            width: 80%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.20),
                    transparent
                );

            transform:
                skewX(-20deg);

            transition:
                left .6s ease;
        }

        .confirm-btn:hover {

            color: white;

            transform:
                translateY(-3px);

            filter:
                brightness(1.05);

            box-shadow:
                0 22px 50px rgba(37,99,235,.38);
        }

        .confirm-btn:hover::before {

            left: 130%;
        }

        .confirm-btn:active {

            transform:
                translateY(-1px);
        }


        /* ==========================================================
           SECURITY
        ========================================================== */

        .payment-security {

            display: flex;

            justify-content: center;

            flex-wrap: wrap;

            gap: 20px;

            margin-top: 22px;

            color: var(--sb-muted);

            font-size: 11px;

            font-weight: 700;
        }


        /* ==========================================================
           BACK
        ========================================================== */

        .back-link {

            display: flex;

            justify-content: center;

            margin-top: 22px;

            color: var(--sb-muted);

            text-decoration: none;

            font-size: 13px;

            font-weight: 750;

            transition:
                color .2s ease,
                transform .2s ease;
        }

        .back-link:hover {

            color: var(--sb-primary);

            transform:
                translateX(-2px);
        }


        /* ==========================================================
           EMPTY
        ========================================================== */

        .empty-checkout {

            padding:
                55px 20px;

            text-align: center;

            color: var(--sb-muted);
        }

        .empty-checkout h3 {

            margin-top: 12px;

            color: var(--sb-heading);

            font-weight: 900;
        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 700px) {

            .checkout-wrapper {

                padding:
                    20px 10px 50px;
            }

            .checkout-card {

                padding:
                    22px 16px;

                border-radius: 23px;
            }

            .brand-row {

                padding: 0 2px;
            }

            .checkout-header {

                flex-direction: column;

                margin-bottom: 25px;
            }

            .checkout-title {

                font-size: 28px;
            }

            .title-icon {

                width: 48px;
                height: 48px;
            }

            .secure-badge {

                font-size: 11px;
            }

            .order-summary {

                padding: 16px;
            }

            .order-item {

                align-items: flex-start;

                flex-direction: column;

                gap: 6px;
            }

            .total-row {

                font-size: 18px;
            }

            .payment-box {

                padding:
                    20px 15px;
            }

            .payment-icons {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .card-visual {

                height: 185px;

                padding: 20px;
            }

            .card-visual-number {

                font-size: 15px;

                margin-top: 24px;
            }

            .confirm-btn {

                min-height: 56px;
            }
        }

        @media (max-width: 400px) {

            .checkout-title {

                font-size: 25px;
            }

            .payment-icons {

                gap: 7px;
            }

            .payment-icon {

                font-size: 10px;
            }
        }
    </style>
</head>


@php
    /*
    |--------------------------------------------------------------------------
    | CUSTOMER THEME
    |--------------------------------------------------------------------------
    */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';

    if (!in_array($customerTheme, ['dark', 'light', 'system'], true)) {
        $customerTheme = 'system';
    }

    $checkoutItems = $cartItems ?? [];
    $checkoutTotal = $total ?? 0;
@endphp


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


<!-- ==============================================================
     AMBIENT BACKGROUND
=============================================================== -->

<div class="premium-bg">

    <div class="orb orb-one"></div>

    <div class="orb orb-two"></div>

    <div class="orb orb-three"></div>

</div>


<div class="checkout-wrapper">

    <div class="checkout-container">


        <!-- ======================================================
             BRAND
        ======================================================= -->

        <div class="brand-row">

            <div class="brand">

                <div class="brand-logo">
                    🛒
                </div>

                SMART BASKET

            </div>


            <div class="secure-mini">
                🔒 Secure Payment
            </div>

        </div>


        <!-- ======================================================
             MAIN CARD
        ======================================================= -->

        <div class="checkout-card">


            <!-- ==================================================
                 HEADER
            =================================================== -->

            <div class="checkout-header">

                <div class="title-wrap">

                    <div class="title-icon">
                        🛍️
                    </div>

                    <div>

                        <h1 class="checkout-title">
                            Checkout
                        </h1>

                        <p class="checkout-subtitle">
                            Complete your purchase securely.
                        </p>

                    </div>

                </div>


                <div class="secure-badge">
                    🛡️ Protected Checkout
                </div>

            </div>


            <!-- ==================================================
                 ORDER SUMMARY
            =================================================== -->

            @if(count($checkoutItems) > 0)

                <div class="order-summary">

                    <div class="section-heading">

                        <div class="section-number">
                            1
                        </div>

                        <h2 class="section-title">
                            Order Summary
                        </h2>

                    </div>


                    @foreach($checkoutItems as $item)

                        @php
                            $product =
                                $item['product']
                                ?? $item->product
                                ?? null;

                            $quantity =
                                $item['quantity']
                                ?? $item->quantity
                                ?? 1;
                        @endphp


                        @if($product)

                            <div class="order-item">

                                <div>

                                    <div class="product-name">
                                        {{ $product->name }}
                                    </div>

                                    <span class="quantity">
                                        Qty: {{ $quantity }}
                                    </span>

                                </div>


                                <div class="product-price">
                                    ₹{{ number_format(
                                        (float) $product->price *
                                        (int) $quantity,
                                        2
                                    ) }}
                                </div>

                            </div>

                        @endif

                    @endforeach


                    <div class="total-row">

                        <span>
                            Total Amount
                        </span>

                        <span class="total-price">
                            ₹{{ number_format(
                                (float) $checkoutTotal,
                                2
                            ) }}
                        </span>

                    </div>

                </div>

            @else

                <div class="empty-checkout">

                    <div style="font-size:65px;">
                        🛒
                    </div>

                    <h3>
                        Your checkout is empty
                    </h3>

                    <p>
                        Please add a product before placing an order.
                    </p>

                </div>

            @endif


            <!-- ==================================================
                 FORM
            =================================================== -->

            <form
                action="{{ route('place.order') }}"
                method="POST"
                id="checkoutForm"
            >

                @csrf


                <!-- ==============================================
                     DELIVERY
                =============================================== -->

                <div class="form-section">

                    <div class="section-heading">

                        <div class="section-number">
                            2
                        </div>

                        <h2 class="section-title">
                            Delivery Information
                        </h2>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', auth()->user()?->name) }}"
                            placeholder="Enter your full name"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Mobile Number
                        </label>

                        <input
                            type="tel"
                            name="mobile"
                            class="form-control"
                            value="{{ old('mobile', auth()->user()?->phone) }}"
                            placeholder="Enter mobile number"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Delivery Address
                        </label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="House no., street, area..."
                            required
                        >{{ old('address', auth()->user()?->address) }}</textarea>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                class="form-control"
                                value="{{ old('city', auth()->user()?->city) }}"
                                placeholder="Enter city"
                                required
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                PIN Code
                            </label>

                            <input
                                type="text"
                                name="pin_code"
                                class="form-control"
                                value="{{ old('pin_code', auth()->user()?->pin_code) }}"
                                placeholder="6-digit PIN code"
                            >

                        </div>

                    </div>

                </div>


                <!-- ==============================================
                     PAYMENT
                =============================================== -->

                <div class="payment-section">

                    <div class="section-heading">

                        <div class="section-number">
                            3
                        </div>

                        <h2 class="section-title">
                            Payment Method
                        </h2>

                    </div>


                    <div class="payment-select-wrap">

                        <select
                            name="payment_method"
                            id="paymentMethod"
                            class="form-select"
                            required
                        >

                            <option value="COD">
                                🚚 Cash on Delivery
                            </option>


                            @if($onlinePaymentAvailable ?? false)

                                <option value="UPI">
                                    📱 UPI Payment
                                </option>

                                <option value="Card">
                                    💳 Card Payment
                                </option>

                            @endif

                        </select>

                    </div>


                    <!-- ==========================================
                         UPI
                    =========================================== -->

                    <div
                        id="upiBox"
                        class="payment-box"
                        style="display:none;"
                    >

                        <div class="payment-title">

                            <div class="payment-title-icon">
                                📱
                            </div>

                            UPI Payment

                        </div>


                        <p class="payment-description">
                            Pay securely using Google Pay,
                            PhonePe, Paytm, BHIM or another
                            supported UPI application.
                        </p>


                        <div class="payment-icons">

                            <span class="payment-icon">
                                Google Pay
                            </span>

                            <span class="payment-icon">
                                PhonePe
                            </span>

                            <span class="payment-icon">
                                Paytm
                            </span>

                            <span class="payment-icon">
                                BHIM
                            </span>

                        </div>


                        <label class="form-label">
                            UPI ID
                        </label>

                        <input
                            type="text"
                            name="upi_id"
                            id="upiId"
                            class="form-control"
                            placeholder="example@upi"
                        >


                        @php

                            $paymentSellers =
                                collect($checkoutItems)

                                ->map(
                                    fn($item) =>
                                        $item['product']
                                        ?? $item->product
                                        ?? null
                                )

                                ->filter()

                                ->map(
                                    fn($product) =>
                                        $product->seller
                                )

                                ->filter()

                                ->unique('id');

                        @endphp


                        @forelse($paymentSellers as $paymentSeller)

                            @if($paymentSeller->payment_qr)

                                <div class="qr-card">

                                    <div class="qr-label">
                                        🔐 SECURE SELLER PAYMENT
                                    </div>


                                    <div class="qr-pay-title">

                                        Pay
                                        {{ $paymentSeller->shop_name
                                            ?: $paymentSeller->seller_name }}

                                    </div>


                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $paymentSeller->payment_qr
                                        ) }}"
                                        alt="Payment QR"
                                    >


                                    <div class="qr-pay-title">
                                        Scan QR Code & Pay
                                    </div>


                                    <div class="qr-note">
                                        Complete your payment using
                                        your UPI application.
                                    </div>

                                </div>

                            @endif

                        @empty

                            <div class="payment-box">

                                <div class="payment-description mb-0">
                                    Seller payment QR is not available.
                                </div>

                            </div>

                        @endforelse

                    </div>


                    <!-- ==========================================
                         CARD
                    =========================================== -->

                    <div
                        id="cardBox"
                        class="payment-box"
                        style="display:none;"
                    >

                        <div class="card-visual">

                            <div class="card-chip"></div>

                            <div class="card-visual-brand">
                                SMART BASKET
                            </div>

                            <div class="card-visual-number">
                                •••• •••• •••• ••••
                            </div>

                        </div>


                        <div class="card-payment-title">
                            Card Payment
                        </div>


                        <p class="payment-description text-center">
                            Enter your card information securely.
                        </p>


                        <label class="form-label">
                            Card Number
                        </label>

                        <input
                            type="text"
                            name="card_number"
                            id="cardNumber"
                            class="form-control"
                            maxlength="19"
                            placeholder="XXXX XXXX XXXX XXXX"
                        >


                        <div class="row mt-3">

                            <div class="col">

                                <label class="form-label">
                                    Expiry
                                </label>

                                <input
                                    type="text"
                                    name="card_expiry"
                                    class="form-control"
                                    placeholder="MM/YY"
                                >

                            </div>


                            <div class="col">

                                <label class="form-label">
                                    CVV
                                </label>

                                <input
                                    type="password"
                                    name="card_cvv"
                                    class="form-control"
                                    maxlength="4"
                                    placeholder="CVV"
                                >

                            </div>

                        </div>

                    </div>


                    <!-- ==========================================
                         COD
                    =========================================== -->

                    <div
                        id="codBox"
                        class="payment-box"
                    >

                        <div class="cod-icon">
                            🚚
                        </div>

                        <div class="payment-title">
                            Cash on Delivery
                        </div>

                        <p class="payment-description mb-0">
                            Pay after receiving your order at your
                            delivery address.
                        </p>

                    </div>

                </div>


                <!-- ==============================================
                     CONFIRM
                =============================================== -->

                <button
                    type="submit"
                    class="confirm-btn"
                >
                    <span>
                        🔒 Confirm & Place Order
                    </span>
                </button>


                <div class="payment-security">

                    <span>
                        🔒 Secure Checkout
                    </span>

                    <span>
                        🛡️ Protected
                    </span>

                    <span>
                        ⚡ Fast Processing
                    </span>

                </div>

            </form>


            <a
                href="{{ route('products.index') }}"
                class="back-link"
            >
                ← Continue Shopping
            </a>

        </div>

    </div>

</div>


<script>

(function () {

    /*
    |--------------------------------------------------------------------------
    | PAYMENT BOX SWITCHER
    |--------------------------------------------------------------------------
    */

    const paymentMethod =
        document.getElementById('paymentMethod');

    const upiBox =
        document.getElementById('upiBox');

    const cardBox =
        document.getElementById('cardBox');

    const codBox =
        document.getElementById('codBox');


    if (!paymentMethod) {
        return;
    }


    function showPaymentBox() {

        const method =
            paymentMethod.value;


        upiBox.style.display = 'none';

        cardBox.style.display = 'none';

        codBox.style.display = 'none';


        if (method === 'UPI') {

            upiBox.style.display = 'block';

        } else if (method === 'Card') {

            cardBox.style.display = 'block';

        } else {

            codBox.style.display = 'block';

        }

    }


    paymentMethod.addEventListener(
        'change',
        showPaymentBox
    );


    showPaymentBox();

})();


/*
|--------------------------------------------------------------------------
| CARD NUMBER FORMAT
|--------------------------------------------------------------------------
*/

const cardNumber =
    document.getElementById('cardNumber');


if (cardNumber) {

    cardNumber.addEventListener(
        'input',
        function () {

            let value =
                this.value
                    .replace(/\D/g, '')
                    .substring(0, 16);


            value =
                value
                    .match(/.{1,4}/g)
                    ?.join(' ')
                    || '';


            this.value = value;

        }
    );

}


/*
|--------------------------------------------------------------------------
| THEME SYSTEM
|--------------------------------------------------------------------------
|
| dark  -> full dark premium UI
| light -> full light premium UI
| system -> Windows/browser preference
|
*/

(function () {

    const body =
        document.body;

    const savedTheme =
        body.dataset.customerTheme
        || 'system';


    function getSystemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    function applyTheme(theme) {

        const finalTheme =
            theme === 'system'
                ? getSystemTheme()
                : theme;


        document.documentElement
            .setAttribute(
                'data-sb-theme',
                finalTheme
            );


        body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

    }


    /*
    |--------------------------------------------------------------------------
    | APPLY SAVED SETTINGS
    |--------------------------------------------------------------------------
    */

    applyTheme(savedTheme);


    /*
    |--------------------------------------------------------------------------
    | SYSTEM MODE LISTENER
    |--------------------------------------------------------------------------
    */

    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    function systemThemeChanged() {

        if (
            body.dataset.customerTheme === 'system'
        ) {

            applyTheme('system');

        }

    }


    if (media.addEventListener) {

        media.addEventListener(
            'change',
            systemThemeChanged
        );

    } else if (media.addListener) {

        media.addListener(
            systemThemeChanged
        );

    }

})();

</script>

</body>
</html>


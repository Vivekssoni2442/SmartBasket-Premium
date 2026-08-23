```php
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        SMART BASKET | Order Placed
    </title>

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
           SMART BASKET — PREMIUM ORDER SUCCESS
        ========================================================== */

        :root {

            --success-bg: #f5f7fb;

            --success-card:
                rgba(255,255,255,.88);

            --success-surface:
                rgba(248,250,252,.88);

            --success-text:
                #0f172a;

            --success-heading:
                #020617;

            --success-muted:
                #64748b;

            --success-border:
                rgba(15,23,42,.09);

            --success-green:
                #16a34a;

            --success-blue:
                #2563eb;

            --success-purple:
                #7c3aed;

            --success-shadow:
                0 30px 90px
                rgba(15,23,42,.14);
        }


        /* ==========================================================
           DARK THEME
        ========================================================== */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --success-bg:
                #020617;

            --success-card:
                rgba(15,23,42,.90);

            --success-surface:
                rgba(30,41,59,.72);

            --success-text:
                #e2e8f0;

            --success-heading:
                #f8fafc;

            --success-muted:
                #94a3b8;

            --success-border:
                rgba(255,255,255,.09);

            --success-green:
                #22c55e;

            --success-blue:
                #3b82f6;

            --success-purple:
                #8b5cf6;

            --success-shadow:
                0 35px 100px
                rgba(0,0,0,.48);
        }


        /* ==========================================================
           GLOBAL
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

            color:
                var(--success-text);

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
                    circle at 10% 5%,
                    rgba(37,99,235,.16),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 10%,
                    rgba(124,58,237,.14),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(34,197,94,.09),
                    transparent 35%
                ),

                var(--success-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }


        /* ==========================================================
           AMBIENT ORBS
        ========================================================== */

        .success-background {

            position: fixed;

            inset: 0;

            overflow: hidden;

            pointer-events: none;

            z-index: -1;
        }

        .success-orb {

            position: absolute;

            border-radius: 50%;

            filter: blur(80px);

            opacity: .20;

            animation:
                successFloat 9s
                ease-in-out
                infinite;
        }

        .success-orb.one {

            width: 280px;

            height: 280px;

            background:
                #2563eb;

            left: -100px;

            top: 10%;
        }

        .success-orb.two {

            width: 300px;

            height: 300px;

            background:
                #7c3aed;

            right: -110px;

            bottom: 15%;

            animation-delay:
                -3s;
        }

        .success-orb.three {

            width: 190px;

            height: 190px;

            background:
                #22c55e;

            left: 48%;

            bottom: -100px;

            animation-delay:
                -6s;
        }

        @keyframes successFloat {

            0%,
            100% {
                transform:
                    translate3d(0,0,0);
            }

            50% {
                transform:
                    translate3d(20px,-25px,0);
            }
        }


        /* ==========================================================
           PAGE
        ========================================================== */

        .success-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding:
                35px 15px 80px;
        }

        .success-container {

            width: 100%;

            max-width: 720px;
        }


        /* ==========================================================
           BRAND
        ========================================================== */

        .success-brand {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            margin-bottom: 18px;

            color:
                var(--success-heading);

            font-size: 18px;

            font-weight: 900;

            letter-spacing:
                -.3px;
        }

        .brand-icon {

            width: 40px;

            height: 40px;

            display: grid;

            place-items: center;

            border-radius: 13px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--success-blue),
                    var(--success-purple)
                );

            box-shadow:
                0 10px 28px
                rgba(37,99,235,.25);
        }


        /* ==========================================================
           MAIN CARD
        ========================================================== */

        .success-card {

            position: relative;

            overflow: hidden;

            padding:
                45px 40px;

            text-align: center;

            border:
                1px solid
                var(--success-border);

            border-radius: 32px;

            background:
                var(--success-card);

            box-shadow:
                var(--success-shadow);

            backdrop-filter:
                blur(25px);

            -webkit-backdrop-filter:
                blur(25px);

            animation:
                cardAppear .55s
                cubic-bezier(.2,.8,.2,1);
        }

        .success-card::before {

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
                    #22c55e
                );
        }

        @keyframes cardAppear {

            from {

                opacity: 0;

                transform:
                    translateY(25px)
                    scale(.97);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* ==========================================================
           SUCCESS ICON
        ========================================================== */

        .success-icon-wrapper {

            position: relative;

            width: 105px;

            height: 105px;

            margin:
                0 auto 25px;

            display: grid;

            place-items: center;

            border-radius: 50%;

            background:
                rgba(34,197,94,.10);

            border:
                1px solid
                rgba(34,197,94,.18);

            animation:
                iconPop .65s
                cubic-bezier(.2,.9,.2,1)
                .15s both;
        }

        .success-icon-wrapper::before {

            content: "";

            position: absolute;

            inset: -10px;

            border-radius: 50%;

            border:
                1px solid
                rgba(34,197,94,.16);

            animation:
                successPulse 2s
                ease-out
                infinite;
        }

        .success-icon {

            width: 76px;

            height: 76px;

            display: grid;

            place-items: center;

            border-radius: 50%;

            color: white;

            font-size: 37px;

            font-weight: 900;

            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

            box-shadow:
                0 15px 35px
                rgba(34,197,94,.30);
        }

        @keyframes iconPop {

            from {

                opacity: 0;

                transform:
                    scale(.45)
                    rotate(-15deg);
            }

            to {

                opacity: 1;

                transform:
                    scale(1)
                    rotate(0);
            }
        }

        @keyframes successPulse {

            0% {
                transform:
                    scale(.9);

                opacity: .7;
            }

            70% {

                transform:
                    scale(1.2);

                opacity: 0;
            }

            100% {

                opacity: 0;
            }
        }


        /* ==========================================================
           TITLE
        ========================================================== */

        .success-title {

            margin: 0;

            color:
                var(--success-heading);

            font-size: 34px;

            font-weight: 950;

            letter-spacing:
                -1px;
        }

        .success-title span {

            background:
                linear-gradient(
                    90deg,
                    #16a34a,
                    #22c55e
                );

            -webkit-background-clip:
                text;

            background-clip:
                text;

            color:
                transparent;
        }

        .success-description {

            max-width: 500px;

            margin:
                12px auto 0;

            color:
                var(--success-muted);

            font-size: 14px;

            line-height: 1.7;
        }


        /* ==========================================================
           STATUS PILL
        ========================================================== */

        .status-pill {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 20px;

            padding:
                9px 14px;

            border-radius:
                999px;

            color:
                var(--success-green);

            background:
                rgba(34,197,94,.09);

            border:
                1px solid
                rgba(34,197,94,.17);

            font-size: 12px;

            font-weight: 850;
        }

        .status-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background:
                var(--success-green);

            box-shadow:
                0 0 0 4px
                rgba(34,197,94,.10);
        }


        /* ==========================================================
           INFO CARDS
        ========================================================== */

        .success-info {

            display: grid;

            grid-template-columns:
                repeat(3,1fr);

            gap: 12px;

            margin-top: 30px;
        }

        .info-card {

            padding:
                17px 12px;

            border:
                1px solid
                var(--success-border);

            border-radius:
                17px;

            background:
                var(--success-surface);

            transition:
                transform .2s ease,
                border-color .2s ease;
        }

        .info-card:hover {

            transform:
                translateY(-3px);

            border-color:
                rgba(37,99,235,.22);
        }

        .info-icon {

            font-size: 22px;

            margin-bottom: 7px;
        }

        .info-title {

            color:
                var(--success-heading);

            font-size: 12px;

            font-weight: 850;
        }

        .info-text {

            margin-top: 3px;

            color:
                var(--success-muted);

            font-size: 10px;
        }


        /* ==========================================================
           BUTTON
        ========================================================== */

        .shopping-btn {

            position: relative;

            overflow: hidden;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            min-width: 220px;

            min-height: 54px;

            margin-top: 30px;

            padding:
                12px 22px;

            border: 0;

            border-radius:
                15px;

            color: white;

            text-decoration: none;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5,
                    #7c3aed
                );

            font-size: 14px;

            font-weight: 900;

            box-shadow:
                0 15px 35px
                rgba(37,99,235,.27);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .shopping-btn:hover {

            color: white;

            transform:
                translateY(-3px);

            box-shadow:
                0 22px 45px
                rgba(37,99,235,.38);
        }


        /* ==========================================================
           FOOTER SECURITY
        ========================================================== */

        .security-row {

            display: flex;

            justify-content: center;

            flex-wrap: wrap;

            gap: 18px;

            margin-top: 23px;

            color:
                var(--success-muted);

            font-size: 10px;

            font-weight: 700;
        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 600px) {

            .success-page {

                padding:
                    20px 10px 60px;
            }

            .success-card {

                padding:
                    38px 20px;

                border-radius:
                    25px;
            }

            .success-title {

                font-size: 28px;
            }

            .success-description {

                font-size: 13px;
            }

            .success-info {

                grid-template-columns:
                    1fr;
            }

            .info-card {

                display: flex;

                align-items: center;

                gap: 12px;

                text-align: left;
            }

            .info-icon {

                margin: 0;

                font-size: 20px;
            }

            .shopping-btn {

                width: 100%;
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

    if (!in_array(
        $customerTheme,
        ['dark', 'light', 'system'],
        true
    )) {
        $customerTheme = 'system';
    }

@endphp


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


<!-- ==============================================================
     AMBIENT BACKGROUND
=============================================================== -->

<div class="success-background">

    <div class="success-orb one"></div>

    <div class="success-orb two"></div>

    <div class="success-orb three"></div>

</div>


<!-- ==============================================================
     PAGE
=============================================================== -->

<div class="success-page">

    <div class="success-container">


        <!-- ======================================================
             BRAND
        ======================================================= -->

        <div class="success-brand">

            <div class="brand-icon">
                🛒
            </div>

            SMART BASKET

        </div>


        <!-- ======================================================
             SUCCESS CARD
        ======================================================= -->

        <div class="success-card">


            <!-- SUCCESS ICON -->

            <div class="success-icon-wrapper">

                <div class="success-icon">
                    ✓
                </div>

            </div>


            <!-- TITLE -->

            <h1 class="success-title">

                Order
                <span>Placed Successfully!</span>

            </h1>


            <p class="success-description">

                Thank you for shopping with
                <strong>SMART BASKET</strong>.
                Your order has been received successfully
                and will be processed shortly.

            </p>


            <!-- STATUS -->

            <div class="status-pill">

                <span class="status-dot"></span>

                Order Received

            </div>


            <!-- INFO -->

            <div class="success-info">


                <div class="info-card">

                    <div class="info-icon">
                        📦
                    </div>

                    <div>

                        <div class="info-title">
                            Order Confirmed
                        </div>

                        <div class="info-text">
                            Your order is being processed
                        </div>

                    </div>

                </div>


                <div class="info-card">

                    <div class="info-icon">
                        🚚
                    </div>

                    <div>

                        <div class="info-title">
                            Fast Delivery
                        </div>

                        <div class="info-text">
                            We'll keep you updated
                        </div>

                    </div>

                </div>


                <div class="info-card">

                    <div class="info-icon">
                        🔒
                    </div>

                    <div>

                        <div class="info-title">
                            Secure Order
                        </div>

                        <div class="info-text">
                            Your information is protected
                        </div>

                    </div>

                </div>


            </div>


            <!-- BUTTON -->

            <a
                href="{{ route('products.index') }}"
                class="shopping-btn"
            >

                🛍️

                Continue Shopping

                →

            </a>


            <!-- SECURITY -->

            <div class="security-row">

                <span>
                    🔒 Secure
                </span>

                <span>
                    🛡️ Protected
                </span>

                <span>
                    ⚡ SMART BASKET
                </span>

            </div>

        </div>

    </div>

</div>


<!-- ==============================================================
     AI HUB
=============================================================== -->

<x-ai-hub-sidebar />


<script>

(function () {

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER THEME
    |--------------------------------------------------------------------------
    |
    | dark  = Dark
    | light = Light
    | system = Browser / Windows theme
    |
    */

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
    | INITIAL THEME
    |--------------------------------------------------------------------------
    */

    applyTheme(savedTheme);


    /*
    |--------------------------------------------------------------------------
    | SYSTEM MODE CHANGE
    |--------------------------------------------------------------------------
    */

    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    function handleThemeChange() {

        if (
            body.dataset.customerTheme === 'system'
        ) {

            applyTheme('system');

        }

    }


    if (media.addEventListener) {

        media.addEventListener(
            'change',
            handleThemeChange
        );

    } else if (media.addListener) {

        media.addListener(
            handleThemeChange
        );

    }

})();

</script>


</body>
</html>
```

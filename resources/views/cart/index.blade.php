<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $customerTheme = auth()->check()
            ? (auth()->user()->dark_mode ?? 'system')
            : 'system';
    @endphp

    <title>SMART BASKET | My Cart</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>

        /* =========================================================
           SMART BASKET CART THEME
        ========================================================= */

        :root {

            --cart-bg: #f4f7fb;
            --cart-text: #0f172a;
            --cart-muted: #64748b;

            --cart-card: rgba(255,255,255,.90);
            --cart-input: #ffffff;

            --cart-border: rgba(15,23,42,.09);

            --cart-primary: #2563eb;
            --cart-primary-2: #7c3aed;

            --cart-success: #16a34a;
            --cart-danger: #ef4444;

            --cart-soft: rgba(148,163,184,.08);

            --cart-shadow:
                0 25px 70px rgba(15,23,42,.12);
        }


        /* ================= DARK ================= */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --cart-bg: #020617;
            --cart-text: #f8fafc;
            --cart-muted: #94a3b8;

            --cart-card: rgba(15,23,42,.88);
            --cart-input: #0f172a;

            --cart-border: rgba(255,255,255,.10);

            --cart-primary: #3b82f6;
            --cart-primary-2: #8b5cf6;

            --cart-success: #22c55e;
            --cart-danger: #f87171;

            --cart-soft: rgba(148,163,184,.07);

            --cart-shadow:
                0 30px 90px rgba(0,0,0,.48);
        }


        /* ================= BODY ================= */

        html,
        body {

            min-height: 100%;

        }


        body {

            margin: 0;

            color: var(--cart-text);

            background:

                radial-gradient(
                    circle at 10% 0%,
                    rgba(37,99,235,.16),
                    transparent 32%
                ),

                radial-gradient(
                    circle at 90% 10%,
                    rgba(124,58,237,.14),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(14,165,233,.08),
                    transparent 35%
                ),

                var(--cart-bg);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            transition:
                background .3s ease,
                color .3s ease;
        }


        /* ================= PAGE ================= */

        .cart-page {

            min-height: 100vh;

            padding:
                45px 15px 90px;
        }


        .cart-container {

            max-width: 1150px;

            margin: auto;
        }


        /* ================= HEADER ================= */

        .cart-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 30px;
        }


        .cart-heading {

            display: flex;

            align-items: center;

            gap: 15px;
        }


        .cart-icon {

            width: 62px;
            height: 62px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background:

                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            font-size: 29px;

            box-shadow:
                0 15px 35px rgba(37,99,235,.25);
        }


        .cart-title {

            margin: 0;

            font-size: 34px;

            font-weight: 900;

            letter-spacing: -.8px;
        }


        .cart-subtitle {

            margin: 5px 0 0;

            color: var(--cart-muted);

            font-size: 14px;
        }


        /* ================= HEADER BUTTONS ================= */

        .top-actions {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;
        }


        .top-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding: 11px 16px;

            border-radius: 13px;

            color: var(--cart-text);

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            text-decoration: none;

            font-size: 14px;

            font-weight: 750;

            box-shadow:
                0 8px 25px rgba(15,23,42,.06);

            transition: .25s ease;
        }


        .top-btn:hover {

            color: var(--cart-primary);

            transform: translateY(-2px);

            border-color:
                rgba(37,99,235,.35);
        }


        /* ================= MAIN ================= */

        .cart-panel {

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            border-radius: 28px;

            padding: 25px;

            box-shadow: var(--cart-shadow);

            backdrop-filter: blur(20px);

            -webkit-backdrop-filter: blur(20px);

            transition: .3s ease;
        }


        /* ================= PRODUCT ================= */

        .cart-item {

            position: relative;

            display: flex;

            align-items: center;

            gap: 20px;

            padding: 20px;

            margin-bottom: 15px;

            border-radius: 21px;

            background: var(--cart-soft);

            border: 1px solid var(--cart-border);

            transition: .25s ease;
        }


        .cart-item:hover {

            transform: translateY(-3px);

            border-color:
                rgba(37,99,235,.30);

            box-shadow:
                0 12px 35px rgba(37,99,235,.08);
        }


        /* IMAGE */

        .product-image-wrapper {

            width: 105px;
            height: 105px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 19px;

            background: var(--cart-input);

            border: 1px solid var(--cart-border);

            overflow: hidden;

            box-shadow:
                0 10px 25px rgba(0,0,0,.10);
        }


        .product-image {

            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .product-placeholder {

            font-size: 38px;
        }


        /* INFO */

        .product-info {

            flex: 1;

            min-width: 0;
        }


        .product-name {

            color: var(--cart-text);

            font-size: 19px;

            font-weight: 850;

            margin-bottom: 7px;
        }


        .product-price {

            color: var(--cart-primary);

            font-size: 16px;

            font-weight: 800;

            margin-bottom: 7px;
        }


        .stock-badge {

            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            border-radius: 999px;

            background:
                rgba(34,197,94,.10);

            border:
                1px solid rgba(34,197,94,.18);

            color: var(--cart-success);

            font-size: 12px;

            font-weight: 750;
        }


        /* ================= CONTROLS ================= */

        .cart-controls {

            min-width: 230px;
        }


        .quantity-form {

            display: flex;

            gap: 8px;

            margin-bottom: 9px;
        }


        .quantity-input {

            width: 82px;

            height: 45px;

            border-radius: 12px;

            background: var(--cart-input) !important;

            color: var(--cart-text) !important;

            border:
                1px solid var(--cart-border) !important;

            text-align: center;

            font-weight: 750;

            box-shadow: none !important;
        }


        .quantity-input:focus {

            border-color:
                var(--cart-primary) !important;

            box-shadow:
                0 0 0 4px
                rgba(37,99,235,.12) !important;
        }


        .update-btn {

            flex: 1;

            border: 0;

            border-radius: 12px;

            background:
                rgba(37,99,235,.10);

            color: var(--cart-primary);

            border:
                1px solid rgba(37,99,235,.18);

            font-weight: 800;

            transition: .2s ease;
        }


        .update-btn:hover {

            color: white;

            background:
                var(--cart-primary);

            transform: translateY(-1px);
        }


        .remove-btn {

            width: 100%;

            min-height: 42px;

            border-radius: 12px;

            background:
                rgba(239,68,68,.08);

            color: var(--cart-danger);

            border:
                1px solid rgba(239,68,68,.18);

            font-weight: 750;

            transition: .2s ease;
        }


        .remove-btn:hover {

            background: var(--cart-danger);

            color: white;

            transform: translateY(-1px);
        }


        /* ================= SUMMARY ================= */

        .summary-card {

            position: sticky;

            top: 25px;

            padding: 25px;

            border-radius: 23px;

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            box-shadow: var(--cart-shadow);

            backdrop-filter: blur(20px);
        }


        .summary-title {

            display: flex;

            align-items: center;

            gap: 10px;

            color: var(--cart-text);

            font-size: 20px;

            font-weight: 850;

            margin-bottom: 20px;
        }


        .summary-icon {

            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;
        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            gap: 15px;

            padding: 9px 0;

            color: var(--cart-muted);
        }


        .summary-row strong {

            color: var(--cart-text);
        }


        .summary-divider {

            border: 0;

            border-top:
                1px solid var(--cart-border);

            margin: 14px 0;
        }


        .summary-total {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }


        .summary-total span {

            font-size: 18px;

            font-weight: 850;
        }


        .summary-total strong {

            color: var(--cart-success);

            font-size: 25px;

            font-weight: 900;
        }


        /* ================= CHECKOUT ================= */

        .checkout-btn {

            width: 100%;

            min-height: 58px;

            margin-top: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            border: 0;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            text-decoration: none;

            font-size: 16px;

            font-weight: 850;

            box-shadow:
                0 15px 35px rgba(37,99,235,.25);

            transition: .25s ease;
        }


        .checkout-btn:hover {

            color: white;

            transform: translateY(-3px);

            box-shadow:
                0 22px 45px rgba(37,99,235,.35);
        }


        /* ================= EMPTY ================= */

        .empty-cart {

            text-align: center;

            padding: 70px 20px;
        }


        .empty-cart-icon {

            width: 105px;
            height: 105px;

            margin:
                0 auto 22px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 30px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.10)
                );

            border:
                1px solid var(--cart-border);

            font-size: 50px;
        }


        .empty-cart h2 {

            color: var(--cart-text);

            font-size: 25px;

            font-weight: 900;
        }


        .empty-cart p {

            color: var(--cart-muted);

            margin: 8px auto 22px;

            max-width: 450px;
        }


        .browse-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 12px 20px;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            text-decoration: none;

            font-weight: 800;

            transition: .25s ease;
        }


        .browse-btn:hover {

            color: white;

            transform: translateY(-2px);
        }


        /* ================= SECURITY ================= */

        .security-row {

            display: flex;

            justify-content: center;

            flex-wrap: wrap;

            gap: 20px;

            margin-top: 24px;

            color: var(--cart-muted);

            font-size: 12px;

            font-weight: 650;
        }


        /* ================= MOBILE ================= */

        @media(max-width: 850px) {

            .cart-header {

                align-items: flex-start;

                flex-direction: column;
            }

            .cart-item {

                align-items: flex-start;

                flex-wrap: wrap;
            }

            .cart-controls {

                width: 100%;

                min-width: 0;
            }

            .summary-card {

                position: static;
            }
        }


        @media(max-width: 600px) {

            .cart-page {

                padding:
                    25px 10px 60px;
            }

            .cart-title {

                font-size: 27px;
            }

            .cart-panel {

                padding: 15px;

                border-radius: 22px;
            }

            .cart-item {

                padding: 15px;

                gap: 14px;

                border-radius: 18px;
            }

            .product-image-wrapper {

                width: 78px;
                height: 78px;
            }

            .product-name {

                font-size: 16px;
            }

            .top-actions {

                width: 100%;
            }

            .top-btn {

                flex: 1;
            }
        }

    </style>

</head>


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


<div class="cart-page">

    <div class="cart-container">


        {{-- ================= HEADER ================= --}}

        <div class="cart-header">

            <div class="cart-heading">

                <div class="cart-icon">
                    🛒
                </div>

                <div>

                    <h1 class="cart-title">
                        My Cart
                    </h1>

                    <p class="cart-subtitle">
                        Review your items before placing your order.
                    </p>

                </div>

            </div>


            <div class="top-actions">

                <a
                    href="{{ route('profile') }}"
                    class="top-btn"
                >
                    👤 Profile
                </a>

                <a
                    href="{{ url('/products') }}"
                    class="top-btn"
                >
                    🛍️ Continue Shopping
                </a>

            </div>

        </div>



        {{-- ================= CART ================= --}}

        @if($cartItems->count())

            <div class="row g-4">


                {{-- PRODUCTS --}}

                <div class="col-lg-8">

                    <div class="cart-panel">

                        @foreach($cartItems as $item)

                            <div class="cart-item">


                                {{-- PRODUCT IMAGE --}}

                                <div class="product-image-wrapper">

                                    @if($item->product?->image)

                                        <img
                                            src="{{ asset('products/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="product-image"
                                        >

                                    @else

                                        <div class="product-placeholder">
                                            🛍️
                                        </div>

                                    @endif

                                </div>


                                {{-- PRODUCT INFO --}}

                                <div class="product-info">

                                    <div class="product-name">
                                        {{ $item->product?->name ?? 'Product' }}
                                    </div>


                                    <div class="product-price">

                                        ₹{{ number_format(
                                            (float) ($item->product?->price ?? 0),
                                            2
                                        ) }}

                                    </div>


                                    <span class="stock-badge">

                                        ● Stock:
                                        {{ $item->product?->stock ?? 0 }}

                                    </span>

                                </div>


                                {{-- CONTROLS --}}

                                <div class="cart-controls">


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'cart.update',
                                            $item->product_id
                                        ) }}"
                                        class="quantity-form"
                                    >

                                        @csrf

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            class="quantity-input"
                                            required
                                        >


                                        <button
                                            type="submit"
                                            class="update-btn"
                                        >
                                            Update
                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'cart.remove',
                                            $item->id
                                        ) }}"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="remove-btn"
                                        >
                                            🗑️ Remove Item
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>



                {{-- ================= SUMMARY ================= --}}

                <div class="col-lg-4">

                    <div class="summary-card">

                        <div class="summary-title">

                            <div class="summary-icon">
                                🧾
                            </div>

                            Order Summary

                        </div>


                        <div class="summary-row">

                            <span>
                                Items
                            </span>

                            <strong>
                                {{ $cartItems->sum('quantity') }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                ₹{{ number_format(
                                    (float) $subtotal,
                                    2
                                ) }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Delivery
                            </span>

                            <strong>
                                Free
                            </strong>

                        </div>


                        <hr class="summary-divider">


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                ₹{{ number_format(
                                    (float) $subtotal,
                                    2
                                ) }}
                            </strong>

                        </div>


                        <a
                            href="{{ url('/checkout') }}"
                            class="checkout-btn"
                        >
                            Proceed to Checkout
                            🚀
                        </a>


                        <div class="security-row">

                            <span>
                                🔒 Secure
                            </span>

                            <span>
                                🛡️ Protected
                            </span>

                            <span>
                                ⚡ Fast
                            </span>

                        </div>

                    </div>

                </div>

            </div>


        @else


            {{-- ================= EMPTY ================= --}}

            <div class="cart-panel">

                <div class="empty-cart">

                    <div class="empty-cart-icon">
                        🛒
                    </div>

                    <h2>
                        Your Cart is Empty
                    </h2>

                    <p>
                        You haven't added any products yet.
                        Explore SMART BASKET and start shopping.
                    </p>

                    <a
                        href="{{ url('/products') }}"
                        class="browse-btn"
                    >
                        🛍️ Browse Products
                    </a>

                </div>

            </div>


        @endif

    </div>

</div>



{{-- ================= THEME SYSTEM ================= --}}

<script>

(function () {

    const savedTheme =
        document.body.dataset.customerTheme || 'system';


    function applyTheme(theme) {

        let finalTheme = theme;


        if (theme === 'system') {

            finalTheme =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';
        }


        document.documentElement.setAttribute(
            'data-sb-theme',
            finalTheme
        );


        document.body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

    }


    applyTheme(savedTheme);


    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    media.addEventListener(
        'change',
        function () {

            if (savedTheme === 'system') {

                applyTheme('system');

            }

        }
    );

})();

</script>


<x-ai-hub-sidebar />

</body>
</html>
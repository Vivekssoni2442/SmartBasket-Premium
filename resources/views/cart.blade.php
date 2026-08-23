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

    <meta name="theme-setting" content="{{ $customerTheme }}">

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
        :root {
            --cart-bg: #f4f7fb;
            --cart-text: #0f172a;
            --cart-muted: #64748b;
            --cart-card: rgba(255,255,255,.88);
            --cart-card-solid: #ffffff;
            --cart-border: rgba(15,23,42,.09);
            --cart-shadow: 0 25px 70px rgba(15,23,42,.10);

            --cart-primary: #2563eb;
            --cart-primary-2: #7c3aed;

            --cart-success: #16a34a;
            --cart-success-bg: rgba(22,163,74,.10);

            --cart-soft: rgba(148,163,184,.08);
            --cart-hover: rgba(37,99,235,.06);
        }

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --cart-bg: #020617;
            --cart-text: #f8fafc;
            --cart-muted: #94a3b8;

            --cart-card: rgba(15,23,42,.86);
            --cart-card-solid: #0f172a;

            --cart-border: rgba(255,255,255,.10);

            --cart-shadow:
                0 30px 90px rgba(0,0,0,.48);

            --cart-primary: #3b82f6;
            --cart-primary-2: #8b5cf6;

            --cart-success: #22c55e;
            --cart-success-bg: rgba(34,197,94,.12);

            --cart-soft: rgba(148,163,184,.08);
            --cart-hover: rgba(59,130,246,.10);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;

            background:
                radial-gradient(
                    circle at 10% 0%,
                    rgba(37,99,235,.16),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(124,58,237,.14),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(14,165,233,.08),
                    transparent 35%
                ),
                var(--cart-bg);

            color: var(--cart-text);

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

        .cart-wrapper {
            min-height: 100vh;
            padding: 45px 15px 90px;
        }

        .cart-container {
            max-width: 1100px;
            margin: auto;
        }

        /* HEADER */

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;

            margin-bottom: 30px;
        }

        .cart-heading-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cart-icon {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            font-size: 27px;

            box-shadow:
                0 15px 35px rgba(37,99,235,.25);
        }

        .cart-title {
            margin: 0;

            font-size: 34px;
            font-weight: 850;
            letter-spacing: -.8px;
        }

        .cart-subtitle {
            margin: 5px 0 0;

            color: var(--cart-muted);

            font-size: 14px;
        }

        .continue-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 11px 17px;

            border-radius: 13px;

            color: var(--cart-text);
            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            text-decoration: none;
            font-weight: 700;

            box-shadow: 0 8px 25px rgba(15,23,42,.07);

            transition: .25s ease;
        }

        .continue-btn:hover {
            color: var(--cart-primary);
            transform: translateY(-2px);
            border-color: rgba(37,99,235,.30);
        }

        /* MAIN CARD */

        .cart-main {
            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            border-radius: 28px;

            padding: 25px;

            box-shadow: var(--cart-shadow);

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            transition:
                background .3s ease,
                border-color .3s ease,
                box-shadow .3s ease;
        }

        /* PRODUCT */

        .cart-item {
            display: flex;
            align-items: center;
            gap: 20px;

            padding: 20px;

            border-radius: 20px;

            background: var(--cart-soft);

            border: 1px solid var(--cart-border);

            margin-bottom: 15px;

            transition:
                transform .25s ease,
                background .25s ease,
                border-color .25s ease;
        }

        .cart-item:hover {
            transform: translateY(-3px);

            background: var(--cart-hover);

            border-color: rgba(37,99,235,.25);
        }

        .product-image {
            width: 88px;
            height: 88px;

            flex-shrink: 0;

            border-radius: 18px;

            object-fit: cover;

            background: var(--cart-card-solid);

            border: 1px solid var(--cart-border);

            box-shadow: 0 10px 25px rgba(0,0,0,.10);
        }

        .product-placeholder {
            width: 88px;
            height: 88px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            font-size: 30px;
        }

        .product-info {
            flex: 1;
            min-width: 0;
        }

        .product-name {
            color: var(--cart-text);

            font-size: 18px;
            font-weight: 800;

            margin-bottom: 6px;
        }

        .product-unit-price {
            color: var(--cart-muted);

            font-size: 13px;
        }

        .quantity-badge {
            display: inline-flex;

            align-items: center;

            margin-top: 9px;

            padding: 6px 11px;

            border-radius: 999px;

            background: rgba(37,99,235,.10);

            color: var(--cart-primary);

            border: 1px solid rgba(37,99,235,.16);

            font-size: 12px;
            font-weight: 800;
        }

        .item-total {
            text-align: right;

            min-width: 150px;
        }

        .item-total-label {
            display: block;

            color: var(--cart-muted);

            font-size: 12px;

            margin-bottom: 4px;
        }

        .item-total-price {
            color: var(--cart-success);

            font-size: 20px;
            font-weight: 850;
        }

        /* SUMMARY */

        .cart-summary {
            margin-top: 25px;

            padding: 22px;

            border-radius: 22px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.08),
                    rgba(124,58,237,.08)
                );

            border: 1px solid var(--cart-border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 8px 0;

            color: var(--cart-muted);
        }

        .summary-row strong {
            color: var(--cart-text);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-top: 12px;
            padding-top: 17px;

            border-top: 1px solid var(--cart-border);
        }

        .summary-total span {
            font-size: 18px;
            font-weight: 800;
        }

        .summary-total strong {
            font-size: 25px;
            font-weight: 900;

            color: var(--cart-success);
        }

        /* CHECKOUT BUTTON */

        .checkout-btn {
            width: 100%;

            min-height: 58px;

            margin-top: 18px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            border: 0;
            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            font-size: 16px;
            font-weight: 850;

            text-decoration: none;

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

        /* EMPTY */

        .empty-cart {
            text-align: center;

            padding: 65px 25px;
        }

        .empty-icon {
            width: 105px;
            height: 105px;

            margin: 0 auto 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 30px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.12),
                    rgba(124,58,237,.12)
                );

            border: 1px solid var(--cart-border);

            font-size: 48px;
        }

        .empty-cart h2 {
            color: var(--cart-text);

            font-size: 25px;
            font-weight: 850;
        }

        .empty-cart p {
            color: var(--cart-muted);

            max-width: 450px;

            margin: 8px auto 22px;
        }

        .browse-btn {
            display: inline-flex;

            padding: 12px 20px;

            border-radius: 13px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            text-decoration: none;

            font-weight: 800;

            transition: .25s ease;
        }

        .browse-btn:hover {
            color: white;
            transform: translateY(-2px);
        }

        /* SECURITY */

        .cart-security {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;

            gap: 20px;

            margin-top: 25px;

            color: var(--cart-muted);

            font-size: 12px;
            font-weight: 600;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* MOBILE */

        @media (max-width: 700px) {

            .cart-wrapper {
                padding: 25px 10px 60px;
            }

            .cart-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .cart-title {
                font-size: 27px;
            }

            .cart-main {
                padding: 15px;

                border-radius: 22px;
            }

            .cart-item {
                align-items: flex-start;
                flex-wrap: wrap;

                padding: 15px;
            }

            .product-image,
            .product-placeholder {
                width: 70px;
                height: 70px;
            }

            .product-name {
                font-size: 16px;
            }

            .item-total {
                width: 100%;

                min-width: 0;

                text-align: left;

                padding-left: 90px;
            }

            .cart-summary {
                padding: 18px;
            }
        }
    </style>
</head>

@php
    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';
@endphp

<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>

<div class="cart-wrapper">

    <div class="cart-container">

        {{-- HEADER --}}
        <div class="cart-header">

            <div class="cart-heading-area">

                <div class="cart-icon">
                    🛒
                </div>

                <div>
                    <h1 class="cart-title">
                        Your Cart
                    </h1>

                    <p class="cart-subtitle">
                        Review your products before checkout.
                    </p>
                </div>

            </div>

            <a
                href="{{ url('/products') }}"
                class="continue-btn"
            >
                ← Continue Shopping
            </a>

        </div>


        @php
            $cart = session('cart', []);

            $cartTotal = 0;
            $cartCount = 0;

            foreach ($cart as $id => $item) {
                $product = \App\Models\Product::find($id);

                if ($product) {
                    $quantity = (int) ($item['quantity'] ?? 1);

                    $cartTotal +=
                        (float) $product->price * $quantity;

                    $cartCount += $quantity;
                }
            }
        @endphp


        {{-- MAIN --}}
        <div class="cart-main">

            @if(count($cart) == 0)

                {{-- EMPTY CART --}}
                <div class="empty-cart">

                    <div class="empty-icon">
                        🛒
                    </div>

                    <h2>
                        Your Cart is Empty
                    </h2>

                    <p>
                        Looks like you haven't added anything yet.
                        Explore our products and find something you love.
                    </p>

                    <a
                        href="{{ url('/products') }}"
                        class="browse-btn"
                    >
                        🛍️ Browse Products
                    </a>

                </div>

            @else

                {{-- CART ITEMS --}}
                @foreach($cart as $id => $item)

                    @php
                        $product =
                            \App\Models\Product::find($id);

                        $quantity =
                            (int) ($item['quantity'] ?? 1);
                    @endphp

                    @if($product)

                        <div class="cart-item">

                            {{-- PRODUCT IMAGE --}}
                            @if($product->image)

                                <img
                                    src="{{ asset('products/'.$product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image"
                                >

                            @else

                                <div class="product-placeholder">
                                    🛍️
                                </div>

                            @endif


                            {{-- PRODUCT INFO --}}
                            <div class="product-info">

                                <div class="product-name">
                                    {{ $product->name }}
                                </div>

                                <div class="product-unit-price">
                                    ₹{{ number_format((float) $product->price, 2) }}
                                    per item
                                </div>

                                <div class="quantity-badge">
                                    Quantity: {{ $quantity }}
                                </div>

                            </div>


                            {{-- TOTAL --}}
                            <div class="item-total">

                                <span class="item-total-label">
                                    Item Total
                                </span>

                                <span class="item-total-price">
                                    ₹{{ number_format(
                                        (float) $product->price * $quantity,
                                        2
                                    ) }}
                                </span>

                            </div>

                        </div>

                    @endif

                @endforeach


                {{-- SUMMARY --}}
                <div class="cart-summary">

                    <div class="summary-row">

                        <span>
                            Total Items
                        </span>

                        <strong>
                            {{ $cartCount }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            ₹{{ number_format($cartTotal, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Delivery
                        </span>

                        <strong>
                            Calculated at checkout
                        </strong>

                    </div>


                    <div class="summary-total">

                        <span>
                            Cart Total
                        </span>

                        <strong>
                            ₹{{ number_format($cartTotal, 2) }}
                        </strong>

                    </div>


                    <a
                        href="{{ url('/checkout') }}"
                        class="checkout-btn"
                    >
                        Proceed to Checkout
                        <span>🚀</span>
                    </a>

                </div>


                {{-- SECURITY --}}
                <div class="cart-security">

                    <div class="security-item">
                        🔒 Secure Checkout
                    </div>

                    <div class="security-item">
                        🛡️ Protected Payment
                    </div>

                    <div class="security-item">
                        ⚡ Fast Delivery
                    </div>

                    <div class="security-item">
                        ✓ Trusted Shopping
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- CUSTOMER THEME --}}
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

    media.addEventListener('change', function () {

        if (savedTheme === 'system') {
            applyTheme('system');
        }

    });

})();
</script>


<x-ai-hub-sidebar />

</body>
</html>
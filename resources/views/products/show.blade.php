<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $product->name }} | SMART BASKET
    </title>


    <script>
        (() => {

            const saved =
                localStorage.getItem('sb-theme');

            const userTheme =
                @auth
                    @json(auth()->user()->theme ?? 'dark')
                @else
                    'dark'
                @endauth;

            const theme =
                ['light','dark'].includes(saved)
                    ? saved
                    : (
                        ['light','dark'].includes(userTheme)
                            ? userTheme
                            : 'dark'
                    );

            document.documentElement
                .setAttribute(
                    'data-theme',
                    theme
                );

        })();
    </script>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    <style>

        :root {

            --bg:#f5f7fb;

            --card:#ffffff;

            --card2:#f8fafc;

            --text:#102033;

            --muted:#718096;

            --border:#e2e8f0;

            --primary:#2563eb;

            --primary2:#7c3aed;

            --success:#16a34a;

            --danger:#e05b72;

            --shadow:
                0 20px 60px rgba(15,23,42,.09);

            --menu-shadow:
                0 25px 70px rgba(15,23,42,.18);

        }


        html[data-theme="dark"] {

            --bg:#07111f;

            --card:#0e1b2d;

            --card2:#14263d;

            --text:#f4f8ff;

            --muted:#9aacc1;

            --border:#29405c;

            --primary:#70a8ff;

            --primary2:#8b7cff;

            --success:#45cf8c;

            --danger:#ef8095;

            --shadow:
                0 25px 70px rgba(0,0,0,.35);

            --menu-shadow:
                0 28px 80px rgba(0,0,0,.48);

        }


        * {
            box-sizing:border-box;
        }


        html {
            scroll-behavior:smooth;
            background:var(--bg);
        }


        body {

            margin:0;

            min-height:100vh;

            color:var(--text);

            font-family:
                Inter,
                Poppins,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 0 0,
                    rgba(37,99,235,.12),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 100% 5%,
                    rgba(124,58,237,.10),
                    transparent 28%
                ),
                var(--bg);

        }


        a {
            text-decoration:none !important;
        }


        /* =====================================================
           TOP
        ====================================================== */

        .wrap {

            max-width:1320px;

            margin:auto;

            padding:
                25px 20px 70px;

        }


        .top {

            position:sticky;

            top:12px;

            z-index:3000;

            display:flex;

            justify-content:space-between;

            align-items:center;

            gap:15px;

            padding:
                13px 17px;

            margin-bottom:22px;

            background:
                color-mix(
                    in srgb,
                    var(--card) 93%,
                    transparent
                );

            border:
                1px solid var(--border);

            border-radius:
                20px;

            box-shadow:
                var(--shadow);

            backdrop-filter:
                blur(20px);

        }


        .brand {

            display:flex;

            align-items:center;

            gap:11px;

            color:var(--text);

            font-weight:950;

        }


        .brand-icon {

            width:44px;

            height:44px;

            display:grid;

            place-items:center;

            border-radius:14px;

            color:#fff;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            box-shadow:
                0 12px 28px
                rgba(37,99,235,.25);

        }


        .brand-text strong {

            display:block;

            color:var(--primary);

            font-size:14px;

            letter-spacing:.13em;

        }


        .brand-text small {

            display:block;

            margin-top:3px;

            color:var(--muted);

            font-size:9px;

            letter-spacing:.13em;

        }


        /* =====================================================
           3 DOT MENU
        ====================================================== */

        .menu-wrap {

            position:relative;

        }


        .menu-button {

            width:48px;

            height:48px;

            display:grid;

            place-items:center;

            border:
                1px solid var(--border);

            border-radius:15px;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:20px;

            cursor:pointer;

            transition:.2s ease;

            box-shadow:
                0 8px 24px var(--shadow);

        }


        .menu-button:hover,
        .menu-button.active {

            color:#fff;

            border-color:transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            transform:
                translateY(-2px);

        }


        .customer-menu {

            position:absolute;

            right:0;

            top:
                calc(100% + 12px);

            width:285px;

            padding:10px;

            border:
                1px solid var(--border);

            border-radius:20px;

            background:
                var(--card);

            box-shadow:
                var(--menu-shadow);

            backdrop-filter:
                blur(25px);

            opacity:0;

            visibility:hidden;

            transform:
                translateY(-8px)
                scale(.97);

            transform-origin:
                top right;

            transition:.2s ease;

        }


        .customer-menu.open {

            opacity:1;

            visibility:visible;

            transform:
                translateY(0)
                scale(1);

        }


        .menu-header {

            padding:
                13px 14px;

            margin-bottom:6px;

            border-radius:15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.07)
                );

            border:
                1px solid var(--border);

        }


        .menu-header strong {

            display:block;

            color:var(--text);

            font-size:14px;

            font-weight:900;

        }


        .menu-header span {

            display:block;

            margin-top:3px;

            color:var(--muted);

            font-size:11px;

        }


        .menu-item {

            width:100%;

            display:flex;

            align-items:center;

            gap:12px;

            padding:12px;

            margin:3px 0;

            border:
                1px solid transparent;

            border-radius:13px;

            background:transparent;

            color:var(--text);

            font-size:12px;

            font-weight:800;

            transition:.18s ease;

        }


        .menu-item:hover {

            color:var(--primary);

            background:var(--card2);

            border-color:var(--border);

            transform:
                translateX(3px);

        }


        .menu-icon {

            width:35px;

            height:35px;

            display:grid;

            place-items:center;

            flex-shrink:0;

            border-radius:11px;

            color:var(--primary);

            background:
                rgba(37,99,235,.10);

        }


        .menu-divider {

            height:1px;

            margin:
                8px 4px;

            background:
                var(--border);

        }


        .menu-item.logout {

            color:
                var(--danger);

        }


        .menu-item.logout
        .menu-icon {

            color:
                var(--danger);

            background:
                rgba(224,91,114,.10);

        }


        .menu-overlay {

            position:fixed;

            inset:0;

            z-index:2500;

            background:
                rgba(2,6,23,.18);

            backdrop-filter:
                blur(2px);

            opacity:0;

            visibility:hidden;

            transition:.2s ease;

        }


        .menu-overlay.open {

            opacity:1;

            visibility:visible;

        }


        /* =====================================================
           PRODUCT
        ====================================================== */

        .product-shell {

            padding:
                25px;

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius:
                28px;

            box-shadow:
                var(--shadow);

        }


        /* =====================================================
           GALLERY
        ====================================================== */

        .gallery-box {

            height:560px;

            display:grid;

            place-items:center;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                24px;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.10),
                    transparent 62%
                ),
                var(--card2);

        }


        .main-image {

            width:100%;

            height:100%;

            object-fit:contain;

            padding:28px;

            transition:.35s ease;

        }


        .main-image:hover {

            transform:
                scale(1.025);

        }


        .thumbs {

            display:flex;

            gap:9px;

            flex-wrap:wrap;

            margin-top:13px;

        }


        .thumb {

            width:72px;

            height:72px;

            padding:3px;

            overflow:hidden;

            border:
                2px solid var(--border);

            border-radius:14px;

            background:
                var(--card);

            cursor:pointer;

            transition:.2s ease;

        }


        .thumb:hover,
        .thumb.active {

            border-color:
                var(--primary);

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px var(--shadow);

        }


        .thumb img {

            width:100%;

            height:100%;

            object-fit:cover;

            border-radius:9px;

        }


        /* =====================================================
           PRODUCT INFO
        ====================================================== */

        .info {

            padding:
                8px 6px;

        }


        .category {

            display:inline-flex;

            padding:
                7px 11px;

            border-radius:
                999px;

            color:
                var(--primary);

            background:
                rgba(37,99,235,.10);

            font-size:
                10px;

            font-weight:
                950;

            text-transform:
                uppercase;

            letter-spacing:
                .08em;

        }


        .title {

            margin:
                15px 0 10px;

            color:
                var(--text);

            font-size:
                clamp(
                    30px,
                    4vw,
                    48px
                );

            line-height:
                1.04;

            letter-spacing:
                -.045em;

            font-weight:
                950;

        }


        .desc {

            margin:0;

            color:
                var(--muted);

            line-height:
                1.8;

            font-size:
                14px;

        }


        /* =====================================================
           PRICE
        ====================================================== */

        .price-row {

            display:flex;

            align-items:center;

            gap:11px;

            flex-wrap:wrap;

            margin:
                21px 0;

        }


        .price {

            color:
                var(--text);

            font-size:
                35px;

            font-weight:
                950;

        }


        .old {

            color:
                var(--muted);

            font-size:
                13px;

            text-decoration:
                line-through;

        }


        .discount {

            padding:
                7px 10px;

            border-radius:
                9px;

            color:
                var(--success);

            background:
                rgba(22,163,74,.11);

            font-size:
                11px;

            font-weight:
                900;

        }


        /* =====================================================
           DETAILS
        ====================================================== */

        .details {

            display:grid;

            grid-template-columns:
                repeat(2,1fr);

            gap:9px;

            margin-top:
                18px;

        }


        .detail {

            padding:
                14px;

            border:
                1px solid var(--border);

            border-radius:
                14px;

            background:
                var(--card2);

            transition:.2s ease;

        }


        .detail:hover {

            border-color:
                var(--primary);

            transform:
                translateY(-2px);

        }


        .label {

            display:block;

            margin-bottom:
                4px;

            color:
                var(--muted);

            font-size:
                10px;

        }


        .value {

            color:
                var(--text);

            font-size:
                13px;

            font-weight:
                850;

        }


        /* =====================================================
           SELLER
        ====================================================== */

        .seller {

            margin-top:
                18px;

            padding:
                16px;

            border:
                1px solid var(--border);

            border-radius:
                17px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.05)
                );

        }


        .seller strong {

            display:block;

            margin:
                5px 0 2px;

            color:
                var(--text);

            font-size:
                16px;

        }


        .seller span {

            color:
                var(--muted);

            font-size:
                11px;

        }


        /* =====================================================
           BUTTONS
        ====================================================== */

        .actions {

            display:flex;

            flex-wrap:wrap;

            gap:9px;

            margin-top:
                19px;

        }


        .btnx {

            min-height:
                46px;

            display:inline-flex;

            align-items:center;

            justify-content:center;

            gap:7px;

            padding:
                10px 16px;

            border:
                1px solid var(--border);

            border-radius:
                12px;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:
                12px;

            font-weight:
                850;

            cursor:pointer;

            transition:.2s ease;

        }


        .btnx:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        .primary {

            color:#fff !important;

            border-color:
                transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

        }


        .primary:hover {

            color:#fff !important;

        }


        .success {

            color:#fff !important;

            border-color:
                transparent;

            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

        }


        .success:hover {

            color:#fff !important;

        }


        /* =====================================================
           QUANTITY
        ====================================================== */

        .qty {

            height:46px;

            display:inline-flex;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                12px;

            background:
                var(--card);

        }


        .qty button {

            width:43px;

            border:0;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:
                19px;

            cursor:pointer;

        }


        .qty input {

            width:56px;

            border:0;

            border-left:
                1px solid var(--border);

            border-right:
                1px solid var(--border);

            outline:0;

            text-align:center;

            background:
                var(--card);

            color:
                var(--text);

        }


        /* =====================================================
           AI TRY ON
        ====================================================== */

        .ai {

            margin-top:
                24px;

            padding:
                21px;

            border:
                1px solid var(--border);

            border-radius:
                21px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.06)
                );

        }


        .ai h2 {

            margin-bottom:
                7px;

            color:
                var(--text);

            font-size:
                20px;

            font-weight:
                950;

        }


        .ai p {

            color:
                var(--muted);

            font-size:
                12px;

        }


        .ai .form-control {

            background:
                var(--card);

            border-color:
                var(--border);

            color:
                var(--text);

        }


        #tryOnPreview,
        #tryOnResult {

            width:100%;

            max-height:
                520px;

            object-fit:
                contain;

            border:
                1px solid var(--border);

            border-radius:
                17px;

            box-shadow:
                var(--shadow);

        }


        /* =====================================================
           RELATED
        ====================================================== */

        .related {

            margin-top:
                34px;

        }


        .related-head {

            display:flex;

            align-items:center;

            justify-content:space-between;

            gap:15px;

            margin-bottom:
                15px;

        }


        .related-head h2 {

            margin:0;

            color:
                var(--text);

            font-size:
                26px;

            font-weight:
                950;

        }


        .view-all {

            display:inline-flex;

            align-items:center;

            gap:7px;

            padding:
                10px 13px;

            border:
                1px solid var(--border);

            border-radius:
                11px;

            background:
                var(--card);

            color:
                var(--text);

            font-size:
                11px;

            font-weight:
                850;

        }


        .view-all:hover {

            color:
                var(--primary);

            border-color:
                var(--primary);

        }


        .related-card {

            height:100%;

            display:block;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                19px;

            background:
                var(--card);

            box-shadow:
                0 10px 35px var(--shadow);

            transition:.25s ease;

        }


        .related-card:hover {

            transform:
                translateY(-6px);

            border-color:
                var(--primary);

        }

        .related-card--clickable { cursor:pointer; }

        .related-view-product {
            display:inline-flex;
            align-items:center;
            margin:0 12px 13px;
            padding:7px 10px;
            border-radius:9px;
            background:var(--primary);
            color:#fff;
            font-size:12px;
            font-weight:800;
            text-decoration:none;
        }

        .related-view-product:hover { color:#fff; filter:brightness(1.06); }


        .related-img {

            width:100%;

            height:195px;

            object-fit:contain;

            padding:10px;

            background:
                var(--card2);

        }


        .related-body {

            padding:
                14px;

        }


        .related-title {

            color:
                var(--text);

            font-size:
                13px;

            font-weight:
                850;

        }


        .related-price {

            margin-top:
                5px;

            color:
                var(--primary);

            font-size:
                15px;

            font-weight:
                950;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media(max-width:991px) {

            .gallery-box {
                height:430px;
            }

        }


        @media(max-width:575px) {

            .wrap {
                padding:
                    12px 12px 50px;
            }

            .top {
                top:8px;

                border-radius:
                    16px;
            }

            .brand-text small {
                display:none;
            }

            .menu-button {
                width:43px;
                height:43px;
            }

            .customer-menu {

                position:fixed;

                top:70px;

                right:12px;

                width:
                    min(
                        300px,
                        calc(100vw - 24px)
                    );

            }

            .product-shell {

                padding:
                    13px;

                border-radius:
                    20px;

            }

            .gallery-box {

                height:
                    330px;

                border-radius:
                    18px;

            }

            .main-image {
                padding:
                    15px;
            }

            .details {
                grid-template-columns:
                    1fr;
            }

            .actions > * {
                width:
                    100%;
            }

            .btnx {
                width:
                    100%;
            }

            .related-head {
                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

        }

    </style>

</head>


<body>


<!-- MENU OVERLAY -->

<div
    class="menu-overlay"
    id="menuOverlay"
    hidden
></div>


<div class="wrap">


    <!-- =====================================================
         TOP BAR
    ====================================================== -->

    <div class="top">

        <a
            href="{{ route('products.index') }}"
            class="brand"
        >

            <span class="brand-icon">

                <i class="fa-solid fa-basket-shopping"></i>

            </span>

            <span class="brand-text">

                <strong>
                    SMART BASKET
                </strong>

                <small>
                    PRODUCT DETAILS
                </small>

            </span>

        </a>


        <!-- 3 DOTS -->

        <div class="menu-wrap" hidden aria-hidden="true" style="display:none!important">

            <button
                type="button"
                class="menu-button"
                id="menuButton"
                aria-label="Open customer menu"
                aria-expanded="false"
            >

                <i class="fa-solid fa-ellipsis-vertical"></i>

            </button>


            <div
                class="customer-menu"
                id="customerMenu"
            >

                <div class="menu-header">

                    @auth

                        <strong>
                            Hi, {{ auth()->user()->name ?? 'Customer' }}
                        </strong>

                        <span>
                            Manage your Smart Basket account
                        </span>

                    @else

                        <strong>
                            SMART BASKET
                        </strong>

                        <span>
                            Your smarter shopping menu
                        </span>

                    @endauth

                </div>


                <a
                    href="{{ route('products.index') }}"
                    class="menu-item"
                >

                    <span class="menu-icon">
                        <i class="fa-solid fa-house"></i>
                    </span>

                    <span>
                        Home / Products
                    </span>

                </a>


                <a
                    href="{{ route('products.index') }}"
                    class="menu-item"
                >

                    <span class="menu-icon">
                        <i class="fa-solid fa-store"></i>
                    </span>

                    <span>
                        All Products
                    </span>

                </a>


                <a
                    href="{{ route('cart.index') }}"
                    class="menu-item"
                >

                    <span class="menu-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>

                    <span>
                        My Cart
                    </span>

                </a>


                @auth

                    <a
                        href="{{ route('wishlist') }}"
                        class="menu-item"
                    >

                        <span class="menu-icon">
                            <i class="fa-regular fa-heart"></i>
                        </span>

                        <span>
                            Wishlist
                        </span>

                    </a>


                    @if(Route::has('profile'))

                        <a
                            href="{{ route('profile') }}"
                            class="menu-item"
                        >

                            <span class="menu-icon">
                                <i class="fa-solid fa-user"></i>
                            </span>

                            <span>
                                My Profile
                            </span>

                        </a>

                    @endif


                    @if(Route::has('orders'))

                        <a
                            href="{{ route('orders') }}"
                            class="menu-item"
                        >

                            <span class="menu-icon">
                                <i class="fa-solid fa-box"></i>
                            </span>

                            <span>
                                My Orders
                            </span>

                        </a>

                    @endif


                    @if(Route::has('settings'))

                        <a
                            href="{{ route('settings') }}"
                            class="menu-item"
                        >

                            <span class="menu-icon">
                                <i class="fa-solid fa-gear"></i>
                            </span>

                            <span>
                                Settings
                            </span>

                        </a>

                    @endif


                    <div class="menu-divider"></div>


                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        style="margin:0"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="menu-item logout"
                        >

                            <span class="menu-icon">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </span>

                            <span>
                                Logout
                            </span>

                        </button>

                    </form>

                @endauth

            </div>

        </div>

    </div>


    <!-- =====================================================
         PRODUCT
    ====================================================== -->

    <div class="product-shell">

        <div class="row g-4">


            <!-- GALLERY -->

            <div class="col-lg-6">

                @php

                    $gallery = collect([
                        [
                            'url' =>
                                asset(
                                    'products/' .
                                    $product->image
                                ),

                            'label' => 'Main',

                            'image_id' => null
                        ]
                    ])->merge(

                        $product->images->map(
                            fn($image) => [
                                'url' =>
                                    asset(
                                        'storage/' .
                                        $image->path
                                    ),

                                'label' =>
                                    'Product view',

                                'image_id' =>
                                    $image->id
                            ]
                        )

                    );

                @endphp


                <div class="gallery-box">

                    <img
                        id="mainProductImage"
                        src="{{ $gallery->first()['url'] }}"
                        class="main-image"
                        alt="{{ $product->name }}"
                        onerror="this.style.opacity='.25'"
                    >

                </div>


                @if($gallery->count() > 1)

                    <div class="thumbs">

                        @foreach($gallery as $index => $image)

                            <button
                                type="button"
                                class="thumb {{ $index === 0 ? 'active' : '' }}"
                                data-image="{{ $image['url'] }}"
                                data-product-image-id="{{ $image['image_id'] }}"
                            >

                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['label'] }}"
                                >

                            </button>

                        @endforeach

                    </div>

                @endif

            </div>


            <!-- INFO -->

            <div class="col-lg-6">

                <div class="info">


                    @if($product->category)

                        <span class="category">
                            {{ $product->category }}
                        </span>

                    @endif


                    <h1 class="title">
                        {{ $product->name }}
                    </h1>


                    @php

                        $hasDiscount =
                            $product->discount_price !== null &&
                            (float)$product->discount_price <
                            (float)$product->price;

                        $finalPrice =
                            $hasDiscount
                            ? (float)$product->discount_price
                            : (float)$product->price;

                        $discountPercent =
                            $hasDiscount &&
                            (float)$product->price > 0
                            ? round(
                                (
                                    1 -
                                    (
                                        $finalPrice /
                                        (float)$product->price
                                    )
                                ) * 100
                            )
                            : 0;

                    @endphp


                    <div class="price-row">

                        <span class="price">
                            ₹{{ number_format($finalPrice,2) }}
                        </span>

                        @if($hasDiscount)

                            <span class="old">
                                ₹{{ number_format((float)$product->price,2) }}
                            </span>

                            <span class="discount">
                                {{ $discountPercent }}% OFF
                            </span>

                        @endif

                    </div>


                    @if($product->description)

                        <p class="desc">
                            {{ $product->description }}
                        </p>

                    @endif


                    <!-- DETAILS -->

                    <div class="details">

                        @if($product->brand)

                            <div class="detail">

                                <span class="label">
                                    Brand
                                </span>

                                <span class="value">
                                    {{ $product->brand }}
                                </span>

                            </div>

                        @endif


                        @if($product->rating !== null)

                            <div class="detail">

                                <span class="label">
                                    Rating
                                </span>

                                <span class="value">
                                    ⭐
                                    {{ number_format((float)$product->rating,1) }}
                                </span>

                            </div>

                        @endif


                        @if($product->stock !== null)

                            <div class="detail">

                                <span class="label">
                                    Available Stock
                                </span>

                                <span class="value">
                                    {{ $product->stock }}
                                </span>

                            </div>

                        @endif


                        @if($product->size)

                            <div class="detail">

                                <span class="label">
                                    Size
                                </span>

                                <span class="value">
                                    {{ $product->size }}
                                </span>

                            </div>

                        @endif


                        @if($product->color)

                            <div class="detail">

                                <span class="label">
                                    Color
                                </span>

                                <span class="value">
                                    {{ $product->color }}
                                </span>

                            </div>

                        @endif


                        @if($product->status)

                            <div class="detail">

                                <span class="label">
                                    Status
                                </span>

                                <span class="value">
                                    {{ ucfirst($product->status) }}
                                </span>

                            </div>

                        @endif

                    </div>


                    <!-- SELLER -->

                    @if($product->seller)

                        <div class="seller">

                            <span>
                                Sold by
                            </span>

                            <strong>
                                {{
                                    $product->seller->shop_name
                                    ?: $product->seller->seller_name
                                }}
                            </strong>

                            <span>

                                {{ $product->seller->seller_name }}

                                @if($product->seller->city)

                                    ·
                                    {{ $product->seller->city }}

                                @endif

                            </span>

                        </div>

                    @endif


                    <!-- WISHLIST -->

                    <div class="actions">

                        <a
                            href="{{ route('products.index') }}"
                            class="btnx"
                        >

                            <i class="fa-solid fa-arrow-left"></i>

                            Back

                        </a>


                        @auth

                            <form
                                action="{{ route('wishlist.add',$product->id) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    class="btnx"
                                    type="submit"
                                >

                                    <i class="fa-regular fa-heart"></i>

                                    Wishlist

                                </button>

                            </form>

                        @endauth

                    </div>


                    <!-- CART -->

                    <form
                        action="{{ route('cart.add',$product) }}"
                        method="POST"
                        class="actions"
                    >

                        @csrf


                        <div>

                            <span class="label mb-1">
                                Quantity
                            </span>


                            <div class="qty">

                                <button
                                    type="button"
                                    id="quantityMinus"
                                >
                                    −
                                </button>


                                <input
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    @if($product->stock!==null)
                                        max="{{ max(1,(int)$product->stock) }}"
                                    @endif
                                    type="number"
                                >


                                <button
                                    type="button"
                                    id="quantityPlus"
                                >
                                    +
                                </button>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btnx primary"
                            {{ $product->stock!==null && (int)$product->stock<1 ? 'disabled' : '' }}
                        >

                            <i class="fa-solid fa-cart-plus"></i>

                            Add to Cart

                        </button>


                        <a
                            class="btnx success"
                            href="{{ url('/buy-now/'.$product->id) }}"
                        >

                            <i class="fa-solid fa-bolt"></i>

                            Buy Now

                        </a>

                    </form>


                    <!-- AI TRY ON -->

                    <section
                        class="ai"
                        id="virtualTryOn"
                    >

                        <h2>
                            ✨ AI Virtual Try-On
                        </h2>

                        <p>
                            Upload your photo or use your camera
                            to create an AI visual preview.
                        </p>


                        <div
                            id="tryOnMessage"
                            class="alert d-none"
                            role="alert"
                        ></div>


                        <form
                            id="tryOnForm"
                            action="{{ route('products.virtual-try-on.generate',$product) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <input
                                type="hidden"
                                id="tryOnProductImageId"
                                name="product_image_id"
                            >


                            <input
                                class="form-control"
                                id="tryOnPhoto"
                                name="photo"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                capture="user"
                                required
                            >


                            <div class="actions">

                                <button
                                    class="btnx primary"
                                    type="submit"
                                    id="tryOnSubmit"
                                >
                                    ✨ Try Product On Me
                                </button>


                                <button
                                    class="btnx d-none"
                                    type="button"
                                    id="tryOnRemove"
                                >
                                    Remove Photo
                                </button>

                            </div>

                        </form>


                        <img
                            id="tryOnPreview"
                            class="img-fluid d-none mt-3"
                            alt="Customer photo preview"
                        >


                        <div
                            class="mt-4 d-none"
                            id="tryOnResultWrap"
                        >

                            <h3 class="h6 fw-bold">
                                AI Virtual Try-On Result
                            </h3>


                            <img
                                id="tryOnResult"
                                class="img-fluid"
                                alt="AI-generated virtual try-on preview"
                            >


                            <div class="actions">

                                <button
                                    class="btnx"
                                    type="button"
                                    id="tryOnAgain"
                                >
                                    🔄 Try Again
                                </button>


                                <label
                                    class="btnx"
                                    for="tryOnPhoto"
                                >
                                    📷 Change Photo
                                </label>


                                <button
                                    class="btnx"
                                    type="button"
                                    id="tryOnProductImage"
                                >
                                    🖼 Change Product Image
                                </button>


                                <form
                                    action="{{ route('cart.add',$product) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        class="btnx primary"
                                        type="submit"
                                    >
                                        🛒 Add to Cart
                                    </button>

                                </form>


                                <a
                                    class="btnx success"
                                    href="{{ url('/buy-now/'.$product->id) }}"
                                >
                                    ⚡ Buy Now
                                </a>

                            </div>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RELATED PRODUCTS
    ====================================================== -->

    @if($relatedProducts->isNotEmpty())

        <section class="related">

            <div class="related-head">

                <h2>
                    Related Products
                </h2>


                <a
                    href="{{ route('products.index') }}"
                    class="view-all"
                >

                    View All

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>


            <div class="row g-3">

                @foreach($relatedProducts as $related)

                    @php

                        $relatedPrice =
                            (float)(
                                $related->discount_price &&
                                $related->discount_price <
                                $related->price

                                    ? $related->discount_price

                                    : $related->price
                            );

                    @endphp


                    <div class="col-6 col-md-3">

                        <article
                            class="related-card related-card--clickable"
                            data-product-url="{{ route('product.show', $related) }}"
                            tabindex="0"
                            role="link"
                            aria-label="View {{ $related->name }}"
                        >

                            <img
                                class="related-img"
                                src="{{ asset('products/'.$related->image) }}"
                                alt="{{ $related->name }}"
                                onerror="this.style.opacity='.25'"
                            >


                            <div class="related-body">

                                <div class="related-title">
                                    {{ $related->name }}
                                </div>

                                <div class="related-price">
                                    ₹{{ number_format($relatedPrice,2) }}
                                </div>

                            </div>

                            <a href="{{ route('product.show', $related) }}" class="related-view-product">View Product</a>
                        </article>

                    </div>

                @endforeach

            </div>

        </section>

    @endif

</div>


<x-ai-hub-sidebar />


<script>

(() => {


    /* =====================================================
       THREE DOT MENU
    ====================================================== */

    const menuButton =
        document.getElementById('menuButton');

    const menu =
        document.getElementById('customerMenu');

    const overlay =
        document.getElementById('menuOverlay');


    function openMenu() {

        menu.classList.add('open');

        overlay.classList.add('open');

        menuButton.classList.add('active');

        menuButton.setAttribute(
            'aria-expanded',
            'true'
        );

    }


    function closeMenu() {

        menu.classList.remove('open');

        overlay.classList.remove('open');

        menuButton.classList.remove('active');

        menuButton.setAttribute(
            'aria-expanded',
            'false'
        );

    }


    menuButton.addEventListener(
        'click',
        event => {

            event.stopPropagation();

            if (
                menu.classList.contains('open')
            ) {

                closeMenu();

            } else {

                openMenu();

            }

        }
    );


    overlay.addEventListener(
        'click',
        closeMenu
    );


    document.addEventListener(
        'keydown',
        event => {

            if (
                event.key === 'Escape'
            ) {

                closeMenu();

            }

        }
    );


    document.querySelectorAll(
        '.customer-menu a'
    ).forEach(link => {

        link.addEventListener(
            'click',
            closeMenu
        );

    });


    document.querySelectorAll('.related-card--clickable').forEach(card => {
        const visitProduct = event => {
            if (event.target.closest('a, button, form, input, select, textarea, label')) return;
            window.location.href = card.dataset.productUrl;
        };

        card.addEventListener('click', visitProduct);
        card.addEventListener('keydown', event => {
            if ((event.key === 'Enter' || event.key === ' ') && !event.target.closest('a, button, form, input, select, textarea, label')) {
                event.preventDefault();
                window.location.href = card.dataset.productUrl;
            }
        });
    });


    /* =====================================================
       PRODUCT IMAGE GALLERY
    ====================================================== */

    document
        .querySelectorAll('.thumb')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    document
                        .getElementById(
                            'mainProductImage'
                        )
                        .src =
                        button.dataset.image;


                    document
                        .getElementById(
                            'tryOnProductImageId'
                        )
                        .value =
                        button.dataset.productImageId
                        || '';


                    document
                        .querySelectorAll('.thumb')
                        .forEach(
                            item =>
                                item.classList.remove(
                                    'active'
                                )
                        );


                    button.classList.add(
                        'active'
                    );

                }
            );

        });


    /* =====================================================
       QUANTITY
    ====================================================== */

    const quantity =
        document.getElementById(
            'quantity'
        );


    if (quantity) {

        const limit =
            () =>
                Number(quantity.max)
                || Infinity;


        document
            .getElementById(
                'quantityMinus'
            )
            .onclick =
            () => {

                quantity.value =
                    Math.max(
                        1,
                        Number(
                            quantity.value || 1
                        ) - 1
                    );

            };


        document
            .getElementById(
                'quantityPlus'
            )
            .onclick =
            () => {

                quantity.value =
                    Math.min(
                        limit(),
                        Number(
                            quantity.value || 1
                        ) + 1
                    );

            };


        quantity.onchange =
            () => {

                quantity.value =
                    Math.max(
                        1,
                        Math.min(
                            limit(),
                            Number(
                                quantity.value || 1
                            )
                        )
                    );

            };

    }


    /* =====================================================
       AI VIRTUAL TRY-ON
    ====================================================== */

    const form =
        document.getElementById(
            'tryOnForm'
        );


    if (!form) {

        return;

    }


    const input =
        document.getElementById(
            'tryOnPhoto'
        );

    const preview =
        document.getElementById(
            'tryOnPreview'
        );

    const message =
        document.getElementById(
            'tryOnMessage'
        );

    const submit =
        document.getElementById(
            'tryOnSubmit'
        );

    const remove =
        document.getElementById(
            'tryOnRemove'
        );

    const resultWrap =
        document.getElementById(
            'tryOnResultWrap'
        );

    const result =
        document.getElementById(
            'tryOnResult'
        );


    function showMessage(
        text,
        success = false
    ) {

        message.textContent =
            text;

        message.className =
            success
                ? 'alert alert-success mt-3'
                : 'alert alert-warning mt-3';

    }


    input.addEventListener(
        'change',
        () => {

            const file =
                input.files[0];


            if (!file) {

                return;

            }


            preview.src =
                URL.createObjectURL(
                    file
                );


            preview.classList.remove(
                'd-none'
            );


            remove.classList.remove(
                'd-none'
            );

        }
    );


    remove.addEventListener(
        'click',
        () => {

            input.value = '';

            preview.removeAttribute(
                'src'
            );

            preview.classList.add(
                'd-none'
            );

            remove.classList.add(
                'd-none'
            );

        }
    );


    document
        .getElementById(
            'tryOnAgain'
        )
        ?.addEventListener(
            'click',
            () => {

                resultWrap.classList.add(
                    'd-none'
                );

                form.scrollIntoView({
                    behavior:
                        'smooth'
                });

            }
        );


    document
        .getElementById(
            'tryOnProductImage'
        )
        ?.addEventListener(
            'click',
            () => {

                showMessage(
                    'Select a product image thumbnail above.',
                    true
                );

            }
        );


    form.addEventListener(
        'submit',
        async event => {

            event.preventDefault();


            submit.disabled =
                true;


            showMessage(
                'Creating your AI virtual try-on preview…',
                true
            );


            try {

                const response =
                    await fetch(
                        form.action,
                        {
                            method:
                                'POST',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    form.querySelector(
                                        '[name="_token"]'
                                    ).value

                            },

                            body:
                                new FormData(
                                    form
                                )

                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'AI Virtual Try-On is temporarily unavailable.'
                    );

                }


                result.src =
                    data.result_url;


                resultWrap.classList.remove(
                    'd-none'
                );


                showMessage(
                    data.message ||
                    'Virtual try-on created successfully.',
                    true
                );


            } catch (error) {

                showMessage(
                    error.message
                );

            } finally {

                submit.disabled =
                    false;

            }

        }
    );


    /* =====================================================
       THEME
    ====================================================== */

    window.addEventListener(
        'sb-theme-changed',
        event => {

            const theme =
                event.detail?.theme;


            if (
                ['light','dark']
                    .includes(theme)
            ) {

                document.documentElement
                    .setAttribute(
                        'data-theme',
                        theme
                    );


                localStorage.setItem(
                    'sb-theme',
                    theme
                );

            }

        }
    );


})();

</script>


</body>
</html>

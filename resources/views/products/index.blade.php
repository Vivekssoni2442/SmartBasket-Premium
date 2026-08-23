<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Basket Products</title>


    {{-- =========================================================
         SMART BASKET THEME - BEFORE PAGE PAINT
    ========================================================= --}}
    <script>
        (function () {

            const html = document.documentElement;

            let theme = null;

            const themeKeys = [
                'sb-theme',
                'smartbasket-theme',
                'theme'
            ];

            for (const key of themeKeys) {

                const value = localStorage.getItem(key);

                if (value === 'light' || value === 'dark') {
                    theme = value;
                    break;
                }
            }

            @auth
                if (!theme) {
                    theme = @json(auth()->user()->theme ?? null);
                }
            @endauth

            if (theme !== 'light' && theme !== 'dark') {
                theme = 'dark';
            }

            html.setAttribute('data-theme', theme);

            window.SB_THEME = theme;

        })();
    </script>


    {{-- =========================================================
         BOOTSTRAP
    ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         FONT AWESOME
    ========================================================= --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         AI CAMERA CSS
    ========================================================= --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera.css') }}"
    >


    <style>

        /* =========================================================
           SMART BASKET GLOBAL VARIABLES
        ========================================================= */

        :root {

            --sb-bg: #020617;
            --sb-surface: #0f172a;
            --sb-card: #111827;
            --sb-card-2: #1e293b;

            --sb-border: #334155;

            --sb-text: #f8fafc;
            --sb-text-secondary: #cbd5e1;
            --sb-muted: #94a3b8;

            --sb-primary: #3b82f6;
            --sb-primary-hover: #60a5fa;

            --sb-gold: #fbbf24;

            --sb-shadow: rgba(0, 0, 0, .35);

            --sb-overlay: rgba(2, 6, 23, .88);
        }


        /* =========================================================
           LIGHT THEME
        ========================================================= */

        html[data-theme="light"] {

            --sb-bg: #f7f9fc;
            --sb-surface: #ffffff;
            --sb-card: #ffffff;
            --sb-card-2: #f8fafc;

            --sb-border: #dbe3ee;

            --sb-text: #0f172a;
            --sb-text-secondary: #475569;
            --sb-muted: #64748b;

            --sb-primary: #2563eb;
            --sb-primary-hover: #1d4ed8;

            --sb-gold: #d97706;

            --sb-shadow: rgba(15, 23, 42, .10);

            --sb-overlay: rgba(255, 255, 255, .94);
        }


        /* =========================================================
           GLOBAL
        ========================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        html {
            background: var(--sb-bg) !important;
            color: var(--sb-text) !important;
        }


        body {

            min-height: 100vh;

            overflow-x: hidden;

            font-family:
                'Poppins',
                Arial,
                sans-serif;

            background:
                var(--sb-bg) !important;

            color:
                var(--sb-text) !important;

            transition:
                background-color .25s ease,
                color .25s ease;
        }


        /* =========================================================
           TEXT
        ========================================================= */

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        label,
        .form-label {

            color:
                var(--sb-text) !important;
        }


        p {

            color:
                var(--sb-text-secondary) !important;
        }


        .text-muted {

            color:
                var(--sb-muted) !important;
        }


        .text-primary {

            color:
                var(--sb-primary) !important;
        }


        /* =========================================================
           BOOTSTRAP
        ========================================================= */

        .container {
            max-width: 1400px;
        }


        .btn-primary {

            background:
                var(--sb-primary) !important;

            border-color:
                var(--sb-primary) !important;

            color:
                #ffffff !important;
        }


        .btn-primary:hover {

            background:
                var(--sb-primary-hover) !important;

            border-color:
                var(--sb-primary-hover) !important;

            color:
                #ffffff !important;
        }


        /* =========================================================
           TOP BAR
        ========================================================= */

        .sb-topbar {

            width: 100%;

            height: 70px;

            display: flex;

            align-items: center;

            justify-content: flex-end;

            padding: 12px 24px;

            position: sticky;

            top: 0;

            z-index: 5000;

            background:
                var(--sb-overlay) !important;

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            border-bottom:
                1px solid var(--sb-border) !important;

            box-shadow:
                0 8px 30px var(--sb-shadow);
        }


        /* =========================================================
           MENU WRAPPER
        ========================================================= */

        .sb-menu-wrapper {
            position: relative;
        }


        /* =========================================================
           MENU BUTTON
        ========================================================= */

        .sb-menu-button {

            width: 48px;
            height: 48px;

            border:
                1px solid var(--sb-border) !important;

            border-radius: 50%;

            background:
                var(--sb-card) !important;

            color:
                var(--sb-text) !important;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            box-shadow:
                0 8px 25px var(--sb-shadow);

            transition:
                all .25s ease;
        }


        .sb-menu-button:hover {

            transform:
                translateY(-2px);

            color:
                var(--sb-gold) !important;

            border-color:
                var(--sb-gold) !important;
        }


        .sb-menu-button i {
            font-size: 20px;
        }


        /* =========================================================
           DROPDOWN
        ========================================================= */

        .sb-dropdown {

            position: absolute;

            top:
                calc(100% + 12px);

            right: 0;

            width: 270px;

            max-height: calc(100vh - 100px);

            overflow-y: auto;

            padding: 10px;

            border-radius: 18px;

            background:
                var(--sb-card) !important;

            border:
                1px solid var(--sb-border) !important;

            box-shadow:
                0 25px 60px var(--sb-shadow);

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

            transform:
                translateY(-8px)
                scale(.97);

            transform-origin:
                top right;

            transition:
                opacity .2s ease,
                visibility .2s ease,
                transform .2s ease;
        }


        .sb-dropdown.show {

            opacity: 1;

            visibility: visible;

            pointer-events: auto;

            transform:
                translateY(0)
                scale(1);
        }


        /* =========================================================
           MENU TITLE
        ========================================================= */

        .sb-menu-title {

            padding:
                8px 12px 10px;

            font-size: 12px;

            font-weight: 700;

            color:
                var(--sb-muted) !important;

            text-transform:
                uppercase;

            letter-spacing:
                .8px;
        }


        /* =========================================================
           MENU ITEM
        ========================================================= */

        .sb-menu-item {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                12px 13px;

            margin-bottom: 3px;

            border-radius: 12px;

            color:
                var(--sb-text) !important;

            text-decoration: none !important;

            font-size: 14px;

            font-weight: 600;

            transition:
                all .2s ease;
        }


        .sb-menu-item:hover {

            background:
                var(--sb-card-2) !important;

            color:
                var(--sb-gold) !important;

            transform:
                translateX(3px);
        }


        .sb-menu-item i:first-child {

            width: 20px;

            text-align: center;

            flex-shrink: 0;
        }


        .sb-menu-item .menu-arrow {

            margin-left: auto;

            font-size: 11px;

            color:
                var(--sb-muted) !important;
        }


        /* =========================================================
           AI HUB SPECIAL MENU
        ========================================================= */

        .sb-ai-hub-item {

            background:
                linear-gradient(
                    135deg,
                    rgba(59,130,246,.12),
                    rgba(139,92,246,.10)
                ) !important;

            border:
                1px solid rgba(59,130,246,.20);
        }


        .sb-ai-hub-item:hover {

            background:
                linear-gradient(
                    135deg,
                    rgba(59,130,246,.20),
                    rgba(139,92,246,.18)
                ) !important;

            color:
                #60a5fa !important;
        }


        .sb-ai-hub-icon {

            color:
                #8b5cf6 !important;
        }


        /* =========================================================
           DIVIDER
        ========================================================= */

        .sb-menu-divider {

            height: 1px;

            background:
                var(--sb-border) !important;

            margin:
                8px 4px;
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .sb-search-form {

            background:
                var(--sb-card) !important;

            border:
                1px solid var(--sb-border) !important;

            box-shadow:
                0 10px 30px var(--sb-shadow) !important;
        }


        .form-control,
        .form-select {

            background:
                var(--sb-card-2) !important;

            color:
                var(--sb-text) !important;

            border:
                1px solid var(--sb-border) !important;

            min-height:
                44px;
        }


        .form-control::placeholder {

            color:
                var(--sb-muted) !important;
        }


        .form-control:focus,
        .form-select:focus {

            background:
                var(--sb-card-2) !important;

            color:
                var(--sb-text) !important;

            border-color:
                var(--sb-primary) !important;

            box-shadow:
                0 0 0 .2rem
                rgba(37,99,235,.15) !important;
        }


        .form-select option {

            background:
                var(--sb-card) !important;

            color:
                var(--sb-text) !important;
        }


        /* =========================================================
           PRODUCT CARD
        ========================================================= */

        .product-card {

            background:
                var(--sb-card) !important;

            border:
                1px solid var(--sb-border) !important;

            border-radius:
                1.2rem;

            overflow:
                hidden;

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;

            box-shadow:
                0 10px 30px var(--sb-shadow);

            height:
                100%;
        }


        .product-card:hover {

            transform:
                translateY(-5px);

            border-color:
                rgba(59,130,246,.55) !important;

            box-shadow:
                0 15px 35px
                rgba(59,130,246,.18);
        }


        .product-img {

            height:
                220px;

            object-fit:
                cover;

            width:
                100%;

            display:
                block;

            background:
                var(--sb-card-2) !important;
        }


        .product-card .card-body {

            min-height:
                255px;

            display:
                flex;

            flex-direction:
                column;

            padding:
                18px;
        }


        .product-card .card-title {

            color:
                var(--sb-text) !important;

            font-size:
                17px;

            font-weight:
                700;

            line-height:
                1.35;

            display:
                -webkit-box;

            -webkit-line-clamp:
                2;

            -webkit-box-orient:
                vertical;

            overflow:
                hidden;

            min-height:
                46px;
        }


        .product-card .product-description {

            color:
                var(--sb-text-secondary) !important;

            line-height:
                1.45;

            display:
                -webkit-box;

            -webkit-line-clamp:
                3;

            -webkit-box-orient:
                vertical;

            overflow:
                hidden;

            min-height:
                63px;
        }


        .product-card .product-price {

            color:
                var(--sb-text) !important;

            font-size:
                20px;

            font-weight:
                800;

            white-space:
                nowrap;
        }


        /* =========================================================
           STOCK PILL
        ========================================================= */

        .pill {

            font-size:
                .75rem;

            white-space:
                nowrap;

            background:
                rgba(37,99,235,.12) !important;

            color:
                var(--sb-primary) !important;
        }


        /* =========================================================
           BUTTONS
        ========================================================= */

        .action-btn {

            border-radius:
                999px;

            font-weight:
                600;

            min-height:
                38px;

            white-space:
                nowrap;
        }


        .btn-outline-light {

            color:
                var(--sb-text) !important;

            border-color:
                var(--sb-border) !important;

            background:
                transparent !important;
        }


        .btn-outline-light:hover {

            color:
                var(--sb-text) !important;

            background:
                var(--sb-card-2) !important;

            border-color:
                var(--sb-primary) !important;
        }


        /* =========================================================
           RECENT CARD
        ========================================================= */

        .recent-card {

            background:
                var(--sb-card) !important;

            border:
                1px solid var(--sb-border) !important;

            color:
                var(--sb-text) !important;

            box-shadow:
                0 8px 25px var(--sb-shadow) !important;
        }


        .recent-card h6 {

            color:
                var(--sb-text) !important;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .sb-empty {

            background:
                var(--sb-card) !important;

            border:
                1px solid var(--sb-border) !important;

            color:
                var(--sb-text) !important;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination .page-link {

            background:
                var(--sb-card) !important;

            color:
                var(--sb-text-secondary) !important;

            border-color:
                var(--sb-border) !important;
        }


        .pagination .page-link:hover {

            background:
                var(--sb-card-2) !important;

            color:
                var(--sb-primary) !important;
        }


        .pagination .active .page-link {

            background:
                var(--sb-primary) !important;

            color:
                #ffffff !important;

            border-color:
                var(--sb-primary) !important;
        }


        /* =========================================================
           MODAL
        ========================================================= */

        .modal-content {

            background:
                var(--sb-card) !important;

            color:
                var(--sb-text) !important;

            border:
                1px solid var(--sb-border) !important;
        }


        .modal-header {

            border-bottom-color:
                var(--sb-border) !important;
        }


        .modal-title {

            color:
                var(--sb-text) !important;
        }


        html[data-theme="dark"]
        .modal-header
        .btn-close {

            filter:
                invert(1);
        }


        html[data-theme="light"]
        .modal-header
        .btn-close {

            filter:
                none;
        }


        /* =========================================================
           AI CAMERA
        ========================================================= */

        html[data-theme="light"] .ai-privacy-note,
        html[data-theme="light"] .ai-camera-stage,
        html[data-theme="light"] .ai-progress-wrap,
        html[data-theme="light"] .ai-success-burst,
        html[data-theme="light"] .ai-results {

            color:
                var(--sb-text);
        }


        /* =========================================================
           THEME TRANSITION
        ========================================================= */

        html.sb-theme-transition,
        html.sb-theme-transition * {

            transition:
                background-color .25s ease !important,
                color .25s ease !important,
                border-color .25s ease !important,
                box-shadow .25s ease !important;
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 576px) {

            .sb-topbar {

                height:
                    62px;

                padding:
                    8px 14px;
            }


            .sb-menu-button {

                width:
                    44px;

                height:
                    44px;
            }


            .sb-dropdown {

                width:
                    calc(100vw - 28px);

                right:
                    -2px;
            }


            .container {

                padding-left:
                    14px;

                padding-right:
                    14px;
            }


            .product-img {

                height:
                    210px;
            }


            .product-card .card-body {

                min-height:
                    auto;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     TOP MENU
========================================================= --}}

<header class="sb-topbar">

    <div class="sb-menu-wrapper">

        <button
            type="button"
            class="sb-menu-button"
            id="sbMenuButton"
            aria-label="Open customer menu"
            aria-expanded="false"
        >

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </button>


        <div
            class="sb-dropdown"
            id="sbCustomerMenu"
        >

            {{-- MENU TITLE --}}

            <div class="sb-menu-title">

                <i class="fa-solid fa-basket-shopping me-1"></i>

                Smart Basket

            </div>


            {{-- HOME --}}

            <a
                href="{{ route('products.index') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-house"></i>

                <span>Home</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            {{-- MY ORDERS --}}

            <a
                href="{{ route('orders.index') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-box"></i>

                <span>My Orders</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            {{-- PROFILE --}}

            <a
                href="{{ route('profile') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-user"></i>

                <span>Profile</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            {{-- SETTINGS --}}

            @if(Route::has('settings'))

                <a
                    href="{{ route('settings') }}"
                    class="sb-menu-item"
                >

                    <i class="fa-solid fa-gear"></i>

                    <span>Settings</span>

                    <i class="fa-solid fa-chevron-right menu-arrow"></i>

                </a>

            @endif


            {{-- CART --}}

            <a
                href="{{ route('cart.index') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-cart-shopping"></i>

                <span>Cart</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            <div class="sb-menu-divider"></div>


            {{-- =================================================
                 AI HUB
            ================================================= --}}

            <a
                href="{{ route('ai-hub') }}"
                class="sb-menu-item sb-ai-hub-item"
            >

                <i
                    class="fa-solid fa-wand-magic-sparkles sb-ai-hub-icon"
                ></i>

                <span>AI HUB</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            {{-- AI CAMERA ASSISTANT --}}

            <a
                href="{{ route('ai-camera-assistant') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-camera-retro"></i>

                <span>AI Camera Assistant</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            {{-- WISHLIST --}}

            <a
                href="{{ route('wishlist') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-heart"></i>

                <span>Wishlist</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>


            <div class="sb-menu-divider"></div>


            {{-- ALL PRODUCTS --}}

            <a
                href="{{ route('products.index') }}"
                class="sb-menu-item"
            >

                <i class="fa-solid fa-store"></i>

                <span>All Products</span>

                <i class="fa-solid fa-chevron-right menu-arrow"></i>

            </a>

        </div>

    </div>

</header>


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<div class="container py-5">


    {{-- PAGE HEADER --}}

    <div
        class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4"
    >

        <div>

            <p class="text-primary fw-semibold mb-2">
                Smart Basket
            </p>

            <h1 class="display-6 fw-bold mb-0">
                Featured Products
            </h1>

            <p class="text-muted mb-0">
                Fresh items added by the seller, ready for customers.
            </p>

        </div>


        <div class="text-muted fw-semibold">

            {{ $pagedProducts->total() }} Products

        </div>

    </div>


    {{-- =========================================================
         SEARCH
    ========================================================= --}}

    <form
        method="GET"
        action="{{ route('products.index') }}"
        class="row g-3 rounded-4 p-3 shadow-sm mb-4 sb-search-form"
    >

        <div class="col-12 col-md-6">

            <label class="form-label small">
                Search
            </label>

            <input
                type="text"
                name="search"
                class="form-control"
                value="{{ $search }}"
                placeholder="Search products or category"
            >

        </div>


        <div class="col-12 col-md-4">

            <label class="form-label small">
                Category
            </label>

            <select
                name="category"
                class="form-select"
            >

                <option value="">
                    All Categories
                </option>

                @foreach($categories as $categoryOption)

                    <option
                        value="{{ $categoryOption }}"
                        {{ $category === $categoryOption ? 'selected' : '' }}
                    >

                        {{ $categoryOption }}

                    </option>

                @endforeach

            </select>

        </div>


        <div class="col-12 col-md-2 d-flex align-items-end">

            <button
                type="submit"
                class="btn btn-primary w-100 action-btn"
            >

                <i class="fa-solid fa-magnifying-glass me-1"></i>

                Apply

            </button>

        </div>

    </form>


    {{-- =========================================================
         RECENTLY VIEWED
    ========================================================= --}}

    @php

        $recentlyViewed = collect();

        if (auth()->check()) {

            $recentlyViewed =
                \App\Models\RecentlyViewedProduct::with('product')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->limit(4)
                    ->get();

        }

    @endphp


    @if(auth()->check() && $recentlyViewed->isNotEmpty())

        <div class="mb-4">

            <h5 class="fw-semibold mb-3">
                Recently viewed
            </h5>


            <div class="row g-3">

                @foreach($recentlyViewed as $view)

                    @if($view->product)

                        <div class="col-12 col-sm-6 col-lg-3">

                            <div class="card recent-card border-0 rounded-4 h-100">

                                <div class="card-body">

                                    <h6 class="fw-semibold mb-1">

                                        {{ $view->product->name }}

                                    </h6>

                                    <p class="text-muted small mb-2">

                                        {{ $view->product->category }}

                                    </p>

                                    <a
                                        href="{{ route('products.show', $view->product->id) }}"
                                        class="btn btn-outline-light btn-sm"
                                    >

                                        View

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    @endif


    {{-- =========================================================
         PRODUCTS
    ========================================================= --}}

    @if($pagedProducts->count() > 0)

        <div class="row g-4">

            @foreach($pagedProducts as $product)

                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="card product-card h-100">


                        {{-- PRODUCT IMAGE --}}

                        <a
                            href="{{ route('products.show', $product->id) }}"
                            class="text-decoration-none"
                        >

                            <img
                                src="{{ asset('products/' . $product->image) }}"
                                class="product-img"
                                alt="{{ $product->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('products/index.php') }}';"
                            >

                        </a>


                        {{-- PRODUCT BODY --}}

                        <div class="card-body">


                            <div
                                class="d-flex justify-content-between align-items-start gap-2 mb-2"
                            >

                                <div class="min-w-0">

                                    <h5 class="card-title mb-1">

                                        {{ $product->name }}

                                    </h5>

                                    <p class="text-muted mb-0 small">

                                        {{ $product->category }}

                                    </p>

                                </div>


                                <span class="badge pill">

                                    In Stock

                                </span>

                            </div>


                            {{-- RATING --}}

                            <div class="d-flex align-items-center text-warning mb-2">

                                <i class="fa-solid fa-star"></i>

                                <span class="ms-2 fw-semibold">

                                    {{ number_format($product->rating, 1) }}

                                </span>

                                <span class="text-muted ms-2">

                                    • {{ $product->stock }} left

                                </span>

                            </div>


                            {{-- DESCRIPTION --}}

                            <p class="product-description small mb-2">

                                {{
                                    $product->description
                                    ? \Illuminate\Support\Str::limit(
                                        $product->description,
                                        90
                                    )
                                    : 'Premium quality product from Smart Basket.'
                                }}

                            </p>


                            <div class="mt-auto">


                                {{-- PRICE --}}

                                <div class="product-price mb-3">

                                    ₹{{ number_format($product->price, 2) }}

                                </div>


                                {{-- ACTION BUTTONS --}}

                                <div class="d-flex gap-2">


                                    <a
                                        href="{{ route('products.show', $product->id) }}"
                                        class="btn btn-outline-light btn-sm action-btn flex-fill"
                                    >

                                        View

                                    </a>


                                    <a
                                        href="{{ url('/buy-now/' . $product->id) }}"
                                        class="btn btn-outline-light btn-sm action-btn flex-fill"
                                    >

                                        Buy Now

                                    </a>


                                    <form
                                        action="{{ route('cart.add', $product->id) }}"
                                        method="POST"
                                        class="flex-fill"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-sm action-btn w-100"
                                        >

                                            <i class="fa-solid fa-cart-plus"></i>

                                            <span class="d-none d-xl-inline">
                                                Cart
                                            </span>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- PAGINATION --}}

        <div class="d-flex justify-content-center mt-5">

            {{ $pagedProducts->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>


    @else

        <div class="alert sb-empty text-center py-5 rounded-4">

            <h4 class="fw-semibold mb-2">
                No products found
            </h4>

            <p class="text-muted mb-0">
                Try adjusting your search or category filter.
            </p>

        </div>

    @endif

</div>


{{-- =========================================================
     AI CAMERA MODAL
========================================================= --}}

<div
    class="modal fade"
    id="aiCameraModal"
    tabindex="-1"
    aria-labelledby="aiCameraModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="aiCameraModalLabel"
                >

                    <i class="fa-solid fa-camera-retro me-2"></i>

                    AI Camera Shopping Assistant

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="ai-privacy-note mb-3">

                    <i class="fa-solid fa-shield-halved me-1"></i>

                    <strong>Privacy First:</strong>

                    All AI processing happens locally in your browser.
                    No camera images are uploaded or stored.
                    Only anonymous body-proportion numbers are sent for recommendations.

                </div>


                <div class="row g-3">

                    <div class="col-lg-5">

                        <div class="ai-camera-stage">

                            <div
                                class="ai-camera-placeholder"
                                id="aiPlaceholder"
                            >

                                <i class="fa-solid fa-video"></i>

                                <div>
                                    Click <strong>AI Camera Assistant</strong> to start
                                </div>

                            </div>


                            <video
                                id="aiVideo"
                                autoplay
                                playsinline
                                muted
                                style="display:none;"
                            ></video>


                            <canvas
                                id="aiOverlay"
                                class="ai-overlay"
                            ></canvas>


                            <div
                                class="ai-scan-line"
                                id="aiScanLine"
                            ></div>


                            <div
                                class="ai-status-badge"
                                id="aiStatusBadge"
                            >

                                <span class="ai-pulse-dot"></span>

                                Idle

                            </div>


                            <button
                                class="ai-camera-flip"
                                id="aiCameraFlip"
                                title="Switch camera"
                                type="button"
                            >

                                <i class="fa-solid fa-camera-rotate"></i>

                            </button>


                            <div
                                class="ai-instructions"
                                id="aiInstructions"
                            >

                                <ul>

                                    <li>
                                        <i class="fa-solid fa-person-walking"></i>
                                        Stand 2-3 meters away from camera
                                    </li>

                                    <li>
                                        <i class="fa-solid fa-person"></i>
                                        Make sure your full body is visible
                                    </li>

                                    <li>
                                        <i class="fa-solid fa-mobile-screen"></i>
                                        Keep camera straight and steady
                                    </li>

                                    <li>
                                        <i class="fa-solid fa-lightbulb"></i>
                                        Ensure good lighting on your body
                                    </li>

                                </ul>

                            </div>

                        </div>


                        <div
                            class="ai-progress-wrap"
                            id="aiProgressWrap"
                        >

                            <div class="ai-progress-bar">

                                <div
                                    class="ai-progress-fill"
                                    id="aiProgressFill"
                                ></div>

                            </div>


                            <div class="ai-progress-label">

                                <span id="aiProgressLabel">
                                    Scanning...
                                </span>

                                <span
                                    class="ai-progress-percent"
                                    id="aiProgressPercent"
                                >
                                    0%
                                </span>

                            </div>

                        </div>


                        <div
                            class="ai-success-burst"
                            id="aiSuccessBurst"
                        >

                            <div class="ai-success-icon">

                                <i class="fa-solid fa-check"></i>

                            </div>


                            <div
                                class="ai-success-text"
                                id="aiSuccessText"
                            >
                                Body analysis completed
                            </div>


                            <div
                                class="ai-success-sub"
                                id="aiSuccessSub"
                            >
                                Generating recommendations...
                            </div>

                        </div>


                        {{-- AI PREFERENCES --}}

                        <div class="mt-3">

                            <small class="text-muted fw-semibold d-block mb-2">
                                Optional preferences:
                            </small>


                            <div class="ai-pref-chips mb-2">

                                <span
                                    class="ai-chip"
                                    data-group="fit"
                                    data-value="slim"
                                >
                                    Slim Fit
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="fit"
                                    data-value="regular"
                                >
                                    Regular
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="fit"
                                    data-value="relaxed"
                                >
                                    Relaxed
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="fit"
                                    data-value="oversized"
                                >
                                    Oversized
                                </span>

                            </div>


                            <div class="ai-pref-chips mb-2">

                                <span
                                    class="ai-chip"
                                    data-group="style"
                                    data-value="casual"
                                >
                                    Casual
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="style"
                                    data-value="formal"
                                >
                                    Formal
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="style"
                                    data-value="sporty"
                                >
                                    Sporty
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="style"
                                    data-value="ethnic"
                                >
                                    Ethnic
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="style"
                                    data-value="party"
                                >
                                    Party
                                </span>

                            </div>


                            <div class="ai-pref-chips">

                                <span
                                    class="ai-chip"
                                    data-group="color"
                                    data-value="light"
                                >
                                    Light
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="color"
                                    data-value="dark"
                                >
                                    Dark
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="color"
                                    data-value="warm"
                                >
                                    Warm
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="color"
                                    data-value="cool"
                                >
                                    Cool
                                </span>

                                <span
                                    class="ai-chip"
                                    data-group="color"
                                    data-value="neutral"
                                >
                                    Neutral
                                </span>

                            </div>

                        </div>


                        <button
                            id="aiAnalyzeBtn"
                            class="btn btn-primary w-100 mt-3 rounded-pill fw-bold"
                            type="button"
                        >

                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>

                            Re-analyze / Get Recommendations

                        </button>

                    </div>


                    <div class="col-lg-7">

                        <div id="aiResults">

                            <div class="text-muted text-center py-5">

                                <i
                                    class="fa-solid fa-camera-retro fs-2 d-block mb-2 text-primary"
                                ></i>

                                <div class="fw-semibold">
                                    AI Camera Ready
                                </div>

                                <small>
                                    Allow camera access to start body analysis
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     AI CAMERA FLOATING BUTTON
========================================================= --}}

<button
    id="btnAiCamera"
    class="ai-fab"
    type="button"
>

    <i class="fa-solid fa-camera-retro"></i>

    <span class="ai-fab-label">
        AI Camera Assistant
    </span>

</button>


<meta
    name="ai-csrf-token"
    content="{{ csrf_token() }}"
>


<script>
    window.aiCameraCsrfToken = "{{ csrf_token() }}";
</script>


{{-- =========================================================
     BOOTSTRAP JS
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- =========================================================
     AI CAMERA JS
========================================================= --}}

<script src="{{ asset('js/ai-camera.js') }}"></script>


{{-- =========================================================
     CUSTOMER MENU JS
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const menuButton =
        document.getElementById('sbMenuButton');

    const menu =
        document.getElementById('sbCustomerMenu');


    if (!menuButton || !menu) {
        return;
    }


    /* OPEN / CLOSE */

    menuButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            const isOpen =
                menu.classList.toggle('show');

            menuButton.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

        }
    );


    /* PREVENT CLOSE INSIDE */

    menu.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

        }
    );


    /* CLOSE OUTSIDE */

    document.addEventListener(
        'click',
        function () {

            menu.classList.remove('show');

            menuButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }
    );


    /* ESCAPE */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                menu.classList.remove('show');

                menuButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        }
    );

});

</script>


{{-- =========================================================
     SMART BASKET THEME SYNC
========================================================= --}}

<script>

(function () {

    const html =
        document.documentElement;


    function getThemeFromStorage() {

        const keys = [
            'sb-theme',
            'smartbasket-theme',
            'theme'
        ];


        for (const key of keys) {

            const value =
                localStorage.getItem(key);

            if (
                value === 'light' ||
                value === 'dark'
            ) {

                return value;

            }

        }


        return null;
    }


    function normalizeTheme(theme) {

        if (
            theme === 'light' ||
            theme === 'dark'
        ) {

            return theme;

        }


        if (
            theme === 'auto' ||
            theme === 'system'
        ) {

            return window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
                ? 'dark'
                : 'light';

        }


        return 'dark';
    }


    function applyTheme(theme) {

        const finalTheme =
            normalizeTheme(theme);


        html.classList.add(
            'sb-theme-transition'
        );


        html.setAttribute(
            'data-theme',
            finalTheme
        );


        window.SB_THEME =
            finalTheme;


        localStorage.setItem(
            'sb-theme',
            finalTheme
        );


        setTimeout(
            function () {

                html.classList.remove(
                    'sb-theme-transition'
                );

            },
            300
        );

    }


    /* INITIAL */

    let initialTheme =
        getThemeFromStorage();


    if (!initialTheme) {

        @auth

            initialTheme =
                @json(auth()->user()->theme ?? 'dark');

        @else

            initialTheme =
                'dark';

        @endauth
    }


    applyTheme(initialTheme);


    /* STORAGE */

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key === 'sb-theme' &&
                event.newValue
            ) {

                applyTheme(
                    event.newValue
                );

            }

        }
    );


    /* CUSTOM EVENT */

    window.addEventListener(
        'sbThemeChanged',
        function (event) {

            if (
                event.detail &&
                event.detail.theme
            ) {

                applyTheme(
                    event.detail.theme
                );

            }

        }
    );


    /* GLOBAL FUNCTION */

    window.setSmartBasketTheme =
        function (theme) {

            const finalTheme =
                normalizeTheme(theme);


            applyTheme(finalTheme);


            window.dispatchEvent(
                new CustomEvent(
                    'sbThemeChanged',
                    {
                        detail: {
                            theme: finalTheme
                        }
                    }
                )
            );

        };


    /* FOCUS SYNC */

    window.addEventListener(
        'focus',
        function () {

            const latestTheme =
                getThemeFromStorage();


            if (!latestTheme) {
                return;
            }


            const currentTheme =
                html.getAttribute(
                    'data-theme'
                );


            if (
                latestTheme !==
                currentTheme
            ) {

                applyTheme(
                    latestTheme
                );

            }

        }
    );

})();

</script>


</body>

</html>
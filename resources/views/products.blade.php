<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SMART BASKET PRODUCTS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>
        :root {
            --sb-bg: #f5f7fb;
            --sb-surface: #ffffff;
            --sb-surface-2: #f8fafc;
            --sb-text: #0f172a;
            --sb-muted: #64748b;
            --sb-border: rgba(15, 23, 42, .10);
            --sb-primary: #6366f1;
            --sb-primary-hover: #4f46e5;
            --sb-shadow: 0 15px 45px rgba(15, 23, 42, .10);
        }

        html[data-sb-theme="dark"] {
            --sb-bg: #020617;
            --sb-surface: #0f172a;
            --sb-surface-2: #111827;
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;
            --sb-border: rgba(148, 163, 184, .16);
            --sb-primary: #818cf8;
            --sb-primary-hover: #6366f1;
            --sb-shadow: 0 20px 60px rgba(0, 0, 0, .35);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at top left,
                    rgba(99, 102, 241, .12),
                    transparent 35%
                ),
                var(--sb-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }

        a {
            color: inherit;
        }

        /* =====================================================
           MAIN WRAPPER
        ===================================================== */

        .products-page {
            min-height: 100vh;
            padding-bottom: 60px;
        }

        .products-container {
            width: min(1500px, calc(100% - 40px));
            margin: auto;
        }

        /* =====================================================
           TOP NAVIGATION
        ===================================================== */

        .top-actions {
            width: min(1500px, calc(100% - 40px));
            margin: auto;

            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;

            padding: 22px 0 10px;
        }

        .sb-nav-btn {
            min-width: 130px;
            height: 44px;

            border-radius: 999px !important;

            display: inline-flex !important;
            align-items: center;
            justify-content: center;

            gap: 8px;

            font-weight: 700 !important;

            color: var(--sb-text) !important;

            background: var(--sb-surface) !important;

            border: 1px solid var(--sb-border) !important;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            transition: .25s ease;
        }

        .sb-nav-btn:hover {
            color: #fff !important;
            background: var(--sb-primary) !important;
            border-color: var(--sb-primary) !important;

            transform: translateY(-2px);

            box-shadow:
                0 12px 30px rgba(99,102,241,.25);
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .page-header {
            padding: 30px 0 20px;
        }

        .brand-label {
            color: var(--sb-primary);
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .page-title {
            margin: 6px 0 8px;

            color: var(--sb-text);

            font-size: clamp(30px, 4vw, 48px);
            font-weight: 900;
            letter-spacing: -1.5px;
        }

        .page-subtitle {
            margin: 0;
            color: var(--sb-muted);
            font-size: 15px;
        }

        .product-count {
            color: var(--sb-muted);
            font-weight: 700;
        }

        /* =====================================================
           SEARCH BOX
        ===================================================== */

        .search-box {
            background: var(--sb-surface);

            border: 1px solid var(--sb-border);

            border-radius: 24px;

            padding: 22px;

            box-shadow: var(--sb-shadow);

            transition: .3s ease;
        }

        .search-box:hover {
            transform: translateY(-2px);
        }

        .form-label {
            color: var(--sb-muted) !important;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            min-height: 48px;

            color: var(--sb-text) !important;

            background-color: var(--sb-surface-2) !important;

            border: 1px solid var(--sb-border) !important;

            border-radius: 14px !important;

            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: var(--sb-muted);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--sb-primary) !important;

            box-shadow:
                0 0 0 4px rgba(99,102,241,.12) !important;
        }

        .form-select option {
            color: #0f172a;
            background: #fff;
        }

        html[data-sb-theme="dark"] .form-select option {
            color: #f8fafc;
            background: #0f172a;
        }

        .apply-btn {
            min-height: 48px;

            border: 0 !important;
            border-radius: 14px !important;

            font-weight: 800 !important;

            background: var(--sb-primary) !important;

            transition: .25s ease;
        }

        .apply-btn:hover {
            background: var(--sb-primary-hover) !important;

            transform: translateY(-2px);

            box-shadow:
                0 12px 25px rgba(99,102,241,.25);
        }

        /* =====================================================
           RECENTLY VIEWED
        ===================================================== */

        .section-title {
            color: var(--sb-text);
            font-weight: 800;
        }

        .recent-card {
            height: 100%;

            background: var(--sb-surface) !important;

            border: 1px solid var(--sb-border) !important;

            border-radius: 18px !important;

            box-shadow:
                0 10px 30px rgba(0,0,0,.08);

            transition: .3s ease;
        }

        .recent-card:hover {
            transform: translateY(-4px);

            box-shadow: var(--sb-shadow);
        }

        .recent-card h6 {
            color: var(--sb-text);
        }

        .recent-card p {
            color: var(--sb-muted) !important;
        }

        /* =====================================================
           PRODUCT GRID
        ===================================================== */

        .product-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 24px;
        }

        /* =====================================================
           PRODUCT CARD
        ===================================================== */

        .product-card {
            height: 100%;

            overflow: hidden;

            background: var(--sb-surface) !important;

            border: 1px solid var(--sb-border) !important;

            border-radius: 24px !important;

            box-shadow: var(--sb-shadow);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .product-card:hover {
            transform: translateY(-7px);

            border-color:
                rgba(99,102,241,.35) !important;

            box-shadow:
                0 25px 60px rgba(0,0,0,.18);
        }

        /* =====================================================
           PRODUCT IMAGE
        ===================================================== */

        .product-image-wrapper {
            position: relative;

            height: 235px;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-surface-2),
                    var(--sb-bg)
                );
        }

        .product-img {
            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;

            transition: transform .5s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.06);
        }

        .product-image-overlay {
            position: absolute;

            inset: auto 12px 12px 12px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-badge {
            padding: 7px 12px;

            border-radius: 999px;

            color: #fff;

            background: rgba(2,6,23,.72);

            backdrop-filter: blur(10px);

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
        }

        /* =====================================================
           CARD BODY
        ===================================================== */

        .product-card .card-body {
            padding: 20px !important;

            display: flex;
            flex-direction: column;

            min-height: 285px;
        }

        .product-name {
            min-height: 50px;

            margin-bottom: 5px;

            color: var(--sb-text);

            font-size: 18px;
            font-weight: 800;
            line-height: 1.4;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;

            overflow: hidden;
        }

        .product-link {
            color: inherit;
            text-decoration: none;
        }

        .product-category {
            margin-bottom: 8px;

            color: var(--sb-muted);

            font-size: 13px;
            font-weight: 600;
        }

        .product-rating {
            margin-bottom: 10px;

            color: #fbbf24;

            font-size: 14px;
            font-weight: 700;
        }

        .product-description {
            min-height: 58px;

            margin-bottom: 12px;

            color: var(--sb-muted);

            font-size: 13px;
            line-height: 1.55;

            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;

            overflow: hidden;

            flex-grow: 1;
        }

        .product-price {
            margin-bottom: 15px;

            color: var(--sb-text);

            font-size: 21px;
            font-weight: 900;
        }

        /* =====================================================
           ACTION BUTTONS
        ===================================================== */

        .product-actions {
            display: flex;
            align-items: center;

            gap: 8px;

            width: 100%;
        }

        .action-btn {
            min-height: 42px;

            border-radius: 999px !important;

            font-size: 13px;
            font-weight: 800 !important;

            transition: .25s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .buy-btn {
            color: var(--sb-text) !important;

            background: transparent !important;

            border: 1px solid var(--sb-border) !important;
        }

        .buy-btn:hover {
            color: #fff !important;

            background: var(--sb-primary) !important;

            border-color: var(--sb-primary) !important;
        }

        .cart-btn {
            color: #fff !important;

            background: var(--sb-primary) !important;

            border: 1px solid var(--sb-primary) !important;
        }

        .cart-btn:hover {
            background: var(--sb-primary-hover) !important;
        }

        .wishlist-btn {
            width: 43px;

            flex: 0 0 43px;

            color: #f43f5e !important;

            background: transparent !important;

            border: 1px solid rgba(244,63,94,.35) !important;
        }

        .wishlist-btn:hover {
            color: #fff !important;

            background: #f43f5e !important;

            border-color: #f43f5e !important;
        }

        /* =====================================================
           NO PRODUCTS
        ===================================================== */

        .empty-products {
            padding: 60px 20px;

            text-align: center;

            background: var(--sb-surface);

            border: 1px solid var(--sb-border);

            border-radius: 24px;

            box-shadow: var(--sb-shadow);
        }

        .empty-products i {
            margin-bottom: 15px;

            color: var(--sb-primary);

            font-size: 45px;
        }

        .empty-products h4 {
            color: var(--sb-text);
            font-weight: 800;
        }

        .empty-products p {
            color: var(--sb-muted);
        }

        /* =====================================================
           PAGINATION
        ===================================================== */

        .pagination {
            gap: 6px;
        }

        .pagination .page-link {
            min-width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--sb-text) !important;

            background: var(--sb-surface) !important;

            border: 1px solid var(--sb-border) !important;

            border-radius: 12px !important;
        }

        .pagination .page-item.active .page-link {
            color: #fff !important;

            background: var(--sb-primary) !important;

            border-color: var(--sb-primary) !important;
        }

        .pagination .page-link:hover {
            color: #fff !important;

            background: var(--sb-primary) !important;

            border-color: var(--sb-primary) !important;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 992px) {

            .top-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .products-container {
                width: min(100% - 30px, 900px);
            }

            .product-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {

            .top-actions {
                width: calc(100% - 20px);

                gap: 7px;
            }

            .sb-nav-btn {
                min-width: calc(50% - 5px);
                height: 40px;

                font-size: 12px !important;
            }

            .products-container {
                width: calc(100% - 20px);
            }

            .page-header {
                padding-top: 20px;
            }

            .page-title {
                font-size: 32px;
            }

            .product-grid {
                grid-template-columns: 1fr;

                gap: 18px;
            }

            .product-image-wrapper {
                height: 250px;
            }

            .search-box {
                padding: 16px;
                border-radius: 18px;
            }

            .product-card .card-body {
                min-height: 0;
            }
        }
    </style>
</head>

@php
    $savedTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'dark')
        : 'dark';
@endphp

<body data-sb-theme="{{ auth()->user()?->dark_mode ?? 'system' }}">

    data-sb-theme="{{ $savedTheme }}"
    data-theme-setting="{{ $savedTheme }}"
>

<div class="products-page">

    <!-- =====================================================
         TOP ACTIONS
    ====================================================== -->

    <div class="top-actions">

        <a
            href="{{ route('orders.index') }}"
            class="btn sb-nav-btn"
        >
            <i class="fa-solid fa-box"></i>
            <span>My Orders</span>
        </a>

        <a
            href="{{ route('profile') }}"
            class="btn sb-nav-btn"
        >
            <i class="fa-solid fa-user"></i>
            <span>Profile</span>
        </a>

        <a
            href="{{ route('settings') }}"
            class="btn sb-nav-btn"
        >
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

        <a
            href="{{ route('cart.index') }}"
            class="btn sb-nav-btn"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
        </a>

    </div>


    <main class="products-container">

        <!-- =================================================
             HEADER
        ================================================== -->

        <section class="page-header">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">

                <div>

                    <div class="brand-label">
                        Smart Basket Premium
                    </div>

                    <h1 class="page-title">
                        Featured Products
                    </h1>

                    <p class="page-subtitle">
                        Discover premium products from Smart Basket sellers.
                    </p>

                </div>

                <div class="product-count">

                    <i class="fa-solid fa-cubes-stacked me-1"></i>

                    {{ $products->total() }} Products

                </div>

            </div>

        </section>


        <!-- =================================================
             SEARCH
        ================================================== -->

        <form
            method="GET"
            action="{{ route('products.index') }}"
            class="search-box row g-3 mb-4"
        >

            <div class="col-md-6">

                <label class="form-label small">
                    <i class="fa-solid fa-magnifying-glass me-1"></i>
                    Search Products
                </label>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search product or category..."
                >

            </div>


            <div class="col-md-4">

                <label class="form-label small">
                    <i class="fa-solid fa-layer-group me-1"></i>
                    Category
                </label>

                <select
                    name="category"
                    class="form-select"
                >

                    <option value="">
                        All Categories
                    </option>

                    @if(isset($categories))

                        @foreach($categories as $categoryOption)

                            <option
                                value="{{ $categoryOption }}"
                                {{ request('category') == $categoryOption ? 'selected' : '' }}
                            >
                                {{ $categoryOption }}
                            </option>

                        @endforeach

                    @endif

                </select>

            </div>


            <div class="col-md-2 d-flex align-items-end">

                <button
                    type="submit"
                    class="btn btn-primary apply-btn w-100"
                >
                    <i class="fa-solid fa-filter me-1"></i>
                    Apply
                </button>

            </div>

        </form>


        <!-- =================================================
             RECENTLY VIEWED
        ================================================== -->

        @if(auth()->check())

            @php

                $recentlyViewed =
                    \App\Models\RecentlyViewedProduct::with('product')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->limit(4)
                        ->get();

            @endphp

            @if($recentlyViewed->isNotEmpty())

                <section class="mb-5">

                    <h5 class="section-title mb-3">

                        <i class="fa-solid fa-clock-rotate-left me-2"></i>

                        Recently Viewed

                    </h5>

                    <div class="row g-3">

                        @foreach($recentlyViewed as $view)

                            @if($view->product)

                                <div class="col-lg-3 col-md-6">

                                    <a
                                        href="{{ route('product.show', $view->product) }}"
                                        class="text-decoration-none"
                                    >

                                        <div class="card recent-card">

                                            <div class="card-body">

                                                <h6 class="fw-bold mb-1">

                                                    {{ $view->product->name }}

                                                </h6>

                                                <p class="small mb-0">

                                                    {{ $view->product->category }}

                                                </p>

                                            </div>

                                        </div>

                                    </a>

                                </div>

                            @endif

                        @endforeach

                    </div>

                </section>

            @endif

        @endif


        <!-- =================================================
             PRODUCTS
        ================================================== -->

        @if($products->count() > 0)

            <div class="product-grid">

                @foreach($products as $product)

                    <article class="product-card">

                        <!-- IMAGE -->

                        <a
                            href="{{ route('product.show', $product) }}"
                            class="product-link"
                        >

                            <div class="product-image-wrapper">

                                <img
                                    src="{{ $product->image }}"
                                    class="product-img"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('products/index.php') }}';"
                                >

                                <div class="product-image-overlay">

                                    <span class="category-badge">

                                        {{ $product->category }}

                                    </span>

                                </div>

                            </div>

                        </a>


                        <!-- BODY -->

                        <div class="card-body">

                            <h5 class="product-name">

                                <a
                                    href="{{ route('product.show', $product) }}"
                                    class="product-link"
                                >

                                    {{ $product->name }}

                                </a>

                            </h5>


                            <div class="product-category">

                                <i class="fa-solid fa-tag me-1"></i>

                                {{ $product->category }}

                            </div>


                            <div class="product-rating">

                                <i class="fa-solid fa-star"></i>

                                {{ number_format($product->rating ?? 0, 1) }}

                            </div>


                            <p class="product-description">

                                {{ \Illuminate\Support\Str::limit(
                                    $product->description ??
                                    'Premium quality product from Smart Basket.',
                                    120
                                ) }}

                            </p>


                            <div class="product-price">

                                ₹{{ number_format($product->price, 2) }}

                            </div>


                            <!-- ACTIONS -->

                            <div class="product-actions">

                                <a
                                    href="{{ url('/buy-now/'.$product->id) }}"
                                    class="btn action-btn buy-btn flex-fill"
                                >
                                    <i class="fa-solid fa-bolt me-1"></i>
                                    Buy
                                </a>


                                <form
                                    action="{{ route('cart.add', $product->id) }}"
                                    method="POST"
                                    class="flex-fill"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn action-btn cart-btn w-100"
                                    >

                                        <i class="fa-solid fa-cart-plus me-1"></i>

                                        Cart

                                    </button>

                                </form>


                                <form
                                    action="{{ route('wishlist.add', $product->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn action-btn wishlist-btn"
                                        title="Add to wishlist"
                                    >

                                        <i class="fa-solid fa-heart"></i>

                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            <!-- =================================================
                 PAGINATION
            ================================================== -->

            <div class="d-flex justify-content-center mt-5">

                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}

            </div>


        @else

            <div class="empty-products">

                <i class="fa-solid fa-box-open"></i>

                <h4>
                    No Products Found
                </h4>

                <p>
                    Try another search or category.
                </p>

            </div>

        @endif

    </main>


    <!-- =====================================================
         AI HUB
    ====================================================== -->

    <x-ai-hub-sidebar />

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER THEME
    |--------------------------------------------------------------------------
    | Database setting:
    | light  = light theme
    | dark   = dark theme
    | system = follows Windows/browser preference
    |--------------------------------------------------------------------------
    */

    const body = document.body;
    const html = document.documentElement;

    const savedTheme =
        body.dataset.themeSetting ||
        body.dataset.sbTheme ||
        'dark';


    function applyTheme(theme) {

        let finalTheme = theme;

        if (theme === 'system') {

            finalTheme =
                window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
        }

        html.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        body.setAttribute(
            'data-theme-setting',
            theme
        );
    }


    applyTheme(savedTheme);


    /*
    |--------------------------------------------------------------------------
    | SYSTEM THEME CHANGE
    |--------------------------------------------------------------------------
    */

    if (window.matchMedia) {

        const mediaQuery =
            window.matchMedia('(prefers-color-scheme: dark)');

        const handleSystemChange = function () {

            if (
                body.getAttribute('data-theme-setting') === 'system'
            ) {

                applyTheme('system');

            }

        };


        if (mediaQuery.addEventListener) {

            mediaQuery.addEventListener(
                'change',
                handleSystemChange
            );

        } else if (mediaQuery.addListener) {

            mediaQuery.addListener(
                handleSystemChange
            );

        }

    }

});
</script>

</body>
</html>
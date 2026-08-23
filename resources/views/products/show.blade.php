<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $product->name }} | SMART BASKET</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            --sb-bg: #f5f7fb;
            --sb-card: #ffffff;
            --sb-card-2: #f8fafc;
            --sb-text: #111827;
            --sb-muted: #64748b;
            --sb-border: #e2e8f0;
            --sb-primary: #4f46e5;
            --sb-primary-hover: #4338ca;
            --sb-success: #16a34a;
            --sb-shadow: 0 20px 50px rgba(15, 23, 42, .08);
        }

        body.sb-dark {
            --sb-bg: #020617;
            --sb-card: #0f172a;
            --sb-card-2: #111827;
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;
            --sb-border: rgba(148, 163, 184, .16);
            --sb-primary: #6366f1;
            --sb-primary-hover: #818cf8;
            --sb-success: #22c55e;
            --sb-shadow: 0 25px 70px rgba(0, 0, 0, .35);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(99,102,241,.08),
                    transparent 35%
                ),
                var(--sb-bg) !important;

            color: var(--sb-text) !important;

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            transition:
                background .3s ease,
                color .3s ease;
        }

        a {
            color: inherit;
        }

        .sb-page {
            min-height: 100vh;
            padding: 35px 0 80px;
        }

        .sb-container {
            max-width: 1250px;
            margin: auto;
            padding: 0 18px;
        }

        /* ================================
           TOP NAVIGATION
        ================================= */

        .sb-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            padding: 15px 20px;

            background: var(--sb-card);
            border: 1px solid var(--sb-border);
            border-radius: 22px;

            box-shadow: var(--sb-shadow);
        }

        .sb-brand {
            display: flex;
            align-items: center;
            gap: 10px;

            font-weight: 800;
            font-size: 20px;
            text-decoration: none;
        }

        .sb-brand-icon {
            width: 42px;
            height: 42px;

            display: grid;
            place-items: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #8b5cf6
                );

            color: white;
            box-shadow: 0 10px 25px rgba(99,102,241,.3);
        }

        .sb-top-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .sb-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 10px 14px;

            border-radius: 12px;

            border: 1px solid var(--sb-border);

            background: var(--sb-card-2);

            color: var(--sb-text) !important;

            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition: .2s ease;
        }

        .sb-nav-btn:hover {
            transform: translateY(-2px);
            border-color: var(--sb-primary);
            color: var(--sb-primary) !important;
        }

        /* ================================
           PRODUCT MAIN CARD
        ================================= */

        .product-shell {
            background: var(--sb-card);

            border: 1px solid var(--sb-border);

            border-radius: 30px;

            padding: 25px;

            box-shadow: var(--sb-shadow);

            transition:
                background .3s ease,
                border .3s ease;
        }

        /* ================================
           IMAGE SECTION
        ================================= */

        .product-gallery {
            position: relative;
        }

        .product-main-image-wrap {
            min-height: 520px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                radial-gradient(
                    circle at center,
                    rgba(99,102,241,.08),
                    transparent 60%
                ),
                var(--sb-card-2);

            border: 1px solid var(--sb-border);

            border-radius: 25px;

            overflow: hidden;
        }

        .product-main-image {
            width: 100%;
            height: min(62vw, 520px);

            object-fit: contain;

            padding: 25px;

            transition:
                transform .35s ease,
                opacity .2s ease;
        }

        .product-main-image:hover {
            transform: scale(1.025);
        }

        .product-thumbnails {
            display: flex;
            gap: 10px;

            flex-wrap: wrap;

            margin-top: 15px;
        }

        .product-thumb {
            width: 75px;
            height: 75px;

            padding: 4px;

            border-radius: 15px;

            background: var(--sb-card);

            border: 2px solid var(--sb-border);

            overflow: hidden;

            transition: .2s ease;
        }

        .product-thumb:hover,
        .product-thumb.active {
            border-color: var(--sb-primary);

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(99,102,241,.18);
        }

        .product-thumb img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            border-radius: 10px;
        }

        /* ================================
           PRODUCT INFO
        ================================= */

        .product-info {
            height: 100%;
            padding: 10px 5px;
        }

        .product-category {
            display: inline-flex;

            padding: 7px 12px;

            border-radius: 999px;

            background: rgba(99,102,241,.1);

            color: var(--sb-primary);

            font-size: 12px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .5px;
        }

        .product-title {
            margin-top: 15px;

            font-size: clamp(28px, 4vw, 44px);

            line-height: 1.08;

            font-weight: 850;

            letter-spacing: -.8px;

            color: var(--sb-text);
        }

        .product-description {
            color: var(--sb-muted);

            line-height: 1.8;

            margin-top: 15px;
        }

        .price-area {
            display: flex;
            align-items: center;
            gap: 12px;

            flex-wrap: wrap;

            margin: 22px 0;
        }

        .current-price {
            font-size: 34px;
            font-weight: 850;
            color: var(--sb-text);
        }

        .old-price {
            color: var(--sb-muted);
            text-decoration: line-through;
        }

        .discount-badge {
            padding: 6px 10px;

            border-radius: 9px;

            background: rgba(34,197,94,.12);

            color: var(--sb-success);

            font-size: 13px;
            font-weight: 800;
        }

        /* ================================
           PRODUCT DETAILS
        ================================= */

        .product-details-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0,1fr));

            gap: 10px;

            margin-top: 20px;
        }

        .detail-item {
            padding: 13px;

            border: 1px solid var(--sb-border);

            border-radius: 14px;

            background: var(--sb-card-2);
        }

        .detail-label {
            display: block;

            color: var(--sb-muted);

            font-size: 12px;

            margin-bottom: 3px;
        }

        .detail-value {
            color: var(--sb-text);

            font-size: 14px;

            font-weight: 700;
        }

        /* ================================
           SELLER
        ================================= */

        .seller-card {
            margin-top: 20px;

            padding: 17px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.10),
                    rgba(139,92,246,.04)
                );

            border: 1px solid var(--sb-border);
        }

        .seller-title {
            font-size: 12px;

            color: var(--sb-muted);

            text-transform: uppercase;

            letter-spacing: .6px;
        }

        .seller-name {
            margin-top: 5px;

            font-size: 17px;

            font-weight: 800;
        }

        .seller-meta {
            color: var(--sb-muted);

            font-size: 13px;
        }

        /* ================================
           BUTTONS
        ================================= */

        .sb-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 48px;

            padding: 11px 18px;

            border-radius: 14px;

            border: 1px solid var(--sb-border);

            font-weight: 750;

            text-decoration: none;

            cursor: pointer;

            transition: .2s ease;
        }

        .sb-btn:hover {
            transform: translateY(-2px);
        }

        .sb-btn-primary {
            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #7c3aed
                );

            border-color: transparent;

            color: white !important;

            box-shadow:
                0 10px 25px rgba(99,102,241,.25);
        }

        .sb-btn-success {
            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

            border-color: transparent;

            color: white !important;
        }

        .sb-btn-outline {
            background: var(--sb-card);

            color: var(--sb-text) !important;
        }

        .sb-btn-outline:hover {
            border-color: var(--sb-primary);

            color: var(--sb-primary) !important;
        }

        .action-row {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 22px;
        }

        /* ================================
           QUANTITY
        ================================= */

        .quantity-box {
            display: inline-flex;

            overflow: hidden;

            border-radius: 14px;

            border: 1px solid var(--sb-border);

            background: var(--sb-card);
        }

        .quantity-box button {
            width: 44px;

            border: 0;

            background: var(--sb-card-2);

            color: var(--sb-text);

            font-size: 20px;

            cursor: pointer;
        }

        .quantity-box input {
            width: 60px;

            border: 0;

            border-left: 1px solid var(--sb-border);
            border-right: 1px solid var(--sb-border);

            text-align: center;

            background: var(--sb-card);

            color: var(--sb-text);

            outline: none;
        }

        /* ================================
           AI TRY ON
        ================================= */

        .ai-card {
            margin-top: 25px;

            padding: 22px;

            border-radius: 22px;

            background:
                linear-gradient(
                    135deg,
                    rgba(99,102,241,.12),
                    rgba(139,92,246,.06)
                );

            border: 1px solid var(--sb-border);
        }

        .ai-card h2 {
            font-weight: 850;
        }

        .ai-card p {
            color: var(--sb-muted);
        }

        .ai-card .form-control {
            background: var(--sb-card);

            border-color: var(--sb-border);

            color: var(--sb-text);
        }

        .ai-card .form-control::file-selector-button {
            background: var(--sb-card-2);

            color: var(--sb-text);

            border: 0;
        }

        #tryOnPreview,
        #tryOnResult {
            border-radius: 18px;

            border: 1px solid var(--sb-border);

            box-shadow: var(--sb-shadow);
        }

        /* ================================
           RELATED PRODUCTS
        ================================= */

        .related-section {
            margin-top: 35px;
        }

        .section-heading {
            display: flex;

            align-items: center;
            justify-content: space-between;

            margin-bottom: 18px;
        }

        .section-heading h2 {
            font-size: 25px;

            font-weight: 850;

            margin: 0;
        }

        .related-card {
            display: block;

            height: 100%;

            overflow: hidden;

            background: var(--sb-card);

            border: 1px solid var(--sb-border);

            border-radius: 20px;

            text-decoration: none;

            box-shadow:
                0 10px 30px rgba(15,23,42,.05);

            transition: .25s ease;
        }

        .related-card:hover {
            transform: translateY(-6px);

            border-color: rgba(99,102,241,.5);

            box-shadow:
                0 20px 45px rgba(15,23,42,.12);
        }

        .related-image {
            width: 100%;

            height: 190px;

            object-fit: cover;

            background: var(--sb-card-2);
        }

        .related-body {
            padding: 15px;
        }

        .related-title {
            color: var(--sb-text);

            font-size: 15px;

            font-weight: 750;

            margin-bottom: 8px;
        }

        .related-price {
            color: var(--sb-primary);

            font-weight: 850;
        }

        /* ================================
           RESPONSIVE
        ================================= */

        @media (max-width: 991px) {

            .product-main-image-wrap {
                min-height: 400px;
            }

            .product-main-image {
                height: 400px;
            }

        }

        @media (max-width: 575px) {

            .sb-page {
                padding-top: 15px;
            }

            .product-shell {
                padding: 14px;

                border-radius: 20px;
            }

            .product-main-image-wrap {
                min-height: 330px;

                border-radius: 18px;
            }

            .product-main-image {
                height: 330px;

                padding: 15px;
            }

            .product-details-grid {
                grid-template-columns: 1fr;
            }

            .action-row > * {
                width: 100%;
            }

            .sb-btn {
                width: 100%;
            }

            .sb-topbar {
                border-radius: 17px;
            }
        }
    </style>
</head>

<body
    data-sb-theme="{{ auth()->check() ? (auth()->user()->dark_mode ?? 'system') : 'system' }}"
>

<div class="sb-page">

    <div class="sb-container">

        <!-- TOP BAR -->
        <div class="sb-topbar">

            <a href="{{ route('products.index') }}" class="sb-brand">

                <span class="sb-brand-icon">
                    🛒
                </span>

                <span>
                    SMART BASKET
                </span>

            </a>

            <div class="sb-top-actions">

                <a
                    href="{{ route('products.index') }}"
                    class="sb-nav-btn"
                >
                    🛍 Products
                </a>

                <a
                    href="{{ route('cart.index') }}"
                    class="sb-nav-btn"
                >
                    🛒 Cart
                </a>

                @auth

                    <a
                        href="{{ route('wishlist') }}"
                        class="sb-nav-btn"
                    >
                        ❤️ Wishlist
                    </a>

                    <a
                        href="{{ route('settings') }}"
                        class="sb-nav-btn"
                    >
                        ⚙️ Settings
                    </a>

                @endauth

            </div>

        </div>


        <!-- PRODUCT -->
        <div class="product-shell">

            <div class="row g-4">

                <!-- GALLERY -->
                <div class="col-lg-6">

                    <div class="product-gallery">

                        @php

                            $gallery = collect([
                                [
                                    'url' => asset(
                                        'products/' . $product->image
                                    ),
                                    'label' => 'Main',
                                    'image_id' => null
                                ]
                            ])->merge(

                                $product->images->map(
                                    fn ($image) => [
                                        'url' => asset(
                                            'storage/' . $image->path
                                        ),
                                        'label' => 'Product view',
                                        'image_id' => $image->id
                                    ]
                                )

                            );

                        @endphp


                        <div class="product-main-image-wrap">

                            <img
                                id="mainProductImage"
                                src="{{ $gallery->first()['url'] }}"
                                class="product-main-image"
                                alt="{{ $product->name }}"
                                onerror="this.style.opacity='.25';"
                            >

                        </div>


                        @if($gallery->count() > 1)

                            <div class="product-thumbnails">

                                @foreach($gallery as $index => $image)

                                    <button
                                        type="button"
                                        class="product-thumb {{ $index === 0 ? 'active' : '' }}"
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

                </div>


                <!-- INFORMATION -->
                <div class="col-lg-6">

                    <div class="product-info">

                        @if($product->category)

                            <span class="product-category">
                                {{ $product->category }}
                            </span>

                        @endif


                        <h1 class="product-title">
                            {{ $product->name }}
                        </h1>


                        @php

                            $hasDiscount =
                                $product->discount_price !== null &&
                                (float) $product->discount_price <
                                (float) $product->price;

                            $finalPrice =
                                $hasDiscount
                                ? (float) $product->discount_price
                                : (float) $product->price;

                        @endphp


                        <div class="price-area">

                            <span class="current-price">
                                ₹{{ number_format($finalPrice, 2) }}
                            </span>

                            @if($hasDiscount)

                                <span class="old-price">
                                    ₹{{ number_format((float) $product->price, 2) }}
                                </span>

                                <span class="discount-badge">

                                    {{ round(
                                        (
                                            1 -
                                            (
                                                $finalPrice /
                                                (float) $product->price
                                            )
                                        ) * 100
                                    ) }}% OFF

                                </span>

                            @endif

                        </div>


                        @if($product->description)

                            <p class="product-description">
                                {{ $product->description }}
                            </p>

                        @endif


                        <!-- DETAILS -->

                        <div class="product-details-grid">

                            @if($product->brand)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Brand
                                    </span>

                                    <span class="detail-value">
                                        {{ $product->brand }}
                                    </span>

                                </div>

                            @endif


                            @if($product->rating !== null)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Rating
                                    </span>

                                    <span class="detail-value">
                                        ⭐ {{ number_format((float) $product->rating, 1) }}
                                    </span>

                                </div>

                            @endif


                            @if($product->stock !== null)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Available Stock
                                    </span>

                                    <span class="detail-value">
                                        {{ $product->stock }}
                                    </span>

                                </div>

                            @endif


                            @if($product->size)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Size
                                    </span>

                                    <span class="detail-value">
                                        {{ $product->size }}
                                    </span>

                                </div>

                            @endif


                            @if($product->color)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Color
                                    </span>

                                    <span class="detail-value">
                                        {{ $product->color }}
                                    </span>

                                </div>

                            @endif


                            @if($product->status)

                                <div class="detail-item">

                                    <span class="detail-label">
                                        Status
                                    </span>

                                    <span class="detail-value">
                                        {{ ucfirst($product->status) }}
                                    </span>

                                </div>

                            @endif

                        </div>


                        <!-- SELLER -->

                        @if($product->seller)

                            <div class="seller-card">

                                <div class="seller-title">
                                    Sold by
                                </div>

                                <div class="seller-name">

                                    {{ $product->seller->shop_name
                                        ?: $product->seller->seller_name }}

                                </div>

                                <div class="seller-meta">

                                    {{ $product->seller->seller_name }}

                                    @if($product->seller->city)

                                        · {{ $product->seller->city }}

                                    @endif

                                </div>

                            </div>

                        @endif


                        <!-- MAIN ACTIONS -->

                        <div class="action-row">

                            <a
                                href="{{ route('products.index') }}"
                                class="sb-btn sb-btn-outline"
                            >
                                ← Back
                            </a>


                            @auth

                                <form
                                    action="{{ route('wishlist.add', $product->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="sb-btn sb-btn-outline"
                                    >
                                        ❤️ Wishlist
                                    </button>

                                </form>

                            @endauth

                        </div>


                        <!-- CART -->

                        <form
                            action="{{ route('cart.add', $product) }}"
                            method="POST"
                            class="action-row"
                        >

                            @csrf

                            <div>

                                <label
                                    for="quantity"
                                    class="detail-label mb-2"
                                >
                                    Quantity
                                </label>

                                <div class="quantity-box">

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
                                        @if($product->stock !== null)
                                            max="{{ max(1, (int) $product->stock) }}"
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
                                class="sb-btn sb-btn-primary"
                                {{ $product->stock !== null && (int) $product->stock < 1 ? 'disabled' : '' }}
                            >
                                🛒 Add to Cart
                            </button>


                            <a
                                class="sb-btn sb-btn-success"
                                href="{{ url('/buy-now/' . $product->id) }}"
                            >
                                ⚡ Buy Now
                            </a>

                        </form>


                        <!-- AI TRY ON -->

                        <section class="ai-card" id="virtualTryOn">

                            <h2 class="h4">
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
                                action="{{ route('products.virtual-try-on.generate', $product) }}"
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


                                <div class="action-row">

                                    <button
                                        class="sb-btn sb-btn-primary"
                                        type="submit"
                                        id="tryOnSubmit"
                                    >
                                        ✨ Try Product On Me
                                    </button>


                                    <button
                                        class="sb-btn sb-btn-outline d-none"
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
                                style="max-height:320px"
                            >


                            <div
                                class="mt-4 d-none"
                                id="tryOnResultWrap"
                            >

                                <h3 class="h5">
                                    AI Virtual Try-On Result
                                </h3>


                                <img
                                    id="tryOnResult"
                                    class="img-fluid"
                                    alt="AI-generated virtual try-on preview"
                                    style="max-height:520px"
                                >


                                <div class="action-row">

                                    <button
                                        class="sb-btn sb-btn-outline"
                                        type="button"
                                        id="tryOnAgain"
                                    >
                                        🔄 Try Again
                                    </button>


                                    <label
                                        class="sb-btn sb-btn-outline"
                                        for="tryOnPhoto"
                                    >
                                        📷 Change Photo
                                    </label>


                                    <button
                                        class="sb-btn sb-btn-outline"
                                        type="button"
                                        id="tryOnProductImage"
                                    >
                                        🖼 Change Product Image
                                    </button>


                                    <form
                                        action="{{ route('cart.add', $product) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            class="sb-btn sb-btn-primary"
                                            type="submit"
                                        >
                                            🛒 Add to Cart
                                        </button>

                                    </form>


                                    <a
                                        class="sb-btn sb-btn-success"
                                        href="{{ url('/buy-now/' . $product->id) }}"
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


        <!-- RELATED PRODUCTS -->

        @if($relatedProducts->isNotEmpty())

            <section class="related-section">

                <div class="section-heading">

                    <h2>
                        🛍 Related Products
                    </h2>

                    <a
                        href="{{ route('products.index') }}"
                        class="sb-nav-btn"
                    >
                        View All →
                    </a>

                </div>


                <div class="row g-3">

                    @foreach($relatedProducts as $related)

                        <div class="col-6 col-md-3">

                            <a
                                href="{{ route('product.show', $related) }}"
                                class="related-card"
                            >

                                <img
                                    class="related-image"
                                    src="{{ asset('products/' . $related->image) }}"
                                    alt="{{ $related->name }}"
                                    onerror="this.style.opacity='.25';"
                                >


                                <div class="related-body">

                                    <div class="related-title">

                                        {{ $related->name }}

                                    </div>


                                    <div class="related-price">

                                        ₹{{ number_format(
                                            (float)
                                            (
                                                $related->discount_price &&
                                                $related->discount_price < $related->price
                                                    ? $related->discount_price
                                                    : $related->price
                                            ),
                                            2
                                        ) }}

                                    </div>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>

            </section>

        @endif

    </div>

</div>


<x-ai-hub-sidebar />


<script>
(function () {

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER THEME
    |--------------------------------------------------------------------------
    */

    function applyCustomerTheme() {

        const savedTheme =
            "{{ auth()->check() ? (auth()->user()->dark_mode ?? 'system') : 'system' }}";

        let theme = savedTheme;

        if (theme === 'system') {

            theme =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';
        }

        document.body.classList.toggle(
            'sb-dark',
            theme === 'dark'
        );

        document.body.dataset.sbTheme = theme;
    }


    applyCustomerTheme();


    /*
    |--------------------------------------------------------------------------
    | LISTEN FOR THEME CHANGE
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'sb-theme-changed',
        applyCustomerTheme
    );


    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMAGE GALLERY
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.product-thumb')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    document
                        .getElementById('mainProductImage')
                        .src =
                        button.dataset.image;


                    document
                        .getElementById('tryOnProductImageId')
                        .value =
                        button.dataset.productImageId || '';


                    document
                        .querySelectorAll('.product-thumb')
                        .forEach(item =>
                            item.classList.remove('active')
                        );


                    button.classList.add('active');
                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | QUANTITY
    |--------------------------------------------------------------------------
    */

    const quantity =
        document.getElementById('quantity');

    if (quantity) {

        const minus =
            document.getElementById('quantityMinus');

        const plus =
            document.getElementById('quantityPlus');


        const getLimit = () =>
            Number(quantity.max) || Infinity;


        minus.onclick = () => {

            quantity.value =
                Math.max(
                    1,
                    Number(quantity.value || 1) - 1
                );

        };


        plus.onclick = () => {

            quantity.value =
                Math.min(
                    getLimit(),
                    Number(quantity.value || 1) + 1
                );

        };


        quantity.onchange = () => {

            quantity.value =
                Math.max(
                    1,
                    Math.min(
                        getLimit(),
                        Number(quantity.value || 1)
                    )
                );

        };

    }


    /*
    |--------------------------------------------------------------------------
    | AI VIRTUAL TRY-ON
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('tryOnForm');

    if (!form) return;


    const input =
        document.getElementById('tryOnPhoto');

    const preview =
        document.getElementById('tryOnPreview');

    const message =
        document.getElementById('tryOnMessage');

    const submit =
        document.getElementById('tryOnSubmit');

    const remove =
        document.getElementById('tryOnRemove');

    const resultWrap =
        document.getElementById('tryOnResultWrap');

    const result =
        document.getElementById('tryOnResult');


    function showMessage(
        text,
        success = false
    ) {

        message.textContent = text;

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

            if (!file) return;


            preview.src =
                URL.createObjectURL(file);


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
        .getElementById('tryOnAgain')
        ?.addEventListener(
            'click',
            () => {

                resultWrap.classList.add(
                    'd-none'
                );

                form.scrollIntoView({
                    behavior: 'smooth'
                });

            }
        );


    document
        .getElementById('tryOnProductImage')
        ?.addEventListener(
            'click',
            () => {

                document
                    .querySelector('.product-thumb')
                    ?.focus();

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

            submit.disabled = true;


            showMessage(
                'Creating your AI virtual try-on preview…',
                true
            );


            try {

                const response =
                    await fetch(
                        form.action,
                        {
                            method: 'POST',

                            headers: {
                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    form.querySelector(
                                        '[name="_token"]'
                                    ).value
                            },

                            body:
                                new FormData(form)
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

                submit.disabled = false;

            }

        }
    );

})();
</script>

</body>
</html>
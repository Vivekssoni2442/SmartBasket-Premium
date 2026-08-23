@extends('seller.partials.premium-layout')

@section('title', 'Seller Dashboard')

@section('content')

<style>
    /* =========================================================
       SMART BASKET SELLER DASHBOARD
       PREMIUM DARK UI
       ========================================================= */

    .seller-dashboard {
        min-height: 100vh;
        padding: 32px;
        color: #f8fafc;
        background:
            radial-gradient(circle at 10% 0%, rgba(0, 255, 153, .08), transparent 28%),
            radial-gradient(circle at 90% 10%, rgba(59, 130, 246, .07), transparent 25%),
            linear-gradient(135deg, #020617 0%, #07111f 48%, #020617 100%);
    }

    .seller-dashboard * {
        box-sizing: border-box;
    }

    /* =========================================================
       HEADER
       ========================================================= */

    .sd-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 30px;
    }

    .sd-title h1 {
        margin: 0;
        color: #f8fafc;
        font-size: 32px;
        line-height: 1.15;
        font-weight: 850;
        letter-spacing: -.8px;
    }

    .sd-title h1 span {
        color: #00ff99;
        text-shadow: 0 0 25px rgba(0,255,153,.18);
    }

    .sd-subtitle {
        margin-top: 8px;
        color: #94a3b8;
        font-size: 13px;
    }

    .sd-status {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 17px;
        border: 1px solid rgba(0,255,153,.20);
        border-radius: 14px;
        background: rgba(0,255,153,.055);
        color: #8affcb;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
        box-shadow: 0 8px 25px rgba(0,0,0,.18);
    }

    .sd-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #00ff99;
        box-shadow:
            0 0 8px #00ff99,
            0 0 18px rgba(0,255,153,.6);
    }

    /* =========================================================
       QUICK ACTIONS
       ========================================================= */

    .sd-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .sd-action {
        position: relative;
        overflow: hidden;
        min-height: 145px;
        padding: 20px;
        border: 1px solid rgba(148,163,184,.13);
        border-radius: 20px;
        background:
            linear-gradient(
                145deg,
                rgba(30,41,59,.78),
                rgba(15,23,42,.72)
            );
        color: #f8fafc;
        text-decoration: none;
        box-shadow:
            0 15px 35px rgba(0,0,0,.22),
            inset 0 1px 0 rgba(255,255,255,.035);
        transition: transform .25s ease,
                    border-color .25s ease,
                    box-shadow .25s ease;
    }

    .sd-action::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -45px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #00ff99;
        opacity: .035;
        filter: blur(25px);
    }

    .sd-action:hover {
        transform: translateY(-5px);
        border-color: rgba(0,255,153,.30);
        color: #fff;
        box-shadow:
            0 22px 45px rgba(0,0,0,.32),
            0 0 30px rgba(0,255,153,.055);
    }

    .sd-action-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        border: 1px solid rgba(0,255,153,.16);
        border-radius: 14px;
        background: rgba(0,255,153,.07);
        color: #00ff99;
        font-size: 17px;
    }

    .sd-action-title {
        color: #f8fafc;
        font-size: 14px;
        font-weight: 750;
    }

    .sd-action-text {
        margin-top: 5px;
        color: #64748b;
        font-size: 11px;
    }

    /* =========================================================
       STATISTICS
       ========================================================= */

    .sd-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-stat {
        position: relative;
        overflow: hidden;
        min-height: 165px;
        padding: 22px;
        border: 1px solid rgba(148,163,184,.13);
        border-radius: 22px;
        background:
            linear-gradient(
                145deg,
                rgba(30,41,59,.82),
                rgba(15,23,42,.68)
            );
        backdrop-filter: blur(18px);
        box-shadow:
            0 16px 38px rgba(0,0,0,.22),
            inset 0 1px 0 rgba(255,255,255,.035);
        transition: transform .28s ease,
                    border-color .28s ease,
                    box-shadow .28s ease;
    }

    .sd-stat:hover {
        transform: translateY(-5px);
        border-color: rgba(0,255,153,.24);
        box-shadow:
            0 24px 48px rgba(0,0,0,.30),
            0 0 30px rgba(0,255,153,.045);
    }

    .sd-stat::after {
        content: "";
        position: absolute;
        right: -50px;
        bottom: -50px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: #00ff99;
        opacity: .035;
        filter: blur(25px);
    }

    .sd-stat-icon {
        width: 47px;
        height: 47px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border: 1px solid rgba(0,255,153,.14);
        border-radius: 14px;
        background: rgba(0,255,153,.065);
        color: #00ff99;
        font-size: 18px;
    }

    .sd-stat-number {
        position: relative;
        z-index: 1;
        color: #f8fafc;
        font-size: 28px;
        line-height: 1;
        font-weight: 850;
        letter-spacing: -.5px;
    }

    .sd-stat-label {
        position: relative;
        z-index: 1;
        margin-top: 9px;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    /* =========================================================
       PRODUCTS SECTION
       ========================================================= */

    .sd-products {
        margin-top: 38px;
    }

    .sd-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
    }

    .sd-section-title {
        color: #f8fafc;
        font-size: 21px;
        font-weight: 850;
        letter-spacing: -.3px;
    }

    .sd-section-subtitle {
        margin-top: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .sd-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg, #00ff99, #00d681);
        color: #020617 !important;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        box-shadow:
            0 10px 25px rgba(0,255,153,.10);
        transition: transform .25s ease,
                    box-shadow .25s ease;
    }

    .sd-add:hover {
        transform: translateY(-2px);
        color: #020617 !important;
        box-shadow:
            0 15px 35px rgba(0,255,153,.22);
    }

    /* =========================================================
       PRODUCT GRID
       ========================================================= */

    .sd-product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-product {
        overflow: hidden;
        min-width: 0;
        border: 1px solid rgba(148,163,184,.13);
        border-radius: 20px;
        background:
            linear-gradient(
                145deg,
                rgba(30,41,59,.82),
                rgba(15,23,42,.72)
            );
        box-shadow:
            0 15px 35px rgba(0,0,0,.22),
            inset 0 1px 0 rgba(255,255,255,.03);
        transition: transform .3s ease,
                    border-color .3s ease,
                    box-shadow .3s ease;
    }

    .sd-product:hover {
        transform: translateY(-6px);
        border-color: rgba(0,255,153,.24);
        box-shadow:
            0 25px 50px rgba(0,0,0,.32),
            0 0 30px rgba(0,255,153,.045);
    }

    .sd-product-image {
        position: relative;
        height: 195px;
        overflow: hidden;
        background: #0b1220;
    }

    .sd-product-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            transparent 60%,
            rgba(2,6,23,.30)
        );
        pointer-events: none;
    }

    .sd-product-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .sd-product:hover .sd-product-image img {
        transform: scale(1.06);
    }

    .sd-product-body {
        padding: 17px;
    }

    .sd-product-name {
        overflow: hidden;
        color: #f8fafc;
        font-size: 14px;
        font-weight: 750;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .sd-product-category {
        margin-top: 5px;
        overflow: hidden;
        color: #64748b;
        font-size: 10px;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .sd-product-price {
        margin-top: 12px;
        color: #00ff99;
        font-size: 19px;
        font-weight: 850;
    }

    .sd-product-stock {
        margin-top: 6px;
        color: #94a3b8;
        font-size: 10px;
    }

    .sd-product-stock i {
        margin-right: 3px;
        color: #00ff99;
    }

    .sd-product-actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
    }

    .sd-edit,
    .sd-delete {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 37px;
        padding: 8px 10px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        transition: .22s ease;
    }

    .sd-edit {
        border: 1px solid rgba(245,158,11,.20);
        background: rgba(245,158,11,.08);
        color: #fbbf24;
    }

    .sd-edit:hover {
        background: rgba(245,158,11,.15);
        border-color: rgba(245,158,11,.35);
        color: #fbbf24;
    }

    .sd-delete {
        width: 100%;
        border: 1px solid rgba(239,68,68,.20);
        background: rgba(239,68,68,.08);
        color: #ff8585;
    }

    .sd-delete:hover {
        background: rgba(239,68,68,.15);
        border-color: rgba(239,68,68,.35);
        color: #ff8585;
    }

    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .sd-empty {
        grid-column: 1 / -1;
        padding: 75px 25px;
        text-align: center;
        border: 1px dashed rgba(148,163,184,.18);
        border-radius: 23px;
        background: rgba(15,23,42,.55);
    }

    .sd-empty i {
        color: #475569;
        font-size: 42px;
    }

    .sd-empty h3 {
        margin: 16px 0 0;
        color: #f8fafc;
        font-size: 18px;
        font-weight: 800;
    }

    .sd-empty p {
        margin: 8px 0 22px;
        color: #64748b;
        font-size: 11px;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1200px) {

        .sd-product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

    }

    @media (max-width: 1050px) {

        .sd-actions,
        .sd-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 768px) {

        .seller-dashboard {
            padding: 22px 15px;
        }

        .sd-top {
            align-items: flex-start;
        }

        .sd-title h1 {
            font-size: 25px;
        }

        .sd-subtitle {
            font-size: 11px;
        }

        .sd-status {
            display: none;
        }

        .sd-product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .sd-product-image {
            height: 170px;
        }

    }

    @media (max-width: 560px) {

        .sd-actions,
        .sd-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .sd-action {
            min-height: 130px;
            padding: 15px;
        }

        .sd-action-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 12px;
        }

        .sd-action-title {
            font-size: 12px;
        }

        .sd-action-text {
            font-size: 9px;
        }

        .sd-stat {
            min-height: 135px;
            padding: 16px;
        }

        .sd-stat-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 14px;
        }

        .sd-stat-number {
            font-size: 21px;
        }

        .sd-stat-label {
            font-size: 9px;
        }

        .sd-section-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .sd-add {
            width: 100%;
        }

        .sd-product-grid {
            grid-template-columns: 1fr;
        }

        .sd-product-image {
            height: 210px;
        }

    }

    /* =========================================================
       REDUCED MOTION
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .sd-action,
        .sd-stat,
        .sd-product,
        .sd-product-image img,
        .sd-add,
        .sd-edit,
        .sd-delete {
            transition: none !important;
        }

    }
</style>


<div class="seller-dashboard">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="sd-top">

        <div class="sd-title">

            <h1>
                Seller <span>Dashboard</span>
            </h1>

            <div class="sd-subtitle">
                Welcome back. Manage your SMART BASKET store from one place.
            </div>

        </div>

        <div class="sd-status">

            <span class="sd-status-dot"></span>

            Seller Account Active

        </div>

    </div>


    {{-- =========================================================
         QUICK ACTIONS
    ========================================================== --}}

    <div class="sd-actions">

        <a
            href="{{ route('seller.product.add') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">
                <i class="fa-solid fa-plus"></i>
            </div>

            <div class="sd-action-title">
                Add Product
            </div>

            <div class="sd-action-text">
                List a new product
            </div>

        </a>


        <a
            href="{{ route('seller.products.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">
                <i class="fa-solid fa-box"></i>
            </div>

            <div class="sd-action-title">
                My Products
            </div>

            <div class="sd-action-text">
                Manage your products
            </div>

        </a>


        <a
            href="{{ route('seller.orders.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

            <div class="sd-action-title">
                Orders
            </div>

            <div class="sd-action-text">
                View customer orders
            </div>

        </a>


        <a
            href="{{ route('seller.payments.index') }}"
            class="sd-action"
        >

            <div class="sd-action-icon">
                <i class="fa-solid fa-wallet"></i>
            </div>

            <div class="sd-action-title">
                Payments
            </div>

            <div class="sd-action-text">
                Track your earnings
            </div>

        </a>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <div class="sd-stats">

        <div class="sd-stat">

            <div class="sd-stat-icon">
                <i class="fa-solid fa-box"></i>
            </div>

            <div class="sd-stat-number">
                {{ $totalProducts }}
            </div>

            <div class="sd-stat-label">
                Total Products
            </div>

        </div>


        <div class="sd-stat">

            <div class="sd-stat-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

            <div class="sd-stat-number">
                {{ $totalOrders }}
            </div>

            <div class="sd-stat-label">
                Total Orders
            </div>

        </div>


        <div class="sd-stat">

            <div class="sd-stat-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div class="sd-stat-number">
                {{ $pendingOrders }}
            </div>

            <div class="sd-stat-label">
                Pending Orders
            </div>

        </div>


        <div class="sd-stat">

            <div class="sd-stat-icon">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>

            <div class="sd-stat-number">
                ₹ {{ number_format($totalRevenue) }}
            </div>

            <div class="sd-stat-label">
                Total Earnings
            </div>

        </div>

    </div>


    {{-- =========================================================
         PRODUCTS
    ========================================================== --}}

    <section class="sd-products">

        <div class="sd-section-head">

            <div>

                <div class="sd-section-title">
                    My Products
                </div>

                <div class="sd-section-subtitle">
                    Manage your listed products
                </div>

            </div>

            <a
                href="{{ route('seller.product.add') }}"
                class="sd-add"
            >

                <i class="fa-solid fa-plus"></i>

                Add Product

            </a>

        </div>


        <div class="sd-product-grid">

            @forelse($products as $product)

                <div class="sd-product">

                    <div class="sd-product-image">

                        <img
                            src="{{ asset('products/'.$product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                        >

                    </div>


                    <div class="sd-product-body">

                        <div class="sd-product-name">
                            {{ $product->name }}
                        </div>

                        <div class="sd-product-category">
                            {{ $product->category }}
                        </div>

                        <div class="sd-product-price">
                            ₹ {{ number_format($product->price) }}
                        </div>

                        <div class="sd-product-stock">

                            <i class="fa-solid fa-cubes"></i>

                            Stock: {{ $product->stock }}

                        </div>


                        <div class="sd-product-actions">

                            <a
                                href="{{ route('seller.product.edit', $product->id) }}"
                                class="sd-edit"
                            >

                                <i class="fa-solid fa-pen"></i>

                                Edit

                            </a>


                            <form
                                action="{{ route('seller.product.delete', $product->id) }}"
                                method="POST"
                                style="flex:1;margin:0;"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="sd-delete"
                                    onclick="return confirm('Delete this product?')"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="sd-empty">

                    <i class="fa-solid fa-box-open"></i>

                    <h3>
                        No Products Added
                    </h3>

                    <p>
                        Start selling by adding your first product.
                    </p>

                    <a
                        href="{{ route('seller.product.add') }}"
                        class="sd-add"
                    >

                        <i class="fa-solid fa-plus"></i>

                        Add Your First Product

                    </a>

                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection
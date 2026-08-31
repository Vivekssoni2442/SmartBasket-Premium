<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Products | SMART BASKET Seller</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        /* =====================================================
           SMART BASKET — SELLER PRODUCTS
           PREMIUM LIGHT THEME
        ===================================================== */

        :root {
            --primary: #00c878;
            --primary-dark: #00a965;
            --primary-soft: rgba(0, 200, 120, .09);

            --bg: #f5f7fb;
            --bg-2: #eef2f7;

            --card: #ffffff;
            --card-soft: #f8fafc;

            --text: #111827;
            --text-2: #374151;
            --muted: #6b7280;
            --muted-2: #9ca3af;

            --border: #e5e7eb;
            --border-soft: #edf0f4;

            --shadow:
                0 10px 30px rgba(15, 23, 42, .055);

            --shadow-hover:
                0 20px 45px rgba(15, 23, 42, .11);
        }


        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;

            font-family: 'Poppins', sans-serif;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            min-height: 100vh;

            overflow-x: hidden;

            color: var(--text);

            background:
                radial-gradient(
                    circle at 8% 5%,
                    rgba(0, 200, 120, .07),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 92% 90%,
                    rgba(59, 130, 246, .055),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f3f6fa,
                    #eef2f7
                );
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .products-page {

            width: 100%;

            max-width: 1450px;

            margin: auto;

            padding: 32px;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .page-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
        }


        .header-left {

            display: flex;

            align-items: center;

            gap: 16px;
        }


        .header-icon {

            width: 58px;
            height: 58px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border-radius: 18px;

            color: var(--primary);

            background:
                linear-gradient(
                    145deg,
                    rgba(0, 200, 120, .13),
                    rgba(0, 200, 120, .045)
                );

            border:
                1px solid rgba(0, 200, 120, .16);

            box-shadow:
                0 8px 25px rgba(0, 200, 120, .08);

            font-size: 23px;
        }


        .eyebrow {

            color: var(--primary);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 2px;

            margin-bottom: 4px;
        }


        .page-title {

            font-size: 29px;

            font-weight: 800;

            line-height: 1.2;

            color: var(--text);
        }


        .page-subtitle {

            margin-top: 5px;

            color: var(--muted);

            font-size: 12px;
        }


        /* =====================================================
           HEADER ACTIONS
        ===================================================== */

        .header-actions {

            display: flex;

            align-items: center;

            gap: 10px;
        }


        .btn-dashboard,
        .btn-add-product {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            min-height: 44px;

            padding: 0 17px;

            border-radius: 13px;

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;

            transition: .25s ease;
        }


        .btn-dashboard {

            color: var(--text-2);

            background: rgba(255,255,255,.82);

            border:
                1px solid var(--border);

            box-shadow:
                0 5px 18px rgba(15,23,42,.035);
        }


        .btn-dashboard:hover {

            color: var(--text);

            background: #fff;

            border-color: #d1d5db;

            transform: translateY(-2px);

            box-shadow:
                0 9px 22px rgba(15,23,42,.08);
        }


        .btn-add-product {

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #00d982,
                    #00b86b
                );

            box-shadow:
                0 10px 25px rgba(0, 200, 120, .15);
        }


        .btn-add-product:hover {

            color: #ffffff;

            transform: translateY(-2px);

            box-shadow:
                0 14px 30px rgba(0, 200, 120, .23);
        }


        /* =====================================================
           ALERTS
        ===================================================== */

        .alert-custom {

            padding: 14px 17px;

            margin-bottom: 22px;

            border-radius: 14px;

            font-size: 12px;

            font-weight: 600;

            box-shadow:
                0 6px 20px rgba(15,23,42,.035);
        }


        .alert-success-custom {

            color: #047857;

            background:
                rgba(16, 185, 129, .08);

            border:
                1px solid rgba(16, 185, 129, .20);
        }


        .alert-error-custom {

            color: #dc2626;

            background:
                rgba(239, 68, 68, .07);

            border:
                1px solid rgba(239, 68, 68, .18);
        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

        .toolbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 22px;

            padding: 15px 17px;

            background:
                rgba(255,255,255,.84);

            border:
                1px solid rgba(226,232,240,.9);

            border-radius: 17px;

            box-shadow:
                var(--shadow);

            backdrop-filter: blur(15px);
        }


        .product-count {

            display: flex;

            align-items: center;

            gap: 9px;

            color: var(--muted);

            font-size: 11px;

            font-weight: 600;
        }


        .product-count i {

            color: var(--primary);

            font-size: 13px;
        }


        .product-count strong {

            color: var(--text);

            font-weight: 800;
        }


        /* =====================================================
           SEARCH
        ===================================================== */

        .search-box {

            position: relative;

            width: 260px;
        }


        .search-box i {

            position: absolute;

            left: 13px;

            top: 50%;

            transform: translateY(-50%);

            color: #9ca3af;

            font-size: 12px;

            pointer-events: none;
        }


        .search-box input {

            width: 100%;

            height: 38px;

            padding:
                0 13px 0 35px;

            color: var(--text);

            background:
                #f8fafc;

            border:
                1px solid var(--border);

            border-radius: 11px;

            outline: none;

            font-size: 11px;

            transition: .2s ease;
        }


        .search-box input::placeholder {

            color: #9ca3af;
        }


        .search-box input:focus {

            background: #fff;

            border-color:
                rgba(0, 200, 120, .45);

            box-shadow:
                0 0 0 3px rgba(0, 200, 120, .07);
        }


        /* =====================================================
           PRODUCT GRID
        ===================================================== */

        .products-grid {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 18px;
        }


        /* =====================================================
           PRODUCT CARD
        ===================================================== */

        .product-card {

            position: relative;

            overflow: hidden;

            border-radius: 21px;

            background:
                rgba(255,255,255,.96);

            border:
                1px solid rgba(226,232,240,.95);

            box-shadow:
                var(--shadow);

            transition: .30s ease;
        }


        .product-card:hover {

            transform: translateY(-6px);

            border-color:
                rgba(0, 200, 120, .22);

            box-shadow:
                var(--shadow-hover),
                0 0 25px rgba(0,200,120,.04);
        }


        /* =====================================================
           PRODUCT IMAGE
        ===================================================== */

        .product-image {

            position: relative;

            width: 100%;

            height: 210px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #f1f5f9,
                    #e5e7eb
                );
        }


        .product-image img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

            transition: .45s ease;
        }


        .product-card:hover
        .product-image img {

            transform: scale(1.06);
        }


        .image-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    to top,
                    rgba(15,23,42,.20),
                    transparent 55%
                );

            pointer-events: none;
        }


        /* =====================================================
           STOCK BADGE
        ===================================================== */

        .stock-badge {

            position: absolute;

            top: 12px;

            right: 12px;

            padding: 6px 9px;

            border-radius: 9px;

            color: #047857;

            background:
                rgba(255,255,255,.92);

            border:
                1px solid rgba(16,185,129,.20);

            box-shadow:
                0 5px 15px rgba(15,23,42,.09);

            backdrop-filter: blur(10px);

            font-size: 9px;

            font-weight: 700;
        }


        .stock-badge i {

            margin-right: 3px;
        }


        /* =====================================================
           NO IMAGE
        ===================================================== */

        .no-image {

            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #cbd5e1;

            font-size: 42px;
        }


        /* =====================================================
           PRODUCT CONTENT
        ===================================================== */

        .product-content {

            padding: 17px;
        }


        .product-category {

            color: var(--primary);

            font-size: 9px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 6px;
        }


        .product-name {

            color: var(--text);

            font-size: 15px;

            font-weight: 700;

            line-height: 1.4;

            min-height: 42px;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }


        .product-price {

            margin-top: 12px;

            color: var(--primary-dark);

            font-size: 20px;

            font-weight: 800;
        }


        .product-price span {

            color: var(--muted-2);

            font-size: 10px;

            font-weight: 500;
        }


        /* =====================================================
           PRODUCT META
        ===================================================== */

        .product-meta {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            margin-top: 9px;

            padding-top: 11px;

            border-top:
                1px solid var(--border-soft);
        }


        .meta-item {

            display: flex;

            align-items: center;

            gap: 6px;

            color: var(--muted);

            font-size: 10px;

            min-width: 0;
        }


        .meta-item i {

            color: #9ca3af;

            flex-shrink: 0;
        }


        .meta-item strong {

            color: var(--text-2);

            font-weight: 700;
        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .product-actions {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 8px;

            margin-top: 15px;
        }


        .action-btn {

            min-height: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            border-radius: 10px;

            font-size: 10px;

            font-weight: 700;

            cursor: pointer;

            text-decoration: none;

            transition: .22s ease;
        }


        /* =====================================================
           EDIT
        ===================================================== */

        .edit-btn {

            color: #b77900;

            background:
                rgba(245,158,11,.08);

            border:
                1px solid rgba(245,158,11,.18);
        }


        .edit-btn:hover {

            color: #ffffff;

            background: #f59e0b;

            border-color: #f59e0b;

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(245,158,11,.18);
        }


        /* =====================================================
           DELETE
        ===================================================== */

        .delete-btn {

            color: #dc2626;

            background:
                rgba(239,68,68,.06);

            border:
                1px solid rgba(239,68,68,.16);
        }


        .delete-btn:hover {

            color: #ffffff;

            background: #ef4444;

            border-color: #ef4444;

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(239,68,68,.18);
        }


        /* =====================================================
           EMPTY STATE
        ===================================================== */

        .empty-state {

            grid-column: 1 / -1;

            padding: 75px 25px;

            text-align: center;

            border-radius: 22px;

            background:
                rgba(255,255,255,.86);

            border:
                1px dashed #d7dde6;

            box-shadow:
                var(--shadow);
        }


        .empty-icon {

            width: 70px;

            height: 70px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 18px;

            border-radius: 22px;

            color: #9ca3af;

            background:
                #f1f5f9;

            border:
                1px solid #e5e7eb;

            font-size: 28px;
        }


        .empty-state h2 {

            color: var(--text-2);

            font-size: 18px;

            font-weight: 700;
        }


        .empty-state p {

            margin-top: 7px;

            color: var(--muted);

            font-size: 11px;
        }


        .empty-add {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 20px;

            padding: 11px 17px;

            border-radius: 11px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #00d982,
                    #00b86b
                );

            text-decoration: none;

            font-size: 11px;

            font-weight: 800;

            transition: .2s;
        }


        .empty-add:hover {

            color: #ffffff;

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(0,200,120,.18);
        }


        /* =====================================================
           SEARCH NO RESULT
        ===================================================== */

        .search-empty {

            display: none;

            grid-column: 1 / -1;

            padding: 60px 20px;

            text-align: center;

            border-radius: 20px;

            background:
                rgba(255,255,255,.85);

            border:
                1px solid var(--border);

            box-shadow:
                var(--shadow);
        }


        .search-empty i {

            color: #cbd5e1;

            font-size: 32px;

            margin-bottom: 12px;
        }


        .search-empty h3 {

            color: var(--text-2);

            font-size: 16px;

            font-weight: 700;
        }


        .search-empty p {

            margin-top: 5px;

            color: var(--muted);

            font-size: 11px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width:1200px) {

            .products-grid {

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }


        @media(max-width:900px) {

            .products-page {

                padding: 24px 18px;
            }


            .products-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }


        @media(max-width:650px) {

            .products-page {

                padding: 20px 14px;
            }


            .page-header {

                align-items: flex-start;

                flex-direction: column;
            }


            .header-left {

                width: 100%;
            }


            .header-icon {

                width: 52px;

                height: 52px;

                border-radius: 16px;
            }


            .header-actions {

                width: 100%;
            }


            .btn-dashboard,
            .btn-add-product {

                flex: 1;
            }


            .toolbar {

                align-items: stretch;

                flex-direction: column;

                padding: 14px;
            }


            .search-box {

                width: 100%;
            }


            .products-grid {

                grid-template-columns: 1fr;

                gap: 15px;
            }


            .product-image {

                height: 230px;
            }


            .page-title {

                font-size: 23px;
            }


            .page-subtitle {

                font-size: 11px;

                line-height: 1.5;
            }
        }


        @media(max-width:400px) {

            .header-left {

                align-items: flex-start;
            }


            .header-icon {

                width: 46px;

                height: 46px;

                font-size: 18px;
            }


            .eyebrow {

                font-size: 8px;
            }


            .page-title {

                font-size: 21px;
            }


            .btn-dashboard,
            .btn-add-product {

                padding: 0 11px;

                font-size: 10px;
            }
        }

    </style>

</head>


<body>


<div class="products-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="page-header">

        <div class="header-left">

            <div class="header-icon">

                <i class="fa-solid fa-boxes-stacked"></i>

            </div>


            <div>

                <div class="eyebrow">
                    SELLER PANEL
                </div>


                <h1 class="page-title">
                    My Products
                </h1>


                <p class="page-subtitle">
                    Manage products listed under your SMART BASKET seller account.
                </p>

            </div>

        </div>


        <div class="header-actions">

            <a
                href="{{ route('seller.dashboard') }}"
                class="btn-dashboard"
            >

                <i class="fa-solid fa-chart-line"></i>

                Dashboard

            </a>


            <a
                href="{{ route('seller.product.add') }}"
                class="btn-add-product"
            >

                <i class="fa-solid fa-plus"></i>

                Add Product

            </a>

        </div>

    </header>


    {{-- =====================================================
         ALERTS
    ====================================================== --}}

    @if(session('success'))

        <div class="alert-custom alert-success-custom">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="alert-custom alert-error-custom">

            <i class="fa-solid fa-circle-exclamation"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- =====================================================
         TOOLBAR
    ====================================================== --}}

    <div class="toolbar">

        <div class="product-count">

            <i class="fa-solid fa-cube"></i>

            <span>

                Your Products:

                <strong>
                    {{ $products->count() }}
                </strong>

            </span>

        </div>


        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="productSearch"
                placeholder="Search your products..."
                autocomplete="off"
            >

        </div>

    </div>


    {{-- =====================================================
         PRODUCTS
    ====================================================== --}}

    <div
        class="products-grid"
        id="productsGrid"
    >


        @forelse($products as $product)


            <article
                class="product-card"
                data-product-name="{{ strtolower($product->name) }}"
                data-product-category="{{ strtolower($product->category) }}"
            >


                {{-- IMAGE --}}

                <div class="product-image">

                    @if($product->image)

                        <img
                            src="{{ asset('products/'.$product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                        >

                        <div class="image-overlay"></div>

                    @else

                        <div class="no-image">

                            <i class="fa-solid fa-image"></i>

                        </div>

                    @endif


                    <div class="stock-badge">

                        <i class="fa-solid fa-cubes"></i>

                        {{ $product->stock }} Stock

                    </div>

                </div>


                {{-- CONTENT --}}

                <div class="product-content">


                    <div class="product-category">

                        {{ $product->category }}

                    </div>


                    <div class="product-name">

                        {{ $product->name }}

                    </div>


                    <div class="product-price">

                        ₹{{ number_format((float) $product->price, 2) }}

                        <span>
                            selling price
                        </span>

                    </div>


                    <div class="product-meta">


                        <div class="meta-item">

                            <i class="fa-solid fa-box"></i>

                            <span>

                                Stock

                                <strong>
                                    {{ $product->stock }}
                                </strong>

                            </span>

                        </div>


                        @if(isset($product->brand) && $product->brand)

                            <div class="meta-item">

                                <i class="fa-solid fa-tag"></i>

                                <strong>
                                    {{ $product->brand }}
                                </strong>

                            </div>

                        @endif


                    </div>


                    {{-- ACTIONS --}}

                    <div class="product-actions">


                        <a
                            href="{{ route('seller.product.edit', $product->id) }}"
                            class="action-btn edit-btn"
                        >

                            <i class="fa-solid fa-pen"></i>

                            Edit

                        </a>


                        <form
                            action="{{ route('seller.product.delete', $product->id) }}"
                            method="POST"
                            style="margin:0;"
                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="action-btn delete-btn"
                                style="width:100%;"
                            >

                                <i class="fa-solid fa-trash"></i>

                                Delete

                            </button>

                        </form>


                    </div>


                </div>


            </article>


        @empty


            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>


                <h2>
                    No Products Added Yet
                </h2>


                <p>
                    Start selling by adding your first product to SMART BASKET.
                </p>


                <a
                    href="{{ route('seller.product.add') }}"
                    class="empty-add"
                >

                    <i class="fa-solid fa-plus"></i>

                    Add Your First Product

                </a>

            </div>


        @endforelse


        {{-- SEARCH EMPTY RESULT --}}

        @if($products->count() > 0)

            <div
                class="search-empty"
                id="searchEmpty"
            >

                <i class="fa-solid fa-box-open"></i>

                <h3>
                    No Products Found
                </h3>

                <p>
                    Try searching with another product name or category.
                </p>

            </div>

        @endif


    </div>


</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('productSearch');

    const products =
        document.querySelectorAll('.product-card');

    const searchEmpty =
        document.getElementById('searchEmpty');


    if (!searchInput) {
        return;
    }


    searchInput.addEventListener('input', function () {

        const search =
            this.value
                .toLowerCase()
                .trim();


        let visibleProducts = 0;


        products.forEach(function (product) {

            const name =
                product.dataset.productName || '';

            const category =
                product.dataset.productCategory || '';


            const match =
                name.includes(search) ||
                category.includes(search);


            if (match) {

                product.style.display = '';

                visibleProducts++;

            } else {

                product.style.display = 'none';

            }

        });


        if (searchEmpty) {

            searchEmpty.style.display =
                search.length > 0 && visibleProducts === 0
                    ? 'block'
                    : 'none';
        }

    });

});

</script>


</body>

    @include('seller.partials.seller-menu')

</html>
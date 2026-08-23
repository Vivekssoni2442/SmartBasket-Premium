```blade
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

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>

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
            color: #fff;
            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 8% 5%,
                    rgba(0,255,153,.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 92% 90%,
                    rgba(59,130,246,.10),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #020617,
                    #030712,
                    #000
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

            border-radius: 18px;

            color: #00ff99;

            background:
                linear-gradient(
                    145deg,
                    rgba(0,255,153,.16),
                    rgba(0,255,153,.04)
                );

            border: 1px solid rgba(0,255,153,.18);

            box-shadow:
                0 0 30px rgba(0,255,153,.08);

            font-size: 23px;
        }

        .eyebrow {
            color: #00ff99;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .page-title {
            font-size: 29px;
            font-weight: 800;
            color: #fff;
        }

        .page-subtitle {
            margin-top: 5px;
            color: rgba(255,255,255,.42);
            font-size: 12px;
        }

        /* =====================================================
           HEADER BUTTONS
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
            color: rgba(255,255,255,.75);

            background:
                rgba(255,255,255,.045);

            border:
                1px solid rgba(255,255,255,.10);
        }

        .btn-dashboard:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.20);
            transform: translateY(-2px);
        }

        .btn-add-product {
            color: #020617;

            background:
                linear-gradient(
                    135deg,
                    #00ff99,
                    #00d681
                );

            box-shadow:
                0 10px 25px rgba(0,255,153,.10);
        }

        .btn-add-product:hover {
            color: #020617;
            transform: translateY(-2px);
            box-shadow:
                0 14px 30px rgba(0,255,153,.22);
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

            backdrop-filter: blur(15px);
        }

        .alert-success-custom {
            color: #7dffc8;
            background: rgba(0,255,153,.08);
            border: 1px solid rgba(0,255,153,.20);
        }

        .alert-error-custom {
            color: #ff8d8d;
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.20);
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
                rgba(255,255,255,.035);

            border:
                1px solid rgba(255,255,255,.07);

            border-radius: 17px;

            backdrop-filter: blur(18px);
        }

        .product-count {
            display: flex;
            align-items: center;
            gap: 9px;

            color: rgba(255,255,255,.55);

            font-size: 11px;
            font-weight: 600;
        }

        .product-count i {
            color: #00ff99;
        }

        .product-count strong {
            color: #fff;
        }

        .search-box {
            position: relative;
            width: 260px;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);

            color: rgba(255,255,255,.30);

            font-size: 12px;
        }

        .search-box input {
            width: 100%;
            height: 38px;

            padding:
                0 13px 0 35px;

            color: #fff;

            background:
                rgba(255,255,255,.045);

            border:
                1px solid rgba(255,255,255,.09);

            border-radius: 11px;

            outline: none;

            font-size: 11px;

            transition: .2s ease;
        }

        .search-box input::placeholder {
            color: rgba(255,255,255,.30);
        }

        .search-box input:focus {
            border-color: rgba(0,255,153,.35);
            box-shadow:
                0 0 0 3px rgba(0,255,153,.05);
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
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.065),
                    rgba(255,255,255,.022)
                );

            border:
                1px solid rgba(255,255,255,.08);

            backdrop-filter: blur(18px);

            transition: .30s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);

            border-color:
                rgba(0,255,153,.20);

            box-shadow:
                0 20px 45px rgba(0,0,0,.28),
                0 0 25px rgba(0,255,153,.05);
        }

        /* =====================================================
           IMAGE
        ===================================================== */

        .product-image {
            position: relative;

            width: 100%;
            height: 210px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #0f172a,
                    #020617
                );
        }

        .product-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;

            transition: .45s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.06);
        }

        .image-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to top,
                    rgba(0,0,0,.55),
                    transparent 55%
                );

            pointer-events: none;
        }

        .stock-badge {
            position: absolute;

            top: 12px;
            right: 12px;

            padding: 6px 9px;

            border-radius: 9px;

            color: #8affcb;

            background:
                rgba(0,0,0,.65);

            border:
                1px solid rgba(0,255,153,.18);

            backdrop-filter: blur(10px);

            font-size: 9px;
            font-weight: 700;
        }

        .no-image {
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            color: rgba(255,255,255,.18);

            font-size: 42px;
        }

        /* =====================================================
           PRODUCT INFO
        ===================================================== */

        .product-content {
            padding: 17px;
        }

        .product-category {
            color: #00ff99;

            font-size: 9px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 1px;

            margin-bottom: 6px;
        }

        .product-name {
            color: #fff;

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

            color: #00ff99;

            font-size: 20px;
            font-weight: 800;
        }

        .product-price span {
            color: rgba(255,255,255,.35);

            font-size: 10px;
            font-weight: 500;
        }

        .product-meta {
            display: flex;

            align-items: center;
            justify-content: space-between;

            margin-top: 9px;
            padding-top: 11px;

            border-top:
                1px solid rgba(255,255,255,.07);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;

            color: rgba(255,255,255,.42);

            font-size: 10px;
        }

        .meta-item i {
            color: rgba(255,255,255,.28);
        }

        .meta-item strong {
            color: rgba(255,255,255,.72);
        }

        /* =====================================================
           ACTIONS
        ===================================================== */

        .product-actions {
            display: grid;

            grid-template-columns: 1fr 1fr;

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

        .edit-btn {
            color: #ffd166;

            background:
                rgba(255,209,102,.07);

            border:
                1px solid rgba(255,209,102,.16);
        }

        .edit-btn:hover {
            color: #020617;
            background: #ffd166;

            transform: translateY(-2px);
        }

        .delete-btn {
            color: #ff8585;

            background:
                rgba(239,68,68,.07);

            border:
                1px solid rgba(239,68,68,.16);
        }

        .delete-btn:hover {
            color: #fff;
            background: #ef4444;

            transform: translateY(-2px);
        }

        /* =====================================================
           EMPTY
        ===================================================== */

        .empty-state {
            grid-column: 1 / -1;

            padding: 75px 25px;

            text-align: center;

            border-radius: 22px;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.045),
                    rgba(255,255,255,.018)
                );

            border:
                1px dashed rgba(255,255,255,.12);
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            border-radius: 22px;

            color: rgba(255,255,255,.25);

            background:
                rgba(255,255,255,.035);

            font-size: 28px;
        }

        .empty-state h2 {
            color: rgba(255,255,255,.72);

            font-size: 18px;
            font-weight: 700;
        }

        .empty-state p {
            margin-top: 7px;

            color: rgba(255,255,255,.35);

            font-size: 11px;
        }

        .empty-add {
            display: inline-flex;

            align-items: center;
            gap: 8px;

            margin-top: 20px;

            padding: 11px 17px;

            border-radius: 11px;

            color: #020617;

            background: #00ff99;

            text-decoration: none;

            font-size: 11px;
            font-weight: 800;

            transition: .2s;
        }

        .empty-add:hover {
            color: #020617;
            transform: translateY(-2px);
            box-shadow:
                0 10px 25px rgba(0,255,153,.18);
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

            .page-header {
                align-items: flex-start;
                flex-direction: column;
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
            }

            .search-box {
                width: 100%;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 23px;
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
                <strong>{{ $products->count() }}</strong>
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


    </div>


</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('productSearch');

    const products =
        document.querySelectorAll('.product-card');


    if (!searchInput) {
        return;
    }


    searchInput.addEventListener('input', function () {

        const search =
            this.value
                .toLowerCase()
                .trim();


        products.forEach(function (product) {

            const name =
                product.dataset.productName || '';

            const category =
                product.dataset.productCategory || '';


            const match =
                name.includes(search) ||
                category.includes(search);


            product.style.display =
                match ? '' : 'none';

        });

    });

});

</script>


</body>

</html>
```

<!doctype html>
<html lang="en" data-theme="light">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <title>For You | Smart Basket</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--sb-bg) !important;
            color: var(--sb-text) !important;
            font-family: Poppins, Arial, sans-serif;
            transition:
                background .3s ease,
                color .3s ease;
        }

        .customer-dashboard {
            min-height: 100vh;
            padding: 35px 20px 50px;
            background:
                radial-gradient(
                    circle at 10% 0%,
                    rgba(37,99,235,.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 100%,
                    rgba(124,58,237,.08),
                    transparent 30%
                ),
                var(--sb-bg);
        }

        .dashboard-container {
            max-width: 1250px;
            margin: auto;
        }

        /* HEADER */

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-title {
            margin: 0;
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -.5px;
            color: var(--sb-text);
        }

        .dashboard-subtitle {
            margin: 7px 0 0;
            color: var(--sb-text-secondary);
            font-size: .9rem;
        }

        .browse-btn {
            border: 1px solid var(--sb-border);
            color: var(--sb-text) !important;
            background: var(--sb-card);
            border-radius: 12px;
            padding: 10px 17px;
            font-weight: 600;
            transition: .25s ease;
        }

        .browse-btn:hover {
            background: var(--sb-primary);
            border-color: var(--sb-primary);
            color: #fff !important;
            transform: translateY(-2px);
        }

        /* PRODUCT GRID */

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        /* PRODUCT CARD */

        .customer-product-card {
            overflow: hidden;
            border-radius: 18px;
            background: var(--sb-card);
            border: 1px solid var(--sb-border);
            box-shadow: var(--sb-shadow);
            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .customer-product-card:hover {
            transform: translateY(-6px);
            border-color: var(--sb-primary);
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background: var(--sb-card-hover);
        }

        .product-image {
            width: 100%;
            height: 190px;
            display: block;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .customer-product-card:hover .product-image {
            transform: scale(1.04);
        }

        .product-content {
            padding: 17px;
        }

        .product-name {
            margin: 0 0 8px;
            color: var(--sb-text);
            font-size: 1rem;
            font-weight: 700;
        }

        .product-rating {
            margin-bottom: 15px;
            color: var(--sb-warning);
            font-size: .88rem;
        }

        .product-price {
            color: var(--sb-primary);
            font-size: 1.05rem;
            font-weight: 800;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .view-btn {
            flex: 1;
            border: 1px solid var(--sb-border);
            background: transparent;
            color: var(--sb-text) !important;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: .8rem;
            font-weight: 600;
        }

        .view-btn:hover {
            background: var(--sb-card-hover);
        }

        .cart-btn {
            flex: 1;
            border: 0;
            background: var(--sb-primary);
            color: #fff;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: .8rem;
            font-weight: 700;
        }

        .cart-btn:hover {
            background: var(--sb-primary-hover);
        }

        /* EMPTY */

        .empty-box {
            padding: 50px 20px;
            text-align: center;
            border-radius: 18px;
            background: var(--sb-card);
            border: 1px solid var(--sb-border);
            color: var(--sb-text-secondary);
        }

        /* LIGHT MODE PREMIUM */

        html[data-theme="light"] .customer-dashboard {
            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(59,130,246,.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 100%,
                    rgba(139,92,246,.10),
                    transparent 30%
                ),
                #f4f7fb;
        }

        html[data-theme="light"] .customer-product-card {
            background: rgba(255,255,255,.92);
            box-shadow:
                0 12px 35px rgba(15,23,42,.07);
        }

        html[data-theme="light"] .product-image-wrapper {
            background: #eef3f8;
        }

        /* DARK MODE */

        html[data-theme="dark"] .customer-dashboard {
            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(59,130,246,.15),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 100%,
                    rgba(124,58,237,.12),
                    transparent 30%
                ),
                #020617;
        }

        /* MOBILE */

        @media (max-width: 1000px) {

            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

        }

        @media (max-width: 700px) {

            .dashboard-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 13px;
            }

            .product-image {
                height: 150px;
            }

            .product-content {
                padding: 13px;
            }

        }

        @media (max-width: 450px) {

            .customer-dashboard {
                padding: 25px 12px 40px;
            }

            .product-grid {
                grid-template-columns: 1fr 1fr;
            }

            .product-image {
                height: 135px;
            }

            .product-name {
                font-size: .88rem;
            }

            .product-actions {
                flex-direction: column;
            }

        }

    </style>

</head>


<body>

<div class="customer-dashboard">

    <main class="dashboard-container">

        <header class="dashboard-header">

            <div>

                <h1 class="dashboard-title">
                    For You
                </h1>

                <p class="dashboard-subtitle">
                    Discover products picked specially for you.
                </p>

            </div>

            <a
                href="{{ route('products.index') }}"
                class="browse-btn"
            >
                <i class="fa-solid fa-store me-1"></i>
                Browse All
            </a>

        </header>


        @if($products->count())

            <div class="product-grid">

                @foreach($products as $product)

                    <article class="customer-product-card">

                        <div class="product-image-wrapper">

                            <img
                                src="{{ asset('products/'.$product->image) }}"
                                class="product-image"
                                alt="{{ $product->name }}"
                            >

                        </div>


                        <div class="product-content">

                            <h2 class="product-name">
                                {{ $product->name }}
                            </h2>


                            <div class="product-rating">

                                ★ {{ $product->rating }}

                            </div>


                            <div class="product-price">

                                ₹{{ number_format($product->sellingPrice(), 2) }}

                            </div>


                            <div class="product-actions">

                                <a
                                    href="{{ route('product.show', $product) }}"
                                    class="view-btn text-center"
                                >
                                    View
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('cart.add', $product) }}"
                                    style="flex:1;"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="cart-btn w-100"
                                    >
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Cart
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="empty-box">

                <i class="fa-solid fa-box-open fa-2x mb-3"></i>

                <div>
                    Recommendations will appear as you browse and shop.
                </div>

            </div>

        @endif

    </main>

</div>


<script>

(function () {

    /*
     * Customer theme sync
     *
     * Settings page should save:
     * localStorage.setItem('sb-theme', 'light')
     * OR
     * localStorage.setItem('sb-theme', 'dark')
     */

    const savedTheme = localStorage.getItem('sb-theme');

    if (
        savedTheme === 'light' ||
        savedTheme === 'dark'
    ) {

        document.documentElement.setAttribute(
            'data-theme',
            savedTheme
        );

    }

})();

</script>


</body>
</html>
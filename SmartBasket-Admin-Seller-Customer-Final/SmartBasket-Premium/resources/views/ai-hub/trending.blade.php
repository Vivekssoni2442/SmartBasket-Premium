<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('ai-hub.partials.head', [
        'title' => 'Trending Products'
    ])

    <style>

        /* =========================================================
           SMART BASKET — PREMIUM TRENDING PRODUCTS
        ========================================================= */

        .sb-trending-page {
            position: relative;
        }

        /* =========================================================
           TRENDING HERO
        ========================================================= */

        .sb-trending-hero {
            position: relative;
            overflow: hidden;

            padding: 30px;

            margin-bottom: 24px;

            border: 1px solid
                rgba(99,102,241,.14);

            border-radius: 24px;

            background:
                radial-gradient(
                    circle at 90% 10%,
                    rgba(99,102,241,.14),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 10% 100%,
                    rgba(14,165,233,.08),
                    transparent 35%
                ),
                var(--sb-card, #ffffff);

            box-shadow:
                0 18px 50px
                rgba(15,23,42,.07);
        }

        .sb-trending-hero::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -70px;
            top: -80px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.13),
                    transparent 70%
                );

            pointer-events: none;
        }

        .sb-trending-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 12px;

            border-radius: 999px;

            background:
                rgba(99,102,241,.10);

            color: #6366f1;

            font-size: .67rem;
            font-weight: 900;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .sb-trending-hero h1 {
            position: relative;
            z-index: 2;

            margin: 13px 0 8px;

            color: var(--sb-text, #111827);

            font-size:
                clamp(1.9rem, 4vw, 2.7rem);

            font-weight: 950;

            letter-spacing: -.045em;
        }

        .sb-trending-hero p {
            position: relative;
            z-index: 2;

            max-width: 700px;

            margin: 0;

            color: var(--sb-muted, #64748b);

            font-size: .92rem;

            line-height: 1.7;
        }

        /* =========================================================
           STATS
        ========================================================= */

        .sb-trending-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;

            margin-top: 20px;
        }

        .sb-trending-stat {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 9px 13px;

            border: 1px solid
                rgba(148,163,184,.18);

            border-radius: 12px;

            background:
                rgba(148,163,184,.06);

            color: var(--sb-muted, #64748b);

            font-size: .74rem;
            font-weight: 800;
        }

        .sb-trending-stat i {
            color: #6366f1;
        }

        /* =========================================================
           RESULT PANEL
        ========================================================= */

        .sb-trending-panel {
            overflow: hidden;

            border: 1px solid
                rgba(148,163,184,.18);

            border-radius: 24px;

            background:
                var(--sb-card, #ffffff);

            box-shadow:
                0 18px 50px
                rgba(15,23,42,.07);
        }

        .sb-trending-panel-head {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 23px 25px;

            border-bottom:
                1px solid
                rgba(148,163,184,.15);
        }

        .sb-trending-panel-title {
            margin: 5px 0 0;

            color: var(--sb-text, #111827);

            font-size: 1.12rem;
            font-weight: 900;
        }

        .sb-trending-panel-subtitle {
            margin: 4px 0 0;

            color: var(--sb-muted, #64748b);

            font-size: .78rem;
        }

        .sb-live-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 8px 12px;

            border-radius: 999px;

            background:
                rgba(34,197,94,.10);

            color: #16a34a;

            font-size: .70rem;
            font-weight: 900;

            white-space: nowrap;
        }

        .sb-live-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #22c55e;

            box-shadow:
                0 0 0 4px
                rgba(34,197,94,.10);
        }

        /* =========================================================
           PRODUCT GRID
        ========================================================= */

        .sb-trending-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    auto-fill,
                    minmax(220px, 1fr)
                );

            gap: 18px;

            padding: 24px;
        }

        /* =========================================================
           PRODUCT CARD
        ========================================================= */

        .sb-trending-card {
            position: relative;

            overflow: hidden;

            min-width: 0;

            border: 1px solid
                rgba(148,163,184,.18);

            border-radius: 19px;

            background:
                var(--sb-card-2, #f8fafc);

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .sb-trending-card:hover {
            transform:
                translateY(-5px);

            border-color:
                rgba(99,102,241,.35);

            box-shadow:
                0 18px 40px
                rgba(15,23,42,.12);
        }

        /* =========================================================
           RANK
        ========================================================= */

        .sb-trending-rank {
            position: absolute;

            top: 12px;
            left: 12px;

            z-index: 5;

            display: inline-flex;

            align-items: center;
            gap: 5px;

            padding: 7px 10px;

            border-radius: 10px;

            background:
                rgba(15,23,42,.88);

            color: #fff;

            font-size: .67rem;
            font-weight: 900;

            box-shadow:
                0 7px 18px
                rgba(15,23,42,.18);
        }

        .sb-trending-rank i {
            color: #fbbf24;
        }

        /* =========================================================
           IMAGE
        ========================================================= */

        .sb-trending-image {
            position: relative;

            display: grid;
            place-items: center;

            height: 220px;

            padding: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.72),
                    rgba(248,250,252,.55)
                );

            border-bottom:
                1px solid
                rgba(148,163,184,.14);
        }

        .sb-trending-image img {
            width: 100%;
            height: 185px;

            object-fit: contain;

            transition:
                transform .3s ease;
        }

        .sb-trending-card:hover
        .sb-trending-image img {
            transform:
                scale(1.055);
        }

        .sb-no-image {
            display: grid;
            place-items: center;

            width: 70px;
            height: 70px;

            border-radius: 20px;

            background:
                rgba(99,102,241,.09);

            color: #6366f1;

            font-size: 1.6rem;
        }

        /* =========================================================
           CARD BODY
        ========================================================= */

        .sb-trending-body {
            padding: 17px;
        }

        .sb-trending-name {
            display: -webkit-box;

            margin: 0 0 6px;

            overflow: hidden;

            color: var(--sb-text, #111827);

            font-size: .94rem;
            font-weight: 850;

            line-height: 1.4;

            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .sb-trending-meta {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 13px;

            color: var(--sb-muted, #64748b);

            font-size: .72rem;
        }

        .sb-trending-rating {
            color: #f59e0b;

            font-weight: 850;
        }

        .sb-trending-price-row {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 8px;
        }

        .sb-trending-price {
            color: #6366f1;

            font-size: 1.08rem;
            font-weight: 950;
        }

        .sb-sold-badge {
            display: inline-flex;

            align-items: center;
            gap: 5px;

            padding: 6px 8px;

            border-radius: 9px;

            background:
                rgba(34,197,94,.10);

            color: #16a34a;

            font-size: .67rem;
            font-weight: 900;

            white-space: nowrap;
        }

        .sb-view-product {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            width: 100%;

            margin-top: 14px;

            padding: 9px 12px;

            border-radius: 10px;

            font-size: .75rem;
            font-weight: 850;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .sb-view-product:hover {
            transform:
                translateY(-2px);

            box-shadow:
                0 8px 18px
                rgba(99,102,241,.18);
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .sb-trending-empty {
            padding: 70px 25px;

            text-align: center;
        }

        .sb-trending-empty-icon {
            display: grid;
            place-items: center;

            width: 78px;
            height: 78px;

            margin: 0 auto 18px;

            border-radius: 24px;

            background:
                rgba(99,102,241,.10);

            color: #6366f1;

            font-size: 1.8rem;
        }

        .sb-trending-empty h3 {
            margin-bottom: 7px;

            color: var(--sb-text, #111827);

            font-weight: 900;
        }

        .sb-trending-empty p {
            max-width: 560px;

            margin: 0 auto 20px;

            color: var(--sb-muted, #64748b);

            line-height: 1.7;
        }

        /* =========================================================
           DARK THEME
        ========================================================= */

        [data-theme="dark"] .sb-trending-hero,
        [data-sb-theme="dark"] .sb-trending-hero {

            --sb-card: #0f172a;
            --sb-card-2: #111c31;
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;

            border-color:
                rgba(148,163,184,.16);

            box-shadow:
                0 22px 60px
                rgba(0,0,0,.28);
        }

        [data-theme="dark"] .sb-trending-panel,
        [data-sb-theme="dark"] .sb-trending-panel {

            --sb-card: #0f172a;

            border-color:
                rgba(148,163,184,.16);

            box-shadow:
                0 22px 60px
                rgba(0,0,0,.28);
        }

        [data-theme="dark"] .sb-trending-card,
        [data-sb-theme="dark"] .sb-trending-card {

            --sb-card-2: #111c31;
            --sb-text: #f8fafc;
            --sb-muted: #94a3b8;

            border-color:
                rgba(148,163,184,.16);
        }

        [data-theme="dark"] .sb-trending-image,
        [data-sb-theme="dark"] .sb-trending-image {

            background:
                linear-gradient(
                    135deg,
                    rgba(15,23,42,.90),
                    rgba(30,41,59,.60)
                );
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 767.98px) {

            .sb-trending-hero {
                padding: 23px 20px;

                border-radius: 20px;
            }

            .sb-trending-panel-head {
                padding: 19px;

                align-items: flex-start;
                flex-direction: column;
            }

            .sb-trending-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0,1fr)
                    );

                gap: 12px;

                padding: 15px;
            }

            .sb-trending-image {
                height: 175px;
            }

            .sb-trending-image img {
                height: 145px;
            }

            .sb-trending-body {
                padding: 13px;
            }

            .sb-trending-price-row {
                align-items: flex-start;
                flex-direction: column;
            }

        }

        @media (max-width: 480px) {

            .sb-trending-grid {
                grid-template-columns: 1fr;
            }

            .sb-trending-image {
                height: 210px;
            }

            .sb-trending-image img {
                height: 175px;
            }

        }

    </style>

</head>


<body>

<div class="ai-hub-layout">

    {{-- =========================================================
         GLOBAL AI HUB
         ONLY ONE INSTANCE
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    <main class="ai-hub-main">

        <div class="sb-trending-page">

            {{-- =================================================
                 HERO
            ================================================== --}}

            <section class="sb-trending-hero">

                <span class="sb-trending-eyebrow">

                    <i class="fa-solid fa-fire"></i>

                    Popular Now

                </span>

                <h1>
                    Trending Products
                </h1>

                <p>
                    Discover the products customers are actually
                    buying the most on Smart Basket. This list is
                    based on real sales activity — not random products.
                </p>


                <div class="sb-trending-stats">

                    <span class="sb-trending-stat">

                        <i class="fa-solid fa-chart-line"></i>

                        Sales Based Trending

                    </span>

                    <span class="sb-trending-stat">

                        <i class="fa-solid fa-ranking-star"></i>

                        Top 12 Products

                    </span>

                    <span class="sb-trending-stat">

                        <i class="fa-solid fa-bolt"></i>

                        Live Popularity

                    </span>

                </div>

            </section>


            {{-- =================================================
                 ACTUAL TRENDING DATA
                 
                 IMPORTANT:
                 Only products having sales > 0 are considered.
                 Then they are sorted by actual sold quantity.
                 Finally only TOP 12 are displayed.
            ================================================== --}}

            @php

                $realTrendingProducts = collect($trendingProducts ?? [])
                    ->filter(function ($product) use ($sales) {

                        return (int) ($sales[$product->id] ?? 0) > 0;

                    })
                    ->sortByDesc(function ($product) use ($sales) {

                        return (int) ($sales[$product->id] ?? 0);

                    })
                    ->take(12)
                    ->values();

            @endphp


            {{-- =================================================
                 TRENDING PANEL
            ================================================== --}}

            <section class="sb-trending-panel">

                @if($realTrendingProducts->isNotEmpty())

                    {{-- PANEL HEADER --}}

                    <div class="sb-trending-panel-head">

                        <div>

                            <span class="sb-trending-eyebrow">

                                <i class="fa-solid fa-arrow-trend-up"></i>

                                Smart Trending

                            </span>

                            <h2 class="sb-trending-panel-title">

                                Most Purchased Products

                            </h2>

                            <p class="sb-trending-panel-subtitle">

                                Ranked by actual number of products sold.

                            </p>

                        </div>


                        <span class="sb-live-badge">

                            <span class="sb-live-dot"></span>

                            Sales Based

                        </span>

                    </div>


                    {{-- =================================================
                         PRODUCT GRID
                    ================================================== --}}

                    <div class="sb-trending-grid">

                        @foreach($realTrendingProducts as $index => $product)

                            @php

                                $soldCount =
                                    (int) ($sales[$product->id] ?? 0);

                            @endphp


                            <article class="sb-trending-card">

                                {{-- RANK --}}

                                <span class="sb-trending-rank">

                                    <i class="fa-solid fa-fire"></i>

                                    #{{ $index + 1 }}

                                </span>


                                {{-- IMAGE --}}

                                <a
                                    href="{{ route(
                                        'products.show',
                                        $product->id
                                    ) }}"
                                    class="text-decoration-none"
                                >

                                    <div class="sb-trending-image">

                                        @if(!empty($product->image))

                                            <img
                                                src="{{ asset(
                                                    'products/' .
                                                    $product->image
                                                ) }}"
                                                alt="{{ $product->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <div class="sb-no-image">

                                                <i
                                                    class="fa-solid
                                                           fa-image"
                                                ></i>

                                            </div>

                                        @endif

                                    </div>

                                </a>


                                {{-- BODY --}}

                                <div class="sb-trending-body">

                                    <h3 class="sb-trending-name">

                                        {{ $product->name }}

                                    </h3>


                                    <div class="sb-trending-meta">

                                        <span>

                                            {{ $product->category
                                                ?: 'Smart Basket Product' }}

                                        </span>

                                        <span>•</span>

                                        <span class="sb-trending-rating">

                                            ★

                                            {{ number_format(
                                                (float) (
                                                    $product->rating ?? 0
                                                ),
                                                1
                                            ) }}

                                        </span>

                                    </div>


                                    <div class="sb-trending-price-row">

                                        <span class="sb-trending-price">

                                            ₹{{ number_format(
                                                (float) $product->price,
                                                2
                                            ) }}

                                        </span>


                                        <span class="sb-sold-badge">

                                            <i
                                                class="fa-solid
                                                       fa-arrow-trend-up"
                                            ></i>

                                            {{ number_format(
                                                $soldCount
                                            ) }}

                                            sold

                                        </span>

                                    </div>


                                    {{-- VIEW PRODUCT --}}

                                    @if(Route::has('products.show'))

                                        <a
                                            href="{{ route(
                                                'products.show',
                                                $product->id
                                            ) }}"
                                            class="btn
                                                   btn-outline-primary
                                                   sb-view-product"
                                        >

                                            <i
                                                class="fa-solid
                                                       fa-eye"
                                            ></i>

                                            View Product

                                        </a>

                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    {{-- =================================================
                         NO REAL TRENDING PRODUCTS
                    ================================================== --}}

                    <div class="sb-trending-empty">

                        <div class="sb-trending-empty-icon">

                            <i
                                class="fa-solid
                                       fa-arrow-trend-up"
                            ></i>

                        </div>


                        <h3>
                            No Trending Products Yet
                        </h3>


                        <p>

                            Smart Basket will show products here
                            only after they receive real sales.
                            Products with zero sales are not shown
                            as trending.

                        </p>


                        @if(Route::has('products.index'))

                            <a
                                href="{{ route('products.index') }}"
                                class="btn btn-primary"
                            >

                                <i
                                    class="fa-solid fa-store me-1"
                                ></i>

                                Explore Products

                            </a>

                        @endif

                    </div>

                @endif

            </section>

        </div>

    </main>

</div>

</body>

</html>
@extends('layouts.app')

@section('title', 'AI HUB')

@push('styles')

<link
    rel="stylesheet"
    href="{{ asset('css/ai-hub-dashboard.css') }}"
>

<style>

/* =========================================================
   SMART BASKET — PREMIUM AI HUB
   GLOBAL THEME COMPATIBLE

   Supported:
   data-theme="light"
   data-theme="dark"
   data-sb-theme="light"
   data-sb-theme="dark"
========================================================= */

.sb-ai-page {

    --ai-primary: #6366f1;
    --ai-primary-2: #4f46e5;
    --ai-primary-soft: rgba(99,102,241,.10);

    --ai-pink: #ec4899;
    --ai-purple: #8b5cf6;
    --ai-blue: #0ea5e9;
    --ai-green: #10b981;
    --ai-orange: #f59e0b;

    --ai-bg: var(--sb-bg, #f5f7fb);
    --ai-card: var(--sb-card, #ffffff);
    --ai-card-2: var(--sb-card-2, #f8fafc);

    --ai-text: var(--sb-text, #111827);
    --ai-muted: var(--sb-muted, #64748b);

    --ai-border:
        var(
            --sb-border,
            rgba(148,163,184,.22)
        );

    --ai-shadow:
        0 20px 55px rgba(15,23,42,.08);

    position: relative;

    min-height:
        calc(100vh - 40px);

    padding:
        30px 0 70px;

    color:
        var(--ai-text);

    transition:
        color .25s ease,
        background .25s ease;
}


/* =========================================================
   BACKGROUND
========================================================= */

.sb-ai-page::before {

    content: "";

    position: fixed;

    inset: 0;

    z-index: -2;

    pointer-events: none;

    background:

        radial-gradient(
            circle at 5% 5%,
            rgba(99,102,241,.08),
            transparent 28%
        ),

        radial-gradient(
            circle at 95% 15%,
            rgba(236,72,153,.07),
            transparent 28%
        ),

        radial-gradient(
            circle at 50% 100%,
            rgba(14,165,233,.05),
            transparent 32%
        );
}


/* =========================================================
   HERO
========================================================= */

.sb-ai-hero {

    position: relative;

    overflow: hidden;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

    margin-bottom: 26px;

    padding:
        36px 34px;

    border:
        1px solid var(--ai-border);

    border-radius: 28px;

    background:

        radial-gradient(
            circle at 88% 15%,
            rgba(99,102,241,.17),
            transparent 34%
        ),

        radial-gradient(
            circle at 10% 100%,
            rgba(236,72,153,.09),
            transparent 36%
        ),

        var(--ai-card);

    box-shadow:
        var(--ai-shadow);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


.sb-ai-hero::after {

    content: "🤖";

    position: absolute;

    right: 38px;

    bottom: -45px;

    font-size: 10rem;

    opacity: .055;

    transform:
        rotate(-8deg);

    pointer-events: none;
}


.sb-ai-eyebrow {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding:
        7px 13px;

    border-radius: 999px;

    background:
        var(--ai-primary-soft);

    color:
        var(--ai-primary);

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .13em;

    text-transform: uppercase;
}


.sb-ai-hero h1 {

    position: relative;

    z-index: 1;

    margin:
        14px 0 8px;

    color:
        var(--ai-text);

    font-size:
        clamp(
            2rem,
            4vw,
            2.9rem
        );

    font-weight: 950;

    letter-spacing: -.05em;
}


.sb-ai-hero p {

    position: relative;

    z-index: 1;

    max-width: 700px;

    margin: 0;

    color:
        var(--ai-muted);

    font-size: .95rem;

    line-height: 1.75;
}


/* =========================================================
   BROWSE BUTTON
========================================================= */

.sb-ai-browse-btn {

    position: relative;

    z-index: 2;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    flex-shrink: 0;

    min-height: 48px;

    padding:
        0 18px;

    border:
        1px solid
        rgba(99,102,241,.30);

    border-radius: 13px;

    background:
        var(--ai-card-2);

    color:
        var(--ai-primary);

    font-size: .82rem;

    font-weight: 850;

    text-decoration: none;

    box-shadow:
        0 8px 20px
        rgba(15,23,42,.06);

    transition:
        transform .22s ease,
        background .22s ease,
        border-color .22s ease,
        box-shadow .22s ease;
}


.sb-ai-browse-btn:hover {

    transform:
        translateY(-2px);

    background:
        var(--ai-primary);

    border-color:
        var(--ai-primary);

    color:
        #fff;

    box-shadow:
        0 12px 27px
        rgba(79,70,229,.25);
}


/* =========================================================
   SECTION HEADER
========================================================= */

.sb-ai-section-head {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 20px;

    margin:
        0 2px 17px;
}


.sb-ai-section-label {

    color:
        var(--ai-primary);

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .13em;

    text-transform: uppercase;
}


.sb-ai-section-head h2 {

    margin:
        7px 0 0;

    color:
        var(--ai-text);

    font-size: 1.3rem;

    font-weight: 900;
}


.sb-ai-section-head p {

    margin:
        5px 0 0;

    color:
        var(--ai-muted);

    font-size: .82rem;
}


/* =========================================================
   TOOL GRID
========================================================= */

.sb-ai-tool-grid {

    display: grid;

    grid-template-columns:
        repeat(
            4,
            minmax(0,1fr)
        );

    gap: 17px;
}


/* =========================================================
   TOOL CARD
========================================================= */

.sb-ai-tool {

    position: relative;

    overflow: hidden;

    display: flex;

    flex-direction: column;

    min-height: 250px;

    padding:
        22px;

    border:
        1px solid var(--ai-border);

    border-radius: 21px;

    background:
        var(--ai-card);

    color:
        var(--ai-text);

    text-decoration: none;

    box-shadow:
        0 12px 35px
        rgba(15,23,42,.055);

    transition:
        transform .25s ease,
        border-color .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}


.sb-ai-tool::before {

    content: "";

    position: absolute;

    width: 130px;

    height: 130px;

    right: -60px;

    top: -60px;

    border-radius: 50%;

    background:
        var(--tool-glow);

    opacity: .65;

    pointer-events: none;
}


.sb-ai-tool:hover {

    transform:
        translateY(-6px);

    border-color:
        var(--tool-border);

    box-shadow:
        0 20px 45px
        rgba(15,23,42,.12);

    color:
        var(--ai-text);
}


/* =========================================================
   TOOL ICON
========================================================= */

.sb-ai-tool-icon {

    position: relative;

    z-index: 1;

    display: grid;

    place-items: center;

    width: 58px;

    height: 58px;

    margin-bottom: 19px;

    border:
        1px solid
        var(--tool-border);

    border-radius: 17px;

    background:
        var(--tool-bg);

    font-size: 1.7rem;

    box-shadow:
        0 8px 20px
        rgba(15,23,42,.06);

    transition:
        transform .25s ease;
}


.sb-ai-tool:hover
.sb-ai-tool-icon {

    transform:
        scale(1.08)
        rotate(-3deg);
}


.sb-ai-tool h3 {

    position: relative;

    z-index: 1;

    margin:
        0 0 8px;

    color:
        var(--ai-text);

    font-size: 1rem;

    font-weight: 900;

    line-height: 1.35;
}


.sb-ai-tool p {

    position: relative;

    z-index: 1;

    margin:
        0;

    color:
        var(--ai-muted);

    font-size: .76rem;

    line-height: 1.65;
}


.sb-ai-tool-arrow {

    position: relative;

    z-index: 1;

    display: flex;

    align-items: center;

    justify-content: center;

    width: 32px;

    height: 32px;

    margin-top: auto;

    padding-top: 13px;

    color:
        var(--tool-color);

    transition:
        transform .22s ease;
}


.sb-ai-tool:hover
.sb-ai-tool-arrow {

    transform:
        translateX(5px);
}


/* =========================================================
   INDIVIDUAL TOOL COLORS
========================================================= */

.sb-tool-camera {

    --tool-color: #8b5cf6;

    --tool-bg:
        rgba(139,92,246,.10);

    --tool-border:
        rgba(139,92,246,.22);

    --tool-glow:
        rgba(139,92,246,.13);
}


.sb-tool-budget {

    --tool-color: #10b981;

    --tool-bg:
        rgba(16,185,129,.10);

    --tool-border:
        rgba(16,185,129,.22);

    --tool-glow:
        rgba(16,185,129,.12);
}


.sb-tool-gift {

    --tool-color: #ec4899;

    --tool-bg:
        rgba(236,72,153,.10);

    --tool-border:
        rgba(236,72,153,.22);

    --tool-glow:
        rgba(236,72,153,.13);
}


.sb-tool-trending {

    --tool-color: #f59e0b;

    --tool-bg:
        rgba(245,158,11,.10);

    --tool-border:
        rgba(245,158,11,.23);

    --tool-glow:
        rgba(245,158,11,.12);
}


.sb-tool-compare {

    --tool-color: #6366f1;

    --tool-bg:
        rgba(99,102,241,.10);

    --tool-border:
        rgba(99,102,241,.22);

    --tool-glow:
        rgba(99,102,241,.13);
}


.sb-tool-wishlist {

    --tool-color: #ef4444;

    --tool-bg:
        rgba(239,68,68,.10);

    --tool-border:
        rgba(239,68,68,.22);

    --tool-glow:
        rgba(239,68,68,.12);
}


.sb-tool-cart {

    --tool-color: #0ea5e9;

    --tool-bg:
        rgba(14,165,233,.10);

    --tool-border:
        rgba(14,165,233,.22);

    --tool-glow:
        rgba(14,165,233,.12);
}


.sb-tool-profile {

    --tool-color: #64748b;

    --tool-bg:
        rgba(100,116,139,.10);

    --tool-border:
        rgba(100,116,139,.22);

    --tool-glow:
        rgba(100,116,139,.12);
}


/* =========================================================
   QUICK INFO
========================================================= */

.sb-ai-info {

    position: relative;

    overflow: hidden;

    display: flex;

    align-items: center;

    gap: 17px;

    margin-top: 27px;

    padding:
        23px 25px;

    border:
        1px solid var(--ai-border);

    border-radius: 21px;

    background:
        var(--ai-card);

    box-shadow:
        0 12px 35px
        rgba(15,23,42,.055);
}


.sb-ai-info-icon {

    flex:
        0 0 55px;

    width: 55px;

    height: 55px;

    display: grid;

    place-items: center;

    border-radius: 16px;

    background:
        var(--ai-primary-soft);

    font-size: 1.55rem;
}


.sb-ai-info h3 {

    margin:
        5px 0 5px;

    color:
        var(--ai-text);

    font-size: 1rem;

    font-weight: 900;
}


.sb-ai-info p {

    margin:
        0;

    color:
        var(--ai-muted);

    font-size: .79rem;

    line-height: 1.65;
}


/* =========================================================
   DARK THEME
========================================================= */

[data-theme="dark"] .sb-ai-page,
[data-sb-theme="dark"] .sb-ai-page {

    --ai-bg: #020617;

    --ai-card: #0f172a;

    --ai-card-2: #111c31;

    --ai-text: #f8fafc;

    --ai-muted: #94a3b8;

    --ai-border:
        rgba(148,163,184,.17);

    --ai-shadow:
        0 22px 60px
        rgba(0,0,0,.30);

    --ai-primary-soft:
        rgba(99,102,241,.14);
}


[data-theme="dark"] .sb-ai-tool:hover,
[data-sb-theme="dark"] .sb-ai-tool:hover {

    background:
        #111c31;
}


/* =========================================================
   LIGHT THEME
========================================================= */

[data-theme="light"] .sb-ai-page,
[data-sb-theme="light"] .sb-ai-page {

    --ai-bg: #f5f7fb;

    --ai-card: #ffffff;

    --ai-card-2: #f8fafc;

    --ai-text: #111827;

    --ai-muted: #64748b;

    --ai-border:
        rgba(148,163,184,.22);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1199.98px) {

    .sb-ai-tool-grid {

        grid-template-columns:
            repeat(
                3,
                minmax(0,1fr)
            );
    }

}


@media (max-width: 991.98px) {

    .sb-ai-hero {

        align-items:
            flex-start;

        flex-direction:
            column;
    }

    .sb-ai-tool-grid {

        grid-template-columns:
            repeat(
                2,
                minmax(0,1fr)
            );
    }

}


@media (max-width: 767.98px) {

    .sb-ai-page {

        padding:
            20px 0 55px;
    }

    .sb-ai-hero {

        padding:
            27px 21px;

        border-radius:
            21px;
    }

    .sb-ai-hero::after {

        right:
            -15px;

        font-size:
            7rem;
    }

    .sb-ai-hero h1 {

        font-size:
            1.9rem;
    }

    .sb-ai-section-head {

        align-items:
            flex-start;

        flex-direction:
            column;

        gap: 5px;
    }

    .sb-ai-tool-grid {

        grid-template-columns:
            1fr;

        gap:
            13px;
    }

    .sb-ai-tool {

        min-height:
            205px;
    }

}


@media (max-width: 480px) {

    .sb-ai-tool {

        min-height:
            190px;

        padding:
            19px;
    }

    .sb-ai-info {

        align-items:
            flex-start;

        padding:
            19px;
    }

}

</style>

@endpush


@section('content')

<div class="ai-hub-layout">

    {{-- =====================================================
         GLOBAL AI HUB
         
         DO NOT INCLUDE:
         @include('ai-hub.partials.navigation')
         
         layouts.app already provides the single global
         AI HUB floating button + sidebar.
    ====================================================== --}}


    <main class="ai-hub-main">

        <div class="sb-ai-page">

            {{-- =================================================
                 HERO
            ================================================== --}}

            <section class="sb-ai-hero">

                <div>

                    <span class="sb-ai-eyebrow">

                        <i class="fa-solid fa-sparkles"></i>

                        Personal Shopping Tools

                    </span>

                    <h1>
                        Your AI HUB 🤖
                    </h1>

                    <p>
                        Explore smarter ways to discover,
                        compare, personalize and shop products
                        with Smart Basket AI.
                    </p>

                </div>


                @if(Route::has('products.index'))

                    <a
                        href="{{ route('products.index') }}"
                        class="sb-ai-browse-btn"
                    >

                        <i class="fa-solid fa-store"></i>

                        Browse Products

                    </a>

                @endif

            </section>


            {{-- =================================================
                 SECTION HEADER
            ================================================== --}}

            <div class="sb-ai-section-head">

                <div>

                    <span class="sb-ai-section-label">
                        Smart Basket AI
                    </span>

                    <h2>
                        Choose your shopping tool
                    </h2>

                    <p>
                        Everything you need for smarter shopping,
                        in one place.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 TOOL GRID
            ================================================== --}}

            <section
                class="sb-ai-tool-grid"
                aria-label="Smart Basket AI Tools"
            >


                {{-- =================================================
                     AI CAMERA
                ================================================== --}}

                @if(Route::has('ai-camera-assistant'))

                    <a
                        class="sb-ai-tool sb-tool-camera"
                        href="{{ route('ai-camera-assistant') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            📷
                        </span>

                        <h3>
                            AI Camera Assistant
                        </h3>

                        <p>
                            Use your camera for AI-powered style
                            analysis and personalized product
                            recommendations.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     BUDGET
                ================================================== --}}

                @if(Route::has('budget-shopping'))

                    <a
                        class="sb-ai-tool sb-tool-budget"
                        href="{{ route('budget-shopping') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            💰
                        </span>

                        <h3>
                            Budget Shopping
                        </h3>

                        <p>
                            Discover products that fit your
                            budget without wasting time.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     GIFT FINDER
                ================================================== --}}

                @if(Route::has('gift-finder'))

                    <a
                        class="sb-ai-tool sb-tool-gift"
                        href="{{ route('gift-finder') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            🎁
                        </span>

                        <h3>
                            Gift Finder
                        </h3>

                        <p>
                            Find thoughtful gift ideas for
                            birthdays, anniversaries and festivals.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     TRENDING
                ================================================== --}}

                @if(Route::has('trending-products'))

                    <a
                        class="sb-ai-tool sb-tool-trending"
                        href="{{ route('trending-products') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            🌟
                        </span>

                        <h3>
                            Trending Products
                        </h3>

                        <p>
                            Discover popular products,
                            top-rated items and current trends.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     COMPARE
                ================================================== --}}

                @if(Route::has('compare-products'))

                    <a
                        class="sb-ai-tool sb-tool-compare"
                        href="{{ route('compare-products') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            ⚖️
                        </span>

                        <h3>
                            Compare Products
                        </h3>

                        <p>
                            Compare two products side by side
                            before making your purchase decision.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     WISHLIST
                ================================================== --}}

                @if(Route::has('wishlist'))

                    <a
                        class="sb-ai-tool sb-tool-wishlist"
                        href="{{ route('wishlist') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            ❤️
                        </span>

                        <h3>
                            Wishlist
                        </h3>

                        <p>
                            Save your favourite products and
                            keep them ready for later.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     CART
                ================================================== --}}

                @if(Route::has('cart.index'))

                    <a
                        class="sb-ai-tool sb-tool-cart"
                        href="{{ route('cart.index') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            🛒
                        </span>

                        <h3>
                            Shopping Cart
                        </h3>

                        <p>
                            Continue shopping with products
                            already added to your Smart Basket.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


                {{-- =================================================
                     PROFILE
                ================================================== --}}

                @if(Route::has('profile'))

                    <a
                        class="sb-ai-tool sb-tool-profile"
                        href="{{ route('profile') }}"
                    >

                        <span class="sb-ai-tool-icon">
                            👤
                        </span>

                        <h3>
                            Profile
                        </h3>

                        <p>
                            Manage your customer profile and
                            Smart Basket account settings.
                        </p>

                        <span class="sb-ai-tool-arrow">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </a>

                @endif


            </section>


            {{-- =================================================
                 QUICK INFO
            ================================================== --}}

            <section class="sb-ai-info">

                <div class="sb-ai-info-icon">
                    ✨
                </div>

                <div>

                    <span class="sb-ai-section-label">
                        Smart Shopping
                    </span>

                    <h3>
                        Your AI tools are always available
                    </h3>

                    <p>
                        Use the floating AI HUB button to quickly
                        switch between Smart Basket tools without
                        losing your place.
                    </p>

                </div>

            </section>

        </div>

    </main>

</div>

@endsection
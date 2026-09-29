@extends('layouts.app')

@section('title', 'Gift Finder')

@push('styles')

<link
    rel="stylesheet"
    href="{{ asset('css/ai-hub-dashboard.css') }}"
>

<style>

/* =========================================================
   SMART BASKET — PREMIUM AI GIFT FINDER
   GLOBAL THEME COMPATIBLE

   Supported:
   data-theme="light"
   data-theme="dark"
   data-sb-theme="light"
   data-sb-theme="dark"
========================================================= */

.sb-gift-page {

    --gift-primary: #ec4899;
    --gift-primary-2: #db2777;
    --gift-primary-soft: rgba(236,72,153,.10);

    --gift-purple: #8b5cf6;
    --gift-blue: #3b82f6;

    --gift-bg: var(--sb-bg, #f5f7fb);
    --gift-card: var(--sb-card, #ffffff);
    --gift-card-2: var(--sb-card-2, #f8fafc);

    --gift-text: var(--sb-text, #111827);
    --gift-muted: var(--sb-muted, #64748b);

    --gift-border:
        var(
            --sb-border,
            rgba(148,163,184,.22)
        );

    --gift-shadow:
        0 20px 55px rgba(15,23,42,.08);

    min-height: calc(100vh - 40px);

    padding:
        32px 0 75px;

    color: var(--gift-text);

    position: relative;

    transition:
        color .25s ease,
        background .25s ease;
}


/* =========================================================
   BACKGROUND
========================================================= */

.sb-gift-page::before {

    content: "";

    position: fixed;

    inset: 0;

    z-index: -2;

    pointer-events: none;

    background:

        radial-gradient(
            circle at 5% 5%,
            rgba(236,72,153,.08),
            transparent 27%
        ),

        radial-gradient(
            circle at 95% 20%,
            rgba(139,92,246,.07),
            transparent 27%
        ),

        radial-gradient(
            circle at 50% 100%,
            rgba(59,130,246,.05),
            transparent 30%
        );
}


/* =========================================================
   HERO
========================================================= */

.sb-gift-hero {

    position: relative;

    overflow: hidden;

    margin-bottom: 26px;

    padding: 38px 34px;

    border:
        1px solid var(--gift-border);

    border-radius: 28px;

    background:

        radial-gradient(
            circle at 88% 15%,
            rgba(236,72,153,.16),
            transparent 34%
        ),

        radial-gradient(
            circle at 10% 100%,
            rgba(139,92,246,.10),
            transparent 36%
        ),

        var(--gift-card);

    box-shadow:
        var(--gift-shadow);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


.sb-gift-hero::after {

    content: "🎁";

    position: absolute;

    right: 45px;

    bottom: -32px;

    font-size: 10rem;

    opacity: .055;

    transform: rotate(-8deg);

    pointer-events: none;
}


.sb-gift-eyebrow {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding:
        7px 13px;

    border-radius: 999px;

    background:
        var(--gift-primary-soft);

    color:
        var(--gift-primary);

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .13em;

    text-transform: uppercase;
}


.sb-gift-hero h1 {

    position: relative;

    z-index: 1;

    margin:
        14px 0 9px;

    color:
        var(--gift-text);

    font-size:
        clamp(
            2rem,
            4vw,
            2.8rem
        );

    font-weight: 950;

    letter-spacing: -.045em;
}


.sb-gift-hero p {

    position: relative;

    z-index: 1;

    max-width: 720px;

    margin: 0;

    color:
        var(--gift-muted);

    font-size: .95rem;

    line-height: 1.75;
}


/* =========================================================
   OCCASION PANEL
========================================================= */

.sb-gift-selector {

    margin-bottom: 26px;

    padding: 27px;

    border:
        1px solid var(--gift-border);

    border-radius: 24px;

    background:
        var(--gift-card);

    box-shadow:
        0 15px 45px rgba(15,23,42,.07);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


.sb-gift-selector-head {

    margin-bottom: 20px;
}


.sb-gift-selector-label {

    color:
        var(--gift-primary);

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .12em;

    text-transform: uppercase;
}


.sb-gift-selector h2 {

    margin:
        8px 0 5px;

    color:
        var(--gift-text);

    font-size: 1.25rem;

    font-weight: 900;
}


.sb-gift-selector p {

    margin: 0;

    color:
        var(--gift-muted);

    font-size: .84rem;
}


/* =========================================================
   OCCASION GRID
========================================================= */

.sb-occasion-grid {

    display: grid;

    grid-template-columns:
        repeat(3, minmax(0,1fr));

    gap: 15px;
}


.sb-occasion-card {

    position: relative;

    overflow: hidden;

    display: flex;

    align-items: center;

    gap: 14px;

    width: 100%;

    min-height: 88px;

    padding: 16px;

    border:
        1px solid var(--gift-border);

    border-radius: 17px;

    background:
        var(--gift-card-2);

    color:
        var(--gift-text);

    text-decoration: none;

    cursor: pointer;

    transition:
        transform .22s ease,
        border-color .22s ease,
        background .22s ease,
        box-shadow .22s ease;
}


.sb-occasion-card:hover {

    transform:
        translateY(-3px);

    border-color:
        rgba(236,72,153,.42);

    box-shadow:
        0 13px 30px
        rgba(15,23,42,.10);

    color:
        var(--gift-text);
}


.sb-occasion-card.active {

    border-color:
        rgba(236,72,153,.55);

    background:

        linear-gradient(
            135deg,
            rgba(236,72,153,.12),
            rgba(139,92,246,.08)
        );

    box-shadow:
        0 12px 28px
        rgba(236,72,153,.13);
}


.sb-occasion-icon {

    flex:
        0 0 53px;

    width: 53px;

    height: 53px;

    display: grid;

    place-items: center;

    border-radius: 15px;

    background:
        var(--gift-primary-soft);

    font-size: 1.55rem;

    transition:
        transform .25s ease;
}


.sb-occasion-card:hover
.sb-occasion-icon {

    transform:
        scale(1.08)
        rotate(-3deg);
}


.sb-occasion-content {

    min-width: 0;

    flex: 1;
}


.sb-occasion-title {

    margin-bottom: 3px;

    color:
        var(--gift-text);

    font-size: .92rem;

    font-weight: 900;
}


.sb-occasion-description {

    color:
        var(--gift-muted);

    font-size: .72rem;

    line-height: 1.45;
}


.sb-occasion-arrow {

    color:
        var(--gift-primary);

    font-size: .78rem;

    transition:
        transform .2s ease;
}


.sb-occasion-card:hover
.sb-occasion-arrow {

    transform:
        translateX(3px);
}


/* =========================================================
   RESULTS
========================================================= */

.sb-gift-results {

    overflow: hidden;

    border:
        1px solid var(--gift-border);

    border-radius: 25px;

    background:
        var(--gift-card);

    box-shadow:
        var(--gift-shadow);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


.sb-gift-results-head {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding:
        27px 28px;

    border-bottom:
        1px solid var(--gift-border);

    background:

        linear-gradient(
            135deg,
            rgba(236,72,153,.075),
            transparent
        );
}


.sb-gift-results-label {

    color:
        var(--gift-primary);

    font-size: .68rem;

    font-weight: 900;

    letter-spacing: .12em;

    text-transform: uppercase;
}


.sb-gift-results-title {

    margin:
        8px 0 5px;

    color:
        var(--gift-text);

    font-size: 1.35rem;

    font-weight: 900;
}


.sb-gift-results-subtitle {

    margin: 0;

    color:
        var(--gift-muted);

    font-size: .82rem;
}


/* =========================================================
   OCCASION BADGE
========================================================= */

.sb-gift-badge {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    flex-shrink: 0;

    padding:
        9px 13px;

    border:
        1px solid rgba(236,72,153,.20);

    border-radius: 999px;

    background:
        var(--gift-primary-soft);

    color:
        var(--gift-primary);

    font-size: .72rem;

    font-weight: 850;
}


/* =========================================================
   PRODUCT AREA
========================================================= */

.sb-gift-products {

    padding:
        26px;
}


/*
|--------------------------------------------------------------------------
| Existing AI product-card is intentionally reused.
| This keeps product functionality unchanged.
|--------------------------------------------------------------------------
*/

.sb-gift-products .ai-product-grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fill,
            minmax(220px, 1fr)
        );

    gap: 20px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.sb-gift-empty {

    padding:
        70px 25px;

    text-align: center;
}


.sb-gift-empty-icon {

    width: 82px;

    height: 82px;

    margin:
        0 auto 19px;

    display: grid;

    place-items: center;

    border-radius: 25px;

    background:
        var(--gift-primary-soft);

    color:
        var(--gift-primary);

    font-size: 2rem;

    box-shadow:
        0 12px 30px
        rgba(236,72,153,.10);
}


.sb-gift-empty h3 {

    margin:
        0 0 8px;

    color:
        var(--gift-text);

    font-size: 1.15rem;

    font-weight: 900;
}


.sb-gift-empty p {

    max-width: 570px;

    margin:
        0 auto;

    color:
        var(--gift-muted);

    font-size: .84rem;

    line-height: 1.7;
}


/* =========================================================
   INITIAL STATE
========================================================= */

.sb-gift-start {

    overflow: hidden;

    padding:
        55px 25px;

    text-align: center;

    border:
        1px solid var(--gift-border);

    border-radius: 25px;

    background:
        var(--gift-card);

    box-shadow:
        var(--gift-shadow);
}


.sb-gift-start-icon {

    width: 88px;

    height: 88px;

    margin:
        0 auto 20px;

    display: grid;

    place-items: center;

    border-radius: 27px;

    background:

        linear-gradient(
            135deg,
            rgba(236,72,153,.12),
            rgba(139,92,246,.10)
        );

    font-size: 2.15rem;
}


.sb-gift-start h3 {

    margin-bottom: 8px;

    color:
        var(--gift-text);

    font-size: 1.25rem;

    font-weight: 900;
}


.sb-gift-start p {

    max-width: 570px;

    margin:
        0 auto;

    color:
        var(--gift-muted);

    font-size: .84rem;

    line-height: 1.7;
}


/* =========================================================
   DARK THEME
========================================================= */

[data-theme="dark"] .sb-gift-page,
[data-sb-theme="dark"] .sb-gift-page {

    --gift-bg: #020617;

    --gift-card: #0f172a;

    --gift-card-2: #111c31;

    --gift-text: #f8fafc;

    --gift-muted: #94a3b8;

    --gift-border:
        rgba(148,163,184,.17);

    --gift-shadow:
        0 22px 60px
        rgba(0,0,0,.30);

    --gift-primary-soft:
        rgba(236,72,153,.13);
}


[data-theme="dark"] .sb-occasion-card:hover,
[data-sb-theme="dark"] .sb-occasion-card:hover {

    background:
        #152039;

    border-color:
        rgba(236,72,153,.40);
}


[data-theme="dark"] .sb-occasion-card.active,
[data-sb-theme="dark"] .sb-occasion-card.active {

    background:

        linear-gradient(
            135deg,
            rgba(236,72,153,.15),
            rgba(139,92,246,.12)
        );

    border-color:
        rgba(236,72,153,.50);
}


/* =========================================================
   LIGHT THEME
========================================================= */

[data-theme="light"] .sb-gift-page,
[data-sb-theme="light"] .sb-gift-page {

    --gift-bg: #f5f7fb;

    --gift-card: #ffffff;

    --gift-card-2: #f8fafc;

    --gift-text: #111827;

    --gift-muted: #64748b;

    --gift-border:
        rgba(148,163,184,.22);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991.98px) {

    .sb-occasion-grid {

        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }

}


@media (max-width: 767.98px) {

    .sb-gift-page {

        padding:
            20px 0 55px;
    }

    .sb-gift-hero {

        padding:
            27px 21px;

        border-radius:
            21px;
    }

    .sb-gift-hero::after {

        right: -15px;

        font-size:
            7rem;
    }

    .sb-gift-selector {

        padding:
            20px;

        border-radius:
            20px;
    }

    .sb-gift-results-head {

        align-items:
            flex-start;

        flex-direction:
            column;

        padding:
            22px 20px;
    }

    .sb-gift-products {

        padding:
            20px;
    }

}


@media (max-width: 575.98px) {

    .sb-gift-hero h1 {

        font-size:
            1.75rem;
    }

    .sb-gift-hero p {

        font-size:
            .84rem;
    }

    .sb-occasion-grid {

        grid-template-columns:
            1fr;
    }

    .sb-occasion-card {

        min-height:
            78px;
    }

    .sb-gift-products .ai-product-grid {

        grid-template-columns:
            repeat(2, minmax(0,1fr));

        gap:
            12px;
    }

}


@media (max-width: 390px) {

    .sb-gift-products .ai-product-grid {

        grid-template-columns:
            1fr;
    }

}

</style>

@endpush


@section('content')

<div class="ai-hub-layout">

    {{-- =====================================================
         MAIN CONTENT
         GLOBAL AI HUB COMES FROM layouts.app
    ====================================================== --}}

    <main class="ai-hub-main">

        <div class="sb-gift-page">

            {{-- =================================================
                 HERO
            ================================================== --}}

            <section class="sb-gift-hero">

                <span class="sb-gift-eyebrow">

                    <i class="fa-solid fa-gift"></i>

                    Thoughtful Gifting

                </span>

                <h1>
                    Gift Finder 🎁
                </h1>

                <p>
                    Find thoughtful gifts for every special
                    moment. Choose an occasion and discover
                    gift-ready recommendations from Smart Basket.
                </p>

            </section>


            {{-- =================================================
                 OCCASION SELECTOR
            ================================================== --}}

            <section class="sb-gift-selector">

                <div class="sb-gift-selector-head">

                    <span class="sb-gift-selector-label">

                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i>

                        Choose Occasion

                    </span>

                    <h2>
                        What are you shopping for?
                    </h2>

                    <p>
                        Select an occasion to discover suitable
                        gift ideas.
                    </p>

                </div>


                <form
                    method="GET"
                    action="{{ route('gift-finder') }}"
                    id="giftFinderForm"
                >

                    <div class="sb-occasion-grid">

                        @foreach([
                            [
                                'name' => 'Birthday',
                                'icon' => '🎂',
                                'description' => 'Celebrate their special day'
                            ],
                            [
                                'name' => 'Anniversary',
                                'icon' => '💝',
                                'description' => 'Make the moment memorable'
                            ],
                            [
                                'name' => 'Festival',
                                'icon' => '🎉',
                                'description' => 'Perfect festive surprises'
                            ]
                        ] as $item)

                            <button
                                type="submit"
                                name="occasion"
                                value="{{ $item['name'] }}"
                                class="sb-occasion-card border-0
                                    {{ $occasion === $item['name']
                                        ? 'active'
                                        : ''
                                    }}"
                            >

                                <span class="sb-occasion-icon">

                                    {{ $item['icon'] }}

                                </span>


                                <span class="sb-occasion-content">

                                    <span class="sb-occasion-title d-block">

                                        {{ $item['name'] }}

                                    </span>

                                    <span class="sb-occasion-description d-block">

                                        {{ $item['description'] }}

                                    </span>

                                </span>


                                <span class="sb-occasion-arrow">

                                    <i class="fa-solid fa-chevron-right"></i>

                                </span>

                            </button>

                        @endforeach

                    </div>

                </form>

            </section>


            {{-- =================================================
                 RECOMMENDATIONS
            ================================================== --}}

            @if($occasion)

                <section class="sb-gift-results">

                    {{-- RESULT HEADER --}}

                    <div class="sb-gift-results-head">

                        <div>

                            <span class="sb-gift-results-label">

                                <i class="fa-solid fa-sparkles me-1"></i>

                                AI Gift Picks

                            </span>

                            <h2 class="sb-gift-results-title">

                                Gifts for {{ $occasion }}

                            </h2>

                            <p class="sb-gift-results-subtitle">

                                Hand-picked recommendations for
                                your selected occasion.

                            </p>

                        </div>


                        <span class="sb-gift-badge">

                            <i class="fa-solid fa-gift"></i>

                            {{ $occasion }}

                        </span>

                    </div>


                    {{-- PRODUCTS --}}

                    @if($products->isNotEmpty())

                        <div class="sb-gift-products">

                            <div class="ai-product-grid">

                                @foreach($products as $product)

                                    @include(
                                        'ai-hub.partials.product-card',
                                        ['product' => $product]
                                    )

                                @endforeach

                            </div>

                        </div>

                    @else

                        {{-- NO PRODUCTS --}}

                        <div class="sb-gift-empty">

                            <div class="sb-gift-empty-icon">

                                <i class="fa-solid fa-gift"></i>

                            </div>

                            <h3>
                                No Gift Picks Available
                            </h3>

                            <p>
                                We couldn't find gift recommendations
                                for {{ $occasion }} right now.
                                Please try another occasion.
                            </p>

                        </div>

                    @endif

                </section>

            @else

                {{-- =================================================
                     INITIAL STATE
                ================================================== --}}

                <section class="sb-gift-start">

                    <div class="sb-gift-start-icon">
                        🎁
                    </div>

                    <h3>
                        Find the Perfect Gift
                    </h3>

                    <p>
                        Choose Birthday, Anniversary or Festival
                        above and Smart Basket will show gift
                        recommendations tailored to that occasion.
                    </p>

                </section>

            @endif

        </div>

    </main>

</div>

@endsection
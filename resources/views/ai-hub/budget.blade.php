@extends('layouts.app')

@section('title', 'Budget Shopping')

@push('styles')

<style>
/* =========================================================
   SMART BASKET — PREMIUM AI BUDGET SHOPPING
   Theme aware: Light / Dark
   Works with global layouts.app theme system
========================================================= */

.sb-budget-page {
    --budget-primary: var(--sb-primary, #6366f1);
    --budget-primary-2: var(--sb-primary-2, #4f46e5);

    --budget-bg: var(--sb-bg, #f5f7fb);
    --budget-card: var(--sb-card, #ffffff);
    --budget-card-2: var(--sb-card-2, #f8fafc);

    --budget-text: var(--sb-text, #111827);
    --budget-muted: var(--sb-muted, #64748b);

    --budget-border: var(
        --sb-border,
        rgba(148, 163, 184, .20)
    );

    --budget-shadow:
        0 22px 60px rgba(15, 23, 42, .08);

    min-height: calc(100vh - 40px);
    padding: 30px 0 70px;

    color: var(--budget-text);
}


/* =========================================================
   MAIN CONTAINER
========================================================= */

.sb-budget-container {
    width: min(1500px, 100%);
    margin: 0 auto;
    padding: 0 22px;
}


/* =========================================================
   HERO
========================================================= */

.sb-budget-hero {
    position: relative;
    overflow: hidden;

    margin-bottom: 24px;
    padding: 34px;

    border: 1px solid var(--budget-border);
    border-radius: 28px;

    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(99, 102, 241, .18),
            transparent 32%
        ),
        radial-gradient(
            circle at 5% 95%,
            rgba(14, 165, 233, .12),
            transparent 34%
        ),
        var(--budget-card);

    box-shadow: var(--budget-shadow);
}


/* Decorative glow */

.sb-budget-hero::before {
    content: "";

    position: absolute;

    width: 260px;
    height: 260px;

    right: -120px;
    top: -130px;

    border-radius: 50%;

    background: rgba(99, 102, 241, .08);

    pointer-events: none;
}


.sb-budget-hero::after {
    content: "";

    position: absolute;

    width: 130px;
    height: 130px;

    left: 42%;
    bottom: -85px;

    border-radius: 50%;

    background: rgba(14, 165, 233, .06);

    pointer-events: none;
}


.sb-budget-eyebrow {
    position: relative;
    z-index: 1;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 7px 12px;

    border: 1px solid rgba(99, 102, 241, .15);
    border-radius: 999px;

    background: rgba(99, 102, 241, .09);

    color: var(--budget-primary);

    font-size: .68rem;
    font-weight: 900;

    letter-spacing: .13em;
    text-transform: uppercase;
}


.sb-budget-hero h1 {
    position: relative;
    z-index: 1;

    margin: 14px 0 8px;

    color: var(--budget-text);

    font-size: clamp(
        2rem,
        4vw,
        3rem
    );

    font-weight: 950;

    line-height: 1.05;
    letter-spacing: -.055em;
}


.sb-budget-hero p {
    position: relative;
    z-index: 1;

    max-width: 700px;

    margin: 0;

    color: var(--budget-muted);

    font-size: .95rem;
    line-height: 1.75;
}


/* =========================================================
   BUDGET SEARCH CARD
========================================================= */

.sb-budget-search {
    position: relative;

    margin-bottom: 24px;
    padding: 25px;

    border: 1px solid var(--budget-border);
    border-radius: 23px;

    background: var(--budget-card);

    box-shadow:
        0 15px 45px rgba(15, 23, 42, .06);
}


.sb-budget-label {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 9px;

    color: var(--budget-text);

    font-size: .76rem;
    font-weight: 850;

    letter-spacing: .06em;
    text-transform: uppercase;
}


.sb-budget-label i {
    color: var(--budget-primary);
}


.sb-budget-input-wrap {
    position: relative;
}


.sb-budget-currency {
    position: absolute;

    left: 16px;
    top: 50%;

    z-index: 2;

    transform: translateY(-50%);

    color: var(--budget-primary);

    font-size: 1rem;
    font-weight: 900;

    pointer-events: none;
}


.sb-budget-input {
    min-height: 54px;

    padding-left: 42px;
    padding-right: 15px;

    border: 1px solid var(--budget-border);
    border-radius: 14px;

    background: var(--budget-card-2) !important;
    color: var(--budget-text) !important;

    font-size: .95rem;
    font-weight: 650;

    box-shadow: none !important;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        transform .2s ease;
}


.sb-budget-input::placeholder {
    color: var(--budget-muted);
    opacity: .7;
}


.sb-budget-input:focus {
    border-color: var(--budget-primary) !important;

    box-shadow:
        0 0 0 4px rgba(99, 102, 241, .10) !important;

    transform: translateY(-1px);
}


/* =========================================================
   SEARCH BUTTON
========================================================= */

.sb-budget-submit {
    min-height: 54px;

    border: 0 !important;
    border-radius: 14px !important;

    background:
        linear-gradient(
            135deg,
            var(--budget-primary),
            var(--budget-primary-2)
        ) !important;

    color: #fff !important;

    font-size: .86rem;
    font-weight: 850;

    box-shadow:
        0 12px 28px rgba(79, 70, 229, .22);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        filter .2s ease;
}


.sb-budget-submit:hover {
    transform: translateY(-2px);

    box-shadow:
        0 17px 35px rgba(79, 70, 229, .30);

    filter: brightness(1.04);
}


.sb-budget-submit:active {
    transform: translateY(0);
}


/* =========================================================
   RESULTS PANEL
========================================================= */

.sb-budget-results {
    position: relative;
    overflow: hidden;

    border: 1px solid var(--budget-border);
    border-radius: 24px;

    background: var(--budget-card);

    box-shadow: var(--budget-shadow);
}


/* =========================================================
   RESULT HEADER
========================================================= */

.sb-budget-result-head {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 18px;

    padding: 25px 27px;

    border-bottom: 1px solid var(--budget-border);

    background:
        linear-gradient(
            135deg,
            rgba(99, 102, 241, .07),
            transparent 65%
        );
}


.sb-budget-result-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: var(--budget-primary);

    font-size: .68rem;
    font-weight: 900;

    letter-spacing: .12em;
    text-transform: uppercase;
}


.sb-budget-result-title {
    margin: 7px 0 3px;

    color: var(--budget-text);

    font-size: 1.2rem;
    font-weight: 900;
}


.sb-budget-result-description {
    margin: 0;

    color: var(--budget-muted);

    font-size: .82rem;
}


.sb-budget-amount {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    flex-shrink: 0;

    padding: 9px 13px;

    border: 1px solid rgba(99, 102, 241, .16);
    border-radius: 12px;

    background: rgba(99, 102, 241, .09);

    color: var(--budget-primary);

    font-size: .85rem;
    font-weight: 900;
}


/* =========================================================
   PRODUCT AREA
========================================================= */

.sb-budget-products {
    padding: 25px;
}


/*
   Existing AI HUB product card remains untouched.
   We only improve its surrounding environment.
*/

.sb-budget-products .ai-product-grid {
    gap: 20px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.sb-budget-empty {
    display: flex;

    align-items: center;
    justify-content: center;

    min-height: 300px;

    padding: 45px 25px;

    text-align: center;
}


.sb-budget-empty-inner {
    max-width: 480px;
}


.sb-budget-empty-icon {
    display: grid;
    place-items: center;

    width: 78px;
    height: 78px;

    margin: 0 auto 18px;

    border: 1px solid rgba(99, 102, 241, .15);
    border-radius: 24px;

    background: rgba(99, 102, 241, .09);

    color: var(--budget-primary);

    font-size: 1.8rem;

    box-shadow:
        0 12px 30px rgba(99, 102, 241, .08);
}


.sb-budget-empty h3 {
    margin: 0 0 7px;

    color: var(--budget-text);

    font-size: 1.15rem;
    font-weight: 900;
}


.sb-budget-empty p {
    margin: 0;

    color: var(--budget-muted);

    font-size: .85rem;
    line-height: 1.65;
}


/* =========================================================
   INITIAL STATE
========================================================= */

.sb-budget-start {
    margin-top: 24px;

    padding: 34px;

    border: 1px dashed var(--budget-border);
    border-radius: 22px;

    background:
        linear-gradient(
            135deg,
            rgba(99, 102, 241, .035),
            transparent
        );

    text-align: center;
}


.sb-budget-start-icon {
    display: grid;
    place-items: center;

    width: 58px;
    height: 58px;

    margin: 0 auto 13px;

    border-radius: 18px;

    background: rgba(99, 102, 241, .09);

    color: var(--budget-primary);

    font-size: 1.3rem;
}


.sb-budget-start h3 {
    margin: 0 0 6px;

    color: var(--budget-text);

    font-size: 1rem;
    font-weight: 850;
}


.sb-budget-start p {
    margin: 0;

    color: var(--budget-muted);

    font-size: .82rem;
}


/* =========================================================
   DARK THEME
   Supports existing data-theme system
========================================================= */

[data-theme="dark"] .sb-budget-page {

    --budget-bg: #0b1120;

    --budget-card: rgba(15, 23, 42, .88);

    --budget-card-2: rgba(30, 41, 59, .78);

    --budget-text: #f1f5f9;

    --budget-muted: #94a3b8;

    --budget-border:
        rgba(148, 163, 184, .16);

    --budget-shadow:
        0 25px 70px rgba(0, 0, 0, .28);
}


[data-theme="dark"] .sb-budget-hero {
    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(99, 102, 241, .20),
            transparent 34%
        ),
        radial-gradient(
            circle at 5% 95%,
            rgba(14, 165, 233, .10),
            transparent 34%
        ),
        rgba(15, 23, 42, .88);
}


[data-theme="dark"] .sb-budget-search,
[data-theme="dark"] .sb-budget-results {
    background: rgba(15, 23, 42, .88);
}


[data-theme="dark"] .sb-budget-result-head {
    background:
        linear-gradient(
            135deg,
            rgba(99, 102, 241, .12),
            transparent 70%
        );
}


[data-theme="dark"] .sb-budget-input {
    background: #0f172a !important;

    border-color:
        rgba(148, 163, 184, .22);

    color: #f8fafc !important;
}


[data-theme="dark"] .sb-budget-input:focus {
    border-color: #818cf8 !important;

    box-shadow:
        0 0 0 4px rgba(99, 102, 241, .15) !important;
}


[data-theme="dark"] .sb-budget-start {
    background:
        linear-gradient(
            135deg,
            rgba(99, 102, 241, .07),
            transparent
        );
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .sb-budget-page {
        padding: 20px 0 50px;
    }

    .sb-budget-container {
        padding: 0 15px;
    }

    .sb-budget-hero {
        padding: 25px 21px;
        border-radius: 21px;
    }

    .sb-budget-search {
        padding: 19px;
        border-radius: 19px;
    }

    .sb-budget-result-head {
        align-items: flex-start;
        flex-direction: column;

        padding: 21px;
    }

    .sb-budget-amount {
        width: 100%;
        justify-content: center;
    }

    .sb-budget-products {
        padding: 19px;
    }

}


@media (max-width: 480px) {

    .sb-budget-hero h1 {
        font-size: 2rem;
    }

    .sb-budget-hero p {
        font-size: .86rem;
    }

    .sb-budget-start {
        padding: 27px 18px;
    }

}
</style>

@endpush


@section('content')

<main class="sb-budget-page">

    <div class="sb-budget-container">


        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="sb-budget-hero">

            <span class="sb-budget-eyebrow">

                <i class="fa-solid fa-wallet"></i>

                AI Shopping Assistant

            </span>

            <h1>
                Budget Shopping
            </h1>

            <p>
                Tell Smart Basket how much you want to spend,
                and discover products that fit comfortably
                within your budget.
            </p>

        </section>


        {{-- =====================================================
             BUDGET SEARCH
        ====================================================== --}}

        <section class="sb-budget-search">

            <form
                method="GET"
                action="{{ route('budget-shopping') }}"
            >

                <div class="row g-3 align-items-end">


                    {{-- BUDGET INPUT --}}

                    <div class="col-12 col-lg-8">

                        <label
                            for="budget"
                            class="sb-budget-label"
                        >

                            <i class="fa-solid fa-indian-rupee-sign"></i>

                            Your Shopping Budget

                        </label>

                        <div class="sb-budget-input-wrap">

                            <span class="sb-budget-currency">
                                ₹
                            </span>

                            <input
                                id="budget"
                                type="number"
                                name="budget"
                                class="form-control sb-budget-input"
                                min="0"
                                step="0.01"
                                value="{{ $budget }}"
                                placeholder="Enter your maximum budget — e.g. 500"
                                required
                            >

                        </div>

                    </div>


                    {{-- BUTTON --}}

                    <div class="col-12 col-lg-4">

                        <button
                            type="submit"
                            class="btn sb-budget-submit w-100"
                        >

                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i>

                            Find Products

                        </button>

                    </div>

                </div>

            </form>

        </section>


        {{-- =====================================================
             RESULTS
        ====================================================== --}}

        @if($budget !== null && $budget !== '')

            <section class="sb-budget-results">


                {{-- RESULT HEADER --}}

                <div class="sb-budget-result-head">

                    <div>

                        <span class="sb-budget-result-label">

                            <i class="fa-solid fa-sparkles"></i>

                            Smart Results

                        </span>

                        @if($products->isNotEmpty())

                            <h2 class="sb-budget-result-title">

                                {{ $products->count() }}

                                Product{{ $products->count() !== 1 ? 's' : '' }}
                                Found

                            </h2>

                            <p class="sb-budget-result-description">

                                Showing products available within
                                your selected budget.

                            </p>

                        @else

                            <h2 class="sb-budget-result-title">

                                No Matching Products

                            </h2>

                            <p class="sb-budget-result-description">

                                Try increasing your budget to discover
                                more products.

                            </p>

                        @endif

                    </div>


                    {{-- BUDGET BADGE --}}

                    <div class="sb-budget-amount">

                        <i class="fa-solid fa-wallet"></i>

                        ₹{{ number_format((float) $budget, 2) }}

                    </div>

                </div>


                {{-- =================================================
                     PRODUCTS
                ================================================== --}}

                @if($products->isNotEmpty())

                    <div class="sb-budget-products">

                        <div class="ai-product-grid">

                            @foreach($products as $product)

                                @include(
                                    'ai-hub.partials.product-card',
                                    ['product' => $product]
                                )

                            @endforeach

                        </div>

                    </div>


                {{-- =================================================
                     EMPTY
                ================================================== --}}

                @else

                    <div class="sb-budget-empty">

                        <div class="sb-budget-empty-inner">

                            <div class="sb-budget-empty-icon">

                                <i class="fa-solid fa-wallet"></i>

                            </div>

                            <h3>
                                Nothing Fits This Budget Yet
                            </h3>

                            <p>
                                We couldn't find products matching
                                ₹{{ number_format((float) $budget, 2) }}.
                                Try a slightly higher budget and
                                explore more Smart Basket picks.
                            </p>

                        </div>

                    </div>

                @endif


            </section>


        @else


            {{-- =================================================
                 INITIAL STATE
            ================================================== --}}

            <section class="sb-budget-start">

                <div class="sb-budget-start-icon">

                    <i class="fa-solid fa-magnifying-glass-dollar"></i>

                </div>

                <h3>
                    What's Your Shopping Budget?
                </h3>

                <p>
                    Enter an amount above and Smart Basket
                    will find products that fit your budget.
                </p>

            </section>

        @endif


    </div>

</main>

@endsection
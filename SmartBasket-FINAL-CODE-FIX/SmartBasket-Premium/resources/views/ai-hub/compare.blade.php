@extends('layouts.app')

@section('title', 'Compare Products')

@push('styles')

<link
    rel="stylesheet"
    href="{{ asset('css/ai-hub-dashboard.css') }}"
>

<style>

/* =========================================================
   SMART BASKET — ULTIMATE PRODUCT COMPARISON
   PREMIUM • LIGHT/DARK • ACCENT AWARE • RESPONSIVE
========================================================= */

.sb-compare-page {

    --cmp-primary:
        var(--sb-primary,
        var(--accent-color,
        #6366f1));

    --cmp-primary-2:
        var(--sb-primary-2,
        #4f46e5);

    --cmp-primary-soft:
        color-mix(
            in srgb,
            var(--cmp-primary) 10%,
            transparent
        );

    --cmp-bg:
        var(--sb-bg,
        #f5f7fb);

    --cmp-card:
        var(--sb-card,
        #ffffff);

    --cmp-card-soft:
        var(--sb-card-2,
        #f8fafc);

    --cmp-text:
        var(--sb-text,
        #111827);

    --cmp-muted:
        var(--sb-muted,
        #64748b);

    --cmp-border:
        var(--sb-border,
        rgba(148,163,184,.18));

    --cmp-success:
        #16a34a;

    --cmp-warning:
        #f59e0b;

    --cmp-danger:
        #ef4444;

    --cmp-shadow:
        0 24px 70px rgba(15,23,42,.08);

    --cmp-radius:
        26px;

    position:
        relative;

    min-height:
        calc(100vh - 40px);

    padding:
        28px 0 80px;

    color:
        var(--cmp-text);

    overflow:
        hidden;

    isolation:
        isolate;

    transition:
        background .3s ease,
        color .3s ease;
}


/* =========================================================
   PREMIUM BACKGROUND
========================================================= */

.sb-compare-page::before {

    content:
        "";

    position:
        fixed;

    inset:
        0;

    z-index:
        -5;

    pointer-events:
        none;

    background:

        radial-gradient(
            circle at 8% 5%,
            color-mix(
                in srgb,
                var(--cmp-primary) 12%,
                transparent
            ),
            transparent 30%
        ),

        radial-gradient(
            circle at 92% 18%,
            rgba(14,165,233,.07),
            transparent 28%
        ),

        radial-gradient(
            circle at 50% 100%,
            color-mix(
                in srgb,
                var(--cmp-primary) 6%,
                transparent
            ),
            transparent 32%
        );
}


/* =========================================================
   HERO
========================================================= */

.sb-compare-hero {

    position:
        relative;

    overflow:
        hidden;

    margin-bottom:
        22px;

    padding:
        36px 38px;

    border:
        1px solid var(--cmp-border);

    border-radius:
        var(--cmp-radius);

    background:

        linear-gradient(
            135deg,
            color-mix(
                in srgb,
                var(--cmp-primary) 8%,
                var(--cmp-card)
            ),
            var(--cmp-card)
        );

    box-shadow:
        var(--cmp-shadow);

    isolation:
        isolate;
}

.sb-compare-hero::before {

    content:
        "";

    position:
        absolute;

    width:
        380px;

    height:
        380px;

    right:
        -170px;

    top:
        -220px;

    border-radius:
        50%;

    background:
        radial-gradient(
            circle,
            color-mix(
                in srgb,
                var(--cmp-primary) 23%,
                transparent
            ),
            transparent 70%
        );

    pointer-events:
        none;
}

.sb-compare-hero::after {

    content:
        "";

    position:
        absolute;

    width:
        190px;

    height:
        190px;

    left:
        -120px;

    bottom:
        -120px;

    border-radius:
        50%;

    background:
        radial-gradient(
            circle,
            rgba(14,165,233,.10),
            transparent 70%
        );

    pointer-events:
        none;
}


/* =========================================================
   HERO EYEBROW
========================================================= */

.sb-compare-eyebrow {

    position:
        relative;

    z-index:
        2;

    display:
        inline-flex;

    align-items:
        center;

    gap:
        8px;

    padding:
        8px 13px;

    border:
        1px solid
        color-mix(
            in srgb,
            var(--cmp-primary) 22%,
            transparent
        );

    border-radius:
        999px;

    background:
        var(--cmp-primary-soft);

    color:
        var(--cmp-primary);

    font-size:
        .66rem;

    font-weight:
        950;

    letter-spacing:
        .13em;

    text-transform:
        uppercase;
}

.sb-compare-eyebrow i {

    font-size:
        .75rem;
}


/* =========================================================
   HERO TITLE
========================================================= */

.sb-compare-hero h1 {

    position:
        relative;

    z-index:
        2;

    margin:
        15px 0 9px;

    color:
        var(--cmp-text);

    font-size:
        clamp(
            2rem,
            4vw,
            3.15rem
        );

    font-weight:
        950;

    line-height:
        1.02;

    letter-spacing:
        -.055em;
}

.sb-compare-hero p {

    position:
        relative;

    z-index:
        2;

    max-width:
        780px;

    margin:
        0;

    color:
        var(--cmp-muted);

    font-size:
        .94rem;

    line-height:
        1.75;
}


/* =========================================================
   SELECTOR
========================================================= */

.sb-compare-selector {

    position:
        relative;

    margin-bottom:
        24px;

    padding:
        25px;

    border:
        1px solid var(--cmp-border);

    border-radius:
        23px;

    background:
        color-mix(
            in srgb,
            var(--cmp-card) 95%,
            transparent
        );

    box-shadow:
        0 18px 55px rgba(15,23,42,.065);

    backdrop-filter:
        blur(20px);
}


/* =========================================================
   SELECT LABEL
========================================================= */

.sb-select-label {

    display:
        flex;

    align-items:
        center;

    gap:
        8px;

    margin-bottom:
        9px;

    color:
        var(--cmp-text);

    font-size:
        .7rem;

    font-weight:
        900;

    letter-spacing:
        .075em;

    text-transform:
        uppercase;
}

.sb-select-label i {

    color:
        var(--cmp-primary);
}


/* =========================================================
   SELECT WRAPPER
========================================================= */

.sb-select-wrap {

    position:
        relative;
}

.sb-select-wrap > i {

    position:
        absolute;

    left:
        16px;

    top:
        50%;

    z-index:
        4;

    transform:
        translateY(-50%);

    color:
        var(--cmp-primary);

    pointer-events:
        none;
}

.sb-select-wrap select {

    min-height:
        56px;

    padding:
        0 42px 0 45px;

    border:
        1px solid var(--cmp-border);

    border-radius:
        15px;

    background:
        var(--cmp-card-soft);

    color:
        var(--cmp-text);

    font-size:
        .86rem;

    font-weight:
        700;

    box-shadow:
        none;

    cursor:
        pointer;

    transition:
        all .22s ease;
}

.sb-select-wrap select:hover {

    border-color:
        color-mix(
            in srgb,
            var(--cmp-primary) 40%,
            transparent
        );

    transform:
        translateY(-1px);
}

.sb-select-wrap select:focus {

    border-color:
        var(--cmp-primary);

    background:
        var(--cmp-card-soft);

    color:
        var(--cmp-text);

    box-shadow:
        0 0 0 4px
        color-mix(
            in srgb,
            var(--cmp-primary) 12%,
            transparent
        );
}

.sb-select-wrap option {

    background:
        var(--cmp-card);

    color:
        var(--cmp-text);
}


/* =========================================================
   VS
========================================================= */

.sb-vs-wrap {

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    height:
        100%;

    padding-top:
        28px;
}

.sb-vs {

    display:
        grid;

    place-items:
        center;

    width:
        45px;

    height:
        45px;

    border-radius:
        50%;

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #334155
        );

    color:
        #fff;

    font-size:
        .67rem;

    font-weight:
        950;

    box-shadow:
        0 10px 25px
        rgba(15,23,42,.20);
}


/* =========================================================
   COMPARE BUTTON
========================================================= */

.sb-compare-btn {

    min-height:
        56px;

    border:
        0;

    border-radius:
        15px;

    background:
        linear-gradient(
            135deg,
            var(--cmp-primary),
            var(--cmp-primary-2)
        );

    color:
        #fff;

    font-weight:
        900;

    box-shadow:
        0 12px 30px
        color-mix(
            in srgb,
            var(--cmp-primary) 27%,
            transparent
        );

    transition:
        all .22s ease;
}

.sb-compare-btn:hover {

    color:
        #fff;

    transform:
        translateY(-3px);

    box-shadow:
        0 17px 38px
        color-mix(
            in srgb,
            var(--cmp-primary) 35%,
            transparent
        );
}


/* =========================================================
   RESULT
========================================================= */

.sb-result-panel {

    overflow:
        hidden;

    border:
        1px solid var(--cmp-border);

    border-radius:
        27px;

    background:
        var(--cmp-card);

    box-shadow:
        var(--cmp-shadow);

    animation:
        sbCompareReveal .45s ease both;
}

@keyframes sbCompareReveal {

    from {

        opacity:
            0;

        transform:
            translateY(15px);
    }

    to {

        opacity:
            1;

        transform:
            translateY(0);
    }
}


/* =========================================================
   RESULT HEADER
========================================================= */

.sb-result-head {

    padding:
        28px 30px;

    border-bottom:
        1px solid var(--cmp-border);

    background:
        linear-gradient(
            135deg,
            color-mix(
                in srgb,
                var(--cmp-primary) 8%,
                transparent
            ),
            transparent
        );
}

.sb-result-label {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        7px;

    color:
        var(--cmp-primary);

    font-size:
        .66rem;

    font-weight:
        950;

    letter-spacing:
        .12em;

    text-transform:
        uppercase;
}

.sb-result-title {

    margin:
        9px 0 5px;

    color:
        var(--cmp-text);

    font-size:
        clamp(
            1.05rem,
            2vw,
            1.42rem
        );

    font-weight:
        950;

    line-height:
        1.5;
}

.sb-result-subtitle {

    margin:
        0;

    color:
        var(--cmp-muted);

    font-size:
        .82rem;
}


/* =========================================================
   PRODUCT AREA
========================================================= */

.sb-compare-products {

    display:
        grid;

    grid-template-columns:
        minmax(0,1fr)
        76px
        minmax(0,1fr);

    gap:
        17px;

    align-items:
        stretch;

    padding:
        25px;
}


/* =========================================================
   PRODUCT CARD
========================================================= */

.sb-product-compare-card {

    position:
        relative;

    overflow:
        hidden;

    min-width:
        0;

    border:
        1px solid var(--cmp-border);

    border-radius:
        22px;

    background:
        var(--cmp-card-soft);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.sb-product-compare-card:hover {

    transform:
        translateY(-5px);

    border-color:
        color-mix(
            in srgb,
            var(--cmp-primary) 42%,
            transparent
        );

    box-shadow:
        0 22px 48px rgba(15,23,42,.11);
}


/* =========================================================
   PRODUCT IMAGE
========================================================= */

.sb-product-image-wrap {

    position:
        relative;

    display:
        grid;

    place-items:
        center;

    min-height:
        245px;

    padding:
        23px;

    border-bottom:
        1px solid var(--cmp-border);

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.80),
            rgba(248,250,252,.55)
        );
}

.sb-product-image-wrap::before {

    content:
        "";

    position:
        absolute;

    width:
        180px;

    height:
        180px;

    border-radius:
        50%;

    background:
        color-mix(
            in srgb,
            var(--cmp-primary) 7%,
            transparent
        );

    filter:
        blur(5px);
}

.sb-product-image-wrap::after {

    content:
        "SMART BASKET";

    position:
        absolute;

    top:
        13px;

    left:
        13px;

    padding:
        5px 8px;

    border-radius:
        7px;

    background:
        var(--cmp-primary-soft);

    color:
        var(--cmp-primary);

    font-size:
        .53rem;

    font-weight:
        950;

    letter-spacing:
        .08em;
}

.sb-product-image-wrap img {

    position:
        relative;

    z-index:
        2;

    width:
        100%;

    height:
        200px;

    object-fit:
        contain;

    filter:
        drop-shadow(
            0 15px 17px
            rgba(15,23,42,.12)
        );

    transition:
        transform .35s ease;
}

.sb-product-compare-card:hover
.sb-product-image-wrap img {

    transform:
        scale(1.055);
}


/* =========================================================
   PRODUCT INFO
========================================================= */

.sb-product-info {

    padding:
        20px;
}

.sb-product-info h3 {

    margin:
        0 0 7px;

    color:
        var(--cmp-text);

    font-size:
        1.03rem;

    font-weight:
        900;

    line-height:
        1.45;
}

.sb-product-category {

    margin:
        0 0 13px;

    color:
        var(--cmp-muted);

    font-size:
        .75rem;
}

.sb-product-price {

    color:
        var(--cmp-primary);

    font-size:
        1.25rem;

    font-weight:
        950;
}

.sb-product-rating {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        5px;

    margin-left:
        7px;

    padding:
        5px 9px;

    border:
        1px solid
        rgba(245,158,11,.20);

    border-radius:
        8px;

    background:
        rgba(245,158,11,.10);

    color:
        #d97706;

    font-size:
        .72rem;

    font-weight:
        900;
}


/* =========================================================
   WINNER BADGE
========================================================= */

.sb-winner-badge {

    position:
        absolute;

    top:
        14px;

    right:
        14px;

    z-index:
        5;

    display:
        inline-flex;

    align-items:
        center;

    gap:
        5px;

    padding:
        6px 9px;

    border:
        1px solid
        rgba(34,197,94,.20);

    border-radius:
        999px;

    background:
        rgba(34,197,94,.10);

    color:
        #15803d;

    font-size:
        .58rem;

    font-weight:
        950;

    text-transform:
        uppercase;

    letter-spacing:
        .04em;
}


/* =========================================================
   CENTER VS
========================================================= */

.sb-vs-column {

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;
}

.sb-vs-large {

    position:
        relative;

    display:
        grid;

    place-items:
        center;

    width:
        58px;

    height:
        58px;

    border-radius:
        50%;

    background:
        linear-gradient(
            135deg,
            var(--cmp-primary),
            var(--cmp-primary-2)
        );

    color:
        #fff;

    font-size:
        .72rem;

    font-weight:
        950;

    box-shadow:

        0 12px 30px
        color-mix(
            in srgb,
            var(--cmp-primary) 30%,
            transparent
        ),

        0 0 0 7px
        color-mix(
            in srgb,
            var(--cmp-primary) 9%,
            transparent
        );
}


/* =========================================================
   COMPARISON TABLE
========================================================= */

.sb-comparison-table-wrap {

    padding:
        0 25px 25px;
}

.sb-comparison-table {

    overflow:
        hidden;

    border:
        1px solid var(--cmp-border);

    border-radius:
        19px;

    background:
        var(--cmp-card);
}

.sb-comparison-table table {

    width:
        100%;

    margin:
        0;

    color:
        var(--cmp-text);
}

.sb-comparison-table th,
.sb-comparison-table td {

    min-width:
        180px;

    padding:
        17px 18px;

    vertical-align:
        middle;

    border-color:
        var(--cmp-border);

    background:
        transparent;

    color:
        var(--cmp-text);
}

.sb-comparison-table thead th {

    padding:
        16px 18px;

    background:
        color-mix(
            in srgb,
            var(--cmp-primary) 7%,
            transparent
        );

    color:
        var(--cmp-text);

    font-size:
        .76rem;

    font-weight:
        900;
}

.sb-comparison-table tbody tr {

    transition:
        background .2s ease;
}

.sb-comparison-table tbody tr:hover {

    background:
        color-mix(
            in srgb,
            var(--cmp-primary) 3%,
            transparent
        );
}

.sb-feature-cell {

    width:
        180px;

    background:
        rgba(148,163,184,.055) !important;

    color:
        var(--cmp-muted) !important;

    font-size:
        .7rem;

    font-weight:
        900;

    letter-spacing:
        .04em;

    text-transform:
        uppercase;
}

.sb-feature-cell i {

    color:
        var(--cmp-primary);
}

.sb-feature-value {

    color:
        var(--cmp-text);

    font-size:
        .85rem;

    line-height:
        1.65;
}

.sb-price-value {

    color:
        var(--cmp-primary);

    font-size:
        1.08rem;

    font-weight:
        950;
}

.sb-rating-value {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        5px;

    font-weight:
        900;
}

.sb-rating-star {

    color:
        #f59e0b;
}


/* =========================================================
   BEST VALUE
========================================================= */

.sb-best-value {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        5px;

    margin-left:
        8px;

    padding:
        4px 7px;

    border-radius:
        6px;

    background:
        rgba(34,197,94,.10);

    color:
        #15803d;

    font-size:
        .58rem;

    font-weight:
        900;

    text-transform:
        uppercase;
}


/* =========================================================
   ACTION BUTTON
========================================================= */

.sb-action-btn {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    border:
        0;

    border-radius:
        10px;

    background:
        linear-gradient(
            135deg,
            var(--cmp-primary),
            var(--cmp-primary-2)
        );

    color:
        #fff;

    font-weight:
        800;

    transition:
        all .2s ease;
}

.sb-action-btn:hover {

    color:
        #fff;

    transform:
        translateY(-2px);

    box-shadow:
        0 9px 20px
        color-mix(
            in srgb,
            var(--cmp-primary) 25%,
            transparent
        );
}


/* =========================================================
   EMPTY STATE
========================================================= */

.sb-compare-empty {

    padding:
        82px 25px;

    text-align:
        center;
}

.sb-compare-empty-icon {

    display:
        grid;

    place-items:
        center;

    width:
        88px;

    height:
        88px;

    margin:
        0 auto 21px;

    border:
        1px solid
        color-mix(
            in srgb,
            var(--cmp-primary) 16%,
            transparent
        );

    border-radius:
        27px;

    background:
        var(--cmp-primary-soft);

    color:
        var(--cmp-primary);

    font-size:
        2rem;

    box-shadow:
        0 13px 32px
        color-mix(
            in srgb,
            var(--cmp-primary) 10%,
            transparent
        );
}

.sb-compare-empty h3 {

    margin:
        0 0 8px;

    color:
        var(--cmp-text);

    font-weight:
        950;
}

.sb-compare-empty p {

    max-width:
        600px;

    margin:
        0 auto;

    color:
        var(--cmp-muted);

    line-height:
        1.7;

    font-size:
        .86rem;
}


/* =========================================================
   DARK THEME
========================================================= */

[data-theme="dark"] .sb-compare-page,
[data-sb-theme="dark"] .sb-compare-page {

    --cmp-bg:
        #020617;

    --cmp-card:
        #0f172a;

    --cmp-card-soft:
        #111c31;

    --cmp-text:
        #f8fafc;

    --cmp-muted:
        #94a3b8;

    --cmp-border:
        rgba(148,163,184,.16);

    --cmp-shadow:
        0 25px 75px rgba(0,0,0,.34);
}

[data-theme="dark"] .sb-product-image-wrap,
[data-sb-theme="dark"] .sb-product-image-wrap {

    background:
        linear-gradient(
            135deg,
            rgba(15,23,42,.95),
            rgba(30,41,59,.58)
        );
}

[data-theme="dark"] .sb-select-wrap select,
[data-sb-theme="dark"] .sb-select-wrap select {

    background:
        #0b1220;

    color:
        #f8fafc;
}

[data-theme="dark"] .sb-select-wrap option,
[data-sb-theme="dark"] .sb-select-wrap option {

    background:
        #0f172a;

    color:
        #f8fafc;
}

[data-theme="dark"] .sb-comparison-table,
[data-sb-theme="dark"] .sb-comparison-table {

    background:
        #0f172a;
}

[data-theme="dark"] .sb-comparison-table thead th,
[data-sb-theme="dark"] .sb-comparison-table thead th {

    background:
        rgba(99,102,241,.12);

    color:
        #f8fafc;
}

[data-theme="dark"] .sb-feature-cell,
[data-sb-theme="dark"] .sb-feature-cell {

    background:
        rgba(2,6,23,.48) !important;

    color:
        #94a3b8 !important;
}

[data-theme="dark"] .sb-comparison-table th,
[data-theme="dark"] .sb-comparison-table td,
[data-sb-theme="dark"] .sb-comparison-table th,
[data-sb-theme="dark"] .sb-comparison-table td {

    color:
        #e2e8f0;

    border-color:
        rgba(148,163,184,.14);
}

[data-theme="dark"] .sb-product-rating,
[data-sb-theme="dark"] .sb-product-rating {

    background:
        rgba(245,158,11,.13);

    color:
        #fbbf24;
}

[data-theme="dark"] .sb-winner-badge,
[data-sb-theme="dark"] .sb-winner-badge {

    background:
        rgba(34,197,94,.13);

    color:
        #4ade80;
}

[data-theme="dark"] .sb-best-value,
[data-sb-theme="dark"] .sb-best-value {

    background:
        rgba(34,197,94,.13);

    color:
        #4ade80;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991.98px) {

    .sb-vs-wrap {

        padding-top:
            0;
    }

    .sb-compare-products {

        grid-template-columns:
            1fr;
    }

    .sb-vs-column {

        height:
            50px;
    }

    .sb-vs-large {

        width:
            48px;

        height:
            48px;
    }
}


@media (max-width: 767.98px) {

    .sb-compare-page {

        padding:
            20px 0 55px;
    }

    .sb-compare-hero {

        padding:
            26px 21px;

        border-radius:
            21px;
    }

    .sb-compare-selector {

        padding:
            19px;

        border-radius:
            20px;
    }

    .sb-result-head {

        padding:
            22px 20px;
    }

    .sb-compare-products {

        padding:
            18px;
    }

    .sb-comparison-table-wrap {

        padding:
            0 18px 18px;
    }
}


@media (max-width: 575.98px) {

    .sb-compare-hero h1 {

        font-size:
            1.75rem;
    }

    .sb-compare-hero p {

        font-size:
            .83rem;
    }

    .sb-product-image-wrap {

        min-height:
            195px;
    }

    .sb-product-image-wrap img {

        height:
            155px;
    }

    .sb-product-info {

        padding:
            17px;
    }

    .sb-comparison-table th,
    .sb-comparison-table td {

        min-width:
            165px;

        padding:
            13px 12px;

        font-size:
            .77rem;
    }

    .sb-feature-cell {

        min-width:
            145px !important;
    }

    .sb-result-title {

        line-height:
            1.5;
    }
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .sb-result-panel,
    .sb-product-compare-card,
    .sb-product-image-wrap img,
    .sb-compare-btn,
    .sb-action-btn,
    .sb-select-wrap select {

        animation:
            none !important;

        transition:
            none !important;
    }
}

</style>

@endpush


@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Comparison Helpers
    |--------------------------------------------------------------------------
    */

    $firstPrice =
        $firstProduct
            ? (float) $firstProduct->price
            : null;

    $secondPrice =
        $secondProduct
            ? (float) $secondProduct->price
            : null;

    $firstRating =
        $firstProduct
            ? (float) ($firstProduct->rating ?? 0)
            : null;

    $secondRating =
        $secondProduct
            ? (float) ($secondProduct->rating ?? 0)
            : null;

    $cheaperProduct = null;

    $higherRatedProduct = null;

    if (
        $firstProduct &&
        $secondProduct &&
        $firstPrice !== $secondPrice
    ) {

        $cheaperProduct =
            $firstPrice < $secondPrice
                ? 'first'
                : 'second';

    }

    if (
        $firstProduct &&
        $secondProduct &&
        $firstRating !== $secondRating
    ) {

        $higherRatedProduct =
            $firstRating > $secondRating
                ? 'first'
                : 'second';

    }

@endphp


<div class="sb-compare-page">

    <div class="container-fluid px-3 px-lg-4">


        {{-- =================================================
             PREMIUM HERO
        ================================================== --}}

        <section class="sb-compare-hero">

            <span class="sb-compare-eyebrow">

                <i class="fa-solid fa-scale-balanced"></i>

                Smart Comparison

            </span>

            <h1>
                Compare Products
            </h1>

            <p>
                Put two Smart Basket products side-by-side and
                compare their price, rating, category, brand and
                features before making your purchase decision.
            </p>

        </section>


        {{-- =================================================
             PRODUCT SELECTOR
        ================================================== --}}

        <section class="sb-compare-selector">

            <form
                method="GET"
                action="{{ route('compare-products') }}"
            >

                <div class="row g-3 align-items-end">


                    {{-- FIRST PRODUCT --}}

                    <div class="col-12 col-lg-5">

                        <label
                            for="product_one"
                            class="sb-select-label"
                        >

                            <i class="fa-solid fa-box"></i>

                            First Product

                        </label>

                        <div class="sb-select-wrap">

                            <i class="fa-solid fa-cube"></i>

                            <select
                                id="product_one"
                                name="product_one"
                                class="form-select"
                            >

                                <option value="">
                                    Select first product
                                </option>

                                @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ optional($firstProduct)->id === $product->id ? 'selected' : '' }}
                                    >

                                        {{ $product->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- VS --}}

                    <div class="col-12 col-lg-1">

                        <div class="sb-vs-wrap">

                            <span class="sb-vs">
                                VS
                            </span>

                        </div>

                    </div>


                    {{-- SECOND PRODUCT --}}

                    <div class="col-12 col-lg-5">

                        <label
                            for="product_two"
                            class="sb-select-label"
                        >

                            <i class="fa-solid fa-box-open"></i>

                            Second Product

                        </label>

                        <div class="sb-select-wrap">

                            <i class="fa-solid fa-cube"></i>

                            <select
                                id="product_two"
                                name="product_two"
                                class="form-select"
                            >

                                <option value="">
                                    Select second product
                                </option>

                                @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ optional($secondProduct)->id === $product->id ? 'selected' : '' }}
                                    >

                                        {{ $product->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- COMPARE --}}

                    <div class="col-12 col-lg-1">

                        <button
                            type="submit"
                            class="btn sb-compare-btn w-100"
                            title="Compare selected products"
                        >

                            <i class="fa-solid fa-scale-balanced"></i>

                            <span class="d-lg-none ms-2">
                                Compare Products
                            </span>

                        </button>

                    </div>

                </div>

            </form>

        </section>


        {{-- =================================================
             RESULT
        ================================================== --}}

        @if($firstProduct && $secondProduct)

            <section class="sb-result-panel">


                {{-- RESULT HEADER --}}

                <div class="sb-result-head">

                    <span class="sb-result-label">

                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                        Smart Comparison Result

                    </span>

                    <h2 class="sb-result-title">

                        {{ $firstProduct->name }}

                        <span class="mx-2 text-muted">
                            VS
                        </span>

                        {{ $secondProduct->name }}

                    </h2>

                    <p class="sb-result-subtitle">

                        Detailed side-by-side analysis for
                        a smarter shopping decision.

                    </p>

                </div>


                {{-- =================================================
                     PRODUCT CARDS
                ================================================== --}}

                <div class="sb-compare-products">


                    {{-- PRODUCT ONE --}}

                    <article class="sb-product-compare-card">

                        @if($cheaperProduct === 'first')

                            <span class="sb-winner-badge">

                                <i class="fa-solid fa-tag"></i>

                                Better Price

                            </span>

                        @elseif($higherRatedProduct === 'first')

                            <span class="sb-winner-badge">

                                <i class="fa-solid fa-star"></i>

                                Higher Rated

                            </span>

                        @endif


                        <div class="sb-product-image-wrap">

                            @if(!empty($firstProduct->image))

                                <img
                                    src="{{ asset(
                                        'products/' . $firstProduct->image
                                    ) }}"
                                    alt="{{ $firstProduct->name }}"
                                    loading="lazy"
                                >

                            @else

                                <i
                                    class="fa-solid fa-image fa-3x text-muted"
                                ></i>

                            @endif

                        </div>


                        <div class="sb-product-info">

                            <h3>
                                {{ $firstProduct->name }}
                            </h3>

                            <p class="sb-product-category">

                                <i class="fa-solid fa-layer-group me-1"></i>

                                {{ $firstProduct->category ?: 'Smart Basket Product' }}

                            </p>

                            <span class="sb-product-price">

                                ₹{{ number_format(
                                    $firstPrice,
                                    2
                                ) }}

                            </span>

                            <span class="sb-product-rating">

                                <i class="fa-solid fa-star"></i>

                                {{ number_format(
                                    $firstRating,
                                    1
                                ) }}

                            </span>

                        </div>

                    </article>


                    {{-- VS --}}

                    <div class="sb-vs-column">

                        <span class="sb-vs-large">
                            VS
                        </span>

                    </div>


                    {{-- PRODUCT TWO --}}

                    <article class="sb-product-compare-card">

                        @if($cheaperProduct === 'second')

                            <span class="sb-winner-badge">

                                <i class="fa-solid fa-tag"></i>

                                Better Price

                            </span>

                        @elseif($higherRatedProduct === 'second')

                            <span class="sb-winner-badge">

                                <i class="fa-solid fa-star"></i>

                                Higher Rated

                            </span>

                        @endif


                        <div class="sb-product-image-wrap">

                            @if(!empty($secondProduct->image))

                                <img
                                    src="{{ asset(
                                        'products/' . $secondProduct->image
                                    ) }}"
                                    alt="{{ $secondProduct->name }}"
                                    loading="lazy"
                                >

                            @else

                                <i
                                    class="fa-solid fa-image fa-3x text-muted"
                                ></i>

                            @endif

                        </div>


                        <div class="sb-product-info">

                            <h3>
                                {{ $secondProduct->name }}
                            </h3>

                            <p class="sb-product-category">

                                <i class="fa-solid fa-layer-group me-1"></i>

                                {{ $secondProduct->category ?: 'Smart Basket Product' }}

                            </p>

                            <span class="sb-product-price">

                                ₹{{ number_format(
                                    $secondPrice,
                                    2
                                ) }}

                            </span>

                            <span class="sb-product-rating">

                                <i class="fa-solid fa-star"></i>

                                {{ number_format(
                                    $secondRating,
                                    1
                                ) }}

                            </span>

                        </div>

                    </article>

                </div>


                {{-- =================================================
                     COMPARISON TABLE
                ================================================== --}}

                <div class="sb-comparison-table-wrap">

                    <div class="sb-comparison-table table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th class="sb-feature-cell">
                                        Feature
                                    </th>

                                    <th>
                                        {{ $firstProduct->name }}
                                    </th>

                                    <th>
                                        {{ $secondProduct->name }}
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                {{-- PRICE --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-indian-rupee-sign me-1"></i>

                                        Price

                                    </th>

                                    <td class="sb-feature-value">

                                        <span class="sb-price-value">

                                            ₹{{ number_format(
                                                $firstPrice,
                                                2
                                            ) }}

                                        </span>

                                        @if($cheaperProduct === 'first')

                                            <span class="sb-best-value">

                                                <i class="fa-solid fa-check"></i>

                                                Better Price

                                            </span>

                                        @endif

                                    </td>

                                    <td class="sb-feature-value">

                                        <span class="sb-price-value">

                                            ₹{{ number_format(
                                                $secondPrice,
                                                2
                                            ) }}

                                        </span>

                                        @if($cheaperProduct === 'second')

                                            <span class="sb-best-value">

                                                <i class="fa-solid fa-check"></i>

                                                Better Price

                                            </span>

                                        @endif

                                    </td>

                                </tr>


                                {{-- RATING --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-star me-1"></i>

                                        Rating

                                    </th>

                                    <td class="sb-feature-value">

                                        <span class="sb-rating-value">

                                            <span class="sb-rating-star">
                                                ★
                                            </span>

                                            {{ number_format(
                                                $firstRating,
                                                1
                                            ) }}

                                        </span>

                                        @if($higherRatedProduct === 'first')

                                            <span class="sb-best-value">

                                                <i class="fa-solid fa-trophy"></i>

                                                Higher Rated

                                            </span>

                                        @endif

                                    </td>

                                    <td class="sb-feature-value">

                                        <span class="sb-rating-value">

                                            <span class="sb-rating-star">
                                                ★
                                            </span>

                                            {{ number_format(
                                                $secondRating,
                                                1
                                            ) }}

                                        </span>

                                        @if($higherRatedProduct === 'second')

                                            <span class="sb-best-value">

                                                <i class="fa-solid fa-trophy"></i>

                                                Higher Rated

                                            </span>

                                        @endif

                                    </td>

                                </tr>


                                {{-- CATEGORY --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-layer-group me-1"></i>

                                        Category

                                    </th>

                                    <td class="sb-feature-value">

                                        {{ $firstProduct->category ?: '—' }}

                                    </td>

                                    <td class="sb-feature-value">

                                        {{ $secondProduct->category ?: '—' }}

                                    </td>

                                </tr>


                                {{-- BRAND --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-tag me-1"></i>

                                        Brand

                                    </th>

                                    <td class="sb-feature-value">

                                        {{ $firstProduct->brand ?: '—' }}

                                    </td>

                                    <td class="sb-feature-value">

                                        {{ $secondProduct->brand ?: '—' }}

                                    </td>

                                </tr>


                                {{-- DESCRIPTION / FEATURES --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-list-check me-1"></i>

                                        Features

                                    </th>

                                    <td class="sb-feature-value">

                                        {{ $firstProduct->description ?: 'No description available.' }}

                                    </td>

                                    <td class="sb-feature-value">

                                        {{ $secondProduct->description ?: 'No description available.' }}

                                    </td>

                                </tr>


                                {{-- ACTIONS --}}

                                <tr>

                                    <th class="sb-feature-cell">

                                        <i class="fa-solid fa-bolt me-1"></i>

                                        Actions

                                    </th>

                                    <td>

                                        @if(Route::has('products.show'))

                                            <a
                                                href="{{ route(
                                                    'products.show',
                                                    $firstProduct->id
                                                ) }}"
                                                class="btn btn-sm sb-action-btn"
                                            >

                                                <i class="fa-solid fa-eye me-1"></i>

                                                View Product

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        @if(Route::has('products.show'))

                                            <a
                                                href="{{ route(
                                                    'products.show',
                                                    $secondProduct->id
                                                ) }}"
                                                class="btn btn-sm sb-action-btn"
                                            >

                                                <i class="fa-solid fa-eye me-1"></i>

                                                View Product

                                            </a>

                                        @endif

                                    </td>

                                </tr>


                            </tbody>

                        </table>

                    </div>

                </div>

            </section>


        @else


            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <section class="sb-result-panel">

                <div class="sb-compare-empty">

                    <div class="sb-compare-empty-icon">

                        <i class="fa-solid fa-scale-balanced"></i>

                    </div>

                    <h3>
                        Ready to Compare?
                    </h3>

                    <p>

                        Select two different products above.
                        Smart Basket will compare their price,
                        rating, category, brand and features
                        in a premium side-by-side view.

                    </p>

                </div>

            </section>

        @endif


    </div>

</div>

@endsection
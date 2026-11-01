@extends('layouts.app')

@section('title', 'Budget Shopping | SMART BASKET')

@push('styles')
<style>
/* =========================================================
   SMART BASKET — PREMIUM ANIMATED BUDGET SHOPPING
   Existing customer Taskbar component is the single source.
   No extra Taskbar or duplicate navigation is created here.
========================================================= */

.sb-budget-page {
    --budget-primary: var(--sb-primary, var(--sb-primary-color, #2563eb));
    --budget-primary-2: var(--sb-primary-2, var(--sb-primary-color, #7c3aed));
    --budget-bg: var(--sb-bg, var(--sb-bg-primary, #f4f7fb));
    --budget-card: var(--sb-card, var(--sb-card-bg, #ffffff));
    --budget-card-2: var(--sb-card-2, var(--sb-bg-secondary, #f8fafc));
    --budget-text: var(--sb-text, var(--sb-text-primary, #0f172a));
    --budget-muted: var(--sb-muted, var(--sb-text-secondary, #64748b));
    --budget-border: var(--sb-border, var(--sb-border-color, rgba(148,163,184,.20)));
    --budget-success: #16a34a;
    --budget-shadow: 0 24px 70px rgba(15,23,42,.09);

    position: relative;
    isolation: isolate;
    min-height: 100vh;
    padding: 30px 0 75px;
    overflow: clip;
    color: var(--budget-text);

    background:
        radial-gradient(
            circle at 4% 3%,
            rgba(37,99,235,.075),
            transparent 27%
        ),
        radial-gradient(
            circle at 96% 14%,
            rgba(124,58,237,.07),
            transparent 28%
        ),
        var(--budget-bg, transparent);

    transition: background .3s ease, color .3s ease;
}

.sb-budget-page *,
.sb-budget-page *::before,
.sb-budget-page *::after {
    box-sizing: border-box;
}

.sb-budget-container {
    position: relative;
    z-index: 1;
    width: min(1540px, 100%);
    margin: 0 auto;
    padding: 0 25px;
}

/* =========================================================
   HERO — ANIMATED PREMIUM DESIGN
========================================================= */

.sb-budget-hero {
    position: relative;
    isolation: isolate;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;

    min-height: 350px;
    margin-bottom: 26px;
    padding: clamp(30px, 4.5vw, 58px);

    border: 1px solid var(--budget-border);
    border-radius: 30px;

    background:
        radial-gradient(
            ellipse at 85% 12%,
            rgba(99,102,241,.18),
            transparent 34%
        ),
        radial-gradient(
            ellipse at 0% 100%,
            rgba(14,165,233,.12),
            transparent 38%
        ),
        var(--budget-card);

    box-shadow: var(--budget-shadow);

    animation: sbBudgetHeroEntrance .75s cubic-bezier(.2,.7,.2,1) both;
}

/* Animated gradient border */
.sb-budget-hero-border {
    position: absolute;
    z-index: -1;
    inset: 0;
    overflow: hidden;
    border-radius: inherit;
    pointer-events: none;
}

.sb-budget-hero-border::before {
    content: "";
    position: absolute;
    inset: -150%;
    background: conic-gradient(
        from 0deg,
        transparent 0deg,
        transparent 245deg,
        rgba(59,130,246,.35) 280deg,
        rgba(139,92,246,.48) 310deg,
        rgba(6,182,212,.30) 335deg,
        transparent 360deg
    );
    animation: sbBudgetBorderSpin 12s linear infinite;
}

.sb-budget-hero-border::after {
    content: "";
    position: absolute;
    inset: 1px;
    border-radius: inherit;
    background: var(--budget-card);
    z-index: 0;
    opacity: .08;
    pointer-events: none;
}

.sb-budget-hero-glow {
    position: absolute;
    z-index: -1;
    width: 270px;
    height: 270px;
    right: 5%;
    top: 2%;
    border-radius: 50%;
    background: rgba(99,102,241,.10);
    filter: blur(45px);
    animation: sbBudgetGlow 7s ease-in-out infinite alternate;
    pointer-events: none;
}

.sb-budget-orbit {
    position: absolute;
    z-index: -1;
    width: 250px;
    height: 250px;
    right: 5%;
    top: -145px;
    border: 1px solid rgba(99,102,241,.16);
    border-radius: 50%;
    box-shadow:
        0 0 0 24px rgba(99,102,241,.025),
        0 0 0 49px rgba(99,102,241,.02);
    animation: sbBudgetOrbit 18s ease-in-out infinite alternate;
    pointer-events: none;
}

.sb-budget-hero-content {
    position: relative;
    z-index: 2;
    flex: 1 1 auto;
    min-width: 0;
}

.sb-budget-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;

    padding: 9px 15px;

    border: 1px solid rgba(99,102,241,.22);
    border-radius: 999px;

    background: rgba(99,102,241,.09);
    color: var(--budget-primary);

    font-size: .70rem;
    font-weight: 950;
    letter-spacing: .12em;
    text-transform: uppercase;

    animation: sbBudgetFadeUp .65s .10s both;
}

.sb-budget-eyebrow i {
    font-size: .9rem;
}

.sb-budget-hero h1 {
    margin: 21px 0 14px;

    color: var(--budget-text);

    font-size: clamp(2.3rem, 4.7vw, 4rem);
    font-weight: 950;
    letter-spacing: -.07em;
    line-height: 1.04;

    animation: sbBudgetFadeUp .7s .18s both;
}

.sb-budget-hero h1 span {
    display: block;
    margin-top: 5px;

    color: var(--budget-primary);

    background: linear-gradient(
        100deg,
        var(--budget-primary),
        var(--budget-primary-2),
        #0891b2,
        var(--budget-primary)
    );

    background-size: 250% auto;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    animation: sbBudgetGradientText 7s linear infinite;
}

.sb-budget-hero-description {
    max-width: 700px;
    margin: 0;

    color: var(--budget-muted);

    font-size: .96rem;
    line-height: 1.9;

    animation: sbBudgetFadeUp .7s .27s both;
}

.sb-budget-hero-points {
    display: flex;
    flex-wrap: wrap;
    gap: 12px 20px;
    margin-top: 24px;

    animation: sbBudgetFadeUp .7s .35s both;
}

.sb-budget-hero-point {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    color: var(--budget-muted);

    font-size: .78rem;
    font-weight: 800;
}

.sb-budget-hero-point i {
    color: var(--budget-success);
}

/* Animated shopping illustration */
.sb-budget-hero-visual {
    position: relative;
    z-index: 2;

    flex: 0 0 210px;

    display: grid;
    place-items: center;

    width: 210px;
    height: 210px;

    margin: 0 15px 0 0;

    border: 1px solid rgba(99,102,241,.22);
    border-radius: 43px;

    background:
        linear-gradient(
            145deg,
            rgba(99,102,241,.15),
            rgba(14,165,233,.08)
        );

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.16),
        0 25px 65px rgba(99,102,241,.10);

    transform: rotate(3deg);
    animation: sbBudgetFloat 5s ease-in-out infinite;
}

.sb-budget-hero-visual::before {
    content: "";
    position: absolute;
    inset: 12px;
    border: 1px solid rgba(99,102,241,.21);
    border-radius: 32px;
    pointer-events: none;
}

.sb-budget-hero-visual::after {
    content: "";
    position: absolute;
    inset: -13px;
    border: 1px dashed rgba(99,102,241,.20);
    border-radius: 50px;
    animation: sbBudgetRingPulse 4s ease-in-out infinite;
    pointer-events: none;
}

.sb-budget-hero-visual-main-icon {
    color: var(--budget-primary);
    font-size: 76px;
    filter: drop-shadow(0 13px 20px rgba(99,102,241,.22));
    animation: sbBudgetIconFloat 3s ease-in-out infinite;
}

.sb-budget-floating-icon {
    position: absolute;
    z-index: 3;

    display: grid;
    place-items: center;

    width: 44px;
    height: 44px;

    border: 1px solid var(--budget-border);
    border-radius: 14px;

    background: var(--budget-card);
    color: var(--budget-primary);

    box-shadow: 0 12px 28px rgba(15,23,42,.10);

    animation: sbBudgetSmallFloat 4s ease-in-out infinite;
}

.sb-budget-floating-icon-one {
    top: -15px;
    left: -22px;
    font-size: 17px;
}

.sb-budget-floating-icon-two {
    right: -18px;
    top: 35px;
    color: #16a34a;
    font-size: 16px;
    animation-delay: -1.4s;
}

.sb-budget-floating-icon-three {
    left: -20px;
    bottom: 13px;
    color: #f59e0b;
    font-size: 16px;
    animation-delay: -2.1s;
}

.sb-budget-hero-visual-badge {
    position: absolute;
    right: -25px;
    bottom: 7px;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 11px 14px;

    border: 1px solid var(--budget-border);
    border-radius: 14px;

    background: var(--budget-card);
    color: var(--budget-text);

    font-size: .76rem;
    font-weight: 950;

    box-shadow: 0 12px 30px rgba(15,23,42,.13);

    transform: rotate(-3deg);
}

/* =========================================================
   SECTION SHARED
========================================================= */

.sb-budget-section-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    color: var(--budget-primary);

    font-size: .69rem;
    font-weight: 950;
    letter-spacing: .12em;
    text-transform: uppercase;
}

/* =========================================================
   BUDGET SEARCH
========================================================= */

.sb-budget-search {
    position: relative;
    overflow: hidden;

    margin-bottom: 26px;
    padding: clamp(21px, 3vw, 32px);

    border: 1px solid var(--budget-border);
    border-radius: 25px;

    background: var(--budget-card);

    box-shadow: 0 15px 45px rgba(15,23,42,.055);

    animation: sbBudgetFadeUp .65s .22s both;
}

.sb-budget-search::before {
    content: "";
    position: absolute;
    width: 150px;
    height: 150px;
    right: -75px;
    top: -85px;
    border-radius: 50%;
    background: rgba(99,102,241,.055);
    pointer-events: none;
}

.sb-budget-search-heading {
    position: relative;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}

.sb-budget-search-icon {
    display: grid;
    place-items: center;
    flex: 0 0 49px;

    width: 49px;
    height: 49px;

    border-radius: 16px;

    background: linear-gradient(
        135deg,
        var(--budget-primary),
        var(--budget-primary-2)
    );

    color: #fff;
    font-size: 19px;

    box-shadow: 0 10px 25px rgba(37,99,235,.20);
}

.sb-budget-search-heading h2 {
    margin: 0 0 5px;
    color: var(--budget-text);
    font-size: 1.06rem;
    font-weight: 950;
}

.sb-budget-search-heading p {
    margin: 0;
    color: var(--budget-muted);
    font-size: .80rem;
    line-height: 1.6;
}

.sb-budget-label {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 10px;

    color: var(--budget-text);

    font-size: .74rem;
    font-weight: 950;
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
    z-index: 2;
    top: 50%;
    left: 17px;
    transform: translateY(-50%);

    color: var(--budget-primary);
    font-size: 1.08rem;
    font-weight: 950;

    pointer-events: none;
}

.sb-budget-input {
    width: 100%;
    min-height: 58px;
    padding: 13px 16px 13px 45px;

    border: 1px solid var(--budget-border);
    border-radius: 15px;

    background: var(--budget-card-2) !important;
    color: var(--budget-text) !important;

    font-size: .95rem;
    font-weight: 700;

    box-shadow: none !important;

    transition: border-color .2s ease, box-shadow .2s ease;
}

.sb-budget-input::placeholder {
    color: var(--budget-muted);
    opacity: .72;
}

.sb-budget-input:focus {
    border-color: var(--budget-primary) !important;
    box-shadow: 0 0 0 4px rgba(99,102,241,.12) !important;
}

.sb-budget-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    width: 100%;
    min-height: 58px;
    padding: 12px 20px;

    border: 0 !important;
    border-radius: 15px !important;

    background: linear-gradient(
        120deg,
        var(--budget-primary),
        var(--budget-primary-2)
    ) !important;

    color: #fff !important;

    font-size: .90rem;
    font-weight: 950;

    box-shadow: 0 12px 27px rgba(79,70,229,.23);

    transition: transform .2s ease, box-shadow .2s ease;
}

.sb-budget-submit:hover {
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 17px 35px rgba(79,70,229,.30);
}

.sb-budget-submit:active {
    transform: translateY(0);
}

/* =========================================================
   RESULTS PANEL
========================================================= */

.sb-budget-results {
    overflow: hidden;

    border: 1px solid var(--budget-border);
    border-radius: 26px;

    background: var(--budget-card);
    box-shadow: var(--budget-shadow);

    animation: sbBudgetFadeUp .6s both;
}

.sb-budget-result-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding: 27px 29px;

    border-bottom: 1px solid var(--budget-border);

    background: linear-gradient(
        120deg,
        rgba(99,102,241,.085),
        transparent 72%
    );
}

.sb-budget-result-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    color: var(--budget-primary);

    font-size: .69rem;
    font-weight: 950;
    letter-spacing: .13em;
    text-transform: uppercase;
}

.sb-budget-result-title {
    margin: 9px 0 5px;

    color: var(--budget-text);

    font-size: clamp(1.1rem, 2vw, 1.45rem);
    font-weight: 950;
    letter-spacing: -.035em;
}

.sb-budget-result-description {
    margin: 0;
    color: var(--budget-muted);
    font-size: .83rem;
    line-height: 1.7;
}

.sb-budget-amount {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    flex-shrink: 0;

    padding: 12px 16px;

    border: 1px solid rgba(99,102,241,.19);
    border-radius: 15px;

    background: rgba(99,102,241,.09);
    color: var(--budget-primary);

    font-size: .93rem;
    font-weight: 950;
}

/* =========================================================
   PRODUCT CARDS — CONSISTENT GRID
   The existing product-card partial and its functionality
   remain intact. Styles are scoped to Budget Shopping.
========================================================= */

.sb-budget-products {
    padding: 27px;
}

/* The shared layout does not load Bootstrap CSS, so keep this page's
   search columns responsive without depending on Bootstrap utilities. */
.sb-budget-search .row {
    display: grid;
    grid-template-columns: minmax(0, 2fr) minmax(220px, 1fr);
    gap: 16px;
    margin: 0;
}

.sb-budget-search .row > [class*="col-"] {
    width: 100%;
    min-width: 0;
    padding: 0;
}

.sb-budget-products .ai-product-grid {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    grid-auto-rows: 1fr;
    align-items: stretch !important;
    gap: 22px !important;
}

.sb-budget-products .ai-product-grid > * {
    display: flex !important;
    flex-direction: column !important;
    align-self: stretch !important;

    width: 100% !important;
    min-width: 0 !important;
    min-height: 100% !important;
    height: 100% !important;
    margin: 0 !important;

    box-sizing: border-box !important;
}

.sb-budget-products .ai-product-grid .ai-product-card,
.sb-budget-products .ai-product-grid .product-card,
.sb-budget-products .ai-product-grid .product-item,
.sb-budget-products .ai-product-grid .card {
    display: flex !important;
    flex-direction: column !important;

    width: 100% !important;
    min-width: 0 !important;
    height: 100% !important;
    min-height: 100% !important;
    margin: 0 !important;

    overflow: hidden;
    border-radius: 19px;
    box-sizing: border-box !important;
}

/* Match the real structure in ai-hub.partials.product-card. */
.sb-budget-products .ai-product-grid .ai-product-card {
    border: 1px solid var(--budget-border);
    background: var(--budget-card);
    color: var(--budget-text);
    box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}

.sb-budget-products .ai-product-grid .ai-product-card:hover {
    transform: translateY(-4px);
    border-color: rgba(99, 102, 241, .38);
    box-shadow: 0 18px 38px rgba(15, 23, 42, .12);
}

.sb-budget-products .ai-product-grid .ai-product-card > img {
    padding: 14px;
    background: var(--budget-card-2);
}

.sb-budget-products .ai-product-grid .ai-product-card .ai-product-card-body {
    padding: 18px;
}

.sb-budget-products .ai-product-grid .ai-product-card h3 {
    min-height: 2.8em;
    margin: 0 0 9px;
    color: var(--budget-text);
    font-size: 1rem;
    font-weight: 850;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.sb-budget-products .ai-product-grid .ai-product-card p {
    min-height: 2.8em;
    margin: 0 0 16px;
    color: var(--budget-muted);
    font-size: .8rem;
    line-height: 1.55;
    overflow-wrap: anywhere;
}

.sb-budget-products .ai-product-grid .ai-product-card .text-warning {
    color: #d97706 !important;
}

.sb-budget-products .ai-product-grid .ai-product-card .d-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: auto;
}

.sb-budget-products .ai-product-grid .ai-product-card .ai-price {
    color: var(--budget-primary);
    font-size: 1rem;
    font-weight: 950;
    overflow-wrap: anywhere;
}

.sb-budget-products .ai-product-grid .ai-product-card a.btn {
    flex: 0 0 auto;
    padding: 7px 12px;
    border: 1px solid var(--budget-primary);
    border-radius: 10px;
    color: var(--budget-primary);
    font-size: .78rem;
    font-weight: 850;
    line-height: 1.2;
    text-decoration: none;
    transition: color .2s ease, background .2s ease;
}

.sb-budget-products .ai-product-grid .ai-product-card a.btn:hover,
.sb-budget-products .ai-product-grid .ai-product-card a.btn:focus-visible {
    background: var(--budget-primary);
    color: #fff;
}

.sb-budget-products .ai-product-grid .ai-product-card a.btn:focus-visible {
    outline: 3px solid rgba(99, 102, 241, .28);
    outline-offset: 2px;
}

/* Common product image containers */
.sb-budget-products .ai-product-grid .product-image-wrapper,
.sb-budget-products .ai-product-grid .ai-product-image-wrapper,
.sb-budget-products .ai-product-grid .product-card-image,
.sb-budget-products .ai-product-grid .product-image-container,
.sb-budget-products .ai-product-grid .ai-product-image-container,
.sb-budget-products .ai-product-grid .product-img-wrap {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 100% !important;
    height: 205px !important;
    min-height: 205px !important;
    max-height: 205px !important;
    flex: 0 0 205px !important;

    overflow: hidden !important;
}

/* Product image proportion is preserved */
.sb-budget-products .ai-product-grid .product-image-wrapper img,
.sb-budget-products .ai-product-grid .ai-product-image-wrapper img,
.sb-budget-products .ai-product-grid .product-card-image img,
.sb-budget-products .ai-product-grid .product-image-container img,
.sb-budget-products .ai-product-grid .ai-product-image-container img,
.sb-budget-products .ai-product-grid .product-img-wrap img,
.sb-budget-products .ai-product-grid img.ai-product-image,
.sb-budget-products .ai-product-grid img.product-image {
    display: block;

    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;

    object-fit: contain !important;
    object-position: center !important;
}

/* Some card partials use a direct image without a wrapper */
.sb-budget-products .ai-product-grid .ai-product-card > img,
.sb-budget-products .ai-product-grid .product-card > img {
    display: block;
    width: 100% !important;
    height: 205px !important;
    min-height: 205px !important;
    max-height: 205px !important;
    flex: 0 0 205px !important;
    object-fit: contain !important;
    object-position: center !important;
}

/* Content area expands, keeping actions aligned */
.sb-budget-products .ai-product-grid .ai-product-card-body,
.sb-budget-products .ai-product-grid .product-card-body,
.sb-budget-products .ai-product-grid .product-details,
.sb-budget-products .ai-product-grid .card-body {
    display: flex !important;
    flex: 1 1 auto !important;
    flex-direction: column !important;

    width: 100% !important;
    min-width: 0 !important;
}

.sb-budget-products .ai-product-grid .ai-product-card-title,
.sb-budget-products .ai-product-grid .product-card-title,
.sb-budget-products .ai-product-grid .product-name,
.sb-budget-products .ai-product-grid .card-title {
    overflow-wrap: anywhere;
}

.sb-budget-products .ai-product-grid .ai-product-card-actions,
.sb-budget-products .ai-product-grid .product-card-actions,
.sb-budget-products .ai-product-grid .product-actions,
.sb-budget-products .ai-product-grid .card-body > .mt-auto {
    margin-top: auto !important;
}

/* =========================================================
   EMPTY RESULTS
========================================================= */

.sb-budget-empty {
    display: flex;
    align-items: center;
    justify-content: center;

    min-height: 330px;
    padding: 45px 25px;

    text-align: center;
}

.sb-budget-empty-inner {
    max-width: 490px;
}

.sb-budget-empty-icon {
    display: grid;
    place-items: center;

    width: 84px;
    height: 84px;

    margin: 0 auto 21px;

    border: 1px solid rgba(99,102,241,.18);
    border-radius: 27px;

    background: rgba(99,102,241,.09);
    color: var(--budget-primary);

    font-size: 2rem;

    box-shadow: 0 14px 35px rgba(99,102,241,.09);
}

.sb-budget-empty h3 {
    margin: 0 0 9px;
    color: var(--budget-text);
    font-size: 1.22rem;
    font-weight: 950;
}

.sb-budget-empty p {
    margin: 0;
    color: var(--budget-muted);
    font-size: .87rem;
    line-height: 1.8;
}

/* =========================================================
   INITIAL STATE
========================================================= */

.sb-budget-start {
    position: relative;
    overflow: hidden;

    margin-top: 25px;
    padding: 39px 25px;

    border: 1px dashed var(--budget-border);
    border-radius: 25px;

    background: linear-gradient(
        130deg,
        rgba(99,102,241,.055),
        transparent 75%
    );

    text-align: center;

    animation: sbBudgetFadeUp .65s .2s both;
}

.sb-budget-start-icon {
    display: grid;
    place-items: center;

    width: 70px;
    height: 70px;

    margin: 0 auto 17px;

    border: 1px solid rgba(99,102,241,.15);
    border-radius: 23px;

    background: rgba(99,102,241,.09);
    color: var(--budget-primary);

    font-size: 1.65rem;

    animation: sbBudgetFloat 4s ease-in-out infinite;
}

.sb-budget-start h3 {
    margin: 0 0 8px;
    color: var(--budget-text);
    font-size: 1.08rem;
    font-weight: 950;
}

.sb-budget-start p {
    max-width: 510px;
    margin: 0 auto;
    color: var(--budget-muted);
    font-size: .85rem;
    line-height: 1.8;
}

/* =========================================================
   DARK THEME — USE EXISTING GLOBAL THEME
========================================================= */

[data-theme="dark"] .sb-budget-page,
[data-sb-theme="dark"] .sb-budget-page {
    --budget-bg: #020617;
    --budget-card: rgba(15,23,42,.94);
    --budget-card-2: #0f172a;
    --budget-text: #f1f5f9;
    --budget-muted: #94a3b8;
    --budget-border: rgba(148,163,184,.17);
    --budget-shadow: 0 25px 75px rgba(0,0,0,.30);
}

[data-theme="dark"] .sb-budget-hero,
[data-sb-theme="dark"] .sb-budget-hero {
    background:
        radial-gradient(circle at 85% 10%, rgba(99,102,241,.20), transparent 34%),
        radial-gradient(circle at 0% 100%, rgba(14,165,233,.11), transparent 35%),
        var(--budget-card);
}

[data-theme="dark"] .sb-budget-hero-border::after,
[data-sb-theme="dark"] .sb-budget-hero-border::after {
    background: var(--budget-card);
}

[data-theme="dark"] .sb-budget-search,
[data-theme="dark"] .sb-budget-results,
[data-sb-theme="dark"] .sb-budget-search,
[data-sb-theme="dark"] .sb-budget-results {
    background: var(--budget-card);
}

[data-theme="dark"] .sb-budget-result-head,
[data-sb-theme="dark"] .sb-budget-result-head {
    background: linear-gradient(
        120deg,
        rgba(99,102,241,.13),
        transparent 72%
    );
}

[data-theme="dark"] .sb-budget-input,
[data-sb-theme="dark"] .sb-budget-input {
    background: var(--budget-card-2) !important;
    color: #f8fafc !important;
    border-color: rgba(148,163,184,.22);
}

[data-theme="dark"] .sb-budget-start,
[data-sb-theme="dark"] .sb-budget-start {
    background: linear-gradient(
        130deg,
        rgba(99,102,241,.08),
        transparent 75%
    );
}

/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes sbBudgetHeroEntrance {
    from {
        opacity: 0;
        transform: translateY(18px) scale(.99);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes sbBudgetFadeUp {
    from {
        opacity: 0;
        transform: translateY(14px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes sbBudgetBorderSpin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes sbBudgetGlow {
    from {
        transform: translate3d(-10px, 0, 0) scale(.92);
        opacity: .55;
    }
    to {
        transform: translate3d(12px, 18px, 0) scale(1.08);
        opacity: 1;
    }
}

@keyframes sbBudgetOrbit {
    from {
        transform: translate3d(0, 0, 0) rotate(0deg);
    }
    to {
        transform: translate3d(-16px, 15px, 0) rotate(12deg);
    }
}

@keyframes sbBudgetFloat {
    0%, 100% {
        transform: translateY(0) rotate(3deg);
    }
    50% {
        transform: translateY(-10px) rotate(1deg);
    }
}

@keyframes sbBudgetIconFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-6px);
    }
}

@keyframes sbBudgetSmallFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-7px);
    }
}

@keyframes sbBudgetRingPulse {
    0%, 100% {
        opacity: .45;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.025);
    }
}

@keyframes sbBudgetGradientText {
    to {
        background-position: 250% center;
    }
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1250px) {
    .sb-budget-products .ai-product-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    }
}

@media (max-width: 900px) {
    .sb-budget-hero {
        gap: 22px;
    }

    .sb-budget-hero-visual {
        flex-basis: 155px;
        width: 155px;
        height: 155px;
        margin-right: 8px;
        border-radius: 33px;
    }

    .sb-budget-hero-visual-main-icon {
        font-size: 59px;
    }

    .sb-budget-products .ai-product-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}

@media (max-width: 768px) {
    .sb-budget-page {
        padding: 21px 0 50px;
    }

    .sb-budget-container {
        padding: 0 15px;
    }

    .sb-budget-hero {
        min-height: 0;
        padding: 28px 22px;
        border-radius: 23px;
    }

    .sb-budget-hero-visual {
        display: none;
    }

    .sb-budget-hero h1 {
        font-size: clamp(2.1rem, 8vw, 3rem);
    }

    .sb-budget-search {
        padding: 21px;
        border-radius: 21px;
    }

    .sb-budget-search .row {
        grid-template-columns: minmax(0, 1fr);
    }

    .sb-budget-result-head {
        align-items: flex-start;
        flex-direction: column;
        padding: 22px;
    }

    .sb-budget-amount {
        width: 100%;
    }

    .sb-budget-products {
        padding: 17px;
    }

    .sb-budget-products .ai-product-grid {
        gap: 15px !important;
    }

    .sb-budget-products .ai-product-grid .product-image-wrapper,
    .sb-budget-products .ai-product-grid .ai-product-image-wrapper,
    .sb-budget-products .ai-product-grid .product-card-image,
    .sb-budget-products .ai-product-grid .product-image-container,
    .sb-budget-products .ai-product-grid .ai-product-image-container,
    .sb-budget-products .ai-product-grid .product-img-wrap,
    .sb-budget-products .ai-product-grid .ai-product-card > img,
    .sb-budget-products .ai-product-grid .product-card > img {
        height: 175px !important;
        min-height: 175px !important;
        max-height: 175px !important;
        flex-basis: 175px !important;
    }
}

@media (max-width: 480px) {
    .sb-budget-container {
        padding: 0 11px;
    }

    .sb-budget-hero {
        padding: 24px 18px;
    }

    .sb-budget-hero h1 {
        font-size: 2.05rem;
    }

    .sb-budget-hero-description {
        font-size: .88rem;
    }

    .sb-budget-hero-points {
        gap: 10px 13px;
    }

    .sb-budget-search {
        padding: 17px;
    }

    .sb-budget-search-heading {
        align-items: flex-start;
    }

    .sb-budget-products {
        padding: 11px;
    }

    .sb-budget-products .ai-product-grid {
        gap: 10px !important;
    }

    .sb-budget-products .ai-product-grid .product-image-wrapper,
    .sb-budget-products .ai-product-grid .ai-product-image-wrapper,
    .sb-budget-products .ai-product-grid .product-card-image,
    .sb-budget-products .ai-product-grid .product-image-container,
    .sb-budget-products .ai-product-grid .ai-product-image-container,
    .sb-budget-products .ai-product-grid .product-img-wrap,
    .sb-budget-products .ai-product-grid .ai-product-card > img,
    .sb-budget-products .ai-product-grid .product-card > img {
        height: 135px !important;
        min-height: 135px !important;
        max-height: 135px !important;
        flex-basis: 135px !important;
    }
}

</style>
@endpush

@section('content')

{{-- IMPORTANT:
     layouts.app must already render the shared customer Taskbar.
     Do not add <x-products-customer-taskbar /> here as well,
     otherwise the Taskbar appears twice.
--}}

<main class="sb-budget-page">
    <div class="sb-budget-container">

        {{-- PREMIUM ANIMATED HERO --}}
        <section class="sb-budget-hero">

            <div class="sb-budget-hero-border" aria-hidden="true"></div>
            <div class="sb-budget-hero-glow" aria-hidden="true"></div>
            <div class="sb-budget-orbit" aria-hidden="true"></div>

            <div class="sb-budget-hero-content">

                <span class="sb-budget-eyebrow">
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                    AI Shopping Assistant
                </span>

                <x-customer-page-hero>
<h1 class="sb-customer-page-title">
                    Shop Smarter.
                    <span>Spend Better.</span>
                </h1>
</x-customer-page-hero>

                <p class="sb-budget-hero-description">
                    Set your shopping budget and discover products
                    that match your spending limit. Smart Basket helps
                    you explore suitable choices in one place.
                </p>

                <div class="sb-budget-hero-points">

                    <span class="sb-budget-hero-point">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        Budget-based discovery
                    </span>

                    <span class="sb-budget-hero-point">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        Easy product comparison
                    </span>

                    <span class="sb-budget-hero-point">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        Simple shopping
                    </span>

                </div>

            </div>

            <div class="sb-budget-hero-visual" aria-hidden="true">

                <span class="sb-budget-floating-icon sb-budget-floating-icon-one">
                    <i class="fa-solid fa-tag"></i>
                </span>

                <span class="sb-budget-floating-icon sb-budget-floating-icon-two">
                    <i class="fa-solid fa-check"></i>
                </span>

                <span class="sb-budget-floating-icon sb-budget-floating-icon-three">
                    <i class="fa-solid fa-coins"></i>
                </span>

                <i class="fa-solid fa-basket-shopping sb-budget-hero-visual-main-icon"></i>

                <span class="sb-budget-hero-visual-badge">
                    <i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i>
                    Your Budget
                </span>

            </div>

        </section>

        {{-- BUDGET SEARCH --}}
        <section class="sb-budget-search">

            <div class="sb-budget-search-heading">

                <div class="sb-budget-search-icon" aria-hidden="true">
                    <i class="fa-solid fa-sliders"></i>
                </div>

                <div>
                    <h2>Find Products Within Your Budget</h2>
                    <p>Enter your maximum spending amount to explore matching products.</p>
                </div>

            </div>

            <form method="GET" action="{{ route('budget-shopping') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-12 col-lg-8">

                        <label for="budget" class="sb-budget-label">
                            <i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i>
                            Your Shopping Budget
                        </label>

                        <div class="sb-budget-input-wrap">

                            <span class="sb-budget-currency" aria-hidden="true">₹</span>

                            <input
                                id="budget"
                                type="number"
                                name="budget"
                                class="form-control sb-budget-input"
                                min="0"
                                step="0.01"
                                value="{{ $budget }}"
                                placeholder="Enter your maximum budget — e.g. 500"
                                aria-describedby="budget-help"
                                required
                            >

                        </div>

                        <small
                            id="budget-help"
                            class="d-block mt-2"
                            style="color:var(--budget-muted);font-size:.76rem;"
                        >
                            Enter an amount in Indian Rupees (₹).
                        </small>

                    </div>

                    <div class="col-12 col-lg-4">

                        <button type="submit" class="btn sb-budget-submit">
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                            Find Products
                        </button>

                    </div>

                </div>

            </form>

        </section>

        {{-- RESULTS --}}
        @if($budget !== null && $budget !== '')

            <section class="sb-budget-results">

                <div class="sb-budget-result-head">

                    <div>

                        <span class="sb-budget-result-label">
                            <i class="fa-solid fa-sparkles" aria-hidden="true"></i>
                            Smart Results
                        </span>

                        @if($products->isNotEmpty())

                            <h2 class="sb-budget-result-title">
                                {{ $products->count() }}
                                Product{{ $products->count() !== 1 ? 's' : '' }} Found
                            </h2>

                            <p class="sb-budget-result-description">
                                Products matching your selected budget are shown below.
                            </p>

                        @else

                            <h2 class="sb-budget-result-title">
                                No Matching Products
                            </h2>

                            <p class="sb-budget-result-description">
                                Try another budget amount to look for more products.
                            </p>

                        @endif

                    </div>

                    <div class="sb-budget-amount">
                        <i class="fa-solid fa-wallet" aria-hidden="true"></i>
                        <span>Budget: ₹{{ number_format((float) $budget, 2) }}</span>
                    </div>

                </div>

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

                @else

                    <div class="sb-budget-empty">

                        <div class="sb-budget-empty-inner">

                            <div class="sb-budget-empty-icon">
                                <i class="fa-solid fa-magnifying-glass-dollar" aria-hidden="true"></i>
                            </div>

                            <h3>Nothing Fits This Budget Yet</h3>

                            <p>
                                We couldn't find products matching
                                ₹{{ number_format((float) $budget, 2) }}.
                                Try a slightly higher amount and explore more Smart Basket products.
                            </p>

                        </div>

                    </div>

                @endif

            </section>

        @else

            {{-- INITIAL STATE --}}
            <section class="sb-budget-start">

                <div class="sb-budget-start-icon" aria-hidden="true">
                    <i class="fa-solid fa-magnifying-glass-dollar"></i>
                </div>

                <h3>What's Your Shopping Budget?</h3>

                <p>
                    Enter your budget above, select Find Products,
                    and discover products that match your spending limit.
                </p>

            </section>

        @endif

    </div>
</main>

@endsection

<!doctype html>
<html lang="en" data-sb-theme="light">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Payment History | Smart Basket Seller</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

/* =========================================================
   SMART BASKET
   PREMIUM SELLER PAYMENT HISTORY — LIGHT THEME
========================================================= */

:root {

    --sb-green: #00b86b;
    --sb-green-dark: #009657;
    --sb-green-light: #e9fff5;

    --sb-blue: #2563eb;
    --sb-blue-light: #eff6ff;

    --sb-orange: #f59e0b;
    --sb-orange-light: #fff7e6;

    --sb-red: #ef4444;
    --sb-red-light: #fff1f2;

    --sb-purple: #8b5cf6;
    --sb-purple-light: #f5f3ff;

    --sb-bg: #f5f7fb;
    --sb-card: #ffffff;
    --sb-card-soft: #fbfcfe;

    --sb-text: #111827;
    --sb-text-2: #334155;
    --sb-muted: #64748b;
    --sb-muted-2: #94a3b8;

    --sb-border: #e7ebf0;

    --sb-shadow:
        0 10px 35px rgba(15,23,42,.07);

    --sb-shadow-hover:
        0 18px 45px rgba(15,23,42,.11);
}


/* =========================================================
   GLOBAL
========================================================= */

* {
    box-sizing: border-box;
}

html {
    min-height: 100%;
    background: var(--sb-bg);
}

body {

    margin: 0;

    min-height: 100vh;

    color: var(--sb-text);

    background:

        radial-gradient(
            circle at 5% 0%,
            rgba(0,184,107,.07),
            transparent 27%
        ),

        radial-gradient(
            circle at 95% 8%,
            rgba(37,99,235,.055),
            transparent 25%
        ),

        linear-gradient(
            135deg,
            #f8fafc 0%,
            #f4f7fb 52%,
            #f8fafc 100%
        );

    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
}


/* =========================================================
   PAGE
========================================================= */

.payment-page {

    width: min(
        1180px,
        calc(100% - 36px)
    );

    margin: 0 auto;

    padding:
        38px 0 75px;
}


/* =========================================================
   TOP HEADER
========================================================= */

.payment-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 24px;

    margin-bottom: 30px;
}


.payment-heading-wrap {
    min-width: 0;
}


.payment-title {

    display: flex;

    align-items: center;

    gap: 12px;

    margin: 0;

    color: #111827;

    font-size: 31px;

    line-height: 1.15;

    font-weight: 850;

    letter-spacing: -.8px;
}


.payment-title-icon {

    width: 48px;

    height: 48px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 15px;

    background:
        linear-gradient(
            145deg,
            #eafff5,
            #f5fffb
        );

    border:
        1px solid rgba(0,184,107,.16);

    color: var(--sb-green);

    box-shadow:
        0 8px 24px rgba(0,184,107,.09);

    font-size: 18px;
}


.payment-title-text {
    display: flex;
    flex-direction: column;
}


.payment-title-main {
    color: #111827;
}


.payment-title-main span {
    color: var(--sb-green-dark);
}


.payment-subtitle {

    margin: 8px 0 0 60px;

    color: var(--sb-muted);

    font-size: 13px;

    line-height: 1.6;
}


.payment-subtitle strong {
    color: #334155;
    font-weight: 800;
}


/* =========================================================
   DASHBOARD BUTTON
========================================================= */

.premium-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    min-height: 44px;

    padding:
        0 17px;

    border-radius: 12px;

    text-decoration: none;

    font-size: 12px;

    font-weight: 800;

    white-space: nowrap;

    transition:
        transform .22s ease,
        box-shadow .22s ease,
        background .22s ease,
        border-color .22s ease;
}


.btn-outline-premium {

    color: #334155;

    background: #ffffff;

    border:
        1px solid #dfe5ec;

    box-shadow:
        0 6px 20px rgba(15,23,42,.05);
}


.btn-outline-premium i {
    color: var(--sb-green-dark);
}


.btn-outline-premium:hover {

    color: #0f172a;

    background: #ffffff;

    border-color:
        rgba(0,184,107,.38);

    transform:
        translateY(-2px);

    box-shadow:
        0 12px 28px rgba(15,23,42,.09),
        0 0 0 4px rgba(0,184,107,.055);
}


/* =========================================================
   SUMMARY GRID
========================================================= */

.summary-grid {

    display: grid;

    grid-template-columns:
        1.45fr
        repeat(4, 1fr);

    gap: 15px;

    margin-bottom: 22px;
}


/* =========================================================
   SUMMARY CARD
========================================================= */

.summary-card {

    position: relative;

    overflow: hidden;

    min-height: 126px;

    padding: 20px;

    border:
        1px solid var(--sb-border);

    border-radius: 18px;

    background:
        rgba(255,255,255,.96);

    box-shadow:
        var(--sb-shadow);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}


.summary-card:hover {

    transform:
        translateY(-4px);

    border-color:
        #dce4ec;

    box-shadow:
        var(--sb-shadow-hover);
}


.summary-card::after {

    content: "";

    position: absolute;

    right: -45px;

    bottom: -55px;

    width: 120px;

    height: 120px;

    border-radius: 50%;

    background:
        rgba(0,184,107,.055);

    filter:
        blur(20px);

    pointer-events: none;
}


/* RECEIVED */

.summary-card.received {

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f1fff8
        );

    border-color:
        rgba(0,184,107,.22);

    box-shadow:
        0 12px 35px rgba(0,184,107,.08);
}


.summary-label {

    display: block;

    color: var(--sb-muted);

    font-size: 10px;

    font-weight: 850;

    text-transform: uppercase;

    letter-spacing: .08em;
}


.summary-value {

    position: relative;

    z-index: 1;

    display: block;

    margin-top: 8px;

    color: #111827;

    font-size: 23px;

    line-height: 1;

    font-weight: 850;

    letter-spacing: -.5px;
}


.received .summary-value {

    color:
        var(--sb-green-dark);

    font-size: 27px;
}


.summary-icon {

    position: absolute;

    z-index: 1;

    right: 18px;

    top: 18px;

    color:
        rgba(15,23,42,.075);

    font-size: 25px;
}


.received .summary-icon {

    color:
        rgba(0,184,107,.13);
}


/* =========================================================
   FILTER CARD
========================================================= */

.filter-card {

    padding: 18px;

    margin-bottom: 22px;

    border:
        1px solid var(--sb-border);

    border-radius: 19px;

    background:
        rgba(255,255,255,.96);

    box-shadow:
        var(--sb-shadow);
}


.filter-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 13px;
}


.filter-title {

    display: flex;

    align-items: center;

    gap: 8px;

    color: #1e293b;

    font-size: 12px;

    font-weight: 850;
}


.filter-title i {
    color: var(--sb-green);
}


.filter-hint {

    color: var(--sb-muted-2);

    font-size: 10px;
}


.form-control,
.form-select {

    min-height: 44px;

    color: #1e293b !important;

    background:
        #f8fafc !important;

    border:
        1px solid #e2e8f0 !important;

    border-radius: 11px !important;

    box-shadow:
        inset 0 1px 2px rgba(15,23,42,.02);

    font-size: 12px !important;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}


.form-control::placeholder {
    color: #94a3b8 !important;
}


.form-control:hover,
.form-select:hover {

    border-color:
        #cbd5e1 !important;

    background:
        #ffffff !important;
}


.form-control:focus,
.form-select:focus {

    color: #0f172a !important;

    background:
        #ffffff !important;

    border-color:
        rgba(0,184,107,.65) !important;

    box-shadow:
        0 0 0 4px rgba(0,184,107,.08) !important;

    outline: none !important;
}


.form-select option {

    color: #111827;

    background: #ffffff;
}


input[type="date"] {
    color-scheme: light;
}


/* FILTER BUTTON */

.filter-btn {

    width: 100%;

    min-height: 44px;

    border: 0;

    border-radius: 11px;

    background:
        linear-gradient(
            135deg,
            #00c878,
            #00a965
        );

    color: #ffffff;

    font-size: 12px;

    font-weight: 850;

    box-shadow:
        0 8px 20px rgba(0,184,107,.15);

    transition:
        transform .22s ease,
        box-shadow .22s ease;
}


.filter-btn:hover {

    color: #ffffff;

    transform:
        translateY(-2px);

    box-shadow:
        0 13px 28px rgba(0,184,107,.22);
}


/* =========================================================
   PAYMENTS CONTAINER
========================================================= */

.payments-card {

    overflow: hidden;

    border:
        1px solid var(--sb-border);

    border-radius: 22px;

    background:
        rgba(255,255,255,.98);

    box-shadow:
        0 15px 50px rgba(15,23,42,.075);
}


/* =========================================================
   PAYMENT ROW
========================================================= */

.payment-row {

    position: relative;

    padding: 23px 24px;

    border-bottom:
        1px solid #edf0f4;

    transition:
        background .22s ease;
}


.payment-row:last-child {
    border-bottom: 0;
}


.payment-row:hover {

    background:
        linear-gradient(
            90deg,
            #ffffff,
            #fbfffd
        );
}


.payment-row-top {
    min-height: 58px;
}


/* =========================================================
   CUSTOMER
========================================================= */

.customer-name {

    color: #111827;

    font-size: 15px;

    font-weight: 850;
}


.customer-icon {

    margin-right: 6px;

    color: var(--sb-green-dark);
}


.customer-uid {

    margin-top: 5px;

    color: var(--sb-blue);

    font-size: 11px;

    font-weight: 650;
}


.order-meta {

    margin-top: 5px;

    color: #94a3b8;

    font-size: 11px;
}


.order-meta i {
    color: #64748b;
}


/* =========================================================
   PAYMENT AMOUNT
========================================================= */

.payment-amount-box {
    min-width: 150px;
}


.payment-amount {

    color:
        var(--sb-green-dark);

    font-size: 21px;

    font-weight: 900;

    letter-spacing: -.3px;
}


.payment-status {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

    margin-top: 6px;

    padding:
        5px 10px;

    border-radius: 999px;

    font-size: 10px;

    font-weight: 850;

    letter-spacing: .02em;
}


/* STATUS */

.status-successful {

    color: #008a51;

    background:
        #eafff4;

    border:
        1px solid #b9f2d5;
}


.status-pending {

    color: #b56a00;

    background:
        #fff7e5;

    border:
        1px solid #f7dca2;
}


.status-failed {

    color: #d52f3d;

    background:
        #fff0f1;

    border:
        1px solid #ffc8cd;
}


.status-refunded {

    color: #7443c5;

    background:
        #f4efff;

    border:
        1px solid #ded0ff;
}


/* =========================================================
   PRODUCT LINE
========================================================= */

.product-section {

    margin-top: 16px;

    padding:
        13px 14px;

    border:
        1px solid #edf0f4;

    border-radius: 13px;

    background:
        #fafbfc;
}


.product-line {

    display: flex;

    align-items: center;

    gap: 11px;

    min-width: 0;

    margin-top: 8px;

    color: #334155;

    font-size: 12px;

    font-weight: 600;
}


.product-line:first-child {
    margin-top: 0;
}


.product-line span {

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}


.product-line img,
.product-placeholder {

    width: 43px;

    height: 43px;

    flex-shrink: 0;

    object-fit: cover;

    border-radius: 10px;

    border:
        1px solid #e2e8f0;

    background:
        #ffffff;
}


.product-placeholder {

    display: flex;

    align-items: center;

    justify-content: center;

    color: #94a3b8;

    font-size: 14px;
}


/* =========================================================
   PAYMENT METHOD
========================================================= */

.payment-method {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 3px;

    margin-top: 12px;

    color: #64748b;

    font-size: 11px;

    font-weight: 600;
}


.payment-method > i {

    color:
        var(--sb-green-dark);
}


.transaction-text {
    color: #94a3b8;
}


/* =========================================================
   ACTION BUTTONS
========================================================= */

.payment-actions {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

    margin-top: 15px;
}


.action-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    min-height: 35px;

    padding:
        0 12px;

    border-radius: 9px;

    text-decoration: none;

    font-size: 10px;

    font-weight: 850;

    transition:
        transform .2s ease,
        background .2s ease,
        border-color .2s ease,
        box-shadow .2s ease;
}


.action-btn:hover {
    transform:
        translateY(-1px);
}


/* VIEW */

.view-btn {

    color: #2563eb;

    background:
        #eff6ff;

    border:
        1px solid #bfdbfe;
}


.view-btn:hover {

    color: #1d4ed8;

    background:
        #dbeafe;

    border-color:
        #93c5fd;
}


/* RECEIPT */

.receipt-btn {

    color:
        #008a51;

    background:
        #edfff6;

    border:
        1px solid #b9efd4;
}


.receipt-btn:hover {

    color: #ffffff;

    background:
        var(--sb-green-dark);

    border-color:
        var(--sb-green-dark);

    box-shadow:
        0 7px 18px rgba(0,184,107,.17);
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-payment {

    padding:
        85px 25px;

    text-align: center;

    background:
        linear-gradient(
            180deg,
            #ffffff,
            #fbfcfd
        );
}


.empty-payment-icon {

    width: 70px;

    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin:
        0 auto 18px;

    border-radius: 21px;

    background:
        #edfff6;

    border:
        1px solid #c5f3db;

    color:
        var(--sb-green-dark);

    font-size: 27px;

    box-shadow:
        0 10px 25px rgba(0,184,107,.07);
}


.empty-payment h5 {

    margin: 0;

    color: #1e293b;

    font-size: 18px;

    font-weight: 850;
}


.empty-payment p {

    margin-top: 7px;

    color: #94a3b8;

    font-size: 12px;
}


/* =========================================================
   RESPONSIVE — TABLET
========================================================= */

@media (max-width: 1050px) {

    .summary-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }


    .summary-card.received {

        grid-column:
            span 2;
    }

}


/* =========================================================
   RESPONSIVE — MOBILE
========================================================= */

@media (max-width: 700px) {

    .payment-page {

        width:
            calc(100% - 24px);

        padding:
            22px 0 55px;
    }


    .payment-header {

        align-items:
            flex-start;

        flex-direction:
            column;

        gap: 15px;
    }


    .payment-title {

        font-size: 25px;
    }


    .payment-title-icon {

        width: 43px;

        height: 43px;

        border-radius: 13px;
    }


    .payment-subtitle {

        margin-left: 0;

        font-size: 11px;
    }


    .payment-header .premium-btn {

        width: 100%;
    }


    .summary-grid {

        grid-template-columns:
            1fr 1fr;

        gap: 10px;
    }


    .summary-card {

        min-height: 112px;

        padding: 16px;
    }


    .summary-card.received {

        grid-column:
            span 2;
    }


    .received .summary-value {

        font-size: 24px;
    }


    .summary-value {

        font-size: 20px;
    }


    .summary-icon {

        right: 13px;

        top: 13px;

        font-size: 19px;
    }


    .filter-card {

        padding: 14px;
    }


    .filter-hint {

        display: none;
    }


    .payment-row {

        padding:
            18px 15px;
    }


    .payment-row-top {

        flex-direction:
            column;

        gap: 13px;
    }


    .payment-amount-box {

        min-width: 0;

        text-align:
            left !important;
    }


    .payment-amount {

        font-size: 20px;
    }


    .product-section {

        padding:
            11px;
    }

}


/* =========================================================
   VERY SMALL MOBILE
========================================================= */

@media (max-width: 430px) {

    .payment-title {

        font-size: 22px;
    }


    .payment-title-icon {

        width: 40px;

        height: 40px;

        font-size: 15px;
    }


    .summary-card {

        padding: 14px;

        border-radius: 15px;
    }


    .summary-label {

        font-size: 9px;
    }


    .summary-value {

        font-size: 18px;
    }


    .received .summary-value {

        font-size: 22px;
    }


    .payment-actions {

        display: grid;

        grid-template-columns:
            1fr 1fr;
    }


    .action-btn {

        width: 100%;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {

        transition:
            none !important;

        animation:
            none !important;
    }

}

    </style>

</head>


<body>


<main class="payment-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="payment-header">

        <div class="payment-heading-wrap">

            <h1 class="payment-title">

                <span class="payment-title-icon">
                    <i class="fa-solid fa-wallet"></i>
                </span>

                <span class="payment-title-text">

                    <span class="payment-title-main">
                        Payment <span>History</span>
                    </span>

                </span>

            </h1>


            <p class="payment-subtitle">

                Customer payments for

                <strong>
                    {{ $seller->shop_name ?: $seller->seller_name }}
                </strong>

            </p>

        </div>


        <a
            href="{{ route('seller.dashboard') }}"
            class="premium-btn btn-outline-premium"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Dashboard

        </a>

    </header>



    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <section class="summary-grid">


        {{-- TOTAL RECEIVED --}}

        <div class="summary-card received">

            <span class="summary-label">
                Total Received
            </span>

            <strong class="summary-value">
                ₹{{ number_format($summary['received'], 2) }}
            </strong>

            <i
                class="fa-solid fa-money-bill-trend-up summary-icon"
            ></i>

        </div>


        {{-- SUCCESSFUL --}}

        <div class="summary-card">

            <span class="summary-label">
                Successful
            </span>

            <strong class="summary-value">
                {{ $summary['successful'] }}
            </strong>

            <i
                class="fa-solid fa-circle-check summary-icon"
            ></i>

        </div>


        {{-- PENDING --}}

        <div class="summary-card">

            <span class="summary-label">
                Pending
            </span>

            <strong class="summary-value">
                {{ $summary['pending'] }}
            </strong>

            <i
                class="fa-solid fa-clock summary-icon"
            ></i>

        </div>


        {{-- FAILED --}}

        <div class="summary-card">

            <span class="summary-label">
                Failed
            </span>

            <strong class="summary-value">
                {{ $summary['failed'] }}
            </strong>

            <i
                class="fa-solid fa-circle-xmark summary-icon"
            ></i>

        </div>


        {{-- REFUNDED --}}

        <div class="summary-card">

            <span class="summary-label">
                Refunded
            </span>

            <strong class="summary-value">
                {{ $summary['refunded'] }}
            </strong>

            <i
                class="fa-solid fa-rotate-left summary-icon"
            ></i>

        </div>


    </section>



    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <form
        class="filter-card"
        method="GET"
    >

        <div class="filter-top">

            <div class="filter-title">

                <i class="fa-solid fa-sliders"></i>

                Payment Filters

            </div>

            <div class="filter-hint">
                Refine your payment history
            </div>

        </div>


        <div class="row g-2">


            {{-- SEARCH --}}

            <div class="col-lg-4 col-md-6">

                <input
                    class="form-control"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Customer, UID, order or product"
                >

            </div>


            {{-- STATUS --}}

            <div class="col-lg-2 col-md-3">

                <select
                    class="form-select"
                    name="status"
                >

                    <option value="">
                        All statuses
                    </option>

                    @foreach([
                        'Successful',
                        'Pending',
                        'Failed',
                        'Refunded'
                    ] as $value)

                        <option
                            value="{{ $value }}"
                            @selected(request('status') === $value)
                        >
                            {{ $value }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- METHOD --}}

            <div class="col-lg-2 col-md-3">

                <select
                    class="form-select"
                    name="method"
                >

                    <option value="">
                        All methods
                    </option>

                    @foreach([
                        'COD',
                        'UPI',
                        'Card',
                        'Google Pay',
                        'PhonePe',
                        'Net Banking'
                    ] as $value)

                        <option
                            value="{{ $value }}"
                            @selected(request('method') === $value)
                        >
                            {{ $value }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- DATE --}}

            <div class="col-lg-2 col-md-6">

                <input
                    class="form-control"
                    type="date"
                    name="from"
                    value="{{ request('from') }}"
                >

            </div>


            {{-- FILTER --}}

            <div class="col-lg-2 col-md-6">

                <button
                    class="filter-btn"
                    type="submit"
                >

                    <i class="fa-solid fa-filter me-1"></i>

                    Filter

                </button>

            </div>


        </div>

    </form>



    {{-- =====================================================
         PAYMENT LIST
    ====================================================== --}}

    <section class="payments-card">


        @forelse($orders as $order)


            @php

                $status =
                    app(
                        \App\Http\Controllers\SellerPaymentController::class
                    )->status($order);

                $customer =
                    $order->user;

            @endphp


            {{-- PAYMENT ROW --}}

            <article class="payment-row">


                {{-- TOP INFORMATION --}}

                <div
                    class="
                        d-flex
                        justify-content-between
                        gap-4
                        payment-row-top
                    "
                >


                    {{-- CUSTOMER --}}

                    <div>

                        <div class="customer-name">

                            <i
                                class="
                                    fa-solid
                                    fa-user
                                    customer-icon
                                "
                            ></i>

                            {{ $customer?->name ?: $order->name }}

                        </div>


                        <div class="customer-uid">

                            Customer UID:

                            {{ $customer?->customer_uid ?: 'Guest checkout — no customer UID' }}

                        </div>


                        <div class="order-meta">

                            <i class="fa-solid fa-receipt me-1"></i>

                            Order #SB-{{ $order->id }}

                            <span class="mx-1">
                                ·
                            </span>

                            {{ $order->created_at?->format('d M Y · h:i A') }}

                        </div>

                    </div>



                    {{-- AMOUNT --}}

                    <div class="payment-amount-box text-end">

                        <div class="payment-amount">

                            ₹{{ number_format($order->total, 2) }}

                        </div>


                        @if($status === 'Successful')

                            <span
                                class="
                                    payment-status
                                    status-successful
                                "
                            >

                                <i
                                    class="
                                        fa-solid
                                        fa-circle-check
                                    "
                                ></i>

                                Successful

                            </span>


                        @elseif($status === 'Pending')

                            <span
                                class="
                                    payment-status
                                    status-pending
                                "
                            >

                                <i
                                    class="
                                        fa-solid
                                        fa-clock
                                    "
                                ></i>

                                Pending

                            </span>


                        @elseif($status === 'Refunded')

                            <span
                                class="
                                    payment-status
                                    status-refunded
                                "
                            >

                                <i
                                    class="
                                        fa-solid
                                        fa-rotate-left
                                    "
                                ></i>

                                Refunded

                            </span>


                        @else

                            <span
                                class="
                                    payment-status
                                    status-failed
                                "
                            >

                                <i
                                    class="
                                        fa-solid
                                        fa-circle-xmark
                                    "
                                ></i>

                                {{ $status }}

                            </span>

                        @endif

                    </div>

                </div>



                {{-- =================================================
                     PRODUCTS
                ================================================== --}}

                <div class="product-section">

                    @forelse($order->seller_items as $item)

                        @php

                            $product =
                                $order->seller_products[
                                    $item['product_id'] ?? null
                                ] ?? null;

                        @endphp


                        <div class="product-line">


                            @if($product?->image)

                                <img
                                    src="{{ asset('products/'.$product->image) }}"
                                    alt="{{ $item['name'] ?? 'Product' }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="product-placeholder">

                                    <i
                                        class="fa-solid fa-box"
                                    ></i>

                                </div>

                            @endif


                            <span>

                                {{ $item['name'] ?? $product?->name ?? 'Product' }}

                                ×

                                {{ $item['quantity'] ?? 1 }}

                            </span>


                        </div>


                    @empty

                        <span
                            class="
                                small
                                transaction-text
                            "
                        >

                            Product details unavailable for this order.

                        </span>

                    @endforelse

                </div>



                {{-- =================================================
                     PAYMENT METHOD
                ================================================== --}}

                <div class="payment-method">

                    <i
                        class="
                            fa-solid
                            fa-credit-card
                            me-1
                        "
                    ></i>

                    {{ $order->payment_method ?: 'Not recorded' }}

                    <span class="transaction-text">

                        · Payment status:

                        {{ $status }}

                    </span>

                </div>



                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="payment-actions">


                    <a
                        class="
                            action-btn
                            view-btn
                        "
                        href="{{ route('seller.payments.show', $order) }}"
                    >

                        <i class="fa-solid fa-eye"></i>

                        View Payment

                    </a>


                    <a
                        class="
                            action-btn
                            receipt-btn
                        "
                        href="{{ route('seller.payments.receipt', $order) }}"
                    >

                        <i class="fa-solid fa-file-pdf"></i>

                        Payment Receipt

                    </a>


                </div>


            </article>


        @empty


            {{-- EMPTY --}}

            <div class="empty-payment">

                <div class="empty-payment-icon">

                    <i class="fa-solid fa-wallet"></i>

                </div>


                <h5>
                    No Customer Payments
                </h5>


                <p class="mb-0">

                    No customer payment records
                    match these filters.

                </p>

            </div>


        @endforelse


    </section>


</main>


</body>

    @include('seller.partials.seller-menu')

</html>
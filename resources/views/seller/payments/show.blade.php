<!doctype html>
<html lang="en" data-sb-theme="light">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Payment #SB-{{ $order->id }} | Smart Basket Seller
    </title>

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
           PREMIUM SELLER PAYMENT DETAILS
           FULL WIDTH / RESPONSIVE
        ========================================================= */

        :root {

            --pd-primary: #2563eb;
            --pd-primary-dark: #1d4ed8;
            --pd-primary-deep: #1e40af;

            --pd-blue-light: #eff6ff;
            --pd-blue-soft: #dbeafe;
            --pd-blue-border: #bfdbfe;

            --pd-indigo: #4f46e5;
            --pd-indigo-light: #eef2ff;

            --pd-green: #16a34a;
            --pd-green-dark: #15803d;
            --pd-green-light: #ecfdf3;

            --pd-orange: #f59e0b;
            --pd-orange-dark: #b45309;
            --pd-orange-light: #fff7e6;

            --pd-red: #ef4444;
            --pd-red-dark: #dc2626;
            --pd-red-light: #fff1f2;

            --pd-purple: #8b5cf6;
            --pd-purple-dark: #7c3aed;
            --pd-purple-light: #f5f3ff;

            --pd-bg: #f4f7fb;
            --pd-bg-2: #eef4fb;

            --pd-card: #ffffff;
            --pd-card-soft: #fbfdff;

            --pd-text: #0f172a;
            --pd-text-2: #334155;
            --pd-muted: #64748b;
            --pd-muted-2: #94a3b8;

            --pd-border: #e2e8f0;
            --pd-border-soft: #edf1f5;

            --pd-shadow:
                0 12px 38px rgba(15, 23, 42, .065);

            --pd-shadow-hover:
                0 22px 55px rgba(37, 99, 235, .12);

            --pd-radius-xl: 26px;
            --pd-radius-lg: 21px;
            --pd-radius-md: 17px;
            --pd-radius-sm: 12px;
        }


        /* =========================================================
           RESET
        ========================================================= */

        .payment-detail-page,
        .payment-detail-page * {
            box-sizing: border-box;
        }


        .payment-detail-page {
            width: 100%;
            min-width: 0;
        }


        .payment-detail-page a {
            -webkit-tap-highlight-color: transparent;
        }



        /* =========================================================
           MAIN PAGE
        ========================================================= */

        .payment-detail-page {

            position: relative;

            isolation: isolate;

            min-height: 100vh;

            width: 100%;

            padding:
                clamp(18px, 2vw, 30px)
                clamp(12px, 2vw, 30px)
                70px;

            overflow: hidden;

            color: var(--pd-text);

            background:

                radial-gradient(
                    circle at 3% 0%,
                    rgba(37, 99, 235, .075),
                    transparent 25%
                ),

                radial-gradient(
                    circle at 97% 7%,
                    rgba(79, 70, 229, .06),
                    transparent 26%
                ),

                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f4f7fb 52%,
                    #f8fafc 100%
                );
        }


        .payment-detail-page::before {

            content: "";

            position: absolute;

            z-index: -1;

            width: 420px;
            height: 420px;

            left: -220px;
            bottom: 50px;

            border-radius: 50%;

            background:
                rgba(37, 99, 235, .035);

            filter: blur(30px);

            pointer-events: none;
        }


        .payment-detail-page::after {

            content: "";

            position: absolute;

            z-index: -1;

            width: 350px;
            height: 350px;

            right: -190px;
            top: 300px;

            border-radius: 50%;

            background:
                rgba(79, 70, 229, .035);

            filter: blur(30px);

            pointer-events: none;
        }



        /* =========================================================
           INNER WIDTH
        ========================================================= */

        .payment-detail-page > .top-bar,
        .payment-detail-page > .hero-card,
        .payment-detail-page > .detail-grid {

            width: 100%;

            max-width: none;

            margin-left: auto;
            margin-right: auto;
        }



        /* =========================================================
           TOP ACTION BAR
        ========================================================= */

        .top-bar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 14px;

            margin-bottom: 18px;
        }


        .back-btn,
        .receipt-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            min-height: 44px;

            padding:
                0 17px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 11px;

            font-weight: 850;

            letter-spacing: .01em;

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                background .22s ease,
                border-color .22s ease,
                color .22s ease;
        }


        .back-btn {

            color:
                var(--pd-text-2);

            background:
                rgba(255,255,255,.94);

            border:
                1px solid var(--pd-border);

            box-shadow:
                0 7px 22px rgba(15,23,42,.045);
        }


        .back-btn i {

            color:
                var(--pd-primary);
        }


        .back-btn:hover {

            color:
                var(--pd-primary);

            background:
                var(--pd-blue-light);

            border-color:
                var(--pd-blue-border);

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 28px rgba(37,99,235,.10);
        }


        .receipt-btn {

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--pd-primary),
                    var(--pd-primary-dark)
                );

            border:
                1px solid var(--pd-primary);

            box-shadow:
                0 9px 25px rgba(37,99,235,.18);
        }


        .receipt-btn:hover {

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--pd-primary-dark),
                    var(--pd-primary-deep)
                );

            transform:
                translateY(-2px);

            box-shadow:
                0 15px 34px rgba(37,99,235,.25);
        }



        /* =========================================================
           HERO
        ========================================================= */

        .hero-card {

            position: relative;

            overflow: hidden;

            margin-bottom: 20px;

            padding:
                clamp(23px, 2.5vw, 31px);

            border-radius:
                var(--pd-radius-xl);

            background:

                linear-gradient(
                    135deg,
                    rgba(255,255,255,.99) 0%,
                    #f8fbff 55%,
                    #eef5ff 100%
                );

            border:
                1px solid var(--pd-blue-border);

            box-shadow:
                0 19px 60px rgba(37,99,235,.085);
        }


        .hero-card::before {

            content: "";

            position: absolute;

            left: 0;
            top: 0;
            bottom: 0;

            width: 5px;

            background:
                linear-gradient(
                    180deg,
                    var(--pd-primary),
                    var(--pd-indigo)
                );
        }


        .hero-card::after {

            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            right: -150px;
            top: -160px;

            border-radius: 50%;

            background:
                rgba(37,99,235,.07);

            filter: blur(10px);

            pointer-events: none;
        }


        .hero-content {

            position: relative;

            z-index: 2;
        }


        .hero-label {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            color:
                var(--pd-primary);

            font-size: 10px;

            font-weight: 850;

            text-transform: uppercase;

            letter-spacing: .11em;
        }


        .hero-label i {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: 24px;
            height: 24px;

            border-radius: 8px;

            color:
                var(--pd-primary);

            background:
                rgba(37,99,235,.09);

            border:
                1px solid rgba(37,99,235,.12);

            font-size: 10px;
        }


        .hero-title {

            margin:
                9px 0 5px;

            color:
                var(--pd-text);

            font-size:
                clamp(27px, 3vw, 38px);

            line-height:
                1.12;

            font-weight:
                900;

            letter-spacing:
                -.9px;
        }


        .hero-order {

            color:
                var(--pd-muted);

            font-size:
                12px;

            font-weight:
                550;
        }


        .hero-order strong {

            color:
                var(--pd-text-2);
        }



        /* =========================================================
           HERO AMOUNT
        ========================================================= */

        .hero-amount-wrap {

            position:
                relative;

            z-index:
                2;

            text-align:
                right;
        }


        .hero-amount-label {

            margin-bottom:
                5px;

            color:
                var(--pd-muted);

            font-size:
                9px;

            font-weight:
                850;

            text-transform:
                uppercase;

            letter-spacing:
                .1em;
        }


        .hero-amount {

            color:
                var(--pd-primary);

            font-size:
                clamp(31px, 3.3vw, 44px);

            line-height:
                1;

            font-weight:
                950;

            letter-spacing:
                -1.3px;
        }


        .status-pill {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            margin-top: 11px;

            padding:
                7px 13px;

            border-radius:
                999px;

            font-size:
                10px;

            font-weight:
                850;
        }


        .successful {

            color:
                var(--pd-green-dark);

            background:
                var(--pd-green-light);

            border:
                1px solid #bbf7d0;
        }


        .pending {

            color:
                var(--pd-orange-dark);

            background:
                var(--pd-orange-light);

            border:
                1px solid #f7dca2;
        }


        .failed {

            color:
                var(--pd-red-dark);

            background:
                var(--pd-red-light);

            border:
                1px solid #fecdd3;
        }


        .refunded {

            color:
                var(--pd-purple-dark);

            background:
                var(--pd-purple-light);

            border:
                1px solid #ddd6fe;
        }



        /* =========================================================
           DETAILS GRID
        ========================================================= */

        .detail-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);

            gap: 20px;

            align-items: start;
        }



        /* =========================================================
           DETAIL CARD
        ========================================================= */

        .detail-card {

            position:
                relative;

            min-width:
                0;

            overflow:
                hidden;

            padding:
                clamp(19px, 2vw, 24px);

            border-radius:
                var(--pd-radius-lg);

            background:
                rgba(255,255,255,.98);

            border:
                1px solid var(--pd-border);

            box-shadow:
                var(--pd-shadow);

            transition:
                transform .23s ease,
                box-shadow .23s ease,
                border-color .23s ease;
        }


        .detail-card:hover {

            border-color:
                #d4e2f4;

            box-shadow:
                var(--pd-shadow-hover);
        }


        .detail-card.full {

            grid-column:
                1 / -1;
        }


        .detail-card::before {

            content: "";

            position:
                absolute;

            left: 0;
            top: 0;

            width: 100%;
            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    var(--pd-primary),
                    var(--pd-indigo)
                );

            opacity: .82;
        }



        /* =========================================================
           SECTION TITLE
        ========================================================= */

        .section-title {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            margin:
                0 0 16px;

            color:
                var(--pd-text);

            font-size:
                15px;

            font-weight:
                850;

            letter-spacing:
                -.15px;
        }


        .section-title i {

            width:
                34px;

            height:
                34px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            flex-shrink:
                0;

            border-radius:
                10px;

            color:
                var(--pd-primary);

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #e8f0ff
                );

            border:
                1px solid var(--pd-blue-border);

            box-shadow:
                0 5px 14px rgba(37,99,235,.07);

            font-size:
                12px;
        }



        /* =========================================================
           INFO ROW
        ========================================================= */

        .info-row {

            display:
                flex;

            align-items:
                flex-start;

            justify-content:
                space-between;

            gap:
                22px;

            padding:
                12px 0;

            border-bottom:
                1px solid var(--pd-border-soft);
        }


        .info-row:last-child {
            border-bottom: 0;
        }


        .info-label {

            flex-shrink:
                0;

            color:
                var(--pd-muted);

            font-size:
                11px;

            font-weight:
                600;

            line-height:
                1.5;
        }


        .info-value {

            max-width:
                68%;

            color:
                var(--pd-text-2);

            font-size:
                12px;

            font-weight:
                750;

            line-height:
                1.55;

            text-align:
                right;

            word-break:
                break-word;
        }



        /* =========================================================
           PAYMENT STATUS
        ========================================================= */

        .payment-status-value {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                6px;

            padding:
                5px 10px;

            border-radius:
                999px;

            color:
                var(--pd-primary);

            background:
                var(--pd-blue-light);

            border:
                1px solid var(--pd-blue-border);

            font-size:
                10px;

            font-weight:
                850;

            white-space:
                nowrap;
        }



        /* =========================================================
           AMOUNT
        ========================================================= */

        .amount-value {

            color:
                var(--pd-primary);

            font-size:
                14px;

            font-weight:
                900;

            white-space:
                nowrap;
        }



        /* =========================================================
           PRODUCTS
        ========================================================= */

        .product-list {

            margin-top:
                2px;
        }


        .product-item {

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

            min-width:
                0;

            padding:
                13px 0;

            border-bottom:
                1px solid var(--pd-border-soft);
        }


        .product-item:last-child {
            border-bottom: 0;
        }


        .product-image,
        .product-placeholder {

            width:
                62px;

            height:
                62px;

            flex-shrink:
                0;

            border-radius:
                13px;
        }


        .product-image {

            display:
                block;

            object-fit:
                cover;

            border:
                1px solid #dfe7f1;

            background:
                #ffffff;

            box-shadow:
                0 5px 16px rgba(15,23,42,.06);
        }


        .product-placeholder {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                var(--pd-primary);

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #e8f0ff
                );

            border:
                1px solid var(--pd-blue-border);

            font-size:
                16px;
        }


        .product-content {

            min-width:
                0;

            flex:
                1;
        }


        .product-name {

            color:
                var(--pd-text);

            font-size:
                13px;

            font-weight:
                800;

            line-height:
                1.4;

            overflow:
                hidden;

            text-overflow:
                ellipsis;

            white-space:
                nowrap;
        }


        .product-meta {

            display:
                flex;

            align-items:
                center;

            flex-wrap:
                wrap;

            gap:
                7px;

            margin-top:
                6px;

            color:
                var(--pd-muted);

            font-size:
                11px;

            font-weight:
                600;
        }


        .product-price {

            color:
                var(--pd-primary);

            font-weight:
                850;
        }


        .product-quantity {

            color:
                var(--pd-muted);

            background:
                #f8fafc;

            border:
                1px solid var(--pd-border);

            padding:
                2px 8px;

            border-radius:
                999px;

            font-size:
                9px;

            font-weight:
                750;
        }



        /* =========================================================
           SECURITY BOX
        ========================================================= */

        .secure-box {

            display:
                flex;

            align-items:
                flex-start;

            gap:
                12px;

            margin-top:
                19px;

            padding:
                14px 15px;

            border-radius:
                14px;

            color:
                var(--pd-muted);

            background:
                linear-gradient(
                    135deg,
                    #f0f8ff,
                    #f8fbff
                );

            border:
                1px solid #d9eaff;

            font-size:
                11px;

            line-height:
                1.6;

            font-weight:
                550;
        }


        .secure-box i {

            width:
                30px;

            height:
                30px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            flex-shrink:
                0;

            border-radius:
                9px;

            color:
                var(--pd-primary);

            background:
                #ffffff;

            border:
                1px solid var(--pd-blue-border);

            box-shadow:
                0 4px 12px rgba(37,99,235,.05);

            font-size:
                13px;
        }



        /* =========================================================
           EMPTY PRODUCTS
        ========================================================= */

        .empty-products {

            padding:
                30px 15px;

            text-align:
                center;

            border-radius:
                14px;

            color:
                var(--pd-muted);

            background:
                #f8fafc;

            border:
                1px dashed #dbe3ed;

            font-size:
                11px;
        }


        .empty-products i {

            display:
                block;

            margin-bottom:
                8px;

            color:
                var(--pd-muted-2);

            font-size:
                22px;
        }



        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1050px) {

            .payment-detail-page {

                padding-left:
                    18px;

                padding-right:
                    18px;
            }


            .detail-grid {

                gap:
                    16px;
            }

        }



        /* =========================================================
           SMALL TABLET
        ========================================================= */

        @media (max-width: 850px) {

            .detail-grid {

                grid-template-columns:
                    1fr;
            }


            .detail-card.full {

                grid-column:
                    auto;
            }


            .hero-card {

                padding:
                    24px;
            }


            .hero-amount-wrap {

                margin-top:
                    20px;

                text-align:
                    left;
            }

        }



        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 700px) {

            .payment-detail-page {

                padding:
                    16px 12px 50px;
            }


            .top-bar {

                flex-direction:
                    column;

                align-items:
                    stretch;

                gap:
                    9px;
            }


            .back-btn,
            .receipt-btn {

                width:
                    100%;
            }


            .hero-card {

                padding:
                    22px 18px;

                border-radius:
                    20px;
            }


            .hero-title {

                font-size:
                    25px;
            }


            .hero-order {

                font-size:
                    11px;

                line-height:
                    1.6;
            }


            .hero-amount {

                font-size:
                    31px;
            }


            .detail-grid {

                gap:
                    13px;
            }


            .detail-card {

                padding:
                    18px 16px;

                border-radius:
                    17px;
            }


            .section-title {

                font-size:
                    14px;
            }


            .info-row {

                flex-direction:
                    column;

                gap:
                    5px;
            }


            .info-value {

                max-width:
                    100%;

                text-align:
                    left;
            }


            .product-image,
            .product-placeholder {

                width:
                    53px;

                height:
                    53px;

                border-radius:
                    11px;
            }


            .product-name {

                font-size:
                    12px;
            }


            .secure-box {

                font-size:
                    10px;
            }

        }



        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 430px) {

            .payment-detail-page {

                padding-left:
                    9px;

                padding-right:
                    9px;
            }


            .hero-card {

                padding:
                    20px 15px;

                border-radius:
                    18px;
            }


            .hero-title {

                font-size:
                    22px;
            }


            .hero-amount {

                font-size:
                    28px;
            }


            .status-pill {

                font-size:
                    9px;

                padding:
                    6px 10px;
            }


            .detail-card {

                padding:
                    17px 14px;
            }


            .product-item {

                gap:
                    10px;
            }


            .product-image,
            .product-placeholder {

                width:
                    48px;

                height:
                    48px;

                border-radius:
                    10px;
            }


            .product-meta {

                font-size:
                    10px;
            }


            .secure-box {

                padding:
                    12px;
            }

        }



        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .payment-detail-page *,
            .payment-detail-page *::before,
            .payment-detail-page *::after {

                transition:
                    none !important;

                animation:
                    none !important;
            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         COMMON SELLER TOPBAR
    ====================================================== --}}

    @include('seller.partials.topbar')


    {{-- =====================================================
         SELLER MENU
    ====================================================== --}}

    @include('seller.partials.seller-menu')



    <main class="payment-detail-page">


        {{-- =====================================================
             TOP ACTION BAR
        ====================================================== --}}

        <div class="top-bar">


            {{-- PAYMENT HISTORY --}}

            <a
                href="{{ route('seller.payments.index') }}"
                class="back-btn"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Payment History

            </a>



            {{-- PAYMENT RECEIPT --}}

            <a
                href="{{ route('seller.payments.receipt', $order) }}"
                class="receipt-btn"
            >

                <i class="fa-solid fa-file-pdf"></i>

                Download Payment Receipt

            </a>


        </div>



        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="hero-card">

            <div class="hero-content">

                <div class="row align-items-center">


                    {{-- HERO INFORMATION --}}

                    <div class="col-md-7">

                        <div class="hero-label">

                            <i class="fa-solid fa-shield-halved"></i>

                            Smart Basket Payment

                        </div>


                        <h1 class="hero-title">
                            Payment Details
                        </h1>


                        <div class="hero-order">

                            Order

                            <strong>
                                #SB-{{ $order->id }}
                            </strong>

                            <span class="mx-1">
                                ·
                            </span>

                            {{ $order->created_at?->format('d M Y · h:i A') }}

                        </div>

                    </div>



                    {{-- HERO AMOUNT --}}

                    <div class="col-md-5">

                        <div class="hero-amount-wrap">

                            <div class="hero-amount-label">
                                Total Payment
                            </div>


                            <div class="hero-amount">

                                ₹{{ number_format((float)$order->total, 2) }}

                            </div>



                            @if($paymentStatus === 'Successful')

                                <span class="status-pill successful">

                                    <i class="fa-solid fa-circle-check"></i>

                                    Successful

                                </span>


                            @elseif($paymentStatus === 'Pending')

                                <span class="status-pill pending">

                                    <i class="fa-solid fa-clock"></i>

                                    Pending

                                </span>


                            @elseif($paymentStatus === 'Refunded')

                                <span class="status-pill refunded">

                                    <i class="fa-solid fa-rotate-left"></i>

                                    Refunded

                                </span>


                            @else

                                <span class="status-pill failed">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    {{ $paymentStatus }}

                                </span>

                            @endif

                        </div>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
             DETAILS GRID
        ====================================================== --}}

        <div class="detail-grid">



            {{-- =================================================
                 CUSTOMER INFORMATION
            ================================================== --}}

            <section class="detail-card">

                <h2 class="section-title">

                    <i class="fa-solid fa-user"></i>

                    Customer Information

                </h2>



                <div class="info-row">

                    <span class="info-label">
                        Customer Name
                    </span>

                    <span class="info-value">

                        {{ $customer?->name ?: $order->name ?: 'Guest Customer' }}

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Customer UID
                    </span>

                    <span class="info-value">

                        {{ $customer?->customer_uid ?: 'Not available' }}

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Mobile
                    </span>

                    <span class="info-value">

                        {{ $order->mobile ?: 'Not available' }}

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Address
                    </span>

                    <span class="info-value">

                        {{ $order->address ?: 'Not available' }}

                    </span>

                </div>

            </section>



            {{-- =================================================
                 PAYMENT INFORMATION
            ================================================== --}}

            <section class="detail-card">

                <h2 class="section-title">

                    <i class="fa-solid fa-credit-card"></i>

                    Payment Information

                </h2>



                <div class="info-row">

                    <span class="info-label">
                        Payment Method
                    </span>

                    <span class="info-value">

                        {{ $order->payment_method ?: 'Not recorded' }}

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Payment Status
                    </span>

                    <span class="info-value">

                        <span class="payment-status-value">

                            @if($paymentStatus === 'Successful')

                                <i class="fa-solid fa-circle-check"></i>

                            @elseif($paymentStatus === 'Pending')

                                <i class="fa-solid fa-clock"></i>

                            @elseif($paymentStatus === 'Refunded')

                                <i class="fa-solid fa-rotate-left"></i>

                            @else

                                <i class="fa-solid fa-circle-xmark"></i>

                            @endif

                            {{ $paymentStatus }}

                        </span>

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Order Amount
                    </span>

                    <span class="info-value amount-value">

                        ₹{{ number_format((float)$order->total, 2) }}

                    </span>

                </div>



                <div class="info-row">

                    <span class="info-label">
                        Payment Date
                    </span>

                    <span class="info-value">

                        {{ $order->created_at?->format('d M Y · h:i A') ?: 'Not available' }}

                    </span>

                </div>

            </section>



            {{-- =================================================
                 SELLER PRODUCTS
            ================================================== --}}

            <section class="detail-card full">

                <h2 class="section-title">

                    <i class="fa-solid fa-box-open"></i>

                    Seller Products

                </h2>



                <div class="product-list">

                    @forelse($sellerItems as $item)

                        @php

                            $product =
                                $products[
                                    $item['product_id'] ?? null
                                ] ?? null;

                        @endphp



                        <div class="product-item">


                            {{-- PRODUCT IMAGE --}}

                            @if($product?->image)

                                <img
                                    class="product-image"
                                    src="{{ asset('products/'.$product->image) }}"
                                    alt="{{ $item['name'] ?? 'Product' }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="product-placeholder">

                                    <i class="fa-solid fa-box"></i>

                                </div>

                            @endif



                            {{-- PRODUCT CONTENT --}}

                            <div class="product-content">

                                <div class="product-name">

                                    {{ $item['name'] ?? $product?->name ?? 'Product' }}

                                </div>



                                <div class="product-meta">

                                    <span class="product-price">

                                        ₹{{ number_format((float)($item['price'] ?? 0), 2) }}

                                    </span>


                                    <span>
                                        ·
                                    </span>


                                    <span class="product-quantity">

                                        Quantity:
                                        {{ $item['quantity'] ?? 1 }}

                                    </span>

                                </div>

                            </div>


                        </div>


                    @empty


                        <div class="empty-products">

                            <i class="fa-solid fa-box-open"></i>

                            No seller products found.

                        </div>


                    @endforelse

                </div>



                {{-- SECURITY INFORMATION --}}

                <div class="secure-box">

                    <i class="fa-solid fa-shield-halved"></i>

                    <span>

                        This payment information belongs to the
                        current seller's order records. Receipt
                        generation is handled securely by
                        Smart Basket.

                    </span>

                </div>

            </section>


        </div>


    </main>



</body>

</html>
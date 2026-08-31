<!doctype html>
<html lang="en" data-sb-theme="dark">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Payment #SB-{{ $order->id }} | Smart Basket
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #020617 !important;
            color: #fff !important;
        }

        body {
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(0,255,153,.08),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 15%,
                    rgba(56,189,248,.07),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #020617,
                    #000 55%,
                    #07111d
                ) !important;
        }

        .payment-detail-page {
            width: min(1100px, calc(100% - 30px));
            margin: auto;
            padding: 35px 0 70px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .back-btn,
        .receipt-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 15px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            transition: .25s ease;
        }

        .back-btn {
            color: #94a3b8;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.03);
        }

        .back-btn:hover {
            color: #fff;
            border-color: rgba(255,255,255,.2);
            transform: translateY(-2px);
        }

        .receipt-btn {
            color: #00150c;
            background: linear-gradient(135deg,#00ff99,#00c878);
            border: 0;
        }

        .receipt-btn:hover {
            color: #00150c;
            transform: translateY(-2px);
            box-shadow: 0 0 28px rgba(0,255,153,.25);
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            margin-bottom: 20px;
            border-radius: 25px;
            background:
                linear-gradient(
                    145deg,
                    rgba(0,255,153,.08),
                    rgba(5,10,17,.97) 60%
                );
            border: 1px solid rgba(0,255,153,.18);
            box-shadow: 0 25px 65px rgba(0,0,0,.45);
        }

        .hero-card::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            right: -100px;
            top: -110px;
            border-radius: 50%;
            background: rgba(0,255,153,.07);
            filter: blur(8px);
        }

        .hero-label {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .hero-title {
            margin: 7px 0 5px;
            color: #fff;
            font-size: 31px;
            font-weight: 900;
        }

        .hero-order {
            color: #64748b;
            font-size: 13px;
        }

        .hero-amount {
            position: relative;
            z-index: 2;
            color: #00ff99;
            font-size: 38px;
            font-weight: 900;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            padding: 7px 13px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 850;
        }

        .successful {
            color: #00ff99;
            background: rgba(0,255,153,.1);
            border: 1px solid rgba(0,255,153,.25);
        }

        .pending {
            color: #ffc107;
            background: rgba(255,193,7,.1);
            border: 1px solid rgba(255,193,7,.25);
        }

        .failed {
            color: #ff7070;
            background: rgba(255,70,70,.1);
            border: 1px solid rgba(255,70,70,.25);
        }

        .refunded {
            color: #c084fc;
            background: rgba(192,132,252,.1);
            border: 1px solid rgba(192,132,252,.25);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-card {
            padding: 23px;
            border-radius: 21px;
            background: rgba(7,13,22,.95);
            border: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 18px 45px rgba(0,0,0,.35);
        }

        .detail-card.full {
            grid-column: span 2;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 18px;
            color: #fff;
            font-size: 16px;
            font-weight: 850;
        }

        .section-title i {
            color: #00ff99;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .info-row:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: #64748b;
            font-size: 12px;
        }

        .info-value {
            color: #e5e7eb;
            font-size: 13px;
            font-weight: 700;
            text-align: right;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .product-item:last-child {
            border-bottom: 0;
        }

        .product-image {
            width: 58px;
            height: 58px;
            object-fit: cover;
            border-radius: 13px;
            border: 1px solid rgba(255,255,255,.1);
        }

        .product-placeholder {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #111827;
            color: #475569;
        }

        .product-name {
            color: #fff;
            font-size: 14px;
            font-weight: 800;
        }

        .product-meta {
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
        }

        .secure-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            padding: 14px;
            border-radius: 14px;
            color: #94a3b8;
            background: rgba(56,189,248,.04);
            border: 1px solid rgba(56,189,248,.12);
            font-size: 12px;
        }

        .secure-box i {
            color: #38bdf8;
            font-size: 20px;
        }

        @media(max-width:750px) {

            .payment-detail-page {
                width: calc(100% - 22px);
                padding-top: 22px;
            }

            .top-bar {
                align-items: stretch;
                flex-direction: column;
            }

            .back-btn,
            .receipt-btn {
                justify-content: center;
            }

            .hero-card {
                padding: 21px;
            }

            .hero-title {
                font-size: 25px;
            }

            .hero-amount {
                margin-top: 15px;
                font-size: 31px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-card.full {
                grid-column: span 1;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }
        }

    </style>

</head>

<body>

<main class="payment-detail-page">

    <div class="top-bar">

        <a
            href="{{ route('seller.payments.index') }}"
            class="back-btn"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Payment History
        </a>


        <a
            href="{{ route('seller.payments.receipt', $order) }}"
            class="receipt-btn"
        >
            <i class="fa-solid fa-file-pdf"></i>
            Download Payment Receipt
        </a>

    </div>


    {{-- HERO --}}

    <section class="hero-card">

        <div class="row align-items-center">

            <div class="col-md-7">

                <div class="hero-label">
                    Smart Basket Payment
                </div>

                <h1 class="hero-title">
                    Payment Details
                </h1>

                <div class="hero-order">
                    Order #SB-{{ $order->id }}
                    ·
                    {{ $order->created_at?->format('d M Y · h:i A') }}
                </div>

            </div>


            <div class="col-md-5 text-md-end">

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

    </section>


    <div class="detail-grid">


        {{-- CUSTOMER --}}

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


        {{-- PAYMENT --}}

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
                    {{ $paymentStatus }}
                </span>

            </div>

            <div class="info-row">

                <span class="info-label">
                    Order Amount
                </span>

                <span class="info-value">
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


        {{-- PRODUCTS --}}

        <section class="detail-card full">

            <h2 class="section-title">
                <i class="fa-solid fa-box-open"></i>
                Seller Products
            </h2>


            @forelse($sellerItems as $item)

                @php
                    $product =
                        $products[$item['product_id'] ?? null] ?? null;
                @endphp


                <div class="product-item">

                    @if($product?->image)

                        <img
                            class="product-image"
                            src="{{ asset('products/'.$product->image) }}"
                            alt="{{ $item['name'] ?? 'Product' }}"
                        >

                    @else

                        <div class="product-placeholder">
                            <i class="fa-solid fa-box"></i>
                        </div>

                    @endif


                    <div>

                        <div class="product-name">
                            {{ $item['name'] ?? $product?->name ?? 'Product' }}
                        </div>

                        <div class="product-meta">

                            ₹{{ number_format((float)($item['price'] ?? 0), 2) }}

                            ·

                            Quantity:
                            {{ $item['quantity'] ?? 1 }}

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-secondary">
                    No seller products found.
                </div>

            @endforelse


            <div class="secure-box">

                <i class="fa-solid fa-shield-halved"></i>

                <span>
                    This payment information belongs to the current seller's
                    order records. Receipt generation is handled securely by
                    Smart Basket.
                </span>

            </div>

        </section>

    </div>

</main>

</body>

    @include('seller.partials.seller-menu')
</html>
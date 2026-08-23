<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Payment History | Smart Basket Seller
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


        body {

            margin: 0;

            min-height: 100vh;

            background:

                radial-gradient(
                    circle at 10% 10%,
                    rgba(0,255,153,.07),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 20%,
                    rgba(0,150,255,.05),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #020617,
                    #000000 55%,
                    #07111d
                ) !important;

            color: #fff !important;

        }


        .payment-page {

            max-width: 1100px;

            margin: auto;

            padding:
                35px 20px 60px;

        }


        /* HEADER */

        .payment-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 28px;

        }


        .payment-title {

            font-size: 30px;

            font-weight: 800;

            margin: 0;

            color: #fff;

        }


        .payment-title i {

            color: #00ff99;

            margin-right: 8px;

        }


        .payment-subtitle {

            color: #94a3b8;

            margin: 6px 0 0;

            font-size: 14px;

        }


        /* ORDERS BUTTON */

        .orders-btn {

            background:
                rgba(0,0,0,.45);

            border:
                1px solid rgba(0,255,153,.35);

            color: #00ff99;

            border-radius: 12px;

            padding: 10px 17px;

            font-weight: 700;

            text-decoration: none;

            transition: .25s;

        }


        .orders-btn:hover {

            background:
                rgba(0,255,153,.10);

            border-color: #00ff99;

            color: #fff;

            transform:
                translateY(-2px);

        }


        /* TOTAL */

        .total-card {

            background:

                linear-gradient(
                    145deg,
                    rgba(12,25,28,.98),
                    rgba(2,6,23,.98)
                );

            border:
                1px solid rgba(0,255,153,.25);

            border-radius: 22px;

            padding: 25px;

            margin-bottom: 20px;

            box-shadow:
                0 20px 50px rgba(0,0,0,.45);

        }


        .total-label {

            color: #94a3b8;

            font-size: 13px;

            font-weight: 600;

        }


        .total-value {

            display: block;

            color: #00ff99;

            font-size: 34px;

            font-weight: 800;

            margin-top: 5px;

        }


        /* FILTER */

        .filter-card {

            background:
                rgba(7,12,19,.96);

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 20px;

            padding: 18px;

            margin-bottom: 20px;

        }


        .form-control,
        .form-select {

            background:
                #080d14 !important;

            border:
                1px solid rgba(255,255,255,.10) !important;

            color:
                #fff !important;

            border-radius: 11px;

            min-height: 45px;

        }


        .form-control::placeholder {

            color: #64748b !important;

        }


        .form-control:focus,
        .form-select:focus {

            background:
                #080d14 !important;

            color: #fff !important;

            border-color:
                #00ff99 !important;

            box-shadow:
                0 0 0 3px
                rgba(0,255,153,.08) !important;

        }


        .form-select option {

            background: #080d14;

            color: #fff;

        }


        input[type="date"] {

            color-scheme: dark;

        }


        .filter-button {

            min-height: 45px;

            border: 0;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #00ff99,
                    #00c878
                );

            color: #00150c;

            font-weight: 800;

        }


        /* PAYMENT LIST */

        .payments-card {

            overflow: hidden;

            background:
                rgba(5,10,17,.97);

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 22px;

            box-shadow:
                0 20px 55px rgba(0,0,0,.50);

        }


        .payment-row {

            padding: 23px;

            border-bottom:
                1px solid rgba(255,255,255,.07);

            transition: .25s;

        }


        .payment-row:last-child {

            border-bottom: 0;

        }


        .payment-row:hover {

            background:
                rgba(0,255,153,.025);

        }


        /* CUSTOMER */

        .customer-name {

            color: #fff;

            font-size: 16px;

            font-weight: 750;

        }


        .customer-name i {

            color: #00ff99;

            margin-right: 5px;

        }


        .customer-uid {

            color: #38bdf8;

            font-size: 12px;

            margin-top: 4px;

        }


        .order-meta {

            color: #64748b;

            font-size: 12px;

            margin-top: 3px;

        }


        /* AMOUNT */

        .payment-amount {

            color: #00ff99;

            font-size: 20px;

            font-weight: 800;

        }


        /* STATUS */

        .payment-status {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 10px;

            border-radius: 30px;

            font-size: 11px;

            font-weight: 800;

            margin-top: 4px;

        }


        .status-successful {

            background:
                rgba(0,255,153,.10);

            color:
                #00ff99;

            border:
                1px solid rgba(0,255,153,.25);

        }


        .status-pending {

            background:
                rgba(255,193,7,.10);

            color:
                #ffc107;

            border:
                1px solid rgba(255,193,7,.25);

        }


        .status-failed {

            background:
                rgba(255,70,70,.10);

            color:
                #ff7070;

            border:
                1px solid rgba(255,70,70,.25);

        }


        /* PRODUCTS */

        .product-line {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-top: 10px;

            color: #d1d5db;

            font-size: 13px;

        }


        .product-line img {

            width: 42px;

            height: 42px;

            object-fit: cover;

            border-radius: 10px;

            border:
                1px solid rgba(255,255,255,.10);

        }


        .product-placeholder {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background: #111827;

            color: #475569;

        }


        /* PAYMENT INFO */

        .payment-method {

            color: #94a3b8;

            font-size: 12px;

            margin-top: 10px;

        }


        .transaction-text {

            color: #64748b;

        }


        /* VIEW PAYMENT */

        .view-payment-btn {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            margin-top: 12px;

            padding: 7px 13px;

            border-radius: 9px;

            border:
                1px solid rgba(56,189,248,.35);

            color: #38bdf8;

            background:
                rgba(56,189,248,.05);

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;

        }


        .view-payment-btn:hover {

            color: #fff;

            background:
                rgba(56,189,248,.12);

            border-color:
                #38bdf8;

        }


        /* BLUE RECEIPT BUTTON */

        .receipt-download-btn {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 12px;

            margin-left: 7px;

            padding: 7px 14px;

            border-radius: 9px;

            border:
                1px solid rgba(59,130,246,.55);

            background:
                rgba(37,99,235,.10);

            color:
                #60a5fa;

            text-decoration: none;

            font-size: 12px;

            font-weight: 800;

            transition: .22s ease;

        }


        .receipt-download-btn:hover {

            background:
                #2563eb;

            border-color:
                #60a5fa;

            color:
                #fff;

            transform:
                translateY(-2px);

            box-shadow:
                0 0 20px rgba(37,99,235,.25);

        }


        /* EMPTY */

        .empty-payment {

            padding:
                65px 25px;

            text-align: center;

            background:
                linear-gradient(
                    145deg,
                    #0f172a,
                    #020617
                );

            color:
                #94a3b8;

        }


        .empty-payment i {

            color:
                #00ff99;

            font-size:
                42px;

            margin-bottom:
                15px;

        }


        .empty-payment h5 {

            color:
                #fff;

            font-weight:
                750;

        }


        /* MOBILE */

        @media(max-width:700px) {

            .payment-page {

                padding:
                    25px 14px 45px;

            }


            .payment-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;

            }


            .payment-title {

                font-size:
                    25px;

            }


            .payment-row-top {

                flex-direction:
                    column !important;

            }


            .payment-amount-box {

                text-align:
                    left !important;

            }


            .receipt-download-btn {

                margin-left:
                    0;

            }

        }

    </style>

</head>


<body>


<main class="payment-page">


    {{-- HEADER --}}

    <div class="payment-header">

        <div>

            <h1 class="payment-title">

                <i class="fa-solid fa-wallet"></i>

                Payment History

            </h1>


            <p class="payment-subtitle">

                Customer payments for

                <strong class="text-white">

                    {{ $seller->shop_name ?: $seller->seller_name }}

                </strong>

            </p>

        </div>


        <a
            href="{{ route('seller.orders.index') }}"
            class="orders-btn"
        >

            <i class="fa-solid fa-box-open me-1"></i>

            Orders

        </a>

    </div>


    {{-- TOTAL --}}

    <div class="total-card">

        <span class="total-label">

            <i class="fa-solid fa-arrow-trend-up me-1"></i>

            TOTAL RECEIVED

        </span>


        <strong class="total-value">

            ₹{{ number_format(
                $summary['received'],
                2
            ) }}

        </strong>

    </div>


    {{-- FILTER --}}

    <form
        class="filter-card"
        method="GET"
    >

        <div class="row g-2">


            <div class="col-md-4">

                <input
                    class="form-control"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Customer, UID, order or product"
                >

            </div>


            <div class="col-md-2">

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
                            @selected(
                                request('status') === $value
                            )
                        >

                            {{ $value }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

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
                            @selected(
                                request('method') === $value
                            )
                        >

                            {{ $value }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <input
                    class="form-control"
                    type="date"
                    name="from"
                    value="{{ request('from') }}"
                >

            </div>


            <div class="col-md-2">

                <button
                    class="filter-button w-100"
                    type="submit"
                >

                    <i class="fa-solid fa-filter me-1"></i>

                    Filter

                </button>

            </div>

        </div>

    </form>


    {{-- PAYMENTS --}}

    <div class="payments-card">


        @forelse($orders as $order)


            @php

                $status =
                    app(
                        \App\Http\Controllers\SellerPaymentController::class
                    )->status($order);

                $customer = $order->user;

            @endphp


            <div class="payment-row">


                <div
                    class="d-flex justify-content-between gap-4 payment-row-top"
                >


                    {{-- CUSTOMER --}}

                    <div>

                        <div class="customer-name">

                            <i class="fa-solid fa-user"></i>

                            {{ $customer?->name ?: $order->name }}

                        </div>


                        <div class="customer-uid">

                            Customer UID:

                            {{ $customer?->customer_uid
                                ?: 'Guest checkout — no customer UID'
                            }}

                        </div>


                        <div class="order-meta">

                            <i class="fa-solid fa-receipt me-1"></i>

                            Order #SB-{{ $order->id }}

                            <span class="mx-1">·</span>

                            {{ $order->created_at?->format(
                                'd M Y · h:i A'
                            ) }}

                        </div>

                    </div>


                    {{-- AMOUNT --}}

                    <div class="payment-amount-box text-end">

                        <div class="payment-amount">

                            ₹{{ number_format(
                                $order->total,
                                2
                            ) }}

                        </div>


                        @if($status === 'Successful')

                            <span
                                class="payment-status status-successful"
                            >

                                <i class="fa-solid fa-circle-check"></i>

                                Successful

                            </span>

                        @elseif($status === 'Pending')

                            <span
                                class="payment-status status-pending"
                            >

                                <i class="fa-solid fa-clock"></i>

                                Pending

                            </span>

                        @else

                            <span
                                class="payment-status status-failed"
                            >

                                <i class="fa-solid fa-circle-xmark"></i>

                                {{ $status }}

                            </span>

                        @endif

                    </div>

                </div>


                {{-- PRODUCTS --}}

                <div class="mt-3">

                    @forelse(
                        $order->seller_items
                        as $item
                    )

                        @php

                            $product =
                                $order->seller_products[
                                    $item['product_id'] ?? null
                                ] ?? null;

                        @endphp


                        <div class="product-line">


                            @if($product?->image)

                                <img
                                    src="{{ asset(
                                        'products/'.$product->image
                                    ) }}"
                                    alt=""
                                >

                            @else

                                <div
                                    class="product-placeholder"
                                >

                                    <i
                                        class="fa-solid fa-box"
                                    ></i>

                                </div>

                            @endif


                            <span>

                                {{ $item['name']
                                    ?? $product?->name
                                    ?? 'Product'
                                }}

                                ×

                                {{ $item['quantity'] ?? 1 }}

                            </span>

                        </div>


                    @empty

                        <span
                            class="small transaction-text"
                        >

                            Product details unavailable
                            for this legacy order.

                        </span>

                    @endforelse

                </div>


                {{-- PAYMENT METHOD --}}

                <div class="payment-method">

                    <i class="fa-solid fa-credit-card me-1"></i>

                    {{ $order->payment_method
                        ?: 'Not recorded'
                    }}

                    <span class="transaction-text">

                        · Transaction reference:
                        not available in current records

                    </span>

                </div>


                {{-- ACTIONS --}}

                <div>


                    {{-- VIEW PAYMENT --}}

                    <a
                        class="view-payment-btn"
                        href="{{ route(
                            'seller.payments.show',
                            $order
                        ) }}"
                    >

                        <i class="fa-solid fa-eye"></i>

                        View Payment

                    </a>


                    {{-- DOWNLOAD RECEIPT --}}

                    @if($status === 'Successful')

                        <a
                            class="receipt-download-btn"
                            href="{{ route(
                                'seller.payments.receipt',
                                $order
                            ) }}"
                        >

                            <i
                                class="fa-solid fa-file-arrow-down"
                            ></i>

                            Download Receipt

                        </a>

                    @endif


                </div>


            </div>


        @empty


            <div class="empty-payment">

                <i class="fa-solid fa-wallet"></i>

                <h5>
                    No Customer Payments
                </h5>

                <p class="mb-0">

                    No customer payment records
                    match these filters.

                </p>

            </div>


        @endforelse


    </div>


</main>


</body>

</html>
<!doctype html>
<html lang="en" data-sb-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment History | Smart Basket Seller</title>

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
                radial-gradient(circle at 10% 10%, rgba(0,255,153,.08), transparent 30%),
                radial-gradient(circle at 90% 15%, rgba(56,189,248,.07), transparent 30%),
                linear-gradient(135deg, #020617, #000 55%, #07111d) !important;
        }

        .payment-page {
            width: min(1150px, calc(100% - 30px));
            margin: auto;
            padding: 35px 0 70px;
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .payment-title {
            margin: 0;
            font-size: 31px;
            font-weight: 850;
            color: #fff;
        }

        .payment-title i {
            color: #00ff99;
            margin-right: 9px;
        }

        .payment-subtitle {
            margin: 7px 0 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .premium-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 17px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            transition: .25s ease;
        }

        .btn-outline-premium {
            color: #00ff99;
            background: rgba(0,255,153,.04);
            border: 1px solid rgba(0,255,153,.3);
        }

        .btn-outline-premium:hover {
            color: #fff;
            background: rgba(0,255,153,.11);
            border-color: #00ff99;
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0,255,153,.15);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1.4fr repeat(4, 1fr);
            gap: 13px;
            margin-bottom: 20px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            padding: 20px;
            border-radius: 18px;
            background: rgba(8,15,25,.92);
            border: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 15px 45px rgba(0,0,0,.3);
        }

        .summary-card.received {
            background: linear-gradient(145deg, rgba(0,255,153,.10), rgba(4,12,20,.96));
            border-color: rgba(0,255,153,.25);
        }

        .summary-label {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .summary-value {
            display: block;
            margin-top: 7px;
            color: #fff;
            font-size: 23px;
            font-weight: 850;
        }

        .received .summary-value {
            color: #00ff99;
            font-size: 29px;
        }

        .summary-icon {
            position: absolute;
            right: 17px;
            top: 17px;
            color: rgba(255,255,255,.12);
            font-size: 25px;
        }

        .filter-card {
            padding: 18px;
            margin-bottom: 20px;
            border-radius: 20px;
            background: rgba(8,13,22,.94);
            border: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 15px 40px rgba(0,0,0,.3);
        }

        .form-control,
        .form-select {
            min-height: 45px;
            background: #070d15 !important;
            color: #fff !important;
            border: 1px solid rgba(255,255,255,.1) !important;
            border-radius: 11px;
        }

        .form-control::placeholder {
            color: #64748b !important;
        }

        .form-control:focus,
        .form-select:focus {
            background: #070d15 !important;
            color: #fff !important;
            border-color: #00ff99 !important;
            box-shadow: 0 0 0 3px rgba(0,255,153,.08) !important;
        }

        .form-select option {
            background: #070d15;
            color: #fff;
        }

        input[type="date"] {
            color-scheme: dark;
        }

        .filter-btn {
            width: 100%;
            min-height: 45px;
            border: 0;
            border-radius: 11px;
            background: linear-gradient(135deg,#00ff99,#00c878);
            color: #00150c;
            font-weight: 850;
            transition: .25s ease;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0,255,153,.25);
        }

        .payments-card {
            overflow: hidden;
            border-radius: 22px;
            background: rgba(4,9,16,.97);
            border: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 20px 55px rgba(0,0,0,.5);
        }

        .payment-row {
            padding: 23px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            transition: .25s ease;
        }

        .payment-row:last-child {
            border-bottom: 0;
        }

        .payment-row:hover {
            background: rgba(0,255,153,.025);
        }

        .customer-name {
            color: #fff;
            font-size: 16px;
            font-weight: 800;
        }

        .customer-icon {
            color: #00ff99;
            margin-right: 5px;
        }

        .customer-uid {
            margin-top: 4px;
            color: #38bdf8;
            font-size: 12px;
        }

        .order-meta {
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
        }

        .payment-amount {
            color: #00ff99;
            font-size: 21px;
            font-weight: 850;
        }

        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 850;
        }

        .status-successful {
            color: #00ff99;
            background: rgba(0,255,153,.09);
            border: 1px solid rgba(0,255,153,.25);
        }

        .status-pending {
            color: #ffc107;
            background: rgba(255,193,7,.09);
            border: 1px solid rgba(255,193,7,.25);
        }

        .status-failed {
            color: #ff7070;
            background: rgba(255,70,70,.09);
            border: 1px solid rgba(255,70,70,.25);
        }

        .status-refunded {
            color: #c084fc;
            background: rgba(192,132,252,.09);
            border: 1px solid rgba(192,132,252,.25);
        }

        .product-line {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            color: #d1d5db;
            font-size: 13px;
        }

        .product-line img,
        .product-placeholder {
            width: 43px;
            height: 43px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.1);
        }

        .product-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111827;
            color: #475569;
        }

        .payment-method {
            margin-top: 12px;
            color: #94a3b8;
            font-size: 12px;
        }

        .transaction-text {
            color: #64748b;
        }

        .payment-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            transition: .2s ease;
        }

        .view-btn {
            color: #38bdf8;
            background: rgba(56,189,248,.05);
            border: 1px solid rgba(56,189,248,.3);
        }

        .view-btn:hover {
            color: #fff;
            background: rgba(56,189,248,.12);
            border-color: #38bdf8;
        }

        .receipt-btn {
            color: #00ff99;
            background: rgba(0,255,153,.05);
            border: 1px solid rgba(0,255,153,.3);
        }

        .receipt-btn:hover {
            color: #00150c;
            background: #00ff99;
            border-color: #00ff99;
            box-shadow: 0 0 20px rgba(0,255,153,.18);
        }

        .empty-payment {
            padding: 70px 25px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-payment i {
            display: block;
            margin-bottom: 15px;
            color: #00ff99;
            font-size: 45px;
        }

        .empty-payment h5 {
            color: #fff;
            font-weight: 800;
        }

        @media(max-width:900px) {
            .summary-grid {
                grid-template-columns: repeat(2,1fr);
            }

            .summary-card.received {
                grid-column: span 2;
            }
        }

        @media(max-width:650px) {
            .payment-page {
                width: calc(100% - 22px);
                padding-top: 22px;
            }

            .payment-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .payment-title {
                font-size: 25px;
            }

            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .summary-card.received {
                grid-column: span 2;
            }

            .payment-row {
                padding: 18px;
            }

            .payment-row-top {
                flex-direction: column;
            }

            .payment-amount-box {
                text-align: left !important;
            }
        }
    </style>
</head>

<body>

<main class="payment-page">

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

        <a href="{{ route('seller.dashboard') }}"
           class="premium-btn btn-outline-premium">
            <i class="fa-solid fa-arrow-left"></i>
            Dashboard
        </a>

    </div>


    {{-- SUMMARY --}}

    <div class="summary-grid">

        <div class="summary-card received">
            <span class="summary-label">
                Total Received
            </span>

            <strong class="summary-value">
                ₹{{ number_format($summary['received'], 2) }}
            </strong>

            <i class="fa-solid fa-money-bill-trend-up summary-icon"></i>
        </div>

        <div class="summary-card">
            <span class="summary-label">Successful</span>
            <strong class="summary-value">
                {{ $summary['successful'] }}
            </strong>
            <i class="fa-solid fa-circle-check summary-icon"></i>
        </div>

        <div class="summary-card">
            <span class="summary-label">Pending</span>
            <strong class="summary-value">
                {{ $summary['pending'] }}
            </strong>
            <i class="fa-solid fa-clock summary-icon"></i>
        </div>

        <div class="summary-card">
            <span class="summary-label">Failed</span>
            <strong class="summary-value">
                {{ $summary['failed'] }}
            </strong>
            <i class="fa-solid fa-circle-xmark summary-icon"></i>
        </div>

        <div class="summary-card">
            <span class="summary-label">Refunded</span>
            <strong class="summary-value">
                {{ $summary['refunded'] }}
            </strong>
            <i class="fa-solid fa-rotate-left summary-icon"></i>
        </div>

    </div>


    {{-- FILTERS --}}

    <form class="filter-card" method="GET">

        <div class="row g-2">

            <div class="col-lg-4 col-md-6">
                <input
                    class="form-control"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Customer, UID, order or product"
                >
            </div>

            <div class="col-lg-2 col-md-3">
                <select class="form-select" name="status">

                    <option value="">All statuses</option>

                    @foreach(['Successful','Pending','Failed','Refunded'] as $value)
                        <option
                            value="{{ $value }}"
                            @selected(request('status') === $value)
                        >
                            {{ $value }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-lg-2 col-md-3">
                <select class="form-select" name="method">

                    <option value="">All methods</option>

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

            <div class="col-lg-2 col-md-6">
                <input
                    class="form-control"
                    type="date"
                    name="from"
                    value="{{ request('from') }}"
                >
            </div>

            <div class="col-lg-2 col-md-6">
                <button class="filter-btn" type="submit">
                    <i class="fa-solid fa-filter me-1"></i>
                    Filter
                </button>
            </div>

        </div>

    </form>


    {{-- PAYMENT LIST --}}

    <div class="payments-card">

        @forelse($orders as $order)

            @php
                $status = app(\App\Http\Controllers\SellerPaymentController::class)
                    ->status($order);

                $customer = $order->user;
            @endphp

            <div class="payment-row">

                <div class="d-flex justify-content-between gap-4 payment-row-top">

                    <div>

                        <div class="customer-name">
                            <i class="fa-solid fa-user customer-icon"></i>
                            {{ $customer?->name ?: $order->name }}
                        </div>

                        <div class="customer-uid">
                            Customer UID:
                            {{ $customer?->customer_uid ?: 'Guest checkout — no customer UID' }}
                        </div>

                        <div class="order-meta">
                            <i class="fa-solid fa-receipt me-1"></i>
                            Order #SB-{{ $order->id }}
                            <span class="mx-1">·</span>
                            {{ $order->created_at?->format('d M Y · h:i A') }}
                        </div>

                    </div>

                    <div class="payment-amount-box text-end">

                        <div class="payment-amount">
                            ₹{{ number_format($order->total, 2) }}
                        </div>

                        @if($status === 'Successful')

                            <span class="payment-status status-successful">
                                <i class="fa-solid fa-circle-check"></i>
                                Successful
                            </span>

                        @elseif($status === 'Pending')

                            <span class="payment-status status-pending">
                                <i class="fa-solid fa-clock"></i>
                                Pending
                            </span>

                        @elseif($status === 'Refunded')

                            <span class="payment-status status-refunded">
                                <i class="fa-solid fa-rotate-left"></i>
                                Refunded
                            </span>

                        @else

                            <span class="payment-status status-failed">
                                <i class="fa-solid fa-circle-xmark"></i>
                                {{ $status }}
                            </span>

                        @endif

                    </div>

                </div>


                <div class="mt-3">

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
                                >

                            @else

                                <div class="product-placeholder">
                                    <i class="fa-solid fa-box"></i>
                                </div>

                            @endif

                            <span>
                                {{ $item['name'] ?? $product?->name ?? 'Product' }}
                                × {{ $item['quantity'] ?? 1 }}
                            </span>

                        </div>

                    @empty

                        <span class="small transaction-text">
                            Product details unavailable for this order.
                        </span>

                    @endforelse

                </div>


                <div class="payment-method">

                    <i class="fa-solid fa-credit-card me-1"></i>

                    {{ $order->payment_method ?: 'Not recorded' }}

                    <span class="transaction-text">
                        · Payment status: {{ $status }}
                    </span>

                </div>


                {{-- ACTION BUTTONS --}}

                <div class="payment-actions">

                    <a
                        class="action-btn view-btn"
                        href="{{ route('seller.payments.show', $order) }}"
                    >
                        <i class="fa-solid fa-eye"></i>
                        View Payment
                    </a>


                    <a
                        class="action-btn receipt-btn"
                        href="{{ route('seller.payments.receipt', $order) }}"
                    >
                        <i class="fa-solid fa-file-pdf"></i>
                        Payment Receipt
                    </a>

                </div>

            </div>

        @empty

            <div class="empty-payment">

                <i class="fa-solid fa-wallet"></i>

                <h5>
                    No Customer Payments
                </h5>

                <p class="mb-0">
                    No customer payment records match these filters.
                </p>

            </div>

        @endforelse

    </div>

</main>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Orders | Smart Basket</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: #fff;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(0,255,153,.10),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(59,130,246,.08),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #020617,
                    #05070b,
                    #0b1120
                );
        }

        .orders-page {
            min-height: 100vh;
            padding: 45px 20px 70px;
        }

        .orders-container {
            max-width: 1450px;
            margin: auto;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .header-left small {
            display: inline-block;
            color: #00ff99;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .header-left h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;

            background: linear-gradient(
                90deg,
                #ffffff,
                #00ff99
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-left p {
            margin: 8px 0 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .premium-btn {
            border-radius: 13px;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: .25s ease;
        }

        .premium-btn-dashboard {
            color: #fff;
            border: 1px solid rgba(255,255,255,.15);
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(15px);
        }

        .premium-btn-dashboard:hover {
            color: #00ff99;
            border-color: rgba(0,255,153,.45);
            transform: translateY(-2px);
        }

        /* =====================================================
           ALERTS
        ===================================================== */

        .premium-alert {
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(18px);
            color: #fff;
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        .premium-alert.success {
            border-color: rgba(0,255,153,.35);
            color: #00ff99;
        }

        .premium-alert.error {
            border-color: rgba(255,90,90,.35);
            color: #ff8585;
        }

        /* =====================================================
           CARD
        ===================================================== */

        .orders-card {
            overflow: hidden;
            border-radius: 24px;

            border: 1px solid rgba(255,255,255,.10);

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.075),
                    rgba(255,255,255,.025)
                );

            backdrop-filter: blur(25px);

            box-shadow:
                0 25px 70px rgba(0,0,0,.45),
                0 0 35px rgba(0,255,153,.04);
        }

        .orders-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 22px 24px;

            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .orders-card-title {
            display: flex;
            align-items: center;
            gap: 12px;

            font-size: 17px;
            font-weight: 750;
        }

        .orders-card-title-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            color: #00ff99;

            background: rgba(0,255,153,.10);

            border: 1px solid rgba(0,255,153,.18);
        }

        .order-count {
            padding: 7px 12px;
            border-radius: 20px;

            background: rgba(0,255,153,.08);

            border: 1px solid rgba(0,255,153,.16);

            color: #00ff99;

            font-size: 12px;
            font-weight: 700;
        }

        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrapper {
            overflow-x: auto;
        }

        .seller-order-table {
            width: 100%;
            margin: 0;
            color: #fff;
            min-width: 1150px;
        }

        .seller-order-table thead th {
            padding: 17px 20px;

            color: #64748b;

            background: rgba(0,0,0,.18);

            border-bottom: 1px solid rgba(255,255,255,.08);

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .8px;

            white-space: nowrap;
        }

        .seller-order-table tbody td {
            padding: 18px 20px;

            color: #e5e7eb;

            border-bottom: 1px solid rgba(255,255,255,.055);

            vertical-align: middle;

            font-size: 13px;
        }

        .seller-order-table tbody tr {
            transition: .22s ease;
        }

        .seller-order-table tbody tr:hover {
            background: rgba(0,255,153,.035);
        }

        .order-number {
            color: #fff;
            font-weight: 800;
        }

        .order-date {
            color: #64748b;
            font-size: 11px;
            margin-top: 4px;
        }

        .customer-name {
            color: #fff;
            font-weight: 700;
        }

        .customer-address {
            max-width: 220px;
            color: #64748b;
            font-size: 11px;
            margin-top: 4px;
        }

        .product-line {
            color: #cbd5e1;
            margin-bottom: 4px;
            font-size: 12px;
        }

        /* =====================================================
           PAYMENT STATUS
        ===================================================== */

        .payment-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 7px 11px;

            border-radius: 20px;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .payment-paid {
            background: rgba(0,255,153,.10);
            border: 1px solid rgba(0,255,153,.25);
            color: #00ff99;
        }

        .payment-pending {
            background: rgba(251,191,36,.10);
            border: 1px solid rgba(251,191,36,.25);
            color: #fbbf24;
        }

        .payment-failed {
            background: rgba(239,68,68,.10);
            border: 1px solid rgba(239,68,68,.25);
            color: #f87171;
        }

        .payment-cod {
            background: rgba(59,130,246,.10);
            border: 1px solid rgba(59,130,246,.20);
            color: #93c5fd;
        }

        .payment-method-small {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 10px;
        }

        /* =====================================================
           STATUS
        ===================================================== */

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 12px;

            border-radius: 20px;

            background: rgba(0,255,153,.08);

            border: 1px solid rgba(0,255,153,.18);

            color: #00ff99;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #00ff99;

            box-shadow: 0 0 10px rgba(0,255,153,.8);
        }

        .status-pending {
            background: rgba(251,191,36,.08);
            border-color: rgba(251,191,36,.20);
            color: #fbbf24;
        }

        .status-pending .status-dot {
            background: #fbbf24;
            box-shadow: 0 0 10px rgba(251,191,36,.7);
        }

        /* =====================================================
           PAYMENT VERIFIED LABEL
        ===================================================== */

        .payment-verified {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            margin-top: 5px;

            color: #00ff99;

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .payment-warning {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            margin-top: 5px;

            color: #fbbf24;

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* =====================================================
           ACTIONS
        ===================================================== */

        .order-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .action-btn {
            border-radius: 10px;
            padding: 8px 11px;

            border: 1px solid rgba(255,255,255,.10);

            font-size: 11px;
            font-weight: 700;

            transition: .2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-delivery {
            background: rgba(0,255,153,.08);
            color: #00ff99;
            border-color: rgba(0,255,153,.20);
        }

        .action-delivery:hover {
            background: rgba(0,255,153,.16);
            color: #00ff99;
        }

        .action-view {
            background: rgba(255,255,255,.06);
            color: #cbd5e1;
        }

        .action-view:hover {
            color: #fff;
            background: rgba(255,255,255,.11);
        }

        /* =====================================================
           EMPTY
        ===================================================== */

        .empty-orders {
            padding: 80px 30px;
            text-align: center;
            color: #64748b;
        }

        .empty-orders-icon {
            width: 75px;
            height: 75px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            border-radius: 22px;

            background: rgba(255,255,255,.05);

            border: 1px solid rgba(255,255,255,.08);

            font-size: 30px;
        }

        .empty-orders h3 {
            color: #e2e8f0;
            font-size: 18px;
            font-weight: 700;
        }

        /* =====================================================
           MODAL
        ===================================================== */

        .premium-modal {
            background:
                linear-gradient(
                    145deg,
                    #111827,
                    #05070b
                );

            color: #fff;

            border: 1px solid rgba(0,255,153,.18);

            border-radius: 22px;

            box-shadow:
                0 30px 90px rgba(0,0,0,.75);
        }

        .premium-modal .modal-header {
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding: 20px 24px;
        }

        .premium-modal .modal-footer {
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 16px 24px;
        }

        .premium-modal .modal-body {
            padding: 24px;
        }

        .premium-modal .form-label {
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
        }

        .premium-modal .form-control,
        .premium-modal .form-select {
            color: #fff;

            background: rgba(255,255,255,.055);

            border: 1px solid rgba(255,255,255,.12);

            border-radius: 11px;

            padding: 11px 13px;
        }

        .premium-modal .form-control:focus,
        .premium-modal .form-select:focus {
            color: #fff;

            background: rgba(255,255,255,.075);

            border-color: #00ff99;

            box-shadow: 0 0 0 .18rem rgba(0,255,153,.10);
        }

        .premium-modal .form-select option {
            background: #111827;
            color: #fff;
        }

        .delivery-profile {
            text-align: center;

            padding: 20px;

            border-radius: 18px;

            background: rgba(255,255,255,.035);

            border: 1px solid rgba(255,255,255,.07);
        }

        .delivery-profile img,
        .delivery-placeholder {
            width: 115px;
            height: 115px;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid rgba(0,255,153,.25);
        }

        .delivery-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto;

            background: #111827;

            color: #64748b;

            font-size: 40px;
        }

        .info-box {
            padding: 15px;

            border-radius: 14px;

            background: rgba(255,255,255,.035);

            border: 1px solid rgba(255,255,255,.07);

            height: 100%;
        }

        .info-label {
            color: #64748b;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .7px;

            margin-bottom: 4px;
        }

        .info-value {
            color: #e2e8f0;

            font-size: 13px;
            font-weight: 600;
        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 768px) {

            .orders-page {
                padding: 25px 12px 50px;
            }

            .orders-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-left h1 {
                font-size: 27px;
            }

            .header-actions {
                width: 100%;
            }

            .premium-btn {
                flex: 1;
                text-align: center;
            }

            .orders-card-header {
                align-items: flex-start;
                gap: 12px;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<main class="orders-page">

    <div class="orders-container">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="orders-header">

            <div class="header-left">

                <small>
                    SMART BASKET • SELLER PANEL
                </small>

                <h1>
                    <i class="fa-solid fa-box-open"></i>
                    Order Management
                </h1>

                <p>
                    Manage customer orders, payments and delivery partners.
                </p>

            </div>

            <div class="header-actions">

                <a
                    href="{{ route('seller.dashboard') }}"
                    class="premium-btn premium-btn-dashboard"
                >
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Dashboard
                </a>

            </div>

        </div>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div class="premium-alert success">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="premium-alert error">

                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="premium-alert error">

                <strong>
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    Please fix the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $err)

                        <li>{{ $err }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             ORDERS CARD
        ====================================================== --}}

        <section class="orders-card">

            <div class="orders-card-header">

                <div class="orders-card-title">

                    <span class="orders-card-title-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>

                    <span>
                        Seller Orders
                    </span>

                </div>

                <span class="order-count">
                    {{ $orders->count() }} Orders
                </span>

            </div>


            <div class="table-wrapper">

                <table class="seller-order-table">

                    <thead>

                        <tr>

                            <th>Order</th>

                            <th>Customer</th>

                            <th>Products</th>

                            <th>Payment</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($orders as $order)

                            @php

                                $delivery = $order->deliveryDetail;
                                $partner = $delivery?->deliveryPartner;

                                /*
                                 * IMPORTANT:
                                 * Only an order whose payment_status is Paid
                                 * is considered a completed online payment.
                                 */

                                $paymentStatus = strtolower(
                                    trim((string) ($order->payment_status ?? 'pending'))
                                );

                                $paymentMethod = strtoupper(
                                    trim((string) ($order->payment_method ?? 'COD'))
                                );

                                $isPaid = in_array(
                                    $paymentStatus,
                                    ['paid', 'captured', 'completed', 'success', 'successful'],
                                    true
                                );

                                $isFailed = in_array(
                                    $paymentStatus,
                                    ['failed', 'failure', 'cancelled', 'canceled'],
                                    true
                                );

                                $isCod = $paymentMethod === 'COD';

                            @endphp


                            <tr>

                                {{-- ORDER --}}

                                <td>

                                    <div class="order-number">
                                        #{{ $order->id }}
                                    </div>

                                    <div class="order-date">

                                        <i class="fa-regular fa-calendar me-1"></i>

                                        {{ $order->created_at?->format('d M Y') }}

                                    </div>

                                </td>


                                {{-- CUSTOMER --}}

                                <td>

                                    <div class="customer-name">
                                        {{ $order->name }}
                                    </div>

                                    <div class="customer-address">

                                        <i class="fa-solid fa-location-dot me-1"></i>

                                        {{ $order->address }}, {{ $order->city }}

                                    </div>

                                </td>


                                {{-- PRODUCTS --}}

                                <td>

                                    @foreach($order->seller_items ?? [] as $item)

                                        <div class="product-line">

                                            <i class="fa-solid fa-box me-1"></i>

                                            {{ $item['name'] ?? ($products[$item['product_id'] ?? null]?->name ?? 'Product') }}

                                            × {{ $item['quantity'] ?? 1 }}

                                        </div>

                                    @endforeach

                                </td>


                                {{-- =================================================
                                     PAYMENT
                                ================================================== --}}

                                <td>

                                    @if($isPaid)

                                        <span class="payment-pill payment-paid">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Paid

                                        </span>

                                        <span class="payment-verified">

                                            <i class="fa-solid fa-shield-check"></i>

                                            Payment Verified

                                        </span>

                                    @elseif($isFailed)

                                        <span class="payment-pill payment-failed">

                                            <i class="fa-solid fa-circle-xmark"></i>

                                            Failed

                                        </span>

                                        <span class="payment-warning">

                                            <i class="fa-solid fa-triangle-exclamation"></i>

                                            Payment Failed

                                        </span>

                                    @elseif($isCod)

                                        <span class="payment-pill payment-cod">

                                            <i class="fa-solid fa-money-bill-wave"></i>

                                            COD

                                        </span>

                                        <span class="payment-method-small">

                                            Pay on delivery

                                        </span>

                                    @else

                                        <span class="payment-pill payment-pending">

                                            <i class="fa-solid fa-clock"></i>

                                            Pending

                                        </span>

                                        <span class="payment-warning">

                                            <i class="fa-solid fa-lock"></i>

                                            Payment Pending

                                        </span>

                                    @endif

                                    <span class="payment-method-small">

                                        {{ $paymentMethod }}

                                    </span>

                                </td>


                                {{-- =================================================
                                     ORDER STATUS
                                ================================================== --}}

                                <td>

                                    @php

                                        $displayStatus =
                                            $delivery?->status
                                            ?? $order->order_status
                                            ?? $order->status
                                            ?? 'Order Placed';

                                    @endphp

                                    <span class="status-pill">

                                        <span class="status-dot"></span>

                                        {{ $displayStatus }}

                                    </span>

                                </td>


                                {{-- =================================================
                                     ACTIONS
                                ================================================== --}}

                                <td>

                                    <div class="order-actions">

                                        {{-- Delivery should only be managed for
                                             confirmed/paid orders or COD orders. --}}

                                        @if($isPaid || $isCod)

                                            <button
                                                type="button"
                                                class="action-btn action-delivery"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deliveryModal{{ $order->id }}"
                                            >

                                                <i class="fa-solid fa-truck me-1"></i>

                                                Delivery

                                            </button>

                                        @endif


                                        <button
                                            type="button"
                                            class="action-btn action-view"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $order->id }}"
                                        >

                                            <i class="fa-solid fa-eye me-1"></i>

                                            View

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="empty-orders">

                                        <div class="empty-orders-icon">

                                            <i class="fa-solid fa-box-open"></i>

                                        </div>

                                        <h3>
                                            No Orders Yet
                                        </h3>

                                        <p class="mb-0">
                                            Customer orders will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>

</main>


{{-- =========================================================
     MODALS
========================================================= --}}

@foreach($orders as $order)

    @php

        $delivery = $order->deliveryDetail;
        $partner = $delivery?->deliveryPartner;

        $paymentStatus = strtolower(
            trim((string) ($order->payment_status ?? 'pending'))
        );

        $paymentMethod = strtoupper(
            trim((string) ($order->payment_method ?? 'COD'))
        );

        $isPaid = in_array(
            $paymentStatus,
            ['paid', 'captured', 'completed', 'success', 'successful'],
            true
        );

        $isCod = $paymentMethod === 'COD';

    @endphp


    {{-- =====================================================
         DELIVERY FORM MODAL
    ====================================================== --}}

    <div
        class="modal fade"
        id="deliveryModal{{ $order->id }}"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <form
                action="{{ route('seller.orders.delivery.store', $order) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="modal-content premium-modal">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            <i class="fa-solid fa-truck text-success me-2"></i>

                            Delivery Boy Details

                            <small class="text-muted ms-2">

                                Order {{ $order->id }}

                            </small>

                        </h5>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body">

                        {{-- PAYMENT CONFIRMATION --}}

                        @if($isPaid)

                            <div class="alert alert-success bg-transparent border-success text-success">

                                <i class="fa-solid fa-shield-check me-2"></i>

                                <strong>Payment Verified</strong>

                                — Online payment has been successfully verified.

                            </div>

                        @elseif($isCod)

                            <div class="alert alert-primary bg-transparent border-primary text-primary">

                                <i class="fa-solid fa-money-bill-wave me-2"></i>

                                <strong>Cash on Delivery</strong>

                                — Customer will pay at delivery.

                            </div>

                        @else

                            <div class="alert alert-warning bg-transparent border-warning text-warning">

                                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                                <strong>Payment Pending</strong>

                                — Do not dispatch this order until payment is confirmed.

                            </div>

                        @endif


                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Delivery Boy Photo
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Name *
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $partner?->name) }}"
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Mobile Number *
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone', $partner?->phone) }}"
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', $partner?->email) }}"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Vehicle Type
                                </label>

                                <input
                                    type="text"
                                    name="vehicle_type"
                                    class="form-control"
                                    value="{{ old('vehicle_type', $partner?->vehicle_type) }}"
                                    placeholder="Bike / Scooter / Van"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Vehicle Number
                                </label>

                                <input
                                    type="text"
                                    name="vehicle_number"
                                    class="form-control"
                                    value="{{ old('vehicle_number', $partner?->vehicle_number) }}"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Delivery Date
                                </label>

                                <input
                                    type="date"
                                    name="delivery_date"
                                    class="form-control"
                                    value="{{ old('delivery_date', $partner?->delivery_date?->format('Y-m-d')) }}"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Expected Delivery Time
                                </label>

                                <input
                                    type="time"
                                    name="expected_time"
                                    class="form-control"
                                    value="{{ old('expected_time', $partner?->expected_time) }}"
                                >

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Current Delivery Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select"
                                >

                                    @foreach([
                                        'Order Placed',
                                        'Seller Confirmed',
                                        'Packed',
                                        'Picked By Delivery Partner',
                                        'Out For Delivery',
                                        'Near Customer',
                                        'Delivered'
                                    ] as $status)

                                        <option
                                            value="{{ $status }}"
                                            {{ old('status', $delivery?->status ?? 'Order Placed') == $status ? 'selected' : '' }}
                                        >

                                            {{ $status }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-12">

                                <label class="form-label">
                                    Notes
                                </label>

                                <textarea
                                    name="notes"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Any special instructions..."
                                >{{ old('notes', $partner?->notes) }}</textarea>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            <i class="fa-solid fa-floppy-disk me-1"></i>

                            Save Details

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         VIEW DELIVERY MODAL
    ====================================================== --}}

    <div
        class="modal fade"
        id="viewModal{{ $order->id }}"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content premium-modal">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fa-solid fa-truck text-success me-2"></i>

                        Delivery Details

                        <small class="text-muted ms-2">

                            Order #{{ $order->id }}

                        </small>

                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    @if($partner)

                        <div class="row g-4">

                            <div class="col-md-4">

                                <div class="delivery-profile">

                                    @if($partner->image)

                                        <img
                                            src="{{ asset('delivery-partners/'.$partner->image) }}"
                                            alt="Delivery Boy"
                                        >

                                    @else

                                        <div class="delivery-placeholder">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                    @endif


                                    <h5 class="mt-3 mb-1">

                                        {{ $partner->name }}

                                    </h5>

                                    <span class="status-pill">

                                        <span class="status-dot"></span>

                                        {{ $delivery?->status ?? 'Order Placed' }}

                                    </span>

                                </div>

                            </div>


                            <div class="col-md-8">

                                <h6 class="text-success fw-bold mb-3">

                                    <i class="fa-solid fa-id-card me-1"></i>

                                    Delivery Partner Information

                                </h6>


                                <div class="row g-2">

                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Mobile
                                            </div>

                                            <div class="info-value">
                                                {{ $partner->phone ?? '—' }}
                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Email
                                            </div>

                                            <div class="info-value">
                                                {{ $partner->email ?? '—' }}
                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Vehicle Type
                                            </div>

                                            <div class="info-value">
                                                {{ $partner->vehicle_type ?? '—' }}
                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Vehicle Number
                                            </div>

                                            <div class="info-value">
                                                {{ $partner->vehicle_number ?? '—' }}
                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Delivery Date
                                            </div>

                                            <div class="info-value">

                                                {{ $partner->delivery_date?->format('d M Y') ?? '—' }}

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="info-box">

                                            <div class="info-label">
                                                Expected Time
                                            </div>

                                            <div class="info-value">

                                                {{ $partner->expected_time ?? '—' }}

                                            </div>

                                        </div>

                                    </div>


                                    @if($partner->notes)

                                        <div class="col-12">

                                            <div class="info-box">

                                                <div class="info-label">
                                                    Notes
                                                </div>

                                                <div class="info-value">

                                                    {{ $partner->notes }}

                                                </div>

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="empty-orders py-5">

                            <div class="empty-orders-icon">

                                <i class="fa-solid fa-truck-ramp-box"></i>

                            </div>

                            <h3>
                                No Delivery Partner Assigned
                            </h3>

                            <p>
                                Delivery details have not been added for this order yet.
                            </p>

                        </div>

                    @endif


                    <hr class="border-secondary my-4">


                    {{-- PAYMENT INFORMATION --}}

                    <h6 class="text-success fw-bold mb-3">

                        <i class="fa-solid fa-credit-card me-1"></i>

                        Payment Information

                    </h6>


                    <div class="row g-2">

                        <div class="col-md-4">

                            <div class="info-box">

                                <div class="info-label">
                                    Payment Method
                                </div>

                                <div class="info-value">
                                    {{ $order->payment_method ?? 'COD' }}
                                </div>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="info-box">

                                <div class="info-label">
                                    Payment Status
                                </div>

                                <div class="info-value">

                                    @if($isPaid)

                                        <span class="text-success">
                                            <i class="fa-solid fa-circle-check me-1"></i>
                                            Paid / Verified
                                        </span>

                                    @elseif($isCod)

                                        <span class="text-primary">
                                            <i class="fa-solid fa-money-bill-wave me-1"></i>
                                            Cash on Delivery
                                        </span>

                                    @else

                                        <span class="text-warning">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            Pending
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="info-box">

                                <div class="info-label">
                                    Order Amount
                                </div>

                                <div class="info-value">

                                    ₹{{ number_format((float) ($order->amount ?? $order->total ?? 0), 2) }}

                                </div>

                            </div>

                        </div>

                    </div>


                    <hr class="border-secondary my-4">


                    <h6 class="text-primary fw-bold mb-3">

                        <i class="fa-solid fa-user me-1"></i>

                        Customer Information

                    </h6>


                    <div class="row g-2">

                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Order Number
                                </div>

                                <div class="info-value">
                                    #{{ $order->id }}
                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Customer Name
                                </div>

                                <div class="info-value">
                                    {{ $order->name }}
                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Customer Mobile
                                </div>

                                <div class="info-value">
                                    {{ $order->mobile }}
                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Customer Address
                                </div>

                                <div class="info-value">
                                    {{ $order->address }}, {{ $order->city }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>


                    @if($isPaid || $isCod)

                        <button
                            type="button"
                            class="btn btn-warning edit-delivery-btn"
                            data-view="#viewModal{{ $order->id }}"
                            data-edit="#deliveryModal{{ $order->id }}"
                        >

                            <i class="fa-solid fa-pen me-1"></i>

                            Edit

                        </button>


                        <form
                            action="{{ route('seller.orders.delivery.destroy', $order) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Delete delivery details for order #{{ $order->id }}?');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >

                                <i class="fa-solid fa-trash me-1"></i>

                                Delete

                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endforeach


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.querySelectorAll('.edit-delivery-btn').forEach(function (btn) {

    btn.addEventListener('click', function () {

        const viewModal =
            document.querySelector(btn.dataset.view);

        const editModal =
            document.querySelector(btn.dataset.edit);

        if (viewModal) {

            const vm =
                bootstrap.Modal.getInstance(viewModal);

            if (vm) {
                vm.hide();
            }
        }

        if (editModal) {

            setTimeout(function () {

                const em =
                    bootstrap.Modal.getOrCreateInstance(editModal);

                em.show();

            }, 250);
        }
    });

});
</script>

</body>
</html>
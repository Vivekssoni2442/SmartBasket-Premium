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
        /* =========================================================
           SMART BASKET — SELLER ORDER MANAGEMENT
           PREMIUM LIGHT THEME
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        :root {
            --sb-bg: #f5f7fb;
            --sb-card: #ffffff;
            --sb-card-soft: #f8fafc;
            --sb-border: #e5e7eb;

            --sb-text: #111827;
            --sb-text-2: #334155;
            --sb-muted: #64748b;

            --sb-green: #00a86b;
            --sb-green-dark: #00875a;
            --sb-green-soft: rgba(0, 168, 107, .09);

            --sb-blue: #2563eb;
            --sb-blue-soft: rgba(37, 99, 235, .09);

            --sb-yellow: #d97706;
            --sb-yellow-soft: rgba(245, 158, 11, .10);

            --sb-red: #dc2626;
            --sb-red-soft: rgba(220, 38, 38, .09);

            --sb-shadow:
                0 12px 35px rgba(15, 23, 42, .08),
                0 3px 10px rgba(15, 23, 42, .035);
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family: 'Poppins', sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at top left,
                    rgba(0, 168, 107, .07),
                    transparent 32%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(37, 99, 235, .055),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #f5f7fb,
                    #eef2f7
                );
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .orders-page {
            min-height: 100vh;
            padding: 42px 20px 70px;
        }

        .orders-container {
            width: 100%;
            max-width: 1450px;
            margin: auto;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;

            margin-bottom: 28px;
        }

        .header-left small {
            display: inline-block;

            margin-bottom: 8px;

            color: var(--sb-green);

            font-size: 11px;
            font-weight: 800;

            letter-spacing: 2px;
        }

        .header-left h1 {
            margin: 0;

            color: var(--sb-text);

            font-size: 34px;
            line-height: 1.2;
            font-weight: 800;

            letter-spacing: -.7px;
        }

        .header-left h1 i {
            margin-right: 8px;
            color: var(--sb-green);
        }

        .header-left p {
            margin: 9px 0 0;

            color: var(--sb-muted);

            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        /* =========================================================
           BUTTON
        ========================================================= */

        .premium-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;

            border-radius: 13px;

            padding: 11px 18px;

            font-size: 13px;
            font-weight: 700;

            text-decoration: none;

            transition: .25s ease;
        }

        .premium-btn-dashboard {
            color: var(--sb-text);

            border: 1px solid var(--sb-border);

            background: rgba(255,255,255,.85);

            box-shadow:
                0 5px 15px rgba(15,23,42,.05);
        }

        .premium-btn-dashboard:hover {
            color: var(--sb-green-dark);

            border-color: rgba(0,168,107,.35);

            background: #fff;

            transform: translateY(-2px);

            box-shadow:
                0 9px 22px rgba(15,23,42,.09);
        }

        /* =========================================================
           ALERTS
        ========================================================= */

        .premium-alert {
            margin-bottom: 20px;

            padding: 14px 18px;

            color: var(--sb-text-2);

            border-radius: 15px;
            border: 1px solid var(--sb-border);

            background: rgba(255,255,255,.9);

            box-shadow: 0 5px 18px rgba(15,23,42,.04);
        }

        .premium-alert.success {
            color: #087f55;

            border-color: rgba(0,168,107,.20);

            background: rgba(0,168,107,.055);
        }

        .premium-alert.error {
            color: #b91c1c;

            border-color: rgba(220,38,38,.20);

            background: rgba(220,38,38,.055);
        }

        /* =========================================================
           MAIN CARD
        ========================================================= */

        .orders-card {
            overflow: hidden;

            border-radius: 24px;

            border: 1px solid rgba(15,23,42,.075);

            background: rgba(255,255,255,.94);

            box-shadow: var(--sb-shadow);
        }

        .orders-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 21px 24px;

            border-bottom: 1px solid var(--sb-border);

            background:
                linear-gradient(
                    180deg,
                    rgba(248,250,252,.95),
                    rgba(255,255,255,.95)
                );
        }

        .orders-card-title {
            display: flex;
            align-items: center;
            gap: 12px;

            color: var(--sb-text);

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

            color: var(--sb-green);

            background: var(--sb-green-soft);

            border: 1px solid rgba(0,168,107,.15);
        }

        .order-count {
            padding: 7px 12px;

            border-radius: 20px;

            color: var(--sb-green-dark);

            background: var(--sb-green-soft);

            border: 1px solid rgba(0,168,107,.14);

            font-size: 12px;
            font-weight: 700;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .table-wrapper {
            overflow-x: auto;
        }

        .seller-order-table {
            width: 100%;
            min-width: 1150px;

            margin: 0;

            color: var(--sb-text);

            border-collapse: separate;
            border-spacing: 0;
        }

        .seller-order-table thead th {
            padding: 16px 20px;

            color: #64748b;

            background: #f8fafc;

            border-bottom: 1px solid var(--sb-border);

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .8px;

            white-space: nowrap;
        }

        .seller-order-table tbody td {
            padding: 18px 20px;

            color: var(--sb-text-2);

            background: #fff;

            border-bottom: 1px solid #eef2f7;

            vertical-align: middle;

            font-size: 13px;
        }

        .seller-order-table tbody tr {
            transition: .22s ease;
        }

        .seller-order-table tbody tr:hover td {
            background: #f9fdfb;
        }

        .seller-order-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* =========================================================
           ORDER
        ========================================================= */

        .order-number {
            color: var(--sb-text);
            font-weight: 800;
        }

        .order-date {
            margin-top: 4px;

            color: var(--sb-muted);

            font-size: 11px;
        }

        /* =========================================================
           CUSTOMER
        ========================================================= */

        .customer-name {
            color: var(--sb-text);
            font-weight: 700;
        }

        .customer-address {
            max-width: 220px;

            margin-top: 4px;

            color: var(--sb-muted);

            font-size: 11px;
        }

        /* =========================================================
           PRODUCT
        ========================================================= */

        .product-line {
            margin-bottom: 4px;

            color: #475569;

            font-size: 12px;
        }

        .product-line i {
            color: var(--sb-green);
        }

        /* =========================================================
           PAYMENT
        ========================================================= */

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
            color: #087f55;

            background: rgba(0,168,107,.09);

            border: 1px solid rgba(0,168,107,.22);
        }

        .payment-pending {
            color: #b45309;

            background: rgba(245,158,11,.10);

            border: 1px solid rgba(245,158,11,.23);
        }

        .payment-failed {
            color: #b91c1c;

            background: rgba(220,38,38,.09);

            border: 1px solid rgba(220,38,38,.20);
        }

        .payment-cod {
            color: #1d4ed8;

            background: rgba(37,99,235,.09);

            border: 1px solid rgba(37,99,235,.19);
        }

        .payment-method-small {
            display: block;

            margin-top: 5px;

            color: var(--sb-muted);

            font-size: 10px;
        }

        .payment-verified {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            margin-top: 5px;

            color: var(--sb-green-dark);

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

            color: #b45309;

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* =========================================================
           STATUS
        ========================================================= */

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 12px;

            border-radius: 20px;

            color: var(--sb-green-dark);

            background: var(--sb-green-soft);

            border: 1px solid rgba(0,168,107,.18);

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;

            flex: 0 0 7px;

            border-radius: 50%;

            background: var(--sb-green);

            box-shadow:
                0 0 8px rgba(0,168,107,.35);
        }

        .status-pending {
            color: #b45309;

            background: rgba(245,158,11,.08);

            border-color: rgba(245,158,11,.20);
        }

        .status-pending .status-dot {
            background: #f59e0b;

            box-shadow:
                0 0 8px rgba(245,158,11,.35);
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .order-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .action-btn {
            border-radius: 10px;

            padding: 8px 11px;

            border: 1px solid var(--sb-border);

            font-size: 11px;
            font-weight: 700;

            transition: .2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-delivery {
            color: var(--sb-green-dark);

            background: rgba(0,168,107,.07);

            border-color: rgba(0,168,107,.18);
        }

        .action-delivery:hover {
            color: var(--sb-green-dark);

            background: rgba(0,168,107,.13);
        }

        .action-view {
            color: #475569;

            background: #f8fafc;
        }

        .action-view:hover {
            color: var(--sb-text);

            background: #eef2f7;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty-orders {
            padding: 80px 30px;

            text-align: center;

            color: var(--sb-muted);
        }

        .empty-orders-icon {
            width: 75px;
            height: 75px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            border-radius: 22px;

            background: #f8fafc;

            border: 1px solid var(--sb-border);

            color: #94a3b8;

            font-size: 30px;
        }

        .empty-orders h3 {
            color: var(--sb-text);

            font-size: 18px;
            font-weight: 700;
        }

        /* =========================================================
           MODAL
        ========================================================= */

        .premium-modal {
            overflow: hidden;

            color: var(--sb-text);

            border: 1px solid #e2e8f0;

            border-radius: 22px;

            background: #fff;

            box-shadow:
                0 30px 90px rgba(15,23,42,.20);
        }

        .premium-modal .modal-header {
            padding: 20px 24px;

            background: #f8fafc;

            border-bottom: 1px solid var(--sb-border);
        }

        .premium-modal .modal-header .modal-title {
            color: var(--sb-text);

            font-weight: 750;
        }

        .premium-modal .modal-footer {
            padding: 16px 24px;

            background: #f8fafc;

            border-top: 1px solid var(--sb-border);
        }

        .premium-modal .modal-body {
            padding: 24px;

            background: #fff;
        }

        .premium-modal .form-label {
            color: #475569;

            font-size: 12px;
            font-weight: 700;
        }

        .premium-modal .form-control,
        .premium-modal .form-select {
            color: var(--sb-text);

            background: #fff;

            border: 1px solid #dbe2ea;

            border-radius: 11px;

            padding: 11px 13px;
        }

        .premium-modal .form-control::placeholder {
            color: #94a3b8;
        }

        .premium-modal .form-control:focus,
        .premium-modal .form-select:focus {
            color: var(--sb-text);

            background: #fff;

            border-color: var(--sb-green);

            box-shadow:
                0 0 0 .18rem rgba(0,168,107,.10);
        }

        .premium-modal .form-select option {
            background: #fff;
            color: var(--sb-text);
        }

        .premium-modal .btn-close {
            filter: none;
        }

        .premium-modal .text-muted {
            color: #64748b !important;
        }

        .premium-modal hr {
            border-color: #e2e8f0 !important;
            opacity: 1;
        }

        .delivery-profile {
            padding: 20px;

            text-align: center;

            border-radius: 18px;

            background: #f8fafc;

            border: 1px solid var(--sb-border);
        }

        .delivery-profile img,
        .delivery-placeholder {
            width: 115px;
            height: 115px;

            object-fit: cover;

            border-radius: 50%;

            border: 2px solid rgba(0,168,107,.25);
        }

        .delivery-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto;

            background: #f1f5f9;

            color: #94a3b8;

            font-size: 40px;
        }

        .delivery-profile h5 {
            color: var(--sb-text);
        }

        .info-box {
            height: 100%;

            padding: 15px;

            border-radius: 14px;

            background: #f8fafc;

            border: 1px solid var(--sb-border);
        }

        .info-label {
            margin-bottom: 4px;

            color: #64748b;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .info-value {
            color: #1e293b;

            font-size: 13px;
            font-weight: 600;

            word-break: break-word;
        }

        /* =========================================================
           MOBILE
        ========================================================= */

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
                width: 100%;
            }

            .orders-card-header {
                align-items: flex-start;
                gap: 12px;
                flex-direction: column;
            }

            .orders-card {
                border-radius: 18px;
            }

            .premium-modal .modal-body {
                padding: 18px;
            }

            .premium-modal .modal-header,
            .premium-modal .modal-footer {
                padding: 16px 18px;
            }
        }
    </style>
</head>

<body>

    {{-- =========================================================
         GLOBAL SELLER 3-DOTS MENU
         Same menu used on Seller Dashboard
    ========================================================= --}}
    @include('seller.partials.seller-menu')


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
                        <i class="fa-solid fa-arrow-left"></i>
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

                                    $paymentStatus = strtolower(
                                        trim((string) ($order->payment_status ?? 'pending'))
                                    );

                                    $paymentMethod = strtoupper(
                                        trim((string) ($order->payment_method ?? 'COD'))
                                    );

                                    $isPaid = in_array(
                                        $paymentStatus,
                                        [
                                            'paid',
                                            'captured',
                                            'completed',
                                            'success',
                                            'successful'
                                        ],
                                        true
                                    );

                                    $isFailed = in_array(
                                        $paymentStatus,
                                        [
                                            'failed',
                                            'failure',
                                            'cancelled',
                                            'canceled'
                                        ],
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


                                    {{-- PAYMENT --}}

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


                                    {{-- STATUS --}}

                                    <td>

                                        @php

                                            $displayStatus =
                                                $delivery?->status
                                                ?? $order->order_status
                                                ?? $order->status
                                                ?? 'Order Placed';

                                        @endphp

                                        <span
                                            class="status-pill
                                            {{ strtolower($displayStatus) === 'pending' ? 'status-pending' : '' }}"
                                        >

                                            <span class="status-dot"></span>

                                            {{ $displayStatus }}

                                        </span>

                                    </td>


                                    {{-- ACTIONS --}}

                                    <td>

                                        <div class="order-actions">

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
                [
                    'paid',
                    'captured',
                    'completed',
                    'success',
                    'successful'
                ],
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
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        <div class="modal-body">

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
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
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


                        <hr class="my-4">


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


                        <hr class="my-4">


                        {{-- CUSTOMER INFORMATION --}}

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
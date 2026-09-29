<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>SMART BASKET — Payment Receipt</title>

    <style>

        * {
            box-sizing: border-box;
        }

        @page {
            margin: 25px;
        }

        body {
            margin: 0;
            padding: 0;
            background: #eef2f5;
            color: #172033;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
        }

        .receipt {
            width: 100%;
            background: #ffffff;
            border: 1px solid #d7e0e7;
        }

        /* =====================================================
           PREMIUM HEADER
        ===================================================== */

        .header {
            width: 100%;
            background: #06131c;
            color: #ffffff;
            padding: 26px 30px;
            border-bottom: 4px solid #00d98b;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: 0;
            padding: 0;
            vertical-align: middle;
        }

        .brand {
            font-size: 26px;
            font-weight: bold;
            letter-spacing: .5px;
            color: #ffffff;
        }

        .brand-green {
            color: #00d98b;
        }

        .receipt-subtitle {
            margin-top: 6px;
            color: #9fb0bd;
            font-size: 10px;
        }

        .receipt-badge {
            text-align: right;
        }

        .receipt-badge-title {
            color: #8fa2b0;
            font-size: 9px;
            text-transform: uppercase;
        }

        .receipt-number {
            margin-top: 4px;
            color: #ffffff;
            font-size: 13px;
            font-weight: bold;
        }

        /* =====================================================
           STATUS
        ===================================================== */

        .status-wrap {
            padding: 20px 30px 5px;
        }

        .status-success {
            background: #e9fff5;
            border: 1px solid #a8efd2;
            color: #087443;
        }

        .status-pending {
            background: #fff8df;
            border: 1px solid #f4df91;
            color: #8a6700;
        }

        .status-failed {
            background: #fff0f0;
            border: 1px solid #f2b8b8;
            color: #b42323;
        }

        .status-refunded {
            background: #f1edff;
            border: 1px solid #cfc2ff;
            color: #5b3db8;
        }

        .status-box {
            padding: 11px 14px;
            font-size: 11px;
            font-weight: bold;
        }

        /* =====================================================
           AMOUNT HERO
        ===================================================== */

        .amount-section {
            padding: 22px 30px;
        }

        .amount-card {
            width: 100%;
            background: #f6fbf9;
            border: 1px solid #c9eee0;
            padding: 20px;
            text-align: center;
        }

        .amount-label {
            color: #64748b;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .amount {
            margin-top: 5px;
            color: #087443;
            font-size: 29px;
            font-weight: bold;
        }

        .amount-note {
            margin-top: 4px;
            color: #64748b;
            font-size: 9px;
        }

        /* =====================================================
           SECTION
        ===================================================== */

        .section {
            padding: 17px 30px;
            border-top: 1px solid #e5e9ed;
        }

        .section-title {
            margin-bottom: 11px;
            color: #087443;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: .3px;
        }

        .section-title-line {
            width: 32px;
            height: 2px;
            margin-top: 4px;
            background: #00d98b;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 0;
            border: 0;
            vertical-align: top;
        }

        .label {
            width: 38%;
            color: #64748b;
            font-size: 10px;
        }

        .value {
            width: 62%;
            color: #172033;
            font-size: 10px;
            font-weight: bold;
            text-align: right;
            word-break: break-word;
        }

        /* =====================================================
           PRODUCTS
        ===================================================== */

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th {
            padding: 9px 8px;
            background: #071923;
            color: #d9fff2;
            border: 0;
            font-size: 9px;
            font-weight: bold;
            text-align: left;
        }

        .products-table th:last-child,
        .products-table td:last-child {
            text-align: right;
        }

        .products-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            color: #263244;
            font-size: 10px;
            vertical-align: top;
        }

        .product-name {
            font-weight: bold;
            color: #172033;
        }

        .product-id {
            margin-top: 2px;
            color: #94a3b8;
            font-size: 8px;
        }

        .qty {
            text-align: center;
            font-weight: bold;
        }

        .price {
            text-align: right;
        }

        .product-empty {
            text-align: center;
            color: #64748b;
            padding: 15px !important;
        }

        /* =====================================================
           TOTAL
        ===================================================== */

        .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-table td {
            border: 0;
            padding: 5px 0;
        }

        .total-label {
            color: #475569;
            font-size: 11px;
        }

        .total-value {
            color: #087443;
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        .total-highlight {
            margin-top: 10px;
            padding-top: 12px;
            border-top: 2px solid #00d98b;
        }

        /* =====================================================
           SELLER CARD
        ===================================================== */

        .seller-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 13px;
        }

        .seller-name {
            color: #0f172a;
            font-size: 12px;
            font-weight: bold;
        }

        .seller-meta {
            margin-top: 3px;
            color: #64748b;
            font-size: 9px;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            margin-top: 8px;
            padding: 20px 30px;
            background: #06131c;
            color: #8fa2b0;
            text-align: center;
            font-size: 8px;
            line-height: 1.7;
        }

        .footer-brand {
            color: #00d98b;
            font-size: 11px;
            font-weight: bold;
        }

        .footer-divider {
            margin: 7px 0;
            color: #334653;
        }

        .secure {
            color: #b8c7d1;
        }

    </style>

</head>

<body>

@php

    /*
    |--------------------------------------------------------------------------
    | SAFE PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    $currentPaymentStatus =
        $paymentStatus
        ?? $status
        ?? $order->payment_status
        ?? 'Pending';

    $currentPaymentStatus =
        ucfirst(
            strtolower(
                (string) $currentPaymentStatus
            )
        );


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER
    |--------------------------------------------------------------------------
    */

    $customerUser = $order->user;

    $customerName =
        $customerUser?->name
        ?: $order->name
        ?: 'Guest Customer';

    $customerUid =
        $customerUser?->customer_uid
        ?: null;


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    $receiptTotal =
        (float) (
            $order->total
            ?? $order->amount
            ?? 0
        );


    /*
    |--------------------------------------------------------------------------
    | STATUS CLASS
    |--------------------------------------------------------------------------
    */

    $statusClass = match (
        strtolower($currentPaymentStatus)
    ) {

        'successful',
        'paid' =>
            'status-success',

        'failed' =>
            'status-failed',

        'refunded' =>
            'status-refunded',

        default =>
            'status-pending',
    };

@endphp


<div class="receipt">


    {{-- =====================================================
         PREMIUM HEADER
    ====================================================== --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td>

                    <div class="brand">
                        SMART
                        <span class="brand-green">
                            BASKET
                        </span>
                    </div>

                    <div class="receipt-subtitle">
                        Secure Customer Payment Receipt
                    </div>

                </td>

                <td>

                    <div class="receipt-badge">

                        <div class="receipt-badge-title">
                            Order Reference
                        </div>

                        <div class="receipt-number">
                            #SB-{{ $order->id }}
                        </div>

                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         PAYMENT STATUS
    ====================================================== --}}

    <div class="status-wrap">

        <div class="status-box {{ $statusClass }}">

            @if(
                strtolower($currentPaymentStatus) === 'successful'
                ||
                strtolower($currentPaymentStatus) === 'paid'
            )

                Payment Successful

            @elseif(
                strtolower($currentPaymentStatus) === 'failed'
            )

                Payment Failed

            @elseif(
                strtolower($currentPaymentStatus) === 'refunded'
            )

                Payment Refunded

            @else

                Payment {{ $currentPaymentStatus }}

            @endif

        </div>

    </div>


    {{-- =====================================================
         AMOUNT
    ====================================================== --}}

    <div class="amount-section">

        <div class="amount-card">

            <div class="amount-label">
                Total Payment Amount
            </div>

            <div class="amount">
                Rs. {{ number_format($receiptTotal, 2) }}
            </div>

            <div class="amount-note">
                Smart Basket Customer Payment
            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER INFORMATION
    ====================================================== --}}

    <div class="section">

        <div class="section-title">

            ORDER INFORMATION

            <div class="section-title-line"></div>

        </div>


        <table class="info-table">

            <tr>

                <td class="label">
                    Order Number
                </td>

                <td class="value">
                    SB-{{ $order->id }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Order Date
                </td>

                <td class="value">
                    {{ $order->created_at?->format('d M Y, h:i A') ?: 'Not available' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Order Status
                </td>

                <td class="value">
                    {{ $order->order_status ?: $order->status ?: 'Placed' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Payment Method
                </td>

                <td class="value">
                    {{ $order->payment_method ?: 'Not recorded' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Payment Status
                </td>

                <td class="value">
                    {{ $currentPaymentStatus }}
                </td>

            </tr>


            @if($paymentDate)

                <tr>

                    <td class="label">
                        Payment Date
                    </td>

                    <td class="value">

                        {{ \Carbon\Carbon::parse(
                            $paymentDate
                        )->format('d M Y, h:i A') }}

                    </td>

                </tr>

            @endif


            @if($paymentId)

                <tr>

                    <td class="label">
                        Payment ID
                    </td>

                    <td class="value">
                        {{ $paymentId }}
                    </td>

                </tr>

            @endif


            @if($gatewayOrderId)

                <tr>

                    <td class="label">
                        Gateway Order ID
                    </td>

                    <td class="value">
                        {{ $gatewayOrderId }}
                    </td>

                </tr>

            @endif

        </table>

    </div>


    {{-- =====================================================
         CUSTOMER INFORMATION
    ====================================================== --}}

    <div class="section">

        <div class="section-title">

            CUSTOMER INFORMATION

            <div class="section-title-line"></div>

        </div>


        <table class="info-table">

            <tr>

                <td class="label">
                    Customer Name
                </td>

                <td class="value">
                    {{ $customerName }}
                </td>

            </tr>


            @if($customerUid)

                <tr>

                    <td class="label">
                        Customer UID
                    </td>

                    <td class="value">
                        {{ $customerUid }}
                    </td>

                </tr>

            @endif


            <tr>

                <td class="label">
                    Mobile
                </td>

                <td class="value">
                    {{ $order->mobile ?: 'Not available' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Address
                </td>

                <td class="value">

                    {{ $order->address ?: 'Not available' }}

                    @if($order->city)
                        , {{ $order->city }}
                    @endif

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         SELLER INFORMATION
    ====================================================== --}}

    <div class="section">

        <div class="section-title">

            SELLER INFORMATION

            <div class="section-title-line"></div>

        </div>


        @php

            $sellerIds =
                collect(
                    $order->items ?? []
                )
                ->pluck('seller_id')
                ->filter()
                ->unique();

        @endphp


        @forelse($sellerIds as $sellerId)

            @php

                $receiptSeller =
                    \App\Models\SellerProfile::find(
                        $sellerId
                    );

            @endphp


            @if($receiptSeller)

                <div class="seller-card">

                    <div class="seller-name">

                        {{ $receiptSeller->shop_name
                            ?: $receiptSeller->seller_name
                            ?: 'SMART BASKET SELLER'
                        }}

                    </div>


                    @if($receiptSeller->seller_name)

                        <div class="seller-meta">

                            Seller:
                            {{ $receiptSeller->seller_name }}

                        </div>

                    @endif


                    @if($receiptSeller->email)

                        <div class="seller-meta">
                            {{ $receiptSeller->email }}
                        </div>

                    @endif


                    @if($receiptSeller->phone)

                        <div class="seller-meta">
                            {{ $receiptSeller->phone }}
                        </div>

                    @endif

                </div>

            @endif

        @empty

            <div class="seller-card">

                <div class="seller-name">
                    SMART BASKET SELLER
                </div>

                <div class="seller-meta">
                    Seller information unavailable
                </div>

            </div>

        @endforelse

    </div>


    {{-- =====================================================
         PRODUCTS
    ====================================================== --}}

    <div class="section">

        <div class="section-title">

            ORDER ITEMS

            <div class="section-title-line"></div>

        </div>


        <table class="products-table">

            <thead>

                <tr>

                    <th style="width:52%;">
                        Product
                    </th>

                    <th style="width:15%; text-align:center;">
                        Qty
                    </th>

                    <th style="width:16%; text-align:right;">
                        Price
                    </th>

                    <th style="width:17%; text-align:right;">
                        Amount
                    </th>

                </tr>

            </thead>


            <tbody>

                @php
                    $itemsTotal = 0;
                @endphp


                @forelse($order->items ?? [] as $item)

                    @php

                        $product =
                            $products[
                                $item['product_id'] ?? null
                            ] ?? null;


                        $quantity =
                            max(
                                1,
                                (int) (
                                    $item['quantity'] ?? 1
                                )
                            );


                        $price =
                            (float) (
                                $item['price']
                                ?? $product?->price
                                ?? 0
                            );


                        $lineTotal =
                            $price * $quantity;


                        $itemsTotal +=
                            $lineTotal;

                    @endphp


                    <tr>

                        <td>

                            <div class="product-name">

                                {{ $item['name']
                                    ?? $product?->name
                                    ?? 'Product'
                                }}

                            </div>


                            @if(!empty($item['product_id']))

                                <div class="product-id">

                                    Product ID:
                                    {{ $item['product_id'] }}

                                </div>

                            @endif

                        </td>


                        <td class="qty">
                            {{ $quantity }}
                        </td>


                        <td class="price">
                            Rs. {{ number_format($price, 2) }}
                        </td>


                        <td class="price">
                            Rs. {{ number_format($lineTotal, 2) }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="product-empty"
                        >
                            Product details unavailable.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
         TOTAL SUMMARY
    ====================================================== --}}

    <div class="section">

        <table class="total-table">

            <tr>

                <td class="total-label">
                    Items Total
                </td>

                <td class="total-value">
                    Rs. {{ number_format($itemsTotal, 2) }}
                </td>

            </tr>


            <tr class="total-highlight">

                <td class="total-label">
                    TOTAL PAYMENT
                </td>

                <td class="total-value">
                    Rs. {{ number_format($receiptTotal, 2) }}
                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        <div class="footer-brand">
            SMART BASKET
        </div>

        <div class="footer-divider">
            --------------------------------
        </div>

        <div class="secure">
            This is a computer-generated payment receipt.
        </div>

        <div>
            No physical signature is required.
        </div>

        <div>
            Order Reference: SB-{{ $order->id }}
        </div>

        <div>
            Generated:
            {{ now()->format('d M Y, h:i A') }}
        </div>

    </div>


</div>

</body>

</html>
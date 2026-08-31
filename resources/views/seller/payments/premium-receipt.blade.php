<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>

<style>

@page {
    size: A4 portrait;
    margin: 10mm 12mm 10mm 12mm;
}

html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    background: #ffffff;
}

body {
    font-family: DejaVu Sans, sans-serif;
    color: #30285a;
    font-size: 7.5px;
}

/* =========================================================
   MAIN RECEIPT
========================================================= */

.receipt {
    width: 100%;
    max-width: 180mm;
    margin: 0 auto;
    background: #ffffff;
}

/* =========================================================
   HEADER
========================================================= */

.header {
    width: 100%;
    border-bottom: 2px solid rgb(58, 44, 104);
    padding-bottom: 6px;
    margin-bottom: 7px;
}

/* =========================================================
   BRAND AREA
========================================================= */

.brand-area {
    width: 100%;
    display: table;
}

/* =========================================================
   SB GOLD LOGO
========================================================= */

.brand-logo-wrap {
    display: table-cell;
    width: 52px;
    vertical-align: middle;
}

.brand-logo {
    width: 44px;
    height: 44px;

    background: #d6a93a;

    border: 2px solid #eadf0f;
    border-radius: 6px;

    text-align: center;
    vertical-align: middle;

    line-height: 44px;

    /*
     * Silver bright SB text
     * with glow / shine effect
     */
    color: #1d1797;

    font-size: 20px;
    font-weight: bold;

    letter-spacing: 1px;

    text-shadow:
        0px 0px 1px #ffffff,
        0px 0px 2px #ffffff,
        0px 0px 4px #dcdcdc,
        1px 1px 1px #b2f418;

    box-shadow:
        inset 0 0 0 1px #f7f303,
        0 0 2px #e0a80e;
}

/* =========================================================
   SMART BASKET CONTENT
========================================================= */

.brand-content {
    display: table-cell;
    vertical-align: middle;
    padding-left: 8px;
}

.brand {
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 1px;
    color: rgb(58, 44, 104);
    line-height: 17px;
    margin: 0;
    padding: 0;
}

.tagline {
    margin-top: 2px;
    font-size: 6px;
    color: #f28c28;
    letter-spacing: 1.1px;
    line-height: 8px;
}

/* =========================================================
   HEADER LINE
========================================================= */

.header-line {
    width: 100%;
    margin-top: 8px;
    text-align: center;
}

/* =========================================================
   PAYMENT RECEIPT GOLD RIBBON
========================================================= */

.receipt-ribbon {
    width: 100%;
    text-align: center;
    white-space: nowrap;
}

/* BIG GOLD STARS */

.ribbon-star {
    display: inline-block;

    color: #d6a93a;

    font-size: 35px;
    font-weight: bold;

    line-height: 1;

    vertical-align: middle;

    margin: 0 7px;

    text-shadow:
        0px 0px 1px #b8860b,
        0px 0px 2px #f5d77a;
}

/* GOLD RIBBON */

.title {
    display: inline-block;

    width: 65%;

    margin: 0 auto;

    padding: 5px 12px;

    text-align: center;

    background: rgb(58, 44, 104);

    color: #f5c451;

    border: 1px solid #d6a93a;

    border-radius: 4px;

    font-size: 13px;

    font-weight: bold;

    letter-spacing: 1px;

    line-height: 15px;

    vertical-align: middle;

    box-shadow:
        inset 0 0 0 1px #8f741e;
}

.receipt-number {
    display: block;

    width: 100%;

    text-align: center;

    margin-top: 3px;

    font-size: 6.5px;

    color: #f28c28;
}

/* =========================================================
   INFORMATION
========================================================= */

.info-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 6px;
}

.info-table td {
    vertical-align: top;
}

.info-box {
    width: 49%;
    background: #faf8ff;
    border: 1px solid #ddd7eb;
    padding: 6px;
}

.info-gap {
    width: 2%;
}

.label {
    font-size: 5.7px;
    font-weight: bold;
    color: #f28c28;
    text-transform: uppercase;
    letter-spacing: .7px;
    margin-bottom: 3px;
}

.main-value {
    font-size: 8px;
    font-weight: bold;
    line-height: 10px;
    color: #30285a;
}

.sub-value {
    font-size: 6.5px;
    color: #77718a;
    line-height: 9px;
}

/* =========================================================
   STATUS
========================================================= */

.status-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 7px;
}

.status-table td {
    width: 33.33%;
    border: 1px solid #ddd7eb;
    padding: 5px;
    vertical-align: top;
    background: #fcfbff;
}

.status-title {
    font-size: 5.5px;
    color: #f28c28;
    text-transform: uppercase;
    letter-spacing: .6px;
}

.status-value {
    margin-top: 2px;
    font-size: 7px;
    font-weight: bold;
    line-height: 9px;
    color: rgb(58, 44, 104);
}

/* =========================================================
   SECTION
========================================================= */

.section-title {
    font-size: 6.5px;
    font-weight: bold;
    color: #f28c28;
    letter-spacing: .8px;
    text-transform: uppercase;
    margin-bottom: 3px;
}

/* =========================================================
   PRODUCT TABLE
========================================================= */

.products {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 6px;
}

.products th {
    background: rgb(58, 44, 104);
    color: #ffffff;
    padding: 5px 4px;
    font-size: 5.7px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.products td {
    border-bottom: 1px solid #e1ddec;
    padding: 5px 4px;
    font-size: 6.8px;
    vertical-align: middle;
    background: #ffffff;
}

.product-col {
    width: 52%;
    text-align: left;
}

.qty-col {
    width: 11%;
    text-align: center;
}

.price-col {
    width: 18.5%;
    text-align: right;
}

.amount-col {
    width: 18.5%;
    text-align: right;
}

.product-name {
    font-size: 7.5px;
    font-weight: bold;
    line-height: 9px;
    color: #30285a;
}

.product-id {
    margin-top: 1px;
    font-size: 5.5px;
    color: #f28c28;
}

.money {
    white-space: nowrap;
    color: #30285a;
}

/* =========================================================
   TOTAL
========================================================= */

.total-section {
    width: 100%;
    border-top: 1px solid #ddd7eb;
    border-bottom: 1px solid #ddd7eb;
    padding: 5px 0;
    margin-bottom: 6px;
}

.total-left {
    display: inline-block;
    width: 61%;
    vertical-align: middle;
    color: #77718a;
    font-size: 6px;
    line-height: 8px;
}

.total-right {
    display: inline-block;
    width: 38%;
    text-align: right;
    vertical-align: middle;
}

.total-label {
    font-size: 5.7px;
    color: #f28c28;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.total {
    margin-top: 1px;
    font-size: 15px;
    font-weight: bold;
    color: rgb(58, 44, 104);
    white-space: nowrap;
}

/* =========================================================
   PAYMENT
========================================================= */

.payment {
    width: 100%;
    background: #faf8ff;
    border: 1px solid #ddd7eb;
    padding: 5px;
    margin-bottom: 6px;
}

.payment-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.payment-table td {
    width: 25%;
    vertical-align: top;
    padding-right: 4px;
}

.payment-label {
    font-size: 5.3px;
    color: #f28c28;
    text-transform: uppercase;
    letter-spacing: .35px;
}

.payment-value {
    margin-top: 1px;
    font-size: 6.3px;
    font-weight: bold;
    line-height: 8px;
    color: #30285a;
    word-wrap: break-word;
}

/* =========================================================
   FOOTER
========================================================= */

.footer {
    width: 100%;
    border-top: 1px solid #ddd7eb;
    padding-top: 5px;
}

.footer-left {
    display: inline-block;
    width: 69%;
    vertical-align: bottom;
}

.footer-right {
    display: inline-block;
    width: 30%;
    text-align: right;
    vertical-align: bottom;
}

.thanks {
    font-size: 6.5px;
    font-weight: bold;
    color: rgb(58, 44, 104);
    margin-bottom: 1px;
}

.footer-note {
    font-size: 5.2px;
    color: #f28c28;
    line-height: 7px;
}

.signature-line {
    width: 65px;
    margin-left: auto;
    border-top: 1px solid #f28c28;
    margin-bottom: 2px;
}

.signature {
    font-size: 5px;
    color: #f28c28;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.signature strong {
    color: rgb(58, 44, 104);
    font-size: 8px;
}

/* =========================================================
   DOMPDF PAGE CONTROL
========================================================= */

.receipt,
.header,
.info-table,
.status-table,
.products,
.total-section,
.payment,
.footer {
    page-break-inside: avoid;
}

table,
tr,
td,
th {
    page-break-inside: avoid;
}

</style>
</head>

<body>

@php

    $customerName =
        $customerName
        ?? ($customer->name ?? 'Customer');

    $customerEmail =
        $customerEmail
        ?? ($customer->email ?? '—');

    $customerPhone =
        $customerPhone
        ?? ($customer->mobile
        ?? $customer->phone
        ?? $order->mobile
        ?? '—');

    $customerAddress =
        $customerAddress
        ?? ($order->address
        ?? $customer->address
        ?? '');

    $customerCity =
        $customerCity
        ?? ($order->city
        ?? $customer->city
        ?? '');

    $fullAddress = trim(
        $customerAddress .
        ($customerCity
            ? ', ' . $customerCity
            : '')
    );

    $orderDateText =
        $orderDate
        ?? (
            $order->created_at
            ? \Carbon\Carbon::parse(
                $order->created_at
            )->format(
                'd M Y, h:i A'
            )
            : '—'
        );

    $paymentDateText =
        $formattedPaymentDate
        ?? '—';

    $method = strtoupper(
        (string) (
            $paymentMethod
            ?? 'COD'
        )
    );

    $receiptNo =
        $receiptNumber
        ?? (
            'SB-' .
            str_pad(
                $order->id,
                6,
                '0',
                STR_PAD_LEFT
            )
        );

    $finalTotal =
        (float) (
            $orderTotal
            ?? 0
        );

    $orderStatus = strtoupper(
        $order->order_status
        ?? $order->status
        ?? 'PLACED'
    );

    $paymentStatus = strtoupper(
        $status
        ?? 'PENDING'
    );

@endphp


<div class="receipt">

    {{-- HEADER --}}

    <div class="header">

        <div class="brand-area">

            {{-- ONLY ONE SB LOGO --}}

            <div class="brand-logo-wrap">

                <div class="brand-logo">
                    SB
                </div>

            </div>

            <div class="brand-content">

                <div class="brand">
                    SMART BASKET
                </div>

                <div class="tagline">
                    SMART SHOPPING &amp; BETTER LIVING
                </div>

            </div>

        </div>


        <div class="header-line">

            {{-- PAYMENT RECEIPT RIBBON --}}

            <div class="receipt-ribbon">

                <span class="ribbon-star">
                    ★
                </span>

                <div class="title">
                    PAYMENT RECEIPT
                </div>

                <span class="ribbon-star">
                    ★
                </span>

            </div>

            <div class="receipt-number">
                Receipt No. {{ $receiptNo }}
            </div>

        </div>

    </div>


    {{-- BILL TO + ORDER INFORMATION --}}

    <table class="info-table">

        <tr>

            <td class="info-box">

                <div class="label">
                    Bill To
                </div>

                <div class="main-value">
                    {{ $customerName }}
                </div>

                <div class="sub-value">
                    {{ $customerEmail }}
                </div>

                <div class="sub-value">
                    {{ $customerPhone }}
                </div>

                <div class="sub-value">
                    {{ $fullAddress ?: '—' }}
                </div>

            </td>

            <td class="info-gap"></td>

            <td class="info-box">

                <div class="label">
                    Order Information
                </div>

                <div class="main-value">
                    ORDER #SB-{{ $order->id }}
                </div>

                <div class="sub-value">
                    Order Date: {{ $orderDateText }}
                </div>

                <div class="sub-value">
                    Payment Date: {{ $paymentDateText }}
                </div>

                <div class="sub-value">
                    Method: {{ $method }}
                </div>

            </td>

        </tr>

    </table>


    {{-- STATUS --}}

    <table class="status-table">

        <tr>

            <td>

                <div class="status-title">
                    Order Status
                </div>

                <div class="status-value">
                    {{ $orderStatus }}
                </div>

            </td>

            <td>

                <div class="status-title">
                    Payment Status
                </div>

                <div class="status-value">
                    {{ $paymentStatus }}
                </div>

            </td>

            <td>

                <div class="status-title">
                    Transaction
                </div>

                <div class="status-value">
                    {{ $paymentId ?? 'NOT AVAILABLE' }}
                </div>

            </td>

        </tr>

    </table>


    {{-- PURCHASE DETAILS --}}

    <div class="section-title">
        PURCHASE DETAILS
    </div>


    <table class="products">

        <thead>

            <tr>

                <th class="product-col">
                    Product Description
                </th>

                <th class="qty-col">
                    Qty
                </th>

                <th class="price-col">
                    Unit Price
                </th>

                <th class="amount-col">
                    Amount
                </th>

            </tr>

        </thead>

        <tbody>

        @include('seller.partials.seller-menu')

        @foreach($receiptItems as $item)

            <tr>

                <td class="product-col">

                    <div class="product-name">
                        {{ $item['name'] ?? 'Product' }}
                    </div>

                    @if(!empty($item['product_id']))

                        <div class="product-id">
                            Product ID:
                            {{ $item['product_id'] }}
                        </div>

                    @endif

                </td>

                <td class="qty-col">
                    {{ $item['quantity'] ?? 1 }}
                </td>

                <td class="price-col money">
                    ₹{{ number_format(
                        (float)($item['price'] ?? 0),
                        2
                    ) }}
                </td>

                <td class="amount-col money">
                    ₹{{ number_format(
                        (float)($item['line_total'] ?? 0),
                        2
                    ) }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>


    {{-- TOTAL --}}

    <div class="total-section">

        <div class="total-left">

            Thank you for shopping with Smart Basket.<br>

            This receipt confirms the order details shown above.

        </div>

        <div class="total-right">

            <div class="total-label">
                Total Paid / Payable
            </div>

            <div class="total">
                ₹{{ number_format(
                    $finalTotal,
                    2
                ) }}
            </div>

        </div>

    </div>


    {{-- PAYMENT INFORMATION --}}

    <div class="payment">

        <table class="payment-table">

            <tr>

                <td>

                    <div class="payment-label">
                        Payment Method
                    </div>

                    <div class="payment-value">
                        {{ $method }}
                    </div>

                </td>

                <td>

                    <div class="payment-label">
                        Payment ID
                    </div>

                    <div class="payment-value">
                        {{ $paymentId ?? 'Not available' }}
                    </div>

                </td>

                <td>

                    <div class="payment-label">
                        Gateway Order
                    </div>

                    <div class="payment-value">
                        {{ $gatewayOrderId ?? '—' }}
                    </div>

                </td>

                <td>

                    <div class="payment-label">
                        Receipt Date
                    </div>

                    <div class="payment-value">
                        {{ $receiptDate ?? now()->format('d M Y') }}
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- FOOTER --}}

    <div class="footer">

        <div class="footer-left">

            <div class="thanks">
                Thank you for choosing SMART BASKET.
            </div>

            <div class="footer-note">
                This is a computer-generated receipt and does not
                require a physical stamp.
            </div>

        </div>

        <div class="footer-right">

            <div class="signature-line"></div>

            <div class="signature">
                Authorized Signature
                <br>
                <strong> SMART BASKET</strong>
            </div>

        </div>

    </div>

</div>

</body>
</html>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Payment | SMART BASKET
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

        /* ==========================================================
           SMART BASKET — PREMIUM PAYMENT PAGE
        ========================================================== */

        :root {

            --pay-bg: #f4f7fb;

            --pay-card: rgba(255,255,255,.91);

            --pay-surface: rgba(248,250,252,.86);

            --pay-text: #0f172a;

            --pay-heading: #020617;

            --pay-muted: #64748b;

            --pay-border: rgba(15,23,42,.09);

            --pay-primary: #2563eb;

            --pay-purple: #7c3aed;

            --pay-success: #16a34a;

            --pay-warning: #f59e0b;

            --pay-danger: #dc2626;

            --pay-shadow:
                0 30px 85px
                rgba(15,23,42,.13);
        }


        /* ==========================================================
           DARK MODE
        ========================================================== */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --pay-bg: #020617;

            --pay-card: rgba(15,23,42,.93);

            --pay-surface: rgba(30,41,59,.72);

            --pay-text: #e2e8f0;

            --pay-heading: #f8fafc;

            --pay-muted: #94a3b8;

            --pay-border: rgba(255,255,255,.09);

            --pay-primary: #3b82f6;

            --pay-purple: #8b5cf6;

            --pay-success: #22c55e;

            --pay-warning: #f59e0b;

            --pay-danger: #ef4444;

            --pay-shadow:
                0 30px 90px
                rgba(0,0,0,.50);
        }


        /* ==========================================================
           GLOBAL
        ========================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {

            margin: 0;

            color:
                var(--pay-text);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:

                radial-gradient(
                    circle at 5% 0%,
                    rgba(37,99,235,.17),
                    transparent 31%
                ),

                radial-gradient(
                    circle at 95% 10%,
                    rgba(124,58,237,.15),
                    transparent 32%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(34,197,94,.06),
                    transparent 35%
                ),

                var(--pay-bg);

            transition:
                background .3s ease,
                color .3s ease;
        }


        /* ==========================================================
           PAGE
        ========================================================== */

        .payment-page {

            min-height: 100vh;

            padding:
                35px 15px 80px;
        }

        .payment-container {

            width: 100%;

            max-width:
                820px;

            margin:
                auto;
        }


        /* ==========================================================
           TOP NAV
        ========================================================== */

        .payment-topbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom:
                22px;
        }

        .back-link {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                10px 15px;

            color:
                var(--pay-text);

            background:
                var(--pay-card);

            border:
                1px solid
                var(--pay-border);

            border-radius:
                12px;

            text-decoration:
                none;

            font-size:
                12px;

            font-weight:
                850;

            backdrop-filter:
                blur(18px);

            transition:
                .2s ease;
        }

        .back-link:hover {

            color:
                var(--pay-primary);

            border-color:
                rgba(37,99,235,.25);

            transform:
                translateY(-2px);
        }

        .secure-badge {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding:
                9px 14px;

            border-radius:
                999px;

            color:
                var(--pay-success);

            background:
                rgba(34,197,94,.09);

            border:
                1px solid
                rgba(34,197,94,.18);

            font-size:
                11px;

            font-weight:
                850;
        }


        /* ==========================================================
           MAIN CARD
        ========================================================== */

        .payment-card {

            position:
                relative;

            overflow:
                hidden;

            padding:
                32px;

            border:
                1px solid
                var(--pay-border);

            border-radius:
                28px;

            background:
                var(--pay-card);

            box-shadow:
                var(--pay-shadow);

            backdrop-filter:
                blur(24px);

            -webkit-backdrop-filter:
                blur(24px);
        }

        .payment-card::before {

            content: "";

            position:
                absolute;

            left: 0;

            right: 0;

            top: 0;

            height:
                3px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed,
                    #22c55e
                );
        }


        /* ==========================================================
           HEADER
        ========================================================== */

        .payment-header {

            display:
                flex;

            align-items:
                center;

            gap:
                17px;

            margin-bottom:
                25px;
        }

        .payment-logo {

            width:
                60px;

            height:
                60px;

            flex-shrink:
                0;

            display:
                grid;

            place-items:
                center;

            border-radius:
                18px;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            box-shadow:
                0 12px 30px
                rgba(37,99,235,.28);

            font-size:
                23px;
        }

        .payment-title {

            margin:
                0;

            color:
                var(--pay-heading);

            font-size:
                28px;

            font-weight:
                950;

            letter-spacing:
                -.7px;
        }

        .payment-subtitle {

            margin:
                4px 0 0;

            color:
                var(--pay-muted);

            font-size:
                12px;
        }


        /* ==========================================================
           STATUS
        ========================================================== */

        .status-box {

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

            margin-bottom:
                22px;

            padding:
                17px;

            border:
                1px solid
                var(--pay-border);

            border-radius:
                18px;

            background:
                var(--pay-surface);

            transition:
                .25s ease;
        }

        .status-icon {

            width:
                43px;

            height:
                43px;

            flex-shrink:
                0;

            display:
                grid;

            place-items:
                center;

            border-radius:
                13px;

            font-size:
                16px;
        }

        .status-icon.pending {

            color:
                #92400e;

            background:
                rgba(245,158,11,.14);
        }

        .status-icon.success {

            color:
                var(--pay-success);

            background:
                rgba(34,197,94,.13);
        }

        .status-icon.failed {

            color:
                var(--pay-danger);

            background:
                rgba(239,68,68,.12);
        }

        .status-icon.cancelled {

            color:
                var(--pay-warning);

            background:
                rgba(245,158,11,.12);
        }

        .status-title {

            color:
                var(--pay-heading);

            font-size:
                14px;

            font-weight:
                900;
        }

        .status-description {

            margin-top:
                3px;

            color:
                var(--pay-muted);

            font-size:
                11px;

            line-height:
                1.5;
        }


        /* ==========================================================
           PAYMENT SUMMARY
        ========================================================== */

        .summary-card {

            padding:
                20px;

            margin-bottom:
                23px;

            border:
                1px solid
                var(--pay-border);

            border-radius:
                19px;

            background:
                var(--pay-surface);
        }

        .summary-title {

            margin-bottom:
                14px;

            color:
                var(--pay-heading);

            font-size:
                14px;

            font-weight:
                900;
        }

        .summary-row {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;

            padding:
                13px 0;

            border-bottom:
                1px solid
                var(--pay-border);
        }

        .summary-row:last-child {

            border-bottom:
                0;

            padding-bottom:
                0;
        }

        .summary-label {

            color:
                var(--pay-muted);

            font-size:
                12px;

            font-weight:
                650;
        }

        .summary-value {

            color:
                var(--pay-heading);

            font-size:
                13px;

            font-weight:
                850;

            text-align:
                right;
        }

        .amount-value {

            color:
                var(--pay-primary);

            font-size:
                22px;

            font-weight:
                950;
        }


        /* ==========================================================
           PAYMENT METHOD ICON
        ========================================================== */

        .method-badge {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                7px;

            padding:
                7px 10px;

            border-radius:
                9px;

            color:
                var(--pay-primary);

            background:
                rgba(37,99,235,.09);

            border:
                1px solid
                rgba(37,99,235,.15);

            font-size:
                11px;

            font-weight:
                850;
        }


        /* ==========================================================
           BUTTONS
        ========================================================== */

        .payment-actions {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                12px;

            margin-top:
                24px;
        }

        .pay-now-btn {

            width:
                100%;

            min-height:
                55px;

            border:
                0;

            border-radius:
                15px;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            font-size:
                14px;

            font-weight:
                900;

            box-shadow:
                0 13px 30px
                rgba(37,99,235,.27);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                opacity .2s ease;
        }

        .pay-now-btn:hover {

            color:
                white;

            transform:
                translateY(-2px);

            box-shadow:
                0 18px 40px
                rgba(37,99,235,.37);
        }

        .pay-now-btn:disabled {

            opacity:
                .65;

            cursor:
                not-allowed;

            transform:
                none;
        }

        .secondary-btn {

            min-height:
                55px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            border:
                1px solid
                var(--pay-border);

            border-radius:
                15px;

            color:
                var(--pay-text);

            background:
                var(--pay-surface);

            font-size:
                13px;

            font-weight:
                800;

            transition:
                .2s ease;
        }

        .secondary-btn:hover {

            color:
                var(--pay-primary);

            border-color:
                rgba(37,99,235,.25);

            background:
                rgba(37,99,235,.06);
        }

        .retry-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            width:
                100%;

            min-height:
                48px;

            margin-top:
                12px;

            color:
                var(--pay-primary);

            background:
                rgba(37,99,235,.07);

            border:
                1px solid
                rgba(37,99,235,.17);

            border-radius:
                13px;

            text-decoration:
                none;

            font-size:
                12px;

            font-weight:
                850;

            transition:
                .2s ease;
        }

        .retry-btn:hover {

            color:
                white;

            background:
                var(--pay-primary);

            border-color:
                var(--pay-primary);
        }


        /* ==========================================================
           SECURITY
        ========================================================== */

        .security-row {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            flex-wrap:
                wrap;

            gap:
                18px;

            margin-top:
                24px;

            color:
                var(--pay-muted);

            font-size:
                10px;

            font-weight:
                700;
        }

        .security-item {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                5px;
        }

        .security-item i {

            color:
                var(--pay-success);
        }


        /* ==========================================================
           LOADING
        ========================================================== */

        .payment-loader {

            width:
                15px;

            height:
                15px;

            display:
                inline-block;

            border:
                2px solid
                rgba(255,255,255,.35);

            border-top-color:
                white;

            border-radius:
                50%;

            animation:
                spin .7s linear infinite;
        }

        @keyframes spin {

            to {
                transform:
                    rotate(360deg);
            }

        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 650px) {

            .payment-page {

                padding:
                    20px 10px 60px;
            }

            .payment-topbar {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

            .secure-badge {

                align-self:
                    flex-start;
            }

            .payment-card {

                padding:
                    21px 16px;

                border-radius:
                    22px;
            }

            .payment-header {

                align-items:
                    flex-start;
            }

            .payment-logo {

                width:
                    52px;

                height:
                    52px;

                border-radius:
                    15px;
            }

            .payment-title {

                font-size:
                    24px;
            }

            .payment-actions {

                grid-template-columns:
                    1fr;
            }

            .summary-row {

                align-items:
                    flex-start;

                flex-direction:
                    column;

                gap:
                    5px;
            }

            .summary-value {

                text-align:
                    left;
            }

        }

    </style>

</head>


@php

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';

    if (!in_array(
        $customerTheme,
        ['dark', 'light', 'system'],
        true
    )) {
        $customerTheme = 'system';
    }


    $paymentStatus =
        strtolower($payment->status);


    if ($paymentStatus === 'paid') {

        $statusType = 'success';

        $statusIcon =
            'fa-circle-check';

        $statusTitle =
            'Payment Successful';

        $statusDescription =
            'Your payment has been verified successfully.';

    } elseif ($paymentStatus === 'failed') {

        $statusType = 'failed';

        $statusIcon =
            'fa-circle-xmark';

        $statusTitle =
            'Payment Failed';

        $statusDescription =
            $payment->failure_reason
            ?: 'Payment could not be completed.';

    } elseif ($paymentStatus === 'cancelled') {

        $statusType = 'cancelled';

        $statusIcon =
            'fa-ban';

        $statusTitle =
            'Payment Cancelled';

        $statusDescription =
            'Your order was not confirmed. You can retry the payment.';

    } else {

        $statusType = 'pending';

        $statusIcon =
            'fa-clock';

        $statusTitle =
            'Payment Pending';

        $statusDescription =
            $gatewayReady
                ? 'Start the secure payment process to confirm your order.'
                : 'Online payment gateway is not configured yet.';

    }

@endphp


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


<main class="payment-page">

    <div class="payment-container">


        <!-- ======================================================
             TOP
        ======================================================= -->

        <div class="payment-topbar">

            <a
                href="{{ route('products.index') }}"
                class="back-link"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Continue Shopping

            </a>


            <div class="secure-badge">

                <i class="fa-solid fa-shield-halved"></i>

                Secure Payment

            </div>

        </div>


        <!-- ======================================================
             MAIN
        ======================================================= -->

        <section class="payment-card">


            <!-- HEADER -->

            <div class="payment-header">

                <div class="payment-logo">

                    <i class="fa-solid fa-credit-card"></i>

                </div>


                <div>

                    <h1 class="payment-title">

                        Payment Verification

                    </h1>


                    <p class="payment-subtitle">

                        Complete your payment securely with
                        SMART BASKET.

                    </p>

                </div>

            </div>


            <!-- SESSION ERROR -->

            @if(session('error'))

                <div
                    class="alert alert-warning border-0"
                >

                    <i
                        class="fa-solid fa-triangle-exclamation me-2"
                    ></i>

                    {{ session('error') }}

                </div>

            @endif


            <!-- STATUS -->

            <div
                id="paymentMessage"
                class="status-box"
            >

                <div
                    id="statusIcon"
                    class="status-icon {{ $statusType }}"
                >

                    <i
                        class="fa-solid {{ $statusIcon }}"
                    ></i>

                </div>


                <div>

                    <div
                        id="statusTitle"
                        class="status-title"
                    >

                        {{ $statusTitle }}

                    </div>


                    <div
                        id="statusDescription"
                        class="status-description"
                    >

                        {{ $statusDescription }}

                    </div>

                </div>

            </div>


            <!-- PAYMENT SUMMARY -->

            <div class="summary-card">

                <div class="summary-title">

                    <i
                        class="fa-solid fa-receipt me-2"
                    ></i>

                    Payment Summary

                </div>


                <div class="summary-row">

                    <span class="summary-label">

                        Payment Method

                    </span>


                    <span
                        class="method-badge"
                    >

                        @if(
                            strtoupper(
                                $payment->payment_method
                            ) === 'UPI'
                        )

                            <i
                                class="fa-solid fa-mobile-screen-button"
                            ></i>

                        @elseif(
                            strtoupper(
                                $payment->payment_method
                            ) === 'CARD'
                        )

                            <i
                                class="fa-solid fa-credit-card"
                            ></i>

                        @else

                            <i
                                class="fa-solid fa-wallet"
                            ></i>

                        @endif

                        {{ $payment->payment_method }}

                    </span>

                </div>


                <div class="summary-row">

                    <span class="summary-label">

                        Amount

                    </span>


                    <strong class="amount-value">

                        ₹{{ number_format(
                            (float) $payment->amount,
                            2
                        ) }}

                    </strong>

                </div>


                <div class="summary-row">

                    <span class="summary-label">

                        Payment Status

                    </span>


                    <strong
                        id="paymentStatus"
                        class="summary-value"
                    >

                        {{ ucfirst($payment->status) }}

                    </strong>

                </div>

            </div>


            <!-- ==================================================
                 ACTIONS
            =================================================== -->

            @if($gatewayReady)

                <div class="payment-actions">


                    <button
                        type="button"
                        class="pay-now-btn"
                        id="payNowBtn"
                    >

                        <i
                            class="fa-solid fa-lock me-2"
                        ></i>

                        Pay Now

                    </button>


                    <form
                        method="POST"
                        action="{{
                            route(
                                'payments.cancel',
                                $payment
                            )
                        }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="secondary-btn w-100"
                        >

                            <i
                                class="fa-solid fa-arrow-left"
                            ></i>

                            Back to Checkout

                        </button>

                    </form>

                </div>


                <a
                    href="{{
                        route(
                            'payments.show',
                            $payment
                        )
                    }}"
                    class="retry-btn"
                >

                    <i
                        class="fa-solid fa-rotate-right me-1"
                    ></i>

                    Retry Payment

                </a>

            @else

                <button
                    type="button"
                    class="pay-now-btn"
                    disabled
                >

                    <i
                        class="fa-solid fa-clock me-2"
                    ></i>

                    Payment Pending

                </button>

            @endif


            <!-- ==================================================
                 SECURITY
            =================================================== -->

            <div class="security-row">

                <span class="security-item">

                    <i
                        class="fa-solid fa-lock"
                    ></i>

                    Secure

                </span>


                <span class="security-item">

                    <i
                        class="fa-solid fa-shield-halved"
                    ></i>

                    Protected

                </span>


                <span class="security-item">

                    <i
                        class="fa-solid fa-bolt"
                    ></i>

                    Fast Payment

                </span>


                <span class="security-item">

                    <i
                        class="fa-solid fa-check"
                    ></i>

                    Verified

                </span>

            </div>

        </section>

    </div>

</main>


@if($gatewayReady)

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

(() => {

    const button =
        document.getElementById(
            'payNowBtn'
        );

    const message =
        document.getElementById(
            'paymentMessage'
        );

    const status =
        document.getElementById(
            'paymentStatus'
        );

    const statusIcon =
        document.getElementById(
            'statusIcon'
        );

    const statusTitle =
        document.getElementById(
            'statusTitle'
        );

    const statusDescription =
        document.getElementById(
            'statusDescription'
        );

    const csrf =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).content;


    let processing = false;


    function updateStatus(
        type,
        icon,
        title,
        description,
        statusText
    ) {

        statusIcon.className =
            'status-icon ' + type;

        statusIcon.innerHTML =
            '<i class="fa-solid ' +
            icon +
            '"></i>';

        statusTitle.textContent =
            title;

        statusDescription.textContent =
            description;

        status.textContent =
            statusText;

    }


    const verifyPayment =
        async (response) => {

            const res =
                await fetch(
                    @json(
                        route(
                            'payments.verify',
                            $payment
                        )
                    ),
                    {
                        method: 'POST',

                        credentials:
                            'same-origin',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrf,

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        body:
                            JSON.stringify(
                                response
                            )
                    }
                );


            const data =
                await res.json();


            if (
                !res.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message
                    ||
                    'Payment verification failed'
                );

            }


            return data;

        };


    button.addEventListener(
        'click',
        () => {

            if (processing) {
                return;
            }


            processing = true;

            button.disabled = true;


            button.innerHTML = `
                <span class="payment-loader me-2"></span>
                Processing Payment...
            `;


            updateStatus(
                'pending',
                'fa-spinner fa-spin',
                'Processing Payment',
                'Please complete the payment in the secure Razorpay window.',
                'Processing'
            );


            const checkout =
                new Razorpay({

                    key:
                        @json($razorpayKey),

                    amount:
                        @json($payment->amount_paise),

                    currency:
                        @json($payment->currency),

                    name:
                        'Smart Basket',

                    description:
                        'Order payment',

                    order_id:
                        @json(
                            $payment->gateway_order_id
                        ),

                    prefill: {

                        name:
                            @json(
                                $payment
                                    ->customer_details['name']
                                ?? ''
                            ),

                        contact:
                            @json(
                                $payment
                                    ->customer_details['mobile']
                                ?? ''
                            )

                    },


                    handler:
                        async (
                            response
                        ) => {

                            try {

                                updateStatus(
                                    'pending',
                                    'fa-spinner fa-spin',
                                    'Verifying Payment',
                                    'Payment received. Verifying your transaction securely...',
                                    'Verifying'
                                );


                                const data =
                                    await verifyPayment(
                                        response
                                    );


                                updateStatus(
                                    'success',
                                    'fa-circle-check',
                                    'Payment Successful',
                                    'Your payment has been verified. Your order is confirmed.',
                                    'Paid'
                                );


                                button.innerHTML = `
                                    <i class="fa-solid fa-check me-2"></i>
                                    Payment Successful
                                `;


                                setTimeout(
                                    () => {

                                        window.location.href =
                                            data.redirect;

                                    },
                                    700
                                );


                            } catch (
                                error
                            ) {

                                updateStatus(
                                    'failed',
                                    'fa-circle-xmark',
                                    'Payment Verification Failed',
                                    error.message,
                                    'Failed'
                                );


                                processing =
                                    false;

                                button.disabled =
                                    false;


                                button.innerHTML = `
                                    <i class="fa-solid fa-rotate-right me-2"></i>
                                    Retry Payment
                                `;

                            }

                        },


                    modal: {

                        ondismiss:
                            () => {

                                updateStatus(
                                    'cancelled',
                                    'fa-ban',
                                    'Payment Cancelled',
                                    'Your order was not confirmed. You can safely retry the payment.',
                                    'Cancelled'
                                );


                                processing =
                                    false;

                                button.disabled =
                                    false;


                                button.innerHTML = `
                                    <i class="fa-solid fa-rotate-right me-2"></i>
                                    Retry Payment
                                `;

                            }

                    }

                });


            checkout.on(
                'payment.failed',
                (response) => {

                    const description =
                        response.error &&
                        response.error.description
                            ? response.error.description
                            : 'Payment Failed';


                    updateStatus(
                        'failed',
                        'fa-circle-xmark',
                        'Payment Failed',
                        description,
                        'Failed'
                    );


                    processing =
                        false;

                    button.disabled =
                        false;


                    button.innerHTML = `
                        <i class="fa-solid fa-rotate-right me-2"></i>
                        Retry Payment
                    `;

                }
            );


            checkout.open();

        }
    );

})();

</script>

@endif


<!-- ==============================================================
     CUSTOMER THEME
=============================================================== -->

<script>

(function () {

    const body =
        document.body;

    const savedTheme =
        body.dataset.customerTheme
        || 'system';


    function getSystemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    function applyTheme(theme) {

        const finalTheme =
            theme === 'system'
                ? getSystemTheme()
                : theme;


        document.documentElement
            .setAttribute(
                'data-sb-theme',
                finalTheme
            );


        body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

    }


    applyTheme(savedTheme);


    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    const systemThemeChanged =
        () => {

            if (
                body.dataset.customerTheme
                === 'system'
            ) {

                applyTheme('system');

            }

        };


    if (media.addEventListener) {

        media.addEventListener(
            'change',
            systemThemeChanged
        );

    } else if (media.addListener) {

        media.addListener(
            systemThemeChanged
        );

    }

})();

</script>


</body>
</html>
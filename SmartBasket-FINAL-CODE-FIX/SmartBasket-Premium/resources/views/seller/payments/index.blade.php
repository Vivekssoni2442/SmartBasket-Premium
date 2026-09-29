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
           PREMIUM SELLER PAYMENT HISTORY
           TASKBAR SAFE
           FULL WIDTH
           RESPONSIVE
        ========================================================= */

        .payment-page,
        .payment-page * {
            box-sizing: border-box;
        }


        /* =========================================================
           PAGE VARIABLES
        ========================================================= */

        .payment-page {

            --pay-primary: #2563eb;
            --pay-primary-dark: #1d4ed8;
            --pay-primary-soft: #eff6ff;

            --pay-indigo: #4f46e5;
            --pay-indigo-soft: #eef2ff;

            --pay-green: #16a34a;
            --pay-green-soft: #ecfdf3;

            --pay-orange: #f59e0b;
            --pay-orange-soft: #fff7e6;

            --pay-red: #ef4444;
            --pay-red-soft: #fff1f2;

            --pay-purple: #8b5cf6;
            --pay-purple-soft: #f5f3ff;

            --pay-bg: #f4f7fb;
            --pay-card: rgba(255,255,255,.96);

            --pay-text: #0f172a;
            --pay-text-2: #334155;
            --pay-muted: #64748b;
            --pay-muted-2: #94a3b8;

            --pay-border: #e2e8f0;
            --pay-border-soft: #edf1f5;

            --pay-shadow:
                0 10px 30px rgba(15,23,42,.055);

            --pay-shadow-hover:
                0 18px 42px rgba(37,99,235,.12);

            position: relative;

            width: 100%;
            max-width: none;

            min-height: calc(100vh - 1px);

            margin: 0;

            padding:
                clamp(16px, 1.8vw, 28px)
                clamp(12px, 1.8vw, 32px)
                55px;

            color: var(--pay-text);

            overflow: hidden;

            isolation: isolate;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(37,99,235,.07),
                    transparent 23%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(79,70,229,.065),
                    transparent 22%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f3f6fb 50%,
                    #f8fafc 100%
                );
        }


        .payment-page::before {

            content: "";

            position: absolute;

            width: 430px;
            height: 430px;

            right: -230px;
            top: 250px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.045),
                    transparent 70%
                );

            pointer-events: none;

            z-index: -1;
        }


        .payment-page::after {

            content: "";

            position: absolute;

            width: 350px;
            height: 350px;

            left: -230px;
            bottom: 50px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(79,70,229,.035),
                    transparent 70%
                );

            pointer-events: none;

            z-index: -1;
        }


        /* =========================================================
           MAIN HEADER
        ========================================================= */

        .payment-header {

            position: relative;

            width: 100%;

            min-height: 128px;

            display: flex;
            align-items: center;

            padding:
                clamp(20px, 2vw, 28px)
                clamp(18px, 2.2vw, 34px);

            margin-bottom: 16px;

            overflow: hidden;

            border:
                1px solid rgba(191,219,254,.85);

            border-radius: 22px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.98),
                    rgba(248,251,255,.98) 55%,
                    rgba(239,246,255,.96)
                );

            box-shadow:
                0 12px 38px rgba(15,23,42,.065);
        }


        .payment-header::before {

            content: "";

            position: absolute;

            left: 0;
            top: 0;
            bottom: 0;

            width: 5px;

            background:
                linear-gradient(
                    180deg,
                    var(--pay-primary),
                    var(--pay-indigo)
                );
        }


        .payment-header::after {

            content: "";

            position: absolute;

            width: 310px;
            height: 310px;

            right: -120px;
            top: -155px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.12),
                    transparent 68%
                );

            pointer-events: none;
        }


        .payment-heading-wrap {

            position: relative;

            z-index: 2;

            width: 100%;

            min-width: 0;

            display: flex;
            align-items: center;

            gap: 17px;
        }


        /* =========================================================
           HEADER ICON
        ========================================================= */

        .payment-title-icon {

            width: 60px;
            height: 60px;

            flex: 0 0 60px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 17px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--pay-primary),
                    var(--pay-indigo)
                );

            box-shadow:
                0 11px 26px rgba(37,99,235,.23);

            font-size: 21px;
        }


        .payment-title-content {

            min-width: 0;
        }


        .payment-title {

            margin: 0;

            color: var(--pay-text);

            font-size:
                clamp(25px, 2.2vw, 35px);

            line-height: 1.08;

            font-weight: 900;

            letter-spacing: -.9px;
        }


        .payment-title span {

            color: var(--pay-primary);
        }


        .payment-subtitle {

            margin:
                8px 0 0;

            color: var(--pay-muted);

            font-size: 11px;

            line-height: 1.5;

            font-weight: 600;
        }


        .payment-subtitle strong {

            color: var(--pay-text-2);

            font-weight: 800;
        }


        /* =========================================================
           SUMMARY
        ========================================================= */

        .summary-grid {

            width: 100%;

            display: grid;

            grid-template-columns:
                1.35fr
                repeat(4, minmax(0, 1fr));

            gap: 12px;

            margin-bottom: 15px;
        }


        .summary-card {

            position: relative;

            min-width: 0;

            min-height: 112px;

            padding: 18px;

            overflow: hidden;

            border:
                1px solid var(--pay-border);

            border-radius: 16px;

            background:
                rgba(255,255,255,.96);

            box-shadow:
                var(--pay-shadow);

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                border-color .22s ease;
        }


        .summary-card:hover {

            transform: translateY(-3px);

            border-color:
                rgba(37,99,235,.24);

            box-shadow:
                var(--pay-shadow-hover);
        }


        .summary-card::after {

            content: "";

            position: absolute;

            width: 120px;
            height: 120px;

            right: -50px;
            bottom: -55px;

            border-radius: 50%;

            background:
                rgba(37,99,235,.055);

            filter: blur(10px);

            pointer-events: none;
        }


        .summary-card.received {

            border-color:
                rgba(37,99,235,.20);

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f7faff 55%,
                    #eff6ff
                );
        }


        .summary-card.received::before {

            content: "";

            position: absolute;

            left: 0;
            top: 0;
            bottom: 0;

            width: 4px;

            background:
                linear-gradient(
                    180deg,
                    var(--pay-primary),
                    var(--pay-indigo)
                );
        }


        .summary-label {

            position: relative;
            z-index: 2;

            display: block;

            color: var(--pay-muted);

            font-size: 9px;

            font-weight: 850;

            text-transform: uppercase;

            letter-spacing: .09em;
        }


        .summary-value {

            position: relative;
            z-index: 2;

            display: block;

            margin-top: 9px;

            color: var(--pay-text);

            font-size: 23px;

            line-height: 1;

            font-weight: 900;

            letter-spacing: -.6px;
        }


        .received .summary-value {

            color: var(--pay-primary);

            font-size: 27px;
        }


        .summary-icon {

            position: absolute;

            z-index: 1;

            right: 17px;
            top: 16px;

            color:
                rgba(37,99,235,.09);

            font-size: 23px;
        }


        .received .summary-icon {

            color:
                rgba(37,99,235,.15);
        }


        /* =========================================================
           FILTER CARD
        ========================================================= */

        .filter-card {

            position: relative;

            width: 100%;

            margin-bottom: 15px;

            padding: 16px;

            overflow: hidden;

            border:
                1px solid var(--pay-border);

            border-radius: 17px;

            background:
                rgba(255,255,255,.97);

            box-shadow:
                var(--pay-shadow);
        }


        .filter-card::before {

            content: "";

            position: absolute;

            left: 0;
            right: 0;
            top: 0;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    var(--pay-primary),
                    var(--pay-indigo)
                );
        }


        .filter-top {

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 11px;
        }


        .filter-title {

            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--pay-text-2);

            font-size: 11px;

            font-weight: 850;
        }


        .filter-title i {

            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            color: var(--pay-primary);

            background:
                var(--pay-primary-soft);

            font-size: 10px;
        }


        .filter-hint {

            color: var(--pay-muted-2);

            font-size: 9px;

            font-weight: 600;
        }


        /* =========================================================
           FORM CONTROLS
        ========================================================= */

        .payment-page .form-control,
        .payment-page .form-select {

            min-height: 43px;

            color: var(--pay-text-2) !important;

            background: #f8fafc !important;

            border:
                1px solid #dfe6ef !important;

            border-radius: 10px !important;

            font-size: 11px !important;

            font-weight: 600;

            box-shadow:
                inset 0 1px 2px rgba(15,23,42,.015);

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .payment-page .form-control::placeholder {

            color: #94a3b8 !important;

            font-weight: 500;
        }


        .payment-page .form-control:hover,
        .payment-page .form-select:hover {

            border-color:
                #cbd5e1 !important;

            background:
                #ffffff !important;
        }


        .payment-page .form-control:focus,
        .payment-page .form-select:focus {

            color: var(--pay-text) !important;

            background:
                #ffffff !important;

            border-color:
                rgba(37,99,235,.65) !important;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.08) !important;

            outline: none !important;
        }


        .payment-page .form-select option {

            color: #111827;

            background: #ffffff;
        }


        .payment-page input[type="date"] {

            color-scheme: light;
        }


        /* =========================================================
           FILTER BUTTON
        ========================================================= */

        .filter-btn {

            width: 100%;

            min-height: 43px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            border: 0;

            border-radius: 10px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--pay-primary),
                    var(--pay-primary-dark)
                );

            font-size: 11px;

            font-weight: 850;

            box-shadow:
                0 8px 20px rgba(37,99,235,.17);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .filter-btn:hover {

            color: #ffffff;

            transform: translateY(-2px);

            box-shadow:
                0 12px 27px rgba(37,99,235,.24);
        }


        /* =========================================================
           PAYMENT LIST
        ========================================================= */

        .payments-card {

            width: 100%;

            overflow: hidden;

            border:
                1px solid var(--pay-border);

            border-radius: 20px;

            background:
                rgba(255,255,255,.98);

            box-shadow:
                0 13px 42px rgba(15,23,42,.065);
        }


        /* =========================================================
           PAYMENT ROW
        ========================================================= */

        .payment-row {

            position: relative;

            width: 100%;

            min-width: 0;

            padding:
                20px clamp(15px, 2vw, 26px);

            border-bottom:
                1px solid var(--pay-border-soft);

            background:
                rgba(255,255,255,.98);

            transition:
                background .2s ease,
                box-shadow .2s ease;
        }


        .payment-row:last-child {

            border-bottom: 0;
        }


        .payment-row::before {

            content: "";

            position: absolute;

            left: 0;

            top: 0;
            bottom: 0;

            width: 3px;

            opacity: 0;

            background:
                linear-gradient(
                    180deg,
                    var(--pay-primary),
                    var(--pay-indigo)
                );

            transition: opacity .2s ease;
        }


        .payment-row:hover {

            background:
                linear-gradient(
                    90deg,
                    #ffffff,
                    #f9fbff
                );

            box-shadow:
                inset 0 0 35px rgba(37,99,235,.018);
        }


        .payment-row:hover::before {

            opacity: 1;
        }


        .payment-row-top {

            min-height: 53px;
        }


        /* =========================================================
           CUSTOMER
        ========================================================= */

        .customer-name {

            color: var(--pay-text);

            font-size: 14px;

            font-weight: 850;

            letter-spacing: -.15px;
        }


        .customer-icon {

            margin-right: 5px;

            color: var(--pay-primary);
        }


        .customer-uid {

            margin-top: 4px;

            color: var(--pay-primary);

            font-size: 10px;

            font-weight: 700;

            overflow-wrap: anywhere;
        }


        .order-meta {

            margin-top: 4px;

            color: var(--pay-muted-2);

            font-size: 10px;

            font-weight: 500;

            overflow-wrap: anywhere;
        }


        .order-meta i {

            color: var(--pay-muted);
        }


        /* =========================================================
           AMOUNT
        ========================================================= */

        .payment-amount-box {

            min-width: 150px;

            flex-shrink: 0;
        }


        .payment-amount {

            color: var(--pay-primary);

            font-size: 21px;

            font-weight: 900;

            letter-spacing: -.5px;
        }


        .payment-status {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            margin-top: 6px;

            padding:
                4px 10px;

            border-radius: 999px;

            font-size: 9px;

            font-weight: 850;

            letter-spacing: .02em;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .status-successful {

            color: #15803d;

            background:
                var(--pay-green-soft);

            border:
                1px solid #bbf7d0;
        }


        .status-pending {

            color: #b45309;

            background:
                var(--pay-orange-soft);

            border:
                1px solid #f7dca2;
        }


        .status-failed {

            color: #dc2626;

            background:
                var(--pay-red-soft);

            border:
                1px solid #fecdd3;
        }


        .status-refunded {

            color: #7c3aed;

            background:
                var(--pay-purple-soft);

            border:
                1px solid #ddd6fe;
        }


        /* =========================================================
           PRODUCT SECTION
        ========================================================= */

        .product-section {

            margin-top: 14px;

            padding:
                13px 14px;

            border:
                1px solid #e3ebf5;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #f8fbff,
                    #fbfdff
                );
        }


        .product-section::before {

            content: "ORDER ITEMS";

            display: block;

            margin-bottom: 8px;

            color: #94a3b8;

            font-size: 7px;

            font-weight: 850;

            letter-spacing: .12em;
        }


        .product-line {

            display: flex;

            align-items: center;

            gap: 10px;

            min-width: 0;

            margin-top: 7px;

            color: var(--pay-text-2);

            font-size: 11px;

            font-weight: 650;
        }


        .product-line:first-of-type {

            margin-top: 0;
        }


        .product-line span {

            min-width: 0;

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
                1px solid #dfe7f1;

            background:
                #ffffff;

            box-shadow:
                0 3px 9px rgba(15,23,42,.04);
        }


        .product-placeholder {

            display: flex;

            align-items: center;
            justify-content: center;

            color: var(--pay-primary);

            background:
                var(--pay-primary-soft);

            font-size: 13px;
        }


        /* =========================================================
           PAYMENT METHOD
        ========================================================= */

        .payment-method {

            display: flex;

            align-items: center;

            flex-wrap: wrap;

            gap: 4px;

            margin-top: 10px;

            color: var(--pay-muted);

            font-size: 10px;

            font-weight: 650;
        }


        .payment-method > i {

            color: var(--pay-primary);
        }


        .transaction-text {

            color: var(--pay-muted-2);
        }


        /* =========================================================
           ACTION BUTTONS
        ========================================================= */

        .payment-actions {

            display: flex;

            flex-wrap: wrap;

            gap: 8px;

            margin-top: 13px;
        }


        .action-btn {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            min-height: 36px;

            padding:
                0 13px;

            border-radius: 9px;

            text-decoration: none;

            font-size: 9px;

            font-weight: 850;

            transition:
                transform .18s ease,
                background .18s ease,
                border-color .18s ease,
                color .18s ease,
                box-shadow .18s ease;
        }


        .action-btn:hover {

            transform: translateY(-2px);
        }


        .view-btn {

            color: var(--pay-primary);

            background:
                var(--pay-primary-soft);

            border:
                1px solid #bfdbfe;
        }


        .view-btn:hover {

            color: #ffffff;

            background:
                var(--pay-primary);

            border-color:
                var(--pay-primary);

            box-shadow:
                0 7px 17px rgba(37,99,235,.18);
        }


        .receipt-btn {

            color: var(--pay-indigo);

            background:
                var(--pay-indigo-soft);

            border:
                1px solid #c7d2fe;
        }


        .receipt-btn:hover {

            color: #ffffff;

            background:
                var(--pay-indigo);

            border-color:
                var(--pay-indigo);

            box-shadow:
                0 7px 17px rgba(79,70,229,.18);
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-payment {

            width: 100%;

            padding:
                75px 25px;

            text-align: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fbfcfe
                );
        }


        .empty-payment-icon {

            width: 74px;
            height: 74px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin:
                0 auto 16px;

            border-radius: 21px;

            background:
                linear-gradient(
                    145deg,
                    #eff6ff,
                    #f5f7ff
                );

            border:
                1px solid #bfdbfe;

            color: var(--pay-primary);

            font-size: 27px;

            box-shadow:
                0 10px 25px rgba(37,99,235,.08);
        }


        .empty-payment h5 {

            margin: 0;

            color: var(--pay-text-2);

            font-size: 18px;

            font-weight: 850;
        }


        .empty-payment p {

            margin-top: 7px;

            color: var(--pay-muted-2);

            font-size: 11px;
        }


        /* =========================================================
           LARGE DESKTOP
        ========================================================= */

        @media (min-width: 1600px) {

            .payment-page {

                padding-left: 38px;
                padding-right: 38px;
            }

            .summary-grid {

                gap: 15px;
            }

            .payment-row {

                padding-left: 30px;
                padding-right: 30px;
            }
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1200px) {

            .summary-grid {

                grid-template-columns:
                    repeat(4, minmax(0, 1fr));
            }


            .summary-card.received {

                grid-column:
                    span 2;
            }
        }


        @media (max-width: 950px) {

            .payment-page {

                padding:
                    18px
                    15px
                    45px;
            }


            .summary-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .summary-card.received {

                grid-column:
                    span 2;
            }
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 700px) {

            .payment-page {

                padding:
                    14px
                    10px
                    40px;
            }


            .payment-header {

                min-height: auto;

                padding:
                    17px 15px;

                margin-bottom: 12px;

                border-radius: 17px;
            }


            .payment-heading-wrap {

                align-items: flex-start;

                gap: 12px;
            }


            .payment-title-icon {

                width: 46px;
                height: 46px;

                flex-basis: 46px;

                border-radius: 13px;

                font-size: 17px;
            }


            .payment-title {

                font-size: 22px;

                letter-spacing: -.55px;
            }


            .payment-subtitle {

                margin-top: 6px;

                font-size: 9px;
            }


            .summary-grid {

                grid-template-columns:
                    1fr 1fr;

                gap: 9px;

                margin-bottom: 12px;
            }


            .summary-card {

                min-height: 98px;

                padding: 14px;

                border-radius: 14px;
            }


            .summary-card.received {

                grid-column:
                    span 2;
            }


            .summary-label {

                font-size: 8px;
            }


            .summary-value {

                font-size: 19px;
            }


            .received .summary-value {

                font-size: 23px;
            }


            .summary-icon {

                right: 12px;
                top: 12px;

                font-size: 18px;
            }


            .filter-card {

                padding: 13px;

                border-radius: 14px;

                margin-bottom: 12px;
            }


            .filter-top {

                margin-bottom: 9px;
            }


            .filter-hint {

                display: none;
            }


            .payment-page .form-control,
            .payment-page .form-select,
            .filter-btn {

                min-height: 42px;
            }


            .payments-card {

                border-radius: 16px;
            }


            .payment-row {

                padding:
                    17px 14px;
            }


            .payment-row-top {

                flex-direction: column;

                gap: 12px;
            }


            .payment-amount-box {

                width: 100%;

                min-width: 0;

                text-align: left !important;
            }


            .payment-amount {

                font-size: 19px;
            }


            .product-section {

                padding:
                    11px;
            }


            .payment-actions {

                width: 100%;
            }


            .action-btn {

                min-height: 36px;

                font-size: 9px;
            }
        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 430px) {

            .payment-page {

                padding-left: 8px;
                padding-right: 8px;
            }


            .payment-header {

                padding:
                    14px;

                border-radius: 15px;
            }


            .payment-heading-wrap {

                gap: 10px;
            }


            .payment-title-icon {

                width: 41px;
                height: 41px;

                flex-basis: 41px;

                border-radius: 11px;

                font-size: 15px;
            }


            .payment-title {

                font-size: 19px;
            }


            .payment-subtitle {

                font-size: 8px;
            }


            .summary-card {

                padding: 12px;

                min-height: 93px;
            }


            .summary-value {

                font-size: 17px;
            }


            .received .summary-value {

                font-size: 21px;
            }


            .payment-actions {

                display: grid;

                grid-template-columns:
                    1fr 1fr;

                width: 100%;
            }


            .action-btn {

                width: 100%;

                padding:
                    0 7px;

                font-size: 8px;
            }


            .customer-name {

                font-size: 13px;
            }


            .customer-uid,
            .order-meta,
            .payment-method {

                font-size: 9px;
            }


            .product-line {

                font-size: 10px;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .payment-page *,
            .payment-page *::before,
            .payment-page *::after {

                transition: none !important;

                animation: none !important;
            }
        }

    </style>

</head>


<body>


    {{-- =====================================================
         COMMON SELLER TASKBAR / TOPBAR
         DO NOT CHANGE
    ====================================================== --}}

    @include('seller.partials.topbar')


    {{-- =====================================================
         COMMON SELLER MENU
         DO NOT CHANGE
    ====================================================== --}}

    @include('seller.partials.seller-menu')


    {{-- =====================================================
         MAIN PAYMENT PAGE
    ====================================================== --}}

    <main class="payment-page">


        {{-- =====================================================
             PREMIUM PAGE HEADER
        ====================================================== --}}

        <header class="payment-header">

            <div class="payment-heading-wrap">

                <span class="payment-title-icon">

                    <i class="fa-solid fa-wallet"></i>

                </span>


                <div class="payment-title-content">

                    <h1 class="payment-title">

                        Payment
                        <span>History</span>

                    </h1>


                    <p class="payment-subtitle">

                        Customer payments for

                        <strong>
                            {{ $seller->shop_name ?: $seller->seller_name }}
                        </strong>

                    </p>

                </div>

            </div>

        </header>


        {{-- =====================================================
             PAYMENT SUMMARY
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

                        <i class="fa-solid fa-filter"></i>

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


                {{-- =================================================
                     PAYMENT ITEM
                ================================================== --}}

                <article class="payment-row">


                    {{-- CUSTOMER + AMOUNT --}}

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

                                {{ $customer?->name ?: $order->name ?: 'Guest Customer' }}

                            </div>


                            <div class="customer-uid">

                                Customer UID:

                                {{ $customer?->customer_uid ?: 'Guest checkout — no customer UID' }}

                            </div>


                            <div class="order-meta">

                                <i
                                    class="
                                        fa-solid
                                        fa-receipt
                                        me-1
                                    "
                                ></i>

                                Order #SB-{{ $order->id }}

                                <span class="mx-1">
                                    ·
                                </span>


                                @if($order->created_at)

                                    {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y · h:i A') }}

                                @else

                                    Not available

                                @endif

                            </div>

                        </div>


                        {{-- AMOUNT --}}

                        <div class="payment-amount-box text-end">

                            <div class="payment-amount">

                                ₹{{ number_format((float) $order->total, 2) }}

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

                                        <i class="fa-solid fa-box"></i>

                                    </div>

                                @endif


                                <span>

                                    {{ $item['name'] ?? $product?->name ?? 'Product' }}

                                    ×

                                    {{ $item['quantity'] ?? 1 }}

                                </span>


                            </div>


                        @empty


                            <span class="transaction-text small">

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
                         CURRENT PAGE ACTIONS
                    ================================================== --}}

                    <div class="payment-actions">


                        {{-- VIEW PAYMENT --}}

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


                        {{-- PAYMENT RECEIPT --}}

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


                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

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

</html>
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

    <style>
        /* =========================================================
           SMART BASKET
           PREMIUM SELLER ORDER CENTER
           FULL-WIDTH DISPLAY DESIGN
           TASKBAR IS NOT MODIFIED
        ========================================================= */

        :root {
            --sb-blue: #2563eb;
            --sb-blue-dark: #1d4ed8;
            --sb-blue-deep: #1e3a8a;
            --sb-blue-light: #60a5fa;
            --sb-cyan: #06b6d4;

            --sb-bg: #f5f8fc;
            --sb-bg-2: #eef4fb;
            --sb-card: rgba(255, 255, 255, .96);
            --sb-card-solid: #ffffff;

            --sb-text: #172033;
            --sb-text-2: #475569;
            --sb-muted: #8490a3;

            --sb-border: #e3eaf4;
            --sb-border-soft: #edf2f7;

            --sb-green: #059669;
            --sb-green-soft: #ecfdf5;
            --sb-green-border: #c8efdf;

            --sb-orange: #d97706;
            --sb-orange-soft: #fff7e8;
            --sb-orange-border: #f4dfad;

            --sb-red: #dc3545;
            --sb-red-soft: #fff1f2;
            --sb-red-border: #ffd0d7;

            --sb-shadow:
                0 20px 60px rgba(15, 23, 42, .065),
                0 5px 18px rgba(37, 99, 235, .025);

            --sb-shadow-hover:
                0 28px 75px rgba(15, 23, 42, .11),
                0 8px 25px rgba(37, 99, 235, .055);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family:
                Inter,
                Poppins,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(37, 99, 235, .075),
                    transparent 24%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(6, 182, 212, .06),
                    transparent 23%
                ),
                linear-gradient(
                    180deg,
                    #f9fbff 0%,
                    #f4f7fb 55%,
                    #f8fafc 100%
                );

            overflow-x: hidden;
        }

        /* =========================================================
           FULL WIDTH PAGE
        ========================================================= */

        .orders-page {
            width: 100%;
            max-width: none;
            min-height: calc(100vh - 70px);

            margin: 0;
            padding:
                clamp(14px, 1.45vw, 26px)
                clamp(10px, 1.55vw, 28px)
                55px;
        }

        .orders-container {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        /* =========================================================
           PREMIUM HEADER
        ========================================================= */

        .orders-header {
            position: relative;

            width: 100%;
            min-height: 148px;

            display: flex;
            align-items: center;

            margin-bottom: 16px;
            padding:
                clamp(22px, 2vw, 34px)
                clamp(20px, 2.1vw, 38px);

            overflow: hidden;

            border: 1px solid rgba(215, 226, 241, .95);
            border-radius: 24px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #ffffff 48%,
                    #f2f7ff 100%
                );

            box-shadow: var(--sb-shadow);
        }

        .orders-header::before {
            content: "";

            position: absolute;

            width: 520px;
            height: 520px;

            top: -380px;
            right: -80px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37, 99, 235, .14),
                    rgba(37, 99, 235, 0)
                );

            pointer-events: none;
        }

        .orders-header::after {
            content: "";

            position: absolute;

            width: 420px;
            height: 110px;

            left: 24%;
            bottom: -85px;

            border-radius: 50%;

            background: rgba(6, 182, 212, .075);

            filter: blur(28px);

            pointer-events: none;
        }

        .header-left {
            position: relative;
            z-index: 2;

            width: 100%;
            min-width: 0;
        }

        .header-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            margin-bottom: 9px;

            color: var(--sb-blue);

            font-size: 9px;
            font-weight: 900;

            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--sb-blue);

            box-shadow:
                0 0 0 5px rgba(37, 99, 235, .09);
        }

        .header-left h1 {
            display: flex;
            align-items: center;
            gap: 14px;

            margin: 0;

            color: #162033;

            font-size: clamp(25px, 2.35vw, 37px);
            line-height: 1.12;

            font-weight: 900;

            letter-spacing: -1.15px;
        }

        .header-icon {
            width: 53px;
            height: 53px;

            flex: 0 0 53px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #3b82f6,
                    #1d4ed8 70%,
                    #1e3a8a
                );

            box-shadow:
                0 12px 27px rgba(37, 99, 235, .22);

            font-size: 18px;
        }

        .header-left p {
            max-width: 850px;

            margin:
                10px 0 0
                67px;

            color: var(--sb-muted);

            font-size: 12px;
            line-height: 1.65;
        }

        /* =========================================================
           ALERTS
        ========================================================= */

        .premium-alert {
            position: relative;

            display: flex;
            align-items: flex-start;

            width: 100%;

            margin-bottom: 13px;
            padding: 13px 16px;

            color: var(--sb-text-2);

            background: rgba(255, 255, 255, .94);

            border: 1px solid var(--sb-border);
            border-radius: 14px;

            box-shadow:
                0 5px 16px rgba(15, 23, 42, .035);

            font-size: 11px;
            line-height: 1.55;
        }

        .premium-alert.success {
            color: #087f52;

            background:
                linear-gradient(
                    135deg,
                    #f7fffb,
                    #ecfdf5
                );

            border-color: var(--sb-green-border);
        }

        .premium-alert.error {
            color: #b42335;

            background:
                linear-gradient(
                    135deg,
                    #fffafb,
                    #fff1f2
                );

            border-color: var(--sb-red-border);
        }

        .premium-alert i {
            margin-top: 1px;
            font-size: 13px;
        }

        .premium-alert strong {
            font-weight: 850;
        }

        .premium-alert ul {
            padding-left: 19px;
        }

        /* =========================================================
           ORDER CENTER
        ========================================================= */

        .orders-card {
            width: 100%;

            overflow: hidden;

            background: var(--sb-card);

            border: 1px solid var(--sb-border);
            border-radius: 23px;

            box-shadow: var(--sb-shadow);

            transition:
                box-shadow .25s ease,
                transform .25s ease;
        }

        .orders-card:hover {
            box-shadow: var(--sb-shadow-hover);
        }

        /* =========================================================
           ORDER CARD HEADER
        ========================================================= */

        .orders-card-header {
            min-height: 76px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding:
                14px
                clamp(16px, 1.55vw, 25px);

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #fafdff 100%
                );

            border-bottom: 1px solid var(--sb-border);
        }

        .orders-card-title {
            display: flex;
            align-items: center;
            gap: 11px;

            color: var(--sb-text);

            font-size: 15px;
            font-weight: 900;
        }

        .orders-card-title-icon {
            width: 41px;
            height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1e40af
                );

            box-shadow:
                0 8px 19px rgba(37, 99, 235, .18);

            font-size: 13px;
        }

        .order-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 13px;

            color: var(--sb-blue-deep);

            background:
                linear-gradient(
                    135deg,
                    #f1f6ff,
                    #eaf3ff
                );

            border: 1px solid #d7e6fc;
            border-radius: 999px;

            font-size: 9px;
            font-weight: 900;

            white-space: nowrap;
        }

        .order-count::before {
            content: "";

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: var(--sb-blue);

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .08);
        }

        /* =========================================================
           TABLE WRAPPER
        ========================================================= */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;
            overflow-y: hidden;

            scrollbar-width: thin;
            scrollbar-color: #bcc9da transparent;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 7px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #c4d0df;
            border-radius: 999px;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .seller-order-table {
            width: 100%;
            min-width: 1120px;

            margin: 0;

            border-collapse: separate;
            border-spacing: 0;

            color: var(--sb-text);
        }

        .seller-order-table thead th {
            padding:
                13px
                clamp(12px, 1.15vw, 18px);

            color: #748197;

            background:
                linear-gradient(
                    180deg,
                    #fafcff,
                    #f5f8fc
                );

            border-bottom: 1px solid var(--sb-border);

            font-size: 8px;
            font-weight: 900;

            letter-spacing: .95px;
            text-transform: uppercase;

            white-space: nowrap;
        }

        .seller-order-table tbody td {
            padding:
                16px
                clamp(12px, 1.15vw, 18px);

            color: var(--sb-text-2);

            background: #ffffff;

            border-bottom: 1px solid var(--sb-border-soft);

            vertical-align: middle;

            font-size: 11px;
        }

        .seller-order-table tbody tr {
            transition:
                background .18s ease,
                transform .18s ease;
        }

        .seller-order-table tbody tr:hover td {
            background:
                linear-gradient(
                    90deg,
                    #ffffff,
                    #f7fbff
                );
        }

        .seller-order-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* =========================================================
           ORDER ID
        ========================================================= */

        .order-id-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-mini-icon {
            width: 37px;
            height: 37px;

            flex: 0 0 37px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #3b82f6,
                    #1e40af
                );

            box-shadow:
                0 7px 16px rgba(37, 99, 235, .15);

            font-size: 10px;
        }

        .order-number {
            color: #182235;

            font-weight: 900;

            letter-spacing: .15px;
        }

        .order-date {
            margin-top: 4px;

            color: #8b96a8;

            font-size: 9px;
        }

        .order-date i {
            color: var(--sb-blue);
        }

        /* =========================================================
           CUSTOMER
        ========================================================= */

        .customer-name {
            color: #1e293b;

            font-weight: 800;
        }

        .customer-address {
            max-width: 250px;

            margin-top: 4px;

            color: #8994a5;

            font-size: 9px;
            line-height: 1.5;
        }

        .customer-address i {
            color: var(--sb-blue);
        }

        /* =========================================================
           PRODUCT LIST
        ========================================================= */

        .product-list {
            max-width: 330px;
        }

        .product-line {
            display: flex;
            align-items: flex-start;

            gap: 7px;

            margin-bottom: 6px;

            color: #475569;

            font-size: 10px;
            line-height: 1.5;
        }

        .product-line:last-child {
            margin-bottom: 0;
        }

        .product-line i {
            margin-top: 3px;

            color: var(--sb-blue);

            font-size: 8px;
        }

        /* =========================================================
           PAYMENT
        ========================================================= */

        .payment-pill,
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 6px 9px;

            border-radius: 999px;

            font-size: 9px;
            font-weight: 900;

            white-space: nowrap;
        }

        .payment-paid {
            color: #087f52;

            background: var(--sb-green-soft);

            border: 1px solid var(--sb-green-border);
        }

        .payment-pending {
            color: #9a6700;

            background: var(--sb-orange-soft);

            border: 1px solid var(--sb-orange-border);
        }

        .payment-failed {
            color: #b42335;

            background: var(--sb-red-soft);

            border: 1px solid var(--sb-red-border);
        }

        .payment-cod {
            color: #1d5db9;

            background: #eff6ff;

            border: 1px solid #d6e6ff;
        }

        .payment-method-small {
            display: block;

            margin-top: 4px;

            color: #8994a5;

            font-size: 8px;
            font-weight: 650;

            letter-spacing: .1px;
        }

        .payment-verified,
        .payment-warning {
            display: inline-flex;
            align-items: center;
            gap: 4px;

            margin-top: 4px;

            font-size: 7px;
            font-weight: 900;

            letter-spacing: .35px;

            text-transform: uppercase;
        }

        .payment-verified {
            color: #159669;
        }

        .payment-warning {
            color: #ad7305;
        }

        /* =========================================================
           STATUS
        ========================================================= */

        .status-pill {
            color: #1d4ed8;

            background: #eff6ff;

            border: 1px solid #d6e5ff;
        }

        .status-dot {
            width: 5px;
            height: 5px;

            flex: 0 0 5px;

            border-radius: 50%;

            background: var(--sb-blue);

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .08);
        }

        .status-pending {
            color: #9a6700;

            background: var(--sb-orange-soft);

            border-color: var(--sb-orange-border);
        }

        .status-pending .status-dot {
            background: #e0a000;

            box-shadow:
                0 0 0 3px rgba(224, 160, 0, .09);
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .order-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .action-btn {
            min-height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 6px 10px;

            border-radius: 9px;

            font-size: 9px;
            font-weight: 900;

            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease,
                border-color .18s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-delivery {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1e40af
                );

            border: 1px solid #2563eb;

            box-shadow:
                0 6px 14px rgba(37, 99, 235, .14);
        }

        .action-delivery:hover {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #1e3a8a
                );

            box-shadow:
                0 9px 20px rgba(37, 99, 235, .21);
        }

        .action-view {
            color: #475569;

            background: #ffffff;

            border: 1px solid #dce4ef;
        }

        .action-view:hover {
            color: var(--sb-blue);

            background: #eff6ff;

            border-color: #c9dcfb;

            box-shadow:
                0 5px 13px rgba(37, 99, 235, .07);
        }

        /* =========================================================
           EMPTY ORDERS
        ========================================================= */

        .empty-orders {
            padding: 88px 25px;

            text-align: center;

            color: var(--sb-muted);
        }

        .empty-orders-icon {
            width: 78px;
            height: 78px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 17px;

            color: var(--sb-blue);

            background:
                linear-gradient(
                    135deg,
                    #f1f6ff,
                    #e9f2ff
                );

            border: 1px solid #d8e7ff;

            border-radius: 22px;

            box-shadow:
                0 12px 28px rgba(37, 99, 235, .075);

            font-size: 28px;
        }

        .empty-orders h3 {
            margin-bottom: 6px;

            color: var(--sb-text);

            font-size: 18px;
            font-weight: 900;
        }

        .empty-orders p {
            max-width: 470px;

            margin-left: auto;
            margin-right: auto;

            color: var(--sb-muted);

            font-size: 11px;
            line-height: 1.65;
        }

        /* =========================================================
           MODALS
        ========================================================= */

        .modal-backdrop.show {
            opacity: .5;
        }

        .premium-modal {
            overflow: hidden;

            color: var(--sb-text);

            background: #ffffff;

            border: 1px solid var(--sb-border);

            border-radius: 22px;

            box-shadow:
                0 35px 100px rgba(15, 23, 42, .23);
        }

        .premium-modal .modal-header {
            position: relative;

            padding: 18px 21px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f3f8ff
                );

            border-bottom: 1px solid var(--sb-border);
        }

        .premium-modal .modal-header::after {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: -1px;

            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    var(--sb-blue),
                    var(--sb-cyan),
                    transparent
                );

            opacity: .8;
        }

        .premium-modal .modal-title {
            color: var(--sb-text);

            font-size: 15px;
            font-weight: 900;
        }

        .premium-modal .modal-title i {
            color: var(--sb-blue) !important;
        }

        .premium-modal .modal-body {
            padding: 23px;

            background:
                linear-gradient(
                    180deg,
                    #fbfdff,
                    #f7f9fc
                );
        }

        .premium-modal .modal-footer {
            padding: 13px 21px;

            background: #ffffff;

            border-top: 1px solid var(--sb-border);
        }

        .premium-modal .btn-close {
            opacity: .5;

            transition: opacity .15s ease;
        }

        .premium-modal .btn-close:hover {
            opacity: 1;
        }

        /* =========================================================
           MODAL FORM
        ========================================================= */

        .premium-modal .form-label {
            margin-bottom: 6px;

            color: #475569;

            font-size: 9px;
            font-weight: 900;

            letter-spacing: .55px;

            text-transform: uppercase;
        }

        .premium-modal .form-control,
        .premium-modal .form-select {
            min-height: 43px;

            color: var(--sb-text);

            background: #ffffff;

            border: 1px solid #dce4ee;

            border-radius: 10px;

            padding: 8px 11px;

            font-size: 11px;

            box-shadow:
                0 2px 6px rgba(16, 24, 40, .025);

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .premium-modal textarea.form-control {
            min-height: auto;
            resize: vertical;
        }

        .premium-modal .form-control::placeholder {
            color: #a0a9b7;
        }

        .premium-modal .form-control:hover,
        .premium-modal .form-select:hover {
            border-color: #c8d7eb;
        }

        .premium-modal .form-control:focus,
        .premium-modal .form-select:focus {
            color: var(--sb-text);

            background: #ffffff;

            border-color: #7aa7f8;

            box-shadow:
                0 0 0 .18rem rgba(37, 99, 235, .09);
        }

        .premium-modal .text-muted {
            color: #8a95a5 !important;
        }

        .premium-modal hr {
            border-color: var(--sb-border) !important;
            opacity: 1;
        }

        /* =========================================================
           MODAL ALERTS
        ========================================================= */

        .premium-modal .alert {
            padding: 11px 13px;

            margin-bottom: 19px;

            border-radius: 10px;

            font-size: 10px;
            line-height: 1.5;
        }

        .premium-modal .alert-success {
            color: #087f52;

            background: var(--sb-green-soft);

            border: 1px solid var(--sb-green-border) !important;
        }

        .premium-modal .alert-primary {
            color: #1d5db9;

            background: #eff6ff;

            border: 1px solid #d6e5ff !important;
        }

        .premium-modal .alert-warning {
            color: #a36a00;

            background: var(--sb-orange-soft);

            border: 1px solid var(--sb-orange-border) !important;
        }

        /* =========================================================
           DELIVERY PROFILE
        ========================================================= */

        .delivery-profile {
            height: 100%;

            padding: 21px;

            text-align: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fafdff
                );

            border: 1px solid var(--sb-border);

            border-radius: 16px;

            box-shadow:
                0 8px 22px rgba(15, 23, 42, .04);
        }

        .delivery-profile img,
        .delivery-placeholder {
            width: 110px;
            height: 110px;

            object-fit: cover;

            border-radius: 50%;

            border: 3px solid #d7e7ff;

            box-shadow:
                0 10px 25px rgba(37, 99, 235, .13);
        }

        .delivery-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto;

            color: #7890ae;

            background:
                linear-gradient(
                    135deg,
                    #f1f6ff,
                    #eaf3ff
                );

            font-size: 33px;
        }

        .delivery-profile h5 {
            color: var(--sb-text);

            font-size: 15px;
            font-weight: 900;
        }

        /* =========================================================
           INFO BOX
        ========================================================= */

        .info-box {
            height: 100%;

            padding: 13px;

            background: #ffffff;

            border: 1px solid var(--sb-border);

            border-radius: 10px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                transform .18s ease;
        }

        .info-box:hover {
            border-color: #cbdcf5;

            box-shadow:
                0 7px 17px rgba(37, 99, 235, .055);

            transform: translateY(-1px);
        }

        .info-label {
            margin-bottom: 4px;

            color: #8a95a5;

            font-size: 7px;
            font-weight: 900;

            letter-spacing: .8px;

            text-transform: uppercase;
        }

        .info-value {
            color: #344054;

            font-size: 11px;
            font-weight: 700;

            line-height: 1.55;

            word-break: break-word;
        }

        .payment-status-paid {
            color: #087f52;
        }

        .payment-status-cod {
            color: #1d5db9;
        }

        .payment-status-pending {
            color: #a36a00;
        }

        /* =========================================================
           MODAL BUTTONS
        ========================================================= */

        .premium-modal .btn {
            min-height: 39px;

            padding: 7px 13px;

            border-radius: 9px;

            font-size: 10px;
            font-weight: 850;

            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .premium-modal .btn:hover {
            transform: translateY(-1px);
        }

        .premium-modal .btn-outline-secondary {
            color: #475569;

            background: #ffffff;

            border-color: #dce4ee;
        }

        .premium-modal .btn-outline-secondary:hover {
            color: var(--sb-blue);

            background: #eff6ff;

            border-color: #c8daf4;
        }

        .premium-modal .btn-success {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-blue),
                    var(--sb-blue-deep)
                );

            border-color: var(--sb-blue);

            box-shadow:
                0 7px 17px rgba(37, 99, 235, .17);
        }

        .premium-modal .btn-success:hover {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-blue-dark),
                    var(--sb-blue-deep)
                );

            border-color: var(--sb-blue-dark);

            box-shadow:
                0 10px 22px rgba(37, 99, 235, .2);
        }

        .premium-modal .btn-warning {
            color: #1d5db9;

            background: #eff6ff;

            border-color: #cfe0fb;
        }

        .premium-modal .btn-warning:hover {
            color: #ffffff;

            background: var(--sb-blue);

            border-color: var(--sb-blue);
        }

        .premium-modal .btn-danger {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #ef4444,
                    #dc3545
                );

            border-color: var(--sb-red);

            box-shadow:
                0 6px 14px rgba(220, 53, 69, .12);
        }

        .premium-modal .btn-danger:hover {
            color: #ffffff;

            box-shadow:
                0 9px 19px rgba(220, 53, 69, .18);
        }

        /* =========================================================
           MODAL SECTION TITLE
        ========================================================= */

        .modal-section-title {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 13px;

            color: var(--sb-blue-deep);

            font-size: 12px;
            font-weight: 900;
        }

        .modal-section-title i {
            color: var(--sb-blue);
        }

        /* =========================================================
           DARK THEME SUPPORT
           SCOPED ONLY TO ORDERS PAGE
        ========================================================= */

        [data-sb-theme="dark"] .orders-page,
        [data-theme="dark"] .orders-page,
        [data-seller-theme="dark"] .orders-page {

            --sb-bg: #080d18;
            --sb-bg-2: #0d1422;

            --sb-card: rgba(15, 23, 42, .94);
            --sb-card-solid: #0f172a;

            --sb-text: #f1f5f9;
            --sb-text-2: #cbd5e1;
            --sb-muted: #8d9bb0;

            --sb-border: #1e2b40;
            --sb-border-soft: #1a2638;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(37, 99, 235, .12),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(6, 182, 212, .08),
                    transparent 25%
                ),
                linear-gradient(
                    180deg,
                    #080d18,
                    #0b1220
                );
        }

        [data-sb-theme="dark"] .orders-page .orders-header,
        [data-theme="dark"] .orders-page .orders-header,
        [data-seller-theme="dark"] .orders-page .orders-header {
            background:
                linear-gradient(
                    135deg,
                    #101a2b,
                    #0d1727
                );

            border-color: #1e2b40;
        }

        [data-sb-theme="dark"] .orders-page .header-left h1,
        [data-theme="dark"] .orders-page .header-left h1,
        [data-seller-theme="dark"] .orders-page .header-left h1,
        [data-sb-theme="dark"] .orders-page .orders-card-title,
        [data-theme="dark"] .orders-page .orders-card-title,
        [data-seller-theme="dark"] .orders-page .orders-card-title {
            color: #f8fafc;
        }

        [data-sb-theme="dark"] .orders-page .orders-card,
        [data-theme="dark"] .orders-page .orders-card,
        [data-seller-theme="dark"] .orders-page .orders-card {
            background: #0f172a;
            border-color: #1e2b40;
        }

        [data-sb-theme="dark"] .orders-page .orders-card-header,
        [data-theme="dark"] .orders-page .orders-card-header,
        [data-seller-theme="dark"] .orders-page .orders-card-header {
            background:
                linear-gradient(
                    180deg,
                    #111c2e,
                    #0e1828
                );

            border-color: #1e2b40;
        }

        [data-sb-theme="dark"] .orders-page .seller-order-table thead th,
        [data-theme="dark"] .orders-page .seller-order-table thead th,
        [data-seller-theme="dark"] .orders-page .seller-order-table thead th {
            color: #91a0b5;
            background:
                linear-gradient(
                    180deg,
                    #101b2d,
                    #0d1727
                );

            border-color: #1e2b40;
        }

        [data-sb-theme="dark"] .orders-page .seller-order-table tbody td,
        [data-theme="dark"] .orders-page .seller-order-table tbody td,
        [data-seller-theme="dark"] .orders-page .seller-order-table tbody td {
            color: #cbd5e1;
            background: #0f172a;
            border-color: #1a2638;
        }

        [data-sb-theme="dark"] .orders-page .seller-order-table tbody tr:hover td,
        [data-theme="dark"] .orders-page .seller-order-table tbody tr:hover td,
        [data-seller-theme="dark"] .orders-page .seller-order-table tbody tr:hover td {
            background:
                linear-gradient(
                    90deg,
                    #111d30,
                    #101b2d
                );
        }

        [data-sb-theme="dark"] .orders-page .order-number,
        [data-theme="dark"] .orders-page .order-number,
        [data-seller-theme="dark"] .orders-page .order-number,
        [data-sb-theme="dark"] .orders-page .customer-name,
        [data-theme="dark"] .orders-page .customer-name,
        [data-seller-theme="dark"] .orders-page .customer-name {
            color: #f1f5f9;
        }

        [data-sb-theme="dark"] .orders-page .action-view,
        [data-theme="dark"] .orders-page .action-view,
        [data-seller-theme="dark"] .orders-page .action-view {
            color: #cbd5e1;
            background: #111c2e;
            border-color: #29384e;
        }

        [data-sb-theme="dark"] .orders-page .action-view:hover,
        [data-theme="dark"] .orders-page .action-view:hover,
        [data-seller-theme="dark"] .orders-page .action-view:hover {
            color: #ffffff;
            background: #172b4b;
            border-color: #315d9d;
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 3px solid rgba(37, 99, 235, .2);
            outline-offset: 2px;
        }

        /* =========================================================
           LARGE DESKTOP
        ========================================================= */

        @media (min-width: 1600px) {

            .orders-page {
                padding-left: 30px;
                padding-right: 30px;
            }

            .seller-order-table {
                min-width: 0;
            }

            .seller-order-table thead th,
            .seller-order-table tbody td {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        /* =========================================================
           DESKTOP / TABLET
        ========================================================= */

        @media (max-width: 1200px) {

            .orders-page {
                padding-left: 18px;
                padding-right: 18px;
            }

            .orders-header {
                padding: 25px;
            }

            .seller-order-table {
                min-width: 1080px;
            }

            .seller-order-table tbody td {
                padding-left: 13px;
                padding-right: 13px;
            }
        }

        @media (max-width: 992px) {

            .orders-header {
                min-height: 135px;
            }

            .header-left p {
                margin-left: 0;
            }

            .orders-card-header {
                padding: 15px 18px;
            }
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 768px) {

            .orders-page {
                padding:
                    14px
                    9px
                    40px;
            }

            .orders-header {
                min-height: auto;

                padding: 20px 17px;

                border-radius: 19px;
            }

            .header-eyebrow {
                font-size: 8px;
                letter-spacing: 1.35px;
            }

            .header-left h1 {
                gap: 10px;

                font-size: 24px;

                letter-spacing: -.7px;
            }

            .header-icon {
                width: 43px;
                height: 43px;

                flex-basis: 43px;

                border-radius: 13px;

                font-size: 14px;
            }

            .header-left p {
                margin-top: 10px;
                margin-left: 0;

                font-size: 11px;
            }

            .orders-card {
                border-radius: 19px;
            }

            .orders-card-header {
                align-items: flex-start;

                flex-direction: column;

                gap: 11px;

                padding: 15px;
            }

            .order-count {
                align-self: flex-start;
            }

            .premium-modal .modal-body {
                padding: 18px;
            }

            .premium-modal .modal-header,
            .premium-modal .modal-footer {
                padding: 14px 16px;
            }

            .premium-modal .modal-title {
                padding-right: 24px;

                font-size: 13px;
            }
        }

        @media (max-width: 576px) {

            .premium-alert {
                font-size: 10px;
            }

            .empty-orders {
                padding: 70px 18px;
            }

            .empty-orders-icon {
                width: 70px;
                height: 70px;

                border-radius: 19px;

                font-size: 25px;
            }

            .empty-orders h3 {
                font-size: 16px;
            }

            .delivery-profile {
                padding: 17px;
            }

            .delivery-profile img,
            .delivery-placeholder {
                width: 92px;
                height: 92px;
            }

            .premium-modal .modal-footer {
                gap: 6px;
            }

            .premium-modal .modal-footer .btn {
                flex: 1 1 auto;
            }
        }

        @media (max-width: 480px) {

            .orders-page {
                padding-top: 10px;
            }

            .orders-header {
                padding: 17px 14px;
            }

            .header-left h1 {
                align-items: flex-start;

                font-size: 21px;

                letter-spacing: -.5px;
            }

            .header-icon {
                width: 38px;
                height: 38px;

                flex-basis: 38px;

                border-radius: 11px;

                font-size: 12px;
            }

            .header-left p {
                font-size: 10px;
            }

            .orders-card-title {
                font-size: 13px;
            }

            .orders-card-title-icon {
                width: 37px;
                height: 37px;

                border-radius: 10px;
            }

            .order-count {
                font-size: 8px;
            }

            .premium-modal .modal-title {
                font-size: 12px !important;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            html {
                scroll-behavior: auto !important;
            }

            *,
            *::before,
            *::after {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

{{-- =========================================================
     GLOBAL SELLER TOPBAR
     KEEP AS-IS
========================================================= --}}

@include('seller.partials.topbar')


{{-- =========================================================
     GLOBAL SELLER MENU
     KEEP AS-IS
========================================================= --}}

@include('seller.partials.seller-menu')


<main class="orders-page">

    <div class="orders-container">

        {{-- =====================================================
             PREMIUM PAGE HEADER
        ====================================================== --}}

        <header class="orders-header">

            <div class="header-left">

                <div class="header-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Smart Basket • Seller Workspace
                </div>

                <h1>

                    <span class="header-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </span>

                    Order Management

                </h1>

                <p>
                    Manage customer orders, verify payment status and coordinate
                    delivery operations from one professional seller workspace.
                </p>

            </div>

        </header>


        {{-- =====================================================
             SUCCESS ALERT
        ====================================================== --}}

        @if(session('success'))

            <div class="premium-alert success">

                <i class="fa-solid fa-circle-check me-2"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- =====================================================
             ERROR ALERT
        ====================================================== --}}

        @if(session('error'))

            <div class="premium-alert error">

                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="premium-alert error">

                <i class="fa-solid fa-triangle-exclamation me-2"></i>

                <div>

                    <strong>
                        Please fix the following:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $err)

                            <li>{{ $err }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- =====================================================
             ORDER CENTER
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

                                $displayStatus =
                                    $delivery?->status
                                    ?? $order->order_status
                                    ?? $order->status
                                    ?? 'Order Placed';

                            @endphp


                            <tr>

                                {{-- ORDER --}}

                                <td>

                                    <div class="order-id-box">

                                        <span class="order-mini-icon">
                                            <i class="fa-solid fa-receipt"></i>
                                        </span>

                                        <div>

                                            <div class="order-number">
                                                #{{ $order->id }}
                                            </div>

                                            <div class="order-date">

                                                <i class="fa-regular fa-calendar me-1"></i>

                                                {{ $order->created_at?->format('d M Y') }}

                                            </div>

                                        </div>

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

                                    <div class="product-list">

                                        @forelse($order->seller_items ?? [] as $item)

                                            <div class="product-line">

                                                <i class="fa-solid fa-box"></i>

                                                <span>

                                                    {{ $item['name'] ?? ($products[$item['product_id'] ?? null]?->name ?? 'Product') }}

                                                    × {{ $item['quantity'] ?? 1 }}

                                                </span>

                                            </div>

                                        @empty

                                            <div class="product-line">

                                                <i class="fa-solid fa-box-open"></i>

                                                <span>
                                                    No product details
                                                </span>

                                            </div>

                                        @endforelse

                                    </div>

                                </td>


                                {{-- PAYMENT --}}

                                <td>

                                    @if($isPaid)

                                        <span class="payment-pill payment-paid">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Paid

                                        </span>

                                        <span class="payment-verified">

                                            <i class="fa-solid fa-shield-halved"></i>

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

                                    <span
                                        class="status-pill
                                        {{ strtolower(trim((string) $displayStatus)) === 'pending' ? 'status-pending' : '' }}"
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
                                            Customer orders will appear here once
                                            your store receives its first order.
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
     ORDER MODALS
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

                            <i class="fa-solid fa-truck me-2"></i>

                            Delivery Partner Details

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

                        @if($isPaid)

                            <div class="alert alert-success">

                                <i class="fa-solid fa-shield-halved me-2"></i>

                                <strong>Payment Verified</strong>

                                — Online payment has been successfully verified.

                            </div>

                        @elseif($isCod)

                            <div class="alert alert-primary">

                                <i class="fa-solid fa-money-bill-wave me-2"></i>

                                <strong>Cash on Delivery</strong>

                                — Customer will pay at delivery.

                            </div>

                        @else

                            <div class="alert alert-warning">

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
                                    Delivery Notes
                                </label>

                                <textarea
                                    name="notes"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Add special instructions, delivery notes or customer instructions..."
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

                            Save Delivery Details

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

                        <i class="fa-solid fa-truck me-2"></i>

                        Order & Delivery Details

                        <small class="text-muted ms-2">
                            #{{ $order->id }}
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

                    {{-- DELIVERY PARTNER --}}

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


                                    <h5 class="mt-3 mb-2">
                                        {{ $partner->name }}
                                    </h5>


                                    <span class="status-pill">

                                        <span class="status-dot"></span>

                                        {{ $delivery?->status ?? 'Order Placed' }}

                                    </span>

                                </div>

                            </div>


                            <div class="col-md-8">

                                <h6 class="modal-section-title">

                                    <i class="fa-solid fa-id-card"></i>

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

                    <h6 class="modal-section-title">

                        <i class="fa-solid fa-credit-card"></i>

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

                                        <span class="payment-status-paid">

                                            <i class="fa-solid fa-circle-check me-1"></i>

                                            Paid / Verified

                                        </span>

                                    @elseif($isCod)

                                        <span class="payment-status-cod">

                                            <i class="fa-solid fa-money-bill-wave me-1"></i>

                                            Cash on Delivery

                                        </span>

                                    @else

                                        <span class="payment-status-pending">

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

                    <h6 class="modal-section-title">

                        <i class="fa-solid fa-user"></i>

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

                            Edit Delivery

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


{{-- =========================================================
     BOOTSTRAP
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


{{-- =========================================================
     DELIVERY MODAL SWITCH
========================================================= --}}

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
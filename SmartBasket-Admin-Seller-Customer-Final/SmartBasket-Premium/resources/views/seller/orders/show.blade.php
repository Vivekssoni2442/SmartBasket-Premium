<!DOCTYPE html>
<html lang="en" data-sb-theme="dark">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order #{{ $order->id }} | Seller Panel | Smart Basket</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <link
        rel="stylesheet"
        href="{{ asset('css/order-tracking.css') }}"
    >

    <style>

        /* =========================================================
           SMART BASKET
           SELLER ORDER DETAILS — PREMIUM FULL WIDTH UI
        ========================================================= */

        :root {
            --sb-order-bg: #020617;
            --sb-order-bg-2: #07111f;

            --sb-order-card: rgba(15, 23, 42, .72);
            --sb-order-card-2: rgba(255,255,255,.035);

            --sb-order-border: rgba(255,255,255,.085);
            --sb-order-border-hover: rgba(255,255,255,.16);

            --sb-order-text: #f8fafc;
            --sb-order-text-2: #cbd5e1;
            --sb-order-muted: #94a3b8;

            --sb-order-green: #00f5a0;
            --sb-order-green-2: #00c982;
            --sb-order-green-soft: rgba(0,245,160,.09);

            --sb-order-blue: #60a5fa;
            --sb-order-blue-soft: rgba(96,165,250,.10);

            --sb-order-yellow: #fbbf24;
            --sb-order-yellow-soft: rgba(251,191,36,.10);

            --sb-order-red: #fb7185;
            --sb-order-red-soft: rgba(251,113,133,.10);

            --sb-order-purple: #a78bfa;
            --sb-order-purple-soft: rgba(167,139,250,.10);

            --sb-order-cyan: #22d3ee;
            --sb-order-cyan-soft: rgba(34,211,238,.10);

            --sb-order-shadow:
                0 25px 70px rgba(0,0,0,.25),
                0 8px 25px rgba(0,0,0,.12);

            --sb-order-radius: 24px;
        }


        /* =========================================================
           LIGHT THEME
        ========================================================= */

        html[data-sb-theme="light"],
        body[data-sb-theme="light"] {

            --sb-order-bg: #f4f7fb;
            --sb-order-bg-2: #edf2f7;

            --sb-order-card: rgba(255,255,255,.92);
            --sb-order-card-2: rgba(15,23,42,.035);

            --sb-order-border: rgba(15,23,42,.085);
            --sb-order-border-hover: rgba(15,23,42,.15);

            --sb-order-text: #0f172a;
            --sb-order-text-2: #334155;
            --sb-order-muted: #64748b;

            --sb-order-green: #00a86b;
            --sb-order-green-2: #00875a;
            --sb-order-green-soft: rgba(0,168,107,.08);

            --sb-order-shadow:
                0 25px 65px rgba(15,23,42,.09),
                0 8px 24px rgba(15,23,42,.05);
        }


        /* =========================================================
           SAFE GLOBAL RESET
        ========================================================= */

        .seller-order-page,
        .seller-order-page * {
            box-sizing: border-box;
        }


        /* =========================================================
           PAGE CANVAS
        ========================================================= */

        .seller-order-page {

            width: 100%;
            max-width: none;

            min-height: 100vh;

            margin: 0;
            padding:
                clamp(16px, 2vw, 28px)
                clamp(12px, 2vw, 30px)
                55px;

            color: var(--sb-order-text);

            overflow: hidden;

            background:

                radial-gradient(
                    circle at 0% 0%,
                    rgba(0,245,160,.075),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 100% 10%,
                    rgba(59,130,246,.075),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 80% 100%,
                    rgba(167,139,250,.055),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    var(--sb-order-bg),
                    var(--sb-order-bg-2)
                );
        }


        .seller-order-container {

            width: 100%;
            max-width: none;

            margin: 0 auto;
        }


        /* =========================================================
           BREADCRUMB
        ========================================================= */

        .seller-breadcrumb {

            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 8px;

            margin: 0 0 16px;

            color: var(--sb-order-muted);

            font-size: 11px;
            font-weight: 700;
        }


        .seller-breadcrumb a {

            display: inline-flex;
            align-items: center;

            color: var(--sb-order-muted);

            text-decoration: none;

            transition: .2s ease;
        }


        .seller-breadcrumb a:hover {

            color: var(--sb-order-green);
        }


        .seller-breadcrumb .separator {

            opacity: .35;
        }


        .seller-breadcrumb .current {

            color: var(--sb-order-text);
        }


        /* =========================================================
           PREMIUM HERO
        ========================================================= */

        .order-hero {

            position: relative;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;

            width: 100%;

            min-height: 185px;

            margin-bottom: 20px;

            padding:
                clamp(23px, 3vw, 34px)
                clamp(20px, 3vw, 38px);

            overflow: hidden;

            border: 1px solid var(--sb-order-border);

            border-radius: 28px;

            background:

                linear-gradient(
                    120deg,
                    rgba(0,245,160,.105),
                    rgba(255,255,255,.035) 40%,
                    rgba(59,130,246,.075)
                );

            backdrop-filter: blur(25px);

            box-shadow: var(--sb-order-shadow);
        }


        .order-hero::before {

            content: "";

            position: absolute;

            width: 390px;
            height: 390px;

            right: -150px;
            top: -230px;

            border-radius: 50%;

            background: rgba(0,245,160,.075);

            filter: blur(3px);

            pointer-events: none;
        }


        .order-hero::after {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            left: 42%;
            bottom: -120px;

            border-radius: 50%;

            background: rgba(96,165,250,.055);

            filter: blur(12px);

            pointer-events: none;
        }


        .hero-content {

            position: relative;
            z-index: 2;

            min-width: 0;
        }


        .hero-eyebrow {

            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 9px;

            color: var(--sb-order-green);

            font-size: 10px;
            font-weight: 900;

            letter-spacing: 1.8px;

            text-transform: uppercase;
        }


        .hero-eyebrow i {

            font-size: 12px;
        }


        .hero-title {

            margin: 0;

            color: var(--sb-order-text);

            font-size: clamp(28px, 3vw, 46px);

            line-height: 1.08;

            font-weight: 950;

            letter-spacing: -1.2px;
        }


        .hero-title span {

            color: var(--sb-order-green);

            text-shadow:
                0 0 25px rgba(0,245,160,.14);
        }


        .hero-description {

            max-width: 720px;

            margin: 11px 0 0;

            color: var(--sb-order-muted);

            font-size: 12px;

            line-height: 1.75;
        }


        .hero-actions {

            position: relative;
            z-index: 3;

            display: flex;
            align-items: center;

            gap: 9px;

            flex-shrink: 0;
        }


        .hero-btn {

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 44px;

            padding: 0 16px;

            border: 1px solid var(--sb-order-border);

            border-radius: 13px;

            color: var(--sb-order-text);

            background: var(--sb-order-card-2);

            text-decoration: none;

            font-size: 11px;
            font-weight: 850;

            white-space: nowrap;

            transition:
                transform .22s ease,
                border-color .22s ease,
                background .22s ease,
                color .22s ease;
        }


        .hero-btn:hover {

            color: var(--sb-order-green);

            border-color: rgba(0,245,160,.30);

            background: var(--sb-order-green-soft);

            transform: translateY(-2px);
        }


        .hero-btn:first-child {

            border-color: rgba(0,245,160,.18);
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .seller-alert {

            display: flex;
            align-items: flex-start;

            gap: 12px;

            width: 100%;

            margin-bottom: 16px;

            padding: 14px 16px;

            border: 1px solid var(--sb-order-border);

            border-radius: 16px;

            color: var(--sb-order-text-2);

            background: var(--sb-order-card);

            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }


        .seller-alert-icon {

            display: flex;
            align-items: center;
            justify-content: center;

            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            border-radius: 11px;
        }


        .seller-alert.success {

            border-color: rgba(0,245,160,.20);
        }


        .seller-alert.success .seller-alert-icon {

            color: var(--sb-order-green);

            background: var(--sb-order-green-soft);
        }


        .seller-alert.error {

            border-color: rgba(251,113,133,.20);
        }


        .seller-alert.error .seller-alert-icon {

            color: var(--sb-order-red);

            background: var(--sb-order-red-soft);
        }


        .seller-alert strong {

            color: var(--sb-order-text);

            font-size: 12px;
        }


        .seller-alert ul {

            padding-left: 18px;

            margin-bottom: 0;

            font-size: 11px;
        }


        /* =========================================================
           ORDER STATISTICS
        ========================================================= */

        .order-stat-grid {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 14px;

            width: 100%;

            margin-bottom: 20px;
        }


        .order-stat {

            position: relative;

            overflow: hidden;

            min-width: 0;

            padding: 18px;

            border: 1px solid var(--sb-order-border);

            border-radius: 20px;

            background:

                linear-gradient(
                    145deg,
                    var(--sb-order-card),
                    var(--sb-order-card-2)
                );

            backdrop-filter: blur(20px);

            box-shadow:
                0 14px 45px rgba(0,0,0,.10);

            transition:
                transform .23s ease,
                border-color .23s ease,
                box-shadow .23s ease;
        }


        .order-stat::after {

            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            right: -55px;
            bottom: -60px;

            border-radius: 50%;

            background: var(--sb-order-green-soft);

            filter: blur(12px);

            pointer-events: none;
        }


        .order-stat:hover {

            transform: translateY(-3px);

            border-color: var(--sb-order-border-hover);

            box-shadow:
                0 20px 50px rgba(0,0,0,.15);
        }


        .order-stat-top {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-bottom: 12px;
        }


        .stat-icon {

            display: flex;
            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;

            flex: 0 0 40px;

            border-radius: 12px;

            font-size: 14px;
        }


        .stat-icon.green {

            color: var(--sb-order-green);

            background: var(--sb-order-green-soft);

            border: 1px solid rgba(0,245,160,.12);
        }


        .stat-icon.blue {

            color: var(--sb-order-blue);

            background: var(--sb-order-blue-soft);

            border: 1px solid rgba(96,165,250,.12);
        }


        .stat-icon.yellow {

            color: var(--sb-order-yellow);

            background: var(--sb-order-yellow-soft);

            border: 1px solid rgba(251,191,36,.12);
        }


        .stat-icon.purple {

            color: var(--sb-order-purple);

            background: var(--sb-order-purple-soft);

            border: 1px solid rgba(167,139,250,.12);
        }


        .stat-label {

            color: var(--sb-order-muted);

            font-size: 9px;
            font-weight: 900;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        .stat-value {

            position: relative;
            z-index: 2;

            overflow: hidden;

            color: var(--sb-order-text);

            font-size: clamp(16px, 1.45vw, 20px);

            font-weight: 950;

            line-height: 1.3;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        .stat-sub {

            position: relative;
            z-index: 2;

            margin-top: 4px;

            color: var(--sb-order-muted);

            font-size: 9px;

            line-height: 1.5;
        }


        /* =========================================================
           MAIN CONTENT
        ========================================================= */

        .seller-order-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1.45fr)
                minmax(340px, .72fr);

            gap: 20px;

            width: 100%;

            align-items: start;
        }


        .seller-order-grid > div {

            min-width: 0;
        }


        /* =========================================================
           PREMIUM CARD
        ========================================================= */

        .seller-card {

            width: 100%;

            margin-bottom: 20px;

            overflow: hidden;

            border: 1px solid var(--sb-order-border);

            border-radius: var(--sb-order-radius);

            background:

                linear-gradient(
                    145deg,
                    var(--sb-order-card),
                    var(--sb-order-card-2)
                );

            backdrop-filter: blur(25px);

            box-shadow: var(--sb-order-shadow);
        }


        .seller-card:last-child {

            margin-bottom: 0;
        }


        .seller-card-header {

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            min-height: 72px;

            padding:
                15px
                clamp(16px, 2vw, 22px);

            border-bottom: 1px solid var(--sb-order-border);

            background: rgba(255,255,255,.012);
        }


        .seller-card-heading {

            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }


        .seller-card-heading-icon {

            display: flex;
            align-items: center;
            justify-content: center;

            width: 39px;
            height: 39px;

            flex: 0 0 39px;

            border: 1px solid rgba(0,245,160,.13);

            border-radius: 12px;

            color: var(--sb-order-green);

            background: var(--sb-order-green-soft);

            font-size: 14px;
        }


        .seller-card-title {

            margin: 0;

            overflow: hidden;

            color: var(--sb-order-text);

            font-size: 14px;
            font-weight: 900;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        .seller-card-subtitle {

            margin: 3px 0 0;

            color: var(--sb-order-muted);

            font-size: 9px;

            line-height: 1.5;
        }


        .seller-card-body {

            padding: clamp(16px, 2vw, 22px);
        }


        /* =========================================================
           CUSTOMER PROFILE
        ========================================================= */

        .customer-profile {

            display: flex;
            align-items: center;

            gap: 15px;

            width: 100%;

            padding: 16px;

            border: 1px solid var(--sb-order-border);

            border-radius: 17px;

            background: var(--sb-order-card-2);
        }


        .customer-avatar {

            display: flex;
            align-items: center;
            justify-content: center;

            width: 56px;
            height: 56px;

            flex: 0 0 56px;

            border: 1px solid rgba(0,245,160,.17);

            border-radius: 17px;

            color: var(--sb-order-green);

            background:

                linear-gradient(
                    135deg,
                    rgba(0,245,160,.15),
                    rgba(59,130,246,.12)
                );

            font-size: 20px;

            box-shadow:
                0 10px 25px rgba(0,0,0,.10);
        }


        .customer-name {

            color: var(--sb-order-text);

            font-size: 15px;
            font-weight: 900;

            line-height: 1.4;
        }


        .customer-contact {

            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 7px 16px;

            margin-top: 5px;

            color: var(--sb-order-muted);

            font-size: 10px;
        }


        .customer-contact span {

            display: inline-flex;
            align-items: center;

            gap: 5px;
        }


        .customer-contact i {

            color: var(--sb-order-green);
        }


        /* =========================================================
           ADDRESS
        ========================================================= */

        .address-box {

            width: 100%;

            margin-top: 14px;

            padding: 15px;

            border: 1px solid var(--sb-order-border);

            border-radius: 16px;

            background: var(--sb-order-card-2);
        }


        .section-mini-title {

            display: flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 7px;

            color: var(--sb-order-muted);

            font-size: 9px;
            font-weight: 900;

            letter-spacing: .8px;

            text-transform: uppercase;
        }


        .section-mini-title i {

            color: var(--sb-order-green);
        }


        .address-text {

            color: var(--sb-order-text-2);

            font-size: 11px;

            line-height: 1.7;
        }


        /* =========================================================
           PRODUCTS
        ========================================================= */

        .products-list {

            display: flex;
            flex-direction: column;

            gap: 10px;

            width: 100%;
        }


        .product-item {

            display: flex;
            align-items: center;

            gap: 13px;

            width: 100%;

            min-width: 0;

            padding: 11px;

            border: 1px solid var(--sb-order-border);

            border-radius: 16px;

            background: var(--sb-order-card-2);

            transition:
                transform .2s ease,
                border-color .2s ease,
                background .2s ease;
        }


        .product-item:hover {

            transform: translateX(3px);

            border-color: rgba(0,245,160,.20);

            background: rgba(0,245,160,.025);
        }


        .product-image {

            width: 70px;
            height: 70px;

            flex: 0 0 70px;

            object-fit: cover;

            border: 1px solid var(--sb-order-border);

            border-radius: 14px;

            background: #0f172a;

            overflow: hidden;
        }


        .product-details {

            min-width: 0;

            flex: 1;
        }


        .product-name {

            overflow: hidden;

            color: var(--sb-order-text);

            font-size: 12px;
            font-weight: 850;

            line-height: 1.4;

            text-overflow: ellipsis;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        .product-meta {

            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 6px;

            margin-top: 7px;
        }


        .product-meta span {

            display: inline-flex;
            align-items: center;

            gap: 4px;

            padding: 5px 7px;

            border: 1px solid var(--sb-order-border);

            border-radius: 8px;

            color: var(--sb-order-muted);

            background: var(--sb-order-card-2);

            font-size: 9px;
        }


        .product-meta i {

            color: var(--sb-order-green);
        }


        .product-price {

            flex-shrink: 0;

            color: var(--sb-order-green);

            font-size: 13px;
            font-weight: 950;

            white-space: nowrap;
        }


        /* =========================================================
           ITEMS BADGE
        ========================================================= */

        .payment-pill {

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 7px 10px;

            border: 1px solid var(--sb-order-border);

            border-radius: 30px;

            font-size: 9px;
            font-weight: 900;

            white-space: nowrap;
        }


        .payment-cod {

            color: var(--sb-order-blue);

            background: var(--sb-order-blue-soft);

            border-color: rgba(96,165,250,.20);
        }


        .payment-paid {

            color: var(--sb-order-green);

            background: var(--sb-order-green-soft);

            border-color: rgba(0,245,160,.20);
        }


        .payment-pending {

            color: var(--sb-order-yellow);

            background: var(--sb-order-yellow-soft);

            border-color: rgba(251,191,36,.20);
        }


        .payment-failed {

            color: var(--sb-order-red);

            background: var(--sb-order-red-soft);

            border-color: rgba(251,113,133,.20);
        }


        /* =========================================================
           PAYMENT PANEL
        ========================================================= */

        .payment-panel {

            position: relative;

            overflow: hidden;

            width: 100%;

            padding: 19px;

            border: 1px solid var(--sb-order-border);

            border-radius: 18px;

            background:

                linear-gradient(
                    135deg,
                    var(--sb-order-green-soft),
                    var(--sb-order-card-2)
                );
        }


        .payment-panel::after {

            content: "";

            position: absolute;

            width: 160px;
            height: 160px;

            right: -85px;
            bottom: -100px;

            border-radius: 50%;

            background: rgba(0,245,160,.055);

            filter: blur(8px);

            pointer-events: none;
        }


        .payment-top {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }


        .payment-method {

            color: var(--sb-order-text);

            font-size: 14px;
            font-weight: 900;
        }


        .payment-method small {

            display: block;

            margin-top: 3px;

            color: var(--sb-order-muted);

            font-size: 9px;
            font-weight: 600;
        }


        .payment-warning {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: flex-start;

            gap: 8px;

            margin-top: 14px;

            padding: 11px 12px;

            border: 1px solid rgba(251,191,36,.15);

            border-radius: 11px;

            color: var(--sb-order-yellow);

            background: var(--sb-order-yellow-soft);

            font-size: 9px;
            font-weight: 750;

            line-height: 1.6;
        }


        .payment-warning i {

            margin-top: 1px;
        }


        .security-note {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: flex-start;

            gap: 9px;

            margin-top: 14px;

            padding: 11px 12px;

            border: 1px solid var(--sb-order-border);

            border-radius: 12px;

            color: var(--sb-order-muted);

            background: var(--sb-order-card-2);

            font-size: 9px;

            line-height: 1.65;
        }


        .security-note i {

            margin-top: 2px;

            color: var(--sb-order-green);
        }


        .security-note strong {

            font-size: 10px;
        }


        .amount-summary {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-top: 17px;

            padding-top: 15px;

            border-top: 1px dashed var(--sb-order-border);
        }


        .amount-label {

            color: var(--sb-order-muted);

            font-size: 10px;
            font-weight: 750;
        }


        .amount-value {

            color: var(--sb-order-text);

            font-size: 23px;
            font-weight: 950;

            white-space: nowrap;
        }


        .amount-value span {

            color: var(--sb-order-green);
        }


        /* =========================================================
           TRACKING
        ========================================================= */

        .current-status {

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 18px;

            padding: 14px;

            border: 1px solid rgba(0,245,160,.14);

            border-radius: 15px;

            background: var(--sb-order-green-soft);
        }


        .current-status-label {

            color: var(--sb-order-muted);

            font-size: 8px;
            font-weight: 900;

            letter-spacing: .8px;

            text-transform: uppercase;
        }


        .current-status-value {

            margin-top: 3px;

            color: var(--sb-order-green);

            font-size: 13px;
            font-weight: 900;

            line-height: 1.4;
        }


        .status-live {

            display: inline-flex;
            align-items: center;

            gap: 6px;

            color: var(--sb-order-green);

            font-size: 8px;
            font-weight: 900;

            letter-spacing: .6px;

            text-transform: uppercase;
        }


        .live-dot {

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--sb-order-green);

            box-shadow:
                0 0 0 4px rgba(0,245,160,.08),
                0 0 12px rgba(0,245,160,.35);

            animation: sbLivePulse 1.8s infinite;
        }


        @keyframes sbLivePulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .65;
                transform: scale(.82);
            }
        }


        .tracking-list {

            position: relative;

            padding-left: 4px;
        }


        .tracking-list::before {

            content: "";

            position: absolute;

            left: 16px;
            top: 18px;
            bottom: 20px;

            width: 2px;

            background:

                linear-gradient(
                    to bottom,
                    var(--sb-order-green),
                    var(--sb-order-border)
                );
        }


        .tracking-item {

            position: relative;

            display: flex;

            gap: 13px;

            min-height: 55px;

            padding: 6px 0 9px;
        }


        .tracking-icon {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 26px;
            height: 26px;

            flex: 0 0 26px;

            border: 2px solid var(--sb-order-border);

            border-radius: 50%;

            color: var(--sb-order-muted);

            background: var(--sb-order-bg-2);

            font-size: 8px;

            transition: .2s ease;
        }


        .tracking-item.active .tracking-icon {

            color: #02150d;

            border-color: var(--sb-order-green);

            background: var(--sb-order-green);

            box-shadow:
                0 0 0 5px rgba(0,245,160,.07),
                0 0 20px rgba(0,245,160,.18);
        }


        .tracking-content {

            min-width: 0;

            padding-top: 2px;
        }


        .tracking-title {

            color: var(--sb-order-text-2);

            font-size: 10px;
            font-weight: 750;

            line-height: 1.45;
        }


        .tracking-item.active .tracking-title {

            color: var(--sb-order-green);

            font-weight: 900;
        }


        .tracking-caption {

            margin-top: 2px;

            color: var(--sb-order-muted);

            font-size: 8px;
        }


        /* =========================================================
           DELIVERY PARTNER
        ========================================================= */

        .existing-partner {

            display: flex;
            align-items: center;

            gap: 10px;

            margin-bottom: 15px;

            padding: 11px;

            border: 1px solid rgba(0,245,160,.13);

            border-radius: 13px;

            background: var(--sb-order-green-soft);
        }


        .partner-icon {

            display: flex;
            align-items: center;
            justify-content: center;

            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            border-radius: 10px;

            color: var(--sb-order-green);

            background: rgba(0,245,160,.08);
        }


        .partner-text {

            color: var(--sb-order-muted);

            font-size: 9px;

            line-height: 1.5;
        }


        .partner-text strong {

            display: block;

            margin-bottom: 2px;

            color: var(--sb-order-text);

            font-size: 10px;
        }


        .assignment-intro {

            margin-bottom: 17px;

            padding: 12px 13px;

            border: 1px solid var(--sb-order-border);

            border-radius: 13px;

            color: var(--sb-order-muted);

            background: var(--sb-order-card-2);

            font-size: 9px;

            line-height: 1.65;
        }


        .assignment-intro i {

            margin-right: 5px;

            color: var(--sb-order-green);
        }


        /* =========================================================
           FORM
        ========================================================= */

        .field-group {

            margin-bottom: 14px;
        }


        .field-label {

            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 6px;

            color: var(--sb-order-text-2);

            font-size: 9px;
            font-weight: 850;

            letter-spacing: .25px;
        }


        .field-label i {

            color: var(--sb-order-green);

            font-size: 9px;
        }


        .seller-form-control,
        .seller-form-select {

            display: block;

            width: 100%;

            min-height: 44px;

            padding:
                9px
                11px;

            border: 1px solid var(--sb-order-border);

            border-radius: 11px;

            outline: none;

            color: var(--sb-order-text);

            background: var(--sb-order-card-2);

            font-family: inherit;

            font-size: 10px;

            box-shadow: none;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .seller-form-control::placeholder {

            color: var(--sb-order-muted);
        }


        .seller-form-control:focus,
        .seller-form-select:focus {

            color: var(--sb-order-text);

            border-color: rgba(0,245,160,.50);

            background: var(--sb-order-card-2);

            box-shadow:
                0 0 0 3px rgba(0,245,160,.07);
        }


        .seller-form-select option {

            background: #0f172a;

            color: #fff;
        }


        html[data-sb-theme="light"] .seller-form-select option {

            background: #fff;

            color: #0f172a;
        }


        .file-control {

            padding-top: 7px;
            padding-bottom: 7px;

            cursor: pointer;
        }


        /* =========================================================
           SUBMIT
        ========================================================= */

        .assign-button {

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            width: 100%;

            min-height: 48px;

            margin-top: 2px;

            padding: 0 16px;

            border: 0;

            border-radius: 12px;

            color: #02150d;

            background:

                linear-gradient(
                    135deg,
                    #00ff9d,
                    #00d987
                );

            font-family: inherit;

            font-size: 10px;
            font-weight: 950;

            cursor: pointer;

            box-shadow:
                0 12px 32px rgba(0,245,160,.13);

            transition:
                transform .22s ease,
                box-shadow .22s ease;
        }


        .assign-button:hover {

            color: #02150d;

            transform: translateY(-2px);

            box-shadow:
                0 17px 40px rgba(0,245,160,.22);
        }


        .assign-button:active {

            transform: translateY(0);
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-box {

            width: 100%;

            padding: 36px 20px;

            text-align: center;

            border: 1px dashed var(--sb-order-border);

            border-radius: 17px;

            color: var(--sb-order-muted);

            background: var(--sb-order-card-2);
        }


        .empty-box i {

            display: block;

            margin-bottom: 10px;

            font-size: 26px;
        }


        .empty-box strong {

            display: block;

            margin-bottom: 4px;

            color: var(--sb-order-text);

            font-size: 12px;
        }


        .empty-box span {

            font-size: 9px;
        }


        /* =========================================================
           RESPONSIVE — LARGE LAPTOP
        ========================================================= */

        @media (max-width: 1350px) {

            .seller-order-grid {

                grid-template-columns:
                    minmax(0, 1.25fr)
                    minmax(320px, .75fr);
            }

            .order-stat-grid {

                grid-template-columns:
                    repeat(4, minmax(0, 1fr));
            }
        }


        /* =========================================================
           RESPONSIVE — TABLET / SMALL LAPTOP
        ========================================================= */

        @media (max-width: 1100px) {

            .seller-order-grid {

                grid-template-columns: 1fr;
            }


            .order-stat-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .order-hero {

                min-height: auto;
            }


            .hero-description {

                max-width: 100%;
            }
        }


        /* =========================================================
           RESPONSIVE — TABLET
        ========================================================= */

        @media (max-width: 760px) {

            .seller-order-page {

                padding:
                    15px
                    11px
                    45px;
            }


            .seller-breadcrumb {

                margin-bottom: 13px;

                font-size: 9px;
            }


            .order-hero {

                align-items: flex-start;

                flex-direction: column;

                gap: 18px;

                padding:
                    22px
                    18px;

                border-radius: 21px;
            }


            .hero-title {

                font-size: 30px;
            }


            .hero-description {

                font-size: 10px;

                line-height: 1.7;
            }


            .hero-actions {

                width: 100%;
            }


            .hero-btn {

                flex: 1;

                min-width: 0;

                padding: 0 10px;
            }


            .seller-card {

                border-radius: 20px;
            }


            .seller-card-header {

                min-height: 65px;

                padding:
                    13px
                    15px;
            }


            .seller-card-body {

                padding: 15px;
            }


            .customer-profile {

                align-items: flex-start;
            }
        }


        /* =========================================================
           RESPONSIVE — MOBILE
        ========================================================= */

        @media (max-width: 560px) {

            .seller-order-page {

                padding:
                    12px
                    9px
                    38px;
            }


            .order-stat-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 9px;
            }


            .order-stat {

                padding: 13px;
            }


            .stat-icon {

                width: 35px;
                height: 35px;

                flex-basis: 35px;

                border-radius: 10px;

                font-size: 12px;
            }


            .stat-label {

                font-size: 7px;
            }


            .stat-value {

                font-size: 14px;
            }


            .stat-sub {

                font-size: 8px;
            }


            .hero-actions {

                flex-direction: column;
            }


            .hero-btn {

                width: 100%;

                flex: none;
            }


            .customer-profile {

                padding: 13px;

                gap: 11px;
            }


            .customer-avatar {

                width: 48px;
                height: 48px;

                flex-basis: 48px;

                border-radius: 14px;

                font-size: 17px;
            }


            .customer-name {

                font-size: 13px;
            }


            .customer-contact {

                align-items: flex-start;

                flex-direction: column;

                gap: 5px;

                font-size: 9px;
            }


            .product-item {

                align-items: flex-start;

                gap: 10px;

                padding: 9px;
            }


            .product-image {

                width: 55px;
                height: 55px;

                flex-basis: 55px;

                border-radius: 12px;
            }


            .product-price {

                font-size: 11px;
            }


            .product-meta span {

                font-size: 8px;

                padding: 4px 6px;
            }


            .payment-top {

                align-items: flex-start;

                flex-direction: column;
            }


            .amount-summary {

                align-items: flex-start;

                flex-direction: column;

                gap: 5px;
            }


            .amount-value {

                font-size: 21px;
            }
        }


        /* =========================================================
           RESPONSIVE — VERY SMALL MOBILE
        ========================================================= */

        @media (max-width: 390px) {

            .order-stat-grid {

                grid-template-columns: 1fr;
            }


            .hero-title {

                font-size: 27px;
            }


            .seller-card-title {

                font-size: 12px;
            }


            .seller-card-subtitle {

                font-size: 8px;
            }


            .product-price {

                font-size: 10px;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .seller-order-page *,
            .seller-order-page *::before,
            .seller-order-page *::after {

                animation: none !important;

                transition: none !important;
            }
        }

    </style>


    {{-- =========================================================
         APPLY SAVED THEME BEFORE PAGE PAINT
    ========================================================= --}}

    <script>

        (function () {

            const keys = [
                'sb-theme',
                'smartbasket-theme',
                'theme',
                'themeMode',
                'appearance'
            ];

            let theme = null;

            for (const key of keys) {

                try {

                    const value =
                        localStorage.getItem(key);

                    if (
                        value === 'dark' ||
                        value === 'light'
                    ) {

                        theme = value;

                        break;
                    }

                } catch (error) {}

            }

            if (!theme) {

                theme = 'dark';
            }

            document.documentElement
                .setAttribute(
                    'data-sb-theme',
                    theme
                );

        })();

    </script>

</head>


<body>


{{-- =========================================================
     SELLER TOPBAR
     DO NOT CHANGE
========================================================= --}}

@include('seller.partials.topbar')


{{-- =========================================================
     SELLER GLOBAL MENU
     DO NOT CHANGE
========================================================= --}}

@include('seller.partials.seller-menu')


<main class="seller-order-page">

    <div class="seller-order-container">


        {{-- =====================================================
             BREADCRUMB
        ====================================================== --}}

        <div class="seller-breadcrumb">

            <a href="{{ route('seller.dashboard') }}">

                <i class="fa-solid fa-house me-1"></i>

                Seller Dashboard

            </a>

            <span class="separator">/</span>

            <a href="{{ route('seller.orders.index') }}">

                Orders

            </a>

            <span class="separator">/</span>

            <span class="current">

                Order #{{ $order->id }}

            </span>

        </div>


        {{-- =====================================================
             ORDER HERO
        ====================================================== --}}

        <section class="order-hero">

            <div class="hero-content">

                <div class="hero-eyebrow">

                    <i class="fa-solid fa-store"></i>

                    Smart Basket Seller Center

                </div>


                <h1 class="hero-title">

                    Order
                    <span>#{{ $order->id }}</span>

                </h1>


                <p class="hero-description">

                    Review customer details, products, payment verification
                    and delivery assignment from one premium seller workspace.

                </p>

            </div>


            <div class="hero-actions">

                <a
                    href="{{ route('seller.orders.index') }}"
                    class="hero-btn"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    All Orders

                </a>


                <a
                    href="{{ route('seller.dashboard') }}"
                    class="hero-btn"
                >

                    <i class="fa-solid fa-gauge-high"></i>

                    Dashboard

                </a>

            </div>

        </section>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div class="seller-alert success">

                <div class="seller-alert-icon">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div>

                    <strong>
                        Success
                    </strong>

                    <div class="mt-1">

                        {{ session('success') }}

                    </div>

                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="seller-alert error">

                <div class="seller-alert-icon">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                </div>

                <div>

                    <strong>
                        Action Required
                    </strong>

                    <div class="mt-1">

                        {{ session('error') }}

                    </div>

                </div>

            </div>

        @endif


        @if($errors->any())

            <div class="seller-alert error">

                <div class="seller-alert-icon">

                    <i class="fa-solid fa-circle-exclamation"></i>

                </div>

                <div>

                    <strong>
                        Please fix the following:
                    </strong>

                    <ul class="mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- =====================================================
             ORDER DATA
        ====================================================== --}}

        @php

            $paymentStatus = strtolower(
                trim(
                    (string) (
                        $order->payment_status
                        ?? 'pending'
                    )
                )
            );

            $paymentMethod = strtoupper(
                trim(
                    (string) (
                        $order->payment_method
                        ?? 'COD'
                    )
                )
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

            $delivery = $order->deliveryDetail;

            $deliveryPartner =
                $delivery?->deliveryPartner;

            $currentStatus =
                $delivery?->status
                ?? $order->order_status
                ?? $order->status
                ?? 'Order Placed';

            $amount =
                (float) (
                    $order->amount
                    ?? $order->total
                    ?? 0
                );

            $items =
                $order->seller_items
                ?? [];

            $statusSteps = [

                'Order Placed',
                'Seller Confirmed',
                'Packed',
                'Picked By Delivery Partner',
                'Out For Delivery',
                'Near Customer',
                'Delivered'

            ];

            $currentIndex =
                array_search(
                    $currentStatus,
                    $statusSteps,
                    true
                );

            if ($currentIndex === false) {

                $currentIndex = 0;

            }

        @endphp


        {{-- =====================================================
             ORDER STATISTICS
        ====================================================== --}}

        <section class="order-stat-grid">


            <div class="order-stat">

                <div class="order-stat-top">

                    <div class="stat-label">
                        Order Value
                    </div>

                    <div class="stat-icon green">

                        <i class="fa-solid fa-indian-rupee-sign"></i>

                    </div>

                </div>

                <div class="stat-value">

                    ₹{{ number_format($amount, 2) }}

                </div>

                <div class="stat-sub">

                    Total order amount

                </div>

            </div>


            <div class="order-stat">

                <div class="order-stat-top">

                    <div class="stat-label">
                        Payment
                    </div>

                    <div class="stat-icon blue">

                        <i class="fa-solid fa-credit-card"></i>

                    </div>

                </div>

                <div class="stat-value">

                    @if($isPaid)

                        Paid

                    @elseif($isCod)

                        COD

                    @elseif($isFailed)

                        Failed

                    @else

                        Pending

                    @endif

                </div>

                <div class="stat-sub">

                    {{ $paymentMethod }}

                </div>

            </div>


            <div class="order-stat">

                <div class="order-stat-top">

                    <div class="stat-label">
                        Order Status
                    </div>

                    <div class="stat-icon yellow">

                        <i class="fa-solid fa-truck-fast"></i>

                    </div>

                </div>

                <div class="stat-value">

                    {{ $currentStatus }}

                </div>

                <div class="stat-sub">

                    Current tracking stage

                </div>

            </div>


            <div class="order-stat">

                <div class="order-stat-top">

                    <div class="stat-label">
                        Customer
                    </div>

                    <div class="stat-icon purple">

                        <i class="fa-solid fa-user"></i>

                    </div>

                </div>

                <div class="stat-value">

                    {{ \Illuminate\Support\Str::limit($order->name ?? 'Customer', 18) }}

                </div>

                <div class="stat-sub">

                    {{ $order->created_at?->format('d M Y, h:i A') ?? 'Order date unavailable' }}

                </div>

            </div>


        </section>


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <div class="seller-order-grid">


            {{-- =================================================
                 LEFT COLUMN
            ================================================== --}}

            <div>


                {{-- CUSTOMER INFORMATION --}}

                <section class="seller-card">

                    <div class="seller-card-header">

                        <div class="seller-card-heading">

                            <div class="seller-card-heading-icon">

                                <i class="fa-solid fa-user"></i>

                            </div>

                            <div>

                                <h2 class="seller-card-title">
                                    Customer Information
                                </h2>

                                <p class="seller-card-subtitle">
                                    Customer contact and delivery address
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="seller-card-body">

                        <div class="customer-profile">

                            <div class="customer-avatar">

                                <i class="fa-solid fa-user"></i>

                            </div>


                            <div>

                                <div class="customer-name">

                                    {{ $order->name ?? 'Customer' }}

                                </div>


                                <div class="customer-contact">

                                    @if($order->mobile)

                                        <span>

                                            <i class="fa-solid fa-phone"></i>

                                            {{ $order->mobile }}

                                        </span>

                                    @endif


                                    @if($order->email ?? null)

                                        <span>

                                            <i class="fa-solid fa-envelope"></i>

                                            {{ $order->email }}

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="address-box">

                            <div class="section-mini-title">

                                <i class="fa-solid fa-location-dot"></i>

                                Delivery Address

                            </div>


                            <div class="address-text">

                                {{ $order->address ?? 'Address not available' }}

                                @if($order->city)

                                    , {{ $order->city }}

                                @endif

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ORDERED PRODUCTS --}}

                <section class="seller-card">

                    <div class="seller-card-header">

                        <div class="seller-card-heading">

                            <div class="seller-card-heading-icon">

                                <i class="fa-solid fa-box-open"></i>

                            </div>

                            <div>

                                <h2 class="seller-card-title">
                                    Ordered Products
                                </h2>

                                <p class="seller-card-subtitle">
                                    Products included in this seller order
                                </p>

                            </div>

                        </div>


                        <span class="payment-pill payment-cod">

                            <i class="fa-solid fa-cubes"></i>

                            {{ count($items) }} Items

                        </span>

                    </div>


                    <div class="seller-card-body">

                        @if(count($items))

                            <div class="products-list">

                                @foreach($items as $item)

                                    @php

                                        $product =
                                            $products[
                                                $item['product_id'] ?? null
                                            ] ?? null;

                                        $productName =
                                            $item['name']
                                            ?? $product?->name
                                            ?? 'Product';

                                        $quantity =
                                            (int) (
                                                $item['quantity']
                                                ?? 1
                                            );

                                        $itemPrice =
                                            (float) (
                                                $item['price']
                                                ?? 0
                                            );

                                    @endphp


                                    <div class="product-item">


                                        @if($product?->image)

                                            <img
                                                src="{{ asset('products/'.$product->image) }}"
                                                alt="{{ $productName }}"
                                                class="product-image"
                                                loading="lazy"
                                                onerror="this.style.display='none';"
                                            >

                                        @else

                                            <div
                                                class="product-image d-flex align-items-center justify-content-center"
                                            >

                                                <i class="fa-solid fa-box text-secondary"></i>

                                            </div>

                                        @endif


                                        <div class="product-details">

                                            <div class="product-name">

                                                {{ $productName }}

                                            </div>


                                            <div class="product-meta">

                                                <span>

                                                    <i class="fa-solid fa-indian-rupee-sign"></i>

                                                    ₹{{ number_format($itemPrice, 2) }}

                                                </span>


                                                <span>

                                                    <i class="fa-solid fa-layer-group"></i>

                                                    Qty {{ $quantity }}

                                                </span>


                                                @if($itemPrice > 0)

                                                    <span>

                                                        <i class="fa-solid fa-calculator"></i>

                                                        ₹{{ number_format($itemPrice * $quantity, 2) }}

                                                    </span>

                                                @endif

                                            </div>

                                        </div>


                                        <div class="product-price">

                                            ₹{{ number_format($itemPrice * $quantity, 2) }}

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="empty-box">

                                <i class="fa-solid fa-box-open"></i>

                                <strong>
                                    No product information
                                </strong>

                                <span>
                                    Product details are not available for this order.
                                </span>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- PAYMENT VERIFICATION --}}

                <section class="seller-card">

                    <div class="seller-card-header">

                        <div class="seller-card-heading">

                            <div class="seller-card-heading-icon">

                                <i class="fa-solid fa-shield-halved"></i>

                            </div>

                            <div>

                                <h2 class="seller-card-title">
                                    Payment Verification
                                </h2>

                                <p class="seller-card-subtitle">
                                    Verify payment before dispatching the order
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="seller-card-body">

                        <div class="payment-panel">

                            <div class="payment-top">

                                <div class="payment-method">

                                    {{ $paymentMethod }}

                                    <small>
                                        Payment method selected by customer
                                    </small>

                                </div>


                                @if($isPaid)

                                    <span class="payment-pill payment-paid">

                                        <i class="fa-solid fa-circle-check"></i>

                                        PAID

                                    </span>

                                @elseif($isFailed)

                                    <span class="payment-pill payment-failed">

                                        <i class="fa-solid fa-circle-xmark"></i>

                                        FAILED

                                    </span>

                                @elseif($isCod)

                                    <span class="payment-pill payment-cod">

                                        <i class="fa-solid fa-money-bill-wave"></i>

                                        COD

                                    </span>

                                @else

                                    <span class="payment-pill payment-pending">

                                        <i class="fa-solid fa-clock"></i>

                                        PENDING

                                    </span>

                                @endif

                            </div>


                            @if($isPaid)

                                <div class="security-note">

                                    <i class="fa-solid fa-shield-check"></i>

                                    <div>

                                        <strong class="text-success">
                                            Payment Verified
                                        </strong>

                                        <br>

                                        Online payment has been successfully
                                        confirmed. This order can proceed to dispatch.

                                    </div>

                                </div>

                            @elseif($isCod)

                                <div class="security-note">

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <div>

                                        <strong>
                                            Cash on Delivery
                                        </strong>

                                        <br>

                                        Customer will pay the amount at the
                                        time of delivery.

                                    </div>

                                </div>

                            @elseif($isFailed)

                                <div class="payment-warning">

                                    <i class="fa-solid fa-triangle-exclamation"></i>

                                    <span>
                                        Payment failed or was cancelled.
                                        Do not dispatch this order.
                                    </span>

                                </div>

                            @else

                                <div class="payment-warning">

                                    <i class="fa-solid fa-lock"></i>

                                    <span>
                                        Online payment is still pending.
                                        Do not dispatch this order until payment
                                        is successfully verified.
                                    </span>

                                </div>

                            @endif


                            <div class="amount-summary">

                                <span class="amount-label">
                                    Total Order Amount
                                </span>


                                <span class="amount-value">

                                    <span>₹</span>{{ number_format($amount, 2) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </section>

            </div>


            {{-- =================================================
                 RIGHT COLUMN
            ================================================== --}}

            <div>


                {{-- ORDER TRACKING --}}

                <section class="seller-card">

                    <div class="seller-card-header">

                        <div class="seller-card-heading">

                            <div class="seller-card-heading-icon">

                                <i class="fa-solid fa-route"></i>

                            </div>

                            <div>

                                <h2 class="seller-card-title">
                                    Order Tracking
                                </h2>

                                <p class="seller-card-subtitle">
                                    Current order delivery progress
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="seller-card-body">

                        <div class="current-status">

                            <div>

                                <div class="current-status-label">
                                    Current Status
                                </div>

                                <div class="current-status-value">

                                    {{ $currentStatus }}

                                </div>

                            </div>


                            <div class="status-live">

                                <span class="live-dot"></span>

                                Live

                            </div>

                        </div>


                        <div class="tracking-list">

                            @foreach($statusSteps as $index => $status)

                                @php

                                    $isActive =
                                        $index <= $currentIndex;

                                @endphp


                                <div
                                    class="tracking-item {{ $isActive ? 'active' : '' }}"
                                >

                                    <div class="tracking-icon">

                                        @if($index < $currentIndex)

                                            <i class="fa-solid fa-check"></i>

                                        @elseif($index === $currentIndex)

                                            <i class="fa-solid fa-location-dot"></i>

                                        @else

                                            <i class="fa-solid fa-circle"></i>

                                        @endif

                                    </div>


                                    <div class="tracking-content">

                                        <div class="tracking-title">

                                            {{ $status }}

                                        </div>


                                        <div class="tracking-caption">

                                            @if($index < $currentIndex)

                                                Completed

                                            @elseif($index === $currentIndex)

                                                Current stage

                                            @else

                                                Waiting for previous step

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </section>


                {{-- DELIVERY ASSIGNMENT --}}

                <section class="seller-card">

                    <div class="seller-card-header">

                        <div class="seller-card-heading">

                            <div class="seller-card-heading-icon">

                                <i class="fa-solid fa-truck-fast"></i>

                            </div>

                            <div>

                                <h2 class="seller-card-title">
                                    Delivery Partner
                                </h2>

                                <p class="seller-card-subtitle">
                                    Assign or update delivery partner
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="seller-card-body">


                        @if($deliveryPartner)

                            <div class="existing-partner">

                                <div class="partner-icon">

                                    <i class="fa-solid fa-user-check"></i>

                                </div>


                                <div class="partner-text">

                                    <strong>

                                        {{ $deliveryPartner->name }}

                                    </strong>

                                    Existing delivery partner is assigned
                                    to this order.

                                </div>

                            </div>

                        @endif


                        <div class="assignment-intro">

                            <i class="fa-solid fa-circle-info"></i>

                            Select an existing partner or create/update
                            delivery partner details for this order.

                        </div>


                        <form
                            action="{{ route('delivery.assign', $order) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="assignment-form"
                        >

                            @csrf


                            @if($deliveryPartners->isNotEmpty())

                                <div class="field-group">

                                    <label class="field-label">

                                        <i class="fa-solid fa-users"></i>

                                        Existing Partner

                                    </label>


                                    <select
                                        name="delivery_partner_id"
                                        class="seller-form-select"
                                    >

                                        <option value="">

                                            + Create New Partner

                                        </option>


                                        @foreach($deliveryPartners as $partner)

                                            <option
                                                value="{{ $partner->id }}"
                                                {{ $order->deliveryDetail?->delivery_partner_id == $partner->id ? 'selected' : '' }}
                                            >

                                                {{ $partner->name }}
                                                —
                                                {{ $partner->phone }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            @endif


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-user"></i>

                                    Delivery Person Name

                                </label>


                                <input
                                    type="text"
                                    name="name"
                                    class="seller-form-control"
                                    value="{{ old('name', $order->deliveryDetail?->deliveryPartner?->name) }}"
                                    placeholder="Enter delivery partner name"
                                >

                            </div>


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-camera"></i>

                                    Profile Image

                                </label>


                                <input
                                    type="file"
                                    name="image"
                                    class="seller-form-control file-control"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                            </div>


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-phone"></i>

                                    Mobile Number

                                </label>


                                <input
                                    type="text"
                                    name="phone"
                                    class="seller-form-control"
                                    value="{{ old('phone', $order->deliveryDetail?->deliveryPartner?->phone) }}"
                                    placeholder="Enter mobile number"
                                >

                            </div>


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-motorcycle"></i>

                                    Vehicle Number

                                </label>


                                <input
                                    type="text"
                                    name="vehicle_number"
                                    class="seller-form-control"
                                    value="{{ old('vehicle_number', $order->deliveryDetail?->deliveryPartner?->vehicle_number) }}"
                                    placeholder="GJ01AB1234"
                                >

                            </div>


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-location-crosshairs"></i>

                                    Current Location

                                </label>


                                <input
                                    type="text"
                                    name="current_location"
                                    class="seller-form-control"
                                    value="{{ old('current_location', $order->deliveryDetail?->current_location) }}"
                                    placeholder="Seller warehouse"
                                >

                            </div>


                            <div class="field-group">

                                <label class="field-label">

                                    <i class="fa-solid fa-bars-progress"></i>

                                    Tracking Status

                                </label>


                                <select
                                    name="status"
                                    class="seller-form-select"
                                >

                                    @foreach($statusSteps as $status)

                                        <option
                                            value="{{ $status }}"
                                            {{ old(
                                                'status',
                                                $order->deliveryDetail?->status
                                                ?? 'Seller Confirmed'
                                            ) == $status ? 'selected' : '' }}
                                        >

                                            {{ $status }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="assign-button"
                            >

                                <i class="fa-solid fa-truck-fast"></i>

                                Save Delivery Assignment

                            </button>


                            <div class="security-note">

                                <i class="fa-solid fa-shield-halved"></i>

                                <div>

                                    Delivery information is linked to this
                                    order and can be updated by the seller.

                                </div>

                            </div>

                        </form>

                    </div>

                </section>


            </div>

        </div>

    </div>

</main>


{{-- =========================================================
     BOOTSTRAP
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- =========================================================
     SMART BASKET THEME SYNC
========================================================= --}}

<script>

(function () {

    const themeKeys = [
        'sb-theme',
        'smartbasket-theme',
        'theme',
        'themeMode',
        'appearance'
    ];


    function getSavedTheme() {

        for (const key of themeKeys) {

            try {

                const value =
                    localStorage.getItem(key);

                if (
                    value === 'dark' ||
                    value === 'light'
                ) {

                    return value;

                }

            } catch (error) {}

        }

        return 'dark';
    }


    function applyTheme(theme) {

        if (
            theme !== 'dark' &&
            theme !== 'light'
        ) {

            theme = 'dark';
        }


        document.documentElement
            .setAttribute(
                'data-sb-theme',
                theme
            );


        if (document.body) {

            document.body
                .setAttribute(
                    'data-sb-theme',
                    theme
                );
        }

    }


    applyTheme(
        getSavedTheme()
    );


    window.addEventListener(
        'storage',
        function (event) {

            if (
                themeKeys.includes(
                    event.key
                )
            ) {

                applyTheme(
                    event.newValue || 'dark'
                );

            }

        }
    );


    window.addEventListener(
        'smartbasket-theme-changed',
        function (event) {

            if (event.detail) {

                applyTheme(
                    event.detail
                );

            }

        }
    );


})();

</script>


</body>

</html>
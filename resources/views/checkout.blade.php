<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SMART BASKET | Secure Checkout</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>
        /* =========================================================
           SMART BASKET — MULTI STEP CHECKOUT
        ========================================================= */

        :root {
            --sb-bg: #f4f7fc;
            --sb-bg-2: #eef2ff;

            --sb-card: rgba(255,255,255,.90);
            --sb-card-solid: #ffffff;
            --sb-surface: #f8fafc;
            --sb-surface-2: #f1f5f9;

            --sb-text: #172033;
            --sb-heading: #071126;
            --sb-muted: #64748b;

            --sb-border: rgba(15,23,42,.09);
            --sb-border-strong: rgba(15,23,42,.14);

            --sb-primary: #2563eb;
            --sb-primary-2: #4f46e5;
            --sb-purple: #7c3aed;
            --sb-cyan: #06b6d4;

            --sb-success: #16a34a;
            --sb-danger: #ef4444;
            --sb-warning: #f59e0b;

            --sb-input: #ffffff;

            --sb-shadow:
                0 30px 90px rgba(15,23,42,.12);

            --sb-small-shadow:
                0 12px 35px rgba(15,23,42,.07);

            --sb-radius-xl: 30px;
            --sb-radius-lg: 22px;
            --sb-radius-md: 15px;
        }

        /* =========================================================
           DARK THEME
        ========================================================= */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --sb-bg: #020617;
            --sb-bg-2: #0b1120;

            --sb-card: rgba(15,23,42,.94);
            --sb-card-solid: #0f172a;
            --sb-surface: #111c2e;
            --sb-surface-2: #172235;

            --sb-text: #dbe5f3;
            --sb-heading: #f8fafc;
            --sb-muted: #94a3b8;

            --sb-border: rgba(255,255,255,.075);
            --sb-border-strong: rgba(255,255,255,.13);

            --sb-input: #0b1220;

            --sb-shadow:
                0 35px 100px rgba(0,0,0,.48);

            --sb-small-shadow:
                0 15px 45px rgba(0,0,0,.30);
        }

        /* =========================================================
           RESET
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;

            color: var(--sb-text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(37,99,235,.17),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 10%,
                    rgba(124,58,237,.15),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(6,182,212,.09),
                    transparent 35%
                ),
                var(--sb-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }

        /* =========================================================
           AMBIENT BACKGROUND
        ========================================================= */

        .premium-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .18;
            animation: orbFloat 11s ease-in-out infinite;
        }

        .orb-one {
            width: 300px;
            height: 300px;
            background: #2563eb;
            top: 5%;
            left: -100px;
        }

        .orb-two {
            width: 330px;
            height: 330px;
            background: #7c3aed;
            right: -120px;
            top: 35%;
            animation-delay: -4s;
        }

        .orb-three {
            width: 220px;
            height: 220px;
            background: #06b6d4;
            left: 45%;
            bottom: -100px;
            animation-delay: -7s;
        }

        @keyframes orbFloat {
            0%,100% {
                transform: translate3d(0,0,0);
            }

            50% {
                transform: translate3d(25px,-30px,0);
            }
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .checkout-wrapper {
            min-height: 100vh;
            padding: 28px 18px 70px;
        }

        .checkout-container {
            width: 100%;
            max-width: 1180px;
            margin: auto;
        }

        /* =========================================================
           TOP BAR
        ========================================================= */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            margin-bottom: 22px;
            padding: 0 5px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;

            color: var(--sb-heading);
            font-size: 18px;
            font-weight: 950;
            letter-spacing: -.4px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;

            display: grid;
            place-items: center;

            border-radius: 14px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            box-shadow:
                0 12px 28px rgba(37,99,235,.28);
        }

        .secure-mini {
            display: flex;
            align-items: center;
            gap: 7px;

            padding: 8px 13px;

            border-radius: 999px;

            color: var(--sb-success);

            background: rgba(34,197,94,.08);

            border:
                1px solid rgba(34,197,94,.15);

            font-size: 11px;
            font-weight: 850;
        }

        /* =========================================================
           PROGRESS BAR
        ========================================================= */

        .progress-card {
            margin-bottom: 22px;
            padding: 20px 18px;

            border:
                1px solid var(--sb-border);

            border-radius: 24px;

            background: var(--sb-card);

            box-shadow: var(--sb-small-shadow);

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .progress-track {
            display: flex;
            align-items: center;
            justify-content: center;

            max-width: 900px;
            margin: auto;
        }

        .progress-step {
            position: relative;

            display: flex;
            align-items: center;
            gap: 9px;

            color: var(--sb-muted);

            font-size: 11px;
            font-weight: 850;

            white-space: nowrap;

            transition: .3s ease;
        }

        .progress-step.active {
            color: var(--sb-primary);
        }

        .progress-step.completed {
            color: var(--sb-success);
        }

        .progress-circle {
            width: 36px;
            height: 36px;

            display: grid;
            place-items: center;

            border-radius: 50%;

            background: var(--sb-surface-2);

            border:
                1px solid var(--sb-border-strong);

            color: var(--sb-muted);

            font-size: 12px;
            font-weight: 950;

            transition: .3s ease;
        }

        .progress-step.active .progress-circle {
            color: #fff;

            border-color: transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            box-shadow:
                0 8px 20px rgba(37,99,235,.24);
        }

        .progress-step.completed .progress-circle {
            color: #fff;

            border-color: transparent;

            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

            box-shadow:
                0 8px 20px rgba(34,197,94,.22);
        }

        .progress-line {
            width: 70px;
            height: 3px;

            margin: 0 10px;

            border-radius: 99px;

            background: var(--sb-border-strong);

            transition: .4s ease;
        }

        .progress-line.completed {
            background:
                linear-gradient(
                    90deg,
                    #16a34a,
                    #22c55e
                );
        }

        /* =========================================================
           GRID
        ========================================================= */

        .checkout-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.45fr)
                minmax(320px, .75fr);

            gap: 22px;

            align-items: start;
        }

        /* =========================================================
           MAIN CARD
        ========================================================= */

        .checkout-card {
            position: relative;
            overflow: hidden;

            padding: 32px;

            border:
                1px solid var(--sb-border);

            border-radius: var(--sb-radius-xl);

            background: var(--sb-card);

            box-shadow: var(--sb-shadow);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
        }

        .checkout-card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;
            right: 0;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed,
                    #06b6d4
                );
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .checkout-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .title-wrap {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .title-icon {
            width: 55px;
            height: 55px;

            flex-shrink: 0;

            display: grid;
            place-items: center;

            border-radius: 17px;

            font-size: 25px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.13),
                    rgba(124,58,237,.13)
                );

            border:
                1px solid rgba(99,102,241,.17);
        }

        .checkout-title {
            margin: 0;

            color: var(--sb-heading);

            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -1.2px;
        }

        .checkout-subtitle {
            margin: 7px 0 0;

            color: var(--sb-muted);

            font-size: 13px;
        }

        .protected-badge {
            display: flex;
            align-items: center;
            gap: 7px;

            padding: 10px 14px;

            border-radius: 999px;

            color: var(--sb-success);

            background:
                rgba(34,197,94,.09);

            border:
                1px solid rgba(34,197,94,.17);

            font-size: 11px;
            font-weight: 900;

            white-space: nowrap;
        }

        /* =========================================================
           STEP CONTENT
        ========================================================= */

        .checkout-step {
            display: none;

            animation:
                stepIn .35s ease;
        }

        .checkout-step.active {
            display: block;
        }

        @keyframes stepIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-heading {
            display: flex;
            align-items: flex-start;
            gap: 13px;

            margin-bottom: 24px;
        }

        .step-heading-icon {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            display: grid;
            place-items: center;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.12),
                    rgba(124,58,237,.12)
                );

            border:
                1px solid rgba(99,102,241,.16);

            font-size: 21px;
        }

        .step-heading h2 {
            margin: 0;

            color: var(--sb-heading);

            font-size: 22px;
            font-weight: 950;
        }

        .step-heading p {
            margin: 5px 0 0;

            color: var(--sb-muted);

            font-size: 12px;
            line-height: 1.55;
        }

        /* =========================================================
           FORMS
        ========================================================= */

        .form-label {
            display: block;

            margin-bottom: 7px;

            color: var(--sb-text);

            font-size: 12px;
            font-weight: 800;
        }

        .form-control,
        .form-select {
            min-height: 51px;

            padding: 12px 14px;

            color: var(--sb-text) !important;

            background:
                var(--sb-input) !important;

            border:
                1px solid var(--sb-border-strong) !important;

            border-radius:
                var(--sb-radius-md) !important;

            box-shadow:
                none !important;

            transition:
                border .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
        }

        .form-control:hover,
        .form-select:hover {
            border-color:
                rgba(37,99,235,.32) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:
                var(--sb-primary) !important;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.10) !important;
        }

        .form-control::placeholder {
            color: var(--sb-muted);
            opacity: .7;
        }

        textarea.form-control {
            min-height: 115px;
            resize: vertical;
        }

        /* =========================================================
           MOBILE VERIFICATION
        ========================================================= */

        .mobile-verify-wrap {
            position: relative;
        }

        .mobile-input-row {
            display: flex;
            gap: 9px;
        }

        .mobile-input-row .form-control {
            flex: 1;
        }

        .verify-mobile-btn {
            min-width: 125px;

            border: 0;

            border-radius: 14px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            font-size: 11px;
            font-weight: 900;

            cursor: pointer;

            transition: .22s ease;
        }

        .verify-mobile-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 12px 28px rgba(37,99,235,.25);
        }

        .verify-mobile-btn:disabled {
            cursor: not-allowed;
            opacity: .65;
            transform: none;
        }

        .mobile-status {
            display: none;

            align-items: center;
            gap: 7px;

            margin-top: 9px;
            padding: 9px 11px;

            border-radius: 12px;

            font-size: 10px;
            font-weight: 800;
        }

        .mobile-status.success {
            display: flex;

            color: #15803d;

            background:
                rgba(34,197,94,.08);

            border:
                1px solid rgba(34,197,94,.14);
        }

        .mobile-status.error {
            display: flex;

            color: #dc2626;

            background:
                rgba(239,68,68,.08);

            border:
                1px solid rgba(239,68,68,.14);
        }

        .profile-mobile-hint {
            margin-top: 7px;

            color: var(--sb-muted);

            font-size: 9px;
        }

        .verified-input {
            border-color:
                #22c55e !important;

            box-shadow:
                0 0 0 4px rgba(34,197,94,.08) !important;
        }

        /* =========================================================
           DELIVERY FEATURES
        ========================================================= */

        .delivery-info {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 10px;

            margin-top: 20px;
        }

        .delivery-info-card {
            padding: 13px;

            border-radius: 15px;

            background: var(--sb-surface);

            border:
                1px solid var(--sb-border);
        }

        .delivery-info-icon {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .delivery-info-title {
            color: var(--sb-heading);
            font-size: 11px;
            font-weight: 850;
        }

        .delivery-info-text {
            margin-top: 2px;
            color: var(--sb-muted);
            font-size: 10px;
        }

        /* =========================================================
           PAYMENT
        ========================================================= */

        .payment-box {
            position: relative;
            overflow: hidden;

            padding: 23px;

            border:
                1px solid var(--sb-border-strong);

            border-radius: var(--sb-radius-lg);

            background:
                linear-gradient(
                    145deg,
                    var(--sb-surface),
                    var(--sb-surface-2)
                );

            box-shadow: var(--sb-small-shadow);
        }

        .payment-box::before {
            content: "";

            position: absolute;

            width: 160px;
            height: 160px;

            right: -80px;
            top: -80px;

            border-radius: 50%;

            background:
                rgba(37,99,235,.09);

            filter: blur(25px);

            pointer-events: none;
        }

        .payment-option-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 11px;

            margin-bottom: 17px;
        }

        .payment-option {
            position: relative;

            padding: 15px;

            border:
                1px solid var(--sb-border);

            border-radius: 16px;

            background:
                var(--sb-surface);

            cursor: pointer;

            transition: .22s ease;
        }

        .payment-option:hover {
            transform: translateY(-2px);

            border-color:
                rgba(37,99,235,.28);
        }

        .payment-option.selected {
            border-color:
                var(--sb-primary);

            background:
                rgba(37,99,235,.07);

            box-shadow:
                0 10px 30px rgba(37,99,235,.10);
        }

        .payment-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .payment-option-icon {
            font-size: 23px;
            margin-bottom: 8px;
        }

        .payment-option-title {
            color: var(--sb-heading);

            font-size: 12px;
            font-weight: 900;
        }

        .payment-option-text {
            margin-top: 3px;

            color: var(--sb-muted);

            font-size: 9px;
            line-height: 1.4;
        }

        .payment-details {
            display: none;
            margin-top: 16px;

            animation:
                paymentIn .28s ease;
        }

        .payment-details.active {
            display: block;
        }

        @keyframes paymentIn {
            from {
                opacity: 0;
                transform:
                    translateY(8px)
                    scale(.99);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }

        .payment-title {
            display: flex;
            align-items: center;
            gap: 10px;

            color: var(--sb-heading);

            font-size: 17px;
            font-weight: 950;
        }

        .payment-title-icon {
            width: 39px;
            height: 39px;

            display: grid;
            place-items: center;

            border-radius: 12px;

            background:
                rgba(37,99,235,.11);

            border:
                1px solid rgba(37,99,235,.14);
        }

        .payment-description {
            margin: 8px 0 18px;

            color: var(--sb-muted);

            font-size: 12px;
            line-height: 1.6;
        }

        .payment-icons {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 9px;

            margin-bottom: 19px;
        }

        .payment-icon {
            min-height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 7px;

            border-radius: 11px;

            color: var(--sb-text);

            background:
                rgba(37,99,235,.06);

            border:
                1px solid rgba(37,99,235,.12);

            font-size: 10px;
            font-weight: 850;
        }

        /* =========================================================
           UPI
        ========================================================= */

        .upi-id-wrap {
            position: relative;
        }

        .upi-copy-btn {
            position: absolute;

            right: 7px;
            bottom: 7px;

            height: 37px;

            padding: 0 12px;

            border: 0;

            border-radius: 10px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            font-size: 10px;
            font-weight: 850;

            cursor: pointer;
        }

        .qr-card {
            position: relative;

            margin-top: 22px;
            padding: 22px;

            text-align: center;

            border-radius: 20px;

            color: #0f172a;

            background: #fff;

            border:
                1px solid rgba(15,23,42,.08);

            box-shadow:
                0 18px 50px rgba(0,0,0,.12);
        }

        .qr-label {
            display: inline-flex;

            padding: 6px 11px;
            margin-bottom: 12px;

            border-radius: 999px;

            color: #2563eb;
            background: #eff6ff;

            font-size: 9px;
            font-weight: 900;
        }

        .qr-pay-title {
            margin: 6px 0;

            font-size: 14px;
            font-weight: 950;
        }

        .qr-card img {
            display: block;

            width: 215px;
            height: 215px;

            max-width: 100%;

            margin: 14px auto;

            padding: 8px;

            object-fit: contain;

            border-radius: 15px;

            background: #fff;

            box-shadow:
                0 12px 35px rgba(15,23,42,.14);
        }

        .qr-note {
            color: #64748b;
            font-size: 10px;
        }

        /* =========================================================
           CARD
        ========================================================= */

        .card-visual {
            position: relative;
            overflow: hidden;

            width: 100%;
            max-width: 410px;
            height: 220px;

            margin:
                0 auto 22px;

            padding: 25px;

            border-radius: 23px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #1e3a8a 52%,
                    #7c3aed
                );

            box-shadow:
                0 22px 50px rgba(37,99,235,.25);
        }

        .card-visual::before {
            content: "";

            position: absolute;

            width: 240px;
            height: 240px;

            right: -90px;
            bottom: -130px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.10);
        }

        .card-chip {
            width: 43px;
            height: 32px;

            border-radius: 7px;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #94a3b8
                );
        }

        .card-brand {
            position: absolute;

            right: 24px;
            top: 23px;

            font-size: 12px;
            font-weight: 950;

            letter-spacing: .7px;
        }

        .card-number-preview {
            margin-top: 29px;

            font-size: 18px;

            letter-spacing: 3px;

            font-weight: 750;
        }

        .card-bottom {
            position: absolute;

            left: 25px;
            right: 25px;
            bottom: 20px;

            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .card-preview-label {
            font-size: 8px;
            opacity: .65;
            text-transform: uppercase;
        }

        .card-preview-value {
            margin-top: 3px;
            font-size: 11px;
            font-weight: 800;
        }

        .cvv-wrap {
            position: relative;
        }

        .cvv-toggle {
            position: absolute;

            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: 0;

            background: transparent;

            color: var(--sb-muted);

            cursor: pointer;
        }

        /* =========================================================
           COD
        ========================================================= */

        .cod-feature-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 10px;

            margin-top: 18px;
        }

        .cod-feature {
            padding: 12px;

            border-radius: 14px;

            background:
                rgba(34,197,94,.06);

            border:
                1px solid rgba(34,197,94,.11);
        }

        .cod-feature strong {
            display: block;

            color: var(--sb-heading);

            font-size: 11px;
        }

        .cod-feature span {
            color: var(--sb-muted);
            font-size: 9px;
        }

        /* =========================================================
           REVIEW
        ========================================================= */

        .review-card {
            padding: 17px;

            margin-bottom: 12px;

            border-radius: 17px;

            background: var(--sb-surface);

            border:
                1px solid var(--sb-border);
        }

        .review-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 11px;
        }

        .review-card-title {
            color: var(--sb-heading);

            font-size: 13px;
            font-weight: 900;
        }

        .review-edit {
            border: 0;

            padding: 5px 9px;

            border-radius: 8px;

            color: var(--sb-primary);

            background:
                rgba(37,99,235,.08);

            font-size: 9px;
            font-weight: 850;

            cursor: pointer;
        }

        .review-value {
            color: var(--sb-text);

            font-size: 11px;
            line-height: 1.65;
        }

        .review-muted {
            color: var(--sb-muted);
        }

        .review-payment {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-payment-icon {
            width: 38px;
            height: 38px;

            display: grid;
            place-items: center;

            border-radius: 11px;

            background:
                rgba(37,99,235,.09);
        }

        /* =========================================================
           NAVIGATION
        ========================================================= */

        .step-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;

            margin-top: 27px;
            padding-top: 20px;

            border-top:
                1px solid var(--sb-border);
        }

        .step-back-btn {
            min-height: 49px;

            padding: 0 19px;

            border:
                1px solid var(--sb-border-strong);

            border-radius: 14px;

            color: var(--sb-text);

            background:
                var(--sb-surface);

            font-size: 11px;
            font-weight: 850;

            cursor: pointer;

            transition: .2s ease;
        }

        .step-back-btn:hover {
            border-color:
                rgba(37,99,235,.3);

            color:
                var(--sb-primary);
        }

        .step-next-btn,
        .final-confirm-btn {
            min-height: 51px;

            padding: 0 25px;

            border: 0;

            border-radius: 15px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5 50%,
                    #7c3aed
                );

            font-size: 12px;
            font-weight: 950;

            box-shadow:
                0 13px 30px rgba(37,99,235,.23);

            cursor: pointer;

            transition: .22s ease;
        }

        .step-next-btn:hover,
        .final-confirm-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 18px 38px rgba(37,99,235,.31);
        }

        .step-next-btn:disabled {
            cursor: not-allowed;
            opacity: .55;
            transform: none;
            box-shadow: none;
        }

        .step-hint {
            color: var(--sb-muted);

            font-size: 9px;
        }

        /* =========================================================
           SUMMARY SIDEBAR
        ========================================================= */

        .summary-card {
            position: sticky;
            top: 18px;

            overflow: hidden;

            padding: 23px;

            border:
                1px solid var(--sb-border);

            border-radius: 25px;

            background: var(--sb-card);

            box-shadow: var(--sb-shadow);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
        }

        .summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 18px;
        }

        .summary-title {
            margin: 0;

            color: var(--sb-heading);

            font-size: 18px;
            font-weight: 950;
        }

        .item-count {
            padding: 5px 9px;

            border-radius: 999px;

            color: var(--sb-primary);

            background:
                rgba(37,99,235,.08);

            font-size: 10px;
            font-weight: 900;
        }

        .summary-items {
            max-height: 330px;
            overflow-y: auto;
        }

        .summary-item {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding: 13px 0;

            border-bottom:
                1px solid var(--sb-border);
        }

        .summary-item:last-child {
            border-bottom: 0;
        }

        .summary-product {
            min-width: 0;
        }

        .summary-product-name {
            overflow: hidden;

            color: var(--sb-heading);

            font-size: 12px;
            font-weight: 800;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .summary-product-qty {
            display: inline-block;

            margin-top: 4px;

            color: var(--sb-muted);

            font-size: 9px;
        }

        .summary-price {
            color: var(--sb-heading);

            font-size: 12px;
            font-weight: 900;

            white-space: nowrap;
        }

        .summary-divider {
            height: 1px;

            margin: 14px 0;

            background:
                var(--sb-border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;

            margin: 8px 0;

            color: var(--sb-muted);

            font-size: 11px;
        }

        .summary-row strong {
            color: var(--sb-heading);
        }

        .summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 16px;
            padding-top: 16px;

            border-top:
                1px solid var(--sb-border);

            color: var(--sb-heading);

            font-size: 17px;
            font-weight: 950;
        }

        .summary-total-price {
            background:
                linear-gradient(
                    90deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            -webkit-background-clip: text;
            background-clip: text;

            color: transparent;

            font-size: 21px;
        }

        .delivery-estimate {
            display: flex;
            align-items: center;
            gap: 11px;

            margin-top: 18px;
            padding: 13px;

            border-radius: 15px;

            background:
                rgba(34,197,94,.06);

            border:
                1px solid rgba(34,197,94,.12);
        }

        .delivery-estimate-icon {
            width: 36px;
            height: 36px;

            display: grid;
            place-items: center;

            border-radius: 11px;

            background:
                rgba(34,197,94,.11);
        }

        .delivery-estimate-title {
            color: var(--sb-heading);

            font-size: 10px;
            font-weight: 900;
        }

        .delivery-estimate-text {
            margin-top: 2px;

            color: var(--sb-muted);

            font-size: 9px;
        }

        .trust-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 7px;

            margin-top: 16px;
        }

        .trust-item {
            padding: 11px 5px;

            text-align: center;

            border-radius: 13px;

            background: var(--sb-surface);

            border:
                1px solid var(--sb-border);
        }

        .trust-item-icon {
            font-size: 15px;
        }

        .trust-item-text {
            margin-top: 4px;

            color: var(--sb-muted);

            font-size: 8px;
            font-weight: 800;
        }

        /* =========================================================
           MOBILE SUMMARY
        ========================================================= */

        .mobile-summary-toggle {
            display: none;

            width: 100%;

            margin-bottom: 12px;
            padding: 13px 15px;

            border:
                1px solid var(--sb-border);

            border-radius: 16px;

            color: var(--sb-heading);

            background: var(--sb-card);

            font-size: 12px;
            font-weight: 850;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty-checkout {
            padding: 50px 20px;

            text-align: center;

            color: var(--sb-muted);
        }

        .empty-icon {
            font-size: 60px;
        }

        .empty-checkout h3 {
            margin-top: 12px;

            color: var(--sb-heading);

            font-size: 20px;
            font-weight: 950;
        }

        .browse-btn {
            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 55px;

            margin-top: 20px;

            border-radius: 16px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            text-decoration: none;

            font-size: 13px;
            font-weight: 950;
        }

        /* =========================================================
           LOADER
        ========================================================= */

        .button-loader {
            display: none;

            width: 18px;
            height: 18px;

            margin-right: 7px;

            vertical-align: middle;

            border:
                2px solid rgba(255,255,255,.35);

            border-top-color: #fff;

            border-radius: 50%;

            animation:
                spin .7s linear infinite;
        }

        .loading .button-loader {
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }

        @media (max-width: 700px) {

            .checkout-wrapper {
                padding:
                    15px 9px 45px;
            }

            .topbar {
                margin-bottom: 13px;
            }

            .brand {
                font-size: 15px;
            }

            .brand-logo {
                width: 36px;
                height: 36px;
                border-radius: 11px;
            }

            .secure-mini {
                font-size: 9px;
                padding: 7px 9px;
            }

            .progress-card {
                padding: 13px 7px;
                border-radius: 17px;
            }

            .progress-step {
                font-size: 8px;
                gap: 4px;
            }

            .progress-circle {
                width: 29px;
                height: 29px;
                font-size: 9px;
            }

            .progress-line {
                width: 23px;
                margin: 0 3px;
            }

            .checkout-card {
                padding: 22px 15px;
                border-radius: 22px;
            }

            .checkout-header {
                flex-direction: column;
                margin-bottom: 20px;
            }

            .checkout-title {
                font-size: 28px;
            }

            .title-icon {
                width: 47px;
                height: 47px;
                font-size: 21px;
            }

            .protected-badge {
                font-size: 9px;
            }

            .delivery-info {
                grid-template-columns: 1fr;
            }

            .payment-option-grid {
                grid-template-columns: 1fr;
            }

            .payment-icons {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .card-visual {
                height: 190px;
                padding: 21px;
            }

            .card-number-preview {
                margin-top: 25px;
                font-size: 14px;
            }

            .cod-feature-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                border-radius: 20px;
            }

            .mobile-summary-toggle {
                display: block;
            }

            .step-actions {
                align-items: stretch;
            }

            .step-next-btn,
            .final-confirm-btn,
            .step-back-btn {
                flex: 1;
            }

            .step-hint {
                display: none;
            }

            .mobile-input-row {
                flex-direction: column;
            }

            .verify-mobile-btn {
                min-height: 48px;
            }
        }

        @media (max-width: 400px) {

            .checkout-title {
                font-size: 25px;
            }

            .progress-step span {
                display: none;
            }

            .progress-line {
                width: 25px;
            }

            .progress-track {
                justify-content: space-between;
            }
        }
    </style>
</head>

@php

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER THEME
    |--------------------------------------------------------------------------
    */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';

    if (!in_array($customerTheme, ['dark', 'light', 'system'], true)) {
        $customerTheme = 'system';
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT DATA
    |--------------------------------------------------------------------------
    */

    $checkoutItems = $cartItems ?? [];
    $checkoutTotal = $total ?? 0;


    /*
    |--------------------------------------------------------------------------
    | PROFILE MOBILE
    |--------------------------------------------------------------------------
    |
    | Used by the frontend verification step.
    | The order controller should ALSO validate this server-side.
    |
    */

    $profileMobile = auth()->user()?->phone ?? '';


    /*
    |--------------------------------------------------------------------------
    | PAYMENT SELLERS
    |--------------------------------------------------------------------------
    */

    $paymentSellers =
        collect($checkoutItems)
        ->map(







        
            fn($item) =>
                $item['product']
                ?? $item->product
                ?? null
        )
        ->filter()
        ->map(
            fn($product) =>
                $product->seller
        )
        ->filter()
        ->unique('id');

@endphp

<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>

    <!-- =========================================================
         AMBIENT BACKGROUND
    ========================================================== -->

    <div class="premium-bg">

        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
        <div class="orb orb-three"></div>

    </div>


    <div class="checkout-wrapper">

        <div class="checkout-container">


            <!-- =================================================
                 TOP BAR
            ================================================== -->

            <div class="topbar">

                <div class="brand">

                    <div class="brand-logo">
                        🛒
                    </div>

                    SMART BASKET

                </div>

                <div class="secure-mini">
                    🔒 Secure Checkout
                </div>

            </div>


            @if(count($checkoutItems) > 0)


                <!-- =================================================
                     PROGRESS
                ================================================== -->

                <div class="progress-card">

                    <div class="progress-track" id="progressTrack">

                        <div
                            class="progress-step active"
                            data-progress="1"
                        >

                            <div class="progress-circle">
                                1
                            </div>

                            <span>Details</span>

                        </div>


                        <div
                            class="progress-line"
                            data-line="1"
                        ></div>


                        <div
                            class="progress-step"
                            data-progress="2"
                        >

                            <div class="progress-circle">
                                2
                            </div>

                            <span>Address</span>

                        </div>


                        <div
                            class="progress-line"
                            data-line="2"
                        ></div>


                        <div
                            class="progress-step"
                            data-progress="3"
                        >

                            <div class="progress-circle">
                                3
                            </div>

                            <span>Payment</span>

                        </div>


                        <div
                            class="progress-line"
                            data-line="3"
                        ></div>


                        <div
                            class="progress-step"
                            data-progress="4"
                        >

                            <div class="progress-circle">
                                4
                            </div>

                            <span>Review</span>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     MOBILE SUMMARY
                ================================================== -->

                <button
                    type="button"
                    class="mobile-summary-toggle"
                    id="mobileSummaryToggle"
                >

                    🛒 View Order Summary

                    <span style="float:right;">
                        ₹{{ number_format((float)$checkoutTotal, 2) }}
                    </span>

                </button>


                <!-- =================================================
                     GRID
                ================================================== -->

                <div class="checkout-grid">


                    <!-- =================================================
                         LEFT CHECKOUT
                    ================================================== -->

                    <div class="checkout-card">

                        <div class="checkout-header">

                            <div class="title-wrap">

                                <div class="title-icon">
                                    🛍️
                                </div>

                                <div>

                                    <h1 class="checkout-title">
                                        Complete Your Order
                                    </h1>

                                    <p class="checkout-subtitle">
                                        Follow each step to safely place your order.
                                    </p>

                                </div>

                            </div>


                            <div class="protected-badge">
                                🛡️ Protected
                            </div>

                        </div>


                        <!-- =================================================
                             FORM
                        ================================================== -->

                        <form
                            action="{{ route('place.order') }}"
                            method="POST"
                            id="checkoutForm"
                            novalidate
                        >

                            @csrf


                            <!-- =================================================
                                 STEP 1 — DETAILS
                            ================================================== -->

                            <section
                                class="checkout-step active"
                                data-step="1"
                            >

                                <div class="step-heading">

                                    <div class="step-heading-icon">
                                        👤
                                    </div>

                                    <div>

                                        <h2>
                                            Customer Details
                                        </h2>

                                        <p>
                                            Enter your details and verify your profile mobile number before continuing.
                                        </p>

                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <label
                                            class="form-label"
                                            for="customerName"
                                        >
                                            Full Name
                                        </label>

                                        <input
                                            type="text"
                                            name="name"
                                            id="customerName"
                                            class="form-control"
                                            value="{{ old('name', auth()->user()?->name) }}"
                                            placeholder="Enter your full name"
                                            autocomplete="name"
                                            required
                                        >

                                    </div>


                                    <div class="col-md-6 mb-3">

                                        <label
                                            class="form-label"
                                            for="customerMobile"
                                        >
                                            Mobile Number
                                        </label>

                                        <div class="mobile-input-row">

                                            <input
                                                type="tel"
                                                name="mobile"
                                                id="customerMobile"
                                                class="form-control"
                                                value="{{ old('mobile', auth()->user()?->phone) }}"
                                                placeholder="Enter profile mobile number"
                                                autocomplete="tel"
                                                maxlength="15"
                                                inputmode="tel"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="verify-mobile-btn"
                                                id="verifyMobileBtn"
                                            >
                                                ✓ Verify Mobile
                                            </button>

                                        </div>


                                        <div
                                            class="profile-mobile-hint"
                                            id="profileMobileHint"
                                        >
                                            Your mobile must match the number saved in your Smart Basket profile.
                                        </div>


                                        <div
                                            class="mobile-status"
                                            id="mobileStatus"
                                        ></div>

                                    </div>

                                </div>


                                <div class="delivery-info">

                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            🔐
                                        </div>

                                        <div class="delivery-info-title">
                                            Profile Verification
                                        </div>

                                        <div class="delivery-info-text">
                                            Mobile is checked against your profile.
                                        </div>

                                    </div>


                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            ✓
                                        </div>

                                        <div class="delivery-info-title">
                                            Verified Customer
                                        </div>

                                        <div class="delivery-info-text">
                                            Verified details continue to the next step.
                                        </div>

                                    </div>


                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            🛡️
                                        </div>

                                        <div class="delivery-info-title">
                                            Protected
                                        </div>

                                        <div class="delivery-info-text">
                                            Your payment information is not saved.
                                        </div>

                                    </div>

                                </div>


                                <div class="step-actions">

                                    <span class="step-hint">
                                        Verify your mobile to continue
                                    </span>

                                    <button
                                        type="button"
                                        class="step-next-btn"
                                        id="step1Next"
                                        disabled
                                    >
                                        Continue to Address →
                                    </button>

                                </div>

                            </section>


                            <!-- =================================================
                                 STEP 2 — ADDRESS
                            ================================================== -->

                            <section
                                class="checkout-step"
                                data-step="2"
                            >

                                <div class="step-heading">

                                    <div class="step-heading-icon">
                                        📍
                                    </div>

                                    <div>

                                        <h2>
                                            Delivery Address
                                        </h2>

                                        <p>
                                            Tell us exactly where your order should be delivered.
                                        </p>

                                    </div>

                                </div>


                                <div class="mb-3">

                                    <label
                                        class="form-label"
                                        for="customerAddress"
                                    >
                                        Delivery Address
                                    </label>

                                    <textarea
                                        name="address"
                                        id="customerAddress"
                                        class="form-control"
                                        rows="3"
                                        placeholder="House no., street, area..."
                                        autocomplete="street-address"
                                        required
                                    >{{ old('address', auth()->user()?->address) }}</textarea>

                                </div>


                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <label
                                            class="form-label"
                                            for="customerCity"
                                        >
                                            City
                                        </label>

                                        <input
                                            type="text"
                                            name="city"
                                            id="customerCity"
                                            class="form-control"
                                            value="{{ old('city', auth()->user()?->city) }}"
                                            placeholder="Enter city"
                                            autocomplete="address-level2"
                                            required
                                        >

                                    </div>


                                    <div class="col-md-6 mb-3">

                                        <label
                                            class="form-label"
                                            for="customerPin"
                                        >
                                            PIN Code
                                        </label>

                                        <input
                                            type="text"
                                            name="pin_code"
                                            id="customerPin"
                                            class="form-control"
                                            value="{{ old('pin_code', auth()->user()?->pin_code) }}"
                                            placeholder="6-digit PIN code"
                                            maxlength="6"
                                            inputmode="numeric"
                                            autocomplete="postal-code"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="delivery-info">

                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            🚚
                                        </div>

                                        <div class="delivery-info-title">
                                            Fast Delivery
                                        </div>

                                        <div class="delivery-info-text">
                                            Reliable doorstep delivery
                                        </div>

                                    </div>


                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            📍
                                        </div>

                                        <div class="delivery-info-title">
                                            Address Verified
                                        </div>

                                        <div class="delivery-info-text">
                                            Your order goes to this address
                                        </div>

                                    </div>


                                    <div class="delivery-info-card">

                                        <div class="delivery-info-icon">
                                            🔔
                                        </div>

                                        <div class="delivery-info-title">
                                            Order Updates
                                        </div>

                                        <div class="delivery-info-text">
                                            Stay updated about your order
                                        </div>

                                    </div>

                                </div>


                                <div class="step-actions">

                                    <button
                                        type="button"
                                        class="step-back-btn"
                                        data-back="1"
                                    >
                                        ← Back
                                    </button>

                                    <button
                                        type="button"
                                        class="step-next-btn"
                                        id="step2Next"
                                    >
                                        Continue to Payment →
                                    </button>

                                </div>

                            </section>


                            <!-- =================================================
                                 STEP 3 — PAYMENT
                            ================================================== -->

                            <section
                                class="checkout-step"
                                data-step="3"
                            >

                                <div class="step-heading">

                                    <div class="step-heading-icon">
                                        💳
                                    </div>

                                    <div>

                                        <h2>
                                            Choose Payment Method
                                        </h2>

                                        <p>
                                            Select the payment option that works best for you.
                                        </p>

                                    </div>

                                </div>


                                <div class="payment-box">

                                    <div class="payment-option-grid">


                                        <!-- COD -->

                                        <label
                                            class="payment-option selected"
                                            data-payment-option="COD"
                                        >

                                            <input
                                                type="radio"
                                                name="payment_method"
                                                value="COD"
                                                checked
                                            >

                                            <div class="payment-option-icon">
                                                🚚
                                            </div>

                                            <div class="payment-option-title">
                                                Cash on Delivery
                                            </div>

                                            <div class="payment-option-text">
                                                Pay after receiving your order.
                                            </div>

                                        </label>


                                        @if($onlinePaymentAvailable ?? false)

                                            <!-- UPI -->

                                            <label
                                                class="payment-option"
                                                data-payment-option="UPI"
                                            >

                                                <input
                                                    type="radio"
                                                    name="payment_method"
                                                    value="UPI"
                                                >

                                                <div class="payment-option-icon">
                                                    📱
                                                </div>

                                                <div class="payment-option-title">
                                                    UPI Payment
                                                </div>

                                                <div class="payment-option-text">
                                                    Pay quickly using UPI.
                                                </div>

                                            </label>


                                            <!-- CARD -->

                                            <label
                                                class="payment-option"
                                                data-payment-option="Card"
                                            >

                                                <input
                                                    type="radio"
                                                    name="payment_method"
                                                    value="Card"
                                                >

                                                <div class="payment-option-icon">
                                                    💳
                                                </div>

                                                <div class="payment-option-title">
                                                    Card Payment
                                                </div>

                                                <div class="payment-option-text">
                                                    Pay securely with your card.
                                                </div>

                                            </label>

                                        @endif

                                    </div>


                                    <!-- =================================================
                                         COD DETAILS
                                    ================================================== -->

                                    <div
                                        class="payment-details active"
                                        id="codDetails"
                                        data-payment-details="COD"
                                    >

                                        <div class="payment-title">

                                            <div class="payment-title-icon">
                                                🚚
                                            </div>

                                            Cash on Delivery

                                        </div>

                                        <p class="payment-description mb-0">
                                            Pay after receiving your order at your delivery address.
                                        </p>


                                        <div class="cod-feature-grid">

                                            <div class="cod-feature">

                                                <strong>
                                                    💵 Pay on Delivery
                                                </strong>

                                                <span>
                                                    No online payment required.
                                                </span>

                                            </div>


                                            <div class="cod-feature">

                                                <strong>
                                                    📦 Easy Ordering
                                                </strong>

                                                <span>
                                                    Confirm your order instantly.
                                                </span>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- =================================================
                                         UPI DETAILS
                                    ================================================== -->

                                    <div
                                        class="payment-details"
                                        id="upiDetails"
                                        data-payment-details="UPI"
                                    >

                                        <div class="payment-title">

                                            <div class="payment-title-icon">
                                                📱
                                            </div>

                                            UPI Payment

                                        </div>


                                        <p class="payment-description">
                                            Pay quickly using your preferred UPI application.
                                        </p>


                                        <div class="payment-icons">

                                            <span class="payment-icon">
                                                Google Pay
                                            </span>

                                            <span class="payment-icon">
                                                PhonePe
                                            </span>

                                            <span class="payment-icon">
                                                Paytm
                                            </span>

                                            <span class="payment-icon">
                                                BHIM
                                            </span>

                                        </div>


                                        <label
                                            class="form-label"
                                            for="upiId"
                                        >
                                            UPI ID
                                        </label>


                                        <div class="upi-id-wrap">

                                            <input
                                                type="text"
                                                name="upi_id"
                                                id="upiId"
                                                class="form-control"
                                                placeholder="example@upi"
                                                autocomplete="off"
                                            >


                                            <button
                                                type="button"
                                                class="upi-copy-btn"
                                                id="copyUpiBtn"
                                            >
                                                📋 Copy
                                            </button>

                                        </div>


                                        @forelse($paymentSellers as $paymentSeller)

                                            @if($paymentSeller->payment_qr)

                                                <div class="qr-card">

                                                    <div class="qr-label">
                                                        🔐 SECURE SELLER PAYMENT
                                                    </div>


                                                    <div class="qr-pay-title">

                                                        Pay
                                                        {{ $paymentSeller->shop_name
                                                            ?: $paymentSeller->seller_name }}

                                                    </div>


                                                    <img
                                                       @php
    $paymentQrPath = ltrim($paymentSeller->payment_qr, '/');

    if (str_starts_with($paymentQrPath, 'storage/')) {
        $paymentQrPath = substr($paymentQrPath, strlen('storage/'));
    }

    $paymentQrUrl = \Illuminate\Support\Facades\Storage::disk('public')->url(
        $paymentQrPath
    );
@endphp

<img
    src="{{ $paymentQrUrl }}"
    alt="Seller Payment QR"
    loading="lazy"
>
                                                        alt="Seller Payment QR"
                                                    >


                                                    <div class="qr-pay-title">
                                                        Scan & Pay
                                                    </div>


                                                    <div class="qr-note">
                                                        Open your UPI application and scan this QR code.
                                                    </div>

                                                </div>

                                            @endif

                                        @empty

                                            <div class="payment-description mb-0">
                                                Seller payment QR is not available.
                                            </div>

                                        @endforelse

                                    </div>


                                    <!-- =================================================
                                         CARD DETAILS
                                    ================================================== -->

                                    <div
                                        class="payment-details"
                                        id="cardDetails"
                                        data-payment-details="Card"
                                    >

                                        <div class="card-visual">

                                            <div class="card-chip"></div>

                                            <div class="card-brand">
                                                SMART BASKET
                                            </div>


                                            <div
                                                class="card-number-preview"
                                                id="cardNumberPreview"
                                            >
                                                •••• •••• •••• ••••
                                            </div>


                                            <div class="card-bottom">

                                                <div>

                                                    <div class="card-preview-label">
                                                        Card Holder
                                                    </div>

                                                    <div
                                                        class="card-preview-value"
                                                        id="cardNamePreview"
                                                    >
                                                        YOUR NAME
                                                    </div>

                                                </div>


                                                <div>

                                                    <div class="card-preview-label">
                                                        Expiry
                                                    </div>

                                                    <div
                                                        class="card-preview-value"
                                                        id="cardExpiryPreview"
                                                    >
                                                        MM/YY
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="payment-title">
                                            💳 Card Payment
                                        </div>


                                        <p class="payment-description">
                                            Enter your card information securely.
                                        </p>


                                        <div class="mb-3">

                                            <label
                                                class="form-label"
                                                for="cardNumber"
                                            >
                                                Card Number
                                            </label>

                                            <input
                                                type="text"
                                                name="card_number"
                                                id="cardNumber"
                                                class="form-control"
                                                maxlength="19"
                                                inputmode="numeric"
                                                autocomplete="cc-number"
                                                placeholder="XXXX XXXX XXXX XXXX"
                                            >

                                        </div>


                                        <div class="row">

                                            <div class="col-6">

                                                <label
                                                    class="form-label"
                                                    for="cardExpiry"
                                                >
                                                    Expiry
                                                </label>

                                                <input
                                                    type="text"
                                                    name="card_expiry"
                                                    id="cardExpiry"
                                                    class="form-control"
                                                    maxlength="5"
                                                    inputmode="numeric"
                                                    autocomplete="cc-exp"
                                                    placeholder="MM/YY"
                                                >

                                            </div>


                                            <div class="col-6">

                                                <label
                                                    class="form-label"
                                                    for="cardCvv"
                                                >
                                                    CVV
                                                </label>

                                                <div class="cvv-wrap">

                                                    <input
                                                        type="password"
                                                        name="card_cvv"
                                                        id="cardCvv"
                                                        class="form-control"
                                                        maxlength="4"
                                                        inputmode="numeric"
                                                        autocomplete="cc-csc"
                                                        placeholder="CVV"
                                                    >


                                                    <button
                                                        type="button"
                                                        class="cvv-toggle"
                                                        id="cvvToggle"
                                                    >
                                                        👁️
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="step-actions">

                                    <button
                                        type="button"
                                        class="step-back-btn"
                                        data-back="2"
                                    >
                                        ← Back
                                    </button>

                                    <button
                                        type="button"
                                        class="step-next-btn"
                                        id="step3Next"
                                    >
                                        Continue to Review →
                                    </button>

                                </div>

                            </section>


                            <!-- =================================================
                                 STEP 4 — REVIEW
                            ================================================== -->

                            <section
                                class="checkout-step"
                                data-step="4"
                            >

                                <div class="step-heading">

                                    <div class="step-heading-icon">
                                        ✓
                                    </div>

                                    <div>

                                        <h2>
                                            Review Your Order
                                        </h2>

                                        <p>
                                            Everything looks good? Confirm your details and place the order.
                                        </p>

                                    </div>

                                </div>


                                <!-- CUSTOMER REVIEW -->

                                <div class="review-card">

                                    <div class="review-card-header">

                                        <div class="review-card-title">
                                            👤 Customer Details
                                        </div>

                                        <button
                                            type="button"
                                            class="review-edit"
                                            data-edit="1"
                                        >
                                            Edit
                                        </button>

                                    </div>


                                    <div
                                        class="review-value"
                                        id="reviewCustomer"
                                    >
                                        —
                                    </div>

                                </div>


                                <!-- ADDRESS REVIEW -->

                                <div class="review-card">

                                    <div class="review-card-header">

                                        <div class="review-card-title">
                                            📍 Delivery Address
                                        </div>

                                        <button
                                            type="button"
                                            class="review-edit"
                                            data-edit="2"
                                        >
                                            Edit
                                        </button>

                                    </div>


                                    <div
                                        class="review-value"
                                        id="reviewAddress"
                                    >
                                        —
                                    </div>

                                </div>


                                <!-- PAYMENT REVIEW -->

                                <div class="review-card">

                                    <div class="review-card-header">

                                        <div class="review-card-title">
                                            💳 Payment Method
                                        </div>

                                        <button
                                            type="button"
                                            class="review-edit"
                                            data-edit="3"
                                        >
                                            Edit
                                        </button>

                                    </div>


                                    <div class="review-payment">

                                        <div
                                            class="review-payment-icon"
                                            id="reviewPaymentIcon"
                                        >
                                            🚚
                                        </div>

                                        <div>

                                            <div
                                                class="review-value"
                                                id="reviewPayment"
                                            >
                                                Cash on Delivery
                                            </div>

                                            <div
                                                class="review-muted"
                                                style="font-size:9px;"
                                            >
                                                Selected payment option
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- TOTAL REVIEW -->

                                <div class="review-card">

                                    <div class="review-card-header">

                                        <div class="review-card-title">
                                            🧾 Order Total
                                        </div>

                                    </div>


                                    <div
                                        style="
                                            display:flex;
                                            justify-content:space-between;
                                            align-items:center;
                                        "
                                    >

                                        <span
                                            style="
                                                color:var(--sb-muted);
                                                font-size:11px;
                                            "
                                        >
                                            Final Payable Amount
                                        </span>


                                        <strong
                                            style="
                                                color:var(--sb-heading);
                                                font-size:20px;
                                            "
                                        >
                                            ₹{{ number_format((float)$checkoutTotal, 2) }}
                                        </strong>

                                    </div>

                                </div>


                                <div
                                    class="delivery-estimate"
                                    style="margin-top:15px;"
                                >

                                    <div class="delivery-estimate-icon">
                                        🛡️
                                    </div>

                                    <div>

                                        <div class="delivery-estimate-title">
                                            Ready to Place Order
                                        </div>

                                        <div class="delivery-estimate-text">
                                            Your details have been completed. Confirm below to place your order.
                                        </div>

                                    </div>

                                </div>


                                <div class="step-actions">

                                    <button
                                        type="button"
                                        class="step-back-btn"
                                        data-back="3"
                                    >
                                        ← Back
                                    </button>


                                    <button
                                        type="submit"
                                        class="final-confirm-btn"
                                        id="confirmBtn"
                                    >

                                        <span
                                            class="button-loader"
                                            id="buttonLoader"
                                        ></span>

                                        <span id="buttonText">
                                            🔒 Confirm & Place Order
                                        </span>

                                    </button>

                                </div>


                                <div class="payment-security"
                                     style="
                                         display:flex;
                                         justify-content:center;
                                         flex-wrap:wrap;
                                         gap:17px;
                                         margin-top:18px;
                                         color:var(--sb-muted);
                                         font-size:9px;
                                         font-weight:750;
                                     "
                                >

                                    <span>
                                        🔒 Secure
                                    </span>

                                    <span>
                                        🛡️ Protected
                                    </span>

                                    <span>
                                        ⚡ Fast Processing
                                    </span>

                                    <span>
                                        ✓ Verified Checkout
                                    </span>

                                </div>

                            </section>

                        </form>


                        <!-- CONTINUE SHOPPING -->

                        <a
                            href="{{ route('products.index') }}"
                            class="back-link"
                            style="
                                display:flex;
                                justify-content:center;
                                margin-top:19px;
                                color:var(--sb-muted);
                                text-decoration:none;
                                font-size:11px;
                                font-weight:800;
                            "
                        >
                            ← Continue Shopping
                        </a>

                    </div>


                    <!-- =================================================
                         RIGHT — ORDER SUMMARY
                    ================================================== -->

                    <aside
                        class="summary-card"
                        id="summaryCard"
                    >

                        <div class="summary-top">

                            <h2 class="summary-title">
                                Order Summary
                            </h2>

                            <span class="item-count">

                                {{ count($checkoutItems) }}

                                {{ count($checkoutItems) == 1 ? 'Item' : 'Items' }}

                            </span>

                        </div>


                        <div class="summary-items">

                            @foreach($checkoutItems as $item)

                                @php

                                    $product =
                                        $item['product']
                                        ?? $item->product
                                        ?? null;

                                    $quantity =
                                        $item['quantity']
                                        ?? $item->quantity
                                        ?? 1;

                                @endphp


                                @if($product)

                                    <div class="summary-item">

                                        <div class="summary-product">

                                            <div class="summary-product-name">
                                                {{ $product->name }}
                                            </div>

                                            <span class="summary-product-qty">
                                                Qty: {{ $quantity }}
                                            </span>

                                        </div>


                                        <div class="summary-price">

                                            ₹{{ number_format(
                                                (float)$product->price *
                                                (int)$quantity,
                                                2
                                            ) }}

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        </div>


                        <div class="summary-divider"></div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                ₹{{ number_format((float)$checkoutTotal, 2) }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Delivery
                            </span>

                            <strong style="color:var(--sb-success);">
                                FREE
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Platform Fee
                            </span>

                            <strong>
                                ₹0.00
                            </strong>

                        </div>


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <span class="summary-total-price">
                                ₹{{ number_format((float)$checkoutTotal, 2) }}
                            </span>

                        </div>


                        <div class="delivery-estimate">

                            <div class="delivery-estimate-icon">
                                🚚
                            </div>

                            <div>

                                <div class="delivery-estimate-title">
                                    Estimated Delivery
                                </div>

                                <div
                                    class="delivery-estimate-text"
                                    id="deliveryEstimate"
                                >
                                    Enter your PIN code to estimate delivery.
                                </div>

                            </div>

                        </div>


                        <div class="trust-grid">

                            <div class="trust-item">

                                <div class="trust-item-icon">
                                    🔒
                                </div>

                                <div class="trust-item-text">
                                    Secure
                                </div>

                            </div>


                            <div class="trust-item">

                                <div class="trust-item-icon">
                                    🛡️
                                </div>

                                <div class="trust-item-text">
                                    Protected
                                </div>

                            </div>


                            <div class="trust-item">

                                <div class="trust-item-icon">
                                    ⚡
                                </div>

                                <div class="trust-item-text">
                                    Fast
                                </div>

                            </div>

                        </div>

                    </aside>

                </div>


            @else

                <!-- =================================================
                     EMPTY CHECKOUT
                ================================================== -->

                <div class="checkout-grid">

                    <div class="checkout-card">

                        <div class="empty-checkout">

                            <div class="empty-icon">
                                🛒
                            </div>

                            <h3>
                                Your checkout is empty
                            </h3>

                            <p>
                                Please add a product before placing an order.
                            </p>


                            <a
                                href="{{ route('products.index') }}"
                                class="browse-btn"
                            >
                                🛍️ Browse Products
                            </a>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>


    <!-- =========================================================
         EXISTING SMART BASKET AI HUB
    ========================================================== -->

    <x-ai-hub-sidebar />


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>

        (function () {

            "use strict";


            /* =====================================================
               GLOBAL STEP STATE
            ===================================================== */

            let currentStep = 1;

            const totalSteps = 4;

            let mobileVerified = false;


            const steps =
                document.querySelectorAll(
                    ".checkout-step"
                );

            const progressSteps =
                document.querySelectorAll(
                    ".progress-step"
                );

            const progressLines =
                document.querySelectorAll(
                    ".progress-line"
                );


            /* =====================================================
               PROFILE MOBILE
            ===================================================== */

            const profileMobile =
                @json($profileMobile);


            function normalizeMobile(value) {

                return String(value || "")
                    .replace(/\D/g, "")
                    .replace(/^91/, "")
                    .replace(/^0/, "")
                    .slice(-10);

            }


            /* =====================================================
               ELEMENTS
            ===================================================== */

            const mobileInput =
                document.getElementById(
                    "customerMobile"
                );

            const verifyMobileBtn =
                document.getElementById(
                    "verifyMobileBtn"
                );

            const mobileStatus =
                document.getElementById(
                    "mobileStatus"
                );

            const step1Next =
                document.getElementById(
                    "step1Next"
                );

            const step2Next =
                document.getElementById(
                    "step2Next"
                );

            const step3Next =
                document.getElementById(
                    "step3Next"
                );


            /* =====================================================
               MOBILE STATUS
            ===================================================== */

            function showMobileStatus(
                type,
                message
            ) {

                if (!mobileStatus) {
                    return;
                }

                mobileStatus.className =
                    "mobile-status " + type;

                mobileStatus.innerHTML =
                    message;

            }


            function resetMobileVerification() {

                mobileVerified = false;

                if (step1Next) {
                    step1Next.disabled = true;
                }

                if (mobileInput) {
                    mobileInput.classList.remove(
                        "verified-input"
                    );
                }

                showMobileStatus(
                    "error",
                    "⚠️ Please verify your mobile number before continuing."
                );

            }


            /* =====================================================
               VERIFY MOBILE
            ===================================================== */

            if (verifyMobileBtn) {

                verifyMobileBtn.addEventListener(
                    "click",
                    function () {

                        const entered =
                            normalizeMobile(
                                mobileInput
                                    ? mobileInput.value
                                    : ""
                            );

                        const profile =
                            normalizeMobile(
                                profileMobile
                            );


                        if (!entered) {

                            mobileVerified = false;

                            if (step1Next) {
                                step1Next.disabled = true;
                            }

                            showMobileStatus(
                                "error",
                                "⚠️ Please enter your mobile number."
                            );

                            if (mobileInput) {
                                mobileInput.focus();
                            }

                            return;
                        }


                        if (entered.length !== 10) {

                            mobileVerified = false;

                            if (step1Next) {
                                step1Next.disabled = true;
                            }

                            showMobileStatus(
                                "error",
                                "⚠️ Please enter a valid 10-digit mobile number."
                            );

                            return;
                        }


                        if (!profile) {

                            mobileVerified = false;

                            if (step1Next) {
                                step1Next.disabled = true;
                            }

                            showMobileStatus(
                                "error",
                                "⚠️ No mobile number is saved in your profile. Please update your profile first."
                            );

                            return;
                        }


                        if (entered === profile) {

                            mobileVerified = true;

                            if (step1Next) {
                                step1Next.disabled = false;
                            }

                            if (mobileInput) {
                                mobileInput.classList.add(
                                    "verified-input"
                                );
                            }

                            showMobileStatus(
                                "success",
                                "✓ Mobile verified successfully. It matches the mobile number saved in your profile."
                            );

                        } else {

                            mobileVerified = false;

                            if (step1Next) {
                                step1Next.disabled = true;
                            }

                            if (mobileInput) {
                                mobileInput.classList.remove(
                                    "verified-input"
                                );
                            }

                            showMobileStatus(
                                "error",
                                "✕ Verification failed. The mobile number does not match your profile number."
                            );

                        }

                    }
                );

            }


            /* =====================================================
               MOBILE CHANGE = RESET VERIFICATION
            ===================================================== */

            if (mobileInput) {

                mobileInput.addEventListener(
                    "input",
                    function () {

                        this.value =
                            this.value
                                .replace(/[^\d+]/g, "")
                                .slice(0, 15);

                        mobileVerified = false;

                        if (step1Next) {
                            step1Next.disabled = true;
                        }

                        this.classList.remove(
                            "verified-input"
                        );

                        if (mobileStatus) {
                            mobileStatus.className =
                                "mobile-status";
                            mobileStatus.innerHTML = "";
                        }

                    }
                );

            }


            /* =====================================================
               PROGRESS UI
            ===================================================== */

            function updateProgress() {

                progressSteps.forEach(
                    function (stepElement) {

                        const number =
                            Number(
                                stepElement.dataset.progress
                            );

                        const circle =
                            stepElement.querySelector(
                                ".progress-circle"
                            );


                        stepElement.classList.remove(
                            "active",
                            "completed"
                        );


                        if (number < currentStep) {

                            stepElement.classList.add(
                                "completed"
                            );

                            if (circle) {
                                circle.textContent = "✓";
                            }

                        }
                        else if (
                            number === currentStep
                        ) {

                            stepElement.classList.add(
                                "active"
                            );

                            if (circle) {
                                circle.textContent =
                                    String(number);
                            }

                        }
                        else {

                            if (circle) {
                                circle.textContent =
                                    String(number);
                            }

                        }

                    }
                );


                progressLines.forEach(
                    function (lineElement) {

                        const lineNumber =
                            Number(
                                lineElement.dataset.line
                            );

                        if (
                            lineNumber <
                            currentStep
                        ) {

                            lineElement.classList.add(
                                "completed"
                            );

                        } else {

                            lineElement.classList.remove(
                                "completed"
                            );

                        }

                    }
                );

            }


            /* =====================================================
               SHOW STEP
            ===================================================== */

            function showStep(stepNumber) {

                if (
                    stepNumber < 1 ||
                    stepNumber > totalSteps
                ) {
                    return;
                }


                currentStep =
                    stepNumber;


                steps.forEach(
                    function (stepElement) {

                        const number =
                            Number(
                                stepElement.dataset.step
                            );

                        stepElement.classList.toggle(
                            "active",
                            number === currentStep
                        );

                    }
                );


                updateProgress();


                if (currentStep === 4) {
                    updateReview();
                }


                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });

            }


            /* =====================================================
               VALIDATION HELPERS
            ===================================================== */

            function validateField(
                element
            ) {

                if (!element) {
                    return false;
                }

                const value =
                    element.value.trim();


                if (!value) {

                    element.focus();

                    element.reportValidity?.();

                    return false;
                }


                return true;

            }


            /* =====================================================
               STEP 1 VALIDATION
            ===================================================== */

            function validateStep1() {

                const name =
                    document.getElementById(
                        "customerName"
                    );


                if (!validateField(name)) {

                    alert(
                        "Please enter your full name."
                    );

                    return false;
                }


                if (!mobileVerified) {

                    alert(
                        "Please verify your mobile number before continuing."
                    );

                    return false;
                }


                return true;

            }


            /* =====================================================
               STEP 2 VALIDATION
            ===================================================== */

            function validateStep2() {

                const address =
                    document.getElementById(
                        "customerAddress"
                    );

                const city =
                    document.getElementById(
                        "customerCity"
                    );

                const pin =
                    document.getElementById(
                        "customerPin"
                    );


                if (!validateField(address)) {

                    alert(
                        "Please enter your delivery address."
                    );

                    return false;
                }


                if (!validateField(city)) {

                    alert(
                        "Please enter your city."
                    );

                    return false;
                }


                if (!validateField(pin)) {

                    alert(
                        "Please enter your PIN code."
                    );

                    return false;
                }


                if (!/^\d{6}$/.test(pin.value)) {

                    alert(
                        "Please enter a valid 6-digit PIN code."
                    );

                    pin.focus();

                    return false;
                }


                return true;

            }


            /* =====================================================
               STEP 3 VALIDATION
            ===================================================== */

            function getSelectedPayment() {

                const selected =
                    document.querySelector(
                        'input[name="payment_method"]:checked'
                    );

                return selected
                    ? selected.value
                    : "COD";

            }


            function validateStep3() {

                const method =
                    getSelectedPayment();


                if (method === "UPI") {

                    const upi =
                        document.getElementById(
                            "upiId"
                        );


                    if (!upi || !upi.value.trim()) {

                        alert(
                            "Please enter your UPI ID."
                        );

                        if (upi) {
                            upi.focus();
                        }

                        return false;
                    }


                    const upiPattern =
                        /^[\w.\-]{2,}@[A-Za-z]{2,}$/;


                    if (
                        !upiPattern.test(
                            upi.value.trim()
                        )
                    ) {

                        alert(
                            "Please enter a valid UPI ID, for example example@upi."
                        );

                        upi.focus();

                        return false;
                    }

                }


                if (method === "Card") {

                    const number =
                        document.getElementById(
                            "cardNumber"
                        );

                    const expiry =
                        document.getElementById(
                            "cardExpiry"
                        );

                    const cvv =
                        document.getElementById(
                            "cardCvv"
                        );


                    const cleanNumber =
                        number
                            ? number.value.replace(/\D/g, "")
                            : "";


                    if (
                        cleanNumber.length < 13 ||
                        cleanNumber.length > 19
                    ) {

                        alert(
                            "Please enter a valid card number."
                        );

                        if (number) {
                            number.focus();
                        }

                        return false;
                    }


                    if (
                        !expiry ||
                        !/^\d{2}\/\d{2}$/.test(
                            expiry.value
                        )
                    ) {

                        alert(
                            "Please enter card expiry in MM/YY format."
                        );

                        if (expiry) {
                            expiry.focus();
                        }

                        return false;
                    }


                    if (
                        !cvv ||
                        !/^\d{3,4}$/.test(
                            cvv.value
                        )
                    ) {

                        alert(
                            "Please enter a valid CVV."
                        );

                        if (cvv) {
                            cvv.focus();
                        }

                        return false;
                    }

                }


                return true;

            }


            /* =====================================================
               STEP 1 NEXT
            ===================================================== */

            if (step1Next) {

                step1Next.addEventListener(
                    "click",
                    function () {

                        if (
                            validateStep1()
                        ) {

                            showStep(2);

                        }

                    }
                );

            }


            /* =====================================================
               STEP 2 NEXT
            ===================================================== */

            if (step2Next) {

                step2Next.addEventListener(
                    "click",
                    function () {

                        if (
                            validateStep2()
                        ) {

                            showStep(3);

                        }

                    }
                );

            }


            /* =====================================================
               STEP 3 NEXT
            ===================================================== */

            if (step3Next) {

                step3Next.addEventListener(
                    "click",
                    function () {

                        if (
                            validateStep3()
                        ) {

                            showStep(4);

                        }

                    }
                );

            }


            /* =====================================================
               BACK BUTTONS
            ===================================================== */

            document.querySelectorAll(
                "[data-back]"
            ).forEach(
                function (button) {

                    button.addEventListener(
                        "click",
                        function () {

                            const target =
                                Number(
                                    this.dataset.back
                                );

                            showStep(target);

                        }
                    );

                }
            );


            /* =====================================================
               EDIT BUTTONS
            ===================================================== */

            document.querySelectorAll(
                "[data-edit]"
            ).forEach(
                function (button) {

                    button.addEventListener(
                        "click",
                        function () {

                            const target =
                                Number(
                                    this.dataset.edit
                                );

                            showStep(target);

                        }
                    );

                }
            );


            /* =====================================================
               PAYMENT SWITCHER
            ===================================================== */

            const paymentOptions =
                document.querySelectorAll(
                    ".payment-option"
                );

            const paymentDetails =
                document.querySelectorAll(
                    ".payment-details"
                );


            function updatePaymentUI() {

                const method =
                    getSelectedPayment();


                paymentOptions.forEach(
                    function (option) {

                        option.classList.toggle(
                            "selected",
                            option.dataset.paymentOption ===
                                method
                        );

                    }
                );


                paymentDetails.forEach(
                    function (box) {

                        box.classList.toggle(
                            "active",
                            box.dataset.paymentDetails ===
                                method
                        );

                    }
                );

            }


            paymentOptions.forEach(
                function (option) {

                    option.addEventListener(
                        "click",
                        function () {

                            const radio =
                                this.querySelector(
                                    'input[type="radio"]'
                                );

                            if (radio) {
                                radio.checked = true;
                            }

                            updatePaymentUI();

                        }
                    );

                }
            );


            updatePaymentUI();


            /* =====================================================
               CARD NUMBER
            ===================================================== */

            const cardNumber =
                document.getElementById(
                    "cardNumber"
                );

            const cardNumberPreview =
                document.getElementById(
                    "cardNumberPreview"
                );


            if (cardNumber) {

                cardNumber.addEventListener(
                    "input",
                    function () {

                        let value =
                            this.value
                                .replace(/\D/g, "")
                                .substring(0, 19);


                        const formatted =
                            value
                                .match(/.{1,4}/g)
                                ?.join(" ")
                                || "";


                        this.value =
                            formatted;


                        if (cardNumberPreview) {

                            if (!value) {

                                cardNumberPreview.textContent =
                                    "•••• •••• •••• ••••";

                            }
                            else {

                                const groups =
                                    formatted.split(" ");

                                cardNumberPreview.textContent =
                                    groups
                                        .map(
                                            function (
                                                part,
                                                index
                                            ) {

                                                if (
                                                    index <
                                                    groups.length - 1
                                                ) {
                                                    return "••••";
                                                }

                                                return part.padEnd(
                                                    4,
                                                    "•"
                                                );

                                            }
                                        )
                                        .join(" ");

                            }

                        }

                    }
                );

            }


            /* =====================================================
               CARD EXPIRY
            ===================================================== */

            const cardExpiry =
                document.getElementById(
                    "cardExpiry"
                );

            const cardExpiryPreview =
                document.getElementById(
                    "cardExpiryPreview"
                );


            if (cardExpiry) {

                cardExpiry.addEventListener(
                    "input",
                    function () {

                        let value =
                            this.value
                                .replace(/\D/g, "")
                                .substring(0, 4);


                        if (value.length >= 3) {

                            value =
                                value.substring(0, 2)
                                + "/"
                                + value.substring(2);

                        }


                        this.value =
                            value;


                        if (cardExpiryPreview) {

                            cardExpiryPreview.textContent =
                                value || "MM/YY";

                        }

                    }
                );

            }


            /* =====================================================
               CARD HOLDER
            ===================================================== */

            const customerName =
                document.getElementById(
                    "customerName"
                );

            const cardNamePreview =
                document.getElementById(
                    "cardNamePreview"
                );


            function updateCardName() {

                if (
                    !customerName ||
                    !cardNamePreview
                ) {
                    return;
                }


                const value =
                    customerName.value.trim();


                cardNamePreview.textContent =
                    value
                        ? value
                            .substring(0, 22)
                            .toUpperCase()
                        : "YOUR NAME";

            }


            if (customerName) {

                customerName.addEventListener(
                    "input",
                    updateCardName
                );

                updateCardName();

            }


            /* =====================================================
               CVV SHOW / HIDE
            ===================================================== */

            const cardCvv =
                document.getElementById(
                    "cardCvv"
                );

            const cvvToggle =
                document.getElementById(
                    "cvvToggle"
                );


            if (
                cardCvv &&
                cvvToggle
            ) {

                cvvToggle.addEventListener(
                    "click",
                    function () {

                        if (
                            cardCvv.type ===
                            "password"
                        ) {

                            cardCvv.type =
                                "text";

                            cvvToggle.textContent =
                                "🙈";

                        }
                        else {

                            cardCvv.type =
                                "password";

                            cvvToggle.textContent =
                                "👁️";

                        }

                    }
                );

            }


            /* =====================================================
               UPI COPY
            ===================================================== */

            const upiInput =
                document.getElementById(
                    "upiId"
                );

            const copyUpiBtn =
                document.getElementById(
                    "copyUpiBtn"
                );


            if (
                upiInput &&
                copyUpiBtn
            ) {

                copyUpiBtn.addEventListener(
                    "click",
                    async function () {

                        const value =
                            upiInput.value.trim();


                        if (!value) {

                            upiInput.focus();

                            return;

                        }


                        try {

                            await navigator.clipboard.writeText(
                                value
                            );


                            const original =
                                copyUpiBtn.textContent;


                            copyUpiBtn.textContent =
                                "✓ Copied";


                            setTimeout(
                                function () {

                                    copyUpiBtn.textContent =
                                        original;

                                },
                                1500
                            );

                        }
                        catch (error) {

                            upiInput.select();

                            document.execCommand(
                                "copy"
                            );

                        }

                    }
                );

            }


            /* =====================================================
               PIN CODE
            ===================================================== */

            const pin =
                document.getElementById(
                    "customerPin"
                );

            const estimate =
                document.getElementById(
                    "deliveryEstimate"
                );


            if (pin) {

                pin.addEventListener(
                    "input",
                    function () {

                        this.value =
                            this.value
                                .replace(/\D/g, "")
                                .substring(0, 6);


                        if (
                            estimate &&
                            this.value.length === 6
                        ) {

                            estimate.textContent =
                                "Delivery available for your PIN code.";

                        }
                        else if (estimate) {

                            estimate.textContent =
                                "Enter your PIN code to estimate delivery.";

                        }

                    }
                );

            }


            /* =====================================================
               REVIEW
            ===================================================== */

            function updateReview() {

                const name =
                    document.getElementById(
                        "customerName"
                    )?.value.trim()
                    || "—";


                const mobile =
                    document.getElementById(
                        "customerMobile"
                    )?.value.trim()
                    || "—";


                const address =
                    document.getElementById(
                        "customerAddress"
                    )?.value.trim()
                    || "—";


                const city =
                    document.getElementById(
                        "customerCity"
                    )?.value.trim()
                    || "—";


                const pinCode =
                    document.getElementById(
                        "customerPin"
                    )?.value.trim()
                    || "—";


                const payment =
                    getSelectedPayment();


                const reviewCustomer =
                    document.getElementById(
                        "reviewCustomer"
                    );


                const reviewAddress =
                    document.getElementById(
                        "reviewAddress"
                    );


                const reviewPayment =
                    document.getElementById(
                        "reviewPayment"
                    );


                const reviewPaymentIcon =
                    document.getElementById(
                        "reviewPaymentIcon"
                    );


                if (reviewCustomer) {

                    reviewCustomer.innerHTML =
                        "<strong>" +
                        escapeHtml(name) +
                        "</strong>" +
                        "<br>" +
                        "📱 " +
                        escapeHtml(mobile) +
                        " " +
                        (
                            mobileVerified
                                ? "✓ Verified"
                                : ""
                        );

                }


                if (reviewAddress) {

                    reviewAddress.innerHTML =
                        escapeHtml(address) +
                        "<br>" +
                        escapeHtml(city) +
                        " - " +
                        escapeHtml(pinCode);

                }


                if (reviewPayment) {

                    if (payment === "UPI") {

                        reviewPayment.textContent =
                            "UPI Payment";

                    }
                    else if (
                        payment === "Card"
                    ) {

                        reviewPayment.textContent =
                            "Card Payment";

                    }
                    else {

                        reviewPayment.textContent =
                            "Cash on Delivery";

                    }

                }


                if (reviewPaymentIcon) {

                    if (payment === "UPI") {

                        reviewPaymentIcon.textContent =
                            "📱";

                    }
                    else if (
                        payment === "Card"
                    ) {

                        reviewPaymentIcon.textContent =
                            "💳";

                    }
                    else {

                        reviewPaymentIcon.textContent =
                            "🚚";

                    }

                }

            }


            /* =====================================================
               HTML ESCAPE
            ===================================================== */

            function escapeHtml(value) {

                return String(value)
                    .replace(
                        /&/g,
                        "&amp;"
                    )
                    .replace(
                        /</g,
                        "&lt;"
                    )
                    .replace(
                        />/g,
                        "&gt;"
                    )
                    .replace(
                        /"/g,
                        "&quot;"
                    )
                    .replace(
                        /'/g,
                        "&#039;"
                    );

            }


            /* =====================================================
               FORM SUBMIT
            ===================================================== */

            const form =
                document.getElementById(
                    "checkoutForm"
                );

            const confirmBtn =
                document.getElementById(
                    "confirmBtn"
                );

            const buttonText =
                document.getElementById(
                    "buttonText"
                );


            if (
                form &&
                confirmBtn
            ) {

                form.addEventListener(
                    "submit",
                    function (event) {

                        /*
                        -------------------------------------------------
                        Final security checks
                        -------------------------------------------------
                        */

                        if (!mobileVerified) {

                            event.preventDefault();

                            showStep(1);

                            alert(
                                "Please verify your profile mobile number before placing the order."
                            );

                            return;
                        }


                        if (
                            !validateStep1()
                        ) {

                            event.preventDefault();

                            showStep(1);

                            return;
                        }


                        if (
                            !validateStep2()
                        ) {

                            event.preventDefault();

                            showStep(2);

                            return;
                        }


                        if (
                            !validateStep3()
                        ) {

                            event.preventDefault();

                            showStep(3);

                            return;
                        }


                        /*
                        -------------------------------------------------
                        Loading state
                        -------------------------------------------------
                        */

                        confirmBtn.classList.add(
                            "loading"
                        );

                        confirmBtn.disabled =
                            true;


                        if (buttonText) {

                            buttonText.textContent =
                                "Processing your order...";

                        }

                    }
                );

            }


            /* =====================================================
               DELIVERY AUTO SAVE
            ===================================================== */

            const deliveryFields = [
                "customerName",
                "customerMobile",
                "customerAddress",
                "customerCity",
                "customerPin"
            ];


            deliveryFields.forEach(
                function (id) {

                    const field =
                        document.getElementById(
                            id
                        );


                    if (!field) {
                        return;
                    }


                    const storageKey =
                        "smartbasket_checkout_" +
                        id;


                    const serverValue =
                        field.value.trim();


                    /*
                    -------------------------------------------------
                    Only restore delivery information.
                    Payment/card/CVV is NEVER restored.
                    -------------------------------------------------
                    */

                    if (!serverValue) {

                        const saved =
                            sessionStorage.getItem(
                                storageKey
                            );


                        if (saved) {

                            field.value =
                                saved;

                        }

                    }


                    field.addEventListener(
                        "input",
                        function () {

                            sessionStorage.setItem(
                                storageKey,
                                this.value
                            );

                        }
                    );

                }
            );


            /* =====================================================
               MOBILE SUMMARY
            ===================================================== */

            const mobileSummaryToggle =
                document.getElementById(
                    "mobileSummaryToggle"
                );


            const summaryCard =
                document.getElementById(
                    "summaryCard"
                );


            if (
                mobileSummaryToggle &&
                summaryCard
            ) {

                mobileSummaryToggle.addEventListener(
                    "click",
                    function () {

                        summaryCard.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });

                    }
                );

            }


            /* =====================================================
               THEME SYSTEM
            ===================================================== */

            const body =
                document.body;


            const savedTheme =
                body.dataset.customerTheme
                || "system";


            function getSystemTheme() {

                return window.matchMedia(
                    "(prefers-color-scheme: dark)"
                ).matches
                    ? "dark"
                    : "light";

            }


            function applyTheme(theme) {

                const finalTheme =
                    theme === "system"
                        ? getSystemTheme()
                        : theme;


                document.documentElement
                    .setAttribute(
                        "data-sb-theme",
                        finalTheme
                    );


                body.setAttribute(
                    "data-sb-theme",
                    finalTheme
                );

            }


            applyTheme(
                savedTheme
            );


            const media =
                window.matchMedia(
                    "(prefers-color-scheme: dark)"
                );


            function systemThemeChanged() {

                if (
                    body.dataset.customerTheme ===
                    "system"
                ) {

                    applyTheme(
                        "system"
                    );

                }

            }


            if (
                media.addEventListener
            ) {

                media.addEventListener(
                    "change",
                    systemThemeChanged
                );

            }
            else if (
                media.addListener
            ) {

                media.addListener(
                    systemThemeChanged
                );

            }


            /* =====================================================
               INITIAL STATE
            ===================================================== */

            updateProgress();

            updateCardName();

        })();

    </script>

</body>
</html>
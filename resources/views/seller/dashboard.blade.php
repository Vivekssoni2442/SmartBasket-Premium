<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Seller Dashboard | SmartBasket</title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        /* =========================================================
           SMARTBASKET SELLER DASHBOARD
           PREMIUM FULL-WIDTH DESIGN
           COMMON TASKBAR IS UNTOUCHED
           ========================================================= */

        :root {

            --sb-primary: #4f46e5;
            --sb-primary-dark: #3730a3;
            --sb-purple: #7c3aed;
            --sb-blue: #2563eb;

            --sb-success: #16a34a;
            --sb-warning: #d97706;
            --sb-danger: #dc2626;

            --sb-bg: #f4f7fb;
            --sb-card: #ffffff;
            --sb-card-soft: #f8fafc;

            --sb-border: rgba(15, 23, 42, .08);

            --sb-text: #101828;
            --sb-muted: #667085;
            --sb-soft: #98a2b3;

            --sb-shadow:
                0 10px 35px rgba(15, 23, 42, .055);

            --sb-shadow-hover:
                0 22px 55px rgba(15, 23, 42, .11);

        }


        /* =========================================================
           PAGE
           ========================================================= */

        .sb-dashboard-page {

            width: 100%;

            min-height: calc(100vh - 1px);

            margin: 0;

            padding: 0;

            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 8% 0%,
                    rgba(79,70,229,.055),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 15%,
                    rgba(124,58,237,.045),
                    transparent 25%
                ),
                var(--sb-bg);

            color: var(--sb-text);

        }


        .sb-dashboard-page *,
        .sb-dashboard-page *::before,
        .sb-dashboard-page *::after {

            box-sizing: border-box;

        }


        .sb-dashboard {

            width: 100%;

            max-width: none;

            margin: 0;

            padding:
                22px
                clamp(18px, 2.3vw, 42px)
                55px;

        }


        /* =========================================================
           COMMAND BAR
           ========================================================= */

        .sb-commandbar {

            position: relative;

            width: 100%;

            min-height: 78px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 18px;

            padding:
                14px 18px;

            border:
                1px solid
                rgba(15,23,42,.075);

            border-radius: 20px;

            background:
                rgba(255,255,255,.92);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            box-shadow:
                var(--sb-shadow);

        }


        .sb-commandbar::after {

            content: "";

            position: absolute;

            inset: 0;

            pointer-events: none;

            border-radius: inherit;

            background:
                linear-gradient(
                    110deg,
                    rgba(79,70,229,.025),
                    transparent 40%,
                    rgba(124,58,237,.025)
                );

        }


        .sb-command-left {

            position: relative;

            z-index: 1;

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 13px;

        }


        .sb-brand-mark {

            width: 50px;

            height: 50px;

            min-width: 50px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #4338ca,
                    #7c3aed
                );

            box-shadow:
                0 12px 28px
                rgba(79,70,229,.25);

            font-size: 17px;

        }


        .sb-command-copy {

            min-width: 0;

        }


        .sb-eyebrow {

            display: flex;

            align-items: center;

            gap: 6px;

            margin-bottom: 2px;

            color: var(--sb-primary);

            font-size: 9px;

            font-weight: 900;

            letter-spacing: .12em;

            text-transform: uppercase;

        }


        .sb-command-title {

            max-width: 550px;

            margin: 0;

            overflow: hidden;

            color: var(--sb-text);

            font-size: clamp(19px, 1.55vw, 24px);

            line-height: 1.15;

            font-weight: 950;

            letter-spacing: -.025em;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-command-subtitle {

            margin: 3px 0 0;

            color: var(--sb-muted);

            font-size: 10px;

            font-weight: 550;

        }


        .sb-command-right {

            position: relative;

            z-index: 1;

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 9px;

        }


        .sb-account-status {

            min-height: 38px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding:
                0 13px;

            border:
                1px solid
                var(--sb-border);

            border-radius: 11px;

            color: var(--sb-muted);

            background:
                rgba(248,250,252,.9);

            font-size: 9px;

            font-weight: 850;

            white-space: nowrap;

        }


        .sb-account-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: var(--sb-warning);

            box-shadow:
                0 0 0 4px
                rgba(217,119,6,.09);

        }


        .sb-account-status.active {

            color: var(--sb-success);

            border-color:
                rgba(22,163,74,.15);

            background:
                rgba(22,163,74,.055);

        }


        .sb-account-status.active .sb-account-dot {

            background: var(--sb-success);

            box-shadow:
                0 0 0 4px
                rgba(22,163,74,.09);

        }


        .sb-account-status.danger {

            color: var(--sb-danger);

            border-color:
                rgba(220,38,38,.15);

            background:
                rgba(220,38,38,.055);

        }


        .sb-account-status.danger .sb-account-dot {

            background: var(--sb-danger);

            box-shadow:
                0 0 0 4px
                rgba(220,38,38,.09);

        }


        .sb-account-status.review {

            color: var(--sb-primary);

            border-color:
                rgba(79,70,229,.15);

            background:
                rgba(79,70,229,.055);

        }


        .sb-account-status.review .sb-account-dot {

            background: var(--sb-primary);

            box-shadow:
                0 0 0 4px
                rgba(79,70,229,.09);

        }


        /* =========================================================
           HERO
           ========================================================= */

        .sb-hero {

            position: relative;

            width: 100%;

            min-height: 265px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 35px;

            margin-bottom: 24px;

            padding:
                clamp(28px, 4vw, 48px);

            overflow: hidden;

            border-radius: 27px;

            color: #fff;

            background:
                linear-gradient(
                    115deg,
                    #1e1b4b 0%,
                    #3730a3 28%,
                    #4f46e5 58%,
                    #7c3aed 100%
                );

            box-shadow:
                0 25px 65px
                rgba(79,70,229,.20);

        }


        .sb-hero::before {

            content: "";

            position: absolute;

            width: 480px;

            height: 480px;

            top: -300px;

            right: 5%;

            border-radius: 50%;

            background:
                rgba(255,255,255,.075);

        }


        .sb-hero::after {

            content: "";

            position: absolute;

            width: 330px;

            height: 330px;

            right: -130px;

            bottom: -170px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.07);

        }


        .sb-hero-copy {

            position: relative;

            z-index: 2;

            max-width: 760px;

        }


        .sb-hero-label {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 14px;

            padding:
                7px 11px;

            border:
                1px solid
                rgba(255,255,255,.16);

            border-radius: 999px;

            color:
                rgba(255,255,255,.92);

            background:
                rgba(255,255,255,.09);

            backdrop-filter:
                blur(10px);

            font-size: 9px;

            font-weight: 850;

            letter-spacing: .03em;

        }


        .sb-hero-title {

            margin: 0;

            font-size:
                clamp(31px, 4vw, 50px);

            line-height: 1.03;

            font-weight: 950;

            letter-spacing: -.045em;

        }


        .sb-hero-text {

            max-width: 670px;

            margin:
                15px 0 0;

            color:
                rgba(255,255,255,.74);

            font-size: 12px;

            line-height: 1.7;

        }


        .sb-hero-actions {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 9px;

            flex-wrap: wrap;

        }


        .sb-primary-btn,
        .sb-secondary-btn {

            min-height: 44px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding:
                0 16px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 9px;

            font-weight: 900;

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease;

        }


        .sb-primary-btn {

            color: #312e81;

            background: #fff;

            box-shadow:
                0 12px 28px
                rgba(0,0,0,.16);

        }


        .sb-secondary-btn {

            color: #fff;

            border:
                1px solid
                rgba(255,255,255,.18);

            background:
                rgba(255,255,255,.10);

            backdrop-filter:
                blur(12px);

        }


        .sb-primary-btn:hover {

            color: #312e81;

            transform:
                translateY(-2px);

            box-shadow:
                0 15px 32px
                rgba(0,0,0,.20);

        }


        .sb-secondary-btn:hover {

            color: #fff;

            transform:
                translateY(-2px);

            background:
                rgba(255,255,255,.16);

        }


        /* =========================================================
           SECTION HEADINGS
           ========================================================= */

        .sb-section-heading {

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 13px;

        }


        .sb-section-kicker {

            margin-bottom: 4px;

            color: var(--sb-primary);

            font-size: 8px;

            font-weight: 950;

            letter-spacing: .13em;

            text-transform: uppercase;

        }


        .sb-section-title {

            margin: 0;

            color: var(--sb-text);

            font-size: 17px;

            line-height: 1.2;

            font-weight: 950;

            letter-spacing: -.02em;

        }


        .sb-section-description {

            margin:
                5px 0 0;

            color: var(--sb-muted);

            font-size: 9px;

            line-height: 1.5;

        }


        /* =========================================================
           STATS
           ========================================================= */

        .sb-stats {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 13px;

            margin-bottom: 24px;

        }


        .sb-stat {

            position: relative;

            min-width: 0;

            overflow: hidden;

            padding: 18px;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 17px;

            background:
                rgba(255,255,255,.94);

            box-shadow:
                var(--sb-shadow);

            transition:
                transform .22s ease,
                box-shadow .22s ease;

        }


        .sb-stat::after {

            content: "";

            position: absolute;

            width: 90px;

            height: 90px;

            right: -35px;

            bottom: -45px;

            border-radius: 50%;

            background:
                rgba(79,70,229,.035);

        }


        .sb-stat:hover {

            transform:
                translateY(-4px);

            box-shadow:
                var(--sb-shadow-hover);

        }


        .sb-stat-top {

            position: relative;

            z-index: 1;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 8px;

        }


        .sb-stat-icon {

            width: 41px;

            height: 41px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            color: var(--sb-primary);

            background:
                linear-gradient(
                    135deg,
                    rgba(79,70,229,.11),
                    rgba(124,58,237,.07)
                );

            font-size: 14px;

        }


        .sb-stat-live {

            padding:
                5px 7px;

            border-radius: 7px;

            color: var(--sb-success);

            background:
                rgba(22,163,74,.06);

            font-size: 7px;

            font-weight: 900;

        }


        .sb-stat-number {

            position: relative;

            z-index: 1;

            margin-top: 17px;

            color: var(--sb-text);

            font-size:
                clamp(22px, 2vw, 28px);

            line-height: 1;

            font-weight: 950;

            letter-spacing: -.035em;

        }


        .sb-stat-label {

            position: relative;

            z-index: 1;

            margin-top: 7px;

            color: var(--sb-muted);

            font-size: 9px;

            font-weight: 650;

        }


        /* =========================================================
           MAIN GRID
           ========================================================= */

        .sb-main-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1.22fr)
                minmax(340px, .78fr);

            gap: 15px;

            margin-bottom: 18px;

        }


        .sb-panel {

            min-width: 0;

            padding: 20px;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 18px;

            background:
                rgba(255,255,255,.94);

            box-shadow:
                var(--sb-shadow);

        }


        /* =========================================================
           QUICK ACTIONS
           ========================================================= */

        .sb-actions {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 10px;

        }


        .sb-action {

            min-width: 0;

            min-height: 76px;

            display: flex;

            align-items: center;

            gap: 11px;

            padding: 11px;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 13px;

            color: var(--sb-text);

            background:
                linear-gradient(
                    145deg,
                    #fbfcfe,
                    #f7f9fc
                );

            text-decoration: none;

            transition:
                transform .2s ease,
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;

        }


        .sb-action:hover {

            color: var(--sb-text);

            border-color:
                rgba(79,70,229,.18);

            background: #fff;

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 25px
                rgba(15,23,42,.06);

        }


        .sb-action-icon {

            width: 39px;

            height: 39px;

            min-width: 39px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.08);

            font-size: 12px;

        }


        .sb-action-content {

            min-width: 0;

            flex: 1;

        }


        .sb-action-title {

            display: block;

            overflow: hidden;

            color: var(--sb-text);

            font-size: 9px;

            font-weight: 900;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-action-text {

            display: block;

            margin-top: 3px;

            color: var(--sb-muted);

            font-size: 7.5px;

            line-height: 1.45;

        }


        .sb-action-arrow {

            color: var(--sb-soft);

            font-size: 8px;

        }


        /* =========================================================
           STORE HEALTH
           ========================================================= */

        .sb-health-list {

            display: flex;

            flex-direction: column;

            gap: 6px;

        }


        .sb-health-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            min-height: 51px;

            padding:
                7px 9px;

            border:
                1px solid
                rgba(15,23,42,.045);

            border-radius: 11px;

            background:
                #f8fafc;

        }


        .sb-health-left {

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 9px;

        }


        .sb-health-icon {

            width: 32px;

            height: 32px;

            min-width: 32px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.075);

            font-size: 10px;

        }


        .sb-health-name {

            overflow: hidden;

            color: var(--sb-text);

            font-size: 8.5px;

            font-weight: 900;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-health-desc {

            margin-top: 2px;

            color: var(--sb-muted);

            font-size: 7.5px;

        }


        .sb-health-value {

            font-size: 11px;

            font-weight: 950;

        }


        .sb-health-value.success {

            color: var(--sb-success);

        }


        .sb-health-value.warning {

            color: var(--sb-warning);

        }


        .sb-health-value.danger {

            color: var(--sb-danger);

        }


        /* =========================================================
           VERIFICATION / ALERT
           ========================================================= */

        .sb-verification {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 18px;

            padding:
                14px 17px;

            border:
                1px solid
                rgba(79,70,229,.11);

            border-radius: 15px;

            background:
                rgba(255,255,255,.95);

            box-shadow:
                var(--sb-shadow);

        }


        .sb-verification-main {

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 11px;

        }


        .sb-verification-icon {

            width: 39px;

            height: 39px;

            min-width: 39px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.08);

            font-size: 13px;

        }


        .sb-verification-title {

            margin: 0;

            color: var(--sb-text);

            font-size: 10px;

            font-weight: 950;

        }


        .sb-verification-text {

            max-width: 700px;

            margin:
                4px 0 0;

            color: var(--sb-muted);

            font-size: 8px;

            line-height: 1.55;

        }


        .sb-verification-controls {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 7px;

            flex-wrap: wrap;

        }


        .sb-verification-status {

            min-height: 30px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding:
                0 9px;

            border-radius: 8px;

            font-size: 8px;

            font-weight: 900;

            white-space: nowrap;

        }


        .sb-verification-status.active {

            color: var(--sb-success);

            background:
                rgba(22,163,74,.07);

        }


        .sb-verification-status.danger {

            color: var(--sb-danger);

            background:
                rgba(220,38,38,.07);

        }


        .sb-verification-status.review {

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.07);

        }


        .sb-verification-status.pending {

            color: var(--sb-warning);

            background:
                rgba(217,119,6,.07);

        }


        .sb-verification-action {

            min-height: 30px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding:
                0 10px;

            border: 0;

            border-radius: 8px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.075);

            text-decoration: none;

            font-size: 8px;

            font-weight: 900;

            white-space: nowrap;

            transition:
                background .2s ease,
                transform .2s ease;

        }


        .sb-verification-action:hover {

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.13);

            transform:
                translateY(-1px);

        }


        /* =========================================================
           PRODUCTS
           ========================================================= */

        .sb-products-wrap {

            width: 100%;

            margin-bottom: 18px;

            padding: 20px;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 18px;

            background:
                rgba(255,255,255,.95);

            box-shadow:
                var(--sb-shadow);

        }


        .sb-products-head {

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 15px;

        }


        .sb-products-head-right {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 7px;

            flex-wrap: wrap;

        }


        .sb-view-all,
        .sb-add-product {

            min-height: 33px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding:
                0 10px;

            border-radius: 9px;

            text-decoration: none;

            font-size: 8px;

            font-weight: 900;

            transition:
                transform .2s ease,
                box-shadow .2s ease;

        }


        .sb-view-all {

            color: var(--sb-muted);

            border:
                1px solid
                rgba(15,23,42,.07);

            background:
                #f8fafc;

        }


        .sb-view-all:hover {

            color: var(--sb-primary);

            transform:
                translateY(-1px);

        }


        .sb-add-product {

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed
                );

            box-shadow:
                0 8px 20px
                rgba(79,70,229,.16);

        }


        .sb-add-product:hover {

            color: #fff;

            transform:
                translateY(-1px);

            box-shadow:
                0 11px 24px
                rgba(79,70,229,.22);

        }


        .sb-product-grid {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 13px;

        }


        .sb-product {

            min-width: 0;

            overflow: hidden;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 14px;

            background: #fff;

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                border-color .22s ease;

        }


        .sb-product:hover {

            transform:
                translateY(-4px);

            border-color:
                rgba(79,70,229,.13);

            box-shadow:
                var(--sb-shadow-hover);

        }


        .sb-product-image {

            position: relative;

            height:
                clamp(165px, 13vw, 210px);

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #f8fafc,
                    #eef2f7
                );

        }


        .sb-product-image::after {

            content: "";

            position: absolute;

            inset: 0;

            pointer-events: none;

            background:
                linear-gradient(
                    180deg,
                    rgba(0,0,0,.025),
                    transparent 50%,
                    rgba(0,0,0,.035)
                );

        }


        .sb-product-image img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

            transition:
                transform .4s ease;

        }


        .sb-product:hover
        .sb-product-image img {

            transform:
                scale(1.045);

        }


        .sb-product-stock-badge {

            position: absolute;

            z-index: 2;

            top: 9px;

            left: 9px;

            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding:
                5px 7px;

            border-radius: 7px;

            color: var(--sb-success);

            background:
                rgba(255,255,255,.94);

            backdrop-filter:
                blur(10px);

            box-shadow:
                0 5px 15px
                rgba(15,23,42,.09);

            font-size: 7px;

            font-weight: 950;

        }


        .sb-product-stock-badge i {

            font-size: 5px;

        }


        .sb-product-stock-badge.low {

            color: var(--sb-warning);

        }


        .sb-product-stock-badge.out {

            color: var(--sb-danger);

        }


        .sb-product-body {

            padding: 13px;

        }


        .sb-product-name {

            min-height: 28px;

            margin: 0;

            overflow: hidden;

            color: var(--sb-text);

            font-size: 9px;

            line-height: 1.45;

            font-weight: 900;

            display:
                -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

        }


        .sb-product-category {

            margin-top: 4px;

            overflow: hidden;

            color: var(--sb-soft);

            font-size: 7.5px;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-product-info {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 8px;

            margin-top: 10px;

        }


        .sb-product-price {

            color: var(--sb-text);

            font-size: 14px;

            font-weight: 950;

            letter-spacing: -.02em;

        }


        .sb-product-stock {

            color: var(--sb-muted);

            font-size: 7.5px;

            font-weight: 750;

        }


        .sb-product-actions {

            display: flex;

            align-items: center;

            gap: 6px;

            margin-top: 11px;

        }


        .sb-edit,
        .sb-delete {

            min-height: 29px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            padding:
                0 8px;

            border: 0;

            border-radius: 8px;

            text-decoration: none;

            font-size: 7.5px;

            font-weight: 900;

            transition:
                transform .18s ease,
                background .18s ease;

        }


        .sb-edit {

            flex: 1;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.075);

        }


        .sb-edit:hover {

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.13);

            transform:
                translateY(-1px);

        }


        .sb-delete {

            color: var(--sb-danger);

            background:
                rgba(220,38,38,.065);

        }


        .sb-delete:hover {

            color: var(--sb-danger);

            background:
                rgba(220,38,38,.12);

            transform:
                translateY(-1px);

        }


        /* =========================================================
           EMPTY
           ========================================================= */

        .sb-empty {

            grid-column:
                1 / -1;

            padding:
                60px 20px;

            text-align: center;

            border:
                1px dashed
                rgba(15,23,42,.12);

            border-radius: 15px;

            background:
                #f8fafc;

        }


        .sb-empty-icon {

            width: 58px;

            height: 58px;

            margin:
                0 auto 13px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.08);

            font-size: 19px;

        }


        .sb-empty-title {

            margin: 0;

            color: var(--sb-text);

            font-size: 14px;

            font-weight: 950;

        }


        .sb-empty-text {

            max-width: 440px;

            margin:
                6px auto 15px;

            color: var(--sb-muted);

            font-size: 8.5px;

            line-height: 1.6;

        }


        .sb-empty-action {

            min-height: 35px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding:
                0 13px;

            border-radius: 9px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            text-decoration: none;

            font-size: 8px;

            font-weight: 900;

        }


        .sb-empty-action:hover {

            color: #fff;

        }


        /* =========================================================
           BOTTOM
           ========================================================= */

        .sb-bottom-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1.28fr)
                minmax(310px, .72fr);

            gap: 15px;

        }


        .sb-tip-card,
        .sb-account-card {

            min-width: 0;

            padding: 20px;

            border:
                1px solid
                rgba(15,23,42,.07);

            border-radius: 18px;

            background:
                rgba(255,255,255,.95);

            box-shadow:
                var(--sb-shadow);

        }


        .sb-tip-list {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 9px;

            margin-top: 15px;

        }


        .sb-tip {

            min-width: 0;

            padding: 13px;

            border:
                1px solid
                rgba(15,23,42,.045);

            border-radius: 12px;

            background:
                #f8fafc;

        }


        .sb-tip-icon {

            width: 31px;

            height: 31px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 9px;

            border-radius: 9px;

            color: var(--sb-primary);

            background:
                rgba(79,70,229,.08);

            font-size: 10px;

        }


        .sb-tip-title {

            color: var(--sb-text);

            font-size: 9px;

            font-weight: 900;

        }


        .sb-tip-text {

            margin:
                4px 0 0;

            color: var(--sb-muted);

            font-size: 8px;

            line-height: 1.6;

        }


        /* =========================================================
           ACCOUNT CARD
           ========================================================= */

        .sb-account-card-head {

            display: flex;

            align-items: center;

            gap: 11px;

            padding-bottom: 14px;

            border-bottom:
                1px solid
                rgba(15,23,42,.07);

        }


        .sb-avatar {

            width: 44px;

            height: 44px;

            min-width: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 13px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-purple)
                );

            box-shadow:
                0 9px 22px
                rgba(79,70,229,.17);

            font-size: 15px;

            font-weight: 950;

        }


        .sb-account-name {

            overflow: hidden;

            color: var(--sb-text);

            font-size: 11px;

            font-weight: 900;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-account-role {

            margin-top: 3px;

            color: var(--sb-muted);

            font-size: 8px;

        }


        .sb-account-info {

            display: grid;

            gap: 7px;

            margin-top: 13px;

        }


        .sb-account-info-row {

            min-height: 35px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            padding:
                7px 9px;

            border-radius: 9px;

            background:
                #f8fafc;

        }


        .sb-account-info-label {

            color: var(--sb-muted);

            font-size: 7.5px;

            font-weight: 750;

        }


        .sb-account-info-value {

            max-width: 60%;

            overflow: hidden;

            color: var(--sb-text);

            font-size: 7.5px;

            font-weight: 900;

            text-align: right;

            white-space: nowrap;

            text-overflow: ellipsis;

        }


        .sb-account-info-value.active {

            color: var(--sb-success);

        }


        .sb-account-info-value.review {

            color: var(--sb-primary);

        }


        .sb-account-info-value.danger {

            color: var(--sb-danger);

        }


        .sb-account-info-value.pending {

            color: var(--sb-warning);

        }


        /* =========================================================
           ICONS
           ========================================================= */

        .sb-dashboard-page
        i[class^="fa-"],
        .sb-dashboard-page
        i[class*=" fa-"] {

            font-style: normal;

            line-height: 1;

            text-rendering:
                optimizeLegibility;

            -webkit-font-smoothing:
                antialiased;

            -moz-osx-font-smoothing:
                grayscale;

        }


        /* =========================================================
           FOCUS
           ========================================================= */

        .sb-dashboard-page
        a:focus-visible,
        .sb-dashboard-page
        button:focus-visible {

            outline:
                2px solid
                var(--sb-primary) !important;

            outline-offset:
                2px !important;

        }


        /* =========================================================
           LARGE DESKTOP
           ========================================================= */

        @media (min-width: 1600px) {

            .sb-dashboard {

                padding-left:
                    38px;

                padding-right:
                    38px;

            }


            .sb-product-image {

                height: 225px;

            }

        }


        /* =========================================================
           1300
           ========================================================= */

        @media (max-width: 1300px) {

            .sb-product-grid {

                grid-template-columns:
                    repeat(4, minmax(0, 1fr));

            }


            .sb-product-image {

                height: 180px;

            }

        }


        /* =========================================================
           1100
           ========================================================= */

        @media (max-width: 1100px) {

            .sb-main-grid {

                grid-template-columns:
                    minmax(0, 1fr)
                    minmax(300px, .75fr);

            }


            .sb-bottom-grid {

                grid-template-columns:
                    1fr;

            }


            .sb-tip-list {

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

            }

        }


        /* =========================================================
           950
           ========================================================= */

        @media (max-width: 950px) {

            .sb-commandbar {

                align-items: flex-start;

                flex-direction: column;

            }


            .sb-command-right {

                width: 100%;

                justify-content: flex-start;

            }


            .sb-hero {

                align-items: flex-start;

                flex-direction: column;

            }


            .sb-hero-actions {

                justify-content: flex-start;

            }


            .sb-main-grid {

                grid-template-columns:
                    1fr;

            }


            .sb-product-grid {

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

            }

        }


        /* =========================================================
           760
           ========================================================= */

        @media (max-width: 760px) {

            .sb-dashboard {

                padding:
                    15px 12px 35px;

            }


            .sb-stats {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 9px;

            }


            .sb-product-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 10px;

            }


            .sb-products-head {

                align-items: flex-start;

                flex-direction: column;

            }


            .sb-products-head-right {

                width: 100%;

                justify-content: flex-start;

            }


            .sb-verification {

                align-items: flex-start;

                flex-direction: column;

            }


            .sb-verification-main {

                width: 100%;

            }


            .sb-verification-controls {

                width: 100%;

                justify-content: flex-start;

            }


            .sb-tip-list {

                grid-template-columns:
                    1fr;

            }

        }


        /* =========================================================
           560
           ========================================================= */

        @media (max-width: 560px) {

            .sb-commandbar {

                padding:
                    13px;

                border-radius:
                    16px;

            }


            .sb-brand-mark {

                width: 43px;

                height: 43px;

                min-width: 43px;

                border-radius: 12px;

            }


            .sb-command-title {

                font-size: 18px;

            }


            .sb-command-subtitle {

                font-size: 8px;

            }


            .sb-account-status {

                width: 100%;

            }


            .sb-hero {

                padding:
                    25px 20px;

                border-radius:
                    20px;

            }


            .sb-hero-title {

                font-size:
                    29px;

            }


            .sb-hero-text {

                font-size: 10px;

            }


            .sb-hero-actions {

                width: 100%;

            }


            .sb-primary-btn,
            .sb-secondary-btn {

                flex: 1;

            }


            .sb-actions {

                grid-template-columns:
                    1fr;

            }


            .sb-product-image {

                height:
                    155px;

            }


            .sb-product-body {

                padding:
                    10px;

            }


            .sb-product-price {

                font-size:
                    13px;

            }


            .sb-product-actions {

                flex-direction:
                    column;

            }


            .sb-edit,
            .sb-delete {

                width: 100%;

            }


            .sb-products-head-right {

                display: grid;

                grid-template-columns:
                    1fr 1fr;

            }


            .sb-view-all,
            .sb-add-product {

                width: 100%;

            }

        }


        /* =========================================================
           420
           ========================================================= */

        @media (max-width: 420px) {

            .sb-dashboard {

                padding:
                    11px 8px 30px;

            }


            .sb-stats {

                gap: 7px;

            }


            .sb-stat {

                padding:
                    12px;

            }


            .sb-stat-icon {

                width: 34px;

                height: 34px;

                border-radius: 9px;

            }


            .sb-stat-number {

                margin-top:
                    13px;

                font-size:
                    19px;

            }


            .sb-stat-label {

                font-size:
                    8px;

            }


            .sb-product-grid {

                grid-template-columns:
                    1fr 1fr;

                gap: 7px;

            }


            .sb-product-image {

                height:
                    135px;

            }


            .sb-product-stock-badge {

                top: 6px;

                left: 6px;

                padding:
                    4px 5px;

                font-size:
                    6px;

            }


            .sb-product-body {

                padding:
                    8px;

            }


            .sb-product-name {

                font-size:
                    8px;

            }


            .sb-product-category {

                font-size:
                    6.5px;

            }


            .sb-product-price {

                font-size:
                    12px;

            }


            .sb-product-stock {

                font-size:
                    6.5px;

            }


            .sb-account-card,
            .sb-tip-card,
            .sb-products-wrap,
            .sb-panel {

                padding:
                    14px;

            }

        }


        /* =========================================================
           REDUCE MOTION
           ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .sb-dashboard-page *,
            .sb-dashboard-page *::before,
            .sb-dashboard-page *::after {

                transition:
                    none !important;

                animation:
                    none !important;

            }

        }

    </style>

</head>


<body>


    {{-- =========================================================
         COMMON SELLER TASKBAR
         IMPORTANT:
         DO NOT CHANGE THESE.
         SAME AS SELLER ORDERS PAGE.
         ========================================================= --}}

    @include('seller.partials.topbar')

    @include('seller.partials.seller-menu')


    {{-- =========================================================
         SELLER DATA
         ========================================================= --}}

    @php

        $sellerName = $seller->business_name
            ?? $seller->name
            ?? $seller->owner_name
            ?? 'Seller';


        $sellerInitial = strtoupper(
            substr(
                trim((string) $sellerName),
                0,
                1
            )
        );


        $sellerStatus =
            $seller->verification_status
            ?? null;


        $sellerDashboardStatus = match ($sellerStatus) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => 'Seller account active',

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => 'Application under review',

            \App\Models\SellerProfile::STATUS_REJECTED
                => 'Application rejected',

            \App\Models\SellerProfile::STATUS_EMAIL_VERIFICATION,
            \App\Models\SellerProfile::STATUS_PENDING_EMAIL,
            \App\Models\SellerProfile::STATUS_PENDING,
            \App\Models\SellerProfile::STATUS_DRAFT
                => 'Verification pending',

            default
                => 'Verification in progress',

        };


        $sellerStatusType = match ($sellerStatus) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => 'active',

            \App\Models\SellerProfile::STATUS_REJECTED
                => 'danger',

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => 'review',

            default
                => 'pending',

        };


        $verificationStatusText = match ($sellerStatus) {

            \App\Models\SellerProfile::STATUS_APPROVED,
            \App\Models\SellerProfile::STATUS_ACTIVE
                => 'Verified',

            \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
            \App\Models\SellerProfile::STATUS_PENDING_REVIEW
                => 'Under Review',

            \App\Models\SellerProfile::STATUS_REJECTED
                => 'Action Required',

            default
                => 'Verification Pending',

        };


        $totalProductsValue =
            (int) ($totalProducts ?? 0);


        $totalOrdersValue =
            (int) ($totalOrders ?? 0);


        $pendingOrdersValue =
            (int) ($pendingOrders ?? 0);


        $totalRevenueValue =
            (float) ($totalRevenue ?? 0);


        $productsCollection =
            collect($products ?? []);


        $lowStockCount =
            $productsCollection
                ->filter(function ($product) {

                    return
                        (int) ($product->stock ?? 0) > 0
                        &&
                        (int) ($product->stock ?? 0) <= 5;

                })
                ->count();


        $outOfStockCount =
            $productsCollection
                ->filter(function ($product) {

                    return
                        (int) ($product->stock ?? 0) <= 0;

                })
                ->count();


        $inStockCount =
            max(
                0,
                $totalProductsValue - $outOfStockCount
            );

    @endphp


    {{-- =========================================================
         DASHBOARD
         ========================================================= --}}

    <main class="sb-dashboard-page">

        <div class="sb-dashboard">


            {{-- =================================================
                 COMMAND BAR
                 ================================================= --}}

            <section class="sb-commandbar">

                <div class="sb-command-left">

                    <div class="sb-brand-mark">

                        <i
                            class="fa-solid fa-store"
                            aria-hidden="true"
                        ></i>

                    </div>


                    <div class="sb-command-copy">

                        <div class="sb-eyebrow">

                            <i
                                class="fa-solid fa-bolt"
                                aria-hidden="true"
                            ></i>

                            Seller Workspace

                        </div>


                        <h1 class="sb-command-title">

                            {{ $sellerName }}

                        </h1>


                        <p class="sb-command-subtitle">

                            SmartBasket Seller Center

                        </p>

                    </div>

                </div>


                <div class="sb-command-right">

                    <div
                        class="sb-account-status {{ $sellerStatusType }}"
                    >

                        <span class="sb-account-dot"></span>

                        {{ $sellerDashboardStatus }}

                    </div>

                </div>

            </section>


            {{-- =================================================
                 HERO
                 ================================================= --}}

            <section class="sb-hero">

                <div class="sb-hero-copy">

                    <span class="sb-hero-label">

                        <i
                            class="fa-solid fa-chart-line"
                            aria-hidden="true"
                        ></i>

                        Seller Dashboard

                    </span>


                    <h2 class="sb-hero-title">

                        Grow your store.
                        <br>
                        Sell smarter.

                    </h2>


                    <p class="sb-hero-text">

                        Manage your products, orders, payments and seller
                        account from one powerful SmartBasket workspace.

                    </p>

                </div>


                <div class="sb-hero-actions">

                    <a
                        href="{{ route('seller.product.add') }}"
                        class="sb-primary-btn"
                    >

                        <i
                            class="fa-solid fa-plus"
                            aria-hidden="true"
                        ></i>

                        Add Product

                    </a>


                    <a
                        href="{{ route('seller.orders.index') }}"
                        class="sb-secondary-btn"
                    >

                        <i
                            class="fa-solid fa-receipt"
                            aria-hidden="true"
                        ></i>

                        View Orders

                    </a>

                </div>

            </section>


            {{-- =================================================
                 STORE OVERVIEW
                 ================================================= --}}

            <section>

                <div class="sb-section-heading">

                    <div>

                        <div class="sb-section-kicker">

                            Business Analytics

                        </div>


                        <h2 class="sb-section-title">

                            Store Overview

                        </h2>


                        <p class="sb-section-description">

                            Monitor your seller business from one place.

                        </p>

                    </div>

                </div>


                <div class="sb-stats">


                    {{-- PRODUCTS --}}

                    <div class="sb-stat">

                        <div class="sb-stat-top">

                            <div class="sb-stat-icon">

                                <i
                                    class="fa-solid fa-box"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <span class="sb-stat-live">

                                Catalog

                            </span>

                        </div>


                        <div class="sb-stat-number">

                            {{ number_format($totalProductsValue) }}

                        </div>


                        <div class="sb-stat-label">

                            Total Products

                        </div>

                    </div>


                    {{-- ORDERS --}}

                    <div class="sb-stat">

                        <div class="sb-stat-top">

                            <div class="sb-stat-icon">

                                <i
                                    class="fa-solid fa-bag-shopping"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <span class="sb-stat-live">

                                Orders

                            </span>

                        </div>


                        <div class="sb-stat-number">

                            {{ number_format($totalOrdersValue) }}

                        </div>


                        <div class="sb-stat-label">

                            Total Orders

                        </div>

                    </div>


                    {{-- PENDING --}}

                    <div class="sb-stat">

                        <div class="sb-stat-top">

                            <div class="sb-stat-icon">

                                <i
                                    class="fa-solid fa-clock"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <span
                                class="sb-stat-live"
                                style="{{ $pendingOrdersValue > 0 ? 'color:var(--sb-warning);background:rgba(217,119,6,.07);' : '' }}"
                            >

                                {{
                                    $pendingOrdersValue > 0
                                        ? 'Action needed'
                                        : 'All clear'
                                }}

                            </span>

                        </div>


                        <div class="sb-stat-number">

                            {{ number_format($pendingOrdersValue) }}

                        </div>


                        <div class="sb-stat-label">

                            Pending Orders

                        </div>

                    </div>


                    {{-- REVENUE --}}

                    <div class="sb-stat">

                        <div class="sb-stat-top">

                            <div class="sb-stat-icon">

                                <i
                                    class="fa-solid fa-indian-rupee-sign"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <span class="sb-stat-live">

                                Earnings

                            </span>

                        </div>


                        <div class="sb-stat-number">

                            ₹{{ number_format($totalRevenueValue, 2) }}

                        </div>


                        <div class="sb-stat-label">

                            Total Revenue

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 MAIN GRID
                 ================================================= --}}

            <section class="sb-main-grid">


                {{-- QUICK ACTIONS --}}

                <div class="sb-panel">

                    <div class="sb-section-heading">

                        <div>

                            <div class="sb-section-kicker">

                                Seller Tools

                            </div>


                            <h2 class="sb-section-title">

                                Quick Actions

                            </h2>


                            <p class="sb-section-description">

                                Your most-used seller operations.

                            </p>

                        </div>

                    </div>


                    <div class="sb-actions">


                        <a
                            href="{{ route('seller.product.add') }}"
                            class="sb-action"
                        >

                            <span class="sb-action-icon">

                                <i
                                    class="fa-solid fa-plus"
                                    aria-hidden="true"
                                ></i>

                            </span>


                            <span class="sb-action-content">

                                <span class="sb-action-title">

                                    Add Product

                                </span>


                                <span class="sb-action-text">

                                    Create a new product listing.

                                </span>

                            </span>


                            <i
                                class="fa-solid fa-arrow-right sb-action-arrow"
                                aria-hidden="true"
                            ></i>

                        </a>


                        <a
                            href="{{ route('seller.products.index') }}"
                            class="sb-action"
                        >

                            <span class="sb-action-icon">

                                <i
                                    class="fa-solid fa-boxes-stacked"
                                    aria-hidden="true"
                                ></i>

                            </span>


                            <span class="sb-action-content">

                                <span class="sb-action-title">

                                    Manage Products

                                </span>


                                <span class="sb-action-text">

                                    Edit, update and manage products.

                                </span>

                            </span>


                            <i
                                class="fa-solid fa-arrow-right sb-action-arrow"
                                aria-hidden="true"
                            ></i>

                        </a>


                        <a
                            href="{{ route('seller.orders.index') }}"
                            class="sb-action"
                        >

                            <span class="sb-action-icon">

                                <i
                                    class="fa-solid fa-truck-fast"
                                    aria-hidden="true"
                                ></i>

                            </span>


                            <span class="sb-action-content">

                                <span class="sb-action-title">

                                    Manage Orders

                                </span>


                                <span class="sb-action-text">

                                    Process pending customer orders.

                                </span>

                            </span>


                            <i
                                class="fa-solid fa-arrow-right sb-action-arrow"
                                aria-hidden="true"
                            ></i>

                        </a>


                        <a
                            href="{{ route('seller.payments.index') }}"
                            class="sb-action"
                        >

                            <span class="sb-action-icon">

                                <i
                                    class="fa-solid fa-wallet"
                                    aria-hidden="true"
                                ></i>

                            </span>


                            <span class="sb-action-content">

                                <span class="sb-action-title">

                                    Payments

                                </span>


                                <span class="sb-action-text">

                                    View earnings and payment receipts.

                                </span>

                            </span>


                            <i
                                class="fa-solid fa-arrow-right sb-action-arrow"
                                aria-hidden="true"
                            ></i>

                        </a>

                    </div>

                </div>


                {{-- STORE HEALTH --}}

                <div class="sb-panel">

                    <div class="sb-section-heading">

                        <div>

                            <div class="sb-section-kicker">

                                Inventory

                            </div>


                            <h2 class="sb-section-title">

                                Store Health

                            </h2>


                            <p class="sb-section-description">

                                Keep your catalog ready to sell.

                            </p>

                        </div>

                    </div>


                    <div class="sb-health-list">


                        <div class="sb-health-row">

                            <div class="sb-health-left">

                                <span class="sb-health-icon">

                                    <i
                                        class="fa-solid fa-box"
                                        aria-hidden="true"
                                    ></i>

                                </span>


                                <div>

                                    <div class="sb-health-name">

                                        Product Catalog

                                    </div>


                                    <div class="sb-health-desc">

                                        Total listed products

                                    </div>

                                </div>

                            </div>


                            <span class="sb-health-value success">

                                {{ number_format($totalProductsValue) }}

                            </span>

                        </div>


                        <div class="sb-health-row">

                            <div class="sb-health-left">

                                <span class="sb-health-icon">

                                    <i
                                        class="fa-solid fa-circle-check"
                                        aria-hidden="true"
                                    ></i>

                                </span>


                                <div>

                                    <div class="sb-health-name">

                                        In Stock

                                    </div>


                                    <div class="sb-health-desc">

                                        Products currently available

                                    </div>

                                </div>

                            </div>


                            <span class="sb-health-value success">

                                {{ number_format($inStockCount) }}

                            </span>

                        </div>


                        <div class="sb-health-row">

                            <div class="sb-health-left">

                                <span class="sb-health-icon">

                                    <i
                                        class="fa-solid fa-triangle-exclamation"
                                        aria-hidden="true"
                                    ></i>

                                </span>


                                <div>

                                    <div class="sb-health-name">

                                        Low Stock

                                    </div>


                                    <div class="sb-health-desc">

                                        Five or fewer units

                                    </div>

                                </div>

                            </div>


                            <span class="sb-health-value warning">

                                {{ number_format($lowStockCount) }}

                            </span>

                        </div>


                        <div class="sb-health-row">

                            <div class="sb-health-left">

                                <span class="sb-health-icon">

                                    <i
                                        class="fa-solid fa-circle-xmark"
                                        aria-hidden="true"
                                    ></i>

                                </span>


                                <div>

                                    <div class="sb-health-name">

                                        Out of Stock

                                    </div>


                                    <div class="sb-health-desc">

                                        Products unavailable

                                    </div>

                                </div>

                            </div>


                            <span
                                class="sb-health-value {{ $outOfStockCount > 0 ? 'danger' : 'success' }}"
                            >

                                {{ number_format($outOfStockCount) }}

                            </span>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 PENDING ORDERS
                 ================================================= --}}

            @if($pendingOrdersValue > 0)

                <section
                    class="sb-verification"
                    style="border-color:rgba(217,119,6,.16);"
                >

                    <div class="sb-verification-main">

                        <div
                            class="sb-verification-icon"
                            style="
                                color:var(--sb-warning);
                                background:rgba(217,119,6,.08);
                            "
                        >

                            <i
                                class="fa-solid fa-bell"
                                aria-hidden="true"
                            ></i>

                        </div>


                        <div>

                            <h3 class="sb-verification-title">

                                You have
                                {{ number_format($pendingOrdersValue) }}
                                pending order{{ $pendingOrdersValue === 1 ? '' : 's' }}

                            </h3>


                            <p class="sb-verification-text">

                                Review and process your customer orders
                                to keep your store running smoothly.

                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ route('seller.orders.index') }}"
                        class="sb-verification-action"
                        style="
                            color:var(--sb-warning);
                            background:rgba(217,119,6,.08);
                        "
                    >

                        Manage Orders

                        <i
                            class="fa-solid fa-arrow-right"
                            aria-hidden="true"
                        ></i>

                    </a>

                </section>

            @endif


            {{-- =================================================
                 SELLER VERIFICATION
                 ================================================= --}}

            <section class="sb-verification">

                <div class="sb-verification-main">

                    <div class="sb-verification-icon">

                        <i
                            class="fa-solid fa-shield-halved"
                            aria-hidden="true"
                        ></i>

                    </div>


                    <div>

                        <h3 class="sb-verification-title">

                            Seller Verification

                        </h3>


                        <p class="sb-verification-text">

                            Manage your seller verification and account
                            information.

                        </p>

                    </div>

                </div>


                <div class="sb-verification-controls">


                    <div
                        class="sb-verification-status {{ $sellerStatusType }}"
                    >

                        @if($sellerStatusType === 'active')

                            <i
                                class="fa-solid fa-circle-check"
                                aria-hidden="true"
                            ></i>

                        @elseif($sellerStatusType === 'danger')

                            <i
                                class="fa-solid fa-circle-exclamation"
                                aria-hidden="true"
                            ></i>

                        @elseif($sellerStatusType === 'review')

                            <i
                                class="fa-solid fa-clock"
                                aria-hidden="true"
                            ></i>

                        @else

                            <i
                                class="fa-solid fa-shield-halved"
                                aria-hidden="true"
                            ></i>

                        @endif


                        {{ $verificationStatusText }}

                    </div>


                    @if(
                        $sellerStatusType !== 'active'
                        &&
                        $sellerStatusType !== 'review'
                    )

                        <a
                            href="{{ route('seller.verification.index') }}"
                            class="sb-verification-action"
                        >

                            {{
                                $sellerStatusType === 'danger'
                                    ? 'Update Application'
                                    : 'Continue Verification'
                            }}


                            <i
                                class="fa-solid fa-arrow-right"
                                aria-hidden="true"
                            ></i>

                        </a>

                    @endif

                </div>

            </section>


            {{-- =================================================
                 PRODUCTS
                 ================================================= --}}

            <section class="sb-products-wrap">

                <div class="sb-products-head">

                    <div>

                        <div class="sb-section-kicker">

                            Seller Catalog

                        </div>


                        <h2 class="sb-section-title">

                            My Products

                        </h2>


                        <p class="sb-section-description">

                            Manage your latest products and inventory.

                        </p>

                    </div>


                    <div class="sb-products-head-right">

                        <a
                            href="{{ route('seller.products.index') }}"
                            class="sb-view-all"
                        >

                            View All

                            <i
                                class="fa-solid fa-arrow-right"
                                aria-hidden="true"
                            ></i>

                        </a>


                        <a
                            href="{{ route('seller.product.add') }}"
                            class="sb-add-product"
                        >

                            <i
                                class="fa-solid fa-plus"
                                aria-hidden="true"
                            ></i>

                            Add Product

                        </a>

                    </div>

                </div>


                <div class="sb-product-grid">


                    @forelse($products as $product)

                        @php

                            $productStock =
                                (int) ($product->stock ?? 0);


                            if ($productStock <= 0) {

                                $stockClass = 'out';

                                $stockText = 'Out of Stock';

                            } elseif ($productStock <= 5) {

                                $stockClass = 'low';

                                $stockText = 'Low Stock';

                            } else {

                                $stockClass = '';

                                $stockText = 'In Stock';

                            }

                        @endphp


                        <article class="sb-product">


                            <div class="sb-product-image">

                                <img
                                    src="{{ asset('products/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    onerror="this.style.display='none';"
                                >


                                <span
                                    class="sb-product-stock-badge {{ $stockClass }}"
                                >

                                    <i
                                        class="fa-solid fa-circle"
                                        aria-hidden="true"
                                    ></i>

                                    {{ $stockText }}

                                </span>

                            </div>


                            <div class="sb-product-body">

                                <h3 class="sb-product-name">

                                    {{ $product->name }}

                                </h3>


                                <div class="sb-product-category">

                                    {{ $product->category ?? 'Product' }}

                                </div>


                                <div class="sb-product-info">

                                    <div class="sb-product-price">

                                        ₹{{ number_format((float) $product->price, 2) }}

                                    </div>


                                    <div class="sb-product-stock">

                                        Stock: {{ $productStock }}

                                    </div>

                                </div>


                                <div class="sb-product-actions">


                                    <a
                                        href="{{ route('seller.product.edit', $product->id) }}"
                                        class="sb-edit"
                                    >

                                        <i
                                            class="fa-solid fa-pen"
                                            aria-hidden="true"
                                        ></i>

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('seller.product.delete', $product->id) }}"
                                        method="POST"
                                        style="
                                            margin:0;
                                            flex:1;
                                        "
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="sb-delete"
                                            style="width:100%;"
                                            onclick="
                                                return confirm(
                                                    'Delete this product?'
                                                )
                                            "
                                        >

                                            <i
                                                class="fa-solid fa-trash"
                                                aria-hidden="true"
                                            ></i>

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </article>


                    @empty


                        <div class="sb-empty">

                            <div class="sb-empty-icon">

                                <i
                                    class="fa-solid fa-box-open"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <h3 class="sb-empty-title">

                                Your catalog is empty

                            </h3>


                            <p class="sb-empty-text">

                                Add your first product and start building
                                your SmartBasket store.

                            </p>


                            <a
                                href="{{ route('seller.product.add') }}"
                                class="sb-empty-action"
                            >

                                <i
                                    class="fa-solid fa-plus"
                                    aria-hidden="true"
                                ></i>

                                Add Your First Product

                            </a>

                        </div>


                    @endforelse

                </div>

            </section>


            {{-- =================================================
                 BOTTOM SECTION
                 ================================================= --}}

            <section class="sb-bottom-grid">


                {{-- GROWTH TIPS --}}

                <div class="sb-tip-card">

                    <div class="sb-section-kicker">

                        Seller Growth

                    </div>


                    <h2 class="sb-section-title">

                        Store Growth Essentials

                    </h2>


                    <p class="sb-section-description">

                        Simple ways to keep your seller store competitive.

                    </p>


                    <div class="sb-tip-list">


                        <div class="sb-tip">

                            <div class="sb-tip-icon">

                                <i
                                    class="fa-solid fa-camera"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <div class="sb-tip-title">

                                Better Product Images

                            </div>


                            <p class="sb-tip-text">

                                Use clear, high-quality images to make
                                your products easier to discover.

                            </p>

                        </div>


                        <div class="sb-tip">

                            <div class="sb-tip-icon">

                                <i
                                    class="fa-solid fa-tags"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <div class="sb-tip-title">

                                Competitive Pricing

                            </div>


                            <p class="sb-tip-text">

                                Keep prices attractive while maintaining
                                healthy margins.

                            </p>

                        </div>


                        <div class="sb-tip">

                            <div class="sb-tip-icon">

                                <i
                                    class="fa-solid fa-truck-fast"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            <div class="sb-tip-title">

                                Fast Order Handling

                            </div>


                            <p class="sb-tip-text">

                                Process customer orders quickly for a
                                smoother shopping experience.

                            </p>

                        </div>


                    </div>

                </div>


                {{-- ACCOUNT INFORMATION --}}

                <div class="sb-account-card">

                    <div class="sb-account-card-head">

                        <div class="sb-avatar">

                            {{ $sellerInitial }}

                        </div>


                        <div>

                            <div class="sb-account-name">

                                {{ $sellerName }}

                            </div>


                            <div class="sb-account-role">

                                SmartBasket Seller Account

                            </div>

                        </div>

                    </div>


                    <div class="sb-account-info">


                        <div class="sb-account-info-row">

                            <span class="sb-account-info-label">

                                Account Status

                            </span>


                            <span
                                class="sb-account-info-value {{ $sellerStatusType }}"
                            >

                                {{ $sellerDashboardStatus }}

                            </span>

                        </div>


                        <div class="sb-account-info-row">

                            <span class="sb-account-info-label">

                                Verification

                            </span>


                            <span
                                class="sb-account-info-value {{ $sellerStatusType }}"
                            >

                                {{ $verificationStatusText }}

                            </span>

                        </div>


                        <div class="sb-account-info-row">

                            <span class="sb-account-info-label">

                                Products

                            </span>


                            <span class="sb-account-info-value">

                                {{ number_format($totalProductsValue) }}

                            </span>

                        </div>


                        <div class="sb-account-info-row">

                            <span class="sb-account-info-label">

                                Orders

                            </span>


                            <span class="sb-account-info-value">

                                {{ number_format($totalOrdersValue) }}

                            </span>

                        </div>

                    </div>

                </div>

            </section>


        </div>

    </main>


    {{-- =========================================================
         DASHBOARD JS
         NO TASKBAR JS
         ========================================================= --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                 * Broken image handling
                 */

                document
                    .querySelectorAll(
                        '.sb-product-image img'
                    )
                    .forEach(
                        function (image) {

                            image.addEventListener(
                                'error',
                                function () {

                                    this.style.display =
                                        'none';

                                }
                            );

                        }
                    );


                /*
                 * Small protection against accidental
                 * double submit on product delete.
                 */

                document
                    .querySelectorAll(
                        '.sb-product form'
                    )
                    .forEach(
                        function (form) {

                            form.addEventListener(
                                'submit',
                                function () {

                                    const button =
                                        this.querySelector(
                                            'button[type="submit"]'
                                        );

                                    if (button) {

                                        button.disabled =
                                            true;

                                    }

                                }
                            );

                        }
                    );

            }
        );

    </script>


    {{-- Bootstrap JS --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


</body>

</html>
<!DOCTYPE html>
<html lang="en" data-sb-theme="light">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="theme-color"
        content="#2563eb"
    >

    <meta
        name="color-scheme"
        content="light"
    >

    <title>My Products | SMART BASKET Seller</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        /* =========================================================
           SMART BASKET SELLER
           MY PRODUCTS — PREMIUM FULL WIDTH LIGHT UI

           IMPORTANT:
           COMMON SELLER TOPBAR + SELLER MENU ARE NOT STYLED HERE.
           THEY MUST USE THE EXACT SAME WIDTH / POSITIONING AS
           THE SELLER ORDERS PAGE THROUGH THE COMMON PARTIALS.
        ========================================================= */


        /* =========================================================
           GLOBAL PAGE RESET
           DOES NOT TOUCH COMMON SELLER TASKBAR
        ========================================================= */

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-width: 0;
        }


        .sb-products-page,
        .sb-products-page * {
            box-sizing: border-box;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .sb-products-page {

            --p-blue-950: #172554;
            --p-blue-900: #1e3a8a;
            --p-blue-800: #1e40af;
            --p-blue-700: #1d4ed8;
            --p-blue-600: #2563eb;
            --p-blue-500: #3b82f6;
            --p-blue-400: #60a5fa;
            --p-blue-100: #dbeafe;
            --p-blue-50: #eff6ff;

            --p-text: #0f172a;
            --p-text-soft: #334155;
            --p-muted: #64748b;
            --p-muted-light: #94a3b8;

            --p-border: #e2e8f0;
            --p-border-soft: #edf2f7;

            --p-green: #16a34a;
            --p-green-dark: #15803d;
            --p-green-bg: #f0fdf4;
            --p-green-border: #bbf7d0;

            --p-red: #dc2626;
            --p-red-dark: #b91c1c;
            --p-red-bg: #fef2f2;
            --p-red-border: #fecaca;

            width: 100%;
            max-width: none;

            min-height: calc(100vh - 1px);

            margin: 0;
            padding: 26px 18px 65px;

            color: var(--p-text);

            font-family: 'Inter', sans-serif;

            background:
                radial-gradient(
                    circle at 4% 3%,
                    rgba(37,99,235,.075),
                    transparent 24%
                ),
                radial-gradient(
                    circle at 96% 96%,
                    rgba(59,130,246,.055),
                    transparent 25%
                );
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .sb-products-page .sb-products-header {

            position: relative;

            width: 100%;

            min-height: 150px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 24px;

            margin-bottom: 20px;
            padding: 28px 32px;

            overflow: hidden;

            border: 1px solid rgba(191,219,254,.85);
            border-radius: 25px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.99),
                    rgba(247,250,255,.97)
                );

            box-shadow:
                0 14px 38px rgba(15,23,42,.065);
        }


        .sb-products-page .sb-products-header::before {

            content: "";

            position: absolute;

            width: 360px;
            height: 360px;

            top: -220px;
            right: -75px;

            border-radius: 50%;

            background:
                rgba(37,99,235,.055);

            pointer-events: none;
        }


        .sb-products-page .sb-products-header::after {

            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            right: 32%;
            bottom: -210px;

            border-radius: 50%;

            background:
                rgba(96,165,250,.045);

            pointer-events: none;
        }


        .sb-products-page .sb-header-left {

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            gap: 18px;

            min-width: 0;
        }


        /* =========================================================
           HEADER ICON
        ========================================================= */

        .sb-products-page .sb-header-icon {

            position: relative;

            width: 70px;
            height: 70px;

            flex: 0 0 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            color: #fff;

            border-radius: 21px;

            background:
                linear-gradient(
                    145deg,
                    #3b82f6 0%,
                    #2563eb 48%,
                    #1e40af 100%
                );

            box-shadow:
                0 15px 34px rgba(37,99,235,.23);

            font-size: 25px;
        }


        .sb-products-page .sb-header-icon::before {

            content: "";

            position: absolute;

            width: 85px;
            height: 85px;

            top: -48px;
            right: -39px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.14);
        }


        .sb-products-page .sb-header-icon::after {

            content: "";

            position: absolute;

            width: 45px;
            height: 45px;

            bottom: -30px;
            left: -15px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.07);
        }


        .sb-products-page .sb-header-icon i {

            position: relative;
            z-index: 3;
        }


        .sb-products-page .sb-eyebrow {

            margin-bottom: 5px;

            color: var(--p-blue-600);

            font-size: 9px;
            font-weight: 900;

            letter-spacing: 2.2px;

            text-transform: uppercase;
        }


        .sb-products-page .sb-page-title {

            margin: 0;

            color: var(--p-text);

            font-size:
                clamp(25px, 2.3vw, 36px);

            font-weight: 900;

            line-height: 1.12;

            letter-spacing: -.9px;
        }


        .sb-products-page .sb-page-subtitle {

            max-width: 760px;

            margin: 8px 0 0;

            color: var(--p-muted);

            font-size: 11px;

            line-height: 1.65;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .sb-products-page .sb-header-status {

            position: relative;
            z-index: 3;

            display: inline-flex;
            align-items: center;

            gap: 9px;

            flex-shrink: 0;

            padding: 11px 15px;

            color: var(--p-blue-800);

            background: rgba(239,246,255,.92);

            border: 1px solid var(--p-blue-100);
            border-radius: 12px;

            box-shadow:
                0 7px 20px rgba(37,99,235,.06);

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }


        .sb-products-page .sb-header-status-dot {

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--p-blue-600);

            box-shadow:
                0 0 0 4px rgba(37,99,235,.10);
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .sb-products-page .sb-alert {

            width: 100%;

            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 18px;

            padding: 14px 17px;

            border-radius: 14px;

            font-size: 11px;
            font-weight: 700;

            box-shadow:
                0 6px 18px rgba(15,23,42,.04);
        }


        .sb-products-page .sb-alert i {
            flex-shrink: 0;
            font-size: 14px;
        }


        .sb-products-page .sb-alert-success {

            color: var(--p-green-dark);

            background: var(--p-green-bg);

            border:
                1px solid var(--p-green-border);
        }


        .sb-products-page .sb-alert-success i {
            color: var(--p-green);
        }


        .sb-products-page .sb-alert-error {

            color: var(--p-red-dark);

            background: var(--p-red-bg);

            border:
                1px solid var(--p-red-border);
        }


        .sb-products-page .sb-alert-error i {
            color: var(--p-red);
        }


        /* =========================================================
           TOOLBAR
        ========================================================= */

        .sb-products-page .sb-products-toolbar {

            width: 100%;

            min-height: 68px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 20px;
            padding: 12px 14px;

            border:
                1px solid rgba(226,232,240,.95);

            border-radius: 17px;

            background:
                rgba(255,255,255,.94);

            box-shadow:
                0 12px 30px rgba(15,23,42,.055);

            backdrop-filter: blur(18px);
        }


        .sb-products-page .sb-toolbar-left {

            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }


        .sb-products-page .sb-toolbar-icon {

            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--p-blue-600);

            background:
                linear-gradient(
                    145deg,
                    #eff6ff,
                    #f8fbff
                );

            border:
                1px solid var(--p-blue-100);

            border-radius: 12px;

            font-size: 13px;
        }


        .sb-products-page .sb-product-count {

            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--p-muted);

            font-size: 10px;
            font-weight: 600;

            white-space: nowrap;
        }


        .sb-products-page .sb-product-count-label {

            color: var(--p-text-soft);

            font-weight: 800;
        }


        .sb-products-page .sb-product-count strong {

            min-width: 32px;
            height: 26px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 8px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--p-blue-600),
                    var(--p-blue-800)
                );

            border-radius: 8px;

            box-shadow:
                0 5px 13px rgba(37,99,235,.17);

            font-size: 10px;
            font-weight: 900;
        }


        /* =========================================================
           TOOLBAR RIGHT
        ========================================================= */

        .sb-products-page .sb-toolbar-right {

            display: flex;
            align-items: center;

            gap: 13px;

            margin-left: auto;

            min-width: 0;
        }


        .sb-products-page .sb-search-box {

            position: relative;

            width: min(420px, 100%);
        }


        .sb-products-page .sb-search-box > i {

            position: absolute;

            top: 50%;
            left: 15px;

            z-index: 2;

            transform: translateY(-50%);

            color: var(--p-muted-light);

            font-size: 11px;

            pointer-events: none;

            transition:
                color .2s ease;
        }


        .sb-products-page .sb-search-box input {

            width: 100%;
            height: 43px;

            padding:
                0 15px 0 40px;

            outline: none;

            color: var(--p-text);

            background:
                #f8fafc;

            border:
                1px solid var(--p-border);

            border-radius: 12px;

            font-size: 10px;

            transition:
                border-color .2s ease,
                background .2s ease,
                box-shadow .2s ease;
        }


        .sb-products-page .sb-search-box input::placeholder {
            color: var(--p-muted-light);
        }


        .sb-products-page .sb-search-box input:hover {
            background: #fff;
            border-color: #cbd5e1;
        }


        .sb-products-page .sb-search-box input:focus {

            background: #fff;

            border-color: var(--p-blue-500);

            box-shadow:
                0 0 0 4px rgba(37,99,235,.085);
        }


        .sb-products-page .sb-search-box:focus-within > i {
            color: var(--p-blue-600);
        }


        .sb-products-page .sb-search-result {

            display: none;

            color: var(--p-muted);

            font-size: 9px;
            font-weight: 600;

            white-space: nowrap;
        }


        .sb-products-page .sb-search-result.is-visible {
            display: block;
        }


        .sb-products-page .sb-search-result strong {
            color: var(--p-blue-600);
            font-weight: 900;
        }


        /* =========================================================
           GRID
        ========================================================= */

        .sb-products-page .sb-products-grid {

            width: 100%;

            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 18px;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .sb-products-page .sb-product-card {

            position: relative;

            min-width: 0;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            background:
                rgba(255,255,255,.98);

            border:
                1px solid #e2e8f0;

            border-radius: 20px;

            box-shadow:
                0 5px 18px rgba(15,23,42,.045);

            transition:
                transform .28s cubic-bezier(.2,.7,.2,1),
                border-color .28s ease,
                box-shadow .28s ease;
        }


        .sb-products-page .sb-product-card:hover {

            transform:
                translateY(-7px);

            border-color:
                rgba(37,99,235,.26);

            box-shadow:
                0 22px 45px rgba(15,23,42,.085),
                0 12px 32px rgba(37,99,235,.065);
        }


        /* =========================================================
           IMAGE
        ========================================================= */

        .sb-products-page .sb-product-image {

            position: relative;

            width: 100%;

            height: 230px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #f8fafc,
                    #edf2f7
                );
        }


        .sb-products-page .sb-product-image img {

            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition:
                transform .6s cubic-bezier(.2,.7,.2,1);
        }


        .sb-products-page .sb-product-card:hover
        .sb-product-image img {

            transform:
                scale(1.075);
        }


        .sb-products-page .sb-image-overlay {

            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(15,23,42,.02) 0%,
                    transparent 42%,
                    rgba(15,23,42,.18) 100%
                );

            pointer-events: none;
        }


        /* =========================================================
           IMAGE LABEL
        ========================================================= */

        .sb-products-page .sb-image-label {

            position: absolute;

            top: 12px;
            left: 12px;

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            color: var(--p-blue-800);

            background:
                rgba(255,255,255,.94);

            border:
                1px solid rgba(255,255,255,.9);

            border-radius: 10px;

            box-shadow:
                0 8px 20px rgba(15,23,42,.10);

            backdrop-filter: blur(12px);

            font-size: 8px;
            font-weight: 900;

            letter-spacing: .7px;

            text-transform: uppercase;
        }


        .sb-products-page .sb-image-label i {
            color: var(--p-blue-600);
            font-size: 8px;
        }


        /* =========================================================
           STOCK BADGE
        ========================================================= */

        .sb-products-page .sb-stock-badge {

            position: absolute;

            top: 12px;
            right: 12px;

            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 7px 10px;

            color: var(--p-green-dark);

            background:
                rgba(255,255,255,.95);

            border:
                1px solid rgba(187,247,208,.95);

            border-radius: 10px;

            box-shadow:
                0 8px 20px rgba(15,23,42,.10);

            backdrop-filter: blur(12px);

            font-size: 9px;
            font-weight: 900;
        }


        .sb-products-page .sb-stock-badge i {
            color: var(--p-green);
            font-size: 8px;
        }


        /* =========================================================
           NO IMAGE
        ========================================================= */

        .sb-products-page .sb-no-image {

            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #cbd5e1;

            background:
                radial-gradient(
                    circle at center,
                    #ffffff,
                    #eef2f7
                );

            font-size: 43px;
        }


        /* =========================================================
           CARD CONTENT
        ========================================================= */

        .sb-products-page .sb-product-content {

            min-width: 0;

            flex: 1;

            display: flex;
            flex-direction: column;

            padding: 17px;
        }


        /* =========================================================
           CATEGORY
        ========================================================= */

        .sb-products-page .sb-product-category {

            width: fit-content;
            max-width: 100%;

            margin-bottom: 9px;

            padding: 5px 8px;

            overflow: hidden;

            color: var(--p-blue-600);

            background:
                var(--p-blue-50);

            border:
                1px solid rgba(191,219,254,.82);

            border-radius: 7px;

            font-size: 8px;
            font-weight: 900;

            letter-spacing: .8px;

            text-transform: uppercase;

            text-overflow: ellipsis;
            white-space: nowrap;
        }


        /* =========================================================
           PRODUCT NAME
        ========================================================= */

        .sb-products-page .sb-product-name {

            min-height: 43px;

            display: -webkit-box;

            overflow: hidden;

            color: var(--p-text);

            font-size: 14px;
            font-weight: 800;

            line-height: 1.48;

            letter-spacing: -.15px;

            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        /* =========================================================
           PRICE
        ========================================================= */

        .sb-products-page .sb-product-price-row {

            display: flex;
            align-items: baseline;

            flex-wrap: wrap;

            gap: 7px;

            margin-top: 13px;
        }


        .sb-products-page .sb-product-price {

            color: var(--p-blue-800);

            font-size: 20px;
            font-weight: 900;

            line-height: 1;
        }


        .sb-products-page .sb-product-price-label {

            color: var(--p-muted-light);

            font-size: 8px;
            font-weight: 600;
        }


        /* =========================================================
           META
        ========================================================= */

        .sb-products-page .sb-product-meta {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 8px;

            min-height: 49px;

            margin-top: 13px;
            padding-top: 12px;

            border-top:
                1px solid var(--p-border-soft);
        }


        .sb-products-page .sb-meta-item {

            min-width: 0;

            display: flex;
            align-items: center;

            gap: 7px;

            color: var(--p-muted);

            font-size: 8px;
        }


        .sb-products-page .sb-meta-item > i {

            width: 27px;
            height: 27px;

            flex: 0 0 27px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--p-blue-600);

            background:
                var(--p-blue-50);

            border:
                1px solid rgba(219,234,254,.9);

            border-radius: 8px;

            font-size: 9px;
        }


        .sb-products-page .sb-meta-text {

            min-width: 0;

            display: flex;
            flex-direction: column;

            gap: 2px;
        }


        .sb-products-page .sb-meta-label {

            color: var(--p-muted-light);

            font-size: 7px;
            font-weight: 600;
        }


        .sb-products-page .sb-meta-value {

            display: block;

            max-width: 110px;

            overflow: hidden;

            color: var(--p-text-soft);

            font-size: 8px;
            font-weight: 800;

            text-overflow: ellipsis;
            white-space: nowrap;
        }


        /* =========================================================
           ACTIONS
        ========================================================= */

        .sb-products-page .sb-product-actions {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 8px;

            margin-top: 15px;
        }


        .sb-products-page .sb-product-actions form {
            min-width: 0;
        }


        .sb-products-page .sb-action-btn {

            width: 100%;
            min-height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 9px;

            outline: none;

            border-radius: 10px;

            font-size: 9px;
            font-weight: 900;

            cursor: pointer;

            transition:
                transform .2s ease,
                background .2s ease,
                color .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;

            text-decoration: none;
        }


        .sb-products-page .sb-action-btn:focus-visible {

            box-shadow:
                0 0 0 3px rgba(37,99,235,.14);
        }


        /* =========================================================
           EDIT
        ========================================================= */

        .sb-products-page .sb-edit-btn {

            color: var(--p-blue-600);

            background:
                var(--p-blue-50);

            border:
                1px solid var(--p-blue-100);
        }


        .sb-products-page .sb-edit-btn:hover {

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--p-blue-600),
                    var(--p-blue-800)
                );

            border-color:
                var(--p-blue-600);

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 22px rgba(37,99,235,.20);
        }


        /* =========================================================
           DELETE
        ========================================================= */

        .sb-products-page .sb-delete-btn {

            color: var(--p-red);

            background:
                var(--p-red-bg);

            border:
                1px solid var(--p-red-border);
        }


        .sb-products-page .sb-delete-btn:hover {

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #ef4444,
                    #b91c1c
                );

            border-color:
                var(--p-red);

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 22px rgba(220,38,38,.18);
        }


        /* =========================================================
           EMPTY INVENTORY
        ========================================================= */

        .sb-products-page .sb-empty-state {

            grid-column: 1 / -1;

            min-height: 430px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-direction: column;

            padding: 60px 25px;

            text-align: center;

            background:
                rgba(255,255,255,.95);

            border:
                1px dashed #cbd5e1;

            border-radius: 24px;

            box-shadow:
                0 14px 36px rgba(15,23,42,.055);
        }


        .sb-products-page .sb-empty-icon {

            width: 88px;
            height: 88px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 19px;

            color: var(--p-blue-600);

            background:
                linear-gradient(
                    145deg,
                    #eff6ff,
                    #ffffff
                );

            border:
                1px solid var(--p-blue-100);

            border-radius: 25px;

            box-shadow:
                0 14px 32px rgba(37,99,235,.09);

            font-size: 32px;
        }


        .sb-products-page .sb-empty-state h2 {

            margin: 0;

            color: var(--p-text);

            font-size: 19px;
            font-weight: 900;
        }


        .sb-products-page .sb-empty-state p {

            max-width: 510px;

            margin: 8px 0 0;

            color: var(--p-muted);

            font-size: 10px;

            line-height: 1.7;
        }


        .sb-products-page .sb-empty-note {

            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-top: 20px;

            padding: 10px 14px;

            color: var(--p-blue-800);

            background:
                var(--p-blue-50);

            border:
                1px solid var(--p-blue-100);

            border-radius: 10px;

            font-size: 9px;
            font-weight: 800;
        }


        .sb-products-page .sb-empty-note i {
            color: var(--p-blue-600);
            font-size: 9px;
        }


        /* =========================================================
           SEARCH EMPTY
        ========================================================= */

        .sb-products-page .sb-search-empty {

            display: none;

            grid-column: 1 / -1;

            min-height: 350px;

            align-items: center;
            justify-content: center;

            flex-direction: column;

            padding: 50px 20px;

            text-align: center;

            background:
                rgba(255,255,255,.96);

            border:
                1px solid var(--p-border);

            border-radius: 23px;

            box-shadow:
                0 14px 36px rgba(15,23,42,.055);
        }


        .sb-products-page .sb-search-empty.is-visible {
            display: flex;
        }


        .sb-products-page .sb-search-empty-icon {

            width: 70px;
            height: 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 16px;

            color: var(--p-blue-500);

            background:
                var(--p-blue-50);

            border:
                1px solid var(--p-blue-100);

            border-radius: 20px;

            font-size: 25px;
        }


        .sb-products-page .sb-search-empty h3 {

            margin: 0;

            color: var(--p-text-soft);

            font-size: 16px;
            font-weight: 900;
        }


        .sb-products-page .sb-search-empty p {

            margin: 7px 0 0;

            color: var(--p-muted);

            font-size: 10px;
        }


        /* =========================================================
           HIDDEN PRODUCT
        ========================================================= */

        .sb-products-page .sb-product-card.is-hidden {
            display: none !important;
        }


        /* =========================================================
           LARGE DESKTOP
        ========================================================= */

        @media (max-width: 1650px) {

            .sb-products-page .sb-products-grid {
                grid-template-columns:
                    repeat(5, minmax(0, 1fr));
            }
        }


        /* =========================================================
           DESKTOP
        ========================================================= */

        @media (max-width: 1320px) {

            .sb-products-page {
                padding-left: 15px;
                padding-right: 15px;
            }

            .sb-products-page .sb-products-grid {
                grid-template-columns:
                    repeat(4, minmax(0, 1fr));

                gap: 16px;
            }

            .sb-products-page .sb-product-image {
                height: 220px;
            }

            .sb-products-page .sb-header-status {
                display: none;
            }
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 980px) {

            .sb-products-page {
                padding-top: 20px;
            }

            .sb-products-page .sb-products-header {
                min-height: 135px;
                padding: 23px;
            }

            .sb-products-page .sb-products-grid {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

                gap: 15px;
            }

            .sb-products-page .sb-product-image {
                height: 215px;
            }

            .sb-products-page .sb-products-toolbar {
                flex-wrap: wrap;
            }

            .sb-products-page .sb-toolbar-right {

                width: 100%;

                margin-left: 0;
            }

            .sb-products-page .sb-search-box {
                width: 100%;
            }
        }


        /* =========================================================
           SMALL TABLET
        ========================================================= */

        @media (max-width: 760px) {

            .sb-products-page .sb-products-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .sb-products-page .sb-product-image {
                height: 235px;
            }
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 600px) {

            .sb-products-page {

                padding:
                    14px 9px 30px;
            }

            .sb-products-page .sb-products-header {

                align-items: flex-start;

                flex-direction: column;

                gap: 14px;

                min-height: auto;

                margin-bottom: 14px;

                padding: 18px;

                border-radius: 19px;
            }

            .sb-products-page .sb-header-left {

                width: 100%;

                align-items: flex-start;

                gap: 13px;
            }

            .sb-products-page .sb-header-icon {

                width: 53px;
                height: 53px;

                flex-basis: 53px;

                border-radius: 16px;

                font-size: 19px;
            }

            .sb-products-page .sb-eyebrow {

                margin-bottom: 4px;

                font-size: 7px;

                letter-spacing: 1.5px;
            }

            .sb-products-page .sb-page-title {
                font-size: 22px;
            }

            .sb-products-page .sb-page-subtitle {

                margin-top: 5px;

                font-size: 9px;
            }

            .sb-products-page .sb-alert {

                margin-bottom: 14px;

                padding: 12px 13px;

                border-radius: 12px;

                font-size: 9px;
            }

            .sb-products-page .sb-products-toolbar {

                align-items: stretch;

                flex-direction: column;

                gap: 10px;

                margin-bottom: 14px;

                padding: 12px;

                border-radius: 15px;
            }

            .sb-products-page .sb-toolbar-left {
                width: 100%;
            }

            .sb-products-page .sb-toolbar-right {

                display: flex;

                flex-direction: column;

                align-items: stretch;

                gap: 7px;

                width: 100%;
            }

            .sb-products-page .sb-search-box {
                width: 100%;
            }

            .sb-products-page .sb-products-grid {

                grid-template-columns:
                    1fr;

                gap: 14px;
            }

            .sb-products-page .sb-product-card {
                border-radius: 18px;
            }

            .sb-products-page .sb-product-image {
                height: 260px;
            }

            .sb-products-page .sb-product-content {
                padding: 16px;
            }

            .sb-products-page .sb-product-name {
                font-size: 15px;
            }

            .sb-products-page .sb-product-price {
                font-size: 21px;
            }

            .sb-products-page .sb-empty-state {

                min-height: 350px;

                padding: 42px 18px;

                border-radius: 19px;
            }
        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 390px) {

            .sb-products-page {
                padding-left: 7px;
                padding-right: 7px;
            }

            .sb-products-page .sb-products-header {
                padding: 15px;
            }

            .sb-products-page .sb-header-left {
                gap: 10px;
            }

            .sb-products-page .sb-header-icon {

                width: 45px;
                height: 45px;

                flex-basis: 45px;

                border-radius: 13px;

                font-size: 16px;
            }

            .sb-products-page .sb-page-title {
                font-size: 19px;
            }

            .sb-products-page .sb-page-subtitle {
                font-size: 8px;
            }

            .sb-products-page .sb-toolbar-icon {

                width: 35px;
                height: 35px;

                flex-basis: 35px;
            }

            .sb-products-page .sb-product-image {
                height: 225px;
            }

            .sb-products-page .sb-product-content {
                padding: 14px;
            }

            .sb-products-page .sb-action-btn {

                min-height: 38px;

                font-size: 8px;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .sb-products-page *,
            .sb-products-page *::before,
            .sb-products-page *::after {

                scroll-behavior: auto !important;

                transition: none !important;

                animation: none !important;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     ORDER PAGE KE EXACT SAME COMMON SELLER TOPBAR
     DO NOT ADD ANY PAGE-LEVEL TASKBAR HERE
========================================================= --}}

@include('seller.partials.topbar')


{{-- =========================================================
     ORDER PAGE KE EXACT SAME COMMON SELLER MENU
     DO NOT ADD ANY PAGE-LEVEL MENU HERE
========================================================= --}}

@include('seller.partials.seller-menu')


<main class="sb-products-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <header class="sb-products-header">

        <div class="sb-header-left">

            <div class="sb-header-icon">

                <i class="fa-solid fa-boxes-stacked"></i>

            </div>


            <div>

                <div class="sb-eyebrow">
                    Seller Inventory
                </div>


                <h1 class="sb-page-title">
                    My Products
                </h1>


                <p class="sb-page-subtitle">
                    Manage, monitor and maintain all products listed
                    under your SMART BASKET seller account.
                </p>

            </div>

        </div>


        <div class="sb-header-status">

            <span class="sb-header-status-dot"></span>

            Product Management

        </div>

    </header>


    {{-- =====================================================
         SUCCESS ALERT
    ====================================================== --}}

    @if(session('success'))

        <div class="sb-alert sb-alert-success">

            <i class="fa-solid fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         ERROR ALERT
    ====================================================== --}}

    @if(session('error'))

        <div class="sb-alert sb-alert-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         INVENTORY TOOLBAR
    ====================================================== --}}

    <section class="sb-products-toolbar">


        <div class="sb-toolbar-left">

            <div class="sb-toolbar-icon">

                <i class="fa-solid fa-cubes-stacked"></i>

            </div>


            <div class="sb-product-count">

                <span class="sb-product-count-label">
                    Your Products
                </span>

                <strong>
                    {{ $products->count() }}
                </strong>

            </div>

        </div>


        <div class="sb-toolbar-right">


            <div class="sb-search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="productSearch"
                    placeholder="Search by product name or category..."
                    autocomplete="off"
                    aria-label="Search products"
                >

            </div>


            @if($products->count() > 0)

                <div
                    class="sb-search-result"
                    id="searchResultCount"
                >

                    Showing

                    <strong id="visibleProductCount">
                        {{ $products->count() }}
                    </strong>

                    products

                </div>

            @endif


        </div>


    </section>


    {{-- =====================================================
         PRODUCTS GRID
    ====================================================== --}}

    <section
        class="sb-products-grid"
        id="productsGrid"
        aria-live="polite"
    >


        @forelse($products as $product)


            <article
                class="sb-product-card"
                data-product-name="{{ strtolower($product->name) }}"
                data-product-category="{{ strtolower($product->category) }}"
            >


                {{-- =================================================
                     PRODUCT IMAGE
                ================================================== --}}

                <div class="sb-product-image">


                    @if($product->image)

                        <img
                            src="{{ asset('products/'.$product->image) }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                        >

                        <div class="sb-image-overlay"></div>

                    @else

                        <div class="sb-no-image">

                            <i class="fa-regular fa-image"></i>

                        </div>

                    @endif


                    <div class="sb-image-label">

                        <i class="fa-solid fa-box"></i>

                        Product

                    </div>


                    <div class="sb-stock-badge">

                        <i class="fa-solid fa-cubes"></i>

                        {{ $product->stock }} Stock

                    </div>


                </div>


                {{-- =================================================
                     PRODUCT CONTENT
                ================================================== --}}

                <div class="sb-product-content">


                    <div class="sb-product-category">

                        {{ $product->category }}

                    </div>


                    <div class="sb-product-name">

                        {{ $product->name }}

                    </div>


                    <div class="sb-product-price-row">

                        <div class="sb-product-price">

                            ₹{{ number_format((float) $product->price, 2) }}

                        </div>


                        <div class="sb-product-price-label">

                            selling price

                        </div>

                    </div>


                    <div class="sb-product-meta">


                        {{-- STOCK --}}

                        <div class="sb-meta-item">

                            <i class="fa-solid fa-box"></i>


                            <div class="sb-meta-text">

                                <span class="sb-meta-label">
                                    Available Stock
                                </span>

                                <strong class="sb-meta-value">
                                    {{ $product->stock }} units
                                </strong>

                            </div>

                        </div>


                        {{-- BRAND / CATEGORY --}}

                        @if(isset($product->brand) && $product->brand)

                            <div class="sb-meta-item">

                                <i class="fa-solid fa-tag"></i>


                                <div class="sb-meta-text">

                                    <span class="sb-meta-label">
                                        Brand
                                    </span>

                                    <strong
                                        class="sb-meta-value"
                                        title="{{ $product->brand }}"
                                    >
                                        {{ $product->brand }}
                                    </strong>

                                </div>

                            </div>

                        @else

                            <div class="sb-meta-item">

                                <i class="fa-solid fa-layer-group"></i>


                                <div class="sb-meta-text">

                                    <span class="sb-meta-label">
                                        Category
                                    </span>

                                    <strong
                                        class="sb-meta-value"
                                        title="{{ $product->category }}"
                                    >
                                        {{ $product->category }}
                                    </strong>

                                </div>

                            </div>

                        @endif


                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="sb-product-actions">


                        {{-- EDIT --}}

                        <a
                            href="{{ route('seller.product.edit', $product->id) }}"
                            class="sb-action-btn sb-edit-btn"
                            aria-label="Edit {{ $product->name }}"
                        >

                            <i class="fa-solid fa-pen-to-square"></i>

                            Edit

                        </a>


                        {{-- DELETE --}}

                        <form
                            action="{{ route('seller.product.delete', $product->id) }}"
                            method="POST"
                            style="margin:0;"
                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="sb-action-btn sb-delete-btn"
                                aria-label="Delete {{ $product->name }}"
                            >

                                <i class="fa-solid fa-trash-can"></i>

                                Delete

                            </button>

                        </form>


                    </div>


                </div>


            </article>


        @empty


            {{-- =================================================
                 EMPTY INVENTORY
            ================================================== --}}

            <div class="sb-empty-state">


                <div class="sb-empty-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>


                <h2>
                    No Products Added Yet
                </h2>


                <p>
                    Your product inventory is currently empty.
                    Use the Seller Taskbar/Menu to add and manage
                    products for your SMART BASKET store.
                </p>


                <div class="sb-empty-note">

                    <i class="fa-solid fa-compass"></i>

                    Manage products from the Seller Taskbar

                </div>


            </div>


        @endforelse


        {{-- =================================================
             SEARCH EMPTY RESULT
        ================================================== --}}

        @if($products->count() > 0)

            <div
                class="sb-search-empty"
                id="searchEmpty"
            >

                <div class="sb-search-empty-icon">

                    <i class="fa-solid fa-magnifying-glass"></i>

                </div>


                <h3>
                    No Products Found
                </h3>


                <p>
                    Try another product name or category.
                </p>

            </div>

        @endif


    </section>


</main>


<script>

document.addEventListener('DOMContentLoaded', function () {


    const searchInput =
        document.getElementById('productSearch');


    const products =
        document.querySelectorAll('.sb-product-card');


    const searchEmpty =
        document.getElementById('searchEmpty');


    const searchResultCount =
        document.getElementById('searchResultCount');


    const visibleProductCount =
        document.getElementById('visibleProductCount');


    if (!searchInput) {
        return;
    }


    function filterProducts() {


        const search =
            searchInput.value
                .toLowerCase()
                .trim();


        let visibleProducts = 0;


        products.forEach(function (product) {


            const name =
                product.dataset.productName || '';


            const category =
                product.dataset.productCategory || '';


            const match =
                search === '' ||
                name.includes(search) ||
                category.includes(search);


            if (match) {

                product.classList.remove('is-hidden');

                visibleProducts++;

            } else {

                product.classList.add('is-hidden');

            }

        });


        /* =========================================
           RESULT COUNT
        ========================================= */

        if (visibleProductCount) {

            visibleProductCount.textContent =
                visibleProducts;

        }


        if (searchResultCount) {

            searchResultCount.classList.toggle(
                'is-visible',
                search.length > 0
            );

        }


        /* =========================================
           SEARCH EMPTY
        ========================================= */

        if (searchEmpty) {

            searchEmpty.classList.toggle(
                'is-visible',
                search.length > 0 &&
                visibleProducts === 0
            );

        }

    }


    searchInput.addEventListener(
        'input',
        filterProducts
    );


    filterProducts();

});

</script>


</body>

</html>

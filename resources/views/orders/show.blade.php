<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Order #{{ $order->id }} | SMART BASKET
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">

    <style>

        /* ==========================================================
           SMART BASKET ORDER PAGE
        ========================================================== */

        :root {

            --order-bg: #f5f8fc;
            --order-bg-secondary: #eef3f9;
            --order-card: #ffffff;
            --order-surface: #f8fafc;

            --order-text: #334155;
            --order-heading: #0f172a;
            --order-muted: #64748b;

            --order-border: rgba(15,23,42,.09);
            --order-border-strong: rgba(37,99,235,.18);

            --order-primary: #2563eb;
            --order-primary-hover: #1d4ed8;
            --order-primary-soft: rgba(37,99,235,.08);

            --order-purple: #6366f1;

            --order-success: #16a34a;
            --order-warning: #f59e0b;
            --order-danger: #dc2626;

            --topbar-bg: #07111f;
            --topbar-border: rgba(59,130,246,.18);

            --order-shadow:
                0 20px 60px rgba(15,23,42,.09);

            --order-header-shadow:
                0 25px 75px rgba(15,23,42,.11);
        }


        /* ==========================================================
           DARK THEME
        ========================================================== */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --order-bg: #050b18;
            --order-bg-secondary: #081120;
            --order-card: #0b1426;
            --order-surface: #101d33;

            --order-text: #cbd5e1;
            --order-heading: #f8fbff;
            --order-muted: #94a3b8;

            --order-border: rgba(96,165,250,.15);
            --order-border-strong: rgba(59,130,246,.35);

            --order-primary: #3b82f6;
            --order-primary-hover: #60a5fa;
            --order-primary-soft: rgba(59,130,246,.12);

            --order-purple: #6366f1;

            --order-success: #22c55e;
            --order-warning: #f59e0b;
            --order-danger: #ef4444;

            --topbar-bg: #030914;
            --topbar-border: rgba(59,130,246,.22);

            --order-shadow:
                0 25px 80px rgba(0,0,0,.52);

            --order-header-shadow:
                0 30px 90px rgba(0,0,0,.60);
        }


        /* ==========================================================
           RESET
        ========================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {

            margin: 0;
            padding: 0;

            min-height: 100%;

            scroll-behavior: smooth;
        }


        /* ==========================================================
           BODY
        ========================================================== */

        body {

            color: var(--order-text);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: var(--order-bg);

            transition:
                background .3s ease,
                color .3s ease;

            /*
            Top taskbar ki height ke liye space.
            */
            padding-top: 0;
        }


        /* ==========================================================
           BACKGROUND
        ========================================================== */

        html[data-sb-theme="light"] body,
        body[data-sb-theme="light"] {

            background:

                radial-gradient(
                    circle at 5% 0%,
                    rgba(37,99,235,.10),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 5%,
                    rgba(99,102,241,.08),
                    transparent 30%
                ),

                var(--order-bg);
        }


        html[data-sb-theme="dark"] body,
        body[data-sb-theme="dark"] {

            background:

                radial-gradient(
                    circle at 8% 0%,
                    rgba(37,99,235,.20),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 92% 8%,
                    rgba(59,130,246,.11),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(30,64,175,.08),
                    transparent 35%
                ),

                #050b18;
        }


        /* ==========================================================
           EXACT CUSTOMER TASKBAR â€” SAME AS ORDERS/CART/PRODUCTS
        ========================================================== */

/* =========================================================
   PRODUCTS PAGE â€” FULL WIDTH PREMIUM TASKBAR
========================================================= */
























/* AI HUB left button: existing project component remains the single left-side AI HUB launcher */
.ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}
html[data-theme="light"] .ai-hub-drawer{background:linear-gradient(145deg,rgba(255,255,255,.99),rgba(242,246,252,.99))!important;color:#101828!important;border-right-color:rgba(37,99,235,.14)!important;box-shadow:24px 0 70px rgba(15,23,42,.20)!important}
html[data-theme="light"] .ai-hub-drawer-header strong,html[data-theme="light"] .ai-hub-tool-text strong{color:#101828!important}html[data-theme="light"] .ai-hub-drawer-header small,html[data-theme="light"] .ai-hub-tool-text small{color:#667085!important}
html[data-theme="light"] .ai-hub-fab{background:linear-gradient(145deg,#fff,#eef4ff)!important;color:#172033!important;border-color:rgba(37,99,235,.25)!important}
html[data-theme="dark"] .ai-hub-drawer{background:linear-gradient(145deg,#09111f,#020711)!important}html[data-theme="dark"] .ai-hub-fab{background:linear-gradient(145deg,#1e293b,#050a14)!important}

/* Robot launcher is hidden; its original panel remains fully functional */








        /* ==========================================================
           PAGE
        ========================================================== */

        .order-page {

            min-height: 100vh;

            padding:
                35px 15px 100px;

            background: transparent;
        }


        .order-container {

            width: 100%;

            max-width: none;

            margin: 0;
        }


        /* ==========================================================
           TOP PAGE BAR
        ========================================================== */

        .order-topbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 25px;
        }


        .back-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 10px 16px;

            border:
                1px solid
                var(--order-border);

            border-radius: 12px;

            color: var(--order-text);

            background: var(--order-card);

            text-decoration: none;

            font-size: 13px;

            font-weight: 800;

            box-shadow:
                0 10px 30px
                rgba(15,23,42,.07);

            transition: all .22s ease;
        }


        .back-btn:hover {

            color: var(--order-primary);

            background:
                var(--order-primary-soft);

            border-color:
                var(--order-primary);

            transform:
                translateY(-2px);
        }


        .secure-pill {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 9px 14px;

            border-radius: 999px;

            color: var(--order-success);

            background:
                rgba(34,197,94,.08);

            border:
                1px solid
                rgba(34,197,94,.18);

            font-size: 11px;

            font-weight: 850;
        }


        /* ==========================================================
           ORDER HEADER
        ========================================================== */

        .order-header {

            position: relative;

            overflow: hidden;

            padding: 30px;

            margin-bottom: 25px;

            border:
                1px solid
                var(--order-border);

            border-radius: 25px;

            background:
                var(--order-card);

            box-shadow:
                var(--order-header-shadow);

            backdrop-filter:
                blur(25px);

            transition:
                all .3s ease;
        }


        .order-header::before {
            content: none;
        }


        .order-label {

            color: var(--order-primary);

            font-size: 11px;

            font-weight: 850;

            text-transform: uppercase;

            letter-spacing: 1.4px;
        }


        .order-title {

            margin:
                6px 0 5px;

            color:
                var(--order-heading);

            font-size: 31px;

            font-weight: 950;

            letter-spacing: -.8px;
        }


        .order-date {

            color:
                var(--order-muted);

            font-size: 13px;
        }


        .order-status {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 15px;

            padding: 9px 15px;

            border-radius: 999px;

            color: var(--order-primary);

            background:
                var(--order-primary-soft);

            border:
                1px solid
                var(--order-border-strong);

            font-size: 12px;

            font-weight: 850;
        }


        .status-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: currentColor;

            box-shadow:
                0 0 0 4px
                rgba(59,130,246,.12);
        }


        /* ==========================================================
           PREMIUM CARD
        ========================================================== */

        .premium-card {

            overflow: hidden;

            border:
                1px solid
                var(--order-border);

            border-radius: 24px;

            background:
                var(--order-card);

            box-shadow:
                var(--order-shadow);

            backdrop-filter:
                blur(22px);

            transition:
                border-color .25s ease,
                box-shadow .25s ease,
                transform .25s ease;
        }


        .premium-card:hover {

            border-color:
                var(--order-border-strong);

            box-shadow:
                var(--order-header-shadow);
        }


        .card-header-premium {

            padding:
                20px 22px;

            border-bottom:
                1px solid
                var(--order-border);

            background:
                var(--order-surface);
        }


        .card-title {

            display: flex;

            align-items: center;

            gap: 10px;

            margin: 0;

            color:
                var(--order-heading);

            font-size: 16px;

            font-weight: 900;
        }


        .card-icon {

            width: 36px;

            height: 36px;

            display: grid;

            place-items: center;

            border-radius: 11px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 9px 25px
                rgba(37,99,235,.28);

            font-size: 14px;
        }


        .card-body-premium {

            padding: 22px;
        }


        /* ==========================================================
           PRODUCT
        ========================================================== */

        .product-row {

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 14px;

            margin-bottom: 12px;

            border:
                1px solid
                var(--order-border);

            border-radius: 17px;

            background:
                var(--order-surface);

            transition: all .22s ease;
        }


        .product-row:last-child {

            margin-bottom: 0;
        }


        .product-row:hover {

            transform:
                translateX(3px);

            border-color:
                var(--order-border-strong);

            background:
                var(--order-primary-soft);
        }


        .product-image {

            width: 75px;

            height: 75px;

            flex-shrink: 0;

            object-fit: cover;

            border-radius: 14px;

            border:
                1px solid
                var(--order-border);

            background:
                var(--order-bg-secondary);
        }


        .product-info {

            flex: 1;
        }


        .product-name {

            margin-bottom: 5px;

            color:
                var(--order-heading);

            font-size: 14px;

            font-weight: 850;
        }


        .product-meta {

            color:
                var(--order-muted);

            font-size: 12px;

            line-height: 1.6;
        }


        .product-total {

            color:
                var(--order-primary);

            font-size: 14px;

            font-weight: 900;

            white-space: nowrap;
        }


        /* ==========================================================
           TOTAL
        ========================================================== */

        .total-box {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-top: 18px;

            padding: 18px;

            border:
                1px solid
                var(--order-border-strong);

            border-radius: 17px;

            background:
                linear-gradient(
                    135deg,
                    var(--order-primary-soft),
                    rgba(99,102,241,.06)
                );
        }


        .total-label {

            color:
                var(--order-primary);

            font-size: 11px;

            font-weight: 800;

            letter-spacing: .6px;
        }


        .total-amount {

            color:
                var(--order-heading);

            font-size: 23px;

            font-weight: 950;
        }


        /* ==========================================================
           DETAIL
        ========================================================== */

        .detail-row {

            display: flex;

            align-items: flex-start;

            gap: 12px;

            padding: 13px 0;

            border-bottom:
                1px solid
                var(--order-border);
        }


        .detail-row:last-child {

            border-bottom: 0;

            padding-bottom: 0;
        }


        .detail-icon {

            width: 35px;

            height: 35px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 10px;

            color:
                var(--order-primary);

            background:
                var(--order-primary-soft);

            border:
                1px solid
                var(--order-border);

            font-size: 13px;
        }


        .detail-label {

            color:
                var(--order-muted);

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .5px;
        }


        .detail-value {

            margin-top: 3px;

            color:
                var(--order-heading);

            font-size: 13px;

            font-weight: 750;
        }


        /* ==========================================================
           DELIVERY PARTNER
        ========================================================== */

        .partner-box {

            display: flex;

            align-items: center;

            gap: 14px;

            padding: 15px;

            border:
                1px solid
                var(--order-border);

            border-radius: 17px;

            background:
                var(--order-surface);
        }


        .partner-image {

            width: 62px;

            height: 62px;

            object-fit: cover;

            border-radius: 15px;

            border:
                1px solid
                var(--order-border);

            background:
                var(--order-bg-secondary);
        }


        .partner-name {

            color:
                var(--order-heading);

            font-size: 14px;

            font-weight: 900;
        }


        .partner-meta {

            margin-top: 4px;

            color:
                var(--order-muted);

            font-size: 11px;
        }


        /* ==========================================================
           LOCATION
        ========================================================== */

        .tracking-location {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 25px;

            padding: 16px;

            border:
                1px solid
                var(--order-border-strong);

            border-radius: 17px;

            background:
                var(--order-primary-soft);
        }


        .location-icon {

            width: 43px;

            height: 43px;

            display: grid;

            place-items: center;

            flex-shrink: 0;

            border-radius: 13px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 10px 28px
                rgba(37,99,235,.30);
        }


        .location-label {

            color:
                var(--order-muted);

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;
        }


        .location-value {

            margin-top: 3px;

            color:
                var(--order-heading);

            font-size: 13px;

            font-weight: 850;
        }


        /* ==========================================================
           TIMELINE
        ========================================================== */

        .timeline {

            position: relative;

            margin: 0;

            padding:
                5px 0 5px 35px;

            list-style: none;
        }


        .timeline::before {

            content: "";

            position: absolute;

            left: 10px;

            top: 13px;

            bottom: 13px;

            width: 2px;

            background:
                var(--order-border);
        }


        .timeline-item {

            position: relative;

            min-height: 50px;

            padding:
                2px 0 22px;
        }


        .timeline-item:last-child {

            padding-bottom: 0;
        }


        .timeline-dot {

            position: absolute;

            left: -31px;

            top: 2px;

            width: 22px;

            height: 22px;

            display: grid;

            place-items: center;

            border-radius: 50%;

            color:
                var(--order-muted);

            background:
                var(--order-card);

            border:
                2px solid
                var(--order-border);

            font-size: 8px;

            z-index: 2;
        }


        .timeline-item.active
        .timeline-dot {

            color: #ffffff;

            background:
                var(--order-primary);

            border-color:
                var(--order-primary);

            box-shadow:
                0 0 0 5px
                rgba(59,130,246,.14);
        }


        .timeline-name {

            color:
                var(--order-muted);

            font-size: 12px;

            font-weight: 700;
        }


        .timeline-item.active
        .timeline-name {

            color:
                var(--order-heading);

            font-weight: 900;
        }


        /* ==========================================================
           CANCEL
        ========================================================== */

        .cancel-box {

            margin-top: 18px;

            padding: 18px;

            border:
                1px solid
                rgba(220,38,38,.18);

            border-radius: 17px;

            background:
                rgba(220,38,38,.05);
        }

        .return-order-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 0 21px;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 15px;
            background: linear-gradient(115deg,#087d70,#2363d2 58%,#6746c5);
            box-shadow: 0 11px 24px rgba(35,94,177,.22), inset 0 1px 0 rgba(255,255,255,.22);
            color: #fff !important;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none !important;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .return-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(35,94,177,.3), inset 0 1px 0 rgba(255,255,255,.26);
        }

        .return-order-btn:focus-visible {
            outline: 3px solid #86d9d0;
            outline-offset: 3px;
        }

        .return-request-panel {
            border-color: rgba(37,99,180,.2);
            border-radius: 20px;
            background: linear-gradient(135deg,rgba(37,99,180,.055),rgba(14,139,125,.06));
            box-shadow: 0 12px 30px rgba(28,58,110,.06);
        }



        .cancel-title {

            color:
                var(--order-heading);

            font-size: 13px;

            font-weight: 850;
        }


        .cancel-description {

            margin-top: 4px;

            color:
                var(--order-muted);

            font-size: 11px;
        }


        .cancel-btn {

            margin-top: 12px;

            border:
                1px solid
                rgba(220,38,38,.28);

            border-radius: 11px;

            color:
                var(--order-danger);

            background: transparent;

            padding:
                9px 13px;

            font-size: 11px;

            font-weight: 850;

            transition: all .2s ease;
        }


        .cancel-btn:hover {

            color: #ffffff;

            background:
                var(--order-danger);

            border-color:
                var(--order-danger);

            transform:
                translateY(-1px);
        }


        .muted-text {

            color:
                var(--order-muted);

            font-size: 12px;
        }


        /* ==========================================================
           BOOTSTRAP DARK OVERRIDES
        ========================================================== */

        html[data-sb-theme="dark"] .text-dark,
        body[data-sb-theme="dark"] .text-dark {

            color:
                var(--order-heading) !important;
        }


        html[data-sb-theme="dark"] .bg-white,
        body[data-sb-theme="dark"] .bg-white {

            background:
                var(--order-card) !important;
        }


        html[data-sb-theme="dark"] .border,
        body[data-sb-theme="dark"] .border {

            border-color:
                var(--order-border) !important;
        }


        /* ==========================================================
           MOBILE TOPBAR
        ========================================================== */

        @media (max-width: 1100px) {

            .sb-brand {

                width: 170px;

                min-width: 170px;
            }


            .sb-nav-item {

                min-width: 80px;

                padding:
                    0 10px;
            }


            .sb-nav-item span {

                display: none;
            }


            .sb-smart-ai {

                min-width: 52px;

                width: 52px;

                padding: 0;
            }


            .sb-smart-ai-text {

                display: none;
            }


            .sb-user-box {

                min-width: 52px;

                width: 52px;

                padding: 0;

                justify-content: center;
            }



        }


        @media (max-width: 767px) {

            body {

                padding-top: 68px;
            }


            .sb-topbar {

                height: 68px;

                padding:
                    8px 10px;

                gap: 7px;

                overflow: hidden;
            }


            .sb-brand {

                width: 48px;

                min-width: 48px;

                height: 48px;
            }


            .sb-brand-logo {

                width: 42px;

                height: 42px;

                border-radius: 12px;

                font-size: 18px;
            }


            .sb-brand-content {

                display: none;
            }


            .sb-topnav {

                gap: 5px;

                overflow: hidden;
            }


            .sb-nav-item {

                flex: 0 0 44px;

                width: 44px;

                min-width: 44px;

                height: 44px;

                padding: 0;

                border-radius: 12px;
            }


            .sb-nav-item span {

                display: none;
            }


            .sb-nav-item i {

                font-size: 13px;
            }


            .sb-smart-ai {

                flex: 0 0 44px;

                width: 44px;

                min-width: 44px;

                height: 44px;

                padding: 0;

                border-radius: 12px;
            }


            .sb-smart-ai-icon {

                width: 27px;

                height: 27px;
            }


            .sb-smart-ai-text,
            .sb-ai-online-dot {

                display: none;
            }


            .sb-user-box {

                flex: 0 0 44px;

                width: 44px;

                min-width: 44px;

                height: 44px;

                padding: 0;

                justify-content: center;

                border-radius: 12px;
            }





            .sb-three-dot-btn {

                width: 44px;

                height: 44px;

                border-radius: 12px;
            }


            .sb-menu-popup {

                top: 62px;

                right: 10px;

                width: 285px;
            }


            .order-page {

                padding:
                    20px 10px 80px;
            }


            .order-topbar {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .secure-pill {

                align-self:
                    flex-start;
            }


            .order-header {

                padding:
                    23px 18px;

                border-radius:
                    21px;
            }


            .order-title {

                font-size:
                    26px;
            }


            .card-header-premium,
            .card-body-premium {

                padding:
                    18px;
            }


            .product-row {

                align-items:
                    flex-start;
            }


            .product-image {

                width:
                    62px;

                height:
                    62px;
            }


            .product-total {

                font-size:
                    12px;
            }


            .total-box {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .total-amount {

                font-size:
                    20px;
            }
        }


/* =========================================================
   FINAL ORDER SHOW TASKBAR SAFETY OVERRIDES
   Keeps the customer taskbar full-width and above all order UI.
========================================================= */
body{
    padding-top:0 !important;
}



@media(max-width:767px){
    body{padding-top:0 !important;}

}
.live-map-card{margin:22px 0 26px;padding:17px;border:1px solid var(--order-border);border-radius:18px;background:var(--order-surface)}.live-map-heading{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:13px}.live-map-heading strong{display:block;color:var(--order-heading);font-size:15px}.live-map-heading small{display:block;margin-top:4px;color:var(--order-muted);font-size:12px}.live-map-pulse{display:flex;align-items:center;gap:6px;color:#16a36a;font-size:10px;font-weight:800;letter-spacing:.12em}.live-map-pulse i{width:7px;height:7px;border-radius:50%;background:#20c982;box-shadow:0 0 0 4px rgba(32,201,130,.14);animation:livePulse 1.5s infinite}.live-map-pulse.is-ended{color:#77839a}.live-map-pulse.is-ended i{background:#9aa5b5;box-shadow:none;animation:none}.live-map-card #deliveryLiveMap{height:310px;overflow:hidden;border:1px solid var(--order-border);border-radius:13px;background:#dbeafe;z-index:0}.live-map-foot{display:flex;gap:7px;margin-top:11px;color:var(--order-muted);font-size:11px}.live-map-unavailable{display:flex;align-items:center;gap:11px;margin:18px 0;padding:15px;border:1px dashed var(--order-border-strong);border-radius:14px;color:var(--order-muted);font-size:13px}.live-map-unavailable i{color:var(--order-primary);font-size:18px}@keyframes livePulse{50%{box-shadow:0 0 0 7px rgba(32,201,130,0)}}
    .live-map-coordinates{display:flex;align-items:center;gap:12px;min-height:108px;padding:20px;border:1px solid var(--order-border);border-radius:13px;background:linear-gradient(125deg,rgba(37,99,235,.08),rgba(34,197,94,.07));color:var(--order-heading);font:600 14px/1.6 ui-monospace,monospace}.live-map-coordinates i{color:var(--order-primary);font-size:25px}
</style>

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>


@php

    /* ==========================================================
       CUSTOMER THEME
    ========================================================== */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'light')
        : 'light';


    if (!in_array(
        $customerTheme,
        ['dark', 'light', 'system'],
        true
    )) {

        $customerTheme = 'light';

    }


    /* ==========================================================
       TRACKING STEPS
    ========================================================== */

    $steps = [

        'Order Placed',

        'Seller Confirmed',

        'Packed',

        'Picked By Delivery Partner',

        'Out For Delivery',

        'Near Customer',

        'Delivered'

    ];


    $current =
        $order->deliveryDetail?->status
        ?? $order->order_status
        ?? 'Order Placed';


    $currentIndex =
        array_search(
            $current,
            $steps,
            true
        );


    if ($currentIndex === false) {

        $currentIndex = 0;

    }


    /* ==========================================================
       ORDER TOTAL
    ========================================================== */

    $orderTotal = 0;


    foreach ($order->items ?? [] as $item) {

        $price =
            (float) ($item['price'] ?? 0);

        $quantity =
            (int) ($item['quantity'] ?? 1);

        $orderTotal +=
            $price * $quantity;

    }

@endphp


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


@auth
{{-- =========================================================
     SMART BASKET â€” PRODUCTS PAGE PREMIUM CUSTOMER TASKBAR
     Core navigation is kept here so this page has ONE taskbar.
========================================================= --}}
@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
@endphp

<x-products-customer-taskbar :include-robot="false" />
@endauth


<!-- ==============================================================
     ORDER PAGE
=============================================================== -->

<main class="order-page">

    <div class="order-container">


        <!-- TOP PAGE BAR -->

        <div class="order-topbar">






        </div>


        <!-- ORDER HEADER -->

        <section class="order-header">

            <div class="order-label">
                SMART BASKET ORDER
            </div>


            <x-customer-page-hero>
<h1 class="order-title sb-customer-page-title">

                Order #{{ $order->id }}

            </h1>
</x-customer-page-hero>


            <div class="order-date">

                <i class="fa-regular fa-calendar"></i>

                Order tracking & details

            </div>


            <div class="order-status">

                <span class="status-dot"></span>

                {{ $current }}

            </div>

        </section>


        <!-- MAIN GRID -->

        <div class="row g-4">


            <!-- ==================================================
                 LEFT
            =================================================== -->

            <div class="col-lg-7">


                <!-- ORDER ITEMS -->

                <section class="premium-card">

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-box"></i>

                            </span>

                            Order Items

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        @forelse($order->items ?? [] as $item)

                            @php

                                $product =
                                    $products[
                                        $item['product_id'] ?? null
                                    ]
                                    ?? null;

                                $quantity =
                                    (int)
                                    ($item['quantity'] ?? 1);

                                $price =
                                    (float)
                                    ($item['price'] ?? 0);

                                $lineTotal =
                                    $price * $quantity;

                            @endphp


                            <div class="product-row">


                                <img
                                    src="{{
                                        $product && $product->image
                                            ? asset(
                                                'products/' .
                                                $product->image
                                            )
                                            : 'https://placehold.co/160x160/0B1426/FFFFFF?text=Product'
                                    }}"
                                    alt="{{
                                        $item['name']
                                        ?? $product?->name
                                        ?? 'Product'
                                    }}"
                                    class="product-image"
                                >


                                <div class="product-info">

                                    <div class="product-name">

                                        {{
                                            $item['name']
                                            ?? $product?->name
                                            ?? 'Product'
                                        }}

                                    </div>


                                    <div class="product-meta">

                                        {{ number_format(
                                            $price,
                                            2
                                        ) }}

                                        Ã—

                                        {{ $quantity }}

                                        quantity

                                    </div>

                                </div>


                                <div class="product-total">

                                    {{ number_format(
                                        $lineTotal,
                                        2
                                    ) }}

                                </div>


                            </div>

                        @empty

                            <div class="muted-text">

                                No products found for this order.

                            </div>

                        @endforelse


                        <div class="total-box">

                            <div>

                                <div class="total-label">
                                    ORDER TOTAL
                                </div>

                                <div class="muted-text">
                                    Final payable amount
                                </div>

                            </div>


                            <div class="total-amount">

                                {{ number_format(
                                    $orderTotal,
                                    2
                                ) }}

                            </div>

                        </div>

                    </div>

                </section>


                <!-- TRACKING -->

                <section
                    class="premium-card mt-4"
                >

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </span>

                            Track Your Order

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        <div class="tracking-location">

                            <div class="location-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>


                            <div>

                                <div class="location-label">

                                    CURRENT LOCATION

                                </div>


                                <div class="location-value">

                                    {{
                                        $order
                                            ->deliveryDetail
                                            ?->current_location
                                        ?? 'Seller Warehouse'
                                    }}

                                </div>

                            </div>

                        </div>

                        @if($order->deliveryDetail?->tracking_token)
                            <div class="live-map-card">
                                <div class="live-map-heading">
                                    <div><strong id="liveMapTitle">Live delivery location</strong><small id="liveMapStatus">Waiting for delivery partner GPSâ€¦</small></div>
                                    <span class="live-map-pulse" id="liveMapBadge"><i></i><span>LIVE</span></span>
                                </div>
                                <div class="live-map-coordinates"><i class="fa-solid fa-location-crosshairs"></i><span id="liveMapCoordinates">Waiting for GPS signalâ€¦</span></div>
                                <div class="live-map-foot"><i class="fa-solid fa-shield-halved"></i> Location is shared by your delivery partner while this order is on the way.</div>
                            </div>
                        @else
                            <div class="live-map-unavailable"><i class="fa-solid fa-map-location-dot"></i><span>Live map will appear once a delivery partner is assigned.</span></div>
                        @endif


                        <ol class="timeline">

                            @foreach($steps as $index => $step)

                                <li
                                    data-delivery-stage="{{ $step }}"
                                    class="
                                        timeline-item
                                        {{
                                            $index <= $currentIndex
                                                ? 'active'
                                                : ''
                                        }}
                                    "
                                >

                                    <span class="timeline-dot">

                                        @if($index <= $currentIndex)

                                            <i
                                                class="fa-solid fa-check"
                                            ></i>

                                        @else

                                            <i
                                                class="fa-solid fa-circle"
                                            ></i>

                                        @endif

                                    </span>


                                    <div class="timeline-name">

                                        {{ $step }}

                                    </div>

                                </li>

                            @endforeach

                        </ol>

                    </div>

                </section>


            </div>


            <!-- ==================================================
                 RIGHT
            =================================================== -->

            <div class="col-lg-5">


                <!-- DELIVERY PARTNER -->

                <section class="premium-card">

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-truck-fast"></i>

                            </span>

                            Delivery Partner

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        @if(
                            $order->deliveryDetail?->deliveryPartner
                        )

                            @php

                                $partner =
                                    $order
                                        ->deliveryDetail
                                        ->deliveryPartner;

                            @endphp


                            <div class="partner-box">


                                <img
                                    src="{{
                                        $partner->image
                                            ? asset(
                                                'delivery-partners/' .
                                                $partner->image
                                            )
                                            : 'https://placehold.co/120x120/0B1426/FFFFFF?text=DP'
                                    }}"
                                    alt="{{ $partner->name }}"
                                    class="partner-image"
                                >


                                <div>

                                    <div class="partner-name">

                                        {{ $partner->name }}

                                    </div>


                                    @if($partner->phone)

                                        <div class="partner-meta">

                                            <i
                                                class="fa-solid fa-phone"
                                            ></i>

                                            {{ $partner->phone }}

                                        </div>

                                    @endif


                                    @if($partner->vehicle_number)

                                        <div class="partner-meta">

                                            <i
                                                class="fa-solid fa-motorcycle"
                                            ></i>

                                            {{ $partner->vehicle_number }}

                                        </div>

                                    @endif

                                </div>

                            </div>


                            <div class="detail-row mt-3">

                                <div class="detail-icon">

                                    <i
                                        class="fa-solid fa-location-crosshairs"
                                    ></i>

                                </div>


                                <div>

                                    <div class="detail-label">
                                        Current Location
                                    </div>


                                    <div class="detail-value">

                                        {{
                                            $order
                                                ->deliveryDetail
                                                ->current_location
                                            ?? $partner->current_location
                                            ?? 'Updating soon'
                                        }}

                                    </div>

                                </div>

                            </div>


                        @else

                            <div class="tracking-location">

                                <div class="location-icon">

                                    <i
                                        class="fa-solid fa-truck"
                                    ></i>

                                </div>


                                <div>

                                    <div class="location-label">

                                        DELIVERY PARTNER

                                    </div>


                                    <div class="location-value">

                                        Will be assigned soon

                                    </div>

                                </div>

                            </div>


                            <div class="muted-text">

                                A delivery partner will appear here
                                after seller assignment.

                            </div>

                        @endif

                    </div>

                </section>


                <!-- ORDER INFORMATION -->

                <section
                    class="premium-card mt-4"
                >

                    <div class="card-header-premium">

                        <h2 class="card-title">

                            <span class="card-icon">

                                <i class="fa-solid fa-receipt"></i>

                            </span>

                            Order Information

                        </h2>

                    </div>


                    <div class="card-body-premium">


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-hashtag"
                                ></i>

                            </div>


                            <div>

                                <div class="detail-label">
                                    Order ID
                                </div>


                                <div class="detail-value">

                                    #{{ $order->id }}

                                </div>

                            </div>

                        </div>


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-credit-card"
                                ></i>

                            </div>


                            <div>

                                <div class="detail-label">
                                    Payment
                                </div>


                                <div class="detail-value">

                                    {{
                                        $order->payment_method
                                        ?? 'Payment information available in order record'
                                    }}

                                </div>

                                <div class="detail-label mt-2">Payment status</div>
                                <div class="detail-value">{{ $order->payment_status_label }}</div>

                            </div>

                        </div>


                        <div class="detail-row">

                            <div class="detail-icon">

                                <i
                                    class="fa-solid fa-box-open"
                                ></i>

                            </div>


                            <div>

                                <div class="detail-label">
                                    Order Status
                                </div>


                                <div class="detail-value">

                                    {{
                                        $order->order_status
                                        ?? $current
                                    }}

                                </div>

                            </div>

                        </div>


                    </div>

                </section>


                                @if($order->isCancellable() || $canRequestReturn)
                    <section class="cancel-box mt-3 return-request-panel" aria-labelledby="order-request-heading">
                        <div class="cancel-title" id="order-request-heading"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Returns and cancellations</div>
                        <p class="cancel-description mb-0">Manage a return, replacement, or cancellation for this order from one place.</p>
                        <a href="{{ route('returns.options', $order) }}" class="return-order-btn mt-3"><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> Return / Cancel Order</a>
                    </section>
                @endif


            </div>

        </div>

    </div>

</main>


<!-- ==========================================================
     SMART BASKET AI COMPONENTS + EXACT CUSTOMER TASKBAR ENGINE
========================================================== -->

{{-- =========================================================
     SMART BASKET AI COMPONENTS
     Existing AI HUB drawer remains on the left.
     Existing Smart AI panel remains functional.
========================================================= --}}

<div class="sb-products-smart-ai-host" aria-hidden="false">
    <x-smart-ai-robot />
</div>

<x-ai-hub-sidebar :without-menu="true" />

{{-- =========================================================
     PREMIUM CUSTOMER TASKBAR JAVASCRIPT
     Exact same 3-dots / AI HUB / Smart AI / theme behavior.
========================================================= --}}



<!-- ==========================================================
     FINAL THEME SYNC
     ========================================================== -->

<script>

(function () {

    const serverTheme =
        @json($customerTheme);


    function getSystemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }


    function applyTheme() {

        const theme =
            serverTheme === 'system'
                ? getSystemTheme()
                : serverTheme;


        document.documentElement.setAttribute(
            'data-sb-theme',
            theme
        );


        document.documentElement.setAttribute(
            'data-bs-theme',
            theme
        );


        document.body.setAttribute(
            'data-sb-theme',
            theme
        );


        document.body.setAttribute(
            'data-customer-theme',
            serverTheme
        );


        document.documentElement.classList.remove(
            'dark',
            'light'
        );


        document.body.classList.remove(
            'dark',
            'light'
        );


        document.documentElement.classList.add(theme);

        document.body.classList.add(theme);

    }


    applyTheme();


    /*
    |--------------------------------------------------------------------------
    | System theme change
    |--------------------------------------------------------------------------
    */

    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    if (media.addEventListener) {

        media.addEventListener(
            'change',
            function () {

                if (serverTheme === 'system') {

                    applyTheme();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Cross-tab Smart Basket theme change
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key === 'smartbasket-theme'
                ||
                event.key === 'theme'
                ||
                event.key === 'appearance'
                ||
                event.key === 'darkMode'
            ) {

                /*
                IMPORTANT:
                Server setting remains authoritative
                on next page load.
                */

                applyTheme();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Custom Smart Basket event
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'smartbasket-theme-changed',
        function () {

            applyTheme();

        }
    );


})();

</script>

@if($order->deliveryDetail?->tracking_token)
<script>
(() => {
    const label = document.getElementById('liveMapStatus');
    const title = document.getElementById('liveMapTitle');
    const coords = document.getElementById('liveMapCoordinates');
    const badge = document.getElementById('liveMapBadge');
    const stages = @json($steps);
    const url = @json(route('orders.live-location', $order));
    const updateTimeline = (status) => {
        const currentIndex = stages.indexOf(status);
        document.querySelectorAll('[data-delivery-stage]').forEach((item, index) => {
            item.classList.toggle('active', currentIndex >= 0 && index <= currentIndex);
            const icon = item.querySelector('.timeline-dot i');
            if (icon) icon.className = index <= currentIndex ? 'fa-solid fa-check' : 'fa-solid fa-circle';
        });
    };
    const refresh = async () => {
        try {
            const response = await fetch(url, {headers:{Accept:'application/json'},cache:'no-store'});
            if (!response.ok) throw new Error('unavailable');
            const point = await response.json();
            if (point.status) updateTimeline(point.status);
            if (!point.available) {
                const status = String(point.status || '').toLowerCase();
                const complete = ['delivered', 'cancelled'].includes(status);
                if (title && complete) title.textContent = status === 'delivered' ? 'Location - Delivered' : 'Location - Cancelled';
                label.textContent = point.status || 'Waiting for delivery partner GPSâ€¦';
                coords.textContent = complete ? 'Delivery tracking has ended.' : 'Location will show here when the delivery partner starts sharing.';
                if (badge) { badge.classList.toggle('is-ended', complete); badge.querySelector('span').textContent = complete ? 'ENDED' : 'LIVE'; }
                return;
            }
            if (badge) { badge.classList.remove('is-ended'); badge.querySelector('span').textContent = 'LIVE'; }
            coords.textContent = `${Number(point.latitude).toFixed(5)}, ${Number(point.longitude).toFixed(5)}${point.vehicle_type ? ' Â· ' + point.vehicle_type : ''}`;
            label.textContent = `${point.status || 'On the way'}${point.updated_at ? ' Â· Updated ' + new Date(point.updated_at).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}`;
        } catch (_) { label.textContent = 'Reconnecting to delivery partnerâ€¦'; }
    };
    refresh();
    window.setInterval(refresh, 10000);
})();
</script>
@endif
</body>

</html>

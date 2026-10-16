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
           EXACT CUSTOMER TASKBAR — SAME AS ORDERS/CART/PRODUCTS
        ========================================================== */

/* =========================================================
   PRODUCTS PAGE — FULL WIDTH PREMIUM TASKBAR
========================================================= */
:root{
    --sb-tbar-bg:rgba(255,255,255,.92);
    --sb-tbar-panel:#ffffff;
    --sb-tbar-text:#102033;
    --sb-tbar-muted:#64748b;
    --sb-tbar-border:rgba(37,99,235,.13);
    --sb-tbar-blue:#2563eb;
    --sb-tbar-blue2:#4f46e5;
    --sb-tbar-soft:#eef4ff;
    --sb-tbar-shadow:0 16px 45px rgba(15,23,42,.12);
}
html[data-theme="dark"],html[data-sb-theme="dark"]{
    --sb-tbar-bg:rgba(5,11,22,.94);
    --sb-tbar-panel:#0b1728;
    --sb-tbar-text:#f7fbff;
    --sb-tbar-muted:#9aacbf;
    --sb-tbar-border:rgba(101,165,255,.20);
    --sb-tbar-blue:#65a5ff;
    --sb-tbar-blue2:#8b7cff;
    --sb-tbar-soft:rgba(37,99,235,.16);
    --sb-tbar-shadow:0 20px 60px rgba(0,0,0,.42);
}

.sb-products-taskbar{
    position:sticky;top:0;left:0;right:0;z-index:99990;
    width:100%;min-height:76px;padding:8px 12px;
    display:flex;align-items:center;gap:9px;
    background:var(--sb-tbar-bg);
    border-bottom:1px solid var(--sb-tbar-border);
    box-shadow:var(--sb-tbar-shadow);
    backdrop-filter:blur(24px) saturate(155%);-webkit-backdrop-filter:blur(24px) saturate(155%);
}
.sb-products-taskbar:before{
    content:"";position:absolute;left:0;right:0;bottom:-2px;height:2px;
    background:linear-gradient(90deg,#00e5ff,#287bff,#8b35ff,#ff20c8,#ff405d,#ffe45c,#00e5ff);
    background-size:600% 100%;animation:sbTaskbarRGB 8s linear infinite;pointer-events:none;
}
@keyframes sbTaskbarRGB{to{background-position:600% 50%}}
.sb-products-brand{
    flex:0 0 208px;min-width:190px;height:58px;padding:5px 10px 5px 6px;
    display:flex;align-items:center;gap:10px;border-radius:18px;
    color:var(--sb-tbar-text)!important;text-decoration:none!important;
    border:1px solid transparent;transition:.22s ease;
}
.sb-products-brand:hover{background:var(--sb-tbar-soft);border-color:var(--sb-tbar-border);transform:translateY(-1px)}
.sb-brand-mark{width:45px;height:45px;display:grid;place-items:center;border-radius:14px;color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);box-shadow:0 8px 22px rgba(37,99,235,.30),inset 0 1px rgba(255,255,255,.25);font-size:17px}
.sb-brand-copy{display:flex;flex-direction:column;line-height:1.05;min-width:0}.sb-brand-copy strong{font-size:14px;letter-spacing:.4px}.sb-brand-copy small{margin-top:5px;font-size:8px;letter-spacing:1.25px;color:var(--sb-tbar-muted);font-weight:900}
.sb-products-nav{display:flex;align-items:center;gap:6px;flex:1;min-width:0}
.sb-pnav-btn{
    position:relative;flex:1;min-width:82px;height:50px;padding:0 10px;
    display:flex;align-items:center;justify-content:center;gap:7px;
    border:1px solid rgba(37,99,235,.13);border-radius:14px;
    background:linear-gradient(180deg,var(--sb-tbar-panel),var(--sb-tbar-soft));
    color:var(--sb-tbar-muted)!important;font-size:11px;font-weight:900;
    text-decoration:none!important;white-space:nowrap;cursor:pointer;
    box-shadow:0 5px 16px rgba(37,99,235,.06);transition:.2s ease;
}
.sb-pnav-btn i{font-size:13px;width:16px;text-align:center}.sb-pnav-btn:hover{color:var(--sb-tbar-blue)!important;border-color:rgba(37,99,235,.32);transform:translateY(-2px);box-shadow:0 10px 25px rgba(37,99,235,.13)}
.sb-pnav-btn.is-active{color:#fff!important;border-color:transparent;background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 10px 28px rgba(37,99,235,.28)}
.sb-pnav-aihub{color:#2563eb!important}.sb-pnav-aihub:hover{color:#fff!important;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}
.sb-pnav-smart-ai{color:#4f46e5!important}.sb-pnav-smart-ai:hover{color:#fff!important;background:linear-gradient(135deg,#4f46e5,#9333ea);border-color:transparent}
.sb-smart-orb{width:25px;height:25px;display:grid;place-items:center;border-radius:8px;color:#fff;background:linear-gradient(135deg,#4f46e5,#9333ea);box-shadow:0 5px 14px rgba(79,70,229,.25);font-size:11px}.sb-online-dot{position:absolute;top:7px;right:8px;width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.13)}
.sb-taskbar-user{flex:0 1 145px;min-width:105px;height:50px;padding:0 10px;display:flex;align-items:center;gap:8px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);box-shadow:0 5px 16px rgba(37,99,235,.05);animation:sbHiFloat 3s ease-in-out infinite}
@keyframes sbHiFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-2px)}}
.sb-user-dot{width:31px;height:31px;display:grid;place-items:center;border-radius:10px;background:var(--sb-tbar-soft);color:var(--sb-tbar-blue);flex:0 0 31px}.sb-user-text{display:flex;flex-direction:column;min-width:0;line-height:1.05}.sb-user-text small{font-size:8px;color:var(--sb-tbar-muted);font-weight:800}.sb-user-text strong{margin-top:4px;font-size:10px;color:var(--sb-tbar-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:92px}
.sb-products-more{flex:0 0 52px;height:50px;border:1px solid var(--sb-tbar-border);border-radius:14px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);cursor:pointer;font-size:17px;transition:.2s ease;box-shadow:0 5px 16px rgba(37,99,235,.06)}.sb-products-more:hover{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent;transform:translateY(-2px)}
.sb-products-more-menu{position:fixed;z-index:100000;top:84px;right:12px;width:290px;max-height:calc(100vh - 100px);overflow:auto;padding:10px;border:1px solid var(--sb-tbar-border);border-radius:22px;background:var(--sb-tbar-bg);box-shadow:0 30px 90px rgba(0,0,0,.28);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);display:none}.sb-products-more-menu.is-open{display:block;animation:sbMenuIn .2s ease}.sb-more-heading{padding:9px 10px 11px;border-bottom:1px solid var(--sb-tbar-border);margin-bottom:5px}.sb-more-heading span{display:block;color:var(--sb-tbar-text);font-size:11px;font-weight:950;letter-spacing:.7px}.sb-more-heading small{display:block;margin-top:4px;color:var(--sb-tbar-muted);font-size:8px}.sb-more-link{width:100%;min-height:42px;padding:0 11px;display:flex;align-items:center;gap:10px;border:0;border-radius:12px;background:transparent;color:var(--sb-tbar-text)!important;text-decoration:none!important;font-size:10px;font-weight:850;cursor:pointer}.sb-more-link i{width:18px;text-align:center;color:var(--sb-tbar-blue)}.sb-more-link:hover{background:var(--sb-tbar-soft);color:var(--sb-tbar-blue)!important;transform:translateX(2px)}.sb-more-separator{height:1px;margin:7px 5px;background:var(--sb-tbar-border)}.sb-more-title{display:flex;gap:8px;align-items:center;padding:5px 10px 7px;color:var(--sb-tbar-muted);font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.sb-theme-switcher{display:grid;grid-template-columns:1fr 1fr;gap:6px}.sb-theme-choice{height:38px;border:1px solid var(--sb-tbar-border);border-radius:11px;background:var(--sb-tbar-panel);color:var(--sb-tbar-text);font-size:10px;font-weight:850;cursor:pointer}.sb-theme-choice:hover,.sb-theme-choice.is-selected{color:#fff;background:linear-gradient(135deg,#2563eb,#7c3aed);border-color:transparent}.sb-theme-choice i{margin-right:5px}.sb-more-action{font-family:inherit;text-align:left}.sb-logout-form{margin:0}.sb-logout{color:#e05b72!important}.sb-logout i{color:#e05b72!important}
@keyframes sbMenuIn{from{opacity:0;transform:translateY(-8px) scale(.98)}to{opacity:1;transform:none}}

/* AI HUB left button: existing project component remains the single left-side AI HUB launcher */
.ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}
html[data-theme="light"] .ai-hub-drawer{background:linear-gradient(145deg,rgba(255,255,255,.99),rgba(242,246,252,.99))!important;color:#101828!important;border-right-color:rgba(37,99,235,.14)!important;box-shadow:24px 0 70px rgba(15,23,42,.20)!important}
html[data-theme="light"] .ai-hub-drawer-header strong,html[data-theme="light"] .ai-hub-tool-text strong{color:#101828!important}html[data-theme="light"] .ai-hub-drawer-header small,html[data-theme="light"] .ai-hub-tool-text small{color:#667085!important}
html[data-theme="light"] .ai-hub-fab{background:linear-gradient(145deg,#fff,#eef4ff)!important;color:#172033!important;border-color:rgba(37,99,235,.25)!important}
html[data-theme="dark"] .ai-hub-drawer{background:linear-gradient(145deg,#09111f,#020711)!important}html[data-theme="dark"] .ai-hub-fab{background:linear-gradient(145deg,#1e293b,#050a14)!important}

/* Robot launcher is hidden; its original panel remains fully functional */


@media(max-width:1350px){.sb-products-brand{flex-basis:185px;min-width:175px}.sb-pnav-btn{min-width:70px;padding:0 7px;font-size:10px}.sb-taskbar-user{flex-basis:125px}}
@media(max-width:1120px){.sb-brand-copy{display:none}.sb-products-brand{flex-basis:65px;min-width:65px;justify-content:center;padding:5px}.sb-pnav-btn span{display:none}.sb-pnav-btn{min-width:52px;padding:0}.sb-taskbar-user{flex-basis:90px;min-width:90px}.sb-user-text strong{max-width:52px}}
@media(max-width:700px){.sb-products-taskbar{padding:7px;gap:5px;overflow-x:auto;scrollbar-width:none}.sb-products-taskbar::-webkit-scrollbar{display:none}.sb-products-brand{position:sticky;left:0;z-index:2;flex-basis:52px;min-width:52px;height:48px}.sb-brand-mark{width:39px;height:39px}.sb-products-nav{flex:0 0 auto}.sb-pnav-btn{height:46px;min-width:48px;flex:0 0 48px;border-radius:12px}.sb-taskbar-user{flex:0 0 110px;height:46px}.sb-products-more{flex:0 0 46px;height:46px}.sb-products-more-menu{top:66px;right:7px;width:min(290px,calc(100vw - 14px))}}



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
                    #3b82f6,
                    #6366f1
                );
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


            .sb-user-text {

                display: none;
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


            .sb-user-text {

                display: none;
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
.sb-products-taskbar{
    width:100% !important;
    max-width:none !important;
    margin:0 !important;
    left:0 !important;
    right:0 !important;
}
.sb-products-taskbar:before{
    z-index:5;
}
@media(max-width:1100px){
    .sb-taskbar-user .sb-user-text{
        display:flex !important;
    }
}
@media(max-width:767px){
    body{padding-top:0 !important;}
    .sb-taskbar-user .sb-user-text{
        display:flex !important;
    }
}
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
     SMART BASKET — PRODUCTS PAGE PREMIUM CUSTOMER TASKBAR
     Core navigation is kept here so this page has ONE taskbar.
========================================================= --}}
@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
@endphp

<nav class="sb-products-taskbar" id="sbProductsTaskbar" aria-label="Customer Navigation">
    <a href="{{ route('products.index') }}" class="sb-products-brand" aria-label="Smart Basket Products">
        <span class="sb-brand-mark"><i class="fa-solid fa-basket-shopping"></i></span>
        <span class="sb-brand-copy">
            <strong>SMART BASKET</strong>
            <small>CUSTOMER PANEL</small>
        </span>
    </a>

    <div class="sb-products-nav">
        @if(Route::has('products.index'))
            <a href="{{ route('products.index') }}" class="sb-pnav-btn {{ $currentRoute === 'products.index' ? 'is-active' : '' }}">
                <i class="fa-solid fa-store"></i><span>Products</span>
            </a>
        @endif

        @if($ordersRoute)
            <a href="{{ route($ordersRoute) }}" class="sb-pnav-btn {{ in_array($currentRoute, [$ordersRoute, 'orders.show'], true) ? 'is-active' : '' }}">
                <i class="fa-solid fa-box"></i><span>Orders</span>
            </a>
        @endif

        @if(Route::has('cart.index'))
            <a href="{{ route('cart.index') }}" class="sb-pnav-btn {{ $currentRoute === 'cart.index' ? 'is-active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
            </a>
        @endif

        @if(Route::has('wishlist'))
            <a href="{{ route('wishlist') }}" class="sb-pnav-btn {{ $currentRoute === 'wishlist' ? 'is-active' : '' }}">
                <i class="fa-regular fa-heart"></i><span>Wishlist</span>
            </a>
        @endif

        @if(Route::has('profile'))
            <a href="{{ route('profile') }}" class="sb-pnav-btn {{ $currentRoute === 'profile' ? 'is-active' : '' }}">
                <i class="fa-regular fa-user"></i><span>Profile</span>
            </a>
        @endif

        @if(Route::has('settings'))
            <a href="{{ route('settings') }}" class="sb-pnav-btn {{ $currentRoute === 'settings' ? 'is-active' : '' }}">
                <i class="fa-solid fa-gear"></i><span>Settings</span>
            </a>
        @endif

        <button type="button" class="sb-pnav-btn sb-pnav-aihub" id="sbProductsAIHub" data-sb-ai-hub-open title="Open AI Hub">
            <i class="fa-solid fa-wand-magic-sparkles"></i><span>AI HUB</span>
        </button>

        <button type="button" class="sb-pnav-btn sb-pnav-smart-ai" id="sbProductsSmartAI" title="Open Smart AI">
            <span class="sb-smart-orb"><i class="fa-solid fa-robot"></i></span><span>Smart AI</span><b class="sb-online-dot"></b>
        </button>
    </div>

    <div class="sb-taskbar-user">
        <span class="sb-user-dot"><i class="fa-regular fa-user"></i></span>
        <span class="sb-user-text"><small>Hi,</small><strong>{{ auth()->user()->name ?? 'Customer' }}</strong></span>
    </div>

    <button type="button" class="sb-products-more" id="sbProductsMore" aria-expanded="false" aria-controls="sbProductsMoreMenu" title="More options">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
</nav>

<div class="sb-products-more-menu" id="sbProductsMoreMenu" aria-hidden="true">
    <div class="sb-more-heading"><span>SMART BASKET</span><small>More options</small></div>

    @if(Route::has('products.index'))
        <a href="{{ route('products.index') }}" class="sb-more-link"><i class="fa-solid fa-house"></i><span>Products Home</span></a>
    @endif
    @if($ordersRoute)
        <a href="{{ route($ordersRoute) }}" class="sb-more-link"><i class="fa-solid fa-box"></i><span>My Orders</span></a>
    @endif
    @if(Route::has('cart.index'))
        <a href="{{ route('cart.index') }}" class="sb-more-link"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>
    @endif
    @if(Route::has('wishlist'))
        <a href="{{ route('wishlist') }}" class="sb-more-link"><i class="fa-regular fa-heart"></i><span>Wishlist</span></a>
    @endif
    @if(Route::has('profile'))
        <a href="{{ route('profile') }}" class="sb-more-link"><i class="fa-regular fa-user"></i><span>Profile</span></a>
    @endif
    @if(Route::has('settings'))
        <a href="{{ route('settings') }}" class="sb-more-link"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
    @endif

    <div class="sb-more-separator"></div>
    <div class="sb-more-title"><i class="fa-solid fa-palette"></i><span>Theme</span></div>
    <div class="sb-theme-switcher">
        <button type="button" class="sb-theme-choice" data-sb-set-theme="light"><i class="fa-solid fa-sun"></i><span>Light</span></button>
        <button type="button" class="sb-theme-choice" data-sb-set-theme="dark"><i class="fa-solid fa-moon"></i><span>Dark</span></button>
    </div>

    <div class="sb-more-separator"></div>
    <button type="button" class="sb-more-link sb-more-action" data-sb-more-aihub><i class="fa-solid fa-wand-magic-sparkles"></i><span>Open AI HUB</span></button>
    <button type="button" class="sb-more-link sb-more-action" data-sb-more-smart-ai><i class="fa-solid fa-robot"></i><span>Open Smart AI</span></button>

    @if(Route::has('logout'))
        <div class="sb-more-separator"></div>
        <form method="POST" action="{{ route('logout') }}" class="sb-logout-form">
            @csrf
            <button type="submit" class="sb-more-link sb-logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
        </form>
    @endif
</div>
@endauth


<!-- ==============================================================
     ORDER PAGE
=============================================================== -->

<main class="order-page">

    <div class="order-container">


        <!-- TOP PAGE BAR -->

        <div class="order-topbar">


           

            <div class="secure-pill">

                <i class="fa-solid fa-shield-halved"></i>

                Secure Order

            </div>

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

                                        ₹{{ number_format(
                                            $price,
                                            2
                                        ) }}

                                        ×

                                        {{ $quantity }}

                                        quantity

                                    </div>

                                </div>


                                <div class="product-total">

                                    ₹{{ number_format(
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

                                ₹{{ number_format(
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


                        <ol class="timeline">

                            @foreach($steps as $index => $step)

                                <li
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


                <!-- CANCEL ORDER -->

                @if($order->isCancellable())

                    <section class="cancel-box">

                        <div class="cancel-title">

                            <i
                                class="fa-solid fa-circle-exclamation"
                            ></i>

                            Need to cancel this order?

                        </div>


                        <div class="cancel-description">

                            You can cancel this order while it is
                            still eligible for cancellation.

                        </div>


                        <form
                            action="{{
                                route(
                                    'orders.cancel',
                                    $order
                                )
                            }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="cancel-btn"
                                onclick="
                                    return confirm(
                                        'Are you sure you want to cancel this order?'
                                    );
                                "
                            >

                                <i
                                    class="fa-solid fa-xmark"
                                ></i>

                                Cancel Order

                            </button>

                        </form>

                    </section>

                @endif

                <section class="cancel-box mt-3 return-request-panel" aria-labelledby="return-request-heading">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h2 class="h5 mb-0" id="return-request-heading"><i class="fa-solid fa-rotate-left me-2" aria-hidden="true"></i>Return / Refund</h2>
                        <a href="{{ route('returns.index') }}" class="btn btn-outline-primary btn-sm">My return requests</a>
                    </div>
                    @php
                        $returnableItems = collect($order->items ?? [])->filter(function ($line) use ($reservedReturnQuantities) {
                            $id = (int) ($line['product_id'] ?? 0);
                            return (int) ($line['quantity'] ?? 1) > ($reservedReturnQuantities[$id] ?? 0);
                        });
                    @endphp
                    @if($returnRequests->isNotEmpty())
                        <p class="cancel-description">Existing requests for this order:</p>
                        @foreach($returnRequests as $returnRequest)
                            <p><a href="{{ route('returns.show', $returnRequest) }}">Return #{{ $returnRequest->id }} — {{ ucfirst(str_replace('_', ' ', $returnRequest->status)) }}</a></p>
                        @endforeach
                    @endif
                    @if(app(\App\Services\SiteSettings::class)->enabled('return_requests_enabled') && $canRequestReturn && $returnableItems->isNotEmpty())
                        <form action="{{ route('returns.store', $order) }}" method="POST" class="mt-3">
                            @csrf
                            <p class="cancel-description">Choose products and quantities. Return requests are reviewed by Smart Basket; submitting a request does not itself issue a refund.</p>
                            @foreach($returnableItems as $line)
                                @php
                                    $productId = (int) ($line['product_id'] ?? 0);
                                    $purchased = (int) ($line['quantity'] ?? 1);
                                    $remaining = max(0, $purchased - ($reservedReturnQuantities[$productId] ?? 0));
                                @endphp
                                @if($remaining > 0)
                                    <div class="mb-2">
                                        <label for="return-qty-{{ $productId }}">{{ $line['name'] ?? ($products[$productId]->name ?? 'Product') }} — {{ $remaining }} eligible</label>
                                        <input id="return-qty-{{ $productId }}" type="number" name="items[{{ $loop->index }}][quantity]" min="0" max="{{ $remaining }}" value="0" class="form-control" aria-label="Return quantity">
                                        <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $productId }}">
                                    </div>
                                @endif
                            @endforeach
                            <label for="return-reason-{{ $order->id }}">Reason</label>
                            <select id="return-reason-{{ $order->id }}" name="reason" class="form-select mb-2" required>
                                <option value="">Choose a reason</option>
                                <option value="damaged">Damaged</option><option value="defective">Defective</option><option value="wrong_item">Wrong item</option><option value="not_as_described">Not as described</option><option value="changed_mind">Changed my mind</option><option value="other">Other</option>
                            </select>
                            <label for="return-description-{{ $order->id }}">Additional details (optional)</label>
                            <textarea id="return-description-{{ $order->id }}" name="description" maxlength="2000" class="form-control mb-3"></textarea>
                            <button type="submit" class="btn btn-primary px-4 py-2"><i class="fa-solid fa-paper-plane me-2" aria-hidden="true"></i>Submit return request</button>
                        </form>
                    @elseif($canRequestReturn && $returnableItems->isEmpty())
                        <p class="cancel-description mb-0">All purchased quantities already have a return request.</p>
                    @elseif($returnRequests->isEmpty())
                        <p class="cancel-description mb-0">This order is not currently eligible. Returns require a paid, delivered order within {{ config('returns.window_days', 30) }} days of purchase.</p>
                    @endif
                </section>


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

<script>
(function(){
    'use strict';
    if(window.__SBProductsPremiumTaskbar) return;
    window.__SBProductsPremiumTaskbar=true;

    const more=document.getElementById('sbProductsMore');
    const menu=document.getElementById('sbProductsMoreMenu');
    const aiHubBtn=document.getElementById('sbProductsAIHub');
    const smartAiBtn=document.getElementById('sbProductsSmartAI');

    function closeMore(){
        if(menu){menu.classList.remove('is-open');menu.setAttribute('aria-hidden','true');}
        if(more) more.setAttribute('aria-expanded','false');
    }
    function openMore(){
        if(menu){menu.classList.add('is-open');menu.setAttribute('aria-hidden','false');}
        if(more) more.setAttribute('aria-expanded','true');
    }
    if(more){
        more.addEventListener('click',function(e){e.preventDefault();e.stopPropagation();menu&&menu.classList.contains('is-open')?closeMore():openMore();});
    }
    document.addEventListener('click',function(e){if(menu&&more&&!menu.contains(e.target)&&!more.contains(e.target))closeMore();});
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closeMore();});

    function openHub(){
        const trigger=document.querySelector('[data-ai-hub-open]');
        if(trigger) trigger.click();
        closeMore();
    }
    function openRobot(){
        const trigger=document.querySelector('[data-smart-ai-open]');
        if(trigger) trigger.click();
        closeMore();
    }
    if(aiHubBtn) aiHubBtn.addEventListener('click',openHub);
    if(smartAiBtn) smartAiBtn.addEventListener('click',openRobot);
    document.querySelectorAll('[data-sb-more-aihub]').forEach(b=>b.addEventListener('click',openHub));
    document.querySelectorAll('[data-sb-more-smart-ai]').forEach(b=>b.addEventListener('click',openRobot));

    function setTheme(theme){
        if(!['light','dark'].includes(theme)) return;
        localStorage.setItem('sb-theme',theme);
        document.documentElement.setAttribute('data-theme',theme);
        document.documentElement.setAttribute('data-sb-theme',theme);
        document.body.setAttribute('data-sb-theme',theme);
        window.SB_THEME=theme;
        try{window.dispatchEvent(new CustomEvent('sb-theme-changed',{detail:{theme:theme}}));}catch(e){}
        try{window.dispatchEvent(new CustomEvent('smartbasket-theme-changed',{detail:{theme:theme}}));}catch(e){}
        updateThemeButtons(theme);
    }
    function updateThemeButtons(theme){
        document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.classList.toggle('is-selected',btn.getAttribute('data-sb-set-theme')===theme);});
    }
    document.querySelectorAll('[data-sb-set-theme]').forEach(function(btn){btn.addEventListener('click',function(){setTheme(btn.getAttribute('data-sb-set-theme'));});});
    updateThemeButtons(document.documentElement.getAttribute('data-theme')||localStorage.getItem('sb-theme')||'dark');
})();
</script>

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

</body>

</html>

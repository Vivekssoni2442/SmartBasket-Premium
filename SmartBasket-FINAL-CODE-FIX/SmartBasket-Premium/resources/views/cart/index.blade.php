<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $customerTheme = auth()->check()
            ? (auth()->user()->dark_mode ?? 'system')
            : 'system';
    @endphp

    <title>SMART BASKET | My Cart</title>

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

        /* =========================================================
           SMART BASKET CART THEME
        ========================================================= */

        :root {

            --cart-bg: #f4f7fb;
            --cart-text: #0f172a;
            --cart-muted: #64748b;

            --cart-card: rgba(255,255,255,.90);
            --cart-input: #ffffff;

            --cart-border: rgba(15,23,42,.09);

            --cart-primary: #2563eb;
            --cart-primary-2: #7c3aed;

            --cart-success: #16a34a;
            --cart-danger: #ef4444;

            --cart-soft: rgba(148,163,184,.08);

            --cart-shadow:
                0 25px 70px rgba(15,23,42,.12);
        }


        /* ================= DARK ================= */

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {

            --cart-bg: #020617;
            --cart-text: #f8fafc;
            --cart-muted: #94a3b8;

            --cart-card: rgba(15,23,42,.88);
            --cart-input: #0f172a;

            --cart-border: rgba(255,255,255,.10);

            --cart-primary: #3b82f6;
            --cart-primary-2: #8b5cf6;

            --cart-success: #22c55e;
            --cart-danger: #f87171;

            --cart-soft: rgba(148,163,184,.07);

            --cart-shadow:
                0 30px 90px rgba(0,0,0,.48);
        }


        /* ================= BODY ================= */

        html,
        body {

            min-height: 100%;

        }


        body {

            margin: 0;

            color: var(--cart-text);

            background:

                radial-gradient(
                    circle at 10% 0%,
                    rgba(37,99,235,.16),
                    transparent 32%
                ),

                radial-gradient(
                    circle at 90% 10%,
                    rgba(124,58,237,.14),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(14,165,233,.08),
                    transparent 35%
                ),

                var(--cart-bg);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            transition:
                background .3s ease,
                color .3s ease;
        }


        /* ================= PAGE ================= */

        .cart-page {

            min-height: 100vh;

            padding:
                28px 18px 70px;
        }


        .cart-container {

            width: 100%;

            max-width: none;

            margin: 0;
        }


        /* ================= HEADER ================= */

        .cart-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 30px;
        }


        .cart-heading {

            display: flex;

            align-items: center;

            gap: 15px;
        }


        .cart-icon {

            width: 62px;
            height: 62px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background:

                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            font-size: 29px;

            box-shadow:
                0 15px 35px rgba(37,99,235,.25);
        }


        .cart-title {

            margin: 0;

            font-size: 34px;

            font-weight: 900;

            letter-spacing: -.8px;
        }


        .cart-subtitle {

            margin: 5px 0 0;

            color: var(--cart-muted);

            font-size: 14px;
        }


        /* ================= HEADER BUTTONS ================= */

        .top-actions {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;
        }


        .top-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding: 11px 16px;

            border-radius: 13px;

            color: var(--cart-text);

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            text-decoration: none;

            font-size: 14px;

            font-weight: 750;

            box-shadow:
                0 8px 25px rgba(15,23,42,.06);

            transition: .25s ease;
        }


        .top-btn:hover {

            color: var(--cart-primary);

            transform: translateY(-2px);

            border-color:
                rgba(37,99,235,.35);
        }


        /* ================= MAIN ================= */

        .cart-panel {

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            border-radius: 28px;

            padding: 25px;

            box-shadow: var(--cart-shadow);

            backdrop-filter: blur(20px);

            -webkit-backdrop-filter: blur(20px);

            transition: .3s ease;
        }


        /* ================= PRODUCT ================= */

        .cart-item {

            position: relative;

            display: flex;

            align-items: center;

            gap: 20px;

            padding: 20px;

            margin-bottom: 15px;

            border-radius: 21px;

            background: var(--cart-soft);

            border: 1px solid var(--cart-border);

            transition: .25s ease;
        }


        .cart-item:hover {

            transform: translateY(-3px);

            border-color:
                rgba(37,99,235,.30);

            box-shadow:
                0 12px 35px rgba(37,99,235,.08);
        }


        /* IMAGE */

        .product-image-wrapper {

            width: 105px;
            height: 105px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 19px;

            background: var(--cart-input);

            border: 1px solid var(--cart-border);

            overflow: hidden;

            box-shadow:
                0 10px 25px rgba(0,0,0,.10);
        }


        .product-image {

            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .product-placeholder {

            font-size: 38px;
        }


        /* INFO */

        .product-info {

            flex: 1;

            min-width: 0;
        }


        .product-name {

            color: var(--cart-text);

            font-size: 19px;

            font-weight: 850;

            margin-bottom: 7px;
        }


        .product-price {

            color: var(--cart-primary);

            font-size: 16px;

            font-weight: 800;

            margin-bottom: 7px;
        }


        .stock-badge {

            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            border-radius: 999px;

            background:
                rgba(34,197,94,.10);

            border:
                1px solid rgba(34,197,94,.18);

            color: var(--cart-success);

            font-size: 12px;

            font-weight: 750;
        }


        /* ================= CONTROLS ================= */

        .cart-controls {

            min-width: 230px;
        }


        .quantity-form {

            display: flex;

            gap: 8px;

            margin-bottom: 9px;
        }


        .quantity-input {

            width: 82px;

            height: 45px;

            border-radius: 12px;

            background: var(--cart-input) !important;

            color: var(--cart-text) !important;

            border:
                1px solid var(--cart-border) !important;

            text-align: center;

            font-weight: 750;

            box-shadow: none !important;
        }


        .quantity-input:focus {

            border-color:
                var(--cart-primary) !important;

            box-shadow:
                0 0 0 4px
                rgba(37,99,235,.12) !important;
        }


        .update-btn {

            flex: 1;

            border: 0;

            border-radius: 12px;

            background:
                rgba(37,99,235,.10);

            color: var(--cart-primary);

            border:
                1px solid rgba(37,99,235,.18);

            font-weight: 800;

            transition: .2s ease;
        }


        .update-btn:hover {

            color: white;

            background:
                var(--cart-primary);

            transform: translateY(-1px);
        }


        .remove-btn {

            width: 100%;

            min-height: 42px;

            border-radius: 12px;

            background:
                rgba(239,68,68,.08);

            color: var(--cart-danger);

            border:
                1px solid rgba(239,68,68,.18);

            font-weight: 750;

            transition: .2s ease;
        }


        .remove-btn:hover {

            background: var(--cart-danger);

            color: white;

            transform: translateY(-1px);
        }


        /* ================= SUMMARY ================= */

        .summary-card {

            position: sticky;

            top: 25px;

            padding: 25px;

            border-radius: 23px;

            background: var(--cart-card);

            border: 1px solid var(--cart-border);

            box-shadow: var(--cart-shadow);

            backdrop-filter: blur(20px);
        }


        .summary-title {

            display: flex;

            align-items: center;

            gap: 10px;

            color: var(--cart-text);

            font-size: 20px;

            font-weight: 850;

            margin-bottom: 20px;
        }


        .summary-icon {

            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;
        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            gap: 15px;

            padding: 9px 0;

            color: var(--cart-muted);
        }


        .summary-row strong {

            color: var(--cart-text);
        }


        .summary-divider {

            border: 0;

            border-top:
                1px solid var(--cart-border);

            margin: 14px 0;
        }


        .summary-total {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }


        .summary-total span {

            font-size: 18px;

            font-weight: 850;
        }


        .summary-total strong {

            color: var(--cart-success);

            font-size: 25px;

            font-weight: 900;
        }


        /* ================= CHECKOUT ================= */

        .checkout-btn {

            width: 100%;

            min-height: 58px;

            margin-top: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            border: 0;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            text-decoration: none;

            font-size: 16px;

            font-weight: 850;

            box-shadow:
                0 15px 35px rgba(37,99,235,.25);

            transition: .25s ease;
        }


        .checkout-btn:hover {

            color: white;

            transform: translateY(-3px);

            box-shadow:
                0 22px 45px rgba(37,99,235,.35);
        }


        /* ================= EMPTY ================= */

        .empty-cart {

            text-align: center;

            padding: 70px 20px;
        }


        .empty-cart-icon {

            width: 105px;
            height: 105px;

            margin:
                0 auto 22px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 30px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.10)
                );

            border:
                1px solid var(--cart-border);

            font-size: 50px;
        }


        .empty-cart h2 {

            color: var(--cart-text);

            font-size: 25px;

            font-weight: 900;
        }


        .empty-cart p {

            color: var(--cart-muted);

            margin: 8px auto 22px;

            max-width: 450px;
        }


        .browse-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 12px 20px;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    var(--cart-primary),
                    var(--cart-primary-2)
                );

            color: white;

            text-decoration: none;

            font-weight: 800;

            transition: .25s ease;
        }


        .browse-btn:hover {

            color: white;

            transform: translateY(-2px);
        }


        /* ================= SECURITY ================= */

        .security-row {

            display: flex;

            justify-content: center;

            flex-wrap: wrap;

            gap: 20px;

            margin-top: 24px;

            color: var(--cart-muted);

            font-size: 12px;

            font-weight: 650;
        }


        /* ================= MOBILE ================= */

        @media(max-width: 850px) {

            .cart-header {

                align-items: flex-start;

                flex-direction: column;
            }

            .cart-item {

                align-items: flex-start;

                flex-wrap: wrap;
            }

            .cart-controls {

                width: 100%;

                min-width: 0;
            }

            .summary-card {

                position: static;
            }
        }


        @media(max-width: 600px) {

            .cart-page {

                padding:
                    25px 10px 60px;
            }

            .cart-title {

                font-size: 27px;
            }

            .cart-panel {

                padding: 15px;

                border-radius: 22px;
            }

            .cart-item {

                padding: 15px;

                gap: 14px;

                border-radius: 18px;
            }

            .product-image-wrapper {

                width: 78px;
                height: 78px;
            }

            .product-name {

                font-size: 16px;
            }

            .top-actions {

                width: 100%;
            }

            .top-btn {

                flex: 1;
            }
        }

    </style>

<style>
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
.sb-products-smart-ai-host>.smart-ai>.smart-ai__launch{opacity:0!important;visibility:hidden!important;pointer-events:none!important;position:fixed!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important}.sb-products-smart-ai-host [data-smart-ai-panel]{z-index:100001!important}

@media(max-width:1350px){.sb-products-brand{flex-basis:185px;min-width:175px}.sb-pnav-btn{min-width:70px;padding:0 7px;font-size:10px}.sb-taskbar-user{flex-basis:125px}}
@media(max-width:1120px){.sb-brand-copy{display:none}.sb-products-brand{flex-basis:65px;min-width:65px;justify-content:center;padding:5px}.sb-pnav-btn span{display:none}.sb-pnav-btn{min-width:52px;padding:0}.sb-taskbar-user{flex-basis:90px;min-width:90px}.sb-user-text strong{max-width:52px}}
@media(max-width:700px){.sb-products-taskbar{padding:7px;gap:5px;overflow-x:auto;scrollbar-width:none}.sb-products-taskbar::-webkit-scrollbar{display:none}.sb-products-brand{position:sticky;left:0;z-index:2;flex-basis:52px;min-width:52px;height:48px}.sb-brand-mark{width:39px;height:39px}.sb-products-nav{flex:0 0 auto}.sb-pnav-btn{height:46px;min-width:48px;flex:0 0 48px;border-radius:12px}.sb-taskbar-user{flex:0 0 110px;height:46px}.sb-products-more{flex:0 0 46px;height:46px}.sb-products-more-menu{top:66px;right:7px;width:min(290px,calc(100vw - 14px))}}
</style>

</head>


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>


{{-- =========================================================
     SMART BASKET — PRODUCTS PAGE PREMIUM CUSTOMER TASKBAR
     Same common customer navigation and 3-dots menu.
========================================================= --}}
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
            <a href="{{ route($ordersRoute) }}" class="sb-pnav-btn {{ $currentRoute === $ordersRoute ? 'is-active' : '' }}">
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


<div class="sb-products-smart-ai-host" aria-hidden="false">
    <x-smart-ai-robot />
</div>



<div class="cart-page">

    <div class="cart-container">


        {{-- ================= HEADER ================= --}}

        <div class="cart-header">

            <div class="cart-heading">

                <div class="cart-icon">
                    🛒
                </div>

                <div>

                    <h1 class="cart-title">
                        My Cart
                    </h1>

                    <p class="cart-subtitle">
                        Review your items before placing your order.
                    </p>

                </div>

            </div>


        </div>



        {{-- ================= CART ================= --}}

        @if($cartItems->count())

            <div class="row g-4">


                {{-- PRODUCTS --}}

                <div class="col-lg-8">

                    <div class="cart-panel">

                        @foreach($cartItems as $item)

                            <div class="cart-item">


                                {{-- PRODUCT IMAGE --}}

                                <div class="product-image-wrapper">

                                    @if($item->product?->image)

                                        <img
                                            src="{{ asset('products/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="product-image"
                                        >

                                    @else

                                        <div class="product-placeholder">
                                            🛍️
                                        </div>

                                    @endif

                                </div>


                                {{-- PRODUCT INFO --}}

                                <div class="product-info">

                                    <div class="product-name">
                                        {{ $item->product?->name ?? 'Product' }}
                                    </div>


                                    <div class="product-price">

                                        ₹{{ number_format(
                                            (float) ($item->product?->price ?? 0),
                                            2
                                        ) }}

                                    </div>


                                    <span class="stock-badge">

                                        ● Stock:
                                        {{ $item->product?->stock ?? 0 }}

                                    </span>

                                </div>


                                {{-- CONTROLS --}}

                                <div class="cart-controls">


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'cart.update',
                                            $item->product_id
                                        ) }}"
                                        class="quantity-form"
                                    >

                                        @csrf

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            class="quantity-input"
                                            required
                                        >


                                        <button
                                            type="submit"
                                            class="update-btn"
                                        >
                                            Update
                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'cart.remove',
                                            $item->id
                                        ) }}"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="remove-btn"
                                        >
                                            🗑️ Remove Item
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>



                {{-- ================= SUMMARY ================= --}}

                <div class="col-lg-4">

                    <div class="summary-card">

                        <div class="summary-title">

                            <div class="summary-icon">
                                🧾
                            </div>

                            Order Summary

                        </div>


                        <div class="summary-row">

                            <span>
                                Items
                            </span>

                            <strong>
                                {{ $cartItems->sum('quantity') }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                ₹{{ number_format(
                                    (float) $subtotal,
                                    2
                                ) }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Delivery
                            </span>

                            <strong>
                                Free
                            </strong>

                        </div>


                        <hr class="summary-divider">


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                ₹{{ number_format(
                                    (float) $subtotal,
                                    2
                                ) }}
                            </strong>

                        </div>


                        <a
                            href="{{ url('/checkout') }}"
                            class="checkout-btn"
                        >
                            Proceed to Checkout
                            🚀
                        </a>


                        <div class="security-row">

                            <span>
                                🔒 Secure
                            </span>

                            <span>
                                🛡️ Protected
                            </span>

                            <span>
                                ⚡ Fast
                            </span>

                        </div>

                    </div>

                </div>

            </div>


        @else


            {{-- ================= EMPTY ================= --}}

            <div class="cart-panel">

                <div class="empty-cart">

                    <div class="empty-cart-icon">
                        🛒
                    </div>

                    <h2>
                        Your Cart is Empty
                    </h2>

                    <p>
                        You haven't added any products yet.
                        Explore SMART BASKET and start shopping.
                    </p>

                    <a
                        href="{{ url('/products') }}"
                        class="browse-btn"
                    >
                        🛍️ Browse Products
                    </a>

                </div>

            </div>


        @endif

    </div>

</div>



{{-- =========================================================
     PRODUCTS PAGE PREMIUM TASKBAR JAVASCRIPT
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

{{-- ================= THEME SYSTEM ================= --}}

<script>

(function () {

    const savedTheme =
        document.body.dataset.customerTheme || 'system';


    function applyTheme(theme) {

        let finalTheme = theme;


        if (theme === 'system') {

            finalTheme =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';
        }


        document.documentElement.setAttribute(
            'data-sb-theme',
            finalTheme
        );


        document.body.setAttribute(
            'data-sb-theme',
            finalTheme
        );

    }


    applyTheme(savedTheme);


    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    media.addEventListener(
        'change',
        function () {

            if (savedTheme === 'system') {

                applyTheme('system');

            }

        }
    );

})();

</script>


<x-ai-hub-sidebar :without-menu="true" />

</body>
</html>
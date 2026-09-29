@php

    /*
    |--------------------------------------------------------------------------
    | SMART BASKET CUSTOMER THEME
    |--------------------------------------------------------------------------
    | Same theme source used by Track Order page.
    |
    | dark  = dark mode
    | light = light mode
    | system = browser system theme
    |--------------------------------------------------------------------------
    */

    $customerTheme = auth()->check()
        ? (auth()->user()->dark_mode ?? 'system')
        : 'system';

    /*
    |--------------------------------------------------------------------------
    | Normalize theme value
    |--------------------------------------------------------------------------
    */

    if ($customerTheme === true || $customerTheme === 1 || $customerTheme === '1' || $customerTheme === 'true') {
        $customerTheme = 'dark';
    }

    if ($customerTheme === false || $customerTheme === 0 || $customerTheme === '0' || $customerTheme === 'false') {
        $customerTheme = 'light';
    }

    if (!in_array($customerTheme, ['dark', 'light', 'system'], true)) {
        $customerTheme = 'system';
    }

@endphp


<!DOCTYPE html>
<html
    lang="en"
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Orders | SMART BASKET</title>


    <!-- ==========================================================
         IMPORTANT:
         APPLY THEME BEFORE PAGE PAINT
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


            const finalTheme =
                serverTheme === 'system'
                    ? getSystemTheme()
                    : serverTheme;


            /*
            |--------------------------------------------------------------------------
            | Apply BEFORE CSS/page renders
            |--------------------------------------------------------------------------
            */

            document.documentElement.setAttribute(
                'data-sb-theme',
                finalTheme
            );


            document.documentElement.setAttribute(
                'data-bs-theme',
                finalTheme
            );


            document.documentElement.classList.remove(
                'dark',
                'light'
            );


            document.documentElement.classList.add(
                finalTheme
            );


            /*
            |--------------------------------------------------------------------------
            | Save current theme for other Smart Basket pages
            |--------------------------------------------------------------------------
            */

            try {

                localStorage.setItem(
                    'smartbasket-theme',
                    finalTheme
                );

            } catch (e) {}

        })();

    </script>


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
           SMART BASKET - MY ORDERS THEME
        ========================================================== */

        :root {

            --sb-bg: #f4f7fb;

            --sb-bg-secondary: #ffffff;

            --sb-card: rgba(255, 255, 255, 0.94);

            --sb-card-hover: #ffffff;

            --sb-surface: rgba(248, 250, 252, 0.95);

            --sb-text: #0f172a;

            --sb-heading: #020617;

            --sb-muted: #64748b;

            --sb-border: rgba(15, 23, 42, 0.09);

            --sb-border-strong: rgba(15, 23, 42, 0.16);

            --sb-primary: #2563eb;

            --sb-primary-hover: #1d4ed8;

            --sb-primary-soft: rgba(37, 99, 235, 0.08);

            --sb-success: #16a34a;

            --sb-success-soft: rgba(22, 163, 74, 0.09);

            --sb-danger: #dc2626;

            --sb-danger-soft: rgba(220, 38, 38, 0.08);

            --sb-shadow:
                0 20px 60px rgba(15, 23, 42, 0.10);

            --sb-image-bg: #e2e8f0;
        }


        /* ==========================================================
           DARK THEME
        ========================================================== */

        html[data-sb-theme="dark"] {

            --sb-bg: #020617;

            --sb-bg-secondary: #0f172a;

            --sb-card: rgba(15, 23, 42, 0.94);

            --sb-card-hover: #111c32;

            --sb-surface: rgba(30, 41, 59, 0.82);

            --sb-text: #e2e8f0;

            --sb-heading: #f8fafc;

            --sb-muted: #94a3b8;

            --sb-border: rgba(148, 163, 184, 0.14);

            --sb-border-strong: rgba(148, 163, 184, 0.25);

            --sb-primary: #3b82f6;

            --sb-primary-hover: #60a5fa;

            --sb-primary-soft: rgba(59, 130, 246, 0.14);

            --sb-success: #22c55e;

            --sb-success-soft: rgba(34, 197, 94, 0.11);

            --sb-danger: #ef4444;

            --sb-danger-soft: rgba(239, 68, 68, 0.11);

            --sb-shadow:
                0 30px 90px rgba(0, 0, 0, 0.50);

            --sb-image-bg: #1e293b;
        }


        /* ==========================================================
           GLOBAL
        ========================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        html {
            background: var(--sb-bg);
        }


        body {

            min-height: 100vh;

            margin: 0;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(37, 99, 235, 0.14),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 10%,
                    rgba(124, 58, 237, 0.10),
                    transparent 30%
                ),

                var(--sb-bg);

            transition:
                background 0.3s ease,
                color 0.3s ease;
        }


        /* ==========================================================
           DARK BODY
        ========================================================== */

        html[data-sb-theme="dark"] body {

            background:
                radial-gradient(
                    circle at 5% 0%,
                    rgba(59, 130, 246, 0.18),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 95% 10%,
                    rgba(139, 92, 246, 0.15),
                    transparent 30%
                ),

                #020617;

            color: #e2e8f0;
        }


        /* ==========================================================
           PAGE
        ========================================================== */

        .orders-page {

            min-height: 100vh;

            padding:
                40px 18px 80px;
        }


        .orders-container {

            width: 100%;

            max-width:
                none;

            margin: 0 auto;
        }


        /* ==========================================================
           HEADER
        ========================================================== */

        .orders-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
        }


        .brand-label {

            color:
                var(--sb-primary);

            font-size:
                11px;

            font-weight:
                900;

            letter-spacing:
                1.8px;

            margin-bottom:
                7px;
        }


        .orders-title {

            margin:
                0 0 6px;

            color:
                var(--sb-heading);

            font-size:
                34px;

            line-height:
                1.15;

            font-weight:
                950;

            letter-spacing:
                -0.8px;
        }


        .orders-subtitle {

            margin: 0;

            color:
                var(--sb-muted);

            font-size:
                13px;
        }


        /* ==========================================================
           CONTINUE SHOPPING
        ========================================================== */

        .continue-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            min-height:
                44px;

            padding:
                0 17px;

            border:
                1px solid
                var(--sb-border-strong);

            border-radius:
                12px;

            color:
                var(--sb-text);

            background:
                var(--sb-card);

            text-decoration:
                none;

            font-size:
                12px;

            font-weight:
                850;

            box-shadow:
                0 8px 25px
                rgba(15, 23, 42, 0.06);

            transition:
                all 0.22s ease;
        }


        .continue-btn:hover {

            color:
                var(--sb-primary);

            border-color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            transform:
                translateY(-2px);
        }


        /* ==========================================================
           SUCCESS
        ========================================================== */

        .theme-alert {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-bottom:
                20px;

            padding:
                14px 17px;

            border:
                1px solid
                rgba(34, 197, 94, 0.25);

            border-radius:
                14px;

            color:
                var(--sb-success);

            background:
                var(--sb-success-soft);

            font-size:
                13px;

            font-weight:
                800;
        }


        /* ==========================================================
           ORDER CARD
        ========================================================== */

        .order-card {

            margin-bottom:
                18px;

            padding:
                22px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                22px;

            background:
                var(--sb-card);

            color:
                var(--sb-text);

            box-shadow:
                var(--sb-shadow);

            backdrop-filter:
                blur(22px);

            -webkit-backdrop-filter:
                blur(22px);

            transition:
                background 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .order-card:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--sb-border-strong);

            background:
                var(--sb-card-hover);

            box-shadow:
                var(--sb-shadow);
        }


        /* ==========================================================
           ORDER HEADER
        ========================================================== */

        .order-number {

            color:
                var(--sb-heading);

            font-size:
                15px;

            font-weight:
                900;
        }


        .order-meta {

            color:
                var(--sb-muted);

            font-size:
                11px;
        }


        /* ==========================================================
           STATUS
        ========================================================== */

        .status-pill {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            min-height:
                30px;

            padding:
                5px 12px;

            border:
                1px solid
                rgba(59, 130, 246, 0.20);

            border-radius:
                999px;

            color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            font-size:
                10px;

            font-weight:
                900;

            text-transform:
                capitalize;
        }


        /* ==========================================================
           PRODUCT
        ========================================================== */

        .order-product {

            display: flex;

            align-items: center;

            gap: 15px;

            padding:
                14px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                17px;

            background:
                var(--sb-surface);

            transition:
                background 0.25s ease,
                border-color 0.25s ease;
        }


        .order-product:hover {

            border-color:
                var(--sb-border-strong);

            background:
                var(--sb-card-hover);
        }


        .order-product img {

            width:
                76px;

            height:
                76px;

            flex-shrink:
                0;

            object-fit:
                cover;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                13px;

            background:
                var(--sb-image-bg);
        }


        .product-name {

            margin-bottom:
                5px;

            color:
                var(--sb-heading);

            font-size:
                14px;

            font-weight:
                850;
        }


        /* ==========================================================
           FOOTER
        ========================================================== */

        .order-footer {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-top:
                5px;

            padding-top:
                18px;

            border-top:
                1px solid
                var(--sb-border);
        }


        .order-total {

            color:
                var(--sb-heading);

            font-size:
                15px;

            font-weight:
                900;
        }


        /* ==========================================================
           ACTIONS
        ========================================================== */

        .action-buttons {

            display: flex;

            align-items: center;

            gap: 8px;
        }


        /* ==========================================================
           TRACK BUTTON
        ========================================================== */

        .track-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            min-height:
                38px;

            padding:
                0 15px;

            border:
                0;

            border-radius:
                11px;

            color:
                #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            text-decoration:
                none;

            font-size:
                11px;

            font-weight:
                900;

            box-shadow:
                0 8px 22px
                rgba(37, 99, 235, 0.25);

            transition:
                all 0.22s ease;
        }


        html[data-sb-theme="dark"] .track-btn {

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #6366f1
                );

            box-shadow:
                0 10px 30px
                rgba(37, 99, 235, 0.40);
        }


        .track-btn:hover {

            color:
                #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #4338ca
                );

            transform:
                translateY(-2px);
        }


        /* ==========================================================
           CANCEL BUTTON
        ========================================================== */

        .cancel-btn {

            min-height:
                38px;

            padding:
                0 14px;

            border:
                1px solid
                var(--sb-danger);

            border-radius:
                11px;

            color:
                var(--sb-danger);

            background:
                var(--sb-danger-soft);

            font-size:
                11px;

            font-weight:
                900;

            transition:
                all 0.22s ease;
        }


        .cancel-btn:hover {

            color:
                #ffffff;

            background:
                var(--sb-danger);

            border-color:
                var(--sb-danger);

            transform:
                translateY(-1px);
        }


        /* ==========================================================
           EMPTY
        ========================================================== */

        .empty-card {

            text-align:
                center;

            padding:
                70px 25px;
        }


        .empty-icon {

            width:
                68px;

            height:
                68px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin:
                0 auto 18px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                18px;

            color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            font-size:
                26px;
        }


        .empty-title {

            margin-bottom:
                7px;

            color:
                var(--sb-heading);

            font-size:
                18px;

            font-weight:
                900;
        }


        .empty-text {

            margin:
                0;

            color:
                var(--sb-muted);

            font-size:
                12px;
        }


        /* ==========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 768px) {

            .orders-page {

                padding:
                    22px 12px 55px;
            }


            .orders-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .orders-title {

                font-size:
                    27px;
            }


            .continue-btn {

                width:
                    100%;
            }


            .order-card {

                padding:
                    16px;

                border-radius:
                    18px;
            }


            .order-footer {

                align-items:
                    stretch;

                flex-direction:
                    column;
            }


            .action-buttons {

                width:
                    100%;
            }


            .track-btn,
            .cancel-btn {

                flex:
                    1;
            }


            .order-product img {

                width:
                    64px;

                height:
                    64px;
            }


            .product-name {

                font-size:
                    13px;
            }

        }

    

        /* ==========================================================
           PRODUCTS PAGE — FULL WIDTH PREMIUM CUSTOMER TASKBAR
           Exact same taskbar styling used by Products page.
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



<main class="orders-page">

    <div class="orders-container">


        <!-- ======================================================
             HEADER
        ======================================================= -->

        <div class="orders-header">

            <div>

                <div class="brand-label">
                    SMART BASKET
                </div>

                <h1 class="orders-title">
                    My Orders
                </h1>

                <p class="orders-subtitle">
                    Follow every order from checkout to delivery.
                </p>

            </div>


            

        </div>


        <!-- ======================================================
             SUCCESS
        ======================================================= -->

        @if(session('success'))

            <div class="theme-alert">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- ======================================================
             ORDERS
        ======================================================= -->

        @forelse($orders as $order)

            <article class="order-card">


                <!-- ORDER HEADER -->

                <div
                    class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3"
                >

                    <div>

                        <div class="order-number">

                            <i class="fa-solid fa-receipt me-2"></i>

                            Order #{{ $order->id }}

                        </div>

                        <span class="order-meta">

                            {{ $order->created_at?->format('d M Y, h:i A') }}

                        </span>

                    </div>


                    <span class="status-pill">

                        <i
                            class="fa-solid fa-circle"
                            style="font-size:6px;"
                        ></i>

                        {{
                            $order->deliveryDetail?->status
                            ?? $order->order_status
                            ?? 'Order Placed'
                        }}

                    </span>

                </div>


                <!-- PRODUCTS -->

                @foreach($order->items ?? [] as $item)

                    @php

                        $product =
                            $products[$item['product_id'] ?? null]
                            ?? null;

                    @endphp


                    <div class="order-product mb-3">


                        <img
                            src="{{
                                $product && $product->image
                                    ? asset(
                                        'products/' .
                                        $product->image
                                    )
                                    : 'https://placehold.co/160x160/1E293B/FFFFFF?text=Product'
                            }}"
                            alt="{{ $item['name'] ?? 'Product' }}"
                        >


                        <div class="flex-grow-1">

                            <div class="product-name">

                                {{
                                    $item['name']
                                    ?? $product?->name
                                    ?? 'Product'
                                }}

                            </div>


                            <div class="order-meta">

                                Quantity:
                                {{ $item['quantity'] ?? 1 }}

                                <span class="mx-1">·</span>

                                ₹{{ number_format(
                                    (float) ($item['price'] ?? 0),
                                    2
                                ) }}

                            </div>

                        </div>


                    </div>

                @endforeach


                <!-- ORDER FOOTER -->

                <div class="order-footer">


                    <div class="order-total">

                        Total:

                        ₹{{ number_format(
                            (float) ($order->amount ?? $order->total),
                            2
                        ) }}

                    </div>


                    <div class="action-buttons">


                        <a
                            href="{{ route('orders.show', $order) }}"
                            class="track-btn"
                        >

                            <i class="fa-solid fa-location-dot"></i>

                            Track Order

                        </a>


                        @if($order->isCancellable())

                            <form
                                action="{{ route('orders.cancel', $order) }}"
                                method="POST"
                                onsubmit="return confirm('Cancel this order? This cannot be undone.');"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="cancel-btn"
                                >

                                    <i class="fa-solid fa-xmark me-1"></i>

                                    Cancel Order

                                </button>

                            </form>

                        @endif


                    </div>

                </div>


            </article>

        @empty


            <div class="order-card empty-card">

                <div class="empty-icon">

                    <i class="fa-solid fa-box-open"></i>

                </div>

                <div class="empty-title">

                    No orders yet

                </div>

                <p class="empty-text">

                    Your placed orders will appear here.

                </p>

            </div>


        @endforelse


    </div>

</main>




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

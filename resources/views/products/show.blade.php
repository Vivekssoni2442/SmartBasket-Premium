<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $product->name }} | SMART BASKET
    </title>


    <script>
        (() => {

            const saved =
                localStorage.getItem('sb-theme');

            const userTheme =
                @auth
                    @json(auth()->user()->theme ?? 'dark')
                @else
                    'dark'
                @endauth;

            const theme =
                ['light','dark'].includes(saved)
                    ? saved
                    : (
                        ['light','dark'].includes(userTheme)
                            ? userTheme
                            : 'dark'
                    );

            document.documentElement
                .setAttribute(
                    'data-theme',
                    theme
                );

        })();
    </script>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    <style>

        :root {

            --bg:#f5f7fb;

            --card:#ffffff;

            --card2:#f8fafc;

            --text:#102033;

            --muted:#718096;

            --border:#e2e8f0;

            --primary:#2563eb;

            --primary2:#7c3aed;

            --success:#16a34a;

            --danger:#e05b72;

            --shadow:
                0 20px 60px rgba(15,23,42,.09);

            --menu-shadow:
                0 25px 70px rgba(15,23,42,.18);

        }


        html[data-theme="dark"] {

            --bg:#07111f;

            --card:#0e1b2d;

            --card2:#14263d;

            --text:#f4f8ff;

            --muted:#9aacc1;

            --border:#29405c;

            --primary:#70a8ff;

            --primary2:#8b7cff;

            --success:#45cf8c;

            --danger:#ef8095;

            --shadow:
                0 25px 70px rgba(0,0,0,.35);

            --menu-shadow:
                0 28px 80px rgba(0,0,0,.48);

        }


        * {
            box-sizing:border-box;
        }


        html {
            scroll-behavior:smooth;
            background:var(--bg);
        }


        body {

            margin:0;

            min-height:100vh;

            color:var(--text);

            font-family:
                Inter,
                Poppins,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 0 0,
                    rgba(37,99,235,.12),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 100% 5%,
                    rgba(124,58,237,.10),
                    transparent 28%
                ),
                var(--bg);

        }


        a {
            text-decoration:none !important;
        }


        /* =====================================================
           TOP
        ====================================================== */

        .wrap {

            max-width:1320px;

            margin:auto;

            padding:
                25px 20px 70px;

        }


        .top {

            position:sticky;

            top:12px;

            z-index:3000;

            display:flex;

            justify-content:space-between;

            align-items:center;

            gap:15px;

            padding:
                13px 17px;

            margin-bottom:22px;

            background:
                color-mix(
                    in srgb,
                    var(--card) 93%,
                    transparent
                );

            border:
                1px solid var(--border);

            border-radius:
                20px;

            box-shadow:
                var(--shadow);

            backdrop-filter:
                blur(20px);

        }


        .brand {

            display:flex;

            align-items:center;

            gap:11px;

            color:var(--text);

            font-weight:950;

        }


        .brand-icon {

            width:44px;

            height:44px;

            display:grid;

            place-items:center;

            border-radius:14px;

            color:#fff;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            box-shadow:
                0 12px 28px
                rgba(37,99,235,.25);

        }


        .brand-text strong {

            display:block;

            color:var(--primary);

            font-size:14px;

            letter-spacing:.13em;

        }


        .brand-text small {

            display:block;

            margin-top:3px;

            color:var(--muted);

            font-size:9px;

            letter-spacing:.13em;

        }


        /* =====================================================
           3 DOT MENU
        ====================================================== */

        .menu-wrap {

            position:relative;

        }


        .menu-button {

            width:48px;

            height:48px;

            display:grid;

            place-items:center;

            border:
                1px solid var(--border);

            border-radius:15px;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:20px;

            cursor:pointer;

            transition:.2s ease;

            box-shadow:
                0 8px 24px var(--shadow);

        }


        .menu-button:hover,
        .menu-button.active {

            color:#fff;

            border-color:transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            transform:
                translateY(-2px);

        }


        .customer-menu {

            position:absolute;

            right:0;

            top:
                calc(100% + 12px);

            width:285px;

            padding:10px;

            border:
                1px solid var(--border);

            border-radius:20px;

            background:
                var(--card);

            box-shadow:
                var(--menu-shadow);

            backdrop-filter:
                blur(25px);

            opacity:0;

            visibility:hidden;

            transform:
                translateY(-8px)
                scale(.97);

            transform-origin:
                top right;

            transition:.2s ease;

        }


        .customer-menu.open {

            opacity:1;

            visibility:visible;

            transform:
                translateY(0)
                scale(1);

        }


        .menu-header {

            padding:
                13px 14px;

            margin-bottom:6px;

            border-radius:15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.07)
                );

            border:
                1px solid var(--border);

        }


        .menu-header strong {

            display:block;

            color:var(--text);

            font-size:14px;

            font-weight:900;

        }


        .menu-header span {

            display:block;

            margin-top:3px;

            color:var(--muted);

            font-size:11px;

        }


        .menu-item {

            width:100%;

            display:flex;

            align-items:center;

            gap:12px;

            padding:12px;

            margin:3px 0;

            border:
                1px solid transparent;

            border-radius:13px;

            background:transparent;

            color:var(--text);

            font-size:12px;

            font-weight:800;

            transition:.18s ease;

        }


        .menu-item:hover {

            color:var(--primary);

            background:var(--card2);

            border-color:var(--border);

            transform:
                translateX(3px);

        }


        .menu-icon {

            width:35px;

            height:35px;

            display:grid;

            place-items:center;

            flex-shrink:0;

            border-radius:11px;

            color:var(--primary);

            background:
                rgba(37,99,235,.10);

        }


        .menu-divider {

            height:1px;

            margin:
                8px 4px;

            background:
                var(--border);

        }


        .menu-item.logout {

            color:
                var(--danger);

        }


        .menu-item.logout
        .menu-icon {

            color:
                var(--danger);

            background:
                rgba(224,91,114,.10);

        }


        .menu-overlay {

            position:fixed;

            inset:0;

            z-index:2500;

            background:
                rgba(2,6,23,.18);

            backdrop-filter:
                blur(2px);

            opacity:0;

            visibility:hidden;

            transition:.2s ease;

        }


        .menu-overlay.open {

            opacity:1;

            visibility:visible;

        }


        /* =====================================================
           PRODUCT
        ====================================================== */

        .product-shell {

            padding:
                25px;

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius:
                28px;

            box-shadow:
                var(--shadow);

        }


        /* =====================================================
           GALLERY
        ====================================================== */

        .gallery-box {

            height:560px;

            display:grid;

            place-items:center;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                24px;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.10),
                    transparent 62%
                ),
                var(--card2);

        }


        .main-image {

            width:100%;

            height:100%;

            object-fit:contain;

            padding:28px;

            transition:.35s ease;

        }


        .main-image:hover {

            transform:
                scale(1.025);

        }


        .thumbs {

            display:flex;

            gap:9px;

            flex-wrap:wrap;

            margin-top:13px;

        }


        .thumb {

            width:72px;

            height:72px;

            padding:3px;

            overflow:hidden;

            border:
                2px solid var(--border);

            border-radius:14px;

            background:
                var(--card);

            cursor:pointer;

            transition:.2s ease;

        }


        .thumb:hover,
        .thumb.active {

            border-color:
                var(--primary);

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px var(--shadow);

        }


        .thumb img {

            width:100%;

            height:100%;

            object-fit:cover;

            border-radius:9px;

        }


        /* =====================================================
           PRODUCT INFO
        ====================================================== */

        .info {

            padding:
                8px 6px;

        }


        .category {

            display:inline-flex;

            padding:
                7px 11px;

            border-radius:
                999px;

            color:
                var(--primary);

            background:
                rgba(37,99,235,.10);

            font-size:
                10px;

            font-weight:
                950;

            text-transform:
                uppercase;

            letter-spacing:
                .08em;

        }


        .title {

            margin:
                15px 0 10px;

            color:
                var(--text);

            font-size:
                clamp(
                    30px,
                    4vw,
                    48px
                );

            line-height:
                1.04;

            letter-spacing:
                -.045em;

            font-weight:
                950;

        }


        .desc {

            margin:0;

            color:
                var(--muted);

            line-height:
                1.8;

            font-size:
                14px;

        }


        /* =====================================================
           PRICE
        ====================================================== */

        .price-row {

            display:flex;

            align-items:center;

            gap:11px;

            flex-wrap:wrap;

            margin:
                21px 0;

        }


        .price {

            color:
                var(--text);

            font-size:
                35px;

            font-weight:
                950;

        }


        .old {

            color:
                var(--muted);

            font-size:
                13px;

            text-decoration:
                line-through;

        }


        .discount {

            padding:
                7px 10px;

            border-radius:
                9px;

            color:
                var(--success);

            background:
                rgba(22,163,74,.11);

            font-size:
                11px;

            font-weight:
                900;

        }


        /* =====================================================
           DETAILS
        ====================================================== */

        .details {

            display:grid;

            grid-template-columns:
                repeat(2,1fr);

            gap:9px;

            margin-top:
                18px;

        }


        .detail {

            padding:
                14px;

            border:
                1px solid var(--border);

            border-radius:
                14px;

            background:
                var(--card2);

            transition:.2s ease;

        }


        .detail:hover {

            border-color:
                var(--primary);

            transform:
                translateY(-2px);

        }


        .label {

            display:block;

            margin-bottom:
                4px;

            color:
                var(--muted);

            font-size:
                10px;

        }


        .value {

            color:
                var(--text);

            font-size:
                13px;

            font-weight:
                850;

        }


        /* =====================================================
           SELLER
        ====================================================== */

        .seller {

            margin-top:
                18px;

            padding:
                16px;

            border:
                1px solid var(--border);

            border-radius:
                17px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.05)
                );

        }


        .seller strong {

            display:block;

            margin:
                5px 0 2px;

            color:
                var(--text);

            font-size:
                16px;

        }


        .seller span {

            color:
                var(--muted);

            font-size:
                11px;

        }


        /* =====================================================
           BUTTONS
        ====================================================== */

        .actions {

            display:flex;

            flex-wrap:wrap;

            gap:9px;

            margin-top:
                19px;

        }


        .btnx {

            min-height:
                46px;

            display:inline-flex;

            align-items:center;

            justify-content:center;

            gap:7px;

            padding:
                10px 16px;

            border:
                1px solid var(--border);

            border-radius:
                12px;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:
                12px;

            font-weight:
                850;

            cursor:pointer;

            transition:.2s ease;

        }


        .btnx:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--primary);

            color:
                var(--primary);

        }


        .primary {

            color:#fff !important;

            border-color:
                transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

        }


        .primary:hover {

            color:#fff !important;

        }


        .success {

            color:#fff !important;

            border-color:
                transparent;

            background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );

        }


        .success:hover {

            color:#fff !important;

        }


        /* =====================================================
           QUANTITY
        ====================================================== */

        .qty {

            height:46px;

            display:inline-flex;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                12px;

            background:
                var(--card);

        }


        .qty button {

            width:43px;

            border:0;

            background:
                var(--card2);

            color:
                var(--text);

            font-size:
                19px;

            cursor:pointer;

        }


        .qty input {

            width:56px;

            border:0;

            border-left:
                1px solid var(--border);

            border-right:
                1px solid var(--border);

            outline:0;

            text-align:center;

            background:
                var(--card);

            color:
                var(--text);

        }


        /* =====================================================
           AI TRY ON
        ====================================================== */

        .ai {

            margin-top:
                24px;

            padding:
                21px;

            border:
                1px solid var(--border);

            border-radius:
                21px;

            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.10),
                    rgba(124,58,237,.06)
                );

        }


        .ai h2 {

            margin-bottom:
                7px;

            color:
                var(--text);

            font-size:
                20px;

            font-weight:
                950;

        }


        .ai p {

            color:
                var(--muted);

            font-size:
                12px;

        }


        .ai .form-control {

            background:
                var(--card);

            border-color:
                var(--border);

            color:
                var(--text);

        }


        #tryOnPreview,
        #tryOnResult {

            width:100%;

            max-height:
                520px;

            object-fit:
                contain;

            border:
                1px solid var(--border);

            border-radius:
                17px;

            box-shadow:
                var(--shadow);

        }


        /* =====================================================
           RELATED
        ====================================================== */

        .related {

            margin-top:
                34px;

        }


        .related-head {

            display:flex;

            align-items:center;

            justify-content:space-between;

            gap:15px;

            margin-bottom:
                15px;

        }


        .related-head h2 {

            margin:0;

            color:
                var(--text);

            font-size:
                26px;

            font-weight:
                950;

        }


        .view-all {

            display:inline-flex;

            align-items:center;

            gap:7px;

            padding:
                10px 13px;

            border:
                1px solid var(--border);

            border-radius:
                11px;

            background:
                var(--card);

            color:
                var(--text);

            font-size:
                11px;

            font-weight:
                850;

        }


        .view-all:hover {

            color:
                var(--primary);

            border-color:
                var(--primary);

        }


        .related-card {

            height:100%;

            display:block;

            overflow:hidden;

            border:
                1px solid var(--border);

            border-radius:
                19px;

            background:
                var(--card);

            box-shadow:
                0 10px 35px var(--shadow);

            transition:.25s ease;

        }


        .related-card:hover {

            transform:
                translateY(-6px);

            border-color:
                var(--primary);

        }

        .related-card--clickable { cursor:pointer; }

        .related-view-product {
            display:inline-flex;
            align-items:center;
            margin:0 12px 13px;
            padding:7px 10px;
            border-radius:9px;
            background:var(--primary);
            color:#fff;
            font-size:12px;
            font-weight:800;
            text-decoration:none;
        }

        .related-view-product:hover { color:#fff; filter:brightness(1.06); }


        .related-img {

            width:100%;

            height:195px;

            object-fit:contain;

            padding:10px;

            background:
                var(--card2);

        }


        .related-body {

            padding:
                14px;

        }


        .related-title {

            color:
                var(--text);

            font-size:
                13px;

            font-weight:
                850;

        }


        .related-price {

            margin-top:
                5px;

            color:
                var(--primary);

            font-size:
                15px;

            font-weight:
                950;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media(max-width:991px) {

            .gallery-box {
                height:430px;
            }

        }


        @media(max-width:575px) {

            .wrap {
                padding:
                    12px 12px 50px;
            }

            .top {
                top:8px;

                border-radius:
                    16px;
            }

            .brand-text small {
                display:none;
            }

            .menu-button {
                width:43px;
                height:43px;
            }

            .customer-menu {

                position:fixed;

                top:70px;

                right:12px;

                width:
                    min(
                        300px,
                        calc(100vw - 24px)
                    );

            }

            .product-shell {

                padding:
                    13px;

                border-radius:
                    20px;

            }

            .gallery-box {

                height:
                    330px;

                border-radius:
                    18px;

            }

            .main-image {
                padding:
                    15px;
            }

            .details {
                grid-template-columns:
                    1fr;
            }

            .actions > * {
                width:
                    100%;
            }

            .btnx {
                width:
                    100%;
            }

            .related-head {
                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

        }

/* =========================================================
   PRODUCTS PAGE — FULL WIDTH PREMIUM TASKBAR
========================================================= */
























/* AI HUB left button: existing project component remains the single left-side AI HUB launcher */
.ai-hub-fab{z-index:99980!important}.ai-hub-drawer{z-index:99999!important}
html[data-theme="light"] .ai-hub-drawer{background:linear-gradient(145deg,rgba(255,255,255,.99),rgba(242,246,252,.99))!important;color:#101828!important;border-right-color:rgba(37,99,235,.14)!important;box-shadow:24px 0 70px rgba(15,23,42,.20)!important}
html[data-theme="light"] .ai-hub-drawer-header strong,html[data-theme="light"] .ai-hub-tool-text strong{color:#101828!important}html[data-theme="light"] .ai-hub-drawer-header small,html[data-theme="light"] .ai-hub-tool-text small{color:#667085!important}
html[data-theme="light"] .ai-hub-fab{background:linear-gradient(145deg,#fff,#eef4ff)!important;color:#172033!important;border-color:rgba(37,99,235,.25)!important}
html[data-theme="dark"] .ai-hub-drawer{background:linear-gradient(145deg,#09111f,#020711)!important}html[data-theme="dark"] .ai-hub-fab{background:linear-gradient(145deg,#1e293b,#050a14)!important}

/* Robot launcher is hidden; its original panel remains fully functional */






        /* =====================================================
           PRODUCT DETAIL — PREMIUM REDESIGN
           Full-width page + crystal-clear product imagery
        ====================================================== */
        .wrap.product-detail-page{
            width:100%;
            max-width:none;
            margin:0;
            padding:28px 24px 90px;
        }
        .product-detail-page .product-shell{
            width:100%;
            max-width:1600px;
            margin:0 auto;
            padding:clamp(16px,2.2vw,34px);
            border-radius:32px;
            background:linear-gradient(145deg,var(--card),color-mix(in srgb,var(--card2) 38%,var(--card)));
            border:1px solid color-mix(in srgb,var(--primary) 13%,var(--border));
            box-shadow:0 28px 90px rgba(15,23,42,.11);
            position:relative;
            overflow:hidden;
        }
        html[data-theme="dark"] .product-detail-page .product-shell{
            box-shadow:0 30px 100px rgba(0,0,0,.38);
        }
        .product-detail-page .product-shell:before{
            content:"";position:absolute;inset:0;pointer-events:none;
            background:radial-gradient(circle at 5% 0%,rgba(37,99,235,.10),transparent 30%),radial-gradient(circle at 100% 0%,rgba(124,58,237,.09),transparent 28%);
        }
        .product-detail-page .product-shell > .row{position:relative;z-index:1}

        .product-detail-page .gallery-box{
            position:relative;
            height:clamp(430px,62vh,680px);
            min-height:430px;
            width:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:14px;
            overflow:hidden;
            border-radius:28px;
            border:1px solid color-mix(in srgb,var(--primary) 12%,var(--border));
            background:
                radial-gradient(circle at 50% 42%,rgba(255,255,255,.98),rgba(248,250,252,.78) 52%,rgba(226,232,240,.48) 100%),
                var(--card2);
            box-shadow:inset 0 1px 0 rgba(255,255,255,.65),0 20px 60px rgba(15,23,42,.08);
        }
        html[data-theme="dark"] .product-detail-page .gallery-box{
            background:radial-gradient(circle at 50% 42%,#17263a 0,#101e31 52%,#0a1525 100%);
            box-shadow:inset 0 1px 0 rgba(255,255,255,.05),0 24px 70px rgba(0,0,0,.30);
        }
        .product-detail-page .main-image{
            width:100%;
            height:100%;
            max-width:100%;
            max-height:100%;
            object-fit:contain;
            object-position:center;
            padding:4px;
            display:block;
            filter:drop-shadow(0 22px 30px rgba(15,23,42,.16));
            transition:transform .4s cubic-bezier(.2,.8,.2,1),filter .3s ease;
        }
        .product-detail-page #mainProductVideo{background:#05070d;border-radius:18px;object-fit:contain}
        .gallery-nav{position:absolute;z-index:2;top:50%;transform:translateY(-50%);width:42px;height:42px;border:1px solid var(--border);border-radius:50%;background:color-mix(in srgb,var(--card) 90%,transparent);color:var(--text);box-shadow:0 8px 24px rgba(15,23,42,.18)}
        .gallery-prev{left:18px}.gallery-next{right:18px}
        .gallery-video-thumb{height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;color:var(--primary);font-size:20px}
        .gallery-video-thumb small{font-size:8px;font-weight:900;letter-spacing:.1em}
        @media(max-width:575px){.gallery-nav{width:36px;height:36px}.gallery-prev{left:9px}.gallery-next{right:9px}}
        .product-detail-page .main-image:hover{
            transform:scale(1.035);
            filter:drop-shadow(0 28px 38px rgba(15,23,42,.22));
        }
        .product-detail-page .thumbs{gap:10px;margin-top:14px;padding:2px}
        .product-detail-page .thumb{
            width:78px;height:78px;padding:4px;border-radius:15px;
            background:var(--card);border:2px solid var(--border);
            box-shadow:0 8px 20px rgba(15,23,42,.07);
        }
        .product-detail-page .thumb.active{border-color:var(--primary);box-shadow:0 10px 25px rgba(37,99,235,.20)}
        .product-detail-page .info{padding:4px 4px 4px 12px}
        .product-detail-page .category{box-shadow:0 7px 20px rgba(37,99,235,.08)}
        .product-detail-page .title{font-size:clamp(32px,4vw,58px);line-height:1.02;margin:14px 0 12px}
        .product-detail-page .desc{font-size:14px;max-width:760px}
        .product-detail-page .price-row{margin:22px 0 18px}
        .product-detail-page .price{font-size:clamp(32px,3vw,42px)}
        .product-detail-page .details{gap:11px;margin-top:20px}
        .product-detail-page .detail{padding:15px;border-radius:16px;background:color-mix(in srgb,var(--card2) 88%,transparent);box-shadow:0 7px 22px rgba(15,23,42,.04)}
        .product-detail-page .seller{border-radius:18px;box-shadow:0 12px 30px rgba(37,99,235,.06)}
        .product-detail-page .actions{gap:10px;margin-top:20px}
        .product-detail-page .btnx{min-height:48px;border-radius:13px;padding:10px 17px;box-shadow:0 7px 18px rgba(15,23,42,.06)}
        .product-detail-page .btnx.primary,.product-detail-page .btnx.success{box-shadow:0 12px 26px rgba(37,99,235,.18)}
        .product-detail-page .qty{height:48px;border-radius:13px}
        .product-detail-page .ai{margin-top:26px;border-radius:23px;padding:23px;box-shadow:0 15px 38px rgba(37,99,235,.07)}
        .product-detail-page #tryOnPreview,.product-detail-page #tryOnResult{max-height:560px;background:var(--card2);object-fit:contain;padding:4px}
        .tryon-product-ref{display:flex;align-items:center;gap:13px;padding:12px;margin:12px 0 18px;border:1px solid var(--border);border-radius:16px;background:var(--card)}
        .tryon-product-ref img{width:76px;height:76px;object-fit:contain;border-radius:12px;background:var(--card2)}
        .tryon-product-ref div{display:flex;flex-direction:column;gap:4px;min-width:0}
        .tryon-product-ref small,.tryon-product-ref span{font-size:11px;color:var(--muted)}
        .tryon-product-ref strong{color:var(--text);font-size:14px}
        #tryOnPreview{max-height:320px;object-fit:contain;background:var(--card2);padding:6px}
        #tryOnResult,#tryOnOriginal,#tryOnComparisonResult{max-height:520px;object-fit:contain;background:var(--card2);padding:6px}
        #tryOnForm.is-processing{opacity:.72;pointer-events:none}
        .product-ai-studio{margin-top:26px;padding:clamp(18px,3vw,28px);border:1px solid rgba(112,91,230,.25);border-radius:24px;background:linear-gradient(145deg,color-mix(in srgb,var(--card) 96%,#ebe9ff),var(--card));box-shadow:0 18px 48px rgba(77,65,170,.10)}
        .product-ai-studio__heading{display:flex;align-items:flex-start;gap:14px}
        .product-ai-studio__badge,.product-ai-message__avatar{display:grid;place-items:center;flex:0 0 auto;width:42px;height:42px;border:1px solid rgba(125,105,255,.24);border-radius:14px;background:linear-gradient(145deg,#f0edff,#e1e7ff);color:#604ee0;font-size:22px}
        .product-ai-studio__eyebrow{margin:0 0 4px;color:#6758cc;font-size:10px;font-weight:900;letter-spacing:1.4px}
        .product-ai-studio__heading h2{margin:0;color:var(--text);font-size:clamp(19px,2.2vw,25px);font-weight:850}
        .product-ai-studio__heading p:last-child{margin:6px 0 0;color:var(--muted);font-size:13px;line-height:1.6}
        .product-ai-chat{display:grid;gap:14px;max-height:460px;overflow:auto;margin-top:22px;padding:15px;border:1px solid var(--border);border-radius:18px;background:color-mix(in srgb,var(--card2) 80%,transparent)}
        .product-ai-message{display:flex;align-items:flex-start;gap:10px;max-width:min(92%,680px)}
        .product-ai-message--user{justify-self:end;padding:11px 14px;border:1px solid rgba(91,76,220,.16);border-radius:17px 17px 4px 17px;background:linear-gradient(135deg,#f1efff,#e7edff)}
        .product-ai-message p{margin:0;color:var(--text);font-size:13px;line-height:1.6}
        .product-ai-message__avatar{width:30px;height:30px;border-radius:10px;font-size:16px}
        .product-ai-message__result{display:block;width:min(100%,520px);max-height:520px;object-fit:contain;margin:12px 0 0;border:1px solid var(--border);border-radius:16px;background:var(--card)}
        .product-ai-message__actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
        .product-ai-message__actions a,.product-ai-message__actions button{min-height:36px;padding:7px 11px;border:1px solid var(--border);border-radius:10px;background:var(--card);color:var(--text);font-size:12px;font-weight:750;text-decoration:none;cursor:pointer}
        .product-ai-prompts{display:flex;flex-wrap:wrap;gap:8px;margin:12px 0}
        .product-ai-prompts button{padding:8px 11px;border:1px solid rgba(112,91,230,.22);border-radius:999px;background:color-mix(in srgb,var(--card) 88%,#e8e6ff);color:var(--text);font-size:11px;font-weight:700;cursor:pointer;transition:transform .2s,border-color .2s,box-shadow .2s}
        .product-ai-prompts button:hover{transform:translateY(-1px);border-color:#8172ed;box-shadow:0 6px 18px rgba(91,76,220,.12)}
        .product-ai-composer{padding:11px;border:1px solid var(--border);border-radius:17px;background:var(--card);box-shadow:0 8px 24px rgba(15,23,42,.05)}
        .product-ai-composer textarea{display:block;width:100%;resize:vertical;min-height:58px;border:0;outline:0;background:transparent;color:var(--text);font:inherit;font-size:13px}
        .product-ai-composer__bottom{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-top:9px;border-top:1px solid var(--border)}
        .product-ai-consent{display:flex;align-items:flex-start;gap:7px;max-width:65%;color:var(--muted);font-size:10px;line-height:1.45}
        .product-ai-consent input{margin-top:2px;accent-color:#6c5ce7}
        .product-ai-composer .btnx{min-height:40px;padding:8px 13px;font-size:12px}
        .product-ai-composer .btnx:disabled{opacity:.5;cursor:not-allowed}
        .product-ai-status{margin:9px 2px 0;color:var(--muted);font-size:10px;line-height:1.5}
        .product-ai-status.is-error{color:#c24153}
        .product-ai-status.is-loading{color:#6758cc}
        @media(max-width:575px){.tryon-product-ref img{width:60px;height:60px}.tryon-product-ref{align-items:flex-start}}
        .product-detail-page .related{max-width:1600px;margin:42px auto 0}
        .product-detail-page .related-card{border-radius:20px;box-shadow:0 14px 42px rgba(15,23,42,.09)}
        .product-detail-page .related-img{height:220px;padding:14px;object-fit:contain;background:linear-gradient(145deg,var(--card2),var(--card))}
        .product-detail-page .related-body{padding:15px}

        /* Canonical Products-page taskbar takes the place of the old detail-page topbar. */


        @media(max-width:991px){
            .wrap.product-detail-page{padding:18px 14px 60px}
            .product-detail-page .product-shell{padding:16px;border-radius:25px}
            .product-detail-page .info{padding:6px 2px}
            .product-detail-page .gallery-box{height:520px;min-height:360px}
        }
        @media(max-width:575px){
            .wrap.product-detail-page{padding:12px 10px 50px}
            .product-detail-page .product-shell{padding:10px;border-radius:20px}
            .product-detail-page .gallery-box{height:390px;min-height:300px;padding:8px;border-radius:19px}
            .product-detail-page .main-image{padding:0}
            .product-detail-page .thumb{width:66px;height:66px}
            .product-detail-page .title{font-size:32px}
            .product-detail-page .actions>*{width:100%}
            .product-detail-page .btnx{width:100%}
            .product-ai-composer__bottom{align-items:stretch;flex-direction:column}
            .product-ai-consent{max-width:100%}
            .product-ai-composer .btnx{width:100%}
            .product-ai-message{max-width:100%}
        }

        .product-promotion { margin: 18px 0; padding: 17px 19px; border: 1px solid rgba(114,146,208,.24); border-radius: 18px; color: var(--text); background: linear-gradient(135deg,var(--card),var(--card2)); box-shadow: var(--shadow); }
        .product-promotion__sale { border-color: rgba(249,115,22,.28); background: linear-gradient(120deg,rgba(249,115,22,.12),var(--card) 55%,rgba(234,179,8,.10)); }
        .product-promotion__coupon { border-color: rgba(99,102,241,.32); }
        .product-promotion__coupon[data-design="sunset"] { border-color: rgba(249,115,22,.38); background: linear-gradient(120deg,rgba(249,115,22,.16),var(--card),rgba(236,72,153,.10)); }
        .product-promotion__coupon[data-design="emerald"] { border-color: rgba(16,185,129,.38); background: linear-gradient(120deg,rgba(16,185,129,.15),var(--card),rgba(20,184,166,.09)); }
        .product-promotion__coupon[data-design="gold"] { border-color: rgba(234,179,8,.42); background: linear-gradient(120deg,rgba(234,179,8,.16),var(--card),rgba(245,158,11,.09)); }
        .product-promotion__eyebrow { margin-bottom: 5px; color: var(--muted); font-size: .72rem; font-weight: 800; letter-spacing: .11em; text-transform: uppercase; }
        .product-promotion__title { margin: 0; color: var(--text); font-size: 1.08rem; font-weight: 850; }
        .product-promotion__body { margin: 6px 0 0; color: var(--muted); line-height: 1.55; }
        .product-promotion__code { display: inline-flex; align-items:center; gap:8px; margin-top:12px; padding:8px 12px; border:1px dashed rgba(99,102,241,.52); border-radius:10px; color:var(--text); background:rgba(99,102,241,.08); font:inherit; font-weight:850; letter-spacing:.08em; cursor:pointer; }
        .product-countdown { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
        .product-countdown span { min-width:55px; padding:7px 9px; border:1px solid rgba(114,146,208,.22); border-radius:10px; color:var(--text); background:var(--card); text-align:center; font-size:.78rem; font-weight:800; }
        .product-countdown small { display:block; color:var(--muted); font-size:.58rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }

    </style>

    <style data-visual-design>{!! app(\App\Services\WebsiteDesignService::class)->renderCss('customer.product_detail') . app(\App\Services\WebsiteDesignService::class)->renderCss('customer.shared') !!}</style>

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>


<body>


{{-- =========================================================
     SMART BASKET — COMMON PREMIUM CUSTOMER TASKBAR
     Same Products-page taskbar + same 3-dot menu.
========================================================= --}}

@auth
@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index') ? 'orders.index' : (Route::has('orders') ? 'orders' : null);
@endphp

<x-products-customer-taskbar :include-robot="false" />
@endauth

<div class="sb-products-smart-ai-host" aria-hidden="false">
    <x-smart-ai-robot />
</div>

<x-ai-hub-sidebar :without-menu="true" />




<div class="wrap product-detail-page">

    <x-customer-page-hero :title="$product->name" />


    <!-- =====================================================
         PRODUCT
    ====================================================== -->

    <div class="product-shell">

        <div class="row g-4">


            <!-- GALLERY -->

            <div class="col-lg-6">

                @php

                    $gallery = collect([
                        [
                            'type' => 'image',
                            'url' =>
                                asset(
                                    'products/' .
                                    $product->image
                                ),

                            'label' => 'Main',

                            'image_id' => null
                        ]
                    ])->merge(

                        $product->images->map(
                            fn($image) => [
                                'type' => 'image',
                                'url' =>
                                    asset(
                                        'storage/' .
                                        $image->path
                                    ),

                                'label' =>
                                    'Product view',

                                'image_id' =>
                                    $image->id
                            ]
                        )
                    )->merge(collect($product->video ? [[
                        'type' => 'video',
                        'url' => asset('storage/' . ltrim($product->video, '/')),
                        'label' => 'Product video',
                        'image_id' => null,
                        'poster' => $product->video_poster ? asset('storage/' . ltrim($product->video_poster, '/')) : null,
                    ]] : [])->merge($product->videos->map(fn($video) => [
                        'type' => 'video',
                        'url' => asset('storage/' . ltrim($video->path, '/')),
                        'label' => 'Product video',
                        'image_id' => null,
                        'poster' => null,
                    ])));

                @endphp


                <div class="gallery-box" data-ve="customer.product_detail.gallery">

                    @if($gallery->count() > 1)<button type="button" class="gallery-nav gallery-prev" aria-label="Previous product media"><i class="fa-solid fa-chevron-left"></i></button>@endif
                    <img
                        id="mainProductImage"
                        src="{{ $gallery->first()['url'] }}"
                        class="main-image"
                        alt="{{ $product->name }}"
                        onerror="this.style.opacity='.25'"
                    >
                    <video id="mainProductVideo" class="main-image" style="display:none" controls playsinline preload="metadata" aria-label="Product video">
                        Your browser does not support product video playback.
                    </video>
                    @if($gallery->count() > 1)<button type="button" class="gallery-nav gallery-next" aria-label="Next product media"><i class="fa-solid fa-chevron-right"></i></button>@endif

                </div>


                @if($gallery->count() > 1)

                    <div class="thumbs">

                        @foreach($gallery as $index => $image)

                            <button
                                type="button"
                                class="thumb {{ $index === 0 ? 'active' : '' }}"
                                data-image="{{ $image['url'] }}"
                                data-media-type="{{ $image['type'] }}"
                                data-product-image-id="{{ $image['image_id'] }}"
                                data-poster="{{ $image['poster'] ?? '' }}"
                                aria-label="Show {{ $image['label'] }} {{ $index + 1 }}"
                            >
                                @if($image['type'] === 'video')
                                    <span class="gallery-video-thumb"><i class="fa-solid fa-play"></i><small>VIDEO</small></span>
                                @else
                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['label'] }}"
                                    loading="lazy"
                                >
                                @endif

                            </button>

                        @endforeach

                    </div>

                @endif

            </div>


            <!-- INFO -->

            <div class="col-lg-6">

                <div class="info">


                    @if($product->category)

                        <span class="category">
                            {{ $product->category }}
                        </span>

                    @endif


                    @php

                        $finalPrice = (float) $product->effective_price;
                        $hasDiscount = $finalPrice < (float) $product->price;

                        $discountPercent =
                            $hasDiscount &&
                            (float)$product->price > 0
                            ? round(
                                (
                                    1 -
                                    (
                                        $finalPrice /
                                        (float)$product->price
                                    )
                                ) * 100
                            )
                            : 0;

                    @endphp


                    <div class="price-row">

                        <span class="price">
                            ₹{{ number_format($finalPrice,2) }}
                        </span>

                        @if($hasDiscount)

                            <span class="old">
                                ₹{{ number_format((float)$product->price,2) }}
                            </span>

                            <span class="discount">
                                {{ $discountPercent }}% OFF
                            </span>

                        @endif

                    </div>

                    @php
                        $promoNow = now();
                        $saleIsScheduled = $product->sale_price !== null
                            && $product->sale_starts_at && $product->sale_ends_at
                            && $product->sale_ends_at->isAfter($promoNow)
                            && (float) $product->sale_price < (float) $product->price;
                        $saleIsLive = $saleIsScheduled && $product->sale_starts_at->lte($promoNow);
                        $saleCountdownTarget = $saleIsLive ? $product->sale_ends_at : $product->sale_starts_at;
                        $couponIsConfigured = filled($product->coupon_title) || filled($product->coupon_code);
                        $couponIsActive = $couponIsConfigured
                            && (!$product->coupon_starts_at || $product->coupon_starts_at->lte($promoNow))
                            && (!$product->coupon_ends_at || $product->coupon_ends_at->isAfter($promoNow));
                    @endphp

                    @if($saleIsScheduled)
                        <section class="product-promotion product-promotion__sale" aria-label="Product sale">
                            <div class="product-promotion__eyebrow"><i class="fa-solid fa-bolt"></i> {{ $saleIsLive ? 'Live sale' : 'Upcoming sale' }}</div>
                            <h2 class="product-promotion__title">{{ $product->sale_title ?: 'Limited time sale' }}</h2>
                            @if($product->sale_offer)<p class="product-promotion__body">{{ $product->sale_offer }}</p>@endif
                            <div class="product-promotion__body">{{ $saleIsLive ? 'Offer ends in' : 'Sale starts in' }}</div>
                            <div class="product-countdown" data-countdown="{{ $saleCountdownTarget->toIso8601String() }}" data-countdown-reload>
                                <span data-days>00<small>Days</small></span><span data-hours>00<small>Hours</small></span><span data-minutes>00<small>Minutes</small></span><span data-seconds>00<small>Seconds</small></span>
                            </div>
                        </section>
                    @endif

                    @if($couponIsActive)
                        <section class="product-promotion product-promotion__coupon" data-design="{{ in_array($product->coupon_design, ['royal','sunset','emerald','gold'], true) ? $product->coupon_design : 'royal' }}" aria-label="Product coupon">
                            <div class="product-promotion__eyebrow"><i class="fa-solid fa-ticket"></i> Seller coupon</div>
                            <h2 class="product-promotion__title">{{ $product->coupon_title ?: 'Special coupon' }}</h2>
                            @if($product->coupon_description)<p class="product-promotion__body">{{ $product->coupon_description }}</p>@endif
                            @if($product->coupon_discount_value !== null)<p class="product-promotion__body">{{ $product->coupon_discount_type === 'percent' ? number_format((float) $product->coupon_discount_value, 2) . '% off' : '₹' . number_format((float) $product->coupon_discount_value, 2) . ' off' }}</p>@endif
                            @if($product->coupon_code)<button type="button" class="product-promotion__code" data-copy-coupon="{{ $product->coupon_code }}"><i class="fa-regular fa-copy"></i> <span>{{ $product->coupon_code }}</span></button>@endif
                            @if($product->coupon_ends_at)<div class="product-promotion__body">Expires in</div><div class="product-countdown" data-countdown="{{ $product->coupon_ends_at->toIso8601String() }}" data-countdown-reload><span data-days>00<small>Days</small></span><span data-hours>00<small>Hours</small></span><span data-minutes>00<small>Minutes</small></span><span data-seconds>00<small>Seconds</small></span></div>@endif
                        </section>
                    @endif

                    @if($product->description)

                        <p class="desc">
                            {{ $product->description }}
                        </p>

                    @endif



                    <!-- DETAILS -->

                    <div class="details">

                        @if($product->brand)

                            <div class="detail">

                                <span class="label">
                                    Brand
                                </span>

                                <span class="value">
                                    {{ $product->brand }}
                                </span>

                            </div>

                        @endif


                        @if($product->rating !== null)

                            <div class="detail">

                                <span class="label">
                                    Rating
                                </span>

                                <span class="value">
                                    ⭐
                                    {{ number_format((float)$product->rating,1) }}
                                </span>

                            </div>

                        @endif


                        @if($product->stock !== null)

                            <div class="detail">

                                <span class="label">
                                    Available Stock
                                </span>

                                <span class="value">
                                    {{ $product->stock }}
                                </span>

                            </div>

                        @endif


                        @if($product->size)

                            <div class="detail">

                                <span class="label">
                                    Size
                                </span>

                                <span class="value">
                                    {{ $product->size }}
                                </span>

                            </div>

                        @endif


                        @if($product->color)

                            <div class="detail">

                                <span class="label">
                                    Color
                                </span>

                                <span class="value">
                                    {{ $product->color }}
                                </span>

                            </div>

                        @endif


                        @if($product->status)

                            <div class="detail">

                                <span class="label">
                                    Status
                                </span>

                                <span class="value">
                                    {{ ucfirst($product->status) }}
                                </span>

                            </div>

                        @endif

                    </div>


                    <!-- SELLER -->

                    @if($product->seller)

                        <div class="seller">

                            <span>
                                Sold by
                            </span>

                            <strong>
                                {{
                                    $product->seller->shop_name
                                    ?: $product->seller->seller_name
                                }}
                            </strong>

                            <span>

                                {{ $product->seller->seller_name }}

                                @if($product->seller->city)

                                    ·
                                    {{ $product->seller->city }}

                                @endif

                            </span>

                        </div>

                        @php
                            $sellerQrPath = ltrim((string) $product->seller->payment_qr, '/');
                            if (str_starts_with($sellerQrPath, 'storage/')) $sellerQrPath = substr($sellerQrPath, 8);
                            $sellerQrAvailable = $sellerQrPath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($sellerQrPath);
                        @endphp
                        @if($sellerQrAvailable)
                            <details class="seller-qr-panel" style="margin:14px 0;padding:14px;border:1px solid var(--border,#dbe3ef);border-radius:16px;background:var(--surface,#fff);">
                                <summary style="cursor:pointer;font-weight:700;">View {{ $product->seller->shop_name ?: $product->seller->seller_name }} QR Code</summary>
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sellerQrPath) }}" target="_blank" rel="noopener" aria-label="Enlarge {{ $product->seller->shop_name ?: $product->seller->seller_name }} payment QR code">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sellerQrPath) }}" alt="Payment QR code for {{ $product->seller->shop_name ?: $product->seller->seller_name }}" loading="lazy" style="display:block;width:min(260px,100%);max-height:300px;object-fit:contain;margin:14px auto 0;padding:10px;background:#fff;border-radius:12px;">
                                </a>
                                <small style="display:block;margin-top:10px;color:#64748b;">Showing this seller's QR does not verify payment or update order status.</small>
                            </details>
                        @endif

                    @endif


                    <!-- WISHLIST -->

                    <div class="actions">




                        @auth

                            <form
                                action="{{ route('wishlist.add',$product->id) }}"
                                method="POST"
                            >

                                @csrf



                            </form>

                        @endauth

                    </div>


                    <!-- CART -->

                    <form
                        action="{{ route('cart.add',$product) }}"
                        method="POST"
                        class="actions"
                    >

                        @csrf


                        <div>

                            <span class="label mb-1">
                                Quantity
                            </span>


                            <div class="qty">

                                <button
                                    type="button"
                                    id="quantityMinus"
                                >
                                    −
                                </button>


                                <input
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    @if($product->stock!==null)
                                        max="{{ max(1,(int)$product->stock) }}"
                                    @endif
                                    type="number"
                                >


                                <button
                                    type="button"
                                    id="quantityPlus"
                                >
                                    +
                                </button>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btnx primary"
                            {{ $product->stock!==null && (int)$product->stock<1 ? 'disabled' : '' }}
                        >

                            <i class="fa-solid fa-cart-plus"></i>

                            Add to Cart

                        </button>


                        <a
                            class="btnx success"
                            href="{{ url('/buy-now/'.$product->id) }}"
                        >

                            <i class="fa-solid fa-bolt"></i>

                            Buy Now

                        </a>

                    </form>


                    @php
                        $productImageAiReady = config('services.virtual_tryon.provider') === 'openai'
                            && filled(config('services.virtual_tryon.openai.key'));
                    @endphp
                    <section class="product-ai-studio" id="productAiStudio" aria-labelledby="productAiTitle">
                        <div class="product-ai-studio__heading">
                            <div class="product-ai-studio__badge" aria-hidden="true">✦</div>
                            <div>
                                <p class="product-ai-studio__eyebrow">SMART BASKET AI</p>
                                <h2 id="productAiTitle">Create an image with this product</h2>
                                <p>Describe a scene and AI will create a new image using this exact product as its reference.</p>
                            </div>
                        </div>

                        <div class="product-ai-chat" id="productAiChat" aria-live="polite">
                            <div class="product-ai-message product-ai-message--assistant">
                                <span class="product-ai-message__avatar" aria-hidden="true">✦</span>
                                <p>I can create a fresh product scene for <strong>{{ $product->name }}</strong>. Try “on a warm wooden table in soft morning light” or describe your own idea.</p>
                            </div>
                        </div>

                        <div class="product-ai-prompts" aria-label="Suggested image ideas">
                            <button type="button" data-ai-prompt="Show this product in a clean premium studio with soft natural lighting">Premium studio</button>
                            <button type="button" data-ai-prompt="Place this product in a cozy modern home, with warm daylight and a simple background">At home</button>
                            <button type="button" data-ai-prompt="Create an elegant festive gift scene around this product, with tasteful warm lights">Festive scene</button>
                        </div>

                        <form class="product-ai-composer" id="productAiForm" action="{{ route('products.ai-image.generate', $product) }}" method="POST">
                            @csrf
                            <label class="visually-hidden" for="productAiPrompt">Describe the image you want</label>
                            <textarea id="productAiPrompt" name="prompt" rows="2" maxlength="500" placeholder="Describe the scene you want for this product…" required></textarea>
                            <div class="product-ai-composer__bottom">
                                <label class="product-ai-consent"><input type="checkbox" name="privacy_consent" value="1" required> I agree to send this catalogue product image and prompt to the configured AI provider.</label>
                                <button class="btnx primary" id="productAiSubmit" type="submit" {{ $productImageAiReady ? '' : 'disabled' }}><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Create image</button>
                            </div>
                        </form>
                        <p class="product-ai-status" id="productAiStatus" role="status">@if($productImageAiReady) Generated images are private to your session and expire after 24 hours. @else AI image creation is currently unavailable. The administrator needs to configure the image provider. @endif</p>
                    </section>

                    <!-- AI TRY ON -->

                    @if(preg_match('/fashion|clothing|apparel|footwear|shoes/i', (string) $product->category) && preg_match('/\b(?:t[\s-]?shirts?|tees?|dresses?|tops?|blouses?|jeans?|trousers?|pants?|leggings?|skirts?|jackets?|coats?|hoodies?|sweaters?|suits?|kurtas?|sarees?|clothing|apparel|footwear|shoes?|sneakers?|boots?)\b/i', (string) $product->name . ' ' . (string) $product->category))

                    @php
                        $tryOnReady = config('services.virtual_tryon.provider') === 'openai'
                            && filled(config('services.virtual_tryon.openai.key'));
                    @endphp

                    <button type="button" class="btnx primary mt-4" id="tryOnOpen"><i class="fa-solid fa-wand-magic-sparkles"></i> AI Virtual Try-On</button>

                    <section
                        class="ai d-none"
                        id="virtualTryOn"
                    >

                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div><h2>✨ AI Virtual Try-On</h2><p>Preview this exact product on your photo. The result is approximate and may differ from real fit, material, colour, or appearance.</p></div>
                            <div class="d-flex gap-2"><button type="button" class="btnx" id="tryOnReset">Reset</button><button type="button" class="btnx" id="tryOnClose" aria-label="Close try-on">Close</button></div>
                        </div>

                        <div class="tryon-product-ref">
                            <img id="tryOnProductPreview" src="{{ $gallery->first()['url'] }}" alt="Selected product: {{ $product->name }}">
                            <div><small>Selected product</small><strong>{{ $product->name }}</strong><span id="tryOnSelectedImageLabel">{{ $gallery->first()['label'] }} image</span></div>
                        </div>

                        <p>
                            Upload a clear, well-lit photo showing the area where you would wear this item. Your photo and the product image are sent to the configured AI provider for generation.
                        </p>


                        <div
                            id="tryOnMessage"
                            class="alert d-none"
                            role="alert"
                        ></div>

                        @unless($tryOnReady)
                            <div class="alert alert-warning" role="status">AI Virtual Try-On needs to be configured by the site administrator before a preview can be generated. Your photo will not be sent while the provider is unavailable.</div>
                        @endunless


                        <form
                            id="tryOnForm"
                            action="{{ route('products.virtual-try-on.generate',$product) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <input
                                type="hidden"
                                id="tryOnProductImageId"
                                name="product_image_id"
                            >

                            <div class="form-check mb-3">
                                <input class="form-check-input" id="tryOnConsent" name="privacy_consent" type="checkbox" value="1" required>
                                <label class="form-check-label small" for="tryOnConsent">I agree to send this photo and selected product image to the configured external AI provider. The uploaded photo is deleted from this server after the generation request; the provider may process or retain submitted images under its own policies. Generated results are kept privately for up to 24 hours.</label>
                            </div>


                            <input
                                class="form-control"
                                id="tryOnPhoto"
                                name="photo"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                capture="user"
                                required
                            >


                            <div class="actions">

                                <button
                                    class="btnx primary"
                                    type="submit"
                                    id="tryOnSubmit"
                                    {{ $tryOnReady ? '' : 'disabled' }}
                                >
                                    ✨ Generate My Try-On
                                </button>


                                <button
                                    class="btnx d-none"
                                    type="button"
                                    id="tryOnRemove"
                                >
                                    Remove Photo
                                </button>

                            </div>

                        </form>


                        <img
                            id="tryOnPreview"
                            class="img-fluid d-none mt-3"
                            alt="Customer photo preview"
                        >

                        <button type="button" class="btnx d-none" id="tryOnChangePhoto">Replace Photo</button>


                        <div
                            class="mt-4 d-none"
                            id="tryOnResultWrap"
                        >

                            <h3 class="h6 fw-bold">
                                AI Virtual Try-On Result
                            </h3>


                            <img
                                id="tryOnResult"
                                class="img-fluid"
                                alt="AI-generated virtual try-on preview"
                            >

                            <p class="small text-muted mt-2">AI-generated preview · may differ from real fit, colour, or appearance.</p>

                            <div class="row g-3 mt-1" id="tryOnComparison">
                                <div class="col-6"><div class="small fw-bold mb-1">Original Photo</div><img id="tryOnOriginal" class="img-fluid" alt="Original customer photo"></div>
                                <div class="col-6"><div class="small fw-bold mb-1">AI Try-On Preview</div><img id="tryOnComparisonResult" class="img-fluid" alt="AI-generated try-on preview"></div>
                            </div>


                            <div class="actions">

                                <button
                                    class="btnx"
                                    type="button"
                                    id="tryOnAgain"
                                >
                                    🔄 Try Again
                                </button>

                                <a class="btnx success" id="tryOnDownload" href="#" download="smart-basket-try-on.png">Download result</a>
                                <button class="btnx" type="button" id="tryOnDiscard">Discard photo and result</button>


                                <label
                                    class="btnx"
                                    for="tryOnPhoto"
                                >
                                    📷 Change Photo
                                </label>


                                <button
                                    class="btnx"
                                    type="button"
                                    id="tryOnProductImage"
                                >
                                    🖼 Change Product Image
                                </button>


                                <a
                                    class="btnx success"
                                    href="{{ url('/buy-now/'.$product->id) }}"
                                >
                                    ⚡ Buy Now
                                </a>

                            </div>

                        </div>

                    </section>

                    @else
                        <p class="small text-muted mt-4">AI Virtual Try-On is currently available for clothing and footwear items only. This product cannot be previewed reliably.</p>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RELATED PRODUCTS
    ====================================================== -->

    @if($relatedProducts->isNotEmpty())

        <section class="related">

            <div class="related-head">

                <h2>
                    Related Products
                </h2>


                <a
                    href="{{ route('products.index') }}"
                    class="view-all"
                >

                    View All

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>


            <div class="row g-3">

                @foreach($relatedProducts as $related)

                    @php

                            $relatedPrice = (float) $related->effective_price;

                    @endphp


                    <div class="col-6 col-md-3">

                        <article
                            class="related-card related-card--clickable"
                            data-product-url="{{ route('product.show', $related) }}"
                            tabindex="0"
                            role="link"
                            aria-label="View {{ $related->name }}"
                        >

                            <img
                                class="related-img"
                                src="{{ asset('products/'.$related->image) }}"
                                alt="{{ $related->name }}"
                                onerror="this.style.opacity='.25'"
                            >


                            <div class="related-body">

                                <div class="related-title">
                                    {{ $related->name }}
                                </div>

                                <div class="related-price">
                                    ₹{{ number_format($relatedPrice,2) }}
                                </div>

                            </div>

                            <a href="{{ route('product.show', $related) }}" class="related-view-product">View Product</a>
                        </article>

                    </div>

                @endforeach

            </div>

        </section>

    @endif

</div>



<script>

(() => {


    /* =====================================================
       PRODUCT IMAGE GALLERY
    ====================================================== */

    const mediaThumbs = [...document.querySelectorAll('.thumb')];
    let activeMediaIndex = 0;
    const showMedia = (index) => {
        if (!mediaThumbs.length) return;
        activeMediaIndex = (index + mediaThumbs.length) % mediaThumbs.length;
        const button = mediaThumbs[activeMediaIndex];
        const image = document.getElementById('mainProductImage');
        const video = document.getElementById('mainProductVideo');
        if (video) { video.pause(); video.removeAttribute('src'); video.load(); }
        if (button.dataset.mediaType === 'video') {
            image.style.display = 'none';
            video.style.display = 'block';
            if (button.dataset.poster) video.poster = button.dataset.poster;
            else video.removeAttribute('poster');
            video.src = button.dataset.image;
        } else {
            video.style.display = 'none';
            image.style.display = 'block';
            image.src = button.dataset.image;
        }
        const productImageId = document.getElementById('tryOnProductImageId');
        if (productImageId) productImageId.value = button.dataset.mediaType === 'image' ? (button.dataset.productImageId || '') : '';
        const productPreview = document.getElementById('tryOnProductPreview');
        if (productPreview && button.dataset.mediaType === 'image') productPreview.src = button.dataset.image;
        const selectedLabel = document.getElementById('tryOnSelectedImageLabel');
        if (selectedLabel) selectedLabel.textContent = button.querySelector('img')?.alt || 'Product video';
        mediaThumbs.forEach((item, itemIndex) => {
            item.classList.toggle('active', itemIndex === activeMediaIndex);
            item.setAttribute('aria-current', itemIndex === activeMediaIndex ? 'true' : 'false');
        });
    };
    mediaThumbs.forEach((button, index) => button.addEventListener('click', () => showMedia(index)));
    document.querySelector('.gallery-prev')?.addEventListener('click', () => showMedia(activeMediaIndex - 1));
    document.querySelector('.gallery-next')?.addEventListener('click', () => showMedia(activeMediaIndex + 1));
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
        if (event.target instanceof HTMLInputElement || event.target instanceof HTMLTextAreaElement) return;
        showMedia(activeMediaIndex + (event.key === 'ArrowRight' ? 1 : -1));
    });


    /* =====================================================
       QUANTITY
    ====================================================== */

    const quantity =
        document.getElementById(
            'quantity'
        );


    if (quantity) {

        const limit =
            () =>
                Number(quantity.max)
                || Infinity;


        document
            .getElementById(
                'quantityMinus'
            )
            .onclick =
            () => {

                quantity.value =
                    Math.max(
                        1,
                        Number(
                            quantity.value || 1
                        ) - 1
                    );

            };


        document
            .getElementById(
                'quantityPlus'
            )
            .onclick =
            () => {

                quantity.value =
                    Math.min(
                        limit(),
                        Number(
                            quantity.value || 1
                        ) + 1
                    );

            };


        quantity.onchange =
            () => {

                quantity.value =
                    Math.max(
                        1,
                        Math.min(
                            limit(),
                            Number(
                                quantity.value || 1
                            )
                        )
                    );

            };

    }


    /* =====================================================
       AI VIRTUAL TRY-ON
    ====================================================== */

    const form =
        document.getElementById(
            'tryOnForm'
        );


    if (!form) {

        return;

    }


    const input =
        document.getElementById(
            'tryOnPhoto'
        );

    const preview =
        document.getElementById(
            'tryOnPreview'
        );

    const message =
        document.getElementById(
            'tryOnMessage'
        );

    const submit =
        document.getElementById(
            'tryOnSubmit'
        );

    const remove =
        document.getElementById(
            'tryOnRemove'
        );

    const resultWrap =
        document.getElementById(
            'tryOnResultWrap'
        );

    const result =
        document.getElementById(
            'tryOnResult'
        );

    const originalResult = document.getElementById('tryOnOriginal');
    const comparisonResult = document.getElementById('tryOnComparisonResult');
    const downloadResult = document.getElementById('tryOnDownload');
    const panel = document.getElementById('virtualTryOn');
    let photoPreviewUrl = null;

    document.getElementById('tryOnOpen')?.addEventListener('click', () => { panel.classList.remove('d-none'); panel.scrollIntoView({behavior:'smooth', block:'center'}); });
    document.getElementById('tryOnClose')?.addEventListener('click', () => panel.classList.add('d-none'));
    document.getElementById('tryOnChangePhoto')?.addEventListener('click', () => input.click());


    function showMessage(
        text,
        success = false
    ) {

        message.textContent =
            text;

        message.className =
            success
                ? 'alert alert-success mt-3'
                : 'alert alert-warning mt-3';

    }


    input.addEventListener(
        'change',
        () => {

            const file =
                input.files[0];


            if (!file) {

                return;

            }


            preview.src =
                URL.createObjectURL(
                    file
                );
            if(photoPreviewUrl) URL.revokeObjectURL(photoPreviewUrl);
            photoPreviewUrl = preview.src;

            originalResult.src = preview.src;


            preview.classList.remove(
                'd-none'
            );


            remove.classList.remove(
                'd-none'
            );
            document.getElementById('tryOnChangePhoto')?.classList.remove('d-none');

        }
    );


    remove.addEventListener(
        'click',
        () => {

            input.value = '';

            preview.removeAttribute(
                'src'
            );

            originalResult.removeAttribute('src');
            if(photoPreviewUrl) URL.revokeObjectURL(photoPreviewUrl);
            photoPreviewUrl = null;

            preview.classList.add(
                'd-none'
            );

            remove.classList.add(
                'd-none'
            );
            document.getElementById('tryOnChangePhoto')?.classList.add('d-none');

        }
    );


    document
        .getElementById(
            'tryOnAgain'
        )
        ?.addEventListener(
            'click',
            () => {

                resultWrap.classList.add(
                    'd-none'
                );

                form.scrollIntoView({
                    behavior:
                        'smooth'
                });

            }
        );


    document
        .getElementById(
            'tryOnProductImage'
        )
        ?.addEventListener(
            'click',
            () => {

                showMessage(
                    'Select a product image thumbnail above.',
                    true
                );

            }
        );


    form.addEventListener(
        'submit',
        async event => {

            event.preventDefault();


            submit.disabled =
                true;
            form.classList.add('is-processing');
            submit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating your preview…';


            showMessage(
                'Creating your AI virtual try-on preview…',
                true
            );


            try {

                const response =
                    await fetch(
                        form.action,
                        {
                            method:
                                'POST',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    form.querySelector(
                                        '[name="_token"]'
                                    ).value

                            },

                            body:
                                new FormData(
                                    form
                                )

                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'AI Virtual Try-On is temporarily unavailable.'
                    );

                }


                result.src =
                    data.result_url;

                comparisonResult.src = data.result_url;
                downloadResult.href = data.download_url;
                result.dataset.discardUrl = data.discard_url;


                resultWrap.classList.remove(
                    'd-none'
                );


                showMessage(
                    data.message ||
                    'Virtual try-on created successfully.',
                    true
                );


            } catch (error) {

                showMessage(
                    error.message
                );

            } finally {

                submit.disabled =
                    false;
                form.classList.remove('is-processing');
                submit.innerHTML = '✨ Generate My Try-On';

            }

        }
    );

    async function discardTryOn(){
        try {
            if(result.dataset.discardUrl){
                const response = await fetch(result.dataset.discardUrl, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value, 'Accept': 'application/json'}
                });
                if (!response.ok) throw new Error('Could not discard this result.');
            }
            resultWrap.classList.add('d-none');
            input.value = '';
            preview.removeAttribute('src');
            preview.classList.add('d-none');
            originalResult.removeAttribute('src');
            remove.classList.add('d-none');
            document.getElementById('tryOnChangePhoto')?.classList.add('d-none');
            if(photoPreviewUrl) URL.revokeObjectURL(photoPreviewUrl);
            photoPreviewUrl = null;
            result.removeAttribute('src');
            comparisonResult.removeAttribute('src');
            originalResult.removeAttribute('src');
            downloadResult.removeAttribute('href');
            delete result.dataset.discardUrl;
            document.getElementById('tryOnChangePhoto')?.classList.add('d-none');
            showMessage('The uploaded photo and generated result were cleared from this page. Any saved server result was deleted.', true);
        } catch (error) {
            showMessage(error.message);
        }
    }
    document.getElementById('tryOnDiscard')?.addEventListener('click', discardTryOn);
    document.getElementById('tryOnReset')?.addEventListener('click', discardTryOn);


    /* =====================================================
       THEME
    ====================================================== */

    window.addEventListener(
        'sb-theme-changed',
        event => {

            const theme =
                event.detail?.theme;


            if (
                ['light','dark']
                    .includes(theme)
            ) {

                document.documentElement
                    .setAttribute(
                        'data-theme',
                        theme
                    );


                localStorage.setItem(
                    'sb-theme',
                    theme
                );

            }

        }
    );


})();

</script>


<script>
(() => {
    const form = document.getElementById('productAiForm');
    if (!form) return;

    const prompt = document.getElementById('productAiPrompt');
    const chat = document.getElementById('productAiChat');
    const status = document.getElementById('productAiStatus');
    const submit = document.getElementById('productAiSubmit');

    document.querySelectorAll('[data-ai-prompt]').forEach((button) => {
        button.addEventListener('click', () => {
            prompt.value = button.dataset.aiPrompt || '';
            prompt.focus();
        });
    });

    function appendMessage(className, content) {
        const message = document.createElement('div');
        message.className = `product-ai-message ${className}`;
        message.append(content);
        chat.append(message);
        chat.scrollTop = chat.scrollHeight;
        return message;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!form.reportValidity()) return;

        const requestPrompt = prompt.value.trim();
        const userMessage = document.createElement('p');
        userMessage.textContent = requestPrompt;
        appendMessage('product-ai-message--user', userMessage);

        submit.disabled = true;
        submit.innerHTML = '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> Creating…';
        status.textContent = 'Creating a new product image. This may take a little while…';
        status.className = 'product-ai-status is-loading';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'Image generation failed. Please try again.');

            const assistant = document.createElement('div');
            assistant.className = 'product-ai-message product-ai-message--assistant';
            const avatar = document.createElement('span');
            avatar.className = 'product-ai-message__avatar';
            avatar.setAttribute('aria-hidden', 'true');
            avatar.textContent = '✦';
            const body = document.createElement('div');
            const caption = document.createElement('p');
            caption.textContent = 'Here is your new scene, created from this product image.';
            const image = document.createElement('img');
            image.className = 'product-ai-message__result';
            image.src = data.result_url;
            image.alt = 'AI-created product scene';
            image.loading = 'lazy';
            const actions = document.createElement('div');
            actions.className = 'product-ai-message__actions';
            const download = document.createElement('a');
            download.href = data.download_url;
            download.textContent = 'Download image';
            const discard = document.createElement('button');
            discard.type = 'button';
            discard.textContent = 'Delete image';
            discard.addEventListener('click', async () => {
                discard.disabled = true;
                try {
                    await fetch(data.discard_url, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                    assistant.remove();
                    status.textContent = 'Generated image deleted.';
                    status.className = 'product-ai-status';
                } catch {
                    discard.disabled = false;
                    status.textContent = 'Could not delete the image just now. Please try again.';
                    status.className = 'product-ai-status is-error';
                }
            });
            actions.append(download, discard);
            body.append(caption, image, actions);
            assistant.append(avatar, body);
            chat.append(assistant);
            chat.scrollTop = chat.scrollHeight;
            prompt.value = '';
            status.textContent = 'Image ready. It is private to your session and expires after 24 hours.';
            status.className = 'product-ai-status';
        } catch (error) {
            status.textContent = error.message || 'Image generation is temporarily unavailable.';
            status.className = 'product-ai-status is-error';
        } finally {
            submit.disabled = false;
            submit.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Create image';
        }
    });
})();
</script>


<script>
    (() => {
        const countdowns = [...document.querySelectorAll('[data-countdown]')];
        const paint = (node) => {
            const target = new Date(node.dataset.countdown).getTime();
            const remaining = Math.max(0, target - Date.now());
            const values = {
                days: Math.floor(remaining / 86400000),
                hours: Math.floor((remaining % 86400000) / 3600000),
                minutes: Math.floor((remaining % 3600000) / 60000),
                seconds: Math.floor((remaining % 60000) / 1000),
            };
            Object.entries(values).forEach(([unit, value]) => {
                const output = node.querySelector(`[data-${unit}]`);
                if (output) output.firstChild.textContent = String(value).padStart(2, '0');
            });
            if (remaining === 0 && node.hasAttribute('data-countdown-reload') && !node.dataset.reloaded) {
                node.dataset.reloaded = 'true';
                window.location.reload();
            }
        };
        countdowns.forEach(paint);
        window.setInterval(() => countdowns.forEach(paint), 1000);
        document.querySelectorAll('[data-copy-coupon]').forEach((button) => {
            button.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(button.dataset.copyCoupon);
                    button.setAttribute('aria-label', 'Coupon code copied');
                } catch (_) {
                    button.querySelector('span').textContent = button.dataset.copyCoupon;
                }
            });
        });
    })();
</script>
</body>
</html>

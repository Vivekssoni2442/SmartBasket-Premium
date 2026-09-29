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


        .product-video-card {
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: var(--card);
            box-shadow: var(--shadow);
        }

        .product-video-head {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:10px;
        }

        .product-video-head strong {
            display:block;
            color:var(--text);
            font-size:14px;
            font-weight:950;
        }

        .product-video-head span {
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:11px;
        }

        .product-video-head i {
            color:var(--primary);
            font-size:20px;
        }

        .product-video {
            display:block;
            width:100%;
            max-height:520px;
            border-radius:16px;
            background:#000;
            object-fit:contain;
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
        .product-detail-page .related{max-width:1600px;margin:42px auto 0}
        .product-detail-page .related-card{border-radius:20px;box-shadow:0 14px 42px rgba(15,23,42,.09)}
        .product-detail-page .related-img{height:220px;padding:14px;object-fit:contain;background:linear-gradient(145deg,var(--card2),var(--card))}
        .product-detail-page .related-body{padding:15px}

        /* Canonical Products-page taskbar takes the place of the old detail-page topbar. */
        .sb-products-taskbar{margin:0!important}

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
        }

    </style>

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

<x-ai-hub-sidebar :without-menu="true" />

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


<div class="wrap product-detail-page">


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

                    );

                @endphp


                <div class="gallery-box">

                    <img
                        id="mainProductImage"
                        src="{{ $gallery->first()['url'] }}"
                        class="main-image"
                        alt="{{ $product->name }}"
                        onerror="this.style.opacity='.25'"
                    >

                </div>


                @if($gallery->count() > 1)

                    <div class="thumbs">

                        @foreach($gallery as $index => $image)

                            <button
                                type="button"
                                class="thumb {{ $index === 0 ? 'active' : '' }}"
                                data-image="{{ $image['url'] }}"
                                data-product-image-id="{{ $image['image_id'] }}"
                            >

                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['label'] }}"
                                >

                            </button>

                        @endforeach

                    </div>

                @endif

                @if(!empty($product->video))

                    <section
                        class="product-video-card mt-3"
                        aria-label="Product video"
                    >

                        <div class="product-video-head">
                            <div>
                                <strong>Product Video</strong>
                                <span>See the product in motion</span>
                            </div>

                            <i class="fa-solid fa-circle-play" aria-hidden="true"></i>
                        </div>

                        <video
                            class="product-video"
                            controls
                            playsinline
                            preload="metadata"
                            poster="{{ asset('products/' . $product->image) }}"
                        >
                            <source
                                src="{{ asset('storage/' . ltrim($product->video, '/')) }}"
                                type="video/mp4"
                            >
                            Your browser does not support video playback.
                        </video>

                    </section>

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


                    <h1 class="title">
                        {{ $product->name }}
                    </h1>


                    @php

                        $hasDiscount =
                            $product->discount_price !== null &&
                            (float)$product->discount_price <
                            (float)$product->price;

                        $finalPrice =
                            $hasDiscount
                            ? (float)$product->discount_price
                            : (float)$product->price;

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


                    <!-- AI TRY ON -->

                    <section
                        class="ai"
                        id="virtualTryOn"
                    >

                        <h2>
                            ✨ AI Virtual Try-On
                        </h2>

                        <p>
                            Upload your photo or use your camera
                            to create an AI visual preview.
                        </p>


                        <div
                            id="tryOnMessage"
                            class="alert d-none"
                            role="alert"
                        ></div>


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
                                >
                                    ✨ Try Product On Me
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


                            <div class="actions">

                                <button
                                    class="btnx"
                                    type="button"
                                    id="tryOnAgain"
                                >
                                    🔄 Try Again
                                </button>


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


                                <form
                                    action="{{ route('cart.add',$product) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        class="btnx primary"
                                        type="submit"
                                    >
                                        🛒 Add to Cart
                                    </button>

                                </form>


                                <a
                                    class="btnx success"
                                    href="{{ url('/buy-now/'.$product->id) }}"
                                >
                                    ⚡ Buy Now
                                </a>

                            </div>

                        </div>

                    </section>

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

                        $relatedPrice =
                            (float)(
                                $related->discount_price &&
                                $related->discount_price <
                                $related->price

                                    ? $related->discount_price

                                    : $related->price
                            );

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

    document
        .querySelectorAll('.thumb')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    document
                        .getElementById(
                            'mainProductImage'
                        )
                        .src =
                        button.dataset.image;


                    document
                        .getElementById(
                            'tryOnProductImageId'
                        )
                        .value =
                        button.dataset.productImageId
                        || '';


                    document
                        .querySelectorAll('.thumb')
                        .forEach(
                            item =>
                                item.classList.remove(
                                    'active'
                                )
                        );


                    button.classList.add(
                        'active'
                    );

                }
            );

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


            preview.classList.remove(
                'd-none'
            );


            remove.classList.remove(
                'd-none'
            );

        }
    );


    remove.addEventListener(
        'click',
        () => {

            input.value = '';

            preview.removeAttribute(
                'src'
            );

            preview.classList.add(
                'd-none'
            );

            remove.classList.add(
                'd-none'
            );

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

            }

        }
    );


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


</body>
</html>

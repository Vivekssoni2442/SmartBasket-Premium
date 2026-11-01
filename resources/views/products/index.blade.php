<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Basket — Products</title>

    {{-- =========================================================
         THEME
    ========================================================= --}}
    <script>
        (() => {
            const saved = localStorage.getItem('sb-theme');

            const userTheme =
                @auth
                    @json(auth()->user()->dark_mode ?? auth()->user()->theme ?? 'dark')
                @else
                    'dark'
                @endauth;

            const theme = ['light', 'dark'].includes(saved)
                ? saved
                : (['light', 'dark'].includes(userTheme) ? userTheme : 'dark');

            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-sb-theme', theme);

            window.SB_THEME = theme;
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

        /* =========================================================
           GLOBAL THEME
        ========================================================= */

        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --surface2: #f8fafc;
            --text: #102033;
            --muted: #718096;
            --border: #e3eaf3;

            --primary: #2563eb;
            --primary2: #7c3aed;

            --success: #16a34a;
            --danger: #e05b72;

            --cyan: #00f6ff;
            --blue: #287bff;
            --purple: #8b35ff;
            --pink: #ff20c8;
            --red: #ff405d;
            --yellow: #ffe45c;

            --shadow:
                0 18px 55px rgba(15, 23, 42, .09);

            --menu-shadow:
                0 30px 90px rgba(15, 23, 42, .20);
        }

        html[data-theme="dark"],
        html[data-sb-theme="dark"] {
            --bg: #040914;
            --surface: #091322;
            --surface2: #0d1b2d;
            --text: #f5f9ff;
            --muted: #9aacbf;
            --border: #21364f;

            --primary: #65a5ff;
            --primary2: #9a7cff;

            --success: #45cf8c;
            --danger: #ef8095;

            --shadow:
                0 22px 65px rgba(0, 0, 0, .42);

            --menu-shadow:
                0 30px 90px rgba(0, 0, 0, .62);
        }

        /* =========================================================
           RESET
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            background: var(--bg);
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);

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
                    circle at 5% 0%,
                    rgba(0, 246, 255, .08),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 95% 0%,
                    rgba(255, 32, 200, .08),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(124, 58, 237, .07),
                    transparent 35%
                ),
                var(--bg);

            transition:
                background .3s ease,
                color .3s ease;

            overflow-x: hidden;
        }

        a {
            text-decoration: none !important;
        }

        button,
        input,
        select {
            font-family: inherit;
        }

        /* =========================================================
           MAIN WRAPPER
        ========================================================= */

        .sb-wrap {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 28px 18px 70px;
        }

        /* =========================================================
           PREMIUM HERO
        ========================================================= */

        .hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;

            min-height: 330px;

            margin-bottom: 32px;
            padding: 45px 50px;

            display: flex;
            align-items: center;

            border-radius: 34px;

            background:
                linear-gradient(
                    135deg,
                    color-mix(
                        in srgb,
                        var(--surface) 96%,
                        transparent
                    ),
                    color-mix(
                        in srgb,
                        var(--surface2) 91%,
                        transparent
                    )
                );

            border:
                1px solid rgba(255,255,255,.12);

            box-shadow:
                0 30px 90px rgba(0,0,0,.14),
                inset 0 1px 0 rgba(255,255,255,.10);

            animation:
                heroAppear .7s ease both;
        }

        .hero::before {
            content: "";

            position: absolute;
            inset: -2px;

            z-index: -4;

            border-radius: 36px;

            background:
                conic-gradient(
                    from 0deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--red),
                    var(--yellow),
                    var(--cyan)
                );

            filter: blur(2px);

            animation:
                heroFrame 9s linear infinite;
        }

        .hero::after {
            content: "";

            position: absolute;
            inset: 2px;

            z-index: -3;

            border-radius: 32px;

            background:
                linear-gradient(
                    135deg,
                    color-mix(
                        in srgb,
                        var(--surface) 98%,
                        transparent
                    ),
                    color-mix(
                        in srgb,
                        var(--surface2) 94%,
                        transparent
                    )
                );
        }

        @keyframes heroFrame {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes heroAppear {
            from {
                opacity: 0;
                transform:
                    translateY(20px)
                    scale(.98);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }

        /* =========================================================
           HERO GLOW
        ========================================================= */

        .hero-glow {
            position: absolute;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            filter: blur(75px);

            opacity: .18;

            pointer-events: none;

            z-index: -2;
        }

        .hero-glow.one {
            right: -80px;
            top: -180px;

            background:
                linear-gradient(
                    135deg,
                    var(--cyan),
                    var(--purple),
                    var(--pink)
                );

            animation:
                glowOne 9s ease-in-out infinite;
        }

        .hero-glow.two {
            left: -180px;
            bottom: -260px;

            background:
                linear-gradient(
                    135deg,
                    var(--cyan),
                    var(--blue)
                );

            animation:
                glowTwo 8s ease-in-out infinite;
        }

        .hero-glow.three {
            right: 28%;
            bottom: -280px;

            width: 300px;
            height: 300px;

            background:
                linear-gradient(
                    135deg,
                    var(--pink),
                    var(--purple)
                );

            opacity: .10;

            animation:
                glowThree 7s ease-in-out infinite;
        }

        @keyframes glowOne {
            0%,100% {
                transform:
                    translate(0,0)
                    scale(1);
            }

            50% {
                transform:
                    translate(-100px,90px)
                    scale(1.25);
            }
        }

        @keyframes glowTwo {
            0%,100% {
                transform: translate(0,0);
            }

            50% {
                transform:
                    translate(120px,-40px)
                    scale(1.2);
            }
        }

        @keyframes glowThree {
            0%,100% {
                transform: translateX(0);
            }

            50% {
                transform:
                    translateX(-80px)
                    scale(1.2);
            }
        }

        /* =========================================================
           HERO GRID
        ========================================================= */

        .hero-grid {
            position: absolute;
            inset: 0;

            z-index: -1;

            opacity: .14;

            background-image:
                linear-gradient(
                    rgba(0,246,255,.10) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(139,53,255,.10) 1px,
                    transparent 1px
                );

            background-size: 38px 38px;

            mask-image:
                radial-gradient(
                    circle at 75% 50%,
                    black,
                    transparent 70%
                );

            animation:
                gridMove 16s linear infinite;
        }

        @keyframes gridMove {
            from {
                transform: translate(0,0);
            }

            to {
                transform:
                    translate(38px,38px);
            }
        }

        /* =========================================================
           HERO CONTENT
        ========================================================= */

        .hero-content {
            position: relative;
            z-index: 20;
            max-width: 720px;
        }

        .eyebrow {
            display: inline-flex;

            align-items: center;
            gap: 9px;

            padding: 8px 14px;

            border-radius: 999px;

            border: 1px solid transparent;

            background:
                linear-gradient(
                    var(--surface),
                    var(--surface)
                ) padding-box,
                linear-gradient(
                    90deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--yellow),
                    var(--cyan)
                ) border-box;

            background-size:
                100% 100%,
                500% 100%;

            color: var(--text);

            font-size: 9px;
            font-weight: 950;

            letter-spacing: .16em;

            animation:
                eyebrowRGB 4s linear infinite;
        }

        .eyebrow i {
            color: var(--purple);

            animation:
                magicPulse 2s ease-in-out infinite;
        }

        @keyframes eyebrowRGB {
            from {
                background-position:
                    0 0,
                    0% 50%;
            }

            to {
                background-position:
                    0 0,
                    500% 50%;
            }
        }

        @keyframes magicPulse {
            0%,100% {
                transform:
                    scale(1)
                    rotate(0);
            }

            50% {
                transform:
                    scale(1.2)
                    rotate(12deg);
            }
        }

        .hero h1 {
            margin:
                18px 0 13px;

            font-size:
                clamp(40px, 5vw, 68px);

            line-height: .98;

            letter-spacing: -.065em;

            font-weight: 950;

            background:
                linear-gradient(
                    90deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--red),
                    var(--yellow),
                    var(--cyan)
                );

            background-size: 600% 100%;

            -webkit-background-clip: text;
            background-clip: text;

            color: transparent;

            animation:
                rgbTitle 6s linear infinite;
        }

        .hero-gradient {
            display: inline;

            background:
                linear-gradient(
                    90deg,
                    var(--pink),
                    var(--purple),
                    var(--blue),
                    var(--cyan),
                    var(--yellow),
                    var(--pink)
                );

            background-size: 600% 100%;

            -webkit-background-clip: text;
            background-clip: text;

            color: transparent;

            animation:
                rgbTitle 5s linear infinite reverse;
        }

        @keyframes rgbTitle {
            from {
                background-position: 0% 50%;
            }

            to {
                background-position: 600% 50%;
            }
        }

        .hero-subtitle {
            max-width: 600px;

            margin: 0;

            color: var(--muted);

            font-size: 13px;

            line-height: 1.75;
        }

        .hero-subtitle strong {
            color: var(--primary);
            font-weight: 950;
        }

        /* =========================================================
           HERO BUTTONS
        ========================================================= */

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .hero-btn {
            min-height: 45px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                0 18px;

            border-radius: 13px;

            font-size: 10px;

            font-weight: 900;

            transition: .25s ease;
        }

        .hero-btn-primary {
            color: #fff;

            background:
                linear-gradient(
                    110deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--red),
                    var(--yellow),
                    var(--cyan)
                );

            background-size: 600% 100%;

            box-shadow:
                0 12px 35px rgba(75,80,255,.25);

            animation:
                buttonRGB 5s linear infinite;
        }

        .hero-btn-primary:hover {
            color: #fff;

            transform:
                translateY(-3px)
                scale(1.02);

            box-shadow:
                0 18px 48px rgba(139,53,255,.35);
        }

        .hero-btn-secondary {
            color: var(--text);

            border:
                1px solid var(--border);

            background:
                color-mix(
                    in srgb,
                    var(--surface) 76%,
                    transparent
                );
        }

        .hero-btn-secondary:hover {
            color: var(--purple);

            border-color: var(--purple);

            transform:
                translateY(-3px);
        }

        @keyframes buttonRGB {
            from {
                background-position: 0% 50%;
            }

            to {
                background-position: 600% 50%;
            }
        }

        /* =========================================================
           HERO AI VISUAL
        ========================================================= */

        .hero-art {
            position: absolute;

            right: 20px;
            top: 50%;

            width: 390px;
            height: 310px;

            transform:
                translateY(-50%);

            z-index: 5;

            pointer-events: none;
        }

        .rgb-core {
            position: absolute;

            left: 50%;
            top: 50%;

            width: 165px;
            height: 165px;

            transform:
                translate(-50%,-50%);

            border-radius: 50%;

            background:
                conic-gradient(
                    from 0deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--red),
                    var(--yellow),
                    var(--cyan)
                );

            box-shadow:
                0 0 30px var(--cyan),
                0 0 65px rgba(139,53,255,.7),
                0 0 110px rgba(255,32,200,.38);

            animation:
                coreRotate 7s linear infinite,
                corePulse 3s ease-in-out infinite;
        }

        .rgb-core::before {
            content: "";

            position: absolute;

            inset: 12px;

            border-radius: 50%;

            background:
                color-mix(
                    in srgb,
                    var(--surface) 90%,
                    transparent
                );

            box-shadow:
                inset 0 0 35px rgba(0,246,255,.16);
        }

        @keyframes coreRotate {
            from {
                transform:
                    translate(-50%,-50%)
                    rotate(0deg);
            }

            to {
                transform:
                    translate(-50%,-50%)
                    rotate(360deg);
            }
        }

        @keyframes corePulse {
            0%,100% {
                scale: .94;
            }

            50% {
                scale: 1.06;
            }
        }

        .hero-basket {
            position: absolute;

            left: 50%;
            top: 50%;

            z-index: 15;

            width: 78px;
            height: 78px;

            display: grid;
            place-items: center;

            transform:
                translate(-50%,-50%);

            border-radius: 25px;

            color: #fff;

            font-size: 31px;

            background:
                linear-gradient(
                    135deg,
                    var(--cyan),
                    var(--purple),
                    var(--pink)
                );

            background-size: 300% 300%;

            box-shadow:
                0 18px 40px rgba(0,0,0,.25),
                0 0 30px rgba(0,246,255,.40);

            animation:
                basketRGB 4s linear infinite,
                basketFloat 3s ease-in-out infinite;
        }

        @keyframes basketRGB {
            from {
                background-position: 0% 50%;
            }

            to {
                background-position: 300% 50%;
            }
        }

        @keyframes basketFloat {
            0%,100% {
                transform:
                    translate(-50%,-50%)
                    rotate(-2deg);
            }

            50% {
                transform:
                    translate(-50%,-57%)
                    rotate(2deg);
            }
        }

        .core-ring {
            position: absolute;

            left: 50%;
            top: 50%;

            border-radius: 50%;

            transform:
                translate(-50%,-50%);

            border: 1px solid;
        }

        .core-ring.one {
            width: 215px;
            height: 215px;

            border-color:
                rgba(0,246,255,.42);

            animation:
                ringRotate 7s linear infinite;
        }

        .core-ring.two {
            width: 285px;
            height: 150px;

            border-color:
                rgba(255,32,200,.42);

            animation:
                ringRotate 10s linear infinite reverse;
        }

        .core-ring.three {
            width: 320px;
            height: 105px;

            border-color:
                rgba(255,228,92,.34);

            animation:
                ringRotate 13s linear infinite;
        }

        .core-ring.four {
            width: 250px;
            height: 275px;

            border-color:
                rgba(139,53,255,.25);

            animation:
                ringRotate 11s linear infinite reverse;
        }

        @keyframes ringRotate {
            to {
                transform:
                    translate(-50%,-50%)
                    rotate(360deg);
            }
        }

        .hero-float {
            position: absolute;

            z-index: 20;

            display: flex;

            align-items: center;

            gap: 8px;

            padding: 9px 12px;

            border:
                1px solid rgba(255,255,255,.18);

            border-radius: 14px;

            background:
                color-mix(
                    in srgb,
                    var(--surface) 68%,
                    transparent
                );

            backdrop-filter:
                blur(18px);

            box-shadow:
                0 16px 38px rgba(0,0,0,.15);

            animation:
                floatCard 4s ease-in-out infinite;
        }

        .hero-float.one {
            top: 18px;
            right: 20px;
        }

        .hero-float.two {
            bottom: 18px;
            left: 15px;

            animation-delay:
                1.2s;
        }

        .hero-float-icon {
            width: 29px;
            height: 29px;

            display: grid;
            place-items: center;

            border-radius: 9px;

            color: var(--cyan);

            background:
                rgba(0,246,255,.09);
        }

        .hero-float strong {
            display: block;
            color: var(--text);
            font-size: 11px;
        }

        .hero-float small {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 7px;
            letter-spacing: .05em;
        }

        @keyframes floatCard {
            0%,100% {
                transform: translateY(0);
            }

            50% {
                transform:
                    translateY(-8px);
            }
        }

        /* =========================================================
           SECTION HEAD
        ========================================================= */

        .section-head {
            display: flex;

            align-items: end;
            justify-content: space-between;

            gap: 15px;

            margin:
                30px 0 14px;
        }

        .section-head h2 {
            margin: 0;

            color: var(--text);

            font-size: 27px;

            font-weight: 950;

            letter-spacing: -.03em;
        }

        .section-head p {
            margin:
                5px 0 0;

            color: var(--muted);

            font-size: 12px;
        }

        .count {
            padding:
                8px 12px;

            border:
                1px solid var(--border);

            border-radius: 999px;

            background:
                var(--surface);

            color:
                var(--muted);

            font-size: 11px;

            font-weight: 800;
        }

        /* =========================================================
           FILTERS
        ========================================================= */

        .filters {
            margin-bottom: 25px;

            padding: 18px;

            border:
                1px solid var(--border);

            border-radius: 20px;

            background:
                var(--surface);

            box-shadow:
                0 10px 35px var(--shadow);
        }

        .filters label {
            display: block;

            margin-bottom: 6px;

            color: var(--muted);

            font-size: 10px;

            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: .08em;
        }

        .filters .form-control,
        .filters .form-select {
            min-height: 45px;

            border:
                1px solid var(--border);

            border-radius: 12px;

            background:
                var(--surface2);

            color:
                var(--text);

            font-size: 13px;
        }

        .filters .form-control::placeholder {
            color:
                var(--muted);
        }

        .filters .form-control:focus,
        .filters .form-select:focus {
            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px rgba(37,99,235,.10);
        }

        .apply {
            height: 45px;

            border: 0;

            border-radius: 12px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );

            font-weight: 900;

            transition: .2s ease;
        }

        .apply:hover {
            transform:
                translateY(-2px);

            box-shadow:
                0 10px 25px rgba(37,99,235,.25);
        }

        /* =========================================================
           PRODUCT CARD
        ========================================================= */

        .product-card {
            height: 100%;

            position: relative;

            overflow: hidden;

            display: flex;

            flex-direction: column;

            border:
                1px solid var(--border) !important;

            border-radius:
                23px !important;

            background:
                var(--surface) !important;

            box-shadow:
                0 10px 35px var(--shadow) !important;

            transition:
                transform .28s ease,
                box-shadow .28s ease,
                border-color .28s ease;
        }

        .product-card:hover {
            transform:
                translateY(-7px);

            border-color:
                var(--primary) !important;

            box-shadow:
                0 22px 55px var(--shadow) !important;
        }

        .product-card--clickable {
            cursor: pointer;
        }

        .media {
            height: 255px;

            position: relative;

            display: grid;
            place-items: center;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at center,
                    rgba(37,99,235,.08),
                    transparent 65%
                ),
                var(--surface2);
        }

        .media img {
            width: 100%;
            height: 100%;

            object-fit: contain;

            padding: 17px;

            transition:
                .35s ease;
        }

        .product-card:hover
        .media img {
            transform:
                scale(1.045);
        }

        .discount {
            position: absolute;

            left: 12px;
            top: 12px;

            padding:
                7px 9px;

            border-radius: 9px;

            color:
                var(--success);

            background:
                rgba(22,163,74,.10);

            font-size: 10px;

            font-weight: 950;
        }

        .product-sale-badge,
        .product-coupon-badge {
            position:absolute; left:12px; z-index:2; display:inline-flex; align-items:center; gap:6px;
            max-width:calc(100% - 24px); padding:7px 10px; overflow:hidden; border-radius:10px;
            color:#fff; font-size:10px; font-weight:950; letter-spacing:.035em; text-overflow:ellipsis; white-space:nowrap;
            box-shadow:0 5px 15px rgba(15,23,42,.2);
        }
        .product-sale-badge { top:12px; color:#FFD66B; background:linear-gradient(115deg,rgba(74,50,4,.96),rgba(117,79,8,.96)); border:1px solid rgba(255,214,107,.7); }
        .card-promotion-timer { display:flex; align-items:center; gap:7px; width:max-content; max-width:100%; margin:9px 0 0; padding:6px 9px; border:1px solid rgba(91,105,143,.2); border-radius:9px; color:var(--text); background:var(--surface2); font-size:11px; font-weight:800; font-variant-numeric:tabular-nums; }
        .card-promotion-timer i { color:#7553d5; }
        .card-promotion-timer--sale i { color:#c08208; }
        .card-promotion-timer [data-unit] { display:inline-block; min-width:19px; text-align:center; }
        .product-card-coupon { display:flex; align-items:flex-start; gap:11px; margin-top:12px; padding:12px; overflow:hidden; border:1px solid rgba(137,111,236,.32); border-radius:15px; color:#f8f7ff; background:radial-gradient(circle at 100% 0,rgba(188,157,255,.32),transparent 42%),linear-gradient(130deg,#211b54,#433381 58%,#6347a6); box-shadow:0 9px 21px rgba(49,36,105,.16),inset 0 1px 0 rgba(255,255,255,.16); }
        .product-card-coupon[data-design="sunset"] { background:radial-gradient(circle at 100% 0,rgba(255,190,125,.31),transparent 42%),linear-gradient(130deg,#542344,#963a57 60%,#c36a43); border-color:rgba(255,177,138,.4); }
        .product-card-coupon[data-design="emerald"] { background:radial-gradient(circle at 100% 0,rgba(124,255,209,.25),transparent 42%),linear-gradient(130deg,#103e43,#147568 60%,#1a9279); border-color:rgba(115,238,205,.36); }
        .product-card-coupon[data-design="gold"] { color:#fff9e8; background:radial-gradient(circle at 100% 0,rgba(255,226,140,.26),transparent 42%),linear-gradient(130deg,#48320d,#806013 60%,#9a7621); border-color:rgba(255,221,131,.42); }
        .product-card-coupon__icon { display:grid; width:38px; height:38px; flex:0 0 38px; place-items:center; border:1px solid rgba(255,255,255,.23); border-radius:12px; background:rgba(255,255,255,.12); color:#ffe08a; font-size:17px; }
        .product-card-coupon__content { min-width:0; flex:1; }
        .product-card-coupon__top { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; }
        .product-card-coupon__label { display:block; margin-bottom:3px; color:rgba(245,241,255,.72); font-size:9px; font-weight:850; letter-spacing:.12em; text-transform:uppercase; }
        .product-card-coupon__title { color:#fff; font-size:12px; font-weight:850; line-height:1.35; overflow-wrap:anywhere; }
        .product-card-coupon__discount { flex:0 0 auto; padding:5px 7px; border:1px solid rgba(255,228,149,.48); border-radius:8px; color:#ffe28b; background:rgba(17,13,42,.26); font-size:10px; font-weight:950; white-space:nowrap; }
        .product-card-coupon__description { margin:6px 0 0; color:rgba(248,246,255,.82); font-size:10px; line-height:1.45; }
        .product-card-coupon .card-promotion-timer { margin-top:8px; padding:5px 7px; border-color:rgba(255,255,255,.19); color:#fff; background:rgba(15,12,38,.24); font-size:10px; }
        .product-card-coupon .card-promotion-timer i { color:#ffe28b; }

        .wishlist {
            position: absolute;

            right: 12px;
            top: 12px;

            width: 39px;
            height: 39px;

            display: grid;
            place-items: center;

            border:
                1px solid var(--border);

            border-radius: 50%;

            background:
                var(--surface);

            color:
                var(--danger);

            box-shadow:
                0 8px 20px var(--shadow);

            transition: .2s ease;

            cursor: pointer;
        }

        .wishlist:hover {
            transform:
                scale(1.08);

            border-color:
                var(--danger);
        }

        .body {
            padding: 17px;

            display: flex;

            flex-direction: column;

            flex: 1;
        }

        .category {
            color:
                var(--primary);

            font-size: 9px;

            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: .1em;
        }

        .title {
            margin:
                5px 0;

            color:
                var(--text);

            font-size: 16px;

            line-height: 1.35;

            font-weight: 900;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }

        .rating {
            display: flex;

            align-items: center;

            gap: 5px;

            margin:
                5px 0 8px;

            color:
                var(--muted);

            font-size: 11px;
        }

        .rating i {
            color:
                #f5b82e;
        }

        .description {
            min-height: 51px;

            margin:
                0 0 10px;

            color:
                var(--muted);

            font-size: 11px;

            line-height: 1.55;

            display: -webkit-box;

            -webkit-line-clamp: 3;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }

        .price {
            color:
                var(--text);

            font-size: 22px;

            font-weight: 950;
        }

        .old {
            margin-left: 7px;

            color:
                var(--muted);

            font-size: 11px;
        }

        .stock {
            margin:
                3px 0 12px;

            color:
                var(--success);

            font-size: 10px;

            font-weight: 800;
        }

        .stock.out {
            color:
                var(--danger);
        }

        .actions {
            display: grid;

            grid-template-columns:
                1fr 1fr 1fr;

            gap: 7px;

            margin-top: auto;
        }

        .action {
            min-height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            padding: 7px;

            border:
                1px solid var(--border);

            border-radius: 10px;

            background:
                var(--surface2);

            color:
                var(--text);

            font-size: 10px;

            font-weight: 900;

            transition: .2s ease;
        }

        .action:hover {
            color:
                var(--primary);

            border-color:
                var(--primary);

            transform:
                translateY(-1px);
        }

        .action.primary {
            color: #fff;

            border-color: transparent;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary2)
                );
        }

        .action.primary:hover {
            color: #fff;
        }

        .action:disabled {
            opacity: .5;

            cursor: not-allowed;

            transform: none !important;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty {
            padding:
                70px 20px;

            text-align: center;

            border:
                1px dashed var(--border);

            border-radius: 22px;

            background:
                var(--surface);
        }

        .empty i {
            margin-bottom: 15px;

            color:
                var(--primary);

            font-size: 35px;
        }

        .empty h3 {
            color:
                var(--text);

            font-weight: 900;
        }

        .empty p {
            color:
                var(--muted);
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination {
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination .page-link {
            border:
                1px solid var(--border);

            border-radius:
                10px !important;

            background:
                var(--surface);

            color:
                var(--text);
        }

        .pagination .active .page-link {
            color:
                #fff;

            border-color:
                var(--primary);

            background:
                var(--primary);
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            width: 100%;

            padding:
                35px 0 55px;

            text-align: center;

            color:
                var(--muted);

            font-size: 10px;
        }

        /* =========================================================
           ⭐ PREMIUM CUSTOMER WELCOME OVERLAY
        ========================================================= */

        .customer-welcome-overlay {
            position: fixed;
            inset: 0;

            z-index: 20000;

            display: grid;
            place-items: center;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 50% 45%,
                    rgba(37,99,235,.20),
                    rgba(3,7,18,.985) 55%,
                    #01040b 100%
                );

            opacity: 1;
            visibility: visible;

            transition:
                opacity .7s cubic-bezier(.4,0,.2,1),
                visibility .7s ease;
        }

        .customer-welcome-overlay.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* ---------------------------------------------------------
           RGB AURA
        --------------------------------------------------------- */

        .customer-welcome-bg {
            position: absolute;

            width: 520px;
            height: 520px;

            border-radius: 50%;

            background:
                conic-gradient(
                    from 0deg,
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--red),
                    var(--yellow),
                    var(--cyan)
                );

            filter:
                blur(65px);

            opacity: .24;

            animation:
                welcomeAuraRotate 9s linear infinite,
                welcomeAuraPulse 4s ease-in-out infinite;
        }

        @keyframes welcomeAuraRotate {
            from {
                transform:
                    rotate(0deg)
                    scale(.9);
            }

            to {
                transform:
                    rotate(360deg)
                    scale(1.12);
            }
        }

        @keyframes welcomeAuraPulse {
            0%,100% {
                opacity: .18;
            }

            50% {
                opacity: .34;
            }
        }

        /* ---------------------------------------------------------
           SECOND GLOW
        --------------------------------------------------------- */

        .customer-welcome-overlay::before {
            content: "";

            position: absolute;

            width: 720px;
            height: 720px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(0,246,255,.12),
                    rgba(139,53,255,.08) 35%,
                    transparent 70%
                );

            filter:
                blur(12px);

            animation:
                welcomeOrb 6s ease-in-out infinite;
        }

        @keyframes welcomeOrb {
            0%,100% {
                transform:
                    scale(.85)
                    rotate(0deg);
            }

            50% {
                transform:
                    scale(1.08)
                    rotate(15deg);
            }
        }

        /* ---------------------------------------------------------
           PREMIUM PARTICLES
        --------------------------------------------------------- */

        .customer-welcome-overlay::after {
            content: "";

            position: absolute;
            inset: 0;

            pointer-events: none;

            opacity: .65;

            background-image:
                radial-gradient(
                    circle,
                    rgba(255,255,255,.80) 1px,
                    transparent 2px
                ),
                radial-gradient(
                    circle,
                    rgba(0,246,255,.65) 1px,
                    transparent 2px
                ),
                radial-gradient(
                    circle,
                    rgba(255,32,200,.60) 1px,
                    transparent 2px
                );

            background-size:
                110px 110px,
                170px 170px,
                230px 230px;

            background-position:
                0 0,
                40px 70px,
                90px 20px;

            animation:
                welcomeStars 12s linear infinite;
        }

        @keyframes welcomeStars {
            from {
                transform:
                    translate3d(0,0,0)
                    scale(1);
            }

            to {
                transform:
                    translate3d(-35px,-55px,0)
                    scale(1.03);
            }
        }

        /* ---------------------------------------------------------
           CONTENT
        --------------------------------------------------------- */

        .customer-welcome-content {
            position: relative;

            z-index: 10;

            width: min(92vw, 760px);

            text-align: center;

            color: #fff;

            animation:
                welcomeContentIn 1s
                cubic-bezier(.16,1,.3,1)
                both;
        }

        @keyframes welcomeContentIn {
            from {
                opacity: 0;
                transform:
                    translateY(35px)
                    scale(.88);
                filter:
                    blur(10px);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
                filter:
                    blur(0);
            }
        }

        /* ---------------------------------------------------------
           FEMALE NAMASTE EMOJI
        --------------------------------------------------------- */

        .customer-welcome-person {
            position: relative;

            width: 180px;
            height: 145px;

            margin:
                0 auto 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            animation:
                welcomePersonFloat
                3.2s
                ease-in-out
                infinite;
        }

        @keyframes welcomePersonFloat {
            0%,100% {
                transform:
                    translateY(0)
                    rotate(-1deg);
            }

            50% {
                transform:
                    translateY(-12px)
                    rotate(1deg);
            }
        }

        /* glowing circle behind female emoji */

        .customer-welcome-person::before {
            content: "";

            position: absolute;

            width: 125px;
            height: 125px;

            border-radius: 50%;

            background:
                conic-gradient(
                    var(--cyan),
                    var(--blue),
                    var(--purple),
                    var(--pink),
                    var(--yellow),
                    var(--cyan)
                );

            filter:
                blur(22px);

            opacity: .32;

            animation:
                personAura 5s linear infinite;
        }

        @keyframes personAura {
            to {
                transform:
                    rotate(360deg)
                    scale(1.12);
            }
        }

        /*
         * Female shopkeeper / greeting representation.
         * Woman emoji + Namaste hands are separated so the
         * hands can have their own premium glow animation.
         */

        .customer-welcome-woman {
            position: relative;

            z-index: 5;

            font-size: 82px;

            line-height: 1;

            filter:
                drop-shadow(
                    0 12px 24px
                    rgba(0,0,0,.35)
                );

            animation:
                womanBreath
                2.8s
                ease-in-out
                infinite;
        }

        @keyframes womanBreath {
            0%,100% {
                transform:
                    scale(1);
            }

            50% {
                transform:
                    scale(1.045);
            }
        }

        /* ---------------------------------------------------------
           NAMASTE HANDS
        --------------------------------------------------------- */

        .customer-welcome-namaste {
            position: absolute;

            z-index: 8;

            left: 50%;
            top: 76px;

            font-size: 43px;

            transform:
                translateX(-50%);

            filter:
                drop-shadow(
                    0 0 8px rgba(255,228,92,.55)
                );

            animation:
                namastePulse
                1.8s
                ease-in-out
                infinite;
        }

        @keyframes namastePulse {
            0%,100% {
                transform:
                    translateX(-50%)
                    scale(1)
                    rotate(0deg);

                filter:
                    drop-shadow(
                        0 0 7px rgba(255,228,92,.40)
                    );
            }

            50% {
                transform:
                    translateX(-50%)
                    scale(1.12)
                    rotate(-2deg);

                filter:
                    drop-shadow(
                        0 0 18px rgba(255,228,92,.90)
                    );
            }
        }

        /* ---------------------------------------------------------
           SMALL SPARKLES AROUND PERSON
        --------------------------------------------------------- */

        .welcome-spark {
            position: absolute;

            z-index: 7;

            width: 8px;
            height: 8px;

            border-radius: 50%;

            background:
                #fff;

            box-shadow:
                0 0 10px var(--cyan),
                0 0 20px var(--purple);

            animation:
                sparkFloat
                2.5s
                ease-in-out
                infinite;
        }

        .welcome-spark.one {
            top: 25px;
            left: 17px;
            animation-delay: .2s;
        }

        .welcome-spark.two {
            top: 52px;
            right: 12px;
            animation-delay: .8s;
        }

        .welcome-spark.three {
            bottom: 12px;
            left: 32px;
            animation-delay: 1.2s;
        }

        .welcome-spark.four {
            bottom: 23px;
            right: 30px;
            animation-delay: 1.7s;
        }

        @keyframes sparkFloat {
            0%,100% {
                opacity: .25;
                transform:
                    translateY(8px)
                    scale(.65);
            }

            50% {
                opacity: 1;
                transform:
                    translateY(-8px)
                    scale(1.25);
            }
        }

        /* ---------------------------------------------------------
           WELCOME TEXT
        --------------------------------------------------------- */

        .customer-welcome-title {
            position: relative;

            display: inline-block;

            margin-top: 3px;

            font-size:
                clamp(42px, 8vw, 82px);

            font-weight: 950;

            letter-spacing:
                .14em;

            line-height: .95;

            background:
                linear-gradient(
                    90deg,
                    var(--cyan),
                    #ffffff,
                    var(--pink),
                    var(--yellow),
                    #ffffff,
                    var(--cyan)
                );

            background-size:
                500% 100%;

            -webkit-background-clip: text;
            background-clip: text;

            color: transparent;

            text-shadow:
                0 0 30px rgba(0,246,255,.20);

            animation:
                welcomeTextRGB
                3.5s
                linear
                infinite;

            filter:
                drop-shadow(
                    0 10px 25px
                    rgba(0,0,0,.30)
                );
        }

        @keyframes welcomeTextRGB {
            0% {
                background-position:
                    0% 50%;
            }

            50% {
                background-position:
                    250% 50%;
            }

            100% {
                background-position:
                    500% 50%;
            }
        }

        /* ---------------------------------------------------------
           PREMIUM LINE
        --------------------------------------------------------- */

        .customer-welcome-line {
            position: relative;

            width: 145px;
            height: 3px;

            margin:
                18px auto 17px;

            border-radius:
                999px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    var(--cyan),
                    var(--purple),
                    var(--pink),
                    var(--yellow),
                    transparent
                );

            background-size:
                300% 100%;

            box-shadow:
                0 0 14px rgba(0,246,255,.65),
                0 0 26px rgba(255,32,200,.35);

            animation:
                welcomeLineRGB
                2.2s
                linear
                infinite;
        }

        @keyframes welcomeLineRGB {
            from {
                background-position:
                    0% 50%;
            }

            to {
                background-position:
                    300% 50%;
            }
        }

        /* ---------------------------------------------------------
           SUBTITLE
        --------------------------------------------------------- */

        .customer-welcome-subtitle {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            padding:
                10px 18px;

            border:
                1px solid rgba(255,255,255,.13);

            border-radius:
                999px;

            background:
                rgba(255,255,255,.055);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

            font-size: 12px;

            letter-spacing:
                .15em;

            color:
                rgba(255,255,255,.72);

            box-shadow:
                inset 0 1px 0
                rgba(255,255,255,.10),
                0 14px 45px
                rgba(0,0,0,.25);

            animation:
                welcomeSubtitle
                1.2s
                .45s
                cubic-bezier(.16,1,.3,1)
                both;
        }

        @keyframes welcomeSubtitle {
            from {
                opacity: 0;
                transform:
                    translateY(15px)
                    scale(.95);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }

        .customer-welcome-subtitle strong {
            color: #fff;

            font-weight: 950;

            letter-spacing:
                .08em;

            text-shadow:
                0 0 14px
                rgba(255,255,255,.30);
        }

        /* Centered glass welcome panel, independent of the page beneath it. */
        .customer-welcome-overlay {
            isolation:isolate;
            background:
                radial-gradient(ellipse at 18% 18%, rgba(37,224,255,.17), transparent 34%),
                radial-gradient(ellipse at 83% 26%, rgba(133,100,255,.22), transparent 38%),
                radial-gradient(ellipse at 50% 112%, rgba(28,116,255,.2), transparent 48%),
                rgba(4,8,20,.965);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .customer-welcome-overlay::before{z-index:0;width:min(90vw,900px);height:min(90vw,900px);border:1px solid rgba(109,205,255,.13);background:radial-gradient(circle,rgba(86,133,255,.11),rgba(0,0,0,0) 64%);box-shadow:0 0 100px rgba(62,110,255,.1);animation:welcomeOrb 10s ease-in-out infinite}
        .customer-welcome-overlay::after{z-index:1;opacity:.54;background-image:radial-gradient(circle,rgba(255,255,255,.85) 1px,transparent 2px),radial-gradient(circle,rgba(56,223,255,.9) 1.2px,transparent 2.4px),radial-gradient(circle,rgba(179,149,255,.8) 1px,transparent 2px);background-size:118px 118px,193px 193px,267px 267px;background-position:0 0,43px 70px,90px 20px;animation:welcomeStars 18s linear infinite}
        .customer-welcome-bg{z-index:2;width:min(68vw,660px);height:min(68vw,660px);filter:blur(78px);opacity:.35;background:conic-gradient(from 25deg,#26e3f2,#357cf6,#9672ff,#23d8ce,#26e3f2);animation:welcomeAuraRotate 18s linear infinite,welcomeAuraPulse 5s ease-in-out infinite}
        .customer-welcome-watermark{position:absolute;z-index:3;left:50%;top:50%;width:max-content;transform:translate(-50%,-50%);color:rgba(176,208,255,.045);font:900 clamp(34px,9vw,112px)/1 system-ui,sans-serif;letter-spacing:.15em;white-space:nowrap;pointer-events:none;animation:welcomeWatermarkDrift 14s ease-in-out infinite alternate}
        .customer-welcome-content{z-index:5;isolation:isolate;border-color:rgba(193,224,255,.26);background:linear-gradient(145deg,rgba(20,32,62,.86),rgba(8,15,34,.91));box-shadow:0 42px 120px rgba(0,0,0,.64),0 0 55px rgba(82,128,255,.12),inset 0 1px rgba(255,255,255,.17)}
        .customer-welcome-content::before{content:"";position:absolute;z-index:-1;inset:-1px;border-radius:inherit;padding:1px;background:linear-gradient(135deg,rgba(103,231,255,.55),transparent 32%,rgba(178,144,255,.44) 74%,rgba(103,231,255,.25));-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
        .customer-welcome-content::after{content:"SMART BASKET  ·  A BETTER WAY TO SHOP";display:block;margin-top:14px;color:rgba(158,185,228,.64);font:700 8px/1.4 system-ui,sans-serif;letter-spacing:.19em}
        .customer-welcome-person::before{background:conic-gradient(#55ecf3,#588dff,#bd8cff,#57e8ef);filter:blur(27px);opacity:.36}
        .customer-welcome-voice{box-shadow:0 8px 24px rgba(45,154,222,.12)}
        .customer-welcome-content {
            display:flex;
            flex-direction:column;
            align-items:center;
            width:min(92vw,540px);
            padding:32px 28px 25px;
            border:1px solid rgba(195,218,255,.2);
            border-radius:30px;
            background:linear-gradient(150deg,rgba(25,37,70,.94),rgba(10,17,36,.96));
            box-shadow:0 35px 110px rgba(0,0,0,.52),inset 0 1px rgba(255,255,255,.12);
        }
        .customer-welcome-person{width:140px;height:116px;margin:0 auto 7px;flex:none}
        .customer-welcome-person::before{width:104px;height:104px;opacity:.24}
        .customer-welcome-woman{font-size:68px}
        .customer-welcome-namaste{top:63px;font-size:35px}
        .customer-welcome-title{display:block;margin:4px 0 12px;font-size:clamp(43px,9vw,62px);line-height:1;letter-spacing:.1em;background:linear-gradient(100deg,#68efff 8%,#fff 49%,#b7a6ff 92%);background-size:200% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;text-shadow:none;animation:welcomeTitleSheen 3s ease-in-out infinite alternate}
        .customer-welcome-subtitle{display:inline-flex;flex-wrap:wrap;gap:7px;padding:10px 16px;border-color:rgba(195,218,255,.2);background:rgba(255,255,255,.055);font-size:10px;letter-spacing:.16em}
        .customer-welcome-line{width:110px;height:2px;margin:19px auto 13px;border:0;background:linear-gradient(90deg,transparent,#62e6ff,#b29cff,transparent);box-shadow:0 0 18px rgba(76,220,255,.5)}
        .customer-welcome-tagline{margin:0;color:#aabbd9;font:500 12px/1.5 system-ui,sans-serif;letter-spacing:.04em}
        .customer-welcome-voice{display:inline-flex;align-items:center;gap:9px;margin-top:17px;padding:9px 15px;border:1px solid rgba(129,202,255,.28);border-radius:999px;background:rgba(94,145,255,.1);color:#e4f4ff;font:650 11px system-ui,sans-serif;cursor:pointer;transition:background .2s,transform .2s}
        .customer-welcome-voice:hover{transform:translateY(-2px);background:rgba(94,145,255,.2)}
        .customer-welcome-voice i{color:#66eaff}
        .customer-welcome-progress{width:130px;height:2px;margin:19px auto 0;overflow:hidden;border-radius:5px;background:rgba(255,255,255,.12)}
        .customer-welcome-progress i{display:block;width:0;height:100%;background:linear-gradient(90deg,#a394ff,#64eaff);animation:customerWelcomeProgress 5.5s linear forwards}
        .sb-wrap.customer-welcome-zoom-in{animation:customerPageZoomIn 1.15s cubic-bezier(.16,1,.3,1) both}
        @keyframes customerPageZoomIn{from{opacity:0;transform:scale(.91);filter:blur(7px)}to{opacity:1;transform:scale(1);filter:blur(0)}}
        @keyframes welcomeTitleSheen{to{background-position:100% 50%}}@keyframes customerWelcomeProgress{to{width:100%}}
        @keyframes welcomeWatermarkDrift{to{transform:translate(-50%,-54%) scale(1.06);opacity:.7}}
        @keyframes welcomeOrb{0%,100%{transform:translate(-50%,-50%) scale(.9) rotate(0);opacity:.75}50%{transform:translate(-50%,-50%) scale(1.06) rotate(14deg);opacity:1}}
        @media(max-width:600px){.customer-welcome-content{padding:27px 20px 22px;border-radius:25px}.customer-welcome-person{transform:none;width:122px;height:105px}.customer-welcome-woman{font-size:61px}.customer-welcome-namaste{top:60px;font-size:32px}.customer-welcome-title{font-size:43px;letter-spacing:.09em}.customer-welcome-subtitle{font-size:9px}}

        /* ---------------------------------------------------------
           RESPONSIVE WELCOME
        --------------------------------------------------------- */

        @media (max-width: 600px) {

            .customer-welcome-person {
                transform:
                    none;

                margin-bottom:
                    0;
            }

            .customer-welcome-woman {
                font-size: 61px;
            }

            .customer-welcome-namaste {
                top: 60px;
                font-size: 32px;
            }

            .customer-welcome-title {
                font-size: 43px;
                letter-spacing: .10em;
            }

            .customer-welcome-subtitle {
                font-size: 9px;
                padding: 9px 13px;
            }

            .customer-welcome-line {
                margin-top: 12px;
                margin-bottom: 13px;
            }
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .hero-art {
                right: -70px;
                opacity: .55;
            }

            .hero-content {
                max-width: 650px;
            }
        }

        @media (max-width: 900px) {

            .sb-wrap {
                padding:
                    20px 15px 60px;
            }

            .hero {
                min-height: 290px;

                padding:
                    35px 35px;
            }

            .hero-art {
                display: none;
            }

            .hero-content {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {

            .sb-wrap {
                padding:
                    16px 12px 50px !important;
            }

            .hero {
                min-height: 275px;

                padding:
                    30px 22px;

                border-radius: 25px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero-subtitle {
                font-size: 12px;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-btn {
                width: 100%;
            }

            .media {
                height: 220px;
            }

            .actions {
                grid-template-columns:
                    1fr 1fr;
            }

            .actions .cart-action {
                grid-column:
                    1 / -1;
            }

            .section-head {
                align-items:
                    flex-start;

                flex-direction:
                    column;
            }
        }

        @media (max-width: 430px) {

            .hero {
                padding:
                    27px 18px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .media {
                height: 205px;
            }
        }


    </style>

<style>
/* =========================================================
   PRODUCTS PAGE — FULL WIDTH PREMIUM TASKBAR
========================================================= */



































































































/* AI HUB */
.ai-hub-fab{
    z-index:99980!important
}

.ai-hub-drawer{
    z-index:99999!important
}

html[data-theme="light"] .ai-hub-drawer{
    background:linear-gradient(
        145deg,
        rgba(255,255,255,.99),
        rgba(242,246,252,.99)
    )!important;
    color:#101828!important;
    border-right-color:rgba(37,99,235,.14)!important;
    box-shadow:24px 0 70px rgba(15,23,42,.20)!important
}

html[data-theme="light"] .ai-hub-drawer-header strong,
html[data-theme="light"] .ai-hub-tool-text strong{
    color:#101828!important
}

html[data-theme="light"] .ai-hub-drawer-header small,
html[data-theme="light"] .ai-hub-tool-text small{
    color:#667085!important
}

html[data-theme="light"] .ai-hub-fab{
    background:linear-gradient(145deg,#fff,#eef4ff)!important;
    color:#172033!important;
    border-color:rgba(37,99,235,.25)!important
}

html[data-theme="dark"] .ai-hub-drawer{
    background:linear-gradient(145deg,#09111f,#020711)!important
}

html[data-theme="dark"] .ai-hub-fab{
    background:linear-gradient(145deg,#1e293b,#050a14)!important
}










</style>

<style data-visual-design>{!! app(\App\Services\WebsiteDesignService::class)->renderCss('customer.products') . app(\App\Services\WebsiteDesignService::class)->renderCss('customer.shared') !!}</style>

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>

<body>

{{-- =========================================================
     PREMIUM COMMON CUSTOMER TASKBAR
========================================================= --}}

@auth

@php
    $currentRoute = request()->route()?->getName();
    $ordersRoute = Route::has('orders.index')
        ? 'orders.index'
        : (Route::has('orders') ? 'orders' : null);
@endphp

<x-products-customer-taskbar :include-robot="false" />

@endauth


{{-- =========================================================
     ⭐ PREMIUM CUSTOMER WELCOME
========================================================= --}}

@if($showWelcome ?? false)

<div
    id="customerWelcomeOverlay"
    class="customer-welcome-overlay"
    role="status"
    aria-live="polite"
    aria-label="Welcome to Smart Basket"
>

    {{-- RGB background aura --}}
    <div class="customer-welcome-bg"></div>
    <div class="customer-welcome-watermark" aria-hidden="true">SMART BASKET</div>


    <div class="customer-welcome-content">


        {{-- =================================================
             FEMALE SHOPKEEPER / NAMASTE
        ================================================= --}}

        <div class="customer-welcome-person">

            <span class="welcome-spark one"></span>
            <span class="welcome-spark two"></span>
            <span class="welcome-spark three"></span>
            <span class="welcome-spark four"></span>


            {{-- Female greeting emoji --}}
            <div class="customer-welcome-woman">
                👩🏻
            </div>


            {{-- Namaste hands --}}
            <div class="customer-welcome-namaste">
                🙏🏻
            </div>

        </div>


        {{-- =================================================
             WELCOME TITLE
        ================================================= --}}

        <div class="customer-welcome-title">
            WELCOME
        </div>

        <div class="customer-welcome-line"></div>


        {{-- Subtitle --}}
        <div class="customer-welcome-subtitle">

            <span>
                WELCOME TO
            </span>

            <strong>
                SMART BASKET
            </strong>

        </div>

        <p class="customer-welcome-tagline">Your smarter shopping journey starts now.</p>
        <button type="button" class="customer-welcome-voice" id="customerWelcomeVoice">
            <i class="fa-solid fa-volume-high"></i><span>Hear the welcome</span>
        </button>
        <div class="customer-welcome-progress" aria-hidden="true"><i></i></div>

    </div>

</div>

@endif


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<div class="sb-wrap">

    {{-- HERO --}}

    <x-customer-page-hero data-ve="customer.products.hero" :stat="$pagedProducts->total()" stat-label="Products">

        <div class="hero-glow one"></div>
        <div class="hero-glow two"></div>
        <div class="hero-glow three"></div>

        <div class="hero-grid"></div>


        <div class="hero-content">

            <span class="eyebrow">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                SMART SHOPPING EXPERIENCE

            </span>


            <h1 class="sb-customer-page-title"><span class="hero-gradient">{{ app(\App\Services\WebsiteDesignService::class)->content('customer.products', 'hero', 'title', 'Shop smarter. Live better.') }}</span></h1>


            <p class="hero-subtitle">

                {{ app(\App\Services\WebsiteDesignService::class)->content('customer.products', 'hero', 'body', 'Discover quality products with a beautiful, fast and intelligent shopping experience designed for you.') }}

            </p>


            <div class="hero-actions">

                <a
                    href="#products"
                    class="hero-btn hero-btn-primary"
                >

                    <i class="fa-solid fa-bag-shopping"></i>

                    {{ app(\App\Services\WebsiteDesignService::class)->content('customer.products', 'hero', 'button_label', 'Explore Products') }}

                    <i class="fa-solid fa-arrow-right"></i>

                </a>


                <a
                    href="#products"
                    class="hero-btn hero-btn-secondary"
                >

                    <i class="fa-solid fa-sparkles"></i>

                    Start Shopping

                </a>

            </div>

        </div>


        <div class="hero-art">

            <div class="core-ring one"></div>
            <div class="core-ring two"></div>
            <div class="core-ring three"></div>
            <div class="core-ring four"></div>

            <div class="rgb-core"></div>


            <div class="hero-basket">

                <i class="fa-solid fa-basket-shopping"></i>

            </div>


            <div class="hero-float one">

                <span class="hero-float-icon">

                    <i class="fa-solid fa-box-open"></i>

                </span>

                <div>

                    <strong>
                        {{ $pagedProducts->total() }}
                    </strong>

                    <small>
                        PRODUCTS
                    </small>

                </div>

            </div>


            <div class="hero-float two">

                <span class="hero-float-icon">

                    <i class="fa-solid fa-bolt"></i>

                </span>

                <div>

                    <strong>
                        24/7
                    </strong>

                    <small>
                        SMART SHOPPING
                    </small>

                </div>

            </div>

        </div>

    </x-customer-page-hero>


    {{-- PRODUCTS HEADER --}}

    <div
        class="section-head"
        id="products"
    >

        <div>

            <h2>
                Find your next favorite
            </h2>

            <p>
                Fresh products added by sellers,
                ready for customers.
            </p>

        </div>


        <span class="count">

            {{ $pagedProducts->total() }}

            Products

        </span>

    </div>


    {{-- FILTER --}}

    <form
        method="GET"
        action="{{ route('products.index') }}"
        class="filters"
    >

        <div class="row g-3">

            <div class="col-12 col-md-6">

                <label>
                    Search products
                </label>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Search by product name..."
                >

            </div>


            <div class="col-12 col-md-4">

                <label>
                    Category
                </label>

                <select
                    name="category"
                    class="form-select"
                >

                    <option value="">
                        All Categories
                    </option>

                    @foreach($categories as $categoryOption)

                        <option
                            value="{{ $categoryOption }}"
                            {{ $category === $categoryOption ? 'selected' : '' }}
                        >
                            {{ $categoryOption }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-12 col-md-2 d-flex align-items-end">

                <button
                    class="apply w-100"
                    type="submit"
                >

                    <i class="fa-solid fa-magnifying-glass me-1"></i>

                    Apply

                </button>

            </div>

        </div>

    </form>


    {{-- FEATURED PRODUCTS --}}

    <div class="section-head">

        <div>

            <h2>
                Featured products
            </h2>

            <p>
                Curated products selected for you.
            </p>

        </div>


        <span class="count">

            Showing

            {{ $pagedProducts->count() }}

            of

            {{ $pagedProducts->total() }}

        </span>

    </div>


    @if($pagedProducts->count() > 0)

        <div class="row g-4">

            @foreach($pagedProducts as $product)

                @php

                    $originalPrice =
                        (float) $product->price;

                    $currentPrice = (float) $product->effective_price;

                    $hasDiscount =
                        $currentPrice > 0 &&
                        $originalPrice > $currentPrice;

                    $discountPercent =
                        $hasDiscount
                        ? round(
                            (
                                ($originalPrice - $currentPrice)
                                / $originalPrice
                            ) * 100
                        )
                        : 0;

                    $promoNow = now();
                    $saleIsScheduled = $product->sale_price !== null
                        && $product->sale_starts_at && $product->sale_ends_at
                        && $product->sale_ends_at->isAfter($promoNow)
                        && (float) $product->sale_price < $originalPrice;
                    $saleIsLive = $saleIsScheduled && $product->sale_starts_at->lte($promoNow);
                    $saleTimerTarget = $saleIsLive ? $product->sale_ends_at : ($saleIsScheduled ? $product->sale_starts_at : null);
                    $salePercentOff = $saleIsScheduled && $originalPrice > 0
                        ? max(0, (int) round((1 - ((float) $product->sale_price / $originalPrice)) * 100))
                        : 0;
                    $couponHasDetails = filled($product->coupon_code) || filled($product->coupon_title);
                    $couponIsScheduled = $couponHasDetails && $product->coupon_ends_at && $product->coupon_ends_at->isAfter($promoNow);
                    $couponIsLive = $couponIsScheduled && (!$product->coupon_starts_at || $product->coupon_starts_at->lte($promoNow));
                    $couponTimerTarget = $couponIsScheduled && !$couponIsLive ? $product->coupon_starts_at : ($couponIsLive ? $product->coupon_ends_at : null);
                    $couponPercentOff = $product->coupon_discount_type === 'percent' && $product->coupon_discount_value !== null
                        ? (int) round((float) $product->coupon_discount_value)
                        : null;

                @endphp


                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <article
                        class="product-card product-card--clickable"
                        data-ve="customer.products.card"
                        data-smart-ai-product-id="{{ $product->id }}"
                        data-product-url="{{ route('product.show', $product) }}"
                        tabindex="0"
                        role="link"
                        aria-label="View {{ $product->name }}"
                    >

                        <div class="media">

                            <img
                                src="{{ asset('products/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                                onerror="
                                    this.style.display='none';
                                    this.nextElementSibling.hidden=false;
                                "
                            >


                            <div
                                hidden
                                style="
                                    text-align:center;
                                    color:var(--muted)
                                "
                            >

                                <i
                                    class="fa-solid fa-image fa-2x mb-2"
                                ></i>

                                <div>
                                    No image
                                </div>

                            </div>


                            @if($hasDiscount && !$saleIsScheduled)

                                <span class="discount">

                                    {{ $discountPercent }}% OFF

                                </span>

                            @endif

                            @if($saleIsScheduled)
                                <span class="product-sale-badge">{{ $salePercentOff }}% OFF</span>
                            @endif


                            @auth

                                <form
                                    method="POST"
                                    action="{{ route('wishlist.add', $product->id) }}"
                                    class="product-card-action"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="wishlist"
                                        title="Add to wishlist"
                                    >

                                        <i
                                            class="fa-regular fa-heart"
                                        ></i>

                                    </button>

                                </form>

                            @endauth

                        </div>


                        <div class="body">

                            <div class="category">

                                {{ $product->category ?: 'General' }}

                            </div>


                            <h3 class="title">

                                {{ $product->name }}

                            </h3>


                            <div class="rating">

                                <i class="fa-solid fa-star"></i>

                                <strong>

                                    {{
                                        number_format(
                                            (float)$product->rating,
                                            1
                                        )
                                    }}

                                </strong>

                                <span>
                                    •
                                </span>

                                <span>

                                    {{ $product->stock ?? 0 }}

                                    left

                                </span>

                            </div>


                            <p class="description">

                                {{
                                    $product->description
                                    ? \Illuminate\Support\Str::limit(
                                        $product->description,
                                        95
                                    )
                                    : 'Premium quality product from Smart Basket.'
                                }}

                            </p>


                            <div class="price">

                                ₹{{ number_format($currentPrice, 2) }}

                                @if($hasDiscount)

                                    <del class="old">

                                        ₹{{ number_format($originalPrice, 2) }}

                                    </del>

                                @endif

                            </div>

                            @if($saleTimerTarget)
                                <div class="card-promotion-timer card-promotion-timer--sale" data-promotion-countdown="{{ $saleTimerTarget->toIso8601String() }}" data-promotion-reload>
                                    <i class="fa-solid fa-stopwatch" aria-hidden="true"></i><span>{{ $saleIsLive ? 'Sale ends' : 'Sale starts' }}</span>
                                    <b data-unit="days">00</b>d <b data-unit="hours">00</b>h <b data-unit="minutes">00</b>m <b data-unit="seconds">00</b>s
                                </div>
                            @endif
                            @if($couponTimerTarget)
                                <section class="product-card-coupon" data-design="{{ in_array($product->coupon_design, ['royal','sunset','emerald','gold'], true) ? $product->coupon_design : 'royal' }}" aria-label="Seller coupon">
                                    <div class="product-card-coupon__icon"><i class="fa-solid fa-ticket" aria-hidden="true"></i></div>
                                    <div class="product-card-coupon__content">
                                        <div class="product-card-coupon__top">
                                            <div><span class="product-card-coupon__label">{{ $couponIsLive ? 'Seller coupon' : 'Upcoming coupon' }}</span><div class="product-card-coupon__title">{{ $product->coupon_title ?: 'Special offer' }}</div></div>
                                            <span class="product-card-coupon__discount">{{ $couponPercentOff !== null ? $couponPercentOff . '% OFF' : ($product->coupon_discount_value !== null ? '₹' . number_format((float) $product->coupon_discount_value, 0) . ' OFF' : 'COUPON') }}</span>
                                        </div>
                                        @if($product->coupon_description)<p class="product-card-coupon__description">{{ \Illuminate\Support\Str::limit($product->coupon_description, 72) }}</p>@endif
                                        <div class="card-promotion-timer" data-promotion-countdown="{{ $couponTimerTarget->toIso8601String() }}" data-promotion-reload>
                                            <i class="fa-solid fa-stopwatch" aria-hidden="true"></i><span>{{ $couponIsLive ? 'Expires' : 'Starts' }}</span>
                                            <b data-unit="days">00</b>d <b data-unit="hours">00</b>h <b data-unit="minutes">00</b>m <b data-unit="seconds">00</b>s
                                        </div>
                                    </div>
                                </section>
                            @endif


                            <div
                                class="stock {{
                                    (int)$product->stock < 1
                                        ? 'out'
                                        : ''
                                }}"
                            >

                                <i
                                    class="fa-solid {{
                                        (int)$product->stock > 0
                                            ? 'fa-circle-check'
                                            : 'fa-circle-xmark'
                                    }}"
                                ></i>

                                {{
                                    (int)$product->stock > 0
                                        ? 'In Stock'
                                        : 'Sold Out'
                                }}

                            </div>


                            <div
                                class="actions product-card-action"
                            >

                                <a
                                    href="{{ route('product.show', $product) }}"
                                    class="action"
                                >

                                    <i
                                        class="fa-regular fa-eye"
                                    ></i>

                                    View

                                </a>


                                <a
                                    href="{{ url('/buy-now/' . $product->id) }}"
                                    class="action"
                                >

                                    <i
                                        class="fa-solid fa-bolt"
                                    ></i>

                                    Buy

                                </a>


                                <form
                                    action="{{ route('cart.add', $product->id) }}"
                                    method="POST"
                                    class="cart-action"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="action primary w-100"
                                        {{
                                            (int)$product->stock < 1
                                                ? 'disabled'
                                                : ''
                                        }}
                                    >

                                        <i
                                            class="fa-solid fa-cart-plus"
                                        ></i>

                                        Cart

                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                </div>

            @endforeach

        </div>


        <div
            class="d-flex justify-content-center mt-5"
        >

            {{
                $pagedProducts
                    ->appends(request()->query())
                    ->links('pagination::bootstrap-5')
            }}

        </div>


    @else

        <div class="empty">

            <i class="fa-solid fa-box-open"></i>

            <h3>
                No products found
            </h3>

            <p>
                Try adjusting your search or category filter.
            </p>

            <a
                href="{{ route('products.index') }}"
                class="action d-inline-flex mt-2 px-4"
            >

                Clear filters

            </a>

        </div>

    @endif


    <div class="footer">

        © {{ date('Y') }}

        SMART BASKET

        · Quality products, smarter shopping.

    </div>

</div>


{{-- =========================================================
     AI HUB SIDEBAR
========================================================= --}}

<div
    class="sb-products-smart-ai-host"
    aria-hidden="false"
>

    <x-smart-ai-robot />

</div>

<x-ai-hub-sidebar :without-menu="true" />





{{-- =========================================================
     PRODUCT / TASKBAR JAVASCRIPT
========================================================= --}}

<script>

(function () {

    'use strict';


    /* =====================================================
       THEME
    ===================================================== */

    function applyTheme(theme) {

        if (
            !['light', 'dark'].includes(theme)
        ) {

            theme = 'dark';

        }

        document.documentElement
            .setAttribute(
                'data-theme',
                theme
            );

        document.documentElement
            .setAttribute(
                'data-sb-theme',
                theme
            );

        document.body
            .setAttribute(
                'data-sb-theme',
                theme
            );

    }


    const savedTheme =
        localStorage.getItem(
            'sb-theme'
        );


    if (
        savedTheme === 'light' ||
        savedTheme === 'dark'
    ) {

        applyTheme(savedTheme);

    } else {

        applyTheme(
            window.SB_THEME || 'dark'
        );

    }


    /* =====================================================
       THEME EVENTS
    ===================================================== */

    window.addEventListener(
        'sb-theme-changed',
        function (event) {

            const theme =
                event.detail?.theme;

            if (
                theme === 'light' ||
                theme === 'dark'
            ) {

                localStorage.setItem(
                    'sb-theme',
                    theme
                );

                applyTheme(theme);

            }

        }
    );


    window.addEventListener(
        'smartbasket-theme-changed',
        function (event) {

            const theme =
                event.detail?.theme;

            if (
                theme === 'light' ||
                theme === 'dark'
            ) {

                localStorage.setItem(
                    'sb-theme',
                    theme
                );

                applyTheme(theme);

            }

        }
    );


    /* =====================================================
       PRODUCT CARD ACTION PROTECTION
    ===================================================== */

    document
        .querySelectorAll(
            '.product-card-action'
        )
        .forEach(
            function (element) {

                element.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );

            }
        );


    /* =====================================================
       PRODUCT CARD CLICK
    ===================================================== */

    document
        .querySelectorAll(
            '.product-card--clickable'
        )
        .forEach(
            function (card) {

                const visitProduct =
                    function (event) {

                        if (
                            event.target.closest(
                                'a, button, form, input, select, textarea, label'
                            )
                        ) {

                            return;

                        }


                        const url =
                            card.dataset.productUrl;


                        if (url) {

                            window.location.href =
                                url;

                        }

                    };


                card.addEventListener(
                    'click',
                    visitProduct
                );


                card.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            (
                                event.key === 'Enter' ||
                                event.key === ' '
                            )
                            &&
                            !event.target.closest(
                                'a, button, form, input, select, textarea, label'
                            )
                        ) {

                            event.preventDefault();


                            const url =
                                card.dataset.productUrl;


                            if (url) {

                                window.location.href =
                                    url;

                            }

                        }

                    }
                );

            }
        );

})();

</script>


{{-- =========================================================
     ⭐ WELCOME — 3 SECOND PREMIUM DISPLAY
========================================================= --}}

@if($showWelcome ?? false)

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const welcomeOverlay =
            document.getElementById(
                'customerWelcomeOverlay'
            );


        if (!welcomeOverlay) {

            return;

        }

        const voiceButton = document.getElementById('customerWelcomeVoice');
        const speakWelcome = function () {
            if (!('speechSynthesis' in window) || !('SpeechSynthesisUtterance' in window)) {
                if (voiceButton) voiceButton.hidden = true;
                return;
            }
            window.speechSynthesis.cancel();
            const greeting = new SpeechSynthesisUtterance('Welcome to Smart Basket. Your smarter shopping experience begins now. Let us find something wonderful for you.');
            const availableVoices = window.speechSynthesis.getVoices();
            greeting.voice = availableVoices.find(voice => /^en-IN$/i.test(voice.lang)) || availableVoices.find(voice => /^en-/i.test(voice.lang)) || null;
            greeting.lang = greeting.voice ? greeting.voice.lang : 'en-US';
            greeting.rate = 0.91;
            greeting.pitch = 1.08;
            greeting.volume = 0.95;
            if (voiceButton) {
                greeting.onstart = function () { voiceButton.querySelector('span').textContent = 'Playing welcome'; };
                greeting.onend = function () { voiceButton.querySelector('span').textContent = 'Hear it again'; };
                greeting.onerror = function () { voiceButton.querySelector('span').textContent = 'Tap to hear welcome'; };
            }
            window.speechSynthesis.speak(greeting);
        };
        if (voiceButton) voiceButton.addEventListener('click', speakWelcome);
        window.setTimeout(speakWelcome, 450);


        /*
         * Premium welcome sequence:
         *
         * 0s     → entrance animation
         * 0-3s   → female Namaste animation
         * 3s     → smooth fade
         * 3.7s   → remove from DOM
         */

        window.setTimeout(
            function () {

                const productsPage = document.querySelector('.sb-wrap');
                if (productsPage) productsPage.classList.add('customer-welcome-zoom-in');

                welcomeOverlay.classList.add(
                    'is-hidden'
                );


                window.setTimeout(
                    function () {

                        if (welcomeOverlay) {

                            window.speechSynthesis?.cancel();
                            welcomeOverlay.remove();

                        }

                    },
                    700
                );

            },
            5500
        );

    }
);

</script>

@endif


<script>
    (() => {
        const timers = [...document.querySelectorAll('[data-promotion-countdown]')];
        const renderTimer = (timer) => {
            const target = new Date(timer.dataset.promotionCountdown).getTime();
            const left = Math.max(0, target - Date.now());
            const values = {
                days: Math.floor(left / 86400000),
                hours: Math.floor((left % 86400000) / 3600000),
                minutes: Math.floor((left % 3600000) / 60000),
                seconds: Math.floor((left % 60000) / 1000),
            };
            Object.entries(values).forEach(([unit, value]) => {
                const part = timer.querySelector(`[data-unit="${unit}"]`);
                if (part) part.textContent = String(value).padStart(2, '0');
            });
            if (left === 0 && timer.hasAttribute('data-promotion-reload') && !timer.dataset.reloaded) {
                timer.dataset.reloaded = 'true';
                window.location.reload();
            }
        };
        timers.forEach(renderTimer);
        window.setInterval(() => timers.forEach(renderTimer), 1000);
    })();
</script>
@if(session('return_request_success'))
    @php($returnSuccess = session('return_request_success'))
    <style>
        .return-success-overlay{position:fixed!important;z-index:100001!important;inset:0;display:grid;place-items:center;padding:20px;background:rgba(8,18,40,.62);backdrop-filter:blur(10px);opacity:1;transition:opacity .35s ease}
        .return-success-overlay.is-leaving{opacity:0;pointer-events:none}
        .return-success-card{position:relative;width:min(100%,470px);overflow:hidden;padding:36px 30px 26px;border:1px solid rgba(255,255,255,.8);border-radius:28px;background:linear-gradient(150deg,#fff,#f7faff 62%,#effaf7);box-shadow:0 34px 90px rgba(5,16,44,.34);text-align:center;animation:returnSuccessIn .48s cubic-bezier(.2,.85,.25,1.2) both}
        .return-success-card:before{position:absolute;top:0;right:0;left:0;height:6px;background:linear-gradient(90deg,#08a887,#3278e8 55%,#7452d8);content:""}
        .return-success-mark{display:grid;width:84px;height:84px;place-items:center;margin:0 auto 20px;border:1px solid #bcebdc;border-radius:27px;background:linear-gradient(145deg,#e6fff5,#d9f4ed);color:#07866e;font-size:35px;box-shadow:0 12px 28px rgba(11,143,112,.16);animation:returnSuccessCheck .55s .12s cubic-bezier(.2,.85,.25,1.35) both}
        .return-success-card h2{margin:0;color:#172640;font-size:clamp(23px,5vw,29px);font-weight:950;letter-spacing:-.045em}
        .return-success-card p{margin:10px 0 0;color:#687790;font-size:14px;line-height:1.65}
        .return-success-ref{display:inline-flex;gap:8px;align-items:center;margin-top:16px;padding:9px 13px;border:1px solid #dfe9f5;border-radius:999px;background:#fff;color:#3156a7;font-size:12px;font-weight:850}
        .return-success-go{display:flex;min-height:49px;align-items:center;justify-content:center;gap:9px;margin-top:22px;padding:0 18px;border:1px solid rgba(255,255,255,.2);border-radius:15px;background:linear-gradient(110deg,#087d70,#2361d4 58%,#6846c7);box-shadow:0 12px 25px rgba(34,85,171,.22);color:#fff!important;font-size:13px;font-weight:900;text-decoration:none}
        .return-success-hint{margin-top:12px;color:#8490a2;font-size:11px}
        .return-success-bar{height:4px;margin:17px -30px -26px;background:#eaf0f6}
        .return-success-bar span{display:block;width:100%;height:100%;transform-origin:left;background:linear-gradient(90deg,#08a887,#3278e8 55%,#7452d8);animation:returnSuccessProgress 2.6s linear forwards}
        @keyframes returnSuccessIn{from{opacity:0;transform:translateY(18px) scale(.94)}to{opacity:1;transform:translateY(0) scale(1)}}
        @keyframes returnSuccessCheck{from{opacity:0;transform:scale(.55) rotate(-12deg)}to{opacity:1;transform:scale(1) rotate(0)}}
        @keyframes returnSuccessProgress{to{transform:scaleX(0)}}
        @media(max-width:520px){.return-success-card{padding:32px 22px 24px;border-radius:24px}.return-success-bar{margin:17px -22px -24px}}
        @media(prefers-reduced-motion:reduce){.return-success-card,.return-success-mark,.return-success-bar span{animation:none!important}.return-success-overlay{transition:none}.return-success-bar span{transform:scaleX(.1)}}
    </style>
    <div class="return-success-overlay" id="returnSuccessOverlay" role="presentation">
        <section class="return-success-card" role="dialog" aria-modal="true" aria-labelledby="returnSuccessTitle" aria-describedby="returnSuccessText">
            <div class="return-success-mark" aria-hidden="true"><i class="fa-solid fa-check"></i></div>
            <h2 id="returnSuccessTitle">Return request successful!</h2>
            <p id="returnSuccessText">Your request was submitted successfully. Our team will review it and update its status.</p>
            <div class="return-success-ref"><i class="fa-solid fa-receipt" aria-hidden="true"></i>Order #{{ $returnSuccess['order_id'] }} <span aria-hidden="true">&middot;</span> Request #{{ $returnSuccess['return_id'] }}</div>
            <a class="return-success-go" href="{{ route('products.index') }}"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>Continue shopping</a>
            <div class="return-success-hint">Opening the product page now...</div>
            <div class="return-success-bar" aria-hidden="true"><span></span></div>
        </section>
    </div>
    <script>
        (() => {
            const popup = document.getElementById('returnSuccessOverlay');
            if (!popup) return;
            window.setTimeout(() => {
                popup.classList.add('is-leaving');
                window.setTimeout(() => popup.remove(), 380);
            }, 2600);
        })();
    </script>
@endif
</body>
</html>

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

        /* ---------------------------------------------------------
           RESPONSIVE WELCOME
        --------------------------------------------------------- */

        @media (max-width: 600px) {

            .customer-welcome-person {
                transform:
                    scale(.88);

                margin-bottom:
                    0;
            }

            .customer-welcome-woman {
                font-size: 72px;
            }

            .customer-welcome-namaste {
                top: 75px;
                font-size: 39px;
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

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;

                transition-duration:
                    .01ms !important;
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
    backdrop-filter:blur(24px) saturate(155%);
    -webkit-backdrop-filter:blur(24px) saturate(155%);
}

.sb-products-taskbar:before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:-2px;
    height:2px;
    background:linear-gradient(
        90deg,
        #00e5ff,
        #287bff,
        #8b35ff,
        #ff20c8,
        #ff405d,
        #ffe45c,
        #00e5ff
    );
    background-size:600% 100%;
    animation:sbTaskbarRGB 8s linear infinite;
    pointer-events:none;
}

@keyframes sbTaskbarRGB{
    to{
        background-position:600% 50%
    }
}

.sb-products-brand{
    flex:0 0 208px;
    min-width:190px;
    height:58px;
    padding:5px 10px 5px 6px;
    display:flex;
    align-items:center;
    gap:10px;
    border-radius:18px;
    color:var(--sb-tbar-text)!important;
    text-decoration:none!important;
    border:1px solid transparent;
    transition:.22s ease;
}

.sb-products-brand:hover{
    background:var(--sb-tbar-soft);
    border-color:var(--sb-tbar-border);
    transform:translateY(-1px)
}

.sb-brand-mark{
    width:45px;
    height:45px;
    display:grid;
    place-items:center;
    border-radius:14px;
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    box-shadow:
        0 8px 22px rgba(37,99,235,.30),
        inset 0 1px rgba(255,255,255,.25);
    font-size:17px
}

.sb-brand-copy{
    display:flex;
    flex-direction:column;
    line-height:1.05;
    min-width:0
}

.sb-brand-copy strong{
    font-size:14px;
    letter-spacing:.4px
}

.sb-brand-copy small{
    margin-top:5px;
    font-size:8px;
    letter-spacing:1.25px;
    color:var(--sb-tbar-muted);
    font-weight:900
}

.sb-products-nav{
    display:flex;
    align-items:center;
    gap:6px;
    flex:1;
    min-width:0
}

.sb-pnav-btn{
    position:relative;
    flex:1;
    min-width:82px;
    height:50px;
    padding:0 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    border:1px solid rgba(37,99,235,.13);
    border-radius:14px;
    background:linear-gradient(
        180deg,
        var(--sb-tbar-panel),
        var(--sb-tbar-soft)
    );
    color:var(--sb-tbar-muted)!important;
    font-size:11px;
    font-weight:900;
    text-decoration:none!important;
    white-space:nowrap;
    cursor:pointer;
    box-shadow:0 5px 16px rgba(37,99,235,.06);
    transition:.2s ease;
}

.sb-pnav-btn i{
    font-size:13px;
    width:16px;
    text-align:center
}

.sb-pnav-btn:hover{
    color:var(--sb-tbar-blue)!important;
    border-color:rgba(37,99,235,.32);
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(37,99,235,.13)
}

.sb-pnav-btn.is-active{
    color:#fff!important;
    border-color:transparent;
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    box-shadow:0 10px 28px rgba(37,99,235,.28)
}

.sb-pnav-aihub{
    color:#2563eb!important
}

.sb-pnav-aihub:hover{
    color:#fff!important;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent
}

.sb-pnav-smart-ai{
    color:#4f46e5!important
}

.sb-pnav-smart-ai:hover{
    color:#fff!important;
    background:linear-gradient(135deg,#4f46e5,#9333ea);
    border-color:transparent
}

.sb-smart-orb{
    width:25px;
    height:25px;
    display:grid;
    place-items:center;
    border-radius:8px;
    color:#fff;
    background:linear-gradient(135deg,#4f46e5,#9333ea);
    box-shadow:0 5px 14px rgba(79,70,229,.25);
    font-size:11px
}

.sb-online-dot{
    position:absolute;
    top:7px;
    right:8px;
    width:6px;
    height:6px;
    border-radius:50%;
    background:#22c55e;
    box-shadow:0 0 0 3px rgba(34,197,94,.13)
}

.sb-taskbar-user{
    flex:0 1 145px;
    min-width:105px;
    height:50px;
    padding:0 10px;
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid var(--sb-tbar-border);
    border-radius:14px;
    background:var(--sb-tbar-panel);
    box-shadow:0 5px 16px rgba(37,99,235,.05);
    animation:sbHiFloat 3s ease-in-out infinite
}

@keyframes sbHiFloat{
    0%,100%{
        transform:translateY(0)
    }

    50%{
        transform:translateY(-2px)
    }
}

.sb-user-dot{
    width:31px;
    height:31px;
    display:grid;
    place-items:center;
    border-radius:10px;
    background:var(--sb-tbar-soft);
    color:var(--sb-tbar-blue);
    flex:0 0 31px
}

.sb-user-text{
    display:flex;
    flex-direction:column;
    min-width:0;
    line-height:1.05
}

.sb-user-text small{
    font-size:8px;
    color:var(--sb-tbar-muted);
    font-weight:800
}

.sb-user-text strong{
    margin-top:4px;
    font-size:10px;
    color:var(--sb-tbar-text);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    max-width:92px
}

.sb-products-more{
    flex:0 0 52px;
    height:50px;
    border:1px solid var(--sb-tbar-border);
    border-radius:14px;
    background:var(--sb-tbar-panel);
    color:var(--sb-tbar-text);
    cursor:pointer;
    font-size:17px;
    transition:.2s ease;
    box-shadow:0 5px 16px rgba(37,99,235,.06)
}

.sb-products-more:hover{
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent;
    transform:translateY(-2px)
}

.sb-products-more-menu{
    position:fixed;
    z-index:100000;
    top:84px;
    right:12px;
    width:290px;
    max-height:calc(100vh - 100px);
    overflow:auto;
    padding:10px;
    border:1px solid var(--sb-tbar-border);
    border-radius:22px;
    background:var(--sb-tbar-bg);
    box-shadow:0 30px 90px rgba(0,0,0,.28);
    backdrop-filter:blur(28px);
    -webkit-backdrop-filter:blur(28px);
    display:none
}

.sb-products-more-menu.is-open{
    display:block;
    animation:sbMenuIn .2s ease
}

.sb-more-heading{
    padding:9px 10px 11px;
    border-bottom:1px solid var(--sb-tbar-border);
    margin-bottom:5px
}

.sb-more-heading span{
    display:block;
    color:var(--sb-tbar-text);
    font-size:11px;
    font-weight:950;
    letter-spacing:.7px
}

.sb-more-heading small{
    display:block;
    margin-top:4px;
    color:var(--sb-tbar-muted);
    font-size:8px
}

.sb-more-link{
    width:100%;
    min-height:42px;
    padding:0 11px;
    display:flex;
    align-items:center;
    gap:10px;
    border:0;
    border-radius:12px;
    background:transparent;
    color:var(--sb-tbar-text)!important;
    text-decoration:none!important;
    font-size:10px;
    font-weight:850;
    cursor:pointer
}

.sb-more-link i{
    width:18px;
    text-align:center;
    color:var(--sb-tbar-blue)
}

.sb-more-link:hover{
    background:var(--sb-tbar-soft);
    color:var(--sb-tbar-blue)!important;
    transform:translateX(2px)
}

.sb-more-separator{
    height:1px;
    margin:7px 5px;
    background:var(--sb-tbar-border)
}

.sb-more-title{
    display:flex;
    gap:8px;
    align-items:center;
    padding:5px 10px 7px;
    color:var(--sb-tbar-muted);
    font-size:9px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.08em
}

.sb-theme-switcher{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:6px
}

.sb-theme-choice{
    height:38px;
    border:1px solid var(--sb-tbar-border);
    border-radius:11px;
    background:var(--sb-tbar-panel);
    color:var(--sb-tbar-text);
    font-size:10px;
    font-weight:850;
    cursor:pointer
}

.sb-theme-choice:hover,
.sb-theme-choice.is-selected{
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border-color:transparent
}

.sb-theme-choice i{
    margin-right:5px
}

.sb-more-action{
    font-family:inherit;
    text-align:left
}

.sb-logout-form{
    margin:0
}

.sb-logout{
    color:#e05b72!important
}

.sb-logout i{
    color:#e05b72!important
}

@keyframes sbMenuIn{
    from{
        opacity:0;
        transform:translateY(-8px) scale(.98)
    }

    to{
        opacity:1;
        transform:none
    }
}

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

.sb-products-smart-ai-host>.smart-ai>.smart-ai__launch{
    opacity:0!important;
    visibility:hidden!important;
    pointer-events:none!important;
    position:fixed!important;
    width:1px!important;
    height:1px!important;
    overflow:hidden!important;
    clip:rect(0,0,0,0)!important
}

.sb-products-smart-ai-host [data-smart-ai-panel]{
    z-index:100001!important
}

@media(max-width:1350px){
    .sb-products-brand{
        flex-basis:185px;
        min-width:175px
    }

    .sb-pnav-btn{
        min-width:70px;
        padding:0 7px;
        font-size:10px
    }

    .sb-taskbar-user{
        flex-basis:125px
    }
}

@media(max-width:1120px){
    .sb-brand-copy{
        display:none
    }

    .sb-products-brand{
        flex-basis:65px;
        min-width:65px;
        justify-content:center;
        padding:5px
    }

    .sb-pnav-btn span{
        display:none
    }

    .sb-pnav-btn{
        min-width:52px;
        padding:0
    }

    .sb-taskbar-user{
        flex-basis:90px;
        min-width:90px
    }

    .sb-user-text strong{
        max-width:52px
    }
}

@media(max-width:700px){
    .sb-products-taskbar{
        padding:7px;
        gap:5px;
        overflow-x:auto;
        scrollbar-width:none
    }

    .sb-products-taskbar::-webkit-scrollbar{
        display:none
    }

    .sb-products-brand{
        position:sticky;
        left:0;
        z-index:2;
        flex-basis:52px;
        min-width:52px;
        height:48px
    }

    .sb-brand-mark{
        width:39px;
        height:39px
    }

    .sb-products-nav{
        flex:0 0 auto
    }

    .sb-pnav-btn{
        height:46px;
        min-width:48px;
        flex:0 0 48px;
        border-radius:12px
    }

    .sb-taskbar-user{
        flex:0 0 110px;
        height:46px
    }

    .sb-products-more{
        flex:0 0 46px;
        height:46px
    }

    .sb-products-more-menu{
        top:66px;
        right:7px;
        width:min(290px,calc(100vw - 14px))
    }
}
</style>

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

<nav
    class="sb-products-taskbar"
    id="sbProductsTaskbar"
    aria-label="Customer Navigation"
>

    <a
        href="{{ route('products.index') }}"
        class="sb-products-brand"
        aria-label="Smart Basket Products"
    >

        <span class="sb-brand-mark">
            <i class="fa-solid fa-basket-shopping"></i>
        </span>

        <span class="sb-brand-copy">

            <strong>
                SMART BASKET
            </strong>

            <small>
                CUSTOMER PANEL
            </small>

        </span>

    </a>

    <div class="sb-products-nav">

        @if(Route::has('products.index'))

            <a
                href="{{ route('products.index') }}"
                class="sb-pnav-btn {{ $currentRoute === 'products.index' ? 'is-active' : '' }}"
            >

                <i class="fa-solid fa-store"></i>

                <span>
                    Products
                </span>

            </a>

        @endif


        @if($ordersRoute)

            <a
                href="{{ route($ordersRoute) }}"
                class="sb-pnav-btn {{ $currentRoute === $ordersRoute ? 'is-active' : '' }}"
            >

                <i class="fa-solid fa-box"></i>

                <span>
                    Orders
                </span>

            </a>

        @endif


        @if(Route::has('cart.index'))

            <a
                href="{{ route('cart.index') }}"
                class="sb-pnav-btn {{ $currentRoute === 'cart.index' ? 'is-active' : '' }}"
            >

                <i class="fa-solid fa-cart-shopping"></i>

                <span>
                    Cart
                </span>

            </a>

        @endif


        @if(Route::has('wishlist'))

            <a
                href="{{ route('wishlist') }}"
                class="sb-pnav-btn {{ $currentRoute === 'wishlist' ? 'is-active' : '' }}"
            >

                <i class="fa-regular fa-heart"></i>

                <span>
                    Wishlist
                </span>

            </a>

        @endif


        @if(Route::has('profile'))

            <a
                href="{{ route('profile') }}"
                class="sb-pnav-btn {{ $currentRoute === 'profile' ? 'is-active' : '' }}"
            >

                <i class="fa-regular fa-user"></i>

                <span>
                    Profile
                </span>

            </a>

        @endif


        @if(Route::has('settings'))

            <a
                href="{{ route('settings') }}"
                class="sb-pnav-btn {{ $currentRoute === 'settings' ? 'is-active' : '' }}"
            >

                <i class="fa-solid fa-gear"></i>

                <span>
                    Settings
                </span>

            </a>

        @endif


        <button
            type="button"
            class="sb-pnav-btn sb-pnav-aihub"
            id="sbProductsAIHub"
            data-sb-ai-hub-open
            title="Open AI Hub"
        >

            <i class="fa-solid fa-wand-magic-sparkles"></i>

            <span>
                AI HUB
            </span>

        </button>


        <button
            type="button"
            class="sb-pnav-btn sb-pnav-smart-ai"
            id="sbProductsSmartAI"
            title="Open Smart AI"
        >

            <span class="sb-smart-orb">
                <i class="fa-solid fa-robot"></i>
            </span>

            <span>
                Smart AI
            </span>

            <b class="sb-online-dot"></b>

        </button>

    </div>


    <div class="sb-taskbar-user">

        <span class="sb-user-dot">
            <i class="fa-regular fa-user"></i>
        </span>

        <span class="sb-user-text">

            <small>
                Hi,
            </small>

            <strong>
                {{ auth()->user()->name ?? 'Customer' }}
            </strong>

        </span>

    </div>


    <button
        type="button"
        class="sb-products-more"
        id="sbProductsMore"
        aria-expanded="false"
        aria-controls="sbProductsMoreMenu"
        title="More options"
    >

        <i class="fa-solid fa-ellipsis-vertical"></i>

    </button>

</nav>


<div
    class="sb-products-more-menu"
    id="sbProductsMoreMenu"
    aria-hidden="true"
>

    <div class="sb-more-heading">

        <span>
            SMART BASKET
        </span>

        <small>
            More options
        </small>

    </div>


    @if(Route::has('products.index'))

        <a
            href="{{ route('products.index') }}"
            class="sb-more-link"
        >

            <i class="fa-solid fa-house"></i>

            <span>
                Products Home
            </span>

        </a>

    @endif


    @if($ordersRoute)

        <a
            href="{{ route($ordersRoute) }}"
            class="sb-more-link"
        >

            <i class="fa-solid fa-box"></i>

            <span>
                My Orders
            </span>

        </a>

    @endif


    @if(Route::has('cart.index'))

        <a
            href="{{ route('cart.index') }}"
            class="sb-more-link"
        >

            <i class="fa-solid fa-cart-shopping"></i>

            <span>
                Cart
            </span>

        </a>

    @endif


    @if(Route::has('wishlist'))

        <a
            href="{{ route('wishlist') }}"
            class="sb-more-link"
        >

            <i class="fa-regular fa-heart"></i>

            <span>
                Wishlist
            </span>

        </a>

    @endif


    @if(Route::has('profile'))

        <a
            href="{{ route('profile') }}"
            class="sb-more-link"
        >

            <i class="fa-regular fa-user"></i>

            <span>
                Profile
            </span>

        </a>

    @endif


    @if(Route::has('settings'))

        <a
            href="{{ route('settings') }}"
            class="sb-more-link"
        >

            <i class="fa-solid fa-gear"></i>

            <span>
                Settings
            </span>

        </a>

    @endif


    <div class="sb-more-separator"></div>


    <div class="sb-more-title">

        <i class="fa-solid fa-palette"></i>

        <span>
            Theme
        </span>

    </div>


    <div class="sb-theme-switcher">

        <button
            type="button"
            class="sb-theme-choice"
            data-sb-set-theme="light"
        >

            <i class="fa-solid fa-sun"></i>

            <span>
                Light
            </span>

        </button>


        <button
            type="button"
            class="sb-theme-choice"
            data-sb-set-theme="dark"
        >

            <i class="fa-solid fa-moon"></i>

            <span>
                Dark
            </span>

        </button>

    </div>


    <div class="sb-more-separator"></div>


    <button
        type="button"
        class="sb-more-link sb-more-action"
        data-sb-more-aihub
    >

        <i class="fa-solid fa-wand-magic-sparkles"></i>

        <span>
            Open AI HUB
        </span>

    </button>


    <button
        type="button"
        class="sb-more-link sb-more-action"
        data-sb-more-smart-ai
    >

        <i class="fa-solid fa-robot"></i>

        <span>
            Open Smart AI
        </span>

    </button>


    @if(Route::has('logout'))

        <div class="sb-more-separator"></div>

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="sb-logout-form"
        >

            @csrf

            <button
                type="submit"
                class="sb-more-link sb-logout"
            >

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    @endif

</div>

@endauth


{{-- =========================================================
     ⭐ PREMIUM CUSTOMER WELCOME
========================================================= --}}

@if($showWelcome ?? false)

<div
    id="customerWelcomeOverlay"
    class="customer-welcome-overlay"
    aria-hidden="true"
>

    {{-- RGB background aura --}}
    <div class="customer-welcome-bg"></div>


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


        {{-- Premium RGB line --}}
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

    </div>

</div>

@endif


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<div class="sb-wrap">

    {{-- HERO --}}

    <section class="hero">

        <div class="hero-glow one"></div>
        <div class="hero-glow two"></div>
        <div class="hero-glow three"></div>

        <div class="hero-grid"></div>


        <div class="hero-content">

            <span class="eyebrow">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                SMART SHOPPING EXPERIENCE

            </span>


            <h1>

                Shop smarter.

                <br>

                <span class="hero-gradient">
                    Live better.
                </span>

            </h1>


            <p class="hero-subtitle">

                Discover

                <strong>
                    quality products
                </strong>

                with a beautiful, fast and intelligent
                shopping experience designed for you.

            </p>


            <div class="hero-actions">

                <a
                    href="#products"
                    class="hero-btn hero-btn-primary"
                >

                    <i class="fa-solid fa-bag-shopping"></i>

                    Explore Products

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

    </section>


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

                    $currentPrice =
                        (float) (
                            $product->discount_price
                            ?: $product->price
                        );

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

                @endphp


                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <article
                        class="product-card product-card--clickable"
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


                            @if($hasDiscount)

                                <span class="discount">

                                    {{ $discountPercent }}% OFF

                                </span>

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


<script>

(function(){

    'use strict';

    if(window.__SBProductsPremiumTaskbar) return;

    window.__SBProductsPremiumTaskbar=true;


    const more =
        document.getElementById(
            'sbProductsMore'
        );

    const menu =
        document.getElementById(
            'sbProductsMoreMenu'
        );

    const aiHubBtn =
        document.getElementById(
            'sbProductsAIHub'
        );

    const smartAiBtn =
        document.getElementById(
            'sbProductsSmartAI'
        );


    function closeMore(){

        if(menu){

            menu.classList.remove(
                'is-open'
            );

            menu.setAttribute(
                'aria-hidden',
                'true'
            );

        }

        if(more){

            more.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    }


    function openMore(){

        if(menu){

            menu.classList.add(
                'is-open'
            );

            menu.setAttribute(
                'aria-hidden',
                'false'
            );

        }

        if(more){

            more.setAttribute(
                'aria-expanded',
                'true'
            );

        }

    }


    if(more){

        more.addEventListener(
            'click',
            function(e){

                e.preventDefault();
                e.stopPropagation();

                menu &&
                menu.classList.contains(
                    'is-open'
                )
                    ? closeMore()
                    : openMore();

            }
        );

    }


    document.addEventListener(
        'click',
        function(e){

            if(
                menu &&
                more &&
                !menu.contains(e.target) &&
                !more.contains(e.target)
            ){

                closeMore();

            }

        }
    );


    document.addEventListener(
        'keydown',
        function(e){

            if(e.key === 'Escape'){

                closeMore();

            }

        }
    );


    function openHub(){

        const trigger =
            document.querySelector(
                '[data-ai-hub-open]'
            );

        if(trigger){

            trigger.click();

        }

        closeMore();

    }


    function openRobot(){

        const trigger =
            document.querySelector(
                '[data-smart-ai-open]'
            );

        if(trigger){

            trigger.click();

        }

        closeMore();

    }


    if(aiHubBtn){

        aiHubBtn.addEventListener(
            'click',
            openHub
        );

    }


    if(smartAiBtn){

        smartAiBtn.addEventListener(
            'click',
            openRobot
        );

    }


    document
        .querySelectorAll(
            '[data-sb-more-aihub]'
        )
        .forEach(
            b =>
                b.addEventListener(
                    'click',
                    openHub
                )
        );


    document
        .querySelectorAll(
            '[data-sb-more-smart-ai]'
        )
        .forEach(
            b =>
                b.addEventListener(
                    'click',
                    openRobot
                )
        );


    function setTheme(theme){

        if(
            !['light','dark']
                .includes(theme)
        ) return;


        localStorage.setItem(
            'sb-theme',
            theme
        );


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


        window.SB_THEME=theme;


        try{

            window.dispatchEvent(
                new CustomEvent(
                    'sb-theme-changed',
                    {
                        detail:{
                            theme:theme
                        }
                    }
                )
            );

        }catch(e){}


        try{

            window.dispatchEvent(
                new CustomEvent(
                    'smartbasket-theme-changed',
                    {
                        detail:{
                            theme:theme
                        }
                    }
                )
            );

        }catch(e){}


        updateThemeButtons(theme);

    }


    function updateThemeButtons(theme){

        document
            .querySelectorAll(
                '[data-sb-set-theme]'
            )
            .forEach(
                function(btn){

                    btn.classList.toggle(
                        'is-selected',
                        btn.getAttribute(
                            'data-sb-set-theme'
                        ) === theme
                    );

                }
            );

    }


    document
        .querySelectorAll(
            '[data-sb-set-theme]'
        )
        .forEach(
            function(btn){

                btn.addEventListener(
                    'click',
                    function(){

                        setTheme(
                            btn.getAttribute(
                                'data-sb-set-theme'
                            )
                        );

                    }
                );

            }
        );


    updateThemeButtons(
        document.documentElement
            .getAttribute('data-theme')
        ||
        localStorage.getItem(
            'sb-theme'
        )
        ||
        'dark'
    );

})();

</script>


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

                welcomeOverlay.classList.add(
                    'is-hidden'
                );


                window.setTimeout(
                    function () {

                        if (welcomeOverlay) {

                            welcomeOverlay.remove();

                        }

                    },
                    700
                );

            },
            3000
        );

    }
);

</script>

@endif


</body>
</html>
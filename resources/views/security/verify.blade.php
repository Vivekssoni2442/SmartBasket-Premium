<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Security PIN - Smart Basket</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        /* =========================================================
           RESET
        ========================================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }


        /* =========================================================
           BODY
        ========================================================= */

        body {

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 18px;

            overflow: hidden;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: #ffffff;

            background:
                radial-gradient(
                    circle at 12% 18%,
                    rgba(123, 32, 170, .25),
                    transparent 31%
                ),
                radial-gradient(
                    circle at 88% 78%,
                    rgba(0, 128, 190, .20),
                    transparent 34%
                ),
                radial-gradient(
                    circle at 50% 50%,
                    rgba(255, 169, 0, .035),
                    transparent 35%
                ),
                #05070b;

            position: relative;
        }


        /* =========================================================
           BACKGROUND
        ========================================================= */

        .background {

            position: fixed;

            inset: 0;

            overflow: hidden;

            pointer-events: none;

            z-index: 0;
        }


        /* =========================================================
           GRADIENT LIGHTS
        ========================================================= */

        .light {

            position: absolute;

            border-radius: 50%;

            filter: blur(60px);

            opacity: .65;

            will-change: transform;
        }


        .light-1 {

            width: 430px;
            height: 430px;

            left: -180px;
            top: -170px;

            background:
                radial-gradient(
                    circle,
                    rgba(151, 28, 191, .30),
                    rgba(100, 20, 140, .10) 45%,
                    transparent 72%
                );

            animation:
                moveLight1 13s ease-in-out infinite;
        }


        .light-2 {

            width: 460px;
            height: 460px;

            right: -210px;
            bottom: -200px;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 125, 194, .26),
                    transparent 70%
                );

            animation:
                moveLight2 15s ease-in-out infinite;
        }


        .light-3 {

            width: 270px;
            height: 270px;

            left: 40%;
            top: -120px;

            background:
                radial-gradient(
                    circle,
                    rgba(255, 169, 0, .11),
                    transparent 70%
                );

            animation:
                moveLight3 10s ease-in-out infinite;
        }


        .light-4 {

            width: 220px;
            height: 220px;

            right: 8%;
            top: 45%;

            background:
                radial-gradient(
                    circle,
                    rgba(111, 40, 175, .18),
                    transparent 70%
                );

            animation:
                moveLight4 12s ease-in-out infinite;
        }


        @keyframes moveLight1 {

            0%,
            100% {
                transform:
                    translate3d(0, 0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate3d(150px, 100px, 0)
                    scale(1.15);
            }
        }


        @keyframes moveLight2 {

            0%,
            100% {
                transform:
                    translate3d(0, 0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate3d(-130px, -90px, 0)
                    scale(1.18);
            }
        }


        @keyframes moveLight3 {

            0%,
            100% {
                transform:
                    translate3d(0, 0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate3d(-100px, 170px, 0)
                    scale(1.25);
            }
        }


        @keyframes moveLight4 {

            0%,
            100% {
                transform:
                    translate3d(0, 0, 0);
            }

            50% {
                transform:
                    translate3d(-90px, -70px, 0);
            }
        }


        /* =========================================================
           MOVING NEON LINES
        ========================================================= */

        .neon-line {

            position: absolute;

            height: 2px;

            width: 650px;

            opacity: .18;

            filter: blur(.4px);

            transform-origin: left center;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #8d25bd,
                    #357cff,
                    transparent
                );
        }


        .neon-line-1 {

            top: 7%;
            left: -80px;

            transform: rotate(22deg);

            animation:
                lineMove1 9s ease-in-out infinite;
        }


        .neon-line-2 {

            right: -180px;
            bottom: 15%;

            transform: rotate(-27deg);

            animation:
                lineMove2 11s ease-in-out infinite;
        }


        .neon-line-3 {

            left: 30%;
            bottom: -80px;

            transform: rotate(-72deg);

            opacity: .09;

            animation:
                lineMove3 12s ease-in-out infinite;
        }


        @keyframes lineMove1 {

            0%,
            100% {
                opacity: .08;
                transform:
                    translateX(0)
                    rotate(22deg);
            }

            50% {
                opacity: .28;
                transform:
                    translateX(120px)
                    rotate(22deg);
            }
        }


        @keyframes lineMove2 {

            0%,
            100% {
                opacity: .08;
            }

            50% {
                opacity: .25;
                transform:
                    translateX(-100px)
                    rotate(-27deg);
            }
        }


        @keyframes lineMove3 {

            0%,
            100% {
                opacity: .05;
            }

            50% {
                opacity: .18;
            }
        }


        /* =========================================================
           STARS / PARTICLES
        ========================================================= */

        .stars {

            position: absolute;

            inset: 0;
        }


        .star {

            position: absolute;

            width: 3px;
            height: 3px;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:
                0 0 9px
                rgba(255,255,255,.9);

            animation:
                twinkle 4s ease-in-out infinite;
        }


        .star:nth-child(1) {
            left: 8%;
            top: 26%;
            animation-delay: -1s;
        }

        .star:nth-child(2) {
            left: 18%;
            top: 72%;
            animation-delay: -3s;
        }

        .star:nth-child(3) {
            left: 29%;
            top: 11%;
            animation-delay: -2s;
        }

        .star:nth-child(4) {
            left: 77%;
            top: 18%;
            animation-delay: -4s;
        }

        .star:nth-child(5) {
            left: 89%;
            top: 44%;
            animation-delay: -1.5s;
        }

        .star:nth-child(6) {
            left: 70%;
            top: 78%;
            animation-delay: -3.5s;
        }

        .star:nth-child(7) {
            left: 45%;
            top: 88%;
            animation-delay: -2.5s;
        }


        @keyframes twinkle {

            0%,
            100% {
                opacity: .18;
                transform: scale(.7);
            }

            50% {
                opacity: .95;
                transform: scale(1.35);
            }
        }


        /* =========================================================
           MAIN WRAPPER
        ========================================================= */

        .pin-wrapper {

            position: relative;

            z-index: 10;

            width: min(430px, 100%);

            animation:
                cardEnter .75s
                cubic-bezier(.16, 1, .3, 1)
                both;
        }


        @keyframes cardEnter {

            from {
                opacity: 0;

                transform:
                    translateY(35px)
                    scale(.94);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* =========================================================
           CARD
        ========================================================= */

        .pin-card {

            position: relative;

            width: 100%;

            padding:
                27px 36px 25px;

            border-radius: 27px;

            background: #1C181E;

            border:
                1px solid
                rgba(255,255,255,.10);

            box-shadow:

                0 35px 100px
                rgba(0,0,0,.72),

                0 0 0 1px
                rgba(255,255,255,.025),

                inset 0 1px 0
                rgba(255,255,255,.055);

            overflow: hidden;

            backdrop-filter: blur(22px);

            -webkit-backdrop-filter: blur(22px);
        }


        /* =========================================================
           CARD TOP LINE
        ========================================================= */

        .pin-card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 8%;
            right: 8%;

            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #FFA900,
                    #ffd166,
                    #FFA900,
                    transparent
                );

            box-shadow:
                0 0 18px
                rgba(255,169,0,.7);

            animation:
                topLine 3s ease-in-out infinite;
        }


        @keyframes topLine {

            0%,
            100% {
                opacity: .4;
            }

            50% {
                opacity: 1;
            }
        }


        /* =========================================================
           CARD GLOW
        ========================================================= */

        .card-glow {

            position: absolute;

            width: 220px;
            height: 220px;

            left: 50%;
            top: -155px;

            transform:
                translateX(-50%);

            background:
                radial-gradient(
                    circle,
                    rgba(255,169,0,.12),
                    transparent 70%
                );

            filter: blur(18px);

            pointer-events: none;
        }


        /* =========================================================
           BACK BUTTON
        ========================================================= */

        .back-button {

            position: relative;

            display: inline-flex;

            align-items: center;

            gap: 7px;

            height: 34px;

            padding:
                0 12px;

            border:
                1px solid
                rgba(255,255,255,.08);

            border-radius: 10px;

            background:
                rgba(255,255,255,.035);

            color:
                rgba(255,255,255,.62);

            text-decoration: none;

            font-size: 11px;

            font-weight: 700;

            transition:
                .25s ease;

            z-index: 3;
        }


        .back-button i {

            color: #FFA900;

            font-size: 10px;

            transition:
                transform .25s ease;
        }


        .back-button:hover {

            color: #ffffff;

            background:
                rgba(255,169,0,.08);

            border-color:
                rgba(255,169,0,.25);

            transform:
                translateX(-2px);
        }


        .back-button:hover i {

            transform:
                translateX(-3px);
        }


        /* =========================================================
           BRAND LOGO
        ========================================================= */

        .brand {

            display: flex;

            align-items: center;

            justify-content: center;

            margin-top: 3px;

            margin-bottom: 14px;
        }


        .brand-logo {

            width: 68px;
            height: 68px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 21px;

            background:
                linear-gradient(
                    145deg,
                    #ffbf26,
                    #FFA900
                );

            color: #ffffff;

            font-size: 31px;

            box-shadow:

                0 12px 30px
                rgba(255,169,0,.23),

                0 0 28px
                rgba(255,169,0,.12);

            animation:
                logoFloat 3.8s
                ease-in-out infinite;
        }


        .brand-logo i {

            filter:
                drop-shadow(
                    0 2px 2px
                    rgba(0,0,0,.12)
                );
        }


        @keyframes logoFloat {

            0%,
            100% {
                transform:
                    translateY(0)
                    rotate(0deg);
            }

            50% {
                transform:
                    translateY(-4px)
                    rotate(1deg);
            }
        }


        /* =========================================================
           BRAND NAME
        ========================================================= */

        .brand-name {

            text-align: center;

            font-size: 25px;

            line-height: 1;

            font-weight: 950;

            letter-spacing: 1.5px;

            margin-bottom: 6px;
        }


        .brand-name .smart {

            color: #ffffff;
        }


        .brand-name .basket {

            color: #FFA900;

            text-shadow:
                0 0 18px
                rgba(255,169,0,.18);
        }


        .brand-tagline {

            text-align: center;

            color:
                rgba(255,255,255,.43);

            font-size: 9px;

            font-weight: 600;

            letter-spacing: 1.7px;

            text-transform: uppercase;

            margin-bottom: 18px;
        }


        /* =========================================================
           DIVIDER
        ========================================================= */

        .divider {

            width: 100%;

            height: 1px;

            margin-bottom: 18px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.10),
                    transparent
                );
        }


        /* =========================================================
           SECURITY ICON
        ========================================================= */

        .security-icon {

            width: 54px;
            height: 54px;

            margin: 0 auto 11px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            background:
                rgba(255,169,0,.08);

            border:
                1px solid
                rgba(255,169,0,.18);

            color: #FFA900;

            font-size: 22px;

            box-shadow:
                0 0 28px
                rgba(255,169,0,.08);

            animation:
                securityPulse 3s ease-in-out infinite;
        }


        @keyframes securityPulse {

            0%,
            100% {
                box-shadow:
                    0 0 20px
                    rgba(255,169,0,.05);
            }

            50% {
                box-shadow:
                    0 0 32px
                    rgba(255,169,0,.16);
            }
        }


        /* =========================================================
           TITLE
        ========================================================= */

        .pin-title {

            text-align: center;

            color: #ffffff;

            font-size: 25px;

            line-height: 1.15;

            font-weight: 900;

            letter-spacing: -.4px;

            margin-bottom: 7px;
        }


        .pin-title span {

            color: #FFA900;
        }


        .pin-subtitle {

            max-width: 310px;

            margin:
                0 auto 19px;

            text-align: center;

            color:
                rgba(255,255,255,.48);

            font-size: 11px;

            line-height: 1.55;
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .security-error {

            display: flex;

            align-items: center;

            gap: 9px;

            padding:
                10px 12px;

            margin-bottom: 14px;

            border-radius: 11px;

            background:
                rgba(239,68,68,.08);

            border:
                1px solid
                rgba(239,68,68,.22);

            color: #ffb4b4;

            font-size: 11px;

            animation:
                errorShake .35s ease;
        }


        .security-error i {

            color: #ff6666;
        }


        @keyframes errorShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }


        /* =========================================================
           LABEL
        ========================================================= */

        .pin-label {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 7px;

            color: #ffffff;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: .8px;

            text-transform: uppercase;
        }


        .pin-label i {

            color: #FFA900;
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .pin-input-wrapper {

            position: relative;

            width: 100%;
        }


        .pin-input {

            width: 100%;

            height: 55px;

            padding:
                0 52px;

            border-radius: 14px;

            border:
                1px solid
                rgba(255,255,255,.09);

            outline: none;

            background:
                rgba(255,255,255,.055);

            color: #ffffff;

            font-size: 20px;

            font-weight: 800;

            letter-spacing: 9px;

            text-align: center;

            caret-color: #FFA900;

            transition:
                .25s ease;
        }


        /*
           PASSWORD TYPE = DOTS
        */

        .pin-input[type="password"] {

            -webkit-text-security: disc;

            text-security: disc;
        }


        .pin-input::placeholder {

            color:
                rgba(255,255,255,.25);

            font-size: 11px;

            font-weight: 500;

            letter-spacing: .5px;
        }


        .pin-input:focus {

            border-color:
                rgba(255,169,0,.60);

            background:
                rgba(255,169,0,.045);

            box-shadow:
                0 0 0 3px
                rgba(255,169,0,.07),

                0 10px 30px
                rgba(0,0,0,.20);
        }


        /* =========================================================
           LEFT INPUT ICON
        ========================================================= */

        .input-icon {

            position: absolute;

            left: 16px;
            top: 50%;

            transform:
                translateY(-50%);

            color: #FFA900;

            font-size: 14px;

            pointer-events: none;

            z-index: 2;
        }


        /* =========================================================
           EYE BUTTON
        ========================================================= */

        .toggle-pin {

            position: absolute;

            right: 10px;
            top: 50%;

            width: 35px;
            height: 35px;

            transform:
                translateY(-50%);

            display: flex;

            align-items: center;

            justify-content: center;

            border: 0;

            border-radius: 9px;

            background: transparent;

            color:
                rgba(255,255,255,.38);

            cursor: pointer;

            transition:
                .2s ease;

            z-index: 3;
        }


        .toggle-pin:hover {

            color: #FFA900;

            background:
                rgba(255,169,0,.08);
        }


        /* =========================================================
           HINT
        ========================================================= */

        .pin-hint {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            margin-top: 7px;

            color:
                rgba(255,255,255,.30);

            font-size: 9px;
        }


        .pin-hint i {

            color: #FFA900;

            font-size: 9px;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .unlock-button {

            position: relative;

            width: 100%;

            height: 52px;

            margin-top: 17px;

            border: 0;

            border-radius: 14px;

            background:
                linear-gradient(
                    110deg,
                    #FFA900,
                    #ffc02e,
                    #FFA900
                );

            background-size: 200% 100%;

            color: #171218;

            font-size: 13px;

            font-weight: 950;

            letter-spacing: .15px;

            cursor: pointer;

            overflow: hidden;

            box-shadow:
                0 12px 30px
                rgba(255,169,0,.20);

            transition:
                .25s ease;
        }


        .unlock-button:hover {

            transform:
                translateY(-2px);

            background-position:
                100% 0;

            box-shadow:
                0 17px 40px
                rgba(255,169,0,.34);
        }


        .unlock-button:active {

            transform:
                translateY(0)
                scale(.99);
        }


        .unlock-button::before {

            content: "";

            position: absolute;

            top: 0;
            left: -130%;

            width: 75%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.42),
                    transparent
                );

            transform:
                skewX(-22deg);

            transition:
                left .7s ease;
        }


        .unlock-button:hover::before {

            left: 145%;
        }


        .unlock-button i {

            margin-right: 7px;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .pin-footer {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            margin-top: 15px;

            color:
                rgba(255,255,255,.27);

            font-size: 8.5px;

            letter-spacing: .2px;
        }


        .pin-footer i {

            color: #FFA900;
        }


        /* =========================================================
           SECURE STATUS
        ========================================================= */

        .security-status {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            margin-top: 7px;

            color:
                rgba(255,255,255,.18);

            font-size: 7.5px;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        .status-dot {

            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: #FFA900;

            box-shadow:
                0 0 8px
                rgba(255,169,0,.8);

            animation:
                statusPulse 2s ease-in-out infinite;
        }


        @keyframes statusPulse {

            0%,
            100% {
                opacity: .35;
                transform: scale(.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.15);
            }
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 520px) {

            body {

                padding:
                    12px;

            }


            .pin-card {

                padding:
                    20px 21px 19px;

                border-radius: 23px;
            }


            .back-button {

                height: 31px;

                padding:
                    0 10px;

                font-size: 10px;
            }


            .brand-logo {

                width: 58px;
                height: 58px;

                border-radius: 18px;

                font-size: 27px;
            }


            .brand {

                margin-top: 0;

                margin-bottom: 10px;
            }


            .brand-name {

                font-size: 22px;
            }


            .brand-tagline {

                font-size: 7.5px;

                margin-bottom: 13px;
            }


            .divider {

                margin-bottom: 13px;
            }


            .security-icon {

                width: 48px;
                height: 48px;

                border-radius: 15px;

                font-size: 19px;

                margin-bottom: 9px;
            }


            .pin-title {

                font-size: 23px;

                margin-bottom: 5px;
            }


            .pin-subtitle {

                font-size: 10px;

                margin-bottom: 15px;
            }


            .pin-input {

                height: 52px;

                font-size: 18px;

                letter-spacing: 8px;
            }


            .unlock-button {

                height: 50px;

                margin-top: 15px;
            }


            .pin-footer {

                margin-top: 12px;
            }
        }


        /* =========================================================
           VERY SMALL SCREEN
        ========================================================= */

        @media (max-height: 650px) {

            body {
                padding: 8px;
            }


            .pin-card {

                padding:
                    15px 28px 14px;
            }


            .brand-logo {

                width: 48px;
                height: 48px;

                border-radius: 15px;

                font-size: 22px;
            }


            .brand {

                margin-bottom: 7px;
            }


            .brand-name {

                font-size: 20px;
            }


            .brand-tagline {

                margin-bottom: 8px;
            }


            .divider {

                margin-bottom: 9px;
            }


            .security-icon {

                width: 40px;
                height: 40px;

                font-size: 16px;

                margin-bottom: 6px;
            }


            .pin-title {

                font-size: 20px;
            }


            .pin-subtitle {

                margin-bottom: 10px;
            }


            .pin-input {

                height: 46px;
            }


            .unlock-button {

                height: 45px;

                margin-top: 11px;
            }


            .pin-footer {

                margin-top: 8px;
            }


            .security-status {

                margin-top: 4px;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

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

</head>


<body>


    <!-- =========================================================
         ANIMATED BACKGROUND
    ========================================================= -->

    <div class="background">

        <div class="light light-1"></div>

        <div class="light light-2"></div>

        <div class="light light-3"></div>

        <div class="light light-4"></div>


        <div class="neon-line neon-line-1"></div>

        <div class="neon-line neon-line-2"></div>

        <div class="neon-line neon-line-3"></div>


        <div class="stars">

            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>

        </div>

    </div>


    <!-- =========================================================
         MAIN
    ========================================================= -->

    <main class="pin-wrapper">

        <section class="pin-card">

            <div class="card-glow"></div>


            <!-- =================================================
                 BACK BUTTON
            ================================================= -->

            <a
                href="{{ url()->previous() }}"
                class="back-button"
            >

                <i class="fa-solid fa-arrow-left"></i>

                <span>Back</span>

            </a>


            <!-- =================================================
                 SMART BASKET LOGO
            ================================================= -->

            <div class="brand">

                <div class="brand-logo">

                    <i
                        class="fa-solid fa-cart-shopping"
                    ></i>

                </div>

            </div>


            <!-- =================================================
                 BRAND NAME
            ================================================= -->

            <div class="brand-name">

                <span class="smart">
                    SMART
                </span>

                <span class="basket">
                    BASKET
                </span>

            </div>


            <div class="brand-tagline">

                Premium Shopping Experience

            </div>


            <div class="divider"></div>


            <!-- =================================================
                 SECURITY ICON
            ================================================= -->

            <div class="security-icon">

                <i
                    class="fa-solid fa-shield-halved"
                ></i>

            </div>


            <!-- =================================================
                 TITLE
            ================================================= -->

            <h1 class="pin-title">

                Security <span>PIN</span>

            </h1>


            <p class="pin-subtitle">

                Enter your Security PIN to securely
                continue using Smart Basket.

            </p>


            <!-- =================================================
                 ERROR
            ================================================= -->

            @if(session('error'))

                <div class="security-error">

                    <i
                        class="fa-solid fa-circle-exclamation"
                    ></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <!-- =================================================
                 FORM
            ================================================= -->

            <form
                action="{{ route('security.verify') }}"
                method="POST"
            >

                @csrf


                <!-- LABEL -->

                <label
                    class="pin-label"
                    for="pin"
                >

                    <i class="fa-solid fa-key"></i>

                    Enter Security PIN

                </label>


                <!-- INPUT -->

                <div class="pin-input-wrapper">

                    <i
                        class="fa-solid fa-lock input-icon"
                    ></i>


                    <input
                        type="password"
                        id="pin"
                        name="pin"
                        class="pin-input"
                        maxlength="6"
                        minlength="4"
                        inputmode="numeric"
                        pattern="[0-9]{4,6}"
                        placeholder="Enter your PIN"
                        required
                        autocomplete="one-time-code"
                    >


                    <!-- SHOW / HIDE -->

                    <button
                        type="button"
                        class="toggle-pin"
                        id="togglePin"
                        aria-label="Show PIN"
                    >

                        <i
                            class="fa-solid fa-eye"
                        ></i>

                    </button>

                </div>


                <!-- HINT -->

                <div class="pin-hint">

                    <i
                        class="fa-solid fa-circle-info"
                    ></i>

                    4–6 digit PIN • Your PIN stays private

                </div>


                <!-- =================================================
                     UNLOCK
                ================================================= -->

                <button
                    type="submit"
                    class="unlock-button"
                >

                    <i
                        class="fa-solid fa-unlock-keyhole"
                    ></i>

                    Unlock Smart Basket

                </button>

            </form>


            <!-- =================================================
                 FOOTER
            ================================================= -->

            <div class="pin-footer">

                <i
                    class="fa-solid fa-shield-halved"
                ></i>

                Protected by Smart Basket Security

            </div>


            <!-- =================================================
                 STATUS
            ================================================= -->

            <div class="security-status">

                <span class="status-dot"></span>

                Secure Session

            </div>


        </section>

    </main>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================= -->

    <script>

        /* =====================================================
           PIN INPUT
        ===================================================== */

        const pinInput =
            document.getElementById('pin');


        if (pinInput) {

            pinInput.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value
                            .replace(/\D/g, '')
                            .slice(0, 6);

                }
            );

        }


        /* =====================================================
           SHOW / HIDE PIN
        ===================================================== */

        const togglePin =
            document.getElementById('togglePin');


        if (
            togglePin &&
            pinInput
        ) {

            togglePin.addEventListener(
                'click',
                function () {

                    const icon =
                        this.querySelector('i');


                    if (
                        pinInput.type ===
                        'password'
                    ) {

                        /* SHOW PIN */

                        pinInput.type =
                            'text';


                        icon.className =
                            'fa-solid fa-eye-slash';


                        this.setAttribute(
                            'aria-label',
                            'Hide PIN'
                        );

                    } else {

                        /* HIDE PIN AS DOTS */

                        pinInput.type =
                            'password';


                        icon.className =
                            'fa-solid fa-eye';


                        this.setAttribute(
                            'aria-label',
                            'Show PIN'
                        );

                    }


                    pinInput.focus();

                }
            );

        }


        /* =====================================================
           AUTO FOCUS
        ===================================================== */

        window.addEventListener(
            'load',
            function () {

                if (pinInput) {

                    setTimeout(
                        function () {

                            pinInput.focus();

                        },
                        500
                    );

                }

            }
        );


        /* =====================================================
           PREVENT NON-NUMERIC KEYS
        ===================================================== */

        if (pinInput) {

            pinInput.addEventListener(
                'keydown',
                function (event) {

                    const allowedKeys = [
                        'Backspace',
                        'Delete',
                        'ArrowLeft',
                        'ArrowRight',
                        'Tab',
                        'Home',
                        'End'
                    ];


                    if (
                        allowedKeys.includes(
                            event.key
                        )
                    ) {
                        return;
                    }


                    if (
                        !/^[0-9]$/.test(
                            event.key
                        )
                    ) {

                        event.preventDefault();

                    }

                }
            );

        }


        /* =====================================================
           FORM SUBMIT ANIMATION
        ===================================================== */

        const pinForm =
            document.querySelector('form');


        if (pinForm) {

            pinForm.addEventListener(
                'submit',
                function () {

                    const button =
                        this.querySelector(
                            '.unlock-button'
                        );


                    if (button) {

                        button.innerHTML =
                            '<i class="fa-solid fa-spinner fa-spin"></i> Verifying PIN...';

                        button.style.pointerEvents =
                            'none';

                        button.style.opacity =
                            '.85';

                    }

                }
            );

        }

    </script>


</body>

</html>
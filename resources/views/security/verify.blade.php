<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#071426">
    <title>Security PIN - Smart Basket</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* ======================================================
           SMART BASKET — PREMIUM BLUE SECURITY
        ====================================================== */

        :root {
            color-scheme: dark;
            --bg: #06101f;
            --panel: rgba(13, 27, 49, .88);
            --panel-border: rgba(143, 190, 255, .17);
            --blue: #3985ff;
            --blue-light: #72b7ff;
            --cyan: #52e3ff;
            --text: #f5f8ff;
            --muted: #93a6c4;
            --danger: #ff929e;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            min-height: 100%;
            background: var(--bg);
        }

        body {
            position: relative;
            isolation: isolate;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            overflow-x: hidden;
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(ellipse at 50% 0%, rgba(29, 94, 190, .17), transparent 46%),
                linear-gradient(145deg, #081426 0%, #050b16 54%, #09172a 100%);
        }

        button,
        input {
            font: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* ======================================================
           ANIMATED BACKGROUND
        ====================================================== */

        .background {
            position: fixed;
            inset: 0;
            z-index: -2;
            overflow: hidden;
            pointer-events: none;
        }

        .ambient {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            filter: blur(85px);
            opacity: .23;
            will-change: transform;
        }

        .ambient-one {
            top: -210px;
            left: -160px;
            background: #1769ff;
            animation: ambientOne 15s ease-in-out infinite alternate;
        }

        .ambient-two {
            right: -210px;
            bottom: -200px;
            background: #00c8ff;
            animation: ambientTwo 18s ease-in-out infinite alternate;
        }

        .ambient-three {
            width: 280px;
            height: 280px;
            left: 55%;
            top: 36%;
            background: #6748ff;
            opacity: .12;
            animation: ambientThree 13s ease-in-out infinite alternate;
        }

        @keyframes ambientOne {
            to { transform: translate3d(150px, 125px, 0) scale(1.18); }
        }

        @keyframes ambientTwo {
            to { transform: translate3d(-140px, -120px, 0) scale(1.15); }
        }

        @keyframes ambientThree {
            to { transform: translate3d(-100px, 80px, 0) scale(1.2); }
        }

        .grid-overlay {
            position: absolute;
            inset: 0;
            opacity: .19;
            background-image:
                linear-gradient(rgba(120, 171, 255, .055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(120, 171, 255, .055) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(to bottom, black, transparent 88%);
            -webkit-mask-image: linear-gradient(to bottom, black, transparent 88%);
        }

        .orbital {
            position: absolute;
            width: 570px;
            height: 570px;
            left: 50%;
            top: 50%;
            border: 1px solid rgba(99, 164, 255, .07);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: orbitalPulse 8s ease-in-out infinite;
        }

        .orbital::before,
        .orbital::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(99, 164, 255, .055);
            border-radius: 50%;
        }

        .orbital::before {
            inset: 45px;
        }

        .orbital::after {
            inset: 95px;
        }

        @keyframes orbitalPulse {
            0%, 100% { opacity: .42; transform: translate(-50%, -50%) scale(.97); }
            50% { opacity: .85; transform: translate(-50%, -50%) scale(1.03); }
        }

        .light-beam {
            position: absolute;
            width: 65vw;
            height: 1px;
            left: -10%;
            top: 26%;
            opacity: .25;
            transform: rotate(-27deg);
            transform-origin: left center;
            background: linear-gradient(90deg, transparent, #3284ff, #4fe5ff, transparent);
            box-shadow: 0 0 15px rgba(56, 145, 255, .24);
            animation: beamMove 12s ease-in-out infinite alternate;
        }

        .light-beam.beam-two {
            top: 78%;
            left: 45%;
            width: 55vw;
            opacity: .16;
            transform: rotate(-24deg);
            animation-delay: -5s;
        }

        @keyframes beamMove {
            to { opacity: .06; transform: translate3d(65px, 35px, 0) rotate(-20deg); }
        }

        .particles {
            position: absolute;
            inset: 0;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #9adfff;
            box-shadow: 0 0 12px rgba(82, 205, 255, .9);
            animation: particleFloat 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { left: 12%; top: 22%; animation-delay: -1s; }
        .particle:nth-child(2) { left: 22%; top: 78%; animation-delay: -3s; }
        .particle:nth-child(3) { left: 35%; top: 14%; animation-delay: -2s; }
        .particle:nth-child(4) { left: 82%; top: 20%; animation-delay: -4s; }
        .particle:nth-child(5) { left: 91%; top: 53%; animation-delay: -2.5s; }
        .particle:nth-child(6) { left: 72%; top: 84%; animation-delay: -1.5s; }
        .particle:nth-child(7) { left: 49%; top: 91%; animation-delay: -3.5s; }
        .particle:nth-child(8) { left: 7%; top: 57%; animation-delay: -.5s; }
        .particle:nth-child(9) { left: 64%; top: 11%; animation-delay: -2.2s; }
        .particle:nth-child(10) { left: 39%; top: 68%; animation-delay: -4.5s; }

        @keyframes particleFloat {
            0%, 100% { opacity: .15; transform: translateY(0) scale(.7); }
            50% { opacity: .9; transform: translateY(-13px) scale(1.35); }
        }

        /* ======================================================
           MAIN CARD
        ====================================================== */

        .pin-wrapper {
            position: relative;
            z-index: 1;
            width: min(100%, 425px);
            margin: auto;
            animation: cardEnter .8s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes cardEnter {
            from { opacity: 0; transform: translateY(24px) scale(.975); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .pin-card {
            position: relative;
            width: 100%;
            padding: 25px 34px 24px;
            overflow: hidden;
            border: 1px solid var(--panel-border);
            border-radius: 26px;
            background:
                linear-gradient(145deg, rgba(19, 38, 67, .96), rgba(8, 19, 36, .97));
            box-shadow:
                0 35px 100px rgba(0, 0, 0, .42),
                0 0 50px rgba(30, 100, 220, .075),
                inset 0 1px 0 rgba(255, 255, 255, .055);
            -webkit-backdrop-filter: blur(22px);
            backdrop-filter: blur(22px);
        }

        .pin-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 9%;
            right: 9%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--blue), var(--cyan), var(--blue), transparent);
            background-size: 200% 100%;
            animation: borderFlow 5s linear infinite;
        }

        .pin-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            top: -170px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50%;
            background: rgba(45, 126, 255, .16);
            filter: blur(45px);
            pointer-events: none;
        }

        @keyframes borderFlow {
            to { background-position: 200% 0; }
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        /* ======================================================
           BACK BUTTON
        ====================================================== */

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 35px;
            padding: 0 12px;
            border: 1px solid rgba(151, 191, 255, .14);
            border-radius: 10px;
            background: rgba(255, 255, 255, .035);
            color: #a8bddb;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            transition: background .22s ease, border-color .22s ease, color .22s ease, transform .22s ease;
        }

        .back-button i {
            color: var(--blue-light);
            font-size: 11px;
        }

        .back-button:hover {
            color: #fff;
            background: rgba(56, 130, 255, .12);
            border-color: rgba(91, 163, 255, .4);
            transform: translateX(-2px);
        }

        /* ======================================================
           BRAND
        ====================================================== */

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px 0 13px;
        }

        .brand-logo {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border: 1px solid rgba(150, 203, 255, .45);
            border-radius: 20px;
            background: linear-gradient(145deg, #4e9dff, #1556d9 78%);
            color: #fff;
            font-size: 27px;
            box-shadow:
                0 12px 28px rgba(20, 100, 240, .26),
                inset 0 1px 0 rgba(255, 255, 255, .28);
            animation: logoFloat 4s ease-in-out infinite;
        }

        .brand-logo::after {
            content: "";
            position: absolute;
            inset: -5px;
            border: 1px solid rgba(83, 184, 255, .19);
            border-radius: 24px;
            animation: logoRing 3.5s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        @keyframes logoRing {
            0%, 100% { opacity: .35; transform: scale(.98); }
            50% { opacity: .9; transform: scale(1.045); }
        }

        .brand-name {
            text-align: center;
            margin-bottom: 6px;
            font-size: 25px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .brand-name .smart {
            color: #f5f8ff;
        }

        .brand-name .basket {
            color: #65baff;
            text-shadow: 0 0 22px rgba(61, 155, 255, .25);
        }

        .brand-tagline {
            margin-bottom: 17px;
            color: #8097b8;
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .divider {
            height: 1px;
            margin-bottom: 19px;
            background: linear-gradient(90deg, transparent, rgba(153, 192, 245, .2), transparent);
        }

        /* ======================================================
           SECURITY ICON AND TITLE
           IMPORTANT: No separate hero/title card here.
        ====================================================== */

        .security-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            margin: 0 auto 12px;
            border: 1px solid rgba(88, 167, 255, .26);
            border-radius: 17px;
            background: linear-gradient(145deg, rgba(58, 132, 255, .17), rgba(35, 204, 255, .07));
            color: var(--blue-light);
            font-size: 22px;
            box-shadow: 0 0 28px rgba(37, 124, 255, .09), inset 0 1px 0 rgba(255, 255, 255, .06);
            animation: securityPulse 3.5s ease-in-out infinite;
        }

        @keyframes securityPulse {
            0%, 100% { box-shadow: 0 0 18px rgba(37, 124, 255, .06); }
            50% { box-shadow: 0 0 34px rgba(37, 124, 255, .2); }
        }

        .pin-title {
            margin-bottom: 8px;
            color: #f6f9ff;
            text-align: center;
            font-size: 27px;
            line-height: 1.2;
            font-weight: 900;
            letter-spacing: -.8px;
        }

        .pin-title span {
            color: #65baff;
            background: linear-gradient(90deg, #72baff, #56e0ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pin-subtitle {
            max-width: 310px;
            margin: 0 auto 21px;
            color: #92a6c4;
            text-align: center;
            font-size: 11px;
            line-height: 1.7;
        }

        /* ======================================================
           ERROR MESSAGE
        ====================================================== */

        .security-error {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 11px 12px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 105, 125, .24);
            border-radius: 12px;
            background: rgba(255, 83, 108, .075);
            color: var(--danger);
            font-size: 11px;
            line-height: 1.5;
            animation: errorEnter .3s ease both;
        }

        .security-error i {
            margin-top: 1px;
            color: #ff788d;
        }

        @keyframes errorEnter {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ======================================================
           FORM
        ====================================================== */

        .pin-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            color: #eaf2ff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .9px;
            text-transform: uppercase;
        }

        .pin-label i {
            color: var(--blue-light);
        }

        .pin-input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            z-index: 2;
            color: #78baff;
            font-size: 14px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .pin-input {
            display: block;
            width: 100%;
            height: 56px;
            padding: 0 52px;
            border: 1px solid rgba(148, 183, 233, .18);
            border-radius: 14px;
            outline: none;
            background: rgba(3, 12, 26, .57);
            color: #f5f9ff;
            caret-color: var(--cyan);
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 9px;
            transition: border-color .22s ease, background .22s ease, box-shadow .22s ease;
        }

        .pin-input[type="password"] {
            -webkit-text-security: disc;
        }

        .pin-input::placeholder {
            color: #6f819e;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .4px;
        }

        .pin-input:hover {
            border-color: rgba(105, 169, 255, .36);
        }

        .pin-input:focus {
            border-color: rgba(77, 157, 255, .8);
            background: rgba(15, 42, 78, .58);
            box-shadow: 0 0 0 3px rgba(54, 132, 255, .12), 0 8px 24px rgba(0, 0, 0, .15);
        }

        .toggle-pin {
            position: absolute;
            top: 50%;
            right: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #7e91af;
            cursor: pointer;
            transform: translateY(-50%);
            transition: color .2s ease, background .2s ease;
        }

        .toggle-pin:hover {
            color: #8ac8ff;
            background: rgba(57, 133, 255, .12);
        }

        .toggle-pin:focus-visible,
        .unlock-button:focus-visible,
        .back-button:focus-visible {
            outline: 2px solid var(--cyan);
            outline-offset: 3px;
        }

        .pin-hint {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 9px;
            color: #7588a6;
            font-size: 9px;
            line-height: 1.5;
        }

        .pin-hint i {
            color: #69b7ff;
        }

        /* ======================================================
           UNLOCK BUTTON
        ====================================================== */

        .unlock-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 53px;
            margin-top: 19px;
            padding: 0 16px;
            overflow: hidden;
            border: 1px solid rgba(160, 210, 255, .25);
            border-radius: 14px;
            background: linear-gradient(105deg, #1764e8, #348bff 52%, #28bce9);
            background-size: 180% 100%;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .1px;
            cursor: pointer;
            box-shadow: 0 12px 28px rgba(24, 105, 238, .24), inset 0 1px 0 rgba(255, 255, 255, .2);
            transition: transform .22s ease, box-shadow .22s ease, background-position .35s ease, opacity .22s ease;
        }

        .unlock-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 65%;
            height: 100%;
            transform: skewX(-22deg);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
            transition: left .7s ease;
            pointer-events: none;
        }

        .unlock-button:hover {
            transform: translateY(-2px);
            background-position: 100% 0;
            box-shadow: 0 17px 36px rgba(24, 105, 238, .34), inset 0 1px 0 rgba(255, 255, 255, .22);
        }

        .unlock-button:hover::before {
            left: 150%;
        }

        .unlock-button:active {
            transform: translateY(0) scale(.99);
        }

        .unlock-button:disabled {
            cursor: wait;
            opacity: .78;
            transform: none;
        }

        /* ======================================================
           FOOTER
        ====================================================== */

        .pin-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 17px;
            color: #7084a3;
            text-align: center;
            font-size: 9px;
            line-height: 1.5;
        }

        .pin-footer i {
            color: #70b9ff;
        }

        .security-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 9px;
            color: #536985;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            flex: 0 0 6px;
            border-radius: 50%;
            background: #4bd9b1;
            box-shadow: 0 0 10px rgba(75, 217, 177, .6);
            animation: statusPulse 2.2s ease-in-out infinite;
        }

        @keyframes statusPulse {
            0%, 100% { opacity: .55; transform: scale(.85); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        /* ======================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 480px) {
            body {
                padding: 16px 12px;
            }

            .pin-wrapper {
                width: min(100%, 390px);
            }

            .pin-card {
                padding: 21px 22px 20px;
                border-radius: 23px;
            }

            .brand-logo {
                width: 58px;
                height: 58px;
                border-radius: 18px;
                font-size: 24px;
            }

            .brand-name {
                font-size: 23px;
            }

            .brand-tagline {
                margin-bottom: 14px;
                font-size: 8px;
            }

            .divider {
                margin-bottom: 16px;
            }

            .security-icon {
                width: 49px;
                height: 49px;
                margin-bottom: 10px;
                border-radius: 15px;
                font-size: 20px;
            }

            .pin-title {
                font-size: 25px;
            }

            .pin-subtitle {
                margin-bottom: 18px;
                font-size: 10px;
            }

            .pin-input {
                height: 53px;
                font-size: 18px;
                letter-spacing: 8px;
            }

            .unlock-button {
                min-height: 51px;
                margin-top: 17px;
            }
        }

        @media (max-height: 720px) and (min-width: 481px) {
            body {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .pin-card {
                padding-top: 17px;
                padding-bottom: 16px;
            }

            .brand {
                margin-top: 0;
                margin-bottom: 8px;
            }

            .brand-logo {
                width: 49px;
                height: 49px;
                border-radius: 15px;
                font-size: 21px;
            }

            .brand-name {
                font-size: 22px;
            }

            .brand-tagline {
                margin-bottom: 11px;
            }

            .divider {
                margin-bottom: 12px;
            }

            .security-icon {
                width: 43px;
                height: 43px;
                margin-bottom: 8px;
                font-size: 18px;
            }

            .pin-title {
                font-size: 23px;
            }

            .pin-subtitle {
                margin-bottom: 13px;
            }

            .pin-input {
                height: 49px;
            }

            .unlock-button {
                min-height: 47px;
                margin-top: 13px;
            }

            .pin-footer {
                margin-top: 11px;
            }
        }

        @media (max-width: 360px) {
            .pin-card {
                padding: 18px 16px;
            }

            .brand-name {
                font-size: 21px;
            }

            .pin-title {
                font-size: 23px;
            }

            .pin-input {
                padding-left: 43px;
                padding-right: 43px;
                letter-spacing: 7px;
            }
        }

            </style>
</head>

<body>
    <!-- Animated background -->
    <div class="background" aria-hidden="true">
        <div class="ambient ambient-one"></div>
        <div class="ambient ambient-two"></div>
        <div class="ambient ambient-three"></div>
        <div class="grid-overlay"></div>
        <div class="orbital"></div>
        <div class="light-beam"></div>
        <div class="light-beam beam-two"></div>

        <div class="particles">
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
            <span class="particle"></span>
        </div>
    </div>

    <main class="pin-wrapper">
        <section class="pin-card" aria-labelledby="securityPinTitle">
            <div class="card-content">

                <a href="{{ url()->previous() }}" class="back-button">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <span>Back</span>
                </a>

                <div class="brand" aria-label="Smart Basket">
                    <div class="brand-logo">
                        <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="brand-name">
                    <span class="smart">SMART</span>
                    <span class="basket">BASKET</span>
                </div>

                <div class="brand-tagline">Premium Shopping Experience</div>

                <div class="divider"></div>

                <div class="security-icon" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <!-- Title is directly inside the main card: no extra hero/title card -->
                <h1 class="pin-title" id="securityPinTitle">
                    Security <span>PIN</span>
                </h1>

                <p class="pin-subtitle">
                    Enter your Security PIN to securely continue using Smart Basket.
                </p>

                @if(session('error'))
                    <div class="security-error" role="alert">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('security.verify') }}" method="POST" id="securityPinForm">
                    @csrf

                    <label class="pin-label" for="pin">
                        <i class="fa-solid fa-key" aria-hidden="true"></i>
                        Enter Security PIN
                    </label>

                    <div class="pin-input-wrapper">
                        <i class="fa-solid fa-lock input-icon" aria-hidden="true"></i>

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
                            aria-describedby="pinHint"
                        >

                        <button
                            type="button"
                            class="toggle-pin"
                            id="togglePin"
                            aria-label="Show PIN"
                            aria-controls="pin"
                            aria-pressed="false"
                        >
                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="pin-hint" id="pinHint">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        <span>4–6 digit PIN · Your PIN stays private</span>
                    </div>

                    <button type="submit" class="unlock-button" id="unlockButton">
                        <i class="fa-solid fa-unlock-keyhole" aria-hidden="true"></i>
                        <span>Unlock Smart Basket</span>
                    </button>
                </form>

                <div class="pin-footer">
                    <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                    <span>Protected by Smart Basket Security</span>
                </div>

                <div class="security-status">
                    <span class="status-dot" aria-hidden="true"></span>
                    <span>Secure Session</span>
                </div>
            </div>
        </section>
    </main>

    <script>
        (() => {
            'use strict';

            const pinInput = document.getElementById('pin');
            const togglePin = document.getElementById('togglePin');
            const pinForm = document.getElementById('securityPinForm');
            const unlockButton = document.getElementById('unlockButton');

            if (pinInput) {
                // Keep the input numeric and limit it to six digits.
                pinInput.addEventListener('input', function () {
                    const cleaned = this.value.replace(/\D/g, '').slice(0, 6);

                    if (this.value !== cleaned) {
                        this.value = cleaned;
                    }
                });
            }

            if (togglePin && pinInput) {
                togglePin.addEventListener('click', function () {
                    const showing = pinInput.type === 'password';
                    const icon = this.querySelector('i');

                    pinInput.type = showing ? 'text' : 'password';

                    if (icon) {
                        icon.className = showing
                            ? 'fa-solid fa-eye-slash'
                            : 'fa-solid fa-eye';
                    }

                    this.setAttribute('aria-label', showing ? 'Hide PIN' : 'Show PIN');
                    this.setAttribute('aria-pressed', showing ? 'true' : 'false');

                    pinInput.focus();
                });
            }

            // Focus only on devices where doing so is unlikely to summon
            // an unwanted mobile keyboard.
            window.addEventListener('load', () => {
                if (
                    pinInput &&
                    window.matchMedia('(pointer: fine)').matches
                ) {
                    window.setTimeout(() => pinInput.focus(), 350);
                }
            });

            if (pinForm && unlockButton) {
                pinForm.addEventListener('submit', function (event) {
                    // Keep browser validation active before changing button state.
                    if (!pinForm.checkValidity()) {
                        return;
                    }

                    if (unlockButton.disabled) {
                        event.preventDefault();
                        return;
                    }

                    unlockButton.disabled = true;
                    unlockButton.setAttribute('aria-busy', 'true');
                    unlockButton.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>' +
                        '<span>Verifying PIN...</span>';
                });
            }
        })();
    </script>

    @include('customer.partials.smart-ai-robot')
</body>
</html>

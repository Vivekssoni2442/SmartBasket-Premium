<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07111f">


<title>Admin Login | SmartBasket Premium</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<style>
    /* =====================================================
       SMART BASKET — PREMIUM ADMIN LOGIN
       Midnight Navy / Electric Blue / Cyan / Silver
       Standalone Blade page — authentication preserved
    ===================================================== */

    :root {
        color-scheme: dark;

        --blue: #3b82f6;
        --blue-bright: #60a5fa;
        --blue-deep: #1d4ed8;
        --cyan: #22d3ee;
        --purple: #8b5cf6;
        --pink: #ec4899;

        --bg: #050b16;
        --panel: rgba(13, 24, 43, .88);
        --text: #f8fafc;
        --muted: #91a4c0;
        --border: rgba(148, 177, 218, .19);

        --radius: 25px;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    html {
        min-height: 100%;
        scroll-behavior: smooth;
    }

    body {
        position: relative;
        isolation: isolate;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 35px 20px;
        overflow-x: hidden;
        color: var(--text);
        background:
            radial-gradient(ellipse at 50% -15%, rgba(37, 99, 235, .22), transparent 45%),
            linear-gradient(145deg, #07111f 0%, #030711 52%, #0a1427 100%);
    }

    /* Background ambient lighting */
    body::before,
    body::after {
        position: fixed;
        z-index: -2;
        width: 540px;
        height: 540px;
        content: "";
        pointer-events: none;
        border-radius: 50%;
        filter: blur(105px);
        animation: ambientFloat 12s ease-in-out infinite alternate;
    }

    body::before {
        top: -280px;
        left: -180px;
        background: conic-gradient(
            from 30deg,
            #2563eb,
            #22d3ee,
            #8b5cf6,
            #2563eb
        );
        opacity: .22;
    }

    body::after {
        right: -220px;
        bottom: -310px;
        background: conic-gradient(
            from 180deg,
            #1d4ed8,
            #22d3ee,
            #ec4899,
            #1d4ed8
        );
        opacity: .16;
        animation-delay: -5s;
    }

    @keyframes ambientFloat {
        from {
            transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
        }
        to {
            transform: translate3d(45px, 35px, 0) rotate(180deg) scale(1.14);
        }
    }

    /* Subtle perspective grid */
    .rgb-grid {
        position: fixed;
        z-index: -1;
        inset: -100px;
        pointer-events: none;
        opacity: .16;
        background-image:
            linear-gradient(rgba(147, 197, 253, .12) 1px, transparent 1px),
            linear-gradient(90deg, rgba(147, 197, 253, .12) 1px, transparent 1px);
        background-size: 55px 55px;
        transform: perspective(550px) rotateX(62deg) scale(1.5);
        transform-origin: center bottom;
        animation: gridMove 15s linear infinite;
    }

    @keyframes gridMove {
        to {
            background-position: 0 55px, 55px 0;
        }
    }

    /* Animated light beams */
    .rgb-beam {
        position: fixed;
        z-index: -1;
        top: -15%;
        width: 2px;
        height: 130%;
        opacity: 0;
        pointer-events: none;
        filter: blur(1px);
        transform: rotate(25deg);
    }

    .rgb-beam.one {
        left: 15%;
        background: linear-gradient(transparent, #3b82f6, transparent);
        animation: beamMove 10s linear infinite;
    }

    .rgb-beam.two {
        left: 48%;
        background: linear-gradient(transparent, #22d3ee, transparent);
        animation: beamMove 12s linear infinite -4s;
    }

    .rgb-beam.three {
        left: 80%;
        background: linear-gradient(transparent, #8b5cf6, transparent);
        animation: beamMove 11s linear infinite -7s;
    }

    @keyframes beamMove {
        0% {
            transform: translateX(-400px) rotate(25deg);
            opacity: 0;
        }
        30%, 70% {
            opacity: .36;
        }
        100% {
            transform: translateX(500px) rotate(25deg);
            opacity: 0;
        }
    }

    /* Floating light particles */
    .rgb-particles {
        position: fixed;
        z-index: -1;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .rgb-particles span {
        position: absolute;
        width: 3px;
        height: 3px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 9px #fff, 0 0 20px #3b82f6;
        opacity: 0;
        animation: particleFloat linear infinite;
    }

    .rgb-particles span:nth-child(1)  { left: 8%;  top: 80%; animation-duration: 13s; }
    .rgb-particles span:nth-child(2)  { left: 18%; top: 40%; animation-duration: 17s; }
    .rgb-particles span:nth-child(3)  { left: 28%; top: 75%; animation-duration: 11s; }
    .rgb-particles span:nth-child(4)  { left: 39%; top: 25%; animation-duration: 15s; }
    .rgb-particles span:nth-child(5)  { left: 52%; top: 85%; animation-duration: 14s; }
    .rgb-particles span:nth-child(6)  { left: 63%; top: 30%; animation-duration: 18s; }
    .rgb-particles span:nth-child(7)  { left: 72%; top: 70%; animation-duration: 12s; }
    .rgb-particles span:nth-child(8)  { left: 82%; top: 25%; animation-duration: 16s; }
    .rgb-particles span:nth-child(9)  { left: 91%; top: 60%; animation-duration: 13s; }
    .rgb-particles span:nth-child(10) { left: 48%; top: 55%; animation-duration: 19s; }

    @keyframes particleFloat {
        0% {
            transform: translate(0, 70px) scale(.4);
            opacity: 0;
        }
        25% {
            opacity: .7;
        }
        65% {
            transform: translate(30px, -160px) scale(1);
            opacity: .65;
        }
        100% {
            transform: translate(-30px, -350px) scale(.2);
            opacity: 0;
        }
    }

    /* Large orbital rings */
    .energy-ring {
        position: fixed;
        z-index: -1;
        top: 50%;
        left: 50%;
        width: min(720px, 95vw);
        aspect-ratio: 1;
        pointer-events: none;
        border: 1px solid rgba(59, 130, 246, .12);
        border-radius: 50%;
        box-shadow:
            0 0 80px rgba(37, 99, 235, .05),
            inset 0 0 80px rgba(34, 211, 238, .035);
        transform: translate(-50%, -50%);
        animation: ringRotate 35s linear infinite;
    }

    .energy-ring::before,
    .energy-ring::after {
        position: absolute;
        content: "";
        border-radius: 50%;
    }

    .energy-ring::before {
        inset: 55px;
        border: 1px solid rgba(34, 211, 238, .1);
    }

    .energy-ring::after {
        inset: 125px;
        border: 1px solid rgba(139, 92, 246, .09);
    }

    @keyframes ringRotate {
        to { rotate: 360deg; }
    }

    /* Main layout */
    .shell {
        position: relative;
        z-index: 2;
        width: min(100%, 465px);
        margin: auto;
        animation: shellEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes shellEnter {
        from {
            opacity: 0;
            transform: translateY(32px) scale(.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Brand */
    .brand {
        margin-bottom: 27px;
        text-align: center;
        animation: brandEnter .8s ease .1s both;
    }

    @keyframes brandEnter {
        from {
            opacity: 0;
            transform: translateY(-18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .crown-wrapper {
        position: relative;
        display: grid;
        width: 88px;
        height: 88px;
        margin: 0 auto 15px;
        place-items: center;
        isolation: isolate;
    }

    .crown-glow {
        position: absolute;
        z-index: -1;
        inset: 2px;
        background: conic-gradient(
            from 0deg,
            #2563eb,
            #22d3ee,
            #8b5cf6,
            #60a5fa,
            #2563eb
        );
        border-radius: 27px;
        filter: blur(17px);
        opacity: .7;
        animation: crownGlow 6s linear infinite;
    }

    @keyframes crownGlow {
        50% {
            transform: rotate(180deg) scale(1.1);
            opacity: .95;
        }
    }

    .crown {
        position: relative;
        display: grid;
        width: 68px;
        height: 68px;
        color: #fff;
        place-items: center;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 22px;
        background: linear-gradient(145deg, #60a5fa, #2563eb 58%, #1e40af);
        box-shadow:
            inset 0 1px 1px rgba(255, 255, 255, .4),
            0 12px 35px rgba(37, 99, 235, .36);
    }

    .crown i {
        font-size: 29px;
        filter: drop-shadow(0 3px 5px rgba(0, 0, 0, .22));
        animation: crownFloat 3.5s ease-in-out infinite;
    }

    @keyframes crownFloat {
        50% {
            transform: translateY(-3px) rotate(-3deg);
        }
    }

    .brand h1 {
        color: #f8fafc;
        font-size: clamp(24px, 5vw, 29px);
        font-weight: 800;
        letter-spacing: 2px;
        text-shadow: 0 0 25px rgba(96, 165, 250, .12);
    }

    .brand h1 span {
        color: #60a5fa;
    }

    .brand p {
        margin-top: 7px;
        color: #91a9cc;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .32em;
    }

    /* Login card */
    .card {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 34px;
        border: 1px solid transparent;
        border-radius: var(--radius);
        background:
            linear-gradient(145deg, rgba(15, 28, 49, .97), rgba(7, 15, 29, .98)) padding-box,
            linear-gradient(
                125deg,
                rgba(96, 165, 250, .7),
                rgba(34, 211, 238, .23),
                rgba(139, 92, 246, .6),
                rgba(96, 165, 250, .7)
            ) border-box;
        background-size: auto, 300% 300%;
        box-shadow:
            0 32px 90px rgba(0, 0, 0, .42),
            0 0 60px rgba(37, 99, 235, .09),
            inset 0 1px 0 rgba(255, 255, 255, .055);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        animation: borderFlow 9s ease infinite, cardEnter .85s ease .1s both;
    }

    @keyframes borderFlow {
        0%, 100% { background-position: 0 0, 0% 50%; }
        50% { background-position: 0 0, 100% 50%; }
    }

    @keyframes cardEnter {
        from {
            opacity: 0;
            transform: translateY(20px) scale(.985);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .card::before {
        position: absolute;
        z-index: -1;
        top: -90px;
        left: 50%;
        width: 260px;
        height: 130px;
        content: "";
        pointer-events: none;
        background: #2563eb;
        filter: blur(80px);
        opacity: .17;
        transform: translateX(-50%);
    }

    .card::after {
        position: absolute;
        z-index: -1;
        right: -100px;
        bottom: -150px;
        width: 230px;
        height: 230px;
        content: "";
        pointer-events: none;
        background: #22d3ee;
        filter: blur(100px);
        opacity: .06;
    }

    .intro {
        position: relative;
        z-index: 1;
    }

    .intro h2 {
        color: #f8fafc;
        font-size: 21px;
        font-weight: 700;
        letter-spacing: -.4px;
    }

    .intro h2::after {
        display: block;
        width: 49px;
        height: 3px;
        margin-top: 10px;
        content: "";
        border-radius: 20px;
        background: linear-gradient(90deg, #60a5fa, #22d3ee);
        box-shadow: 0 0 15px rgba(34, 211, 238, .22);
    }

    .intro p {
        margin: 12px 0 24px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.8;
    }

    /* Alerts */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 13px 14px;
        margin-bottom: 18px;
        border: 1px solid;
        border-radius: 12px;
        font-size: 12px;
        line-height: 1.65;
        overflow-wrap: anywhere;
        animation: alertEnter .35s ease both;
    }

    .alert i {
        margin-top: 3px;
    }

    .alert.error {
        color: #fecdd3;
        background: rgba(244, 63, 94, .09);
        border-color: rgba(251, 113, 133, .28);
    }

    .alert.success {
        color: #bbf7d0;
        background: rgba(16, 185, 129, .09);
        border-color: rgba(52, 211, 153, .27);
    }

    @keyframes alertEnter {
        from {
            opacity: 0;
            transform: translateY(-7px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form */
    form {
        position: relative;
        z-index: 1;
    }

    label {
        display: block;
        margin: 17px 0 9px;
        color: #dbeafe;
        font-size: 11px;
        font-weight: 600;
    }

    .field {
        position: relative;
    }

    .field > i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 15px;
        color: #60a5fa;
        font-size: 13px;
        pointer-events: none;
        transform: translateY(-50%);
        transition: color .25s ease, text-shadow .25s ease;
    }

    .field input {
        display: block;
        width: 100%;
        height: 52px;
        padding: 0 45px;
        color: #f8fafc;
        background: rgba(4, 11, 24, .76);
        border: 1px solid #2a3b56;
        border-radius: 12px;
        outline: none;
        font: 400 12px 'Poppins', sans-serif;
        box-shadow: inset 0 1px 7px rgba(0, 0, 0, .12);
        transition:
            border-color .25s ease,
            background .25s ease,
            box-shadow .25s ease;
    }

    .field input::placeholder {
        color: #71839f;
        opacity: 1;
    }

    .field input:hover {
        border-color: #46658f;
    }

    .field input:focus {
        background: rgba(8, 20, 40, .96);
        border-color: #60a5fa;
        box-shadow:
            0 0 0 3px rgba(59, 130, 246, .15),
            0 0 22px rgba(59, 130, 246, .08);
    }

    .field:focus-within > i {
        color: #22d3ee;
        text-shadow: 0 0 12px rgba(34, 211, 238, .35);
    }

    /* Password visibility toggle */
    .toggle {
        position: absolute;
        top: 7px;
        right: 7px;
        display: grid;
        width: 38px;
        height: 38px;
        color: #91a4c0;
        place-items: center;
        background: rgba(148, 163, 184, .06);
        border: 1px solid transparent;
        border-radius: 9px;
        cursor: pointer;
        transition: color .2s ease, background .2s ease, border-color .2s ease;
    }

    .toggle:hover {
        color: #67e8f9;
        background: rgba(34, 211, 238, .09);
        border-color: rgba(34, 211, 238, .18);
    }

    .toggle:focus-visible {
        outline: 2px solid #22d3ee;
        outline-offset: 2px;
    }

    /* Submit button */
    .submit {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        min-height: 53px;
        margin-top: 25px;
        padding: 12px 18px;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(115deg, #3b82f6 0%, #2563eb 48%, #1d4ed8 100%);
        border: 1px solid rgba(147, 197, 253, .38);
        border-radius: 12px;
        box-shadow:
            0 10px 27px rgba(37, 99, 235, .24),
            inset 0 1px 0 rgba(255, 255, 255, .19);
        font: 700 12px 'Poppins', sans-serif;
        letter-spacing: .035em;
        cursor: pointer;
        transition: transform .22s ease, box-shadow .22s ease, filter .22s ease;
    }

    .submit::before {
        position: absolute;
        top: 0;
        left: -130%;
        width: 70%;
        height: 100%;
        content: "";
        pointer-events: none;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
        transform: skewX(-22deg);
        animation: buttonShine 5s ease-in-out infinite;
    }

    @keyframes buttonShine {
        0%, 65% { left: -130%; }
        85%, 100% { left: 150%; }
    }

    .submit:hover {
        filter: brightness(1.09);
        transform: translateY(-2px);
        box-shadow:
            0 15px 34px rgba(37, 99, 235, .3),
            0 0 24px rgba(34, 211, 238, .07);
    }

    .submit:active {
        transform: translateY(0) scale(.99);
    }

    .submit:disabled {
        opacity: .72;
        cursor: wait;
        transform: none;
    }

    .submit i {
        position: relative;
        z-index: 1;
    }

    /* Back link */
    .back {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: fit-content;
        max-width: 100%;
        margin: 22px auto 0;
        color: #9aacc7;
        font-size: 11px;
        text-decoration: none;
        transition: color .2s ease;
    }

    .back:hover {
        color: #67e8f9;
    }

    .back i {
        font-size: 10px;
        transition: transform .2s ease;
    }

    .back:hover i {
        transform: translateX(-3px);
    }

    /* Security notice */
    .notice {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 21px;
        color: #7d91af;
        font-size: 10px;
        text-align: center;
        animation: noticePulse 5s ease-in-out infinite;
    }

    .notice i {
        color: #60a5fa;
        font-size: 10px;
    }

    @keyframes noticePulse {
        50% { opacity: .7; }
    }

    /* Keyboard accessibility */
    :focus-visible {
        outline: 2px solid #22d3ee;
        outline-offset: 3px;
    }

    /* Responsive */
    @media (max-width: 520px) {
        body {
            align-items: flex-start;
            padding: 25px 14px;
        }

        .shell {
            margin: auto;
        }

        .brand {
            margin-bottom: 22px;
        }

        .crown-wrapper {
            width: 77px;
            height: 77px;
        }

        .crown {
            width: 61px;
            height: 61px;
            border-radius: 19px;
        }

        .card {
            padding: 26px 21px;
            border-radius: 21px;
        }

        .intro h2 {
            font-size: 19px;
        }

        .energy-ring {
            width: 460px;
        }

        .brand p {
            font-size: 9px;
            letter-spacing: .25em;
        }
    }

    @media (max-height: 700px) and (min-width: 521px) {
        body {
            align-items: flex-start;
        }

        .shell {
            margin: auto;
        }

        .brand {
            margin-bottom: 17px;
        }

        .crown-wrapper {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }

        .crown {
            width: 57px;
            height: 57px;
        }

        .card {
            padding: 26px 30px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            scroll-behavior: auto !important;
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>


</head>

<body class="admin-login">


<!-- Premium animated background -->
<div class="rgb-grid" aria-hidden="true"></div>

<div class="rgb-beam one" aria-hidden="true"></div>
<div class="rgb-beam two" aria-hidden="true"></div>
<div class="rgb-beam three" aria-hidden="true"></div>

<div class="rgb-particles" aria-hidden="true">
    <span></span><span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="energy-ring" aria-hidden="true"></div>

<!-- Main login section -->
<main class="shell">

    <!-- Smart Basket branding -->
    <header class="brand">
        <div class="crown-wrapper" aria-hidden="true">
            <div class="crown-glow"></div>
            <div class="crown">
                <i class="fas fa-crown"></i>
            </div>
        </div>

        <h1>SMART<span>BASKET</span></h1>
        <p>ADMIN CONTROL CENTER</p>
    </header>

    <!-- Login card -->
    <section class="card" aria-labelledby="login-title">

        <div class="intro">
            <h2 id="login-title">Secure administrator sign in</h2>
            <p>
                Use your dedicated administrator account.
                MFA is requested when enabled.
            </p>
        </div>

        <!-- Existing error message -->
        @if(session('error'))
            <div class="alert error" role="alert">
                <i class="fas fa-circle-exclamation" aria-hidden="true"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Existing success message -->
        @if(session('success'))
            <div class="alert success" role="status">
                <i class="fas fa-circle-check" aria-hidden="true"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Existing authentication form and route preserved -->
        <form
            method="POST"
            action="{{ route('admin.login.submit') }}"
            id="adminLoginForm"
        >
            @csrf

            <!-- Administrator email -->
            <label for="email">Administrator email</label>

            <div class="field">
                <i class="fas fa-envelope" aria-hidden="true"></i>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    placeholder="Enter administrator email"
                    required
                    autofocus
                    aria-describedby="email-error"
                >
            </div>

            @error('email')
                <small
                    id="email-error"
                    style="display:block;color:#fda4af;margin-top:7px;font-size:11px;"
                >{{ $message }}</small>
            @enderror

            <!-- Administrator password -->
            <label for="password">Password</label>

            <div class="field">
                <i class="fas fa-lock" aria-hidden="true"></i>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Enter administrator password"
                    required
                >

                <button
                    class="toggle"
                    type="button"
                    aria-label="Show password"
                    aria-pressed="false"
                    id="passwordToggle"
                >
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
            </div>

            @error('password')
                <small
                    style="display:block;color:#fda4af;margin-top:7px;font-size:11px;"
                >{{ $message }}</small>
            @enderror

            <!-- Login button -->
            <button
                class="submit"
                type="submit"
                id="loginButton"
            >
                <i class="fas fa-shield-halved" aria-hidden="true"></i>
                <span>Secure Admin Login</span>
            </button>
        </form>

        <!-- Existing home link preserved -->
        <a class="back" href="{{ url('/') }}">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            Return to SmartBasket
        </a>

    </section>

    <!-- Security notice -->
    <p class="notice">
        <i class="fas fa-lock" aria-hidden="true"></i>
        Restricted access is monitored and audited.
    </p>

</main>

<script>
    /* =====================================================
       PASSWORD VISIBILITY — EXISTING FUNCTION PRESERVED
    ===================================================== */

    const toggle = document.getElementById('passwordToggle');
    const password = document.getElementById('password');

    if (toggle && password) {
        toggle.addEventListener('click', () => {
            const reveal = password.type === 'password';

            password.type = reveal ? 'text' : 'password';

            toggle.setAttribute('aria-pressed', String(reveal));
            toggle.setAttribute(
                'aria-label',
                reveal ? 'Hide password' : 'Show password'
            );

            const icon = toggle.querySelector('i');

            if (icon) {
                icon.className = reveal ? 'fas fa-eye-slash' : 'fas fa-eye';
            }
        });
    }

    /* =====================================================
       LOGIN BUTTON LOADING — EXISTING FUNCTION PRESERVED
    ===================================================== */

    const form = document.getElementById('adminLoginForm');
    const loginButton = document.getElementById('loginButton');

    if (form && loginButton) {
        form.addEventListener('submit', () => {
            if (!form.checkValidity()) {
                return;
            }

            loginButton.disabled = true;
            loginButton.innerHTML =
                '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i><span>Signing in…</span>';
        });
    }

    /* =====================================================
       MOUSE PARALLAX — SUBTLE AND PERFORMANCE-FRIENDLY
    ===================================================== */

    const grid = document.querySelector('.rgb-grid');
    const ring = document.querySelector('.energy-ring');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    let parallaxFrame = null;

    document.addEventListener('mousemove', (event) => {
        if (reduceMotion.matches || window.innerWidth < 700) {
            return;
        }

        if (parallaxFrame) {
            cancelAnimationFrame(parallaxFrame);
        }

        parallaxFrame = requestAnimationFrame(() => {
            const x = (event.clientX / window.innerWidth) - 0.5;
            const y = (event.clientY / window.innerHeight) - 0.5;

            if (grid) {
                grid.style.transform =
                    `perspective(550px) rotateX(${62 + y * 2}deg) rotateY(${x * 3}deg) scale(1.5)`;
            }

            if (ring) {
                ring.style.marginLeft = `${x * 12}px`;
                ring.style.marginTop = `${y * 12}px`;
            }

            parallaxFrame = null;
        });
    }, { passive: true });
</script>


</body>
</html>

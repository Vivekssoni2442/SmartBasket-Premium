<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

/* =========================================================
   RESET
========================================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* =========================================================
   BODY
========================================================= */

html,
body {
    width: 100%;
    min-height: 100%;
}

body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 25px;
    overflow-x: hidden;
    position: relative;

    background: linear-gradient(
        135deg,
        #020617 0%,
        #000000 50%,
        #111827 100%
    );
}

/* =========================================================
   PREMIUM RGB BACKGROUND
========================================================= */

.background {
    position: fixed;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
}

.rgb-light {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: .30;
    mix-blend-mode: screen;
}

.rgb-light.one {
    width: 650px;
    height: 650px;

    background: conic-gradient(
        from 0deg,
        #ff004c,
        #ff00ff,
        #00ffff,
        #0066ff,
        #ff004c
    );

    top: -250px;
    left: -230px;
    filter: blur(110px);
    opacity: .22;

    animation:
        rgbOne 12s linear infinite,
        rgbPulse 5s ease-in-out infinite;
}

.rgb-light.two {
    width: 650px;
    height: 650px;

    background: conic-gradient(
        from 180deg,
        #00ffff,
        #0066ff,
        #ff00ff,
        #ffae00,
        #00ffff
    );

    right: -250px;
    bottom: -270px;
    filter: blur(120px);
    opacity: .20;

    animation:
        rgbTwo 15s linear infinite,
        rgbPulse 6s ease-in-out infinite;
}

/* =========================================================
   RGB ANIMATIONS
========================================================= */

@keyframes rgbOne {
    0% {
        transform: rotate(0deg) scale(1);
    }

    50% {
        transform: rotate(180deg) scale(1.12);
    }

    100% {
        transform: rotate(360deg) scale(1);
    }
}

@keyframes rgbTwo {
    0% {
        transform: rotate(360deg) scale(1);
    }

    50% {
        transform: rotate(180deg) scale(1.13);
    }

    100% {
        transform: rotate(0deg) scale(1);
    }
}

@keyframes rgbPulse {
    0%, 100% {
        opacity: .16;
    }

    50% {
        opacity: .28;
    }
}

/* =========================================================
   ANIMATED GRID
========================================================= */

.grid {
    position: absolute;
    inset: -100px;
    opacity: .16;

    background-image:
        linear-gradient(
            rgba(0,255,255,.045) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(255,0,255,.045) 1px,
            transparent 1px
        );

    background-size: 55px 55px;

    transform:
        perspective(700px)
        rotateX(62deg)
        scale(1.8);

    transform-origin: center;

    animation: gridMove 12s linear infinite;
}

@keyframes gridMove {
    from {
        background-position: 0 0, 0 0;
    }

    to {
        background-position: 0 110px, 0 110px;
    }
}

/* =========================================================
   RGB LIGHT BEAMS
========================================================= */

.beam {
    position: absolute;
    width: 900px;
    height: 3px;

    background: linear-gradient(
        90deg,
        transparent,
        #ff00ff,
        #00ffff,
        transparent
    );

    filter: blur(2px);
    opacity: .5;
    pointer-events: none;
}

.beam.one {
    top: 18%;
    left: -200px;
    transform: rotate(22deg);

    animation: beamMove1 7s ease-in-out infinite;
}

.beam.two {
    bottom: 22%;
    right: -250px;
    transform: rotate(-25deg);

    animation: beamMove2 9s ease-in-out infinite;
}

@keyframes beamMove1 {
    0%, 100% {
        transform: translateX(-100px) rotate(22deg);
        opacity: .15;
    }

    50% {
        transform: translateX(500px) rotate(22deg);
        opacity: .55;
    }
}

@keyframes beamMove2 {
    0%, 100% {
        transform: translateX(100px) rotate(-25deg);
        opacity: .15;
    }

    50% {
        transform: translateX(-500px) rotate(-25deg);
        opacity: .55;
    }
}

/* =========================================================
   RGB PARTICLES
========================================================= */

.particles {
    position: absolute;
    inset: 0;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #ffffff;

    box-shadow:
        0 0 8px #00ffff,
        0 0 18px #ff00ff;

    animation: particleFloat 5s ease-in-out infinite;
}

.particle:nth-child(1) {
    left: 8%;
    top: 20%;
    animation-delay: 0s;
}

.particle:nth-child(2) {
    left: 17%;
    top: 70%;
    animation-delay: 1s;
}

.particle:nth-child(3) {
    left: 29%;
    top: 13%;
    animation-delay: 2s;
}

.particle:nth-child(4) {
    left: 76%;
    top: 17%;
    animation-delay: 1.5s;
}

.particle:nth-child(5) {
    left: 88%;
    top: 62%;
    animation-delay: 2.5s;
}

.particle:nth-child(6) {
    left: 67%;
    top: 84%;
    animation-delay: 3s;
}

.particle:nth-child(7) {
    left: 43%;
    top: 90%;
    animation-delay: 1.2s;
}

.particle:nth-child(8) {
    left: 94%;
    top: 35%;
    animation-delay: 3.5s;
}

@keyframes particleFloat {
    0%, 100% {
        transform: translateY(0) scale(.7);
        opacity: .25;
    }

    50% {
        transform: translateY(-35px) scale(1.5);
        opacity: 1;
    }
}

/* =========================================================
   ENERGY RING
========================================================= */

.energy-ring {
    position: fixed;
    width: 600px;
    height: 600px;
    border-radius: 50%;

    border: 1px solid rgba(0,255,255,.13);

    box-shadow:
        0 0 70px rgba(0,255,255,.08),
        inset 0 0 70px rgba(255,0,255,.06);

    animation: ringRotate 20s linear infinite;

    pointer-events: none;
    z-index: 1;
}

.energy-ring::before {
    content: "";
    position: absolute;
    inset: 35px;
    border-radius: 50%;

    border: 1px dashed rgba(255,0,255,.18);

    animation: ringRotateReverse 13s linear infinite;
}

.energy-ring::after {
    content: "";
    position: absolute;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    top: 50px;
    left: 50%;

    background: #00ffff;

    box-shadow:
        0 0 15px #00ffff,
        0 0 35px #ff00ff;
}

@keyframes ringRotate {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

@keyframes ringRotateReverse {
    from {
        transform: rotate(360deg);
    }

    to {
        transform: rotate(0deg);
    }
}

/* =========================================================
   LOGIN CARD — SLIGHTLY SMALLER
   Original width: 420px
   Updated width: 400px
========================================================= */

.login-container {
    width: 400px;
    max-width: 100%;

    /* Slightly reduced padding */
    padding: 36px;

    border-radius: 28px;

    background: linear-gradient(
        145deg,
        rgba(255,255,255,.10),
        rgba(255,255,255,.045)
    );

    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);

    border: 1px solid rgba(255,215,0,.25);

    box-shadow:
        0 30px 90px rgba(0,0,0,.60),
        0 0 60px rgba(37,93,224,.06),
        inset 0 1px 0 rgba(255,255,255,.07);

    position: relative;
    z-index: 10;

    animation: show 1s cubic-bezier(.22,1,.36,1);

    overflow: hidden;
}

/* =========================================================
   ANIMATED CARD BORDER
========================================================= */

.login-container::before {
    content: "";
    position: absolute;
    inset: 0;
    padding: 1px;
    border-radius: 28px;

    background: linear-gradient(
        120deg,
        transparent,
        rgba(37,93,224,.60),
        transparent,
        rgba(155,92,255,.45),
        transparent,
        rgba(245,209,101,.45),
        transparent
    );

    background-size: 300% 300%;

    animation: borderMove 8s linear infinite;

    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);

    -webkit-mask-composite: xor;
    mask-composite: exclude;

    pointer-events: none;
}

@keyframes borderMove {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.login-container::after {
    content: "";
    position: absolute;
    width: 260px;
    height: 100px;
    top: -70px;
    left: 50%;
    transform: translateX(-50%);
    background: #255DE0;
    filter: blur(70px);
    opacity: .12;
    pointer-events: none;
}

@keyframes show {
    from {
        opacity: 0;
        transform: translateY(70px) scale(.94);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   LOGO — SLIGHTLY COMPACT
========================================================= */

.logo {
    text-align: center;
    position: relative;
    z-index: 2;
}

.logo-circle {
    width: 88px;
    height: 88px;
    margin: auto;
    border-radius: 27px;

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 42px;

    background: linear-gradient(
        135deg,
        #FFD700,
        #ff9900
    );

    box-shadow: 0 0 40px rgba(255,215,0,.65);

    animation: logoFloat 3s ease-in-out infinite;
}

@keyframes logoFloat {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }

    50% {
        transform: translateY(-7px) rotate(2deg);
    }
}

.logo h1 {
    margin-top: 17px;
    color: #ffffff;
    font-size: 35px;
    font-weight: 800;
    letter-spacing: 2.5px;
}

.logo span {
    color: #FFD700 !important;
    text-shadow: 0 0 18px rgba(255,215,0,.30);
}

.logo p {
    color: #cccccc;
    font-size: 12px;
    margin: 9px 0 29px;
}

/* =========================================================
   INPUTS
========================================================= */

.input-box {
    margin-bottom: 17px;
    position: relative;
}

.input-box input {
    width: 100%;
    height: 53px;
    padding: 0 18px;

    border: 1px solid transparent;
    outline: none;
    border-radius: 17px;

    background: rgba(255,255,255,.12);
    color: #ffffff;
    font-size: 14px;

    position: relative;
    z-index: 2;

    transition:
        background .3s ease,
        box-shadow .3s ease,
        border .3s ease;
}

.input-box input::placeholder {
    color: #aaaaaa;
}

.input-box input:hover {
    background: rgba(255,255,255,.14);
}

/* =========================================================
   INPUT FOCUS
========================================================= */

.input-box input:focus {
    background: rgba(255,255,255,.15);
    border: 1px solid #FFAE00;

    box-shadow:
        0 0 0 1px #FFAE00,
        0 0 8px rgba(255,174,0,.75),
        0 0 20px rgba(255,174,0,.45),
        0 0 40px rgba(255,174,0,.18);

    animation: inputGlow 1.5s ease-in-out infinite;
}

@keyframes inputGlow {
    0%, 100% {
        box-shadow:
            0 0 0 1px #FFAE00,
            0 0 8px rgba(255,174,0,.70),
            0 0 20px rgba(255,174,0,.40),
            0 0 40px rgba(255,174,0,.15);
    }

    50% {
        box-shadow:
            0 0 0 1px #FFAE00,
            0 0 12px rgba(255,174,0,.95),
            0 0 30px rgba(255,174,0,.60),
            0 0 55px rgba(255,174,0,.22);
    }
}

/* =========================================================
   OPTIONS
========================================================= */

.options {
    display: flex;
    justify-content: space-between;
    align-items: center;

    color: #ffffff;
    font-size: 12px;
    margin-bottom: 22px;

    position: relative;
    z-index: 2;
}

.options a {
    color: #FFD700;
    text-decoration: none;
    font-weight: 600;
    transition: .25s ease;
}

.options a:hover {
    color: #ffffff;
    text-shadow: 0 0 12px rgba(255,255,255,.25);
}

.remember-option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.remember-option input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin: 0;
    accent-color: #3B82F6;
    cursor: pointer;
}

/* =========================================================
   FORM
========================================================= */

.form-box {
    position: relative;
    z-index: 2;
}

/* =========================================================
   MAIN LOGIN BUTTON
========================================================= */

.form-box > form > button {
    width: 100%;
    height: 53px;

    border: none;
    border-radius: 18px;

    background: linear-gradient(
        135deg,
        #FFD700,
        #ff9900
    );

    color: #000000;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;

    transition: .3s ease;
    position: relative;
    overflow: hidden;
}

.form-box > form > button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 80%;
    height: 100%;

    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.55),
        transparent
    );

    transform: skewX(-20deg);

    animation: loginShine 4s ease-in-out infinite;
}

@keyframes loginShine {
    0%, 55% {
        left: -120%;
    }

    75%, 100% {
        left: 140%;
    }
}

.form-box > form > button:hover {
    transform: scale(1.03);

    box-shadow:
        0 0 20px rgba(255,215,0,.55),
        0 0 45px rgba(255,153,0,.25);
}

/* =========================================================
   REGISTER
========================================================= */

.register {
    text-align: center;
    color: #cccccc;
    margin-top: 21px;
    font-size: 13px;
}

.register a {
    color: #FFD700;
    text-decoration: none;
    font-weight: 700;
    transition: .25s ease;
}

.register a:hover {
    color: #ffffff;
}

/* =========================================================
   SELLER + ADMIN LOGIN ROW
========================================================= */

.login-options-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 12px;
    width: 100%;
    margin-top: 18px;
    align-items: stretch;
}

/* =========================================================
   SELLER LOGIN — LEFT
========================================================= */

.seller-login {
    width: 100%;
    min-width: 0;
    margin: 0;
    padding: 0;
    text-align: center;

    background: rgb(20,21,24) !important;
    background-color: rgb(20,21,24) !important;
    background-image: none !important;

    border: 1px solid rgba(255,255,255,.10) !important;
    border-radius: 15px !important;
    overflow: hidden;

    box-shadow: 0 8px 25px rgba(0,0,0,.35);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.seller-login a {
    display: flex !important;
    width: 100%;
    min-height: 52px;
    height: 100%;

    align-items: center;
    justify-content: center;

    padding: 9px 6px;

    background: rgb(20,21,24) !important;
    background-color: rgb(20,21,24) !important;
    background-image: none !important;

    color: #ffffff !important;

    border: none !important;
    border-radius: 15px;

    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    text-align: center;

    overflow-wrap: anywhere;
    cursor: pointer;

    transition:
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}

.seller-login:hover {
    background: #255DE0 !important;
    background-color: #255DE0 !important;
    background-image: none !important;

    border-color: #255DE0 !important;

    box-shadow: 0 0 25px rgba(37,93,224,.45) !important;
}

.seller-login:hover a {
    background: #255DE0 !important;
    background-color: #255DE0 !important;
    background-image: none !important;

    color: #ffffff !important;

    box-shadow: 0 0 25px rgba(37,93,224,.35);
}

/* =========================================================
   ADMIN LOGIN — RIGHT
========================================================= */

.admin-login {
    width: 100%;
    min-width: 0;
    margin: 0;
    padding: 0;
    text-align: center;

    background: rgb(20,21,24) !important;
    background-color: rgb(20,21,24) !important;
    background-image: none !important;

    border: 1px solid rgba(210,152,33,.45) !important;
    border-radius: 15px !important;
    overflow: hidden;

    box-shadow: 0 8px 25px rgba(0,0,0,.35);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}

.admin-login a {
    display: flex !important;
    width: 100%;
    min-height: 52px;
    height: 100%;

    align-items: center;
    justify-content: center;

    padding: 9px 6px;

    background: linear-gradient(
        135deg,
        #F5D165 0%,
        #D29821 100%
    ) !important;

    background-color: #F5D165 !important;

    color: #000000 !important;

    border: none !important;
    border-radius: 15px;

    font-size: 12px;
    font-weight: 700;

    text-align: center;
    text-decoration: none !important;

    overflow-wrap: anywhere;
    cursor: pointer;

    transition:
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}

.admin-login:hover {
    border-color: #D29821 !important;

    box-shadow: 0 0 25px rgba(210,152,33,.45) !important;
}

.admin-login:hover a {
    background: linear-gradient(
        135deg,
        #FFE58A 0%,
        #D29821 100%
    ) !important;

    color: #000000 !important;

    box-shadow: 0 0 20px rgba(210,152,33,.30);
}

/* =========================================================
   ERROR
========================================================= */

.login-error {
    background: #ff000033;
    color: #ff6b6b;
    padding: 11px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 18px;
    font-weight: 600;
    font-size: 13px;
    animation: messageIn .5s ease;
}

/* =========================================================
   SUCCESS
========================================================= */

.login-success {
    background: #00ff9933;
    color: #00ff99;
    padding: 11px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 18px;
    font-weight: 600;
    font-size: 13px;
    animation: messageIn .5s ease;
}

@keyframes messageIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================================
   MOBILE RESPONSIVE
========================================================= */

@media (max-width: 500px) {

    body {
        padding: 16px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .energy-ring {
        width: 420px;
        height: 420px;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 28px 24px;
        border-radius: 25px;
    }

    .logo h1 {
        font-size: 29px;
    }

    .logo-circle {
        width: 82px;
        height: 82px;
        font-size: 38px;
    }

    .login-options-row {
        gap: 10px;
    }

    .seller-login a,
    .admin-login a {
        min-height: 50px;
        font-size: 11px;
        padding: 9px 5px;
    }
}

/* =========================================================
   EXTRA SMALL SCREENS
========================================================= */

@media (max-width: 350px) {

    .login-container {
        padding: 24px 16px;
    }

    .login-options-row {
        gap: 8px;
    }

    .seller-login a,
    .admin-login a {
        font-size: 10px;
        padding: 8px 3px;
    }

    .options {
        gap: 8px;
        font-size: 10px;
    }

    .logo h1 {
        font-size: 25px;
        letter-spacing: 1.5px;
    }
}

</style>
</head>

<body>

<!-- =========================================================
     PREMIUM RGB BACKGROUND
========================================================= -->

<div class="background">

    <div class="rgb-light one"></div>

    <div class="rgb-light two"></div>

    <div class="grid"></div>

    <div class="beam one"></div>

    <div class="beam two"></div>

    <div class="particles">
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

<!-- ENERGY RING -->

<div class="energy-ring"></div>

<!-- =========================================================
     LOGIN CARD
========================================================= -->

<div class="login-container">

    <!-- LOGO -->

    <div class="logo">

        <div class="logo-circle">
            🛒
        </div>

        <h1>
            SMART <span>BASKET</span>
        </h1>

        <p>
            PREMIUM SHOPPING EXPERIENCE
        </p>

    </div>

    <!-- ERROR -->

    @if(session('error'))

        <div class="login-error">
            {{ session('error') }}
        </div>

    @endif

    <!-- SUCCESS -->

    @if(session('success'))

        <div class="login-success">
            {{ session('success') }}
        </div>

    @endif

    <!-- FORM -->

    <div class="form-box">

        <form
            method="POST"
            action="{{ route('login.submit') }}"
        >

            @csrf

            <!-- EMAIL -->

            <div class="input-box">

                <input
                    type="email"
                    name="email"
                    placeholder="Enter Email Address"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >

            </div>

            <!-- PASSWORD -->

            <div class="input-box">

                <input
                    type="password"
                    name="password"
                    placeholder="Enter Password"
                    autocomplete="current-password"
                    required
                >

            </div>

            <!-- OPTIONS -->

            <div class="options">

                <label class="remember-option">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >

                    Remember Me

                </label>

                <a href="{{ url('/forgot-password') }}">
                    Forgot Password?
                </a>

            </div>

            <!-- LOGIN -->

            <button type="submit">
                LOGIN
            </button>

            <!-- REGISTER -->

            @if(app(\App\Services\SiteSettings::class)->enabled('customer_registration_enabled'))
            <div class="register">

                Don't have an account?

                <a href="{{ url('/register') }}">
                    Create Account
                </a>

            </div>
            @endif

            <!-- =================================================
                 SELLER + ADMIN LOGIN
                 BOTH BUTTONS IN THE SAME ROW
            ================================================== -->

            <div class="login-options-row">

                <!-- SELLER LOGIN — LEFT -->

                <div class="seller-login">

                    <a href="{{ url('/seller-login') }}">
                        🛒 Seller Login
                    </a>

                </div>

                <!-- ADMIN LOGIN — RIGHT -->

                <div class="admin-login">

                    <a href="{{ route('admin.login') }}">
                        👑 Admin Login
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- =========================================================
     MOUSE PARALLAX
========================================================= -->

<script>

document.addEventListener('mousemove', function(event) {

    const x = (event.clientX / window.innerWidth) - 0.5;

    const y = (event.clientY / window.innerHeight) - 0.5;

    const grid = document.querySelector('.grid');

    const ring = document.querySelector('.energy-ring');

    if (grid) {

        grid.style.transform =
            `perspective(700px)
             rotateX(${62 + y * 2}deg)
             rotateY(${x * 3}deg)
             scale(1.8)`;

    }

    if (ring) {

        ring.style.marginLeft = `${x * 14}px`;

        ring.style.marginTop = `${y * 14}px`;

    }

});

</script>

</body>
</html>

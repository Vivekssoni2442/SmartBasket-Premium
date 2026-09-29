<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Seller Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

html,
body{
    width:100%;
    height:100%;
}

body{

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    overflow:hidden;

    position:relative;

    background:
        radial-gradient(
            circle at 15% 20%,
            rgba(255,0,128,.16),
            transparent 30%
        ),
        radial-gradient(
            circle at 85% 25%,
            rgba(0,255,255,.15),
            transparent 30%
        ),
        radial-gradient(
            circle at 50% 90%,
            rgba(255,174,0,.14),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #020617 0%,
            #000000 48%,
            #111827 100%
        );

}


/* =========================================================
   PREMIUM RGB BACKGROUND
========================================================= */

body::before{

    content:"";

    position:absolute;

    width:650px;
    height:650px;

    left:-230px;
    top:-250px;

    border-radius:50%;

    background:
        conic-gradient(
            from 0deg,
            #ff004c,
            #ff00ff,
            #00ffff,
            #0066ff,
            #ff004c
        );

    filter:blur(100px);

    opacity:.22;

    animation:
        rgbRotate 12s linear infinite,
        rgbPulse 5s ease-in-out infinite;

    pointer-events:none;

}


body::after{

    content:"";

    position:absolute;

    width:650px;
    height:650px;

    right:-250px;
    bottom:-270px;

    border-radius:50%;

    background:
        conic-gradient(
            from 180deg,
            #00ffff,
            #0066ff,
            #ff00ff,
            #ffae00,
            #00ffff
        );

    filter:blur(110px);

    opacity:.20;

    animation:
        rgbRotateReverse 15s linear infinite,
        rgbPulse 6s ease-in-out infinite;

    pointer-events:none;

}


@keyframes rgbRotate{

    0%{
        transform:rotate(0deg) scale(1);
    }

    50%{
        transform:rotate(180deg) scale(1.12);
    }

    100%{
        transform:rotate(360deg) scale(1);
    }

}


@keyframes rgbRotateReverse{

    0%{
        transform:rotate(360deg) scale(1);
    }

    50%{
        transform:rotate(180deg) scale(1.13);
    }

    100%{
        transform:rotate(0deg) scale(1);
    }

}


@keyframes rgbPulse{

    0%,
    100%{
        opacity:.16;
    }

    50%{
        opacity:.28;
    }

}


/* =========================================================
   RGB GRID
========================================================= */

body .rgb-grid{

    position:absolute;

    inset:-100px;

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

    background-size:55px 55px;

    transform:perspective(700px)
              rotateX(62deg)
              scale(1.8);

    transform-origin:center;

    animation:gridMove 12s linear infinite;

    opacity:.65;

    pointer-events:none;

}


@keyframes gridMove{

    from{
        background-position:0 0;
    }

    to{
        background-position:0 110px;
    }

}


/* =========================================================
   RGB LIGHT BEAMS
========================================================= */

.rgb-beam{

    position:absolute;

    width:900px;
    height:3px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #ff00ff,
            #00ffff,
            transparent
        );

    filter:blur(2px);

    opacity:.5;

    pointer-events:none;

}


.rgb-beam.one{

    top:18%;

    left:-200px;

    transform:rotate(22deg);

    animation:beamMove1 7s ease-in-out infinite;

}


.rgb-beam.two{

    bottom:22%;

    right:-250px;

    transform:rotate(-25deg);

    animation:beamMove2 9s ease-in-out infinite;

}


@keyframes beamMove1{

    0%,
    100%{
        transform:
            translateX(-100px)
            rotate(22deg);
        opacity:.15;
    }

    50%{
        transform:
            translateX(500px)
            rotate(22deg);
        opacity:.55;
    }

}


@keyframes beamMove2{

    0%,
    100%{
        transform:
            translateX(100px)
            rotate(-25deg);
        opacity:.15;
    }

    50%{
        transform:
            translateX(-500px)
            rotate(-25deg);
        opacity:.55;
    }

}


/* =========================================================
   RGB PARTICLES
========================================================= */

.rgb-particles{

    position:absolute;

    inset:0;

    pointer-events:none;

}


.rgb-particles span{

    position:absolute;

    width:4px;
    height:4px;

    border-radius:50%;

    background:#ffffff;

    box-shadow:
        0 0 8px #00ffff,
        0 0 18px #ff00ff;

    animation:
        particleFloat 5s ease-in-out infinite;

}


.rgb-particles span:nth-child(1){
    left:8%;
    top:20%;
    animation-delay:0s;
}

.rgb-particles span:nth-child(2){
    left:17%;
    top:70%;
    animation-delay:1s;
}

.rgb-particles span:nth-child(3){
    left:29%;
    top:13%;
    animation-delay:2s;
}

.rgb-particles span:nth-child(4){
    left:76%;
    top:17%;
    animation-delay:1.5s;
}

.rgb-particles span:nth-child(5){
    left:88%;
    top:62%;
    animation-delay:2.5s;
}

.rgb-particles span:nth-child(6){
    left:67%;
    top:84%;
    animation-delay:3s;
}

.rgb-particles span:nth-child(7){
    left:43%;
    top:90%;
    animation-delay:1.2s;
}

.rgb-particles span:nth-child(8){
    left:94%;
    top:35%;
    animation-delay:3.5s;
}


@keyframes particleFloat{

    0%,
    100%{
        transform:
            translateY(0)
            scale(.7);

        opacity:.25;
    }

    50%{
        transform:
            translateY(-35px)
            scale(1.5);

        opacity:1;
    }

}


/* =========================================================
   ENERGY RING
========================================================= */

.energy-ring{

    position:absolute;

    width:600px;
    height:600px;

    border-radius:50%;

    border:
        1px solid rgba(0,255,255,.13);

    box-shadow:
        0 0 70px rgba(0,255,255,.08),
        inset 0 0 70px rgba(255,0,255,.06);

    animation:
        ringRotate 20s linear infinite;

    pointer-events:none;

}


.energy-ring::before{

    content:"";

    position:absolute;

    inset:35px;

    border-radius:50%;

    border:
        1px dashed rgba(255,0,255,.18);

    animation:
        ringRotateReverse 13s linear infinite;

}


.energy-ring::after{

    content:"";

    position:absolute;

    width:14px;
    height:14px;

    border-radius:50%;

    top:50px;
    left:50%;

    background:#00ffff;

    box-shadow:
        0 0 15px #00ffff,
        0 0 35px #ff00ff;

}


@keyframes ringRotate{

    from{
        transform:rotate(0deg);
    }

    to{
        transform:rotate(360deg);
    }

}


@keyframes ringRotateReverse{

    from{
        transform:rotate(360deg);
    }

    to{
        transform:rotate(0deg);
    }

}


/* =========================================================
   SELLER LOGIN CARD
   ORIGINAL SELLER COLOR
========================================================= */

.card{

    width:420px;

    padding:40px;

    border-radius:30px;

    background:rgb(20,21,24) !important;

    background-color:rgb(20,21,24) !important;

    background-image:none !important;

    backdrop-filter:none !important;

    -webkit-backdrop-filter:none !important;

    border:1px solid rgba(37,99,235,.5);

    box-shadow:
        0 0 50px rgba(37,99,235,.4),
        0 25px 80px rgba(0,0,0,.55);

    position:relative;

    z-index:5;

    animation:
        show 1s ease,
        cardFloat 6s ease-in-out infinite;

}


@keyframes show{

    from{

        opacity:0;

        transform:
            translateY(60px)
            scale(.96);

    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);

    }

}


@keyframes cardFloat{

    0%,
    100%{
        box-shadow:
            0 0 45px rgba(37,99,235,.35),
            0 25px 80px rgba(0,0,0,.55);
    }

    50%{
        box-shadow:
            0 0 70px rgba(37,99,235,.55),
            0 25px 90px rgba(0,0,0,.65);
    }

}


/* =========================================================
   LOGO
========================================================= */

.logo{

    width:95px;

    height:95px;

    margin:auto;

    border-radius:30px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:45px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    box-shadow:
        0 0 40px rgba(37,99,235,.45);

    animation:
        logoFloat 3s ease-in-out infinite;

}


@keyframes logoFloat{

    0%,
    100%{
        transform:translateY(0) rotate(0deg);
    }

    50%{
        transform:translateY(-7px) rotate(2deg);
    }

}


/* =========================================================
   TITLE
========================================================= */

h1{

    text-align:center;

    margin-top:25px;

    color:#ffffff;

    font-size:35px;

    font-weight:800;

    letter-spacing:2px;

}


h1 span{

    color:#3b82f6 !important;

}


/* =========================================================
   SUBTITLE
========================================================= */

.subtitle{

    text-align:center;

    color:#cccccc;

    font-size:13px;

    margin:10px 0 35px;

}


/* =========================================================
   SESSION MESSAGE
========================================================= */

.message-error{

    background:rgba(255,0,0,.15);

    color:#ff6b6b;

    padding:12px;

    border-radius:10px;

    text-align:center;

    margin-bottom:20px;

    font-weight:600;

}


.message-success{

    background:rgba(37,99,235,.15);

    color:#60a5fa;

    padding:12px;

    border-radius:10px;

    text-align:center;

    margin-bottom:20px;

    font-weight:600;

}


/* =========================================================
   INPUT
========================================================= */

.input-box{

    margin-bottom:20px;

}


.input-box input{

    width:100%;

    height:55px;

    padding:0 20px;

    border:none;

    outline:none;

    border-radius:18px;

    background:rgba(255,255,255,.10);

    color:#ffffff;

    font-size:15px;

    transition:.3s ease;

}


.input-box input:focus{

    background:rgba(255,255,255,.12);

    border:1px solid #2563eb;

    box-shadow:
        0 0 0 1px #2563eb,
        0 0 10px rgba(37,99,235,.75),
        0 0 25px rgba(37,99,235,.45);

    animation:
        sellerInputGlow 1.5s ease-in-out infinite;

}


@keyframes sellerInputGlow{

    0%,
    100%{

        box-shadow:
            0 0 0 1px #2563eb,
            0 0 8px rgba(37,99,235,.65),
            0 0 20px rgba(37,99,235,.35);

    }

    50%{

        box-shadow:
            0 0 0 1px #3b82f6,
            0 0 14px rgba(37,99,235,.95),
            0 0 32px rgba(37,99,235,.55),
            0 0 50px rgba(37,99,235,.20);

    }

}


.input-box input::placeholder{

    color:#aaaaaa;

}


/* =========================================================
   OPTIONS
========================================================= */

.options{

    display:flex;

    justify-content:space-between;

    align-items:center;

    color:#ffffff;

    font-size:13px;

    margin-bottom:25px;

}


.options label{

    display:flex;

    align-items:center;

    gap:8px;

    cursor:pointer;

}


.options input[type="checkbox"]{

    width:16px;

    height:16px;

    cursor:pointer;

    accent-color:#2563eb;

}


/* =========================================================
   FORGOT PASSWORD
========================================================= */

.forgot-link{

    color:#3b82f6 !important;

    text-decoration:none;

    font-weight:600;

    transition:.25s ease;

}


.forgot-link:hover{

    color:#ffffff !important;

    text-decoration:underline;

}


/* =========================================================
   LOGIN BUTTON
========================================================= */

button{

    width:100%;

    height:55px;

    border:none;

    border-radius:20px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #1d4ed8
        );

    color:#ffffff;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:.3s;

}


button:hover{

    transform:scale(1.03);

    box-shadow:
        0 0 20px rgba(37,99,235,.55),
        0 0 40px rgba(37,99,235,.35);

}


/* =========================================================
   CUSTOMER LOGIN
   ORIGINAL GOLD/ORANGE HOVER
========================================================= */

.back{

    display:flex;

    align-items:center;

    justify-content:center;

    width:100%;

    min-height:50px;

    margin-top:25px;

    padding:10px 20px;

    border-radius:18px;

    background:rgb(20,21,24);

    border:1px solid rgba(255,255,255,.10);

    color:#ffffff !important;

    text-decoration:none;

    font-weight:600;

    cursor:pointer;

    transition:
        background .25s ease,
        color .25s ease,
        border-color .25s ease,
        box-shadow .25s ease,
        transform .25s ease;

}


.back:hover{

    background:rgb(255,173,0) !important;

    color:#000000 !important;

    border-color:rgb(255,173,0) !important;

    box-shadow:
        0 0 30px rgba(255,173,0,.45);

    transform:translateY(-1px);

}


/* =========================================================
   CREATE SELLER ACCOUNT
========================================================= */

.create-account-row{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:7px;

    margin-top:22px;

    color:#aaaaaa;

    font-size:13px;

}


.create-account-link{

    width:auto;

    height:auto;

    padding:0;

    border:0;

    border-radius:0;

    background:transparent;

    color:#3b82f6;

    font-size:13px;

    font-weight:700;

    cursor:pointer;

    transition:.25s ease;

}


.create-account-link:hover{

    color:#60a5fa;

    transform:none;

    box-shadow:none;

    text-decoration:underline;

}


/* =========================================================
   SELLER REGISTRATION MODAL
========================================================= */

.register-modal{

    position:fixed;

    inset:0;

    display:none;

    align-items:center;

    justify-content:center;

    padding:20px;

    background:rgba(0,0,0,.72);

    backdrop-filter:blur(10px);

    -webkit-backdrop-filter:blur(10px);

    z-index:1000;

}


.register-modal.active{

    display:flex;

}


.register-modal-card{

    width:min(560px,100%);

    max-height:calc(100vh - 40px);

    overflow-y:auto;

    padding:32px;

    border-radius:28px;

    background:rgb(20,21,24);

    border:1px solid rgba(37,99,235,.45);

    box-shadow:
        0 0 70px rgba(37,99,235,.22),
        0 25px 80px rgba(0,0,0,.55);

    position:relative;

    animation:registerModalShow .28s ease;

}


@keyframes registerModalShow{

    from{

        opacity:0;

        transform:
            translateY(20px)
            scale(.97);

    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);

    }

}


.register-modal-close{

    position:absolute;

    top:16px;

    right:16px;

    width:42px;

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:50%;

    border:1px solid rgba(255,255,255,.12);

    background:rgba(255,255,255,.07);

    color:#ffffff;

    font-size:24px;

    line-height:1;

    cursor:pointer;

    transition:.25s ease;

}


.register-modal-close:hover{

    background:#FFD700;

    color:#000000;

    transform:rotate(90deg);

}


.register-modal-icon{

    width:70px;

    height:70px;

    margin:0 auto 16px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:22px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    box-shadow:
        0 0 30px rgba(37,99,235,.28);

    font-size:32px;

}


.register-modal-title{

    margin:0;

    text-align:center;

    color:#ffffff;

    font-size:26px;

    font-weight:800;

}


.register-modal-title span{

    color:#3b82f6;

}


.register-modal-subtitle{

    margin:8px 0 24px;

    text-align:center;

    color:#aaaaaa;

    font-size:13px;

}


.register-form-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:16px;

}


.register-field{

    margin:0;

}


.register-field.full{

    grid-column:1 / -1;

}


.register-field label{

    display:block;

    margin:0 0 7px 4px;

    color:#eeeeee;

    font-size:12px;

    font-weight:600;

}


.register-field input{

    width:100%;

    height:50px;

    padding:0 16px;

    border:1px solid rgba(255,255,255,.10);

    outline:none;

    border-radius:15px;

    background:rgba(255,255,255,.07);

    color:#ffffff;

    font-size:14px;

    transition:.2s ease;

}


.register-field input:focus{

    border-color:rgba(37,99,235,.65);

    box-shadow:
        0 0 0 3px rgba(37,99,235,.10),
        0 0 18px rgba(37,99,235,.20);

}


.register-field input::placeholder{

    color:#888888;

}


.password-hint{

    margin:6px 3px 0;

    color:#777777;

    font-size:10px;

    line-height:1.45;

}


/* =========================================================
   CREATE SELLER ACCOUNT BUTTON
========================================================= */

.register-submit{

    margin-top:20px;

    height:54px;

    border-radius:17px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #1d4ed8
        );

    color:#ffffff;

    font-size:16px;

    font-weight:800;

}


.register-submit:hover{

    transform:
        translateY(-1px)
        scale(1.01);

    box-shadow:
        0 0 20px rgba(37,99,235,.55),
        0 0 40px rgba(37,99,235,.30);

}


.register-login-note{

    margin-top:14px;

    text-align:center;

    color:#888888;

    font-size:12px;

}


.register-login-note button{

    width:auto;

    height:auto;

    padding:0;

    background:transparent;

    color:#3b82f6;

    font-size:12px;

    font-weight:700;

}


.register-login-note button:hover{

    transform:none;

    box-shadow:none;

    text-decoration:underline;

}


/* =========================================================
   MOBILE MODAL
========================================================= */

@media(max-width:600px){

    .register-modal-card{

        padding:27px 20px 22px;

        border-radius:22px;

    }

    .register-form-grid{

        grid-template-columns:1fr;

    }

    .register-field.full{

        grid-column:auto;

    }

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:500px){

    .card{

        width:calc(100% - 30px);

        padding:30px 25px;

    }

    h1{

        font-size:29px;

    }

    .options{

        font-size:12px;

    }

    .energy-ring{

        width:420px;

        height:420px;

    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){

    *,
    *::before,
    *::after{

        animation-duration:.01ms !important;

        animation-iteration-count:1 !important;

        transition-duration:.01ms !important;

    }

}

</style>

</head>


<body>


<!-- =========================================================
     PREMIUM RGB BACKGROUND ELEMENTS
========================================================= -->

<div class="rgb-grid"></div>

<div class="rgb-beam one"></div>

<div class="rgb-beam two"></div>

<div class="energy-ring"></div>


<div class="rgb-particles">

    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>

</div>


<!-- =========================================================
     SELLER LOGIN CARD
========================================================= -->

<div class="card">


    <!-- LOGO -->

    <div class="logo">
        🏪
    </div>


    <!-- TITLE -->

    <h1>
        SELLER <span>LOGIN</span>
    </h1>


    <div class="subtitle">
        SMART BASKET SELLER PANEL
    </div>


    <!-- ERROR -->

    @if(session('error'))

        <div class="message-error">
            {{ session('error') }}
        </div>

    @endif


    <!-- SUCCESS -->

    @if(session('success'))

        <div class="message-success">
            {{ session('success') }}
        </div>

    @endif


    <!-- LOGIN FORM -->

    <form method="POST" action="{{ route('seller.login.submit') }}">

        @csrf


        <!-- EMAIL -->

        <div class="input-box">

            <input
                type="email"
                name="email"
                placeholder="Enter Seller Email"
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

            <label>

                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                >

                Remember Me

            </label>


            <a
                href="{{ url('/forgot-password') }}"
                class="forgot-link"
            >
                Forgot Password?
            </a>

        </div>


        <!-- LOGIN -->

        <button type="submit">
            LOGIN AS SELLER
        </button>


    </form>


    <!-- CREATE SELLER ACCOUNT -->

    <div class="create-account-row">

        <span>New seller?</span>

        <button
            type="button"
            class="create-account-link"
            id="openSellerRegister"
        >
            Create a Seller Account
        </button>

    </div>


    <!-- CUSTOMER LOGIN -->

    <a
        class="back"
        href="{{ url('/login') }}"
    >
        ← Customer Login
    </a>


</div>


<!-- =========================================================
     CREATE SELLER ACCOUNT MODAL
========================================================= -->

<div
    class="register-modal"
    id="sellerRegisterModal"
    aria-hidden="true"
>

    <div
        class="register-modal-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="sellerRegisterTitle"
    >

        <button
            type="button"
            class="register-modal-close"
            id="closeSellerRegister"
            aria-label="Close"
        >
            ×
        </button>


        <div class="register-modal-icon">
            🏪
        </div>


        <h2
            class="register-modal-title"
            id="sellerRegisterTitle"
        >
            CREATE <span>SELLER ACCOUNT</span>
        </h2>


        <p class="register-modal-subtitle">
            Register your seller account and start your Smart Basket journey.
        </p>


        <form
            method="POST"
            action="{{ route('seller.register.submit') }}"
        >

            @csrf


            <div class="register-form-grid">


                <div class="register-field full">

                    <label for="seller_name">
                        Seller / Shop Name
                    </label>

                    <input
                        id="seller_name"
                        type="text"
                        name="seller_name"
                        value="{{ old('seller_name') }}"
                        placeholder="Enter seller or shop name"
                        autocomplete="organization"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="register-field">

                    <label for="seller_email">
                        Email Address
                    </label>

                    <input
                        id="seller_email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email"
                        autocomplete="email"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="register-field">

                    <label for="seller_mobile">
                        Mobile Number
                    </label>

                    <input
                        id="seller_mobile"
                        type="tel"
                        name="mobile_number"
                        value="{{ old('mobile_number') }}"
                        placeholder="Enter mobile number"
                        autocomplete="tel"
                        maxlength="20"
                        required
                    >

                </div>


                <div class="register-field">

                    <label for="seller_password">
                        Password
                    </label>

                    <input
                        id="seller_password"
                        type="password"
                        name="password"
                        placeholder="Create password"
                        autocomplete="new-password"
                        required
                    >

                    <div class="password-hint">
                        Minimum 8 characters with uppercase, lowercase, number and symbol.
                    </div>

                </div>


                <div class="register-field">

                    <label for="seller_password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        id="seller_password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        autocomplete="new-password"
                        required
                    >

                </div>


            </div>


            <button
                type="submit"
                class="register-submit"
            >
                CREATE SELLER ACCOUNT
            </button>


        </form>


        <div class="register-login-note">

            Already have a seller account?

            <button
                type="button"
                id="backToSellerLogin"
            >
                Login here
            </button>

        </div>


    </div>

</div>


<script>

(function () {

    const modal =
        document.getElementById('sellerRegisterModal');

    const openBtn =
        document.getElementById('openSellerRegister');

    const closeBtn =
        document.getElementById('closeSellerRegister');

    const backBtn =
        document.getElementById('backToSellerLogin');


    if (!modal || !openBtn || !closeBtn) return;


    const openModal = () => {

        modal.classList.add('active');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';


        setTimeout(() => {

            const firstInput =
                modal.querySelector('input');

            if (firstInput) {

                firstInput.focus();

            }

        }, 50);

    };


    const closeModal = () => {

        modal.classList.remove('active');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

        openBtn.focus();

    };


    openBtn.addEventListener(
        'click',
        openModal
    );


    closeBtn.addEventListener(
        'click',
        closeModal
    );


    if (backBtn) {

        backBtn.addEventListener(
            'click',
            closeModal
        );

    }


    modal.addEventListener(
        'click',
        function (event) {

            if (event.target === modal) {

                closeModal();

            }

        }
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal.classList.contains('active')
            ) {

                closeModal();

            }

        }
    );


    @if (
        $errors->has('seller_name') ||
        $errors->has('email') ||
        $errors->has('mobile_number') ||
        $errors->has('password')
    )

        openModal();

    @endif

})();

</script>


</body>

</html>
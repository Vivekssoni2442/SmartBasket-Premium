<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login | SmartBasket Premium</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           ROOT
        ========================================================= */

        :root{

            color-scheme:dark;

            --gold-1:#F5D165;
            --gold-2:#D29821;

            --gold:#F5D165;

            --blue:#255DE0;
            --cyan:#00eaff;
            --purple:#9b5cff;
            --pink:#ff3cac;

            --bg:#02040a;

            --panel:rgba(8,13,25,.72);

            --muted:#91a0b7;

            --border:rgba(255,255,255,.10);

        }


        /* =========================================================
           RESET
        ========================================================= */

        *{

            margin:0;
            padding:0;

            box-sizing:border-box;

            font-family:'Poppins',sans-serif;

        }


        html{

            scroll-behavior:smooth;

        }


        /* =========================================================
           BODY
           SAME RGB BACKGROUND STYLE AS SELLER LOGIN
        ========================================================= */

        body{

            min-height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

            padding:30px;

            color:#fff;

            overflow:hidden;

            position:relative;

            background:

                linear-gradient(
                    135deg,
                    #020617 0%,
                    #000000 50%,
                    #111827 100%
                );

        }


        /* =========================================================
           RGB GLOW - TOP LEFT
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

            z-index:0;

        }


        /* =========================================================
           RGB GLOW - BOTTOM RIGHT
        ========================================================= */

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

            z-index:0;

        }


        @keyframes rgbRotate{

            from{

                transform:rotate(0deg);

            }

            to{

                transform:rotate(360deg);

            }

        }


        @keyframes rgbRotateReverse{

            from{

                transform:rotate(360deg);

            }

            to{

                transform:rotate(0deg);

            }

        }


        @keyframes rgbPulse{

            0%,
            100%{

                opacity:.16;

                transform:scale(1);

            }

            50%{

                opacity:.28;

                transform:scale(1.12);

            }

        }


        /* =========================================================
           ANIMATED RGB GRID
        ========================================================= */

        .rgb-grid{

            position:fixed;

            inset:-100px;

            z-index:1;

            pointer-events:none;

            opacity:.17;

            background-image:

                linear-gradient(
                    rgba(255,255,255,.055) 1px,
                    transparent 1px
                ),

                linear-gradient(
                    90deg,
                    rgba(255,255,255,.055) 1px,
                    transparent 1px
                );

            background-size:
                55px 55px;

            transform:

                perspective(500px)
                rotateX(62deg)
                scale(1.5);

            transform-origin:center bottom;

            animation:

                gridMove 12s linear infinite;

        }


        @keyframes gridMove{

            from{

                background-position:
                    0 0,
                    0 0;

            }

            to{

                background-position:
                    0 55px,
                    55px 0;

            }

        }


        /* =========================================================
           RGB LIGHT BEAMS
        ========================================================= */

        .rgb-beam{

            position:fixed;

            width:2px;

            height:130%;

            top:-15%;

            opacity:.35;

            filter:blur(1px);

            transform:rotate(25deg);

            pointer-events:none;

            z-index:2;

        }


        .rgb-beam.one{

            left:15%;

            background:

                linear-gradient(
                    transparent,
                    #255DE0,
                    transparent
                );

            animation:

                beamMove 8s linear infinite;

        }


        .rgb-beam.two{

            left:45%;

            background:

                linear-gradient(
                    transparent,
                    #00eaff,
                    transparent
                );

            animation:

                beamMove 11s linear infinite -4s;

        }


        .rgb-beam.three{

            left:75%;

            background:

                linear-gradient(
                    transparent,
                    #ff3cac,
                    transparent
                );

            animation:

                beamMove 9s linear infinite -6s;

        }


        @keyframes beamMove{

            0%{

                transform:
                    translateX(-400px)
                    rotate(25deg);

                opacity:0;

            }

            25%{

                opacity:.35;

            }

            75%{

                opacity:.35;

            }

            100%{

                transform:
                    translateX(500px)
                    rotate(25deg);

                opacity:0;

            }

        }


        /* =========================================================
           RGB PARTICLES
        ========================================================= */

        .rgb-particles{

            position:fixed;

            inset:0;

            pointer-events:none;

            z-index:3;

        }


        .rgb-particles span{

            position:absolute;

            width:3px;

            height:3px;

            border-radius:50%;

            background:#fff;

            box-shadow:

                0 0 10px #fff,
                0 0 20px #255DE0,
                0 0 30px #00eaff;

            opacity:.55;

            animation:

                particleFloat linear infinite;

        }


        .rgb-particles span:nth-child(1){

            left:8%;
            top:80%;

            animation-duration:13s;

        }


        .rgb-particles span:nth-child(2){

            left:18%;
            top:40%;

            animation-duration:17s;

        }


        .rgb-particles span:nth-child(3){

            left:28%;
            top:75%;

            animation-duration:11s;

        }


        .rgb-particles span:nth-child(4){

            left:39%;
            top:25%;

            animation-duration:15s;

        }


        .rgb-particles span:nth-child(5){

            left:52%;
            top:85%;

            animation-duration:14s;

        }


        .rgb-particles span:nth-child(6){

            left:63%;
            top:30%;

            animation-duration:18s;

        }


        .rgb-particles span:nth-child(7){

            left:72%;
            top:70%;

            animation-duration:12s;

        }


        .rgb-particles span:nth-child(8){

            left:82%;
            top:25%;

            animation-duration:16s;

        }


        .rgb-particles span:nth-child(9){

            left:91%;
            top:60%;

            animation-duration:13s;

        }


        .rgb-particles span:nth-child(10){

            left:48%;
            top:55%;

            animation-duration:19s;

        }


        @keyframes particleFloat{

            0%{

                transform:
                    translateY(80px)
                    scale(.5);

                opacity:0;

            }

            20%{

                opacity:.7;

            }

            50%{

                transform:
                    translateY(-120px)
                    translateX(30px)
                    scale(1);

                opacity:.8;

            }

            100%{

                transform:
                    translateY(-350px)
                    translateX(-40px)
                    scale(.2);

                opacity:0;

            }

        }


        /* =========================================================
           ENERGY RING
        ========================================================= */

        .energy-ring{

            position:fixed;

            width:700px;

            height:700px;

            border-radius:50%;

            border:
                1px solid rgba(37,93,224,.08);

            box-shadow:

                0 0 80px
                rgba(37,93,224,.05),

                inset 0 0 80px
                rgba(155,92,255,.04);

            animation:
                ringRotate 25s linear infinite;

            pointer-events:none;

            z-index:4;

        }


        .energy-ring::before{

            content:"";

            position:absolute;

            inset:55px;

            border-radius:50%;

            border:
                1px solid rgba(0,234,255,.07);

            animation:
                ringRotateReverse 18s linear infinite;

        }


        .energy-ring::after{

            content:"";

            position:absolute;

            inset:120px;

            border-radius:50%;

            border:
                1px solid rgba(255,60,172,.06);

        }


        @keyframes ringRotate{

            to{

                transform:rotate(360deg);

            }

        }


        @keyframes ringRotateReverse{

            to{

                transform:rotate(-360deg);

            }

        }


        /* =========================================================
           MAIN SHELL
        ========================================================= */

        .shell{

            width:min(100%,460px);

            position:relative;

            z-index:20;

            animation:
                shellEnter 1s cubic-bezier(.22,1,.36,1);

        }


        @keyframes shellEnter{

            from{

                opacity:0;

                transform:
                    translateY(70px)
                    scale(.94);

            }

            to{

                opacity:1;

                transform:
                    translateY(0)
                    scale(1);

            }

        }


        /* =========================================================
           BRAND
        ========================================================= */

        .brand{

            text-align:center;

            margin-bottom:25px;

            animation:
                brandEnter 1s ease .15s both;

        }


        @keyframes brandEnter{

            from{

                opacity:0;

                transform:
                    translateY(-25px);

            }

            to{

                opacity:1;

                transform:
                    translateY(0);

            }

        }


        /* =========================================================
           CROWN
        ========================================================= */

        .crown-wrapper{

            width:82px;

            height:82px;

            margin:
                0 auto 15px;

            position:relative;

            display:grid;

            place-items:center;

        }


        .crown-glow{

            position:absolute;

            inset:0;

            border-radius:26px;

            background:

                conic-gradient(
                    from 0deg,
                    #F5D165,
                    #D29821,
                    #255DE0,
                    #9b5cff,
                    #F5D165
                );

            filter:blur(13px);

            opacity:.55;

            animation:
                crownGlow 4s linear infinite;

        }


        @keyframes crownGlow{

            50%{

                transform:
                    scale(1.12)
                    rotate(180deg);

                opacity:.8;

            }

        }


        .crown{

            position:relative;

            width:64px;

            height:64px;

            display:grid;

            place-items:center;

            border-radius:21px;

            background:

                linear-gradient(
                    145deg,
                    #ffe99b,
                    #F5D165 45%,
                    #D29821
                );

            color:#171106;

            font-size:27px;

            box-shadow:

                inset 0 1px 1px rgba(255,255,255,.7),

                0 15px 40px
                rgba(210,152,33,.30);

            z-index:2;

        }


        .crown i{

            animation:
                crownFloat 3s ease-in-out infinite;

        }


        @keyframes crownFloat{

            50%{

                transform:
                    translateY(-4px)
                    rotate(-4deg);

            }

        }


        .brand h1{

            font-size:28px;

            font-weight:800;

            letter-spacing:2px;

            text-shadow:
                0 0 25px rgba(255,255,255,.08);

        }


        .brand h1 span{

            background:

                linear-gradient(
                    135deg,
                    #F5D165,
                    #D29821
                );

            -webkit-background-clip:text;

            background-clip:text;

            color:transparent;

        }


        .brand p{

            margin-top:6px;

            color:#F5D165;

            font-size:10px;

            font-weight:700;

            letter-spacing:.35em;

            text-shadow:
                0 0 15px rgba(245,209,101,.30);

        }


        /* =========================================================
           CARD
        ========================================================= */

        .card{

            position:relative;

            overflow:hidden;

            padding:34px;

            border-radius:27px;

            background:

                linear-gradient(
                    145deg,
                    rgba(17,26,45,.82),
                    rgba(4,8,18,.76)
                );

            border:
                1px solid rgba(255,255,255,.11);

            box-shadow:

                0 35px 100px rgba(0,0,0,.65),

                0 0 80px
                rgba(37,93,224,.08),

                inset 0 1px 0
                rgba(255,255,255,.07);

            backdrop-filter:
                blur(25px);

            -webkit-backdrop-filter:
                blur(25px);

            animation:
                cardEnter 1s cubic-bezier(.22,1,.36,1) .15s both;

        }


        @keyframes cardEnter{

            from{

                opacity:0;

                transform:
                    scale(.92)
                    translateY(35px);

            }

            to{

                opacity:1;

                transform:
                    scale(1)
                    translateY(0);

            }

        }


        /* =========================================================
           ANIMATED CARD BORDER
        ========================================================= */

        .card::before{

            content:"";

            position:absolute;

            inset:0;

            padding:1px;

            border-radius:27px;

            background:

                linear-gradient(
                    120deg,
                    transparent 10%,
                    rgba(37,93,224,.7),
                    transparent 35%,
                    rgba(155,92,255,.5),
                    transparent 65%,
                    rgba(245,209,101,.6),
                    transparent 90%
                );

            background-size:300% 300%;

            animation:
                borderMove 7s linear infinite;

            -webkit-mask:

                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);

            -webkit-mask-composite:xor;

            mask-composite:exclude;

            pointer-events:none;

        }


        @keyframes borderMove{

            0%{

                background-position:
                    0% 50%;

            }

            50%{

                background-position:
                    100% 50%;

            }

            100%{

                background-position:
                    0% 50%;

            }

        }


        .card::after{

            content:"";

            position:absolute;

            width:260px;

            height:100px;

            top:-80px;

            left:50%;

            transform:
                translateX(-50%);

            background:#255DE0;

            filter:blur(70px);

            opacity:.18;

            pointer-events:none;

        }


        /* =========================================================
           INTRO
        ========================================================= */

        .intro{

            position:relative;

            z-index:2;

        }


        .intro h2{

            font-size:21px;

            font-weight:700;

            letter-spacing:-.3px;

        }


        .intro h2::after{

            content:"";

            display:block;

            width:48px;

            height:3px;

            margin-top:9px;

            border-radius:10px;

            background:

                linear-gradient(
                    90deg,
                    #F5D165,
                    #D29821,
                    transparent
                );

        }


        .intro p{

            margin:
                10px 0 25px;

            color:var(--muted);

            font-size:12px;

            line-height:1.7;

        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert{

            display:flex;

            align-items:center;

            gap:10px;

            padding:13px;

            border-radius:13px;

            margin-bottom:18px;

            font-size:12px;

            border:1px solid;

            animation:
                alertEnter .5s ease;

        }


        @keyframes alertEnter{

            from{

                opacity:0;

                transform:
                    translateY(-10px);

            }

            to{

                opacity:1;

                transform:
                    translateY(0);

            }

        }


        .alert.error{

            color:#fecdd3;

            background:
                rgba(251,113,133,.08);

            border-color:
                rgba(251,113,133,.25);

        }


        .alert.success{

            color:#bbf7d0;

            background:
                rgba(52,211,153,.08);

            border-color:
                rgba(52,211,153,.25);

        }


        /* =========================================================
           FORM
        ========================================================= */

        form{

            position:relative;

            z-index:2;

        }


        label{

            display:block;

            font-size:11px;

            font-weight:600;

            color:#dce4f0;

            margin:
                17px 0 8px;

        }


        .field{

            position:relative;

        }


        .field > i{

            position:absolute;

            left:15px;

            top:50%;

            transform:
                translateY(-50%);

            color:#F5D165;

            font-size:13px;

            z-index:3;

            transition:.25s;

        }


        .field input{

            width:100%;

            height:51px;

            padding:
                0 45px;

            border-radius:13px;

            border:
                1px solid rgba(148,163,184,.18);

            background:
                rgba(1,6,16,.68);

            color:#fff;

            font:inherit;

            font-size:12px;

            outline:none;

            transition:
                .3s ease;

            box-shadow:
                inset 0 1px 8px rgba(0,0,0,.15);

        }


        .field input::placeholder{

            color:#637189;

        }


        .field input:hover{

            border-color:
                rgba(245,209,101,.28);

        }


        .field input:focus{

            border-color:
                #F5D165;

            background:
                rgba(4,9,20,.9);

            box-shadow:

                0 0 0 3px
                rgba(245,209,101,.08),

                0 0 25px
                rgba(245,209,101,.08);

        }


        .field:focus-within > i{

            color:#ffe99b;

            text-shadow:
                0 0 12px rgba(245,209,101,.7);

            transform:
                translateY(-50%)
                scale(1.12);

        }


        /* =========================================================
           PASSWORD TOGGLE
        ========================================================= */

        .toggle{

            position:absolute;

            right:7px;

            top:7px;

            width:37px;

            height:37px;

            display:grid;

            place-items:center;

            border:0;

            border-radius:9px;

            background:
                rgba(255,255,255,.035);

            color:#7e8da4;

            cursor:pointer;

            transition:
                .25s ease;

        }


        .toggle:hover,
        .toggle:focus-visible{

            color:#F5D165;

            background:
                rgba(245,209,101,.08);

            box-shadow:
                0 0 18px
                rgba(245,209,101,.08);

            outline:none;

        }


        /* =========================================================
           SUBMIT BUTTON
        ========================================================= */

        .submit{

            position:relative;

            overflow:hidden;

            width:100%;

            height:53px;

            margin-top:25px;

            border:0;

            border-radius:14px;

            background:

                linear-gradient(
                    135deg,
                    #F5D165 0%,
                    #D29821 100%
                );

            color:#171106;

            font:
                700 12px
                Poppins,sans-serif;

            letter-spacing:.06em;

            cursor:pointer;

            transition:
                transform .25s ease,
                box-shadow .25s ease;

            box-shadow:

                0 12px 35px
                rgba(210,152,33,.15);

        }


        .submit::before{

            content:"";

            position:absolute;

            top:0;

            left:-120%;

            width:80%;

            height:100%;

            background:

                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.5),
                    transparent
                );

            transform:
                skewX(-20deg);

            animation:
                buttonShine 4s ease-in-out infinite;

        }


        @keyframes buttonShine{

            0%,
            55%{

                left:-120%;

            }

            75%,
            100%{

                left:140%;

            }

        }


        .submit:hover{

            transform:
                translateY(-3px)
                scale(1.01);

            box-shadow:

                0 15px 38px
                rgba(245,209,101,.25),

                0 0 30px
                rgba(210,152,33,.16);

        }


        .submit:active{

            transform:
                translateY(0)
                scale(.99);

        }


        .submit:disabled{

            opacity:.65;

            cursor:wait;

            transform:none;

        }


        .submit i{

            margin-right:7px;

        }


        /* =========================================================
           BACK BUTTON
        ========================================================= */

        .back{

            position:relative;

            display:flex;

            align-items:center;

            justify-content:center;

            gap:7px;

            margin-top:21px;

            color:#8492a8;

            font-size:11px;

            text-decoration:none;

            transition:
                .25s ease;

        }


        .back::after{

            content:"";

            position:absolute;

            width:0;

            height:1px;

            bottom:-5px;

            background:#F5D165;

            transition:.3s;

        }


        .back:hover{

            color:#F5D165;

            text-shadow:
                0 0 12px rgba(245,209,101,.25);

        }


        .back:hover::after{

            width:90px;

        }


        /* =========================================================
           SECURITY NOTICE
        ========================================================= */

        .notice{

            display:flex;

            justify-content:center;

            align-items:center;

            gap:7px;

            color:#59677c;

            font-size:9px;

            margin-top:19px;

            animation:
                noticePulse 4s ease-in-out infinite;

        }


        .notice i{

            color:#F5D165;

            font-size:9px;

        }


        @keyframes noticePulse{

            50%{

                opacity:.65;

            }

        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media(max-width:520px){

            body{

                padding:16px;

                overflow:auto;

            }


            .energy-ring{

                width:450px;

                height:450px;

            }


            .card{

                padding:26px 21px;

                border-radius:23px;

            }


            .card::before{

                border-radius:23px;

            }


            .brand h1{

                font-size:24px;

            }


            .brand p{

                font-size:8px;

            }

        }


        @media(max-height:760px){

            body{

                align-items:flex-start;

                padding-top:25px;

                padding-bottom:25px;

                overflow:auto;

            }

        }

    </style>

</head>


<body>


    <!-- =========================================================
         SAME ANIMATED RGB BACKGROUND AS SELLER LOGIN
    ========================================================== -->

    <div class="rgb-grid"></div>


    <div class="rgb-beam one"></div>

    <div class="rgb-beam two"></div>

    <div class="rgb-beam three"></div>


    <div class="rgb-particles">

        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>

    </div>


    <div class="energy-ring"></div>


    <!-- =========================================================
         MAIN
    ========================================================== -->

    <main class="shell">


        <!-- BRAND -->

        <div class="brand">

            <div class="crown-wrapper">

                <div class="crown-glow"></div>

                <div class="crown">

                    <i class="fas fa-crown"></i>

                </div>

            </div>


            <h1>

                SMART<span>BASKET</span>

            </h1>


            <p>

                ADMIN CONTROL CENTER

            </p>

        </div>


        <!-- =====================================================
             LOGIN CARD
        ====================================================== -->

        <section
            class="card"
            aria-labelledby="login-title"
        >


            <!-- INTRO -->

            <div class="intro">

                <h2 id="login-title">

                    Secure administrator sign in

                </h2>


                <p>

                    Use your dedicated administrator account.
                    MFA is requested when enabled.

                </p>

            </div>


            <!-- ERROR -->

            @if(session('error'))

                <div
                    class="alert error"
                    role="alert"
                >

                    <i class="fas fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <!-- SUCCESS -->

            @if(session('success'))

                <div
                    class="alert success"
                    role="status"
                >

                    <i class="fas fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            <!-- LOGIN FORM -->

            <form
                method="POST"
                action="{{ route('admin.login.submit') }}"
                id="adminLoginForm"
            >

                @csrf


                <!-- EMAIL -->

                <label for="email">

                    Administrator email

                </label>


                <div class="field">

                    <i class="fas fa-envelope"></i>

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
                        style="
                            display:block;
                            color:#fda4af;
                            margin-top:6px;
                            font-size:10px;
                        "
                    >

                        {{ $message }}

                    </small>

                @enderror


                <!-- PASSWORD -->

                <label for="password">

                    Password

                </label>


                <div class="field">

                    <i class="fas fa-lock"></i>


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

                        <i class="fas fa-eye"></i>

                    </button>

                </div>


                @error('password')

                    <small
                        style="
                            display:block;
                            color:#fda4af;
                            margin-top:6px;
                            font-size:10px;
                        "
                    >

                        {{ $message }}

                    </small>

                @enderror


                <!-- LOGIN BUTTON -->

                <button
                    class="submit"
                    type="submit"
                    id="loginButton"
                >

                    <i class="fas fa-shield-halved"></i>

                    Secure Admin Login

                </button>

            </form>


            <!-- BACK -->

            <a
                class="back"
                href="{{ url('/') }}"
            >

                <i class="fas fa-arrow-left"></i>

                Return to SmartBasket

            </a>


        </section>


        <!-- SECURITY NOTICE -->

        <p class="notice">

            <i class="fas fa-lock"></i>

            Restricted access is monitored and audited.

        </p>


    </main>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>


        /* =====================================================
           PASSWORD TOGGLE
        ====================================================== */

        const toggle =
            document.getElementById('passwordToggle');

        const password =
            document.getElementById('password');


        if(toggle && password){

            toggle.addEventListener(
                'click',
                () => {

                    const reveal =
                        password.type === 'password';


                    password.type =
                        reveal
                            ? 'text'
                            : 'password';


                    toggle.setAttribute(
                        'aria-pressed',
                        String(reveal)
                    );


                    toggle.setAttribute(
                        'aria-label',
                        reveal
                            ? 'Hide password'
                            : 'Show password'
                    );


                    toggle.firstElementChild.className =
                        reveal
                            ? 'fas fa-eye-slash'
                            : 'fas fa-eye';

                }
            );

        }


        /* =====================================================
           LOGIN BUTTON LOADING
        ====================================================== */

        const form =
            document.getElementById('adminLoginForm');

        const loginButton =
            document.getElementById('loginButton');


        if(form && loginButton){

            form.addEventListener(
                'submit',
                () => {

                    loginButton.disabled = true;


                    loginButton.innerHTML =

                        '<i class="fas fa-spinner fa-spin"></i> Signing in…';

                }
            );

        }


        /* =====================================================
           MOUSE PARALLAX
        ====================================================== */

        document.addEventListener(
            'mousemove',
            (event) => {

                const x =
                    (
                        event.clientX /
                        window.innerWidth
                    ) - 0.5;


                const y =
                    (
                        event.clientY /
                        window.innerHeight
                    ) - 0.5;


                const grid =
                    document.querySelector('.rgb-grid');


                const ring =
                    document.querySelector('.energy-ring');


                if(grid){

                    grid.style.transform =

                        `perspective(500px)
                         rotateX(${62 + y * 2}deg)
                         rotateY(${x * 3}deg)
                         scale(1.5)`;

                }


                if(ring){

                    ring.style.marginLeft =
                        `${x * 15}px`;

                    ring.style.marginTop =
                        `${y * 15}px`;

                }

            }
        );


    </script>


</body>

</html>
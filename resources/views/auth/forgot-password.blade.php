<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Forgot Password</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}


/* =========================================================
   PAGE
========================================================= */

html,
body{
    width:100%;
    min-height:100%;
}

body{

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:30px 20px;

    overflow:hidden;

    position:relative;

    background:
        radial-gradient(
            circle at 15% 15%,
            rgba(37,99,235,.28),
            transparent 32%
        ),
        radial-gradient(
            circle at 85% 85%,
            rgba(6,182,212,.20),
            transparent 32%
        ),
        linear-gradient(
            135deg,
            #020617,
            #050816,
            #020617
        );

    color:#fff;
}


/* =========================================================
   ANIMATED BACKGROUND LIGHTS
========================================================= */

body::before{

    content:"";

    position:fixed;

    width:520px;
    height:520px;

    left:-230px;
    top:-220px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(37,99,235,.45),
            rgba(37,99,235,.10) 40%,
            transparent 72%
        );

    filter:blur(20px);

    animation:
        blueFloat 8s ease-in-out infinite;

    pointer-events:none;

}


body::after{

    content:"";

    position:fixed;

    width:600px;
    height:600px;

    right:-280px;
    bottom:-300px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(14,165,233,.38),
            rgba(59,130,246,.08) 45%,
            transparent 72%
        );

    filter:blur(25px);

    animation:
        blueFloatReverse 10s ease-in-out infinite;

    pointer-events:none;

}


@keyframes blueFloat{

    0%,
    100%{
        transform:translate(0,0) scale(1);
    }

    50%{
        transform:translate(100px,80px) scale(1.15);
    }

}


@keyframes blueFloatReverse{

    0%,
    100%{
        transform:translate(0,0) scale(1);
    }

    50%{
        transform:translate(-100px,-80px) scale(1.12);
    }

}


/* =========================================================
   PAGE LAYER
========================================================= */

body{
    isolation:isolate;
}

body > *{
    position:relative;
    z-index:2;
}

body > .forgot-box{
    z-index:10;
}


/* =========================================================
   MOVING LIGHT
========================================================= */

body > .forgot-box::before{

    content:"";

    position:absolute;

    width:8px;
    height:8px;

    border-radius:50%;

    background:#fff;

    box-shadow:
        0 0 10px #fff,
        0 0 25px #38bdf8;

    top:-120px;
    left:-180px;

    animation:
        starMove 7s linear infinite;

    pointer-events:none;

}


@keyframes starMove{

    0%{
        transform:translate(0,0);
        opacity:0;
    }

    15%{
        opacity:1;
    }

    50%{
        transform:translate(800px,500px);
        opacity:.8;
    }

    100%{
        transform:translate(1200px,750px);
        opacity:0;
    }

}


/* =========================================================
   FORGOT PASSWORD CARD
========================================================= */

.forgot-box{

    width:430px;

    max-width:100%;

    padding:42px 40px;

    border-radius:32px;

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            145deg,
            rgba(15,23,42,.96),
            rgba(3,7,18,.96)
        );

    border:
        1px solid rgba(59,130,246,.38);

    box-shadow:

        0 35px 100px rgba(0,0,0,.65),

        0 0 45px rgba(37,99,235,.16),

        inset 0 1px 0 rgba(255,255,255,.08);

    backdrop-filter:blur(28px);

    -webkit-backdrop-filter:blur(28px);

    animation:
        cardShow .8s cubic-bezier(.2,.8,.2,1);

}


/* =========================================================
   TOP LIGHT LINE
========================================================= */

.forgot-box::after{

    content:"";

    position:absolute;

    top:0;

    left:8%;

    right:8%;

    height:2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #2563eb,
            #38bdf8,
            #60a5fa,
            transparent
        );

    box-shadow:
        0 0 18px rgba(59,130,246,.9);

    animation:
        linePulse 3s ease-in-out infinite;

}


@keyframes linePulse{

    0%,
    100%{
        opacity:.45;
    }

    50%{
        opacity:1;
    }

}


@keyframes cardShow{

    from{

        opacity:0;

        transform:
            translateY(45px)
            scale(.94);

        filter:blur(5px);

    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);

        filter:blur(0);

    }

}


/* =========================================================
   LOGO
========================================================= */

.logo{

    text-align:center;

}


/* LOGO ICON */

.logo-icon{

    height:88px;

    width:88px;

    margin:0 auto;

    border-radius:27px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:42px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #0ea5e9
        );

    border:
        1px solid rgba(255,255,255,.25);

    box-shadow:

        0 0 30px rgba(37,99,235,.45),

        0 0 70px rgba(14,165,233,.20),

        inset 0 1px 0 rgba(255,255,255,.30);

    animation:
        logoFloat 3.5s ease-in-out infinite;

}


@keyframes logoFloat{

    0%,
    100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-7px);
    }

}


/* =========================================================
   SMART BASKET TITLE
========================================================= */

.forgot-box h1{

    margin-top:19px;

    text-align:center;

    font-size:32px;

    font-weight:800;

    letter-spacing:-.7px;

    color:#ffffff !important;

}


.forgot-box h1 span{

    color:#38bdf8 !important;

    text-shadow:
        0 0 18px rgba(56,189,248,.25);

}


/* =========================================================
   SUBTITLE
========================================================= */

.subtitle{

    text-align:center;

    color:#94a3b8;

    font-size:11px;

    font-weight:600;

    letter-spacing:2.4px;

    margin:9px 0 31px;

}


/* =========================================================
   SUCCESS MESSAGE
========================================================= */

.success-message{

    display:flex;

    align-items:center;

    gap:10px;

    padding:13px 15px;

    margin-bottom:20px;

    border-radius:15px;

    color:#93c5fd;

    background:
        rgba(37,99,235,.10);

    border:
        1px solid rgba(59,130,246,.25);

    font-size:12px;

    line-height:1.5;

    animation:
        messageShow .45s ease;

}


.success-message i{

    color:#38bdf8;

    font-size:15px;

}


@keyframes messageShow{

    from{
        opacity:0;
        transform:translateY(-8px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}


/* =========================================================
   INPUT AREA
========================================================= */

.input-box{

    margin-bottom:22px;

    position:relative;

}


.input-box label{

    display:block;

    margin-bottom:9px;

    padding-left:4px;

    color:#cbd5e1;

    font-size:11px;

    font-weight:700;

    letter-spacing:.7px;

    text-transform:uppercase;

}


.input-box label i{

    color:#38bdf8;

    margin-right:6px;

}


.input-box input{

    width:100%;

    height:58px;

    padding:0 19px;

    border:none;

    outline:none;

    border-radius:18px;

    background:
        rgba(255,255,255,.065);

    border:
        1px solid rgba(148,163,184,.14);

    color:#fff;

    font-size:14px;

    transition:.25s ease;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.03);

}


.input-box input::placeholder{

    color:#64748b;

}


.input-box input:hover{

    border-color:
        rgba(59,130,246,.35);

}


.input-box input:focus{

    border-color:
        rgba(56,189,248,.75);

    background:
        rgba(37,99,235,.075);

    box-shadow:

        0 0 0 4px
        rgba(37,99,235,.10),

        0 12px 30px
        rgba(0,0,0,.18);

}


/* =========================================================
   SEND OTP BUTTON
========================================================= */

button{

    width:100%;

    height:58px;

    border:none;

    border-radius:18px;

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            110deg,
            #2563eb,
            #0ea5e9
        );

    color:#fff;

    font-size:15px;

    font-weight:800;

    letter-spacing:.2px;

    cursor:pointer;

    transition:.25s ease;

    box-shadow:
        0 12px 30px
        rgba(37,99,235,.28);

}


button::before{

    content:"";

    position:absolute;

    top:0;

    left:-120%;

    width:75%;

    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.30),
            transparent
        );

    transform:skewX(-20deg);

    transition:left .65s ease;

}


button:hover{

    transform:translateY(-2px);

    box-shadow:
        0 18px 40px
        rgba(37,99,235,.40);

}


button:hover::before{

    left:145%;

}


button:active{

    transform:translateY(0) scale(.98);

}


/* =========================================================
   BACK
========================================================= */

.back{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:5px;

    margin-top:24px;

    color:#94a3b8;

    font-size:12px;

}


.back a{

    color:#38bdf8;

    text-decoration:none;

    font-weight:700;

    transition:.2s ease;

}


.back a:hover{

    color:#fff;

    text-shadow:
        0 0 12px rgba(56,189,248,.7);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:500px){

    body{

        padding:20px 15px;

        overflow-y:auto;

    }


    .forgot-box{

        width:100%;

        padding:34px 24px;

        border-radius:27px;

    }


    .logo-icon{

        width:78px;

        height:78px;

        border-radius:23px;

        font-size:36px;

    }


    .forgot-box h1{

        font-size:28px;

    }


    .subtitle{

        font-size:9px;

        letter-spacing:1.8px;

        margin-bottom:27px;

    }


    .input-box input{

        height:55px;

    }


    button{

        height:55px;

    }

}


@media(max-height:650px){

    body{

        align-items:flex-start;

        padding-top:20px;

        overflow-y:auto;

    }

}

</style>

</head>


<body>

<x-site-menu />


<div class="forgot-box">


    @if(session('success'))

        <div class="success-message">

            <i class="fa-solid fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <div class="logo">


        <div class="logo-icon">
            🛒
        </div>


        <h1>
            SMART <span>BASKET</span>
        </h1>


        <div class="subtitle">
            PASSWORD RECOVERY SYSTEM
        </div>


    </div>


    <form method="POST" action="{{ route('send.otp') }}">

        @csrf


        <div class="input-box">

            <label for="email">

                <i class="fa-solid fa-envelope"></i>

                Registered Email

            </label>


            <input
                id="email"
                type="email"
                name="email"
                placeholder="Enter Registered Email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >

        </div>


        <button type="submit">

            <i class="fa-solid fa-paper-plane"></i>

            &nbsp; SEND OTP

        </button>


    </form>


    <div class="back">

        Remember Password?

        <a href="{{ route('login') }}">

            Login

        </a>

    </div>


</div>


</body>

</html>
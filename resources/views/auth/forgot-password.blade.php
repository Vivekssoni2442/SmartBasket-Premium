<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Forgot Password</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}


/* =========================================================
   PAGE
========================================================= */

body{

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    overflow:hidden;

    position:relative;

    background:
        linear-gradient(
            135deg,
            #020617,
            #000,
            #111827
        );

}


/* =========================================================
   BACKGROUND GLOW
========================================================= */

body::before{

    content:"";

    position:absolute;

    width:650px;
    height:650px;

    background:#FFD700;

    opacity:.18;

    filter:blur(160px);

    top:-250px;
    left:-250px;

}


body::after{

    content:"";

    position:absolute;

    width:650px;
    height:650px;

    background:#ff9900;

    opacity:.15;

    filter:blur(160px);

    bottom:-250px;
    right:-250px;

}


/* =========================================================
   FORGOT PASSWORD CARD
========================================================= */

.forgot-box{

    width:430px;

    padding:45px;

    border-radius:35px;

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(25px);

    -webkit-backdrop-filter:blur(25px);

    border:1px solid rgba(255,215,0,.35);

    box-shadow:
        0 0 60px rgba(255,215,0,.25);

    position:relative;

    z-index:5;

    animation:show 1s ease;

}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes show{

    from{

        opacity:0;

        transform:translateY(100px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}


/* =========================================================
   LOGO
========================================================= */

.logo{

    text-align:center;

}


.logo-icon{

    height:95px;

    width:95px;

    margin:auto;

    border-radius:30px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:45px;

    background:
        linear-gradient(
            135deg,
            #FFD700,
            #ff9900
        );

    box-shadow:
        0 0 40px #FFD700;

}


/* =========================================================
   SMART BASKET TITLE
   SMART = WHITE
   BASKET = YELLOW
========================================================= */

.forgot-box h1{

    margin-top:20px;

    text-align:center;

    font-size:36px;

    font-weight:800;

    color:#ffffff !important;

}


.forgot-box h1 span{

    color:#FFD700 !important;

}


/* =========================================================
   SUBTITLE
========================================================= */

.subtitle{

    text-align:center;

    color:#ccc;

    font-size:13px;

    letter-spacing:2px;

    margin:10px 0 35px;

}


/* =========================================================
   INPUT
========================================================= */

.input-box{

    margin-bottom:25px;

}


.input-box input{

    width:100%;

    height:58px;

    padding:0 20px;

    border:none;

    outline:none;

    border-radius:20px;

    background:rgba(255,255,255,.12);

    color:white;

    font-size:15px;

}


.input-box input::placeholder{

    color:#aaa;

}


.input-box input:focus{

    background:rgba(255,255,255,.15);

    box-shadow:
        0 0 0 2px rgba(255,215,0,.20);

}


/* =========================================================
   BUTTON
========================================================= */

button{

    width:100%;

    height:58px;

    border:none;

    border-radius:22px;

    background:
        linear-gradient(
            135deg,
            #FFD700,
            #ff9900
        );

    color:#000;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:.3s;

}


button:hover{

    transform:scale(1.05);

    box-shadow:
        0 0 35px #FFD700;

}


/* =========================================================
   BACK
========================================================= */

.back{

    text-align:center;

    margin-top:25px;

    color:#ccc;

}


.back a{

    color:#FFD700;

    text-decoration:none;

    font-weight:600;

}


.back a:hover{

    color:#ffffff;

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:500px){

    .forgot-box{

        width:calc(100% - 30px);

        padding:35px 25px;

    }

    .forgot-box h1{

        font-size:30px;

    }

}

</style>

</head>


<body>
<x-site-menu />


<div class="forgot-box">


    @if(session('success'))

        <div style="
            color:#FFD700;
            text-align:center;
            margin-bottom:20px;
            font-weight:600;
        ">
            {{ session('success') }}
        </div>

    @endif


    <div class="logo">


        <div class="logo-icon">
            🔐
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

            <input
                type="email"
                name="email"
                placeholder="Enter Registered Email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >

        </div>


        <button type="submit">
            SEND OTP
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

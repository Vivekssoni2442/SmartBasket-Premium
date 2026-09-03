<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    background:
        linear-gradient(
            135deg,
            #020617,
            #000,
            #111827
        );

    overflow:hidden;

    position:relative;
}


/* =========================================================
   BACKGROUND GLOW
========================================================= */

body::before{

    content:"";

    position:absolute;

    width:500px;
    height:500px;

    background:#FFD700;

    opacity:.15;

    filter:blur(150px);

    top:-150px;
    left:-150px;

    pointer-events:none;
}


body::after{

    content:"";

    position:absolute;

    width:500px;
    height:500px;

    background:#00ff99;

    opacity:.10;

    filter:blur(150px);

    right:-150px;
    bottom:-150px;

    pointer-events:none;
}


/* =========================================================
   LOGIN CARD
========================================================= */

.login-container{

    width:420px;

    padding:40px;

    border-radius:30px;

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(25px);

    border:1px solid rgba(255,215,0,.3);

    box-shadow:
        0 0 50px rgba(255,215,0,.25);

    position:relative;

    z-index:10;

    animation:show 1s ease;
}


@keyframes show{

    from{

        opacity:0;

        transform:translateY(80px);

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


.logo-circle{

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
            #FFD700,
            #ff9900
        );

    box-shadow:
        0 0 40px #FFD700;
}


.logo h1{

    margin-top:20px;

    color:#ffffff;

    font-size:38px;

    font-weight:800;

    letter-spacing:3px;
}


.logo span{

    color:#FFD700 !important;
}


.logo p{

    color:#cccccc;

    font-size:13px;

    margin:10px 0 35px;
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

    background:rgba(255,255,255,.12);

    color:#ffffff;

    font-size:15px;
}


.input-box input::placeholder{

    color:#aaaaaa;
}


.input-box input:focus{

    background:rgba(255,255,255,.15);

    box-shadow:
        0 0 0 1px rgba(255,215,0,.30);
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


.options a{

    color:#FFD700;

    text-decoration:none;

    font-weight:600;

}


.options a:hover{

    color:#ffffff;
}


.remember-option{

    display:flex;

    align-items:center;

    gap:8px;

    cursor:pointer;
}


.remember-option input[type="checkbox"]{

    width:16px;

    height:16px;

    margin:0;

    accent-color:#3B82F6;

    cursor:pointer;
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
            #FFD700,
            #ff9900
        );

    color:#000000;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:.3s ease;
}


button:hover{

    transform:scale(1.05);

    box-shadow:
        0 0 30px #FFD700;
}


/* =========================================================
   REGISTER
========================================================= */

.register{

    text-align:center;

    color:#cccccc;

    margin-top:25px;

    font-size:14px;
}


.register a{

    color:#FFD700;

    text-decoration:none;

    font-weight:700;
}


.register a:hover{

    color:#ffffff;
}


/* =========================================================
   SELLER LOGIN BUTTON
   NORMAL:
   RGB(20, 21, 24)

   HOVER:
   RGB(255, 173, 0)
========================================================= */

.seller-login{

    width:100%;

    margin-top:20px;

    padding:0;

    text-align:center;

    background:rgb(20,21,24) !important;

    background-color:rgb(20,21,24) !important;

    background-image:none !important;

    border:1px solid rgba(255,255,255,.10) !important;

    border-radius:20px !important;

    overflow:hidden;

    box-shadow:
        0 8px 25px rgba(0,0,0,.35);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


/* Seller Login Link */

.seller-login a{

    display:flex !important;

    width:100%;

    min-height:55px;

    align-items:center;

    justify-content:center;

    padding:10px 20px;

    background:rgb(20,21,24) !important;

    background-color:rgb(20,21,24) !important;

    background-image:none !important;

    color:#ffffff !important;

    border:none !important;

    border-radius:20px;

    font-size:14px;

    font-weight:700;

    text-decoration:none !important;

    cursor:pointer;

    transition:
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}


/* =========================================================
   IMPORTANT:
   ONLY WHEN CURSOR IS ON SELLER LOGIN
========================================================= */

.seller-login:hover{

    background:rgb(55, 230, 67) !important;

    background-color:rgb(55, 230, 67) !important;

    background-image:none !important;

    border-color:rgb(255,173,0) !important;

    box-shadow:
        0 0 30px rgba(255,173,0,.45) !important;
}


.seller-login:hover a{

    background:rgb(0, 214, 126) !important;

    background-color:rgb(0, 214, 126) !important;

    background-image:none !important;

    color:#000000 !important;

    box-shadow:none !important;

    transform:none !important;
}


/* =========================================================
   ADMIN LOGIN BUTTON
========================================================= */

.admin-login{

    width:100%;

    margin-top:12px;

    padding:0;

    text-align:center;

    background:rgb(20,21,24) !important;

    background-color:rgb(20,21,24) !important;

    background-image:none !important;

    border:1px solid rgba(147,51,234,.25) !important;

    border-radius:20px !important;

    overflow:hidden;

    box-shadow:
        0 8px 25px rgba(0,0,0,.35);

    transition:
        background .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


/* Admin Login Link */

.admin-login a{

    display:flex !important;

    width:100%;

    min-height:55px;

    align-items:center;

    justify-content:center;

    padding:10px 20px;

    background:rgb(20,21,24) !important;

    background-color:rgb(20,21,24) !important;

    background-image:none !important;

    color:#ffffff !important;

    border:none !important;

    border-radius:20px;

    font-size:14px;

    font-weight:700;

    text-decoration:none !important;

    cursor:pointer;

    transition:
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}


/* Admin Login Hover */

.admin-login:hover{

    background:rgb(147,51,234) !important;

    background-color:rgb(147,51,234) !important;

    background-image:none !important;

    border-color:rgb(168,85,247) !important;

    box-shadow:
        0 0 30px rgba(147,51,234,.45) !important;
}


.admin-login:hover a{

    background:rgb(147,51,234) !important;

    background-color:rgb(147,51,234) !important;

    background-image:none !important;

    color:#ffffff !important;

    box-shadow:none !important;

    transform:none !important;
}


/* =========================================================
   SESSION ERROR
========================================================= */

.login-error{

    background:#ff000033;

    color:#ff6b6b;

    padding:12px;

    border-radius:10px;

    text-align:center;

    margin-bottom:20px;

    font-weight:600;
}


/* =========================================================
   SESSION SUCCESS
========================================================= */

.login-success{

    background:#00ff9933;

    color:#00ff99;

    padding:12px;

    border-radius:10px;

    text-align:center;

    margin-bottom:20px;

    font-weight:600;
}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:500px){

    .login-container{

        width:calc(100% - 30px);

        padding:30px 25px;

    }

    .logo h1{

        font-size:30px;

    }

}

</style>

</head>


<body>
<x-site-menu />


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


    <!-- LOGIN FORM -->

    <div class="form-box">

        <form method="POST" action="{{ route('login.submit') }}">

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

            <div class="register">

                Don't have an account?

                <a href="{{ url('/register') }}">
                    Create Account
                </a>

            </div>


            <!-- SELLER LOGIN -->

            <div class="seller-login">

                <a href="{{ url('/seller-login') }}">
                    🛒 Seller Login
                </a>

            </div>


            <!-- ADMIN LOGIN -->

            <div class="admin-login">

                <a href="{{ route('admin.login') }}">
                    👑 Admin Login
                </a>

            </div>


        </form>

    </div>


</div>


</body>

</html>

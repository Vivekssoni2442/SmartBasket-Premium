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
        linear-gradient(
            135deg,
            #020617 0%,
            #000000 50%,
            #111827 100%
        );
}


/* =========================================================
   BACKGROUND GLOW
========================================================= */

body::before{

    content:"";

    position:absolute;

    width:500px;
    height:500px;

    background:#00ff99;

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

    background:#FFD700;

    opacity:.15;

    filter:blur(150px);

    right:-150px;
    bottom:-150px;

    pointer-events:none;
}


/* =========================================================
   SELLER LOGIN CARD
   EXACT BACKGROUND = RGB(20, 21, 24)
========================================================= */

.card{

    width:420px;

    padding:40px;

    border-radius:30px;

    background:rgb(20, 21, 24) !important;

    background-color:rgb(20, 21, 24) !important;

    background-image:none !important;

    backdrop-filter:none !important;

    -webkit-backdrop-filter:none !important;

    border:1px solid rgba(0,255,153,.5);

    box-shadow:
        0 0 50px rgba(0,255,153,.4);

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

        transform:translateY(60px) scale(.96);

    }

    to{

        opacity:1;

        transform:translateY(0) scale(1);

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
            #00ff99,
            #00cc77
        );

    box-shadow:
        0 0 40px rgba(0,255,153,.45);

}


/* =========================================================
   TITLE
   SELLER = WHITE
   LOGIN = YELLOW
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

    color:#FFD700 !important;

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

    background:rgba(0,255,153,.15);

    color:#00ff99;

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

}


.input-box input:focus{

    background:rgba(255,255,255,.12);

    box-shadow:
        0 0 0 1px rgba(0,255,153,.40);

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

    accent-color:#00ff99;

}


/* =========================================================
   FORGOT PASSWORD
========================================================= */

.forgot-link{

    color:#00ff99 !important;

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
            #00ff99,
            #00cc77
        );

    color:#000000;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:.3s;

}


button:hover{

    transform:scale(1.03);

    box-shadow:
        0 0 30px rgba(0,255,153,.50);

}


/* =========================================================
   CUSTOMER LOGIN
   DEFAULT = WHITE
   MOUSE/CURSOR = RGB(255, 173, 0)
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


/* MOUSE / CURSOR LANE PAR */

.back:hover{

    background:rgb(255,173,0) !important;

    color:#000000 !important;

    border-color:rgb(255,173,0) !important;

    box-shadow:
        0 0 30px rgba(255,173,0,.45);

    transform:translateY(-1px);

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

}

</style>

</head>


<body>
<x-site-menu />


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


    <!-- CUSTOMER LOGIN -->

    <a
        class="back"
        href="{{ url('/login') }}"
    >
        ← Customer Login
    </a>


</div>


</body>

</html>

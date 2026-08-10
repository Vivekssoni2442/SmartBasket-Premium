<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Seller Login</title>


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
linear-gradient(135deg,#020617,#000,#111827);

overflow:hidden;

}



/* Background Glow */

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

}



/* Seller Card */

.card{

width:420px;

padding:40px;

border-radius:30px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);

border:1px solid rgba(0,255,153,.5);

box-shadow:0 0 50px rgba(0,255,153,.4);

position:relative;

z-index:5;

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



/* Logo */

.logo{

width:95px;

height:95px;

margin:auto;

border-radius:30px;

display:flex;

justify-content:center;

align-items:center;

font-size:45px;

background:linear-gradient(135deg,#00ff99,#00cc77);

box-shadow:0 0 40px #00ff99;

}



h1{

text-align:center;

margin-top:25px;

color:white;

font-size:35px;

letter-spacing:2px;

}



h1 span{

color:#00ff99;

}



.subtitle{

text-align:center;

color:#ccc;

font-size:13px;

margin:10px 0 35px;

}



/* Input */


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

color:white;

font-size:15px;

}



.input-box input::placeholder{

color:#aaa;

}



/* Button */


button{


width:100%;

height:55px;

border:none;

border-radius:20px;

background:linear-gradient(135deg,#00ff99,#00cc77);

font-size:18px;

font-weight:700;

cursor:pointer;

transition:.3s;

}



button:hover{

transform:scale(1.05);

box-shadow:0 0 30px #00ff99;

}



/* Back */


.back{

display:block;

text-align:center;

margin-top:25px;

color:#FFD700;

text-decoration:none;

font-weight:600;

}




/* Success Popup */


.success-popup{


position:fixed;

top:50%;

left:50%;

transform:translate(-50%,-50%);

width:360px;

padding:35px;

border-radius:30px;

background:rgba(255,255,255,.12);

backdrop-filter:blur(25px);

box-shadow:0 0 50px #00ff99;

text-align:center;

color:white;

z-index:100;

animation:popup .5s ease;

}



.check{

width:85px;

height:85px;

margin:auto;

border-radius:50%;

background:#00ff99;

color:black;

font-size:55px;

display:flex;

align-items:center;

justify-content:center;

font-weight:bold;

}



.success-popup h2{

margin-top:20px;

color:#00ff99;

}



.success-popup p{

color:#ddd;

margin-top:10px;

}



@keyframes popup{

from{

opacity:0;

transform:translate(-50%,-50%) scale(.5);

}

to{

opacity:1;

transform:translate(-50%,-50%) scale(1);

}

}


</style>


    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>



<body>



<div class="card">



<div class="logo">

🏪

</div>



<h1>

SELLER <span>LOGIN</span>

</h1>



<div class="subtitle">

SMART BASKET SELLER PANEL

</div>



<form method="POST" action="{{ route('seller.login.submit') }}">

    @csrf

    <div class="input-box">
        <input
            type="email"
            name="email"
            placeholder="Enter Seller Email"
            required
        >
    </div>

    <div class="input-box">
        <input
            type="password"
            name="password"
            placeholder="Enter Password"
            required
        >
    </div>

    <button type="submit">
        LOGIN AS SELLER
    </button>

</form>



<a class="back" href="{{url('/login')}}">

← Customer Login

</a>



</div>







</body>

</html>

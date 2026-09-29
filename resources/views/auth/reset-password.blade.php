<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | New Password</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

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
linear-gradient(135deg,#020617,#06152e,#000814,#0a192f);

overflow:hidden;

position:relative;

}


/* BLUE BACKGROUND GLOW */

body:before{

content:"";

position:absolute;

width:600px;
height:600px;

background:#1687ff;

opacity:.15;

filter:blur(150px);

top:-200px;
left:-200px;

}


/* PASSWORD CARD */

.password-box{

width:430px;

padding:45px;

border-radius:35px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);
-webkit-backdrop-filter:blur(25px);

border:1px solid rgba(30,144,255,.30);

box-shadow:
0 0 60px rgba(0,119,255,.20);

text-align:center;

color:white;

position:relative;

z-index:2;

animation:show 1s ease;

}


/* CARD ANIMATION */

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


/* LOGO */

.logo{

font-size:55px;

width:85px;
height:85px;

margin:auto;

display:flex;

justify-content:center;
align-items:center;

border-radius:25px;

background:
linear-gradient(135deg,#1687ff,#0066ff);

box-shadow:
0 0 35px rgba(0,132,255,.40);

}


/* TITLE */

h1{

font-size:35px;

font-weight:800;

margin:20px 0 15px;

color:#ffffff;

}


/* SMART BASKET BLUE */

span{

color:#1687ff;

}


/* DESCRIPTION */

p{

color:#d1d5db;

margin-bottom:30px;

font-size:14px;

}


/* ERROR MESSAGE */

.error-message{

color:#ff6b6b;

text-align:center;

margin-bottom:20px;

font-size:14px;

}


/* INPUT */

input{

width:100%;

height:58px;

margin-bottom:20px;

border:none;

outline:none;

border-radius:20px;

padding:0 20px;

background:rgba(255,255,255,.12);

border:1px solid rgba(255,255,255,.08);

color:white;

font-size:16px;

transition:.25s;

}


/* PLACEHOLDER */

input::placeholder{

color:#64748b;

}


/* INPUT FOCUS */

input:focus{

background:rgba(255,255,255,.16);

border-color:#1687ff;

box-shadow:
0 0 0 3px rgba(22,135,255,.12);

}


/* SAVE PASSWORD BUTTON */

button{

width:100%;

height:58px;

border:none;

border-radius:22px;

background:
linear-gradient(135deg,#1687ff,#0066ff);

color:white;

font-size:18px;

font-weight:700;

cursor:pointer;

transition:.3s;

box-shadow:
0 10px 30px rgba(0,102,255,.25);

}


/* BUTTON HOVER */

button:hover{

transform:scale(1.05);

box-shadow:
0 0 35px rgba(22,135,255,.65);

}


/* BUTTON CLICK */

button:active{

transform:scale(.98);

}


/* MOBILE */

@media(max-width:500px){

.password-box{

width:calc(100% - 30px);

padding:35px 25px;

}

h1{

font-size:30px;

}

.logo{

width:75px;
height:75px;

font-size:42px;

}

}

</style>

<link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">

</head>


<body>

<x-site-menu />


<div class="password-box">


<div class="logo">
🔐
</div>


<h1>
SMART <span>BASKET</span>
</h1>


<p>
Create your new password
</p>


@if($errors->any())

<div class="error-message">

{{ $errors->first() }}

</div>

@endif


<form method="POST" action="{{ route('reset.password.submit') }}">

@csrf


<input 
type="password"
name="password"
placeholder="Enter New Password"
required>


<input 
type="password"
name="password_confirmation"
placeholder="Confirm New Password"
required>


<button type="submit">

SAVE PASSWORD

</button>


</form>


</div>


</body>

</html>
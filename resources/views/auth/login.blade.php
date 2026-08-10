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
linear-gradient(135deg,#020617,#000,#111827);

overflow:hidden;

position:relative;

}



/* Glow */

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

}



/* Card */

.login-container{

width:420px;

padding:40px;

border-radius:30px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);

border:1px solid rgba(255,215,0,.3);

box-shadow:0 0 50px rgba(255,215,0,.25);

position:relative;

z-index:10;

animation:show 1s;

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

background:linear-gradient(135deg,#FFD700,#ff9900);

box-shadow:0 0 40px #FFD700;

}



.logo h1{

margin-top:20px;

color:white;

font-size:38px;

font-weight:800;

letter-spacing:3px;

}



.logo span{

color:#FFD700;

}



.logo p{

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



/* Options */


.options{

display:flex;

justify-content:space-between;

color:white;

font-size:13px;

margin-bottom:25px;

}


.options a{

color:#FFD700;

text-decoration:none;

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



/* Button */


button{

width:100%;

height:55px;

border:none;

border-radius:20px;

background:linear-gradient(135deg,#FFD700,#ff9900);

font-size:18px;

font-weight:700;

cursor:pointer;

transition:.3s;

}



button:hover{

transform:scale(1.05);

box-shadow:0 0 30px #FFD700;

}



/* Register */


.register{

text-align:center;

color:#ccc;

margin-top:25px;

font-size:14px;

}


.register a{

color:#FFD700;

text-decoration:none;

font-weight:700;

}



/* Seller */

.seller-login{

text-align:center;

margin-top:20px;

}



.seller-login a{

display:inline-block;

color:#00ff99;

font-weight:700;

text-decoration:none;

border:1px solid #00ff99;

padding:10px 25px;

border-radius:20px;

transition:.3s;

}



.seller-login a:hover{

background:#00ff99;

color:black;

box-shadow:0 0 25px #00ff99;

transform:scale(1.05);

}



</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>



<body>


<div class="login-container">


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

@if(session('error'))

<div style="
background:#ff000033;
color:#ff6b6b;
padding:12px;
border-radius:10px;
text-align:center;
margin-bottom:20px;
font-weight:600;
">
{{ session('error') }}
</div>

@endif


@if(session('success'))

<div style="
background:#00ff9933;
color:#00ff99;
padding:12px;
border-radius:10px;
text-align:center;
margin-bottom:20px;
font-weight:600;
">
{{ session('success') }}
</div>

@endif
<div class="form-box">

<form method="POST" action="{{ route('login.submit') }}">

@csrf


<div class="input-box">

<input 
type="email" 
name="email"
placeholder="Enter Email Address"
required>

</div>



<div class="input-box">

<input 
type="password"
name="password"
placeholder="Enter Password"
required>

</div>



<div class="options">

<label class="remember-option">

<input type="checkbox" name="remember" value="1">

Remember Me

</label>


<a href="{{ url('/forgot-password') }}">
Forgot Password?
</a>


</div>



<button type="submit">
LOGIN
</button>



<div class="register">

Don't have an account?

<a href="{{ url('/register') }}">
Create Account
</a>

</div>



<div class="seller-login">

<a href="{{ url('/seller-login') }}">

🛒 Seller Login

</a>

</div>


</form>

</div>


</div>



<script>


function login(){

alert("Welcome to SMART BASKET");

}



</script>


</body>

</html>

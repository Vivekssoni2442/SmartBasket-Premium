<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>KDP SMART MART | Success</title>

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
linear-gradient(135deg,#020617,#000,#111827);

}


.success-box{

width:430px;

padding:50px 40px;

border-radius:35px;

text-align:center;

color:white;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);

border:1px solid rgba(255,215,0,.35);

box-shadow:0 0 60px rgba(255,215,0,.25);

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



.check{

height:100px;

width:100px;

margin:auto;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

font-size:55px;

background:linear-gradient(135deg,#FFD700,#ff9900);

box-shadow:0 0 40px #FFD700;

}



h1{

margin-top:25px;

font-size:32px;

font-weight:800;

}


span{

color:#FFD700;

}



p{

color:#ccc;

margin:20px 0 35px;

}



a{

display:block;

height:55px;

line-height:55px;

border-radius:20px;

background:linear-gradient(135deg,#FFD700,#ff9900);

color:#000;

text-decoration:none;

font-weight:700;

font-size:18px;

transition:.3s;

}


a:hover{

transform:scale(1.05);

box-shadow:0 0 35px #FFD700;

}


</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body>
<x-site-menu />


<div class="success-box">


<div class="check">
✓
</div>


<h1>
SMART <span>BASKET</span>
</h1>


<p>
Your password has been changed successfully.
<br>
You can now login with your new password.
</p>



<a href="{{ route('login') }}">
GO TO LOGIN
</a>


</div>


</body>

</html>

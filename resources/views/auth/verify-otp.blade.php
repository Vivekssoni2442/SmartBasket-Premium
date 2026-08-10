<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Verify OTP</title>

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

overflow:hidden;

}


body:before{

content:"";

position:absolute;

width:600px;
height:600px;

background:#FFD700;

opacity:.15;

filter:blur(150px);

top:-200px;
left:-200px;

}



.otp-box{

width:420px;

padding:45px;

border-radius:35px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);

border:1px solid rgba(255,215,0,.3);

box-shadow:0 0 50px rgba(255,215,0,.25);

text-align:center;

color:white;

position:relative;

z-index:2;

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



.logo{

font-size:50px;

}



h1{

margin-top:20px;

font-size:35px;

font-weight:800;

}



span{

color:#FFD700;

}


p{

color:#ccc;

margin:15px 0 30px;

font-size:14px;

}



input{

width:100%;

height:60px;

border:none;

outline:none;

border-radius:20px;

background:rgba(255,255,255,.15);

color:white;

font-size:22px;

text-align:center;

letter-spacing:10px;

}



button{

margin-top:25px;

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



</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body>


<div class="otp-box">


<div class="logo">
🛒
</div>


<h1>
SMART <span>BASKET</span>
</h1>


<p>
Enter the OTP sent to your email
</p>



<form method="POST" action="{{ route('verify.otp') }}">

@csrf


<input 
type="text"
name="otp"
maxlength="6"
placeholder="000000"
required>



<button type="submit">

VERIFY OTP

</button>


</form>


</div>


</body>

</html>

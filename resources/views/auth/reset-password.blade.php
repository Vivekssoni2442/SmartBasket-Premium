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
linear-gradient(135deg,#020617,#000,#111827);

}


.password-box{

width:430px;
padding:45px;

border-radius:35px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(25px);

border:1px solid rgba(255,215,0,.35);

box-shadow:0 0 60px rgba(255,215,0,.25);

text-align:center;

color:white;

}


.logo{

font-size:55px;

}


h1{

font-size:35px;
font-weight:800;

margin:15px 0;

}


span{

color:#FFD700;

}


p{

color:#ccc;

margin-bottom:30px;

}


input{

width:100%;
height:58px;

margin-bottom:20px;

border:none;
outline:none;

border-radius:20px;

padding:0 20px;

background:rgba(255,255,255,.15);

color:white;

font-size:16px;

}


input::placeholder{

color:#aaa;

}



button{

width:100%;

height:58px;

border:none;

border-radius:22px;

background:linear-gradient(135deg,#FFD700,#ff9900);

font-size:18px;

font-weight:700;

cursor:pointer;

transition:.3s;

}


button:hover{

transform:scale(1.05);

box-shadow:0 0 35px #FFD700;

}


</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body>


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
<div style="color:#ff4444;text-align:center;margin-bottom:20px;">
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

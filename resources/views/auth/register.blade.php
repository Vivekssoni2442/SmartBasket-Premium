<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET | Register</title>

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
}


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

.register-container{

    width:450px;

    padding:40px;

    border-radius:30px;

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(25px);

    border:1px solid rgba(255,215,0,.3);

    box-shadow:0 0 50px rgba(255,215,0,.25);

    z-index:10;

}


/* Logo */

.logo{

    text-align:center;

}


.logo-circle{

    width:90px;
    height:90px;

    margin:auto;

    border-radius:30px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:40px;

    background:linear-gradient(135deg,#FFD700,#ff9900);

    box-shadow:0 0 40px #FFD700;

}


.logo h1{

    margin-top:20px;

    color:white;

    font-size:36px;

    font-weight:800;

}


.logo span{

    color:#FFD700;

}


.logo p{

    color:#ccc;

    font-size:13px;

    margin:10px 0 30px;

}



/* Input */


.input-box{

    margin-bottom:18px;

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

    background:linear-gradient(135deg,#FFD700,#ff9900);

    font-size:18px;

    font-weight:700;

    cursor:pointer;

}


button:hover{

    transform:scale(1.05);

    box-shadow:0 0 30px #FFD700;

}



/* Login */


.login{

    text-align:center;

    color:#ccc;

    margin-top:25px;

}


.login a{

    color:#FFD700;

    text-decoration:none;

    font-weight:700;

}



/* Error */


.error{

    color:#ff6b6b;

    background:#ff000022;

    padding:10px;

    border-radius:10px;

    margin-bottom:15px;

    text-align:center;

}


</style>


    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body>


<div class="register-container">


<div class="logo">


<div class="logo-circle">
🛒
</div>


<h1>
SMART <span>BASKET</span>
</h1>


<p>
CREATE YOUR PREMIUM SHOPPING ACCOUNT
</p>


</div>



@if(session('error'))

<div class="error">
{{ session('error') }}
</div>

@endif



<form method="POST" action="{{ route('register.submit') }}">

@csrf



<div class="input-box">

<input 
type="text"
name="name"
placeholder="Enter Full Name"
required>

</div>



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
placeholder="Create Password"
required>

</div>



<div class="input-box">

<input 
type="password"
name="password_confirmation"
placeholder="Confirm Password"
required>

</div>



<button type="submit">

CREATE ACCOUNT

</button>



<div class="login">

Already have an account?

<a href="{{ url('/login') }}">
Login
</a>

</div>



</form>


</div>


</body>

</html>

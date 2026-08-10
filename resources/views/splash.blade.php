<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">


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


/* Glow */

body::before{

content:"";

position:absolute;

width:600px;
height:600px;

background:#FFD700;

opacity:.18;

filter:blur(150px);

top:-200px;
left:-200px;

}



body::after{

content:"";

position:absolute;

width:600px;
height:600px;

background:#ff9900;

opacity:.15;

filter:blur(150px);

bottom:-200px;
right:-200px;

}



/* Logo */

.logo{

text-align:center;

animation:zoom 2s ease;

}


.icon{

height:130px;

width:130px;

margin:auto;

border-radius:40px;

display:flex;

align-items:center;

justify-content:center;

font-size:65px;

background:linear-gradient(135deg,#FFD700,#ff9900);

box-shadow:0 0 60px #FFD700;

animation:pulse 2s infinite;

}



h1{

margin-top:30px;

font-size:55px;

font-weight:800;

color:white;

letter-spacing:3px;

}


span{

color:#FFD700;

}



p{

margin-top:15px;

color:#ccc;

letter-spacing:5px;

font-size:14px;

}



@keyframes zoom{

from{

opacity:0;

transform:scale(0.2);

}


to{

opacity:1;

transform:scale(1);

}

}



@keyframes pulse{

50%{

transform:scale(1.1);

}

}


</style>


    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body>


<div class="logo">


<div class="icon">

🛒

</div>


<h1>

SMART <span>BASKET</span>

</h1>


<p>

PREMIUM SHOPPING EXPERIENCE

</p>


</div>



<script>

setTimeout(function(){

window.location.href="/login";

},3000);

</script>


</body>

</html>

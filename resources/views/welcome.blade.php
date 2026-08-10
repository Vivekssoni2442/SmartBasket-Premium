<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SMART BASKET</title>

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

background:linear-gradient(135deg,#050505,#111827,#000);

overflow:hidden;

}

.logo{

text-align:center;

animation:zoom 2.5s ease;

}

.logo h1{

font-size:90px;

letter-spacing:10px;

font-weight:800;

color:#FFD700;

text-shadow:

0 0 20px gold,
0 0 40px orange,
0 0 70px gold;

}

.logo p{

margin-top:20px;

font-size:18px;

letter-spacing:8px;

color:#ddd;

}

@keyframes zoom{

0%{

transform:scale(.2);

opacity:0;

}

100%{

transform:scale(1);

opacity:1;

}

}

</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>

<body>

<div class="logo">

<h1>SMART BASKET</h1>

<p>PREMIUM E-COMMERCE EXPERIENCE</p>

</div>

<script>

setTimeout(function(){

window.location="/login";

},3000);

</script>

</body>
</html>

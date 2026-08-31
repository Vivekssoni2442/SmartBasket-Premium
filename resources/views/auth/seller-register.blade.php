<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SMART BASKET | Create Seller Account</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{min-height:100vh;display:flex;justify-content:center;align-items:center;padding:30px 0;background:linear-gradient(135deg,#020617,#000,#111827);overflow:auto}
body::before,body::after{content:"";position:fixed;width:500px;height:500px;opacity:.15;filter:blur(150px);z-index:0}
body::before{background:#00ff99;top:-150px;left:-150px}body::after{background:#FFD700;right:-150px;bottom:-150px}
.card{width:420px;padding:40px;border-radius:30px;background:rgba(255,255,255,.08);backdrop-filter:blur(25px);border:1px solid rgba(0,255,153,.5);box-shadow:0 0 50px rgba(0,255,153,.4);position:relative;z-index:5;animation:show 1s ease}
@keyframes show{from{opacity:0;transform:translateY(80px)}to{opacity:1;transform:translateY(0)}}
.logo{width:95px;height:95px;margin:auto;border-radius:30px;display:flex;justify-content:center;align-items:center;font-size:45px;background:linear-gradient(135deg,#00ff99,#00cc77);box-shadow:0 0 40px #00ff99}
h1{text-align:center;margin-top:25px;color:white;font-size:30px;letter-spacing:2px}h1 span{color:#00ff99}.subtitle{text-align:center;color:#ccc;font-size:13px;margin:10px 0 35px}.input-box{margin-bottom:20px}.input-box input{width:100%;height:55px;padding:0 20px;border:none;outline:none;border-radius:18px;background:rgba(255,255,255,.12);color:white;font-size:15px}.input-box input::placeholder{color:#aaa}button{width:100%;height:55px;border:none;border-radius:20px;background:linear-gradient(135deg,#00ff99,#00cc77);font-size:18px;font-weight:700;cursor:pointer;transition:.3s}button:hover{transform:scale(1.05);box-shadow:0 0 30px #00ff99}.back{display:block;text-align:center;margin-top:25px;color:#FFD700;text-decoration:none;font-weight:600}.errors{margin:-15px 0 20px;color:#ff9b9b;font-size:13px}.errors ul{padding-left:20px}
</style>
<link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body>
<x-site-menu />
<div class="card">
<div class="logo">🏪</div>
<h1>CREATE <span>SELLER</span></h1>
<div class="subtitle">SMART BASKET SELLER PANEL</div>

@if ($errors->any())
    <div class="errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('seller.register.submit') }}">
    @csrf
    <div class="input-box"><input type="text" name="seller_name" value="{{ old('seller_name') }}" placeholder="Enter Seller Name" required></div>
    <div class="input-box"><input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Seller Email" required></div>
    <div class="input-box"><input type="tel" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number" required></div>
    <div class="input-box"><input type="password" name="password" placeholder="Create Password" required></div>
    <div class="input-box"><input type="password" name="password_confirmation" placeholder="Confirm Password" required></div>
    <button type="submit">CREATE SELLER ACCOUNT</button>
</form>
<a class="back" href="{{ route('seller.login') }}">← Seller Login</a>
<a class="back" href="{{ url('/login') }}">← Customer Login</a>
</div>
</body>
</html>

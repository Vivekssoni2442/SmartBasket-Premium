<!DOCTYPE html>
<html>
<head>
<title>SMART BASKET PRODUCTS</title>
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>

<body style="background:#020617;color:white;font-family:Arial">

<h1>🛒 SMART BASKET PRODUCTS</h1>
<h3 align="center">
Total Products: {{ $products->total() }}
</h3>
@foreach($products as $product)

<div style="
background:#111827;
margin:20px;
padding:20px;
border-radius:20px;
width:300px;
">

<img 
src="{{ $product->image }}"
width="250"
height="250"
style="object-fit:cover;border-radius:15px;"
>

<h2>{{ $product->name }}</h2>

<p>{{ $product->category }}</p>

<h3>₹{{ $product->price }}</h3>

<button>
Buy Now
</button>

</div>

@endforeach


</body>
</html>

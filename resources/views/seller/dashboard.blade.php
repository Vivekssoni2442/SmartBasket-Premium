<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SMART BASKET Seller Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">


<style>

*{
    font-family:Poppins, sans-serif;
}


body{

    margin:0;
    background:#020617;
    color:white;

}


/* Sidebar */

.sidebar{

    width:260px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:#0f172a;
    padding:25px;

}


.logo{

    color:#00ff99;
    font-size:24px;
    font-weight:800;
    margin-bottom:40px;

}



.menu a{

    display:block;
    color:#cbd5e1;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    margin-bottom:10px;

}


.menu a:hover{

    background:#00ff99;
    color:black;

}



/* Main */

.main{

    margin-left:260px;
    padding:30px;

}


.header{

    display:flex;
    justify-content:space-between;
    align-items:center;

}


.header h1{

    color:#00ff99;
    font-weight:800;

}



/* Cards */

.cards{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-top:30px;

}


.card-box{

background:#111827;
padding:25px;
border-radius:20px;
border:1px solid rgba(0,255,153,.2);
transition:.3s;

}


.card-box:hover{

transform:translateY(-8px);
box-shadow:0 0 30px rgba(0,255,153,.25);

}


.card-box i{

font-size:35px;
color:#00ff99;

}


.number{

font-size:30px;
font-weight:800;
margin-top:10px;

}




/* Product */

.product-area{

margin-top:40px;

}


.product-card{

background:#111827;
border-radius:20px;
padding:20px;

}


.product-card img{

width:100%;
height:180px;
object-fit:cover;
border-radius:15px;

}


.price{

color:#00ff99;
font-size:22px;
font-weight:bold;

}


.btn-add{

background:#00ff99;
color:black;
padding:12px 20px;
border-radius:12px;
text-decoration:none;
font-weight:700;

}



.logout{

background:#ef4444;
color:white;
border:none;
padding:10px 20px;
border-radius:12px;

}



</style>

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>


<body data-sb-theme="{{ $seller->theme ?? 'dark' }}">


<!-- Sidebar -->


<div class="sidebar">


<div class="logo">

SMART BASKET

<br>

<span style="font-size:15px">
SELLER PANEL
</span>

</div>



<div class="menu">


<a href="/seller-dashboard">
<i class="fa fa-home"></i>
Dashboard
</a>


<a href="/seller-product-add">
<i class="fa fa-plus"></i>
Add Product
</a>


<a href="{{ route('seller.products.index') }}">
<i class="fa fa-box"></i>
My Products
</a>


<a href="{{ route('seller.orders.index') }}">
<i class="fa fa-shopping-cart"></i>
Orders
</a>


<a href="{{ route('seller.profile') }}">
<i class="fa fa-user"></i>
Profile
</a>

<a href="{{ route('seller.settings') }}">
<i class="fa fa-gear"></i>
Settings
</a>



</div>


</div>




<!-- Main -->


<div class="main">


<div class="header">


<h1>
Seller Dashboard 🚀
</h1>



<form method="POST" action="{{route('seller.logout')}}">

@csrf

<button class="logout">

Logout

</button>

</form>



</div>



<!-- Statistics -->


<div class="cards">


<div class="card-box">

<i class="fa fa-box"></i>

<div class="number">

{{$totalProducts}}

</div>

<p>
Total Products
</p>

</div>



<div class="card-box">

<i class="fa fa-shopping-cart"></i>

<div class="number">

{{$totalOrders}}

</div>

<p>
Total Orders
</p>

</div>



<div class="card-box">

<i class="fa fa-clock"></i>

<div class="number">

{{$pendingOrders}}

</div>

<p>
Pending Orders
</p>

</div>




<div class="card-box">

<i class="fa fa-indian-rupee-sign"></i>


<div class="number">

₹ {{number_format($totalRevenue)}}

</div>


<p>
Total Earnings
</p>


</div>



</div>





<!-- Products -->


<div class="product-area">


<div class="d-flex justify-content-between align-items-center">


<h2>
My Products
</h2>


<a href="/seller-product-add" class="btn-add">

<i class="fa fa-plus"></i>
Add Product

</a>


</div>



<br>



<div class="row">


@forelse($products as $product)



<div class="col-md-4 mb-4">


<div class="product-card">



<img src="{{asset('products/'.$product->image)}}">



<h4 class="mt-3">

{{$product->name}}

</h4>



<p>

{{$product->category}}

</p>



<div class="price">

₹ {{$product->price}}

</div>



<p>

Stock:
{{$product->stock}}

</p>



<a href="{{route('seller.product.edit',$product->id)}}" 
class="btn btn-warning">

Edit

</a>


<form 
action="{{route('seller.product.delete',$product->id)}}"
method="POST"
style="display:inline">

@csrf

<button class="btn btn-danger">

Delete

</button>


</form>



</div>


</div>


@empty


<h3>
No Products Added
</h3>


@endforelse



</div>


</div>



</div>



</body>

</html>

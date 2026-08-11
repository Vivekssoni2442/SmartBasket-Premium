<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smart Basket Products</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">


<style>

body{
    background:linear-gradient(135deg,#f8fafc,#eef2ff);
    min-height:100vh;
    overflow-x:hidden;
}


/* ================= TOP BUTTONS ================= */


.top-actions{

    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:12px;
    padding:15px 20px;

}


.top-actions a,
.top-actions button,
.top-actions .btn{

    width:130px;
    height:42px;

    border-radius:999px !important;

    display:flex;
    justify-content:center;
    align-items:center;

    gap:8px;

    font-size:14px;
    font-weight:600;

    transition:.3s ease;

}


.top-actions a:hover,
.top-actions button:hover,
.top-actions .btn:hover{

    transform:scale(1.08);

    box-shadow:0 10px 25px rgba(0,0,0,.18);

}


.top-actions a:active,
.top-actions button:active,
.top-actions .btn:active{

    transform:scale(.95);

}



/* ================= MAIN ================= */


.container{

    max-width:100%!important;

    padding-left:80px;
    padding-right:20px;

}



/* ================= PRODUCT CARD FIX ================= */


.product-card{

    height:420px !important;

    min-height:420px !important;

    max-height:420px !important;

    border:0;

    border-radius:18px;

    overflow:hidden;

    box-shadow:
    0 10px 30px rgba(15,23,42,.08);

    transition:.3s;

}


.product-card:hover{

    transform:translateY(-5px);

}



.product-img{

    width:100%;

    height:190px !important;

    min-height:190px !important;

    max-height:190px !important;

    object-fit:cover !important;

}



.product-card .card-body{

    height:230px !important;

    overflow:hidden;

}

.product-card .card-body > .d-flex { position:relative; z-index:2; }



.product-card h5{

    overflow:hidden;

    white-space:nowrap;

    text-overflow:ellipsis;

}



.product-card p{

    overflow:hidden;

}



.action-btn{

    border-radius:999px;

    font-weight:600;

    height:36px !important;

}



/* Equal cards */

.row.g-4 > div{

    display:flex;

}



/* AI HUB */

.ai-hub-sidebar{

    position:fixed;

    left:0;

    z-index:9999;

}



@media(max-width:992px){

.container{

    padding-left:15px;

}


.top-actions{

    justify-content:center;

}

}
/* ===== Top Navigation Buttons ===== */

.sb-nav-btn,
.top-actions .btn {
    width: 145px !important;
    height: 46px !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px;

    border-radius: 50px !important;

    font-size: 15px;
    font-weight: 600;

    transition: all .3s ease;
}

.sb-nav-btn:hover,
.top-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,.18);
}
.sb-nav-btn{
    width:145px !important;
    height:46px !important;
    display:flex !important;
    justify-content:center;
    align-items:center;
    gap:8px;
    border-radius:50px !important;
    font-weight:600;
}
</style>


</head>


<body data-sb-theme="{{ auth()->user()?->dark_mode ?? 'dark' }}">



<div class="top-actions">

    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark sb-nav-btn">
        <i class="fa-solid fa-box"></i>
        My Orders
    </a>

    <a href="{{ route('profile') }}" class="btn btn-outline-dark sb-nav-btn">
        <i class="fa fa-user"></i>
        Profile
    </a>

    <a href="{{ route('settings') }}" class="btn btn-outline-dark sb-nav-btn">
        <i class="fa fa-gear"></i> Settings
    </a>

    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark sb-nav-btn">
        <i class="fa fa-shopping-cart"></i>
        Cart
    </a>

</div>





<div class="container py-3">



<!-- HEADER -->


<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">


<div>


<p class="text-primary fw-semibold mb-2">

Smart Basket

</p>


<h1 class="display-6 fw-bold">

Featured Products

</h1>


<p class="text-muted">

Fresh items added by the seller, ready for customers.

</p>


</div>



<div class="text-muted fw-semibold">

{{ $pagedProducts->total() }} Products

</div>


</div>





<!-- SEARCH FILTER -->


<form method="GET"

action="{{ route('products.index') }}"

class="row g-3 bg-white rounded-4 p-3 shadow-sm mb-4">


<div class="col-md-6">

<label class="form-label small">

Search

</label>


<input type="text"

name="search"

class="form-control"

value="{{ $search }}"

placeholder="Search products or category">


</div>



<div class="col-md-4">


<label class="form-label small">

Category

</label>


<select name="category"

class="form-select">


<option value="">

All Categories

</option>


@foreach($categories as $categoryOption)

<option value="{{ $categoryOption }}"
{{ $category==$categoryOption?'selected':'' }}>

{{ $categoryOption }}

</option>

@endforeach


</select>


</div>


<div class="col-md-2 d-flex align-items-end">


<button class="btn btn-primary w-100 action-btn">

Apply

</button>


</div>


</form>

<!-- RECENTLY VIEWED -->

@if(auth()->check())

@php

$recentlyViewed = \App\Models\RecentlyViewedProduct::with('product')
->where('user_id', auth()->id())
->latest()
->limit(4)
->get();

@endphp


@if($recentlyViewed->isNotEmpty())


<div class="mb-4">


<h5 class="fw-bold mb-3">
Recently Viewed
</h5>



<div class="row g-3">



@foreach($recentlyViewed as $view)



@if($view->product)


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm rounded-4 h-100">


<div class="card-body">


<h6 class="fw-bold">

{{ $view->product->name }}

</h6>


<p class="text-muted small">

{{ $view->product->category }}

</p>


</div>


</div>


</div>



@endif


@endforeach



</div>


</div>


@endif

@endif






<!-- PRODUCTS -->


@if($pagedProducts->count() > 0)



<div class="row g-4">



@foreach($pagedProducts as $product)



<div class="col-lg-3 col-md-6 d-flex">


<div class="card product-card h-100">



<a href="{{ route('product.show', $product) }}" class="text-decoration-none text-reset">
<img src="{{ asset('products/'.$product->image) }}"
class="product-img"
alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('products/index.php') }}';">
</a>





<div class="card-body d-flex flex-column">



<h5 class="fw-bold">

<a href="{{ route('product.show', $product) }}" class="text-decoration-none text-reset">{{ $product->name }}</a>

</h5>



<p class="text-muted small">

{{ $product->category }}

</p>





<div class="text-warning mb-2">

<i class="fa-solid fa-star"></i>

{{ number_format($product->rating,1) }}

</div>





<p class="text-muted small flex-grow-1">


{{ \Illuminate\Support\Str::limit(
$product->description ?? 'Premium quality product from Smart Basket.',
90
) }}


</p>

<a href="{{ route('product.show', $product) }}" class="stretched-link" aria-label="View {{ $product->name }} details"></a>





<h5 class="fw-bold mb-3">

Rs {{ number_format($product->price,2) }}

</h5>







<div class="d-flex gap-2">



<!-- BUY NOW -->


<a href="{{ url('/buy-now/'.$product->id) }}"

class="btn btn-outline-dark action-btn flex-fill">


Buy Now


</a>







<!-- CART -->


<form action="{{ route('cart.add',$product->id) }}"

method="POST"

class="flex-fill">


@csrf


<button type="submit"

class="btn btn-primary action-btn w-100">


<i class="fa fa-cart-plus"></i>

Cart


</button>


</form>







<!-- WISHLIST -->


<form action="{{ route('wishlist.add',$product->id) }}"

method="POST">


@csrf


<button type="submit"

class="btn btn-outline-danger action-btn">


<i class="fa fa-heart"></i>


</button>


</form>





</div>




</div>



</div>



</div>



@endforeach



</div>







<!-- PAGINATION -->


<div class="d-flex justify-content-center mt-5">


{{ $pagedProducts->appends(request()->query())->links('pagination::bootstrap-5') }}


</div>





@else



<div class="alert alert-light text-center rounded-4 shadow-sm">


<h5>

No Products Found

</h5>


</div>



@endif







</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



<x-ai-hub-sidebar />



</body>

</html>

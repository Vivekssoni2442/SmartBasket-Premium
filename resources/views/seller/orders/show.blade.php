<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Order #{{ $order->id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">
</head>

<body>

<main class="order-page">

<div class="container">

    <a href="{{ route('seller.orders.index') }}"
       class="btn btn-outline-primary btn-sm mb-3">
        ← Seller Orders
    </a>


    <h1 class="h2 fw-bold mb-4">
        Order #{{ $order->id }}
    </h1>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



<div class="row g-4">


<!-- Customer + Product Details -->

<div class="col-lg-7">

<section class="order-card">


<h2 class="h5">
    Customer Information
</h2>


<p class="mb-1">
    <strong>{{ $order->name }}</strong>
</p>

<p class="order-meta mb-1">
    {{ $order->mobile }}
</p>

<p class="order-meta">
    {{ $order->address }}, {{ $order->city }}
</p>


<hr>


<h2 class="h5">
    Product Information
</h2>



@foreach($order->items ?? [] as $item)

@php
$product = $products[$item['product_id'] ?? null] ?? null;
@endphp



<div class="order-product mb-3">


<img src="{{ $product && $product->image 
        ? asset('products/'.$product->image) 
        : 'https://placehold.co/160x160/1E293B/FFFFFF?text=Product' }}"
     alt="{{ $item['name'] ?? 'Product' }}">



<div>

<strong>
    {{ $item['name'] ?? ($product?->name ?? 'Product') }}
</strong>


<span class="d-block order-meta">

₹{{ number_format((float)($item['price'] ?? 0),2) }}

· Quantity {{ $item['quantity'] ?? 1 }}

</span>


</div>


</div>


@endforeach



<p>
<span class="status-pill">
    Payment:
    {{ $order->payment_status ?? 'Pending' }}
</span>
</p>



</section>

</div>





<!-- Delivery Assignment -->


<div class="col-lg-5">

<section class="delivery-card">


<h2 class="h5 mb-3">
    Assign Delivery Partner
</h2>



<form action="{{ route('delivery.assign', $order) }}"
      method="POST"
      enctype="multipart/form-data"
      class="assignment-form">


@csrf



@if($deliveryPartners->isNotEmpty())


<label class="form-label">
    Existing partner (optional)
</label>


<select name="delivery_partner_id"
        class="form-select mb-3">


<option value="">
    Create a new partner
</option>



@foreach($deliveryPartners as $partner)


<option value="{{ $partner->id }}"
{{ $order->deliveryDetail?->delivery_partner_id == $partner->id ? 'selected' : '' }}>

{{ $partner->name }} — {{ $partner->phone }}

</option>


@endforeach


</select>


@endif





<label class="form-label">
    Delivery person name
</label>


<input name="name"
       class="form-control mb-2"
       value="{{ old('name') }}">





<label class="form-label">
    Profile image
</label>


<input type="file"
       name="image"
       class="form-control mb-2"
       accept="image/*">





<label class="form-label">
    Mobile number
</label>


<input name="phone"
       class="form-control mb-2"
       value="{{ old('phone') }}">





<label class="form-label">
    Vehicle number
</label>


<input name="vehicle_number"
       class="form-control mb-2"
       value="{{ old('vehicle_number') }}">





<label class="form-label">
    Current location
</label>


<input name="current_location"
       class="form-control mb-2"
       value="{{ old('current_location',$order->deliveryDetail?->current_location) }}"
       placeholder="Seller warehouse">





<label class="form-label">
    Tracking status
</label>



<select name="status"
        class="form-select mb-3">


@foreach([
'Order Placed',
'Seller Confirmed',
'Packed',
'Picked By Delivery Partner',
'Out For Delivery',
'Near Customer',
'Delivered'
] as $status)



<option value="{{ $status }}"
{{ old('status',$order->deliveryDetail?->status ?? 'Seller Confirmed') == $status ? 'selected' : '' }}>

{{ $status }}

</option>



@endforeach


</select>




<button class="btn btn-primary w-100">

Assign Delivery Partner

</button>



</form>


</section>

</div>


</div>


</div>

</main>


</body>

</html>
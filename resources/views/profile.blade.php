<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

body{
    background:linear-gradient(135deg,#f8fafc,#eef2ff);
}


.profile-card{

    border:0;
    border-radius:1.2rem;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}


.avatar{

width:120px;
height:120px;
object-fit:cover;
border-radius:50%;
border:5px solid white;
box-shadow:0 10px 25px rgba(0,0,0,.15);
transition:.3s;

}


.avatar:hover{

transform:scale(1.08);

}


.btn-primary{

transition:.3s;

}


.btn-primary:hover{

transform:translateY(-3px);
box-shadow:0 10px 25px rgba(13,110,253,.3);

}


.profile-card{

transition:.3s;

}


.profile-card:hover{

transform:translateY(-5px);

}


</style>


<link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">


</head>


<body>


<div class="container py-5">


@if(session('success'))

<div class="alert alert-success rounded-4 shadow">

✅ {{session('success')}}

</div>

@endif



<div class="row g-4">


<div class="col-lg-4">


<div class="card profile-card p-4">


<div class="text-center">


@if($user->profile_image)

<img src="{{asset('storage/profile/'.$user->profile_image)}}"
class="avatar mb-3">


@else


<div class="avatar bg-primary text-white d-flex align-items-center justify-content-center fs-2 mx-auto">

{{strtoupper(substr($user->name,0,1))}}

</div>


@endif



<h3 class="fw-bold">

{{$user->name}}

</h3>


<p class="text-muted">

{{$user->email}}

</p>


</div>



<hr>



<form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">


@csrf



<div class="mb-3">

<label class="form-label">
Profile Photo
</label>


<input type="file"
name="profile_image"
class="form-control">

</div>





<div class="mb-3">

<label class="form-label">
Full Name
</label>


<input type="text"
name="name"
class="form-control"
value="{{old('name',$user->name)}}">

</div>





<div class="mb-3">

<label class="form-label">
Username
</label>


<input type="text"
name="username"
class="form-control"
value="{{old('username',$user->username)}}">

</div>





<div class="mb-3">

<label class="form-label">
Email
</label>


<input type="email"
name="email"
class="form-control"
value="{{old('email',$user->email)}}">

</div>





<div class="mb-3">

<label class="form-label">
Phone
</label>


<input type="text"
name="phone"
class="form-control"
value="{{old('phone',$user->phone)}}">

</div>





<div class="mb-3">

<label class="form-label">
Date Of Birth
</label>


<input type="date"
name="date_of_birth"
class="form-control"
value="{{old('date_of_birth',$user->date_of_birth)}}">

</div>





<div class="mb-3">

<label class="form-label">
Gender
</label>


<select name="gender" class="form-select">


<option value="">
Select
</option>


<option value="Male">
Male
</option>


<option value="Female">
Female
</option>


<option value="Other">
Other
</option>


</select>


</div>





<div class="mb-3">

<label class="form-label">
Address
</label>


<textarea name="address"
class="form-control"
rows="3">{{old('address',$user->address)}}</textarea>


</div>





<div class="row">


<div class="col-md-6 mb-3">

<label>
House No
</label>

<input type="text"
name="house_no"
class="form-control"
value="{{$user->house_no}}">

</div>




<div class="col-md-6 mb-3">

<label>
Street
</label>

<input type="text"
name="street"
class="form-control"
value="{{$user->street}}">

</div>


</div>





<div class="row">


<div class="col-md-6 mb-3">

<label>
Area
</label>

<input type="text"
name="area"
class="form-control"
value="{{$user->area}}">

</div>



<div class="col-md-6 mb-3">

<label>
Landmark
</label>

<input type="text"
name="landmark"
class="form-control"
value="{{$user->landmark}}">

</div>


</div>





<div class="row">


<div class="col-md-6 mb-3">

<label>
City
</label>

<input type="text"
name="city"
class="form-control"
value="{{$user->city}}">

</div>




<div class="col-md-6 mb-3">

<label>
State
</label>

<input type="text"
name="state"
class="form-control"
value="{{$user->state}}">

</div>


</div>





<div class="row">


<div class="col-md-6 mb-3">

<label>
Country
</label>

<input type="text"
name="country"
class="form-control"
value="{{$user->country}}">

</div>



<div class="col-md-6 mb-3">

<label>
PIN Code
</label>

<input type="text"
name="pin_code"
class="form-control"
value="{{$user->pin_code}}">

</div>


</div>
{{-- Language --}}

<div class="mb-3">

<label class="form-label">
Language
</label>


<select name="language" class="form-select">

<option value="English"
{{old('language',$user->language)=='English'?'selected':''}}>
English
</option>


<option value="Hindi"
{{old('language',$user->language)=='Hindi'?'selected':''}}>
Hindi
</option>


<option value="Other"
{{old('language',$user->language)=='Other'?'selected':''}}>
Other
</option>


</select>

</div>




{{-- Theme --}}

<div class="mb-3">

<label class="form-label">
Theme
</label>


<select name="dark_mode" class="form-select">


<option value="light">
Light
</option>


<option value="dark">
Dark
</option>


</select>

</div>




{{-- Notification --}}

<div class="mb-3">

<label class="form-label">
Notifications
</label>


<select name="notifications" class="form-select">


<option value="enabled">
Enabled
</option>


<option value="disabled">
Disabled
</option>


</select>


</div>




{{-- Password --}}

<div class="mb-3">

<label>
New Password
</label>


<input type="password"
name="password"
class="form-control">


</div>



<div class="mb-3">

<label>
Confirm Password
</label>


<input type="password"
name="password_confirmation"
class="form-control">


</div>



<button type="submit"
class="btn btn-primary px-4">

💾 Save Profile

</button>



<a href="/products"
class="btn btn-outline-dark">

Back

</a>



</form>

</div>

</div>





{{-- RIGHT SIDE --}}

<div class="col-lg-8">



<div class="card profile-card p-4 mb-4">


<h4 class="fw-bold">

🔐 Security Center

</h4>



<hr>



@if(session('security_success'))

<div class="alert alert-success">

{{session('security_success')}}

</div>

@endif




@if($user->securitySetting && $user->securitySetting->security_enabled)



<div class="alert alert-success">

🟢 Security PIN Enabled

</div>




<form action="{{route('security.disable')}}" method="POST">

@csrf


<button class="btn btn-danger">

Disable PIN

</button>


</form>



@else



<div class="alert alert-warning">

🔴 PIN Not Setup

</div>



<form action="{{route('security.save')}}" method="POST">


@csrf



<div class="mb-3">


<label class="form-label">

Create Security PIN

</label>


<input type="password"
name="pin"
maxlength="6"
minlength="4"
class="form-control"
required>


</div>




<div class="mb-3">


<label class="form-label">

Confirm PIN

</label>


<input type="password"
name="pin_confirmation"
maxlength="6"
minlength="4"
class="form-control"
required>


</div>




<button class="btn btn-primary">

Enable Security PIN

</button>



</form>


@endif



</div>





{{-- ORDERS --}}


<div class="card profile-card p-4">


<h4 class="fw-bold mb-3">

🛒 My Orders

</h4>



@php

$orders=$user->orders()->latest()->get();

@endphp




@if($orders->count()==0)


<div class="alert alert-light">

No Orders Yet

</div>


@else



<div class="table-responsive">


<table class="table">


<thead>

<tr>

<th>
Order
</th>

<th>
Date
</th>

<th>
Total
</th>

<th>
Status
</th>


</tr>

</thead>



<tbody>


@foreach($orders as $order)


<tr>


<td>

#{{$order->id}}

</td>


<td>

{{$order->created_at->format('d M Y')}}

</td>


<td>

₹{{number_format($order->total,2)}}

</td>


<td>

{{$order->status}}

</td>


</tr>


@endforeach



</tbody>


</table>


</div>


@endif



</div>



</div>


</div>


</div>




{{-- LOGOUT --}}


<div class="container pb-5">


<form action="{{route('logout')}}" method="POST">

@csrf


<button class="btn btn-outline-danger w-100">

Logout

</button>


</form>


</div>





<script>


setTimeout(()=>{


let box=document.querySelector('.alert-success');


if(box){

box.style.opacity="0";

}


},3000);



</script>




<x-ai-hub-sidebar />



</body>

</html>
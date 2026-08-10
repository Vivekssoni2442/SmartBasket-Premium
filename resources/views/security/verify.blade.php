<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Security PIN</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#eef2ff,#f8fafc);
}


.pin-card{

    width:400px;
    border-radius:25px;
    box-shadow:0 20px 50px rgba(0,0,0,.15);
    border:0;

}


.lock{

    font-size:60px;

}


.btn-primary{

    border-radius:15px;
    padding:12px;

}

</style>

</head>


<body>


<div class="card pin-card p-5">


<div class="text-center">


<div class="lock">
🔐
</div>


<h2 class="fw-bold">
Security PIN
</h2>


<p class="text-muted">
Enter your PIN to continue Smart Basket
</p>


</div>



@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif



<form action="{{ route('security.verify') }}" method="POST">

@csrf


<div class="mb-3">

<label class="form-label">
Enter Security PIN
</label>


<input

type="password"

name="pin"

class="form-control form-control-lg text-center"

maxlength="6"

placeholder="Enter PIN"

required>

</div>



<button class="btn btn-primary w-100">

🔓 Unlock

</button>


</form>


</div>


</body>

</html>
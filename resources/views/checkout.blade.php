<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART BASKET | Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #020617, #1e3a8a); color: white; min-height: 100vh; }
        .checkout-card { max-width: 720px; margin: 40px auto; background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); border-radius: 1.3rem; padding: 2rem; }
        .product-box { background: rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; }
        .summary { color: #f8fafc; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body>
    <div class="container py-4">
        <div class="checkout-card">
            <h1 class="fw-bold mb-4">🛒 Checkout</h1>

            @php
                $checkoutItems = $cartItems ?? [];
                $checkoutTotal = $total ?? 0;
            @endphp

            @if(count($checkoutItems) > 0)
                <div class="product-box mb-4">
                    <h5 class="fw-semibold">Order Summary</h5>
                    @foreach($checkoutItems as $item)
                        @php $product = $item['product'] ?? $item->product ?? null; @endphp
                        @if($product)
                            <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10">
                                <span>{{ $product->name }}</span>
                                <span>₹{{ number_format((float) $product->price * (int) ($item['quantity'] ?? $item->quantity ?? 1), 2) }}</span>
                            </div>
                        @endif
                    @endforeach
                    <div class="d-flex justify-content-between pt-3 fw-bold fs-5">
                        <span>Total</span>
                        <span>₹{{ number_format((float) $checkoutTotal, 2) }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('place.order') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
               <div class="mb-3">

<label class="form-label fw-bold">
💳 Payment Method
</label>


<select 
name="payment_method" 
id="paymentMethod"
class="form-select"
onchange="showPaymentBox()"
required>


<option value="COD">
🚚 Cash on Delivery
</option>


<option value="UPI">
📱 UPI Payment
</option>


<option value="Card">
💳 Card Payment
</option>


</select>

</div>



<!-- UPI BOX -->

<div id="upiBox" 
class="payment-box p-3 rounded-4 mb-3"
style="display:none;background:white;color:black;">


<h5 class="fw-bold">
📱 UPI Payment
</h5>


<div class="d-flex gap-3 fs-2">

<span>Gpay</span>
<span>PhonePay</span>
<span>Paytm</span>
<span>etc.

</div>


<label class="mt-3">
UPI ID
</label>


<input 
type="text"
class="form-control"
placeholder="example@upi">


<div class="text-center mt-3">

<img 
src="{{ asset('images/my-qr.png') }}"
alt="UPI QR Code"
style="
width:220px;
height:220px;
border-radius:15px;
object-fit:contain;
box-shadow:0 5px 20px rgba(0,0,0,.3);
">

<p class="mt-3 fw-bold">
📲 Scan QR Code & Pay
</p>

</div>


<p class="mt-2">
Scan & Pay
</p>


</div>


</div>





<!-- CARD BOX -->


<div id="cardBox"
class="payment-box p-3 rounded-4 mb-3"
style="display:none;background:white;color:black;">






<div style="font-size:80px;" class="mb-3 text-center">

💳

</div>



<label>
Card Number
</label>


<input 
type="text"
class="form-control"
placeholder="XXXX XXXX XXXX XXXX">



<div class="row mt-3">


<div class="col">

<label>
Expiry
</label>


<input 
type="text"
class="form-control"
placeholder="MM/YY">


</div>



<div class="col">


<label>
CVV
</label>


<input 
type="password"
class="form-control"
placeholder="CVV">


</div>


</div>


</div>





<!-- COD BOX -->


<div id="codBox"
class="payment-box p-3 rounded-4 mb-3"
style="background:white;color:black;">


<h5 class="fw-bold">
🚚 Cash On Delivery
</h5>


<p>
Pay after receiving your order.
</p>


</div>
                <button type="submit" class="btn btn-warning w-100 fw-bold">✅ Confirm Order</button>
            </form>
        </div>
    </div>
<script>

document.addEventListener("DOMContentLoaded", function(){

    showPaymentBox();

});


function showPaymentBox(){


let method = document.getElementById("paymentMethod").value;


let upiBox = document.getElementById("upiBox");
let cardBox = document.getElementById("cardBox");
let codBox = document.getElementById("codBox");


// hide all

upiBox.style.display = "none";
cardBox.style.display = "none";
codBox.style.display = "none";



// show selected

if(method === "UPI"){

    upiBox.style.display = "block";

}


else if(method === "Card"){

    cardBox.style.display = "block";

}


else{

    codBox.style.display = "block";

}


}

</script>
</body>
</html>

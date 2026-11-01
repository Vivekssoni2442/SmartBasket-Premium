<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111b39">
    <title>Cancel order #{{ $order->id }} · Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root{--ink:#16213a;--muted:#68758c;--line:#e3e9f2;--blue:#3159d8;--green:#087d5b}
        body{margin:0;background:radial-gradient(circle at 88% 4%,#e4ecff 0,transparent 32%),#f5f7fb;color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif}
        .cancel-wrap{width:100%;max-width:1680px;padding:30px clamp(16px,3vw,52px) 64px;margin:0 auto;display:grid;grid-template-columns:minmax(300px,.78fr) minmax(0,1.45fr);gap:20px;align-items:start}.cancel-wrap>.back-btn,.cancel-head{grid-column:1/-1}.cancel-head{margin-top:-8px;padding:clamp(25px,4vw,48px);border-radius:28px;background:linear-gradient(125deg,#152449,#3159b9 70%,#6655d9);color:#fff;box-shadow:0 22px 55px #233e8029}.cancel-head h1{margin:13px 0 7px;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;letter-spacing:-.045em}.cancel-head p{margin:0;color:#dbe5ff;font-size:1.02rem}.cancel-chip{display:inline-flex;gap:8px;align-items:center;padding:8px 13px;border:1px solid #ffffff45;border-radius:99px;background:#ffffff17;font-size:.8rem;font-weight:800}
        .cancel-card{min-width:0;margin:0;padding:clamp(20px,2.5vw,34px);border:1px solid #e1e8f2;border-radius:23px;background:#ffffffed;box-shadow:0 16px 40px #15244910}.section-title{margin:0 0 17px;font-size:1.08rem;font-weight:900}.product-row{display:grid;grid-template-columns:60px minmax(0,1fr) auto;gap:13px;align-items:center;padding:14px 0;border-bottom:1px solid #edf0f6}.product-row:last-of-type{border:0}.product-row img{width:60px;height:60px;object-fit:cover;border-radius:15px;background:#f0f3f8}.product-row strong{display:block}.product-row small,.muted{color:var(--muted)}.form-control,.form-select{min-height:48px;border-radius:13px;border-color:#dce3ee;padding:11px 14px}.form-control:focus,.form-select:focus{border-color:#6177e7;box-shadow:0 0 0 4px #536fe322}.form-label{font-size:.86rem;font-weight:800}.destination-card{height:100%;padding:18px;border:1px solid var(--line);border-radius:17px;background:#fff;cursor:pointer;transition:.2s}.destination-card:hover{border-color:#9baaf0;transform:translateY(-2px);box-shadow:0 10px 25px #243e8010}.destination-card:has(input:checked){border-color:#536fe3;background:#f5f7ff;box-shadow:0 0 0 3px #536fe322}.destination-card input{accent-color:var(--blue);margin-top:4px}.privacy-note{padding:15px 17px;border:1px solid #bce9d6;border-radius:15px;background:linear-gradient(120deg,#f0fbf6,#f6fffb);color:#176345;font-size:.88rem;line-height:1.6}.primary-btn,.secondary-btn{display:inline-flex;min-height:50px;align-items:center;justify-content:center;padding:0 22px;border-radius:15px;font-weight:900;text-decoration:none;transition:.2s}.primary-btn{border:0;background:linear-gradient(120deg,#2454d7,#6a4fd3);color:#fff;box-shadow:0 11px 24px #3159d833}.primary-btn:hover{color:#fff;transform:translateY(-2px);box-shadow:0 15px 28px #3159d84a}.secondary-btn{border:1px solid #dce4f1;background:#f7f9fd;color:#34415e}.secondary-btn:hover{background:#eef3ff;color:#244fd0}.back-btn{display:inline-flex;align-items:center;gap:9px;color:#33415f;font-weight:800;text-decoration:none;padding:10px 14px;border:1px solid #dce4f1;border-radius:13px;background:#ffffffd9}.field-error{color:#be123c;font-size:.8rem;margin-top:5px}
        @media(max-width:900px){.cancel-wrap{grid-template-columns:1fr;padding-top:20px}.cancel-wrap>.back-btn,.cancel-head{grid-column:1}.cancel-head{margin-top:0}}
        @media(max-width:575px){.cancel-wrap{padding:14px 12px 36px;gap:13px}.cancel-head{border-radius:22px}.cancel-card{padding:19px 16px;border-radius:19px}.product-row{grid-template-columns:50px minmax(0,1fr) auto;gap:10px}.product-row img{width:50px;height:50px}.submit-row>*{width:100%;justify-content:center}}
    </style>
</head>
<body>
<x-products-customer-taskbar :include-robot="false" />
<x-ai-hub-sidebar :without-menu="true" />
<main class="cancel-wrap">
    <header class="cancel-head mt-3">
        <span class="cancel-chip"><i class="fa-solid fa-bag-shopping"></i> Order #{{ $order->id }}</span>
        <h1>Cancel this order</h1>
        <p>Check the order and choose where the seller should return your payment.</p>
    </header>

    <section class="cancel-card">
        <h2 class="section-title">Items in this order</h2>
        @foreach($order->items ?? [] as $item)
            @php($product = $products->get((int) ($item['product_id'] ?? 0)))
            <div class="product-row">
                @if($product?->image)<img src="{{ asset('products/' . $product->image) }}" alt="">@else<div class="d-grid place-items-center rounded-3 bg-light" style="width:58px;height:58px"><i class="fa-solid fa-box text-secondary"></i></div>@endif
                <div><strong>{{ $item['name'] ?? $product?->name ?? 'Product' }}</strong><small>Qty {{ (int) ($item['quantity'] ?? 1) }}</small></div>
                <strong>₹{{ number_format((float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1), 2) }}</strong>
            </div>
        @endforeach
        <div class="d-flex justify-content-between pt-3"><strong>Order total</strong><strong>₹{{ number_format((float) ($order->amount ?? $order->total), 2) }}</strong></div>
    </section>

    <form method="POST" action="{{ route('orders.cancel', $order) }}" class="cancel-card">
        @csrf
        <h2 class="section-title">Cancellation details</h2>
        <div class="mb-4"><label class="form-label" for="cancellation_reason">Reason (optional)</label><textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" maxlength="500" placeholder="Tell the seller why you are cancelling">{{ old('cancellation_reason') }}</textarea>@error('cancellation_reason')<div class="field-error">{{ $message }}</div>@enderror</div>

        @if($refundRequired)
            <div class="privacy-note mb-4"><i class="fa-solid fa-lock me-2"></i>Your online payment is marked paid. Refund destination details are encrypted in the database and visible only in the seller's signed-in cancellation page. The seller sends the refund; it is not automatic.</div>
        @elseif($order->isCashOnDelivery())
            <div class="privacy-note mb-4"><i class="fa-solid fa-circle-info me-2"></i>Cash on delivery is normally collected only when the parcel arrives. Your selected payment details will be saved for the seller; a cancellation before delivery does not automatically mean a refund is due.</div>
        @else
            <div class="privacy-note mb-4"><i class="fa-solid fa-circle-info me-2"></i>Your payment is not currently marked as captured. The seller will review the payment before deciding whether a refund is due.</div>
        @endif
        @include('partials.refund-destination-fields')

        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-end submit-row"><button type="submit" class="primary-btn" onclick="return confirm('Cancel this order?')"><i class="fa-solid fa-ban me-2"></i>Confirm cancellation</button></div>
    </form>
</main>
</body>
</html>

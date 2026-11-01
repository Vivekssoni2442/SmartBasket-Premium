@php
    $invoiceSeller = $seller ?? $order->seller;
    $invoiceItems = collect($order->items ?? []);
    $invoiceTransaction = $transactionId ?? $paymentId ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber ?? 'SB-' . $order->id }}</title>
    <style>
        @page{margin:30px 34px}
        *{box-sizing:border-box}
        body{margin:0;color:#17243a;font-family:DejaVu Sans,Arial,sans-serif;font-size:10px;line-height:1.5}
        .top{padding:23px 25px;border-radius:16px;background:#102953;color:#fff}
        .brand{font-size:10px;font-weight:bold;letter-spacing:2px;color:#b8d7ff}.title{margin:9px 0 3px;font-size:25px;font-weight:bold}.muted-light{color:#d8e5fb}
        .top-grid{width:100%;margin-top:16px}.top-grid td{width:50%;vertical-align:bottom}.right{text-align:right}.tag{display:inline-block;padding:7px 11px;border-radius:30px;background:#e9fff1;color:#087849;font-size:9px;font-weight:bold;text-transform:uppercase}
        .cards{width:100%;margin:17px 0;border-spacing:9px 0}.card{width:50%;padding:13px 14px;border:1px solid #dfe7f1;border-radius:12px;vertical-align:top}.label{margin-bottom:5px;color:#718096;font-size:8px;font-weight:bold;letter-spacing:.7px;text-transform:uppercase}.value{color:#1a2c45;font-size:10px;font-weight:bold}.sub{margin-top:3px;color:#64748b;font-size:9px}
        table.items{width:100%;border-collapse:collapse;margin-top:14px}.items th{padding:10px 8px;background:#edf3fb;color:#48617e;font-size:8px;text-align:left;text-transform:uppercase}.items td{padding:11px 8px;border-bottom:1px solid #e8edf4;vertical-align:middle}.product{width:55px;height:55px;object-fit:cover;border-radius:8px}.product-placeholder{width:55px;height:55px;border-radius:8px;background:#edf3fb}.product-name{font-size:10px;font-weight:bold}.product-sub{margin-top:3px;color:#718096;font-size:8px}.num{text-align:right;white-space:nowrap}
        .summary{width:100%;margin-top:14px}.summary td{padding:5px 8px}.summary .total td{padding-top:11px;border-top:1px solid #dbe4ef;color:#102953;font-size:14px;font-weight:bold}.footer{margin-top:24px;padding-top:12px;border-top:1px solid #e2e8f0;color:#718096;font-size:8px;text-align:center}
    </style>
</head>
<body>
    <header class="top">
        <div class="brand">SMART BASKET</div>
        <div class="title">Order Invoice</div>
        <div class="muted-light">{{ $invoiceSeller?->getSellerDisplayName() ?? 'Smart Basket Seller' }}</div>
        <table class="top-grid"><tr>
            <td><span class="tag">{{ $order->isCashOnDelivery() ? 'Cash on Delivery' : ($paymentStatus ?? $order->payment_status_label) }}</span></td>
            <td class="right"><strong>Invoice {{ $invoiceNumber ?? 'SB-' . $order->id }}</strong><br><span class="muted-light">{{ ($order->created_at ?? now())->format('d M Y, h:i A') }}</span></td>
        </tr></table>
    </header>

    <table class="cards"><tr>
        <td class="card"><div class="label">Billed to</div><div class="value">{{ $order->name }}</div><div class="sub">{{ $order->mobile }}</div><div class="sub">{{ $order->address }}@if($order->city), {{ $order->city }}@endif</div></td>
        <td class="card"><div class="label">Seller</div><div class="value">{{ $invoiceSeller?->getSellerDisplayName() ?? 'Seller' }}</div><div class="sub">{{ $invoiceSeller?->getSellerPhone() ?? '' }}</div><div class="sub">Order #{{ $order->id }}</div></td>
    </tr></table>

    <div class="label">Purchased items</div>
    <table class="items">
        <thead><tr><th colspan="2">Product</th><th class="num">Qty</th><th class="num">Unit price</th><th class="num">Amount</th></tr></thead>
        <tbody>
            @foreach($invoiceItems as $item)
                @php
                    $product = $products->get((int) ($item['product_id'] ?? 0));
                    $imagePath = $product?->image ? public_path('products/' . $product->image) : null;
                    if ($imagePath && ! file_exists($imagePath)) $imagePath = null;
                    $quantity = (int) ($item['quantity'] ?? 1);
                    $unitPrice = (float) ($item['price'] ?? $item['unit_price'] ?? 0);
                @endphp
                <tr>
                    <td style="width:63px">@if($imagePath)<img class="product" src="{{ $imagePath }}" alt="">@else<div class="product-placeholder"></div>@endif</td>
                    <td><div class="product-name">{{ $item['name'] ?? $product?->name ?? 'Product' }}</div><div class="product-sub">Product ID: {{ $item['product_id'] ?? '—' }}</div></td>
                    <td class="num">{{ $quantity }}</td>
                    <td class="num">&#8377;{{ number_format($unitPrice, 2) }}</td>
                    <td class="num">&#8377;{{ number_format($unitPrice * $quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr><td>Payment method</td><td class="num">{{ $order->payment_method }}</td></tr>
        <tr><td>Payment status</td><td class="num">{{ $order->isCashOnDelivery() ? 'Cash due on delivery' : ($paymentStatus ?? $order->payment_status_label) }}</td></tr>
        <tr><td>Transaction / payment reference</td><td class="num">{{ $invoiceTransaction ?: 'Not available' }}</td></tr>
        <tr class="total"><td>Order total</td><td class="num">&#8377;{{ number_format((float) ($order->amount ?? $order->total), 2) }}</td></tr>
    </table>

    <footer class="footer">Thank you for shopping with Smart Basket. Keep this PDF as your order bill.</footer>
</body>
</html>

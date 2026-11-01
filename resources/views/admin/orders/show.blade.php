@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-receipt"></i> Order #{{ $order->id }}</h1>
        <p class="admin-page-description">Placed {{ $order->created_at?->format('d M Y, h:i A') }}</p>
    </div>
</div>

<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><div class="admin-stat-label">Order total</div><div class="admin-stat-value">&#8377;{{ number_format((float) ($order->amount ?? $order->total ?? 0), 2) }}</div></div>
    <div class="admin-card admin-stat"><div class="admin-stat-label">Payment</div><div class="admin-stat-value" style="font-size:15px">{{ $order->payment_status_label }}</div></div>
    <div class="admin-card admin-stat"><div class="admin-stat-label">Fulfilment</div><div class="admin-stat-value" style="font-size:15px">{{ $order->deliveryDetail?->status ?? $order->order_status ?? $order->status ?? 'Pending' }}</div></div>
</div>

<div class="admin-card">
    <div class="admin-card-title">Customer, seller and delivery</div>
    <div class="admin-table-wrap"><table class="admin-table"><tbody>
        <tr><th>Customer</th><td>{{ $order->user?->name ?? $order->name }} · {{ $order->user?->email }}</td></tr>
        <tr><th>Contact</th><td>{{ $order->mobile }}</td></tr>
        <tr><th>Delivery address</th><td>{{ $order->address }}, {{ $order->city }}</td></tr>
        <tr><th>Seller</th><td>{{ $order->seller?->business_name ?: $order->seller?->name ?: 'See item allocation' }}</td></tr>
        <tr><th>Delivery partner</th><td>{{ $order->deliveryDetail?->deliveryPartner?->name ?? 'Not assigned' }} @if($order->deliveryDetail?->deliveryPartner?->phone) · {{ $order->deliveryDetail->deliveryPartner->phone }} @endif</td></tr>
        <tr><th>Vehicle</th><td>{{ $order->deliveryDetail?->deliveryPartner?->vehicle_type ?? '—' }} @if($order->deliveryDetail?->deliveryPartner?->vehicle_number) · {{ $order->deliveryDetail->deliveryPartner->vehicle_number }} @endif</td></tr>
        @if($order->deliveryDetail?->delivered_at)
            <tr><th>Delivery confirmation</th><td>Scanned code: <strong>{{ $order->deliveryDetail->delivery_scan_code }}</strong> · {{ $order->deliveryDetail->delivered_at->format('d M Y, h:i A') }}</td></tr>
        @endif
    </tbody></table></div>

    @if($order->deliveryDetail)
        <div id="adminDeliveryProof" style="display:{{ $order->deliveryDetail->delivered_at ? 'block' : 'none' }};margin-top:14px;padding:14px;border:1px solid #b8ead4;border-radius:14px;background:#eaf8f2;color:#176b4e">
            <strong><i class="fas fa-circle-check"></i> Delivery confirmed by driver scan</strong>
            <div id="adminDeliveryProofText" style="margin-top:5px">Scanned code: {{ $order->deliveryDetail->delivery_scan_code }} · {{ $order->deliveryDetail->delivered_at?->format('d M Y, h:i A') }}</div>
        </div>
        <div id="adminDeliveryTracking" data-location-url="{{ route('admin.orders.delivery.location', $order) }}" style="margin-top:18px;padding:16px;border:1px solid #e4eaf3;border-radius:15px;background:#f7f9fc">
            <strong><i class="fas fa-location-crosshairs"></i> Live driver location</strong>
            <div id="adminDeliveryCoordinates" style="margin-top:8px;color:#526178">Waiting for driver GPS.</div>
            <small id="adminDeliveryUpdated" style="display:block;margin-top:5px;color:#7b8798">{{ $order->deliveryDetail->status }}</small>
        </div>
    @endif
</div>

<div class="admin-card">
    <div class="admin-card-title">Order items</div>
    <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Item</th><th>Quantity</th><th>Unit price</th><th>Line total</th></tr></thead><tbody>
        @forelse($order->items ?? [] as $item)
            <tr><td>{{ $item['name'] ?? $item['product_name'] ?? 'Product' }}</td><td>{{ $item['quantity'] ?? 1 }}</td><td>&#8377;{{ number_format((float) ($item['price'] ?? 0), 2) }}</td><td>&#8377;{{ number_format((float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1), 2) }}</td></tr>
        @empty
            <tr><td colspan="4">This order has no item snapshot available.</td></tr>
        @endforelse
    </tbody></table></div>
</div>

@if($order->deliveryDetail)
<script>
(() => {
    const panel = document.getElementById('adminDeliveryTracking');
    if (!panel) return;
    const coordinates = document.getElementById('adminDeliveryCoordinates');
    const updated = document.getElementById('adminDeliveryUpdated');
    const refresh = async () => {
        try {
            const response = await fetch(panel.dataset.locationUrl, {headers:{Accept:'application/json'},cache:'no-store'});
            if (!response.ok) return;
            const point = await response.json();
            if (point.delivered_at) {
                const proof = document.getElementById('adminDeliveryProof');
                const proofText = document.getElementById('adminDeliveryProofText');
                if (proof && proofText) { proof.style.display = 'block'; proofText.textContent = `Scanned code: ${point.delivery_scan_code || 'Recorded'} · ${new Date(point.delivered_at).toLocaleString()}`; }
            }
            coordinates.textContent = point.available ? `${Number(point.latitude).toFixed(5)}, ${Number(point.longitude).toFixed(5)}${point.vehicle_type ? ' · ' + point.vehicle_type : ''}` : (['delivered','cancelled'].includes(String(point.status || '').toLowerCase()) ? 'Delivery tracking has ended.' : 'Waiting for driver GPS.');
            updated.textContent = `${point.status || 'Pending'}${point.updated_at ? ' · Updated ' + new Date(point.updated_at).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}`;
        } catch (_) {}
    };
    refresh();
    window.setInterval(refresh, 10000);
})();
</script>
@endif
@endsection

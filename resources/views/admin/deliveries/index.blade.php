@extends('layouts.admin')
@section('title', 'Live Deliveries')
@section('content')
<div class="admin-page-header"><div><h1 class="admin-page-title"><i class="fas fa-truck-fast"></i> Live deliveries</h1><p class="admin-page-description">Assigned drivers, order progress and latest shared GPS positions.</p></div></div>

<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><div class="admin-stat-label">Active deliveries</div><div class="admin-stat-value">{{ $activeDeliveryCount }}</div></div>
    <div class="admin-card admin-stat"><div class="admin-stat-label">Location feed</div><div class="admin-stat-value" style="font-size:15px">Refreshes every 10 sec</div></div>
    <div class="admin-card admin-stat"><div class="admin-stat-label">Privacy</div><div class="admin-stat-value" style="font-size:15px">Admin access only</div></div>
</div>

<div class="admin-card">
    <div class="admin-card-title">Driver dispatch board</div>
    <div class="admin-table-wrap"><table class="admin-table">
        <thead><tr><th>Order / customer</th><th>Delivery partner</th><th>Progress</th><th>Live GPS</th><th>Scan confirmation</th><th>Order details</th></tr></thead>
        <tbody>
        @forelse($deliveries as $delivery)
            @php($order = $delivery->order)
            @if($order)
                <tr id="delivery-row-{{ $order->id }}" data-location-url="{{ route('admin.orders.delivery.location', $order) }}">
                    <td><strong>#{{ $order->id }}</strong><br><small>{{ $order->user?->name ?? $order->name ?? 'Customer' }}</small><br><small>{{ $order->mobile }}</small></td>
                    <td>{{ $delivery->deliveryPartner?->name ?? 'Unassigned' }}<br><small>{{ $delivery->deliveryPartner?->phone }}</small><br><small>{{ $delivery->deliveryPartner?->vehicle_type }} {{ $delivery->deliveryPartner?->vehicle_number }}</small></td>
                    <td><span class="admin-badge admin-badge-info" id="delivery-status-{{ $order->id }}">{{ $delivery->status }}</span></td>
                    <td><span id="delivery-location-{{ $order->id }}">{{ $delivery->latitude !== null ? number_format((float) $delivery->latitude, 5) . ', ' . number_format((float) $delivery->longitude, 5) : 'Waiting for GPS' }}</span><br><small id="delivery-updated-{{ $order->id }}">{{ $delivery->location_updated_at?->format('d M, h:i A') ?? 'No location received yet' }}</small></td>
                    <td id="delivery-scan-{{ $order->id }}">@if($delivery->delivered_at)<strong>{{ $delivery->delivery_scan_code }}</strong><br><small>{{ $delivery->delivered_at->format('d M, h:i A') }}</small>@else—@endif</td>
                    <td><a class="admin-btn admin-btn-secondary" href="{{ route('admin.orders.show', $order) }}">Open order</a></td>
                </tr>
            @endif
        @empty
            <tr><td colspan="6"><div class="admin-empty"><i class="fas fa-circle-check"></i>No active or recently completed deliveries.</div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div class="admin-pagination">{{ $deliveries->links() }}</div>
</div>

<script>
(() => {
    const rows = [...document.querySelectorAll('[data-location-url]')];
    const refresh = async (row) => {
        try {
            const response = await fetch(row.dataset.locationUrl, {headers:{Accept:'application/json'},cache:'no-store'});
            if (!response.ok) return;
            const point = await response.json();
            const id = row.id.replace('delivery-row-', '');
            document.getElementById(`delivery-status-${id}`).textContent = point.status || 'Pending';
            document.getElementById(`delivery-location-${id}`).textContent = point.available ? `${Number(point.latitude).toFixed(5)}, ${Number(point.longitude).toFixed(5)}` : 'Waiting for GPS';
            document.getElementById(`delivery-updated-${id}`).textContent = point.updated_at ? `Updated ${new Date(point.updated_at).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}` : 'No location received yet';
        } catch (_) {}
    };
    rows.forEach(refresh);
    window.setInterval(() => rows.forEach(refresh), 10000);
})();
</script>
@endsection

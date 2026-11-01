@php
    $order = $delivery->order;
    $stages = ['Order Placed', 'Seller Confirmed', 'Packed', 'Picked By Delivery Partner', 'Out For Delivery', 'Near Customer', 'Delivered'];
    $currentIndex = array_search($delivery->status, $stages, true);
    $address = collect([$order?->address, $order?->city])->filter()->implode(', ');
@endphp
<details class="driver-order" data-driver-order="{{ $order?->id }}">
    <summary>
        <span class="driver-order-sigil"><i class="fa-solid fa-box"></i></span>
        <span class="driver-order-summary"><strong>Order #{{ $order?->id }}</strong><small>{{ $order?->created_at?->format('d M Y -- h:i A') }}</small></span>
        <span class="driver-status-pill">{{ $delivery->status }}</span>
    </summary>
    <div class="driver-order-body">
        <div class="driver-order-customer">
            <strong>{{ $order?->name ?: $order?->user?->name ?: 'Customer' }}</strong>
            @if($order?->mobile)<a class="driver-order-phone" href="tel:{{ $order->mobile }}"><i class="fa-solid fa-phone"></i> {{ $order->mobile }}</a>@endif
            <div class="driver-order-address">{{ $address ?: 'Delivery address is not available.' }}</div>
            <div class="driver-order-quick">
                @if($order?->mobile)<a href="tel:{{ $order->mobile }}"><i class="fa-solid fa-phone"></i> Call customer</a>@endif
                @if($address)<a target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($address) }}"><i class="fa-solid fa-route"></i> Navigate</a>@endif
                <button type="button" data-copy-address="{{ $address }}"><i class="fa-regular fa-copy"></i> Copy address</button>
            </div>
        </div>
        <ul class="driver-items">
            @foreach($delivery->driver_items ?? [] as $item)
                <li><span class="driver-product">@if($item['image_url'] ?? false)<img src="{{ $item['image_url'] }}" alt="">@endif<span>{{ $item['name'] ?? 'Product' }} x {{ $item['quantity'] ?? 1 }}</span></span><strong>Rs. {{ number_format((float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1), 2) }}</strong></li>
            @endforeach
        </ul>
        <div class="driver-payment"><span>Order total</span><strong>Rs. {{ number_format((float) ($order?->total ?? $order?->amount ?? 0), 2) }}</strong></div>
        @if(!$completed)
            <form class="driver-status-form" method="POST" action="{{ route('delivery.driver.status', [$token, $order], false) }}" data-status-form>
                @csrf
                <label for="delivery-status-{{ $order?->id }}">Update customer tracking</label>
                <select id="delivery-status-{{ $order?->id }}" name="status" required>
                    @foreach($stages as $index => $stage)
                        @if($currentIndex === false || $index > $currentIndex)
                            <option value="{{ $stage }}" @selected($currentIndex === false ? $loop->first : $index === $currentIndex + 1)>{{ $stage }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="driver-scan-tools" data-scan-tools>
                    <input type="text" name="delivery_scan_code" placeholder="Scan code to confirm delivery" autocomplete="off">
                    <button type="button" data-camera><i class="fa-solid fa-camera"></i> Scan</button>
                    <video playsinline muted></video>
                </div>
                <button type="submit" class="driver-update" data-update-status>Update order status</button>
            </form>
        @elseif($delivery->status === 'Delivered')
            <div class="driver-proof"><i class="fa-solid fa-circle-check"></i> Delivered{{ $delivery->delivered_at ? ' -- ' . $delivery->delivered_at->format('d M, h:i A') : '' }}</div>
        @else
            <div class="driver-proof"><i class="fa-solid fa-ban"></i> This order was cancelled.</div>
        @endif
    </div>
</details>

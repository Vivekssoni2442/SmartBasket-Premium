<div class="driver-profile">
    <div class="driver-avatar">
        @if($partner->image)
            <img src="{{ asset('delivery-partners/' . $partner->image) }}" alt="{{ $partner->name }}">
        @else
            {{ \Illuminate\Support\Str::of($partner->name)->explode(' ')->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}
        @endif
    </div>
    <div class="driver-profile-copy">
        <strong>{{ $partner->name }}</strong>
        <span>{{ $partner->phone }}</span>
    </div>
    <div class="driver-vehicle">{{ $partner->vehicle_type ?: 'Delivery partner' }}<small>{{ $partner->vehicle_number ?: 'Vehicle details pending' }}</small></div>
</div>

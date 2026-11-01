@props([
    'title' => null,
    'subtitle' => null,
    'stat' => null,
    'statLabel' => null,
])

@once
    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}?v=20261019-purple-blue-4">
@endonce

<section {{ $attributes->class(['sb-customer-page-hero']) }}>
    <div class="sb-customer-page-hero__copy">
        @if ($title !== null)
            <h1 class="sb-customer-page-title">{{ $title }}</h1>
        @else
            {{ $slot }}
        @endif
        @if ($subtitle)
            <p class="sb-customer-page-hero__subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($stat !== null && filled($statLabel))
        <aside class="sb-customer-page-hero__stat" aria-label="{{ $statLabel }}">
            <strong>{{ $stat }}</strong>
            <span>{{ $statLabel }}</span>
        </aside>
    @endif
</section>

@props(['withoutMenu' => false])

@unless (request()->routeIs('delivery.driver'))
    @include('ai-hub.partials.navigation', ['showSiteMenu' => ! $withoutMenu])
@endunless

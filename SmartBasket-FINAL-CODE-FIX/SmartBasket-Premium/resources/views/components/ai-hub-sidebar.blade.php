@props(['withoutMenu' => false])

@if (request()->path() !== '/')
    @include('ai-hub.partials.navigation', ['showSiteMenu' => ! $withoutMenu])
@endif

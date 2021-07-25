<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title ?? config('app.long.title') }}</title>
    @include('front-v1.partials.metas')
    @yield('page-metas')
    @include('front-v1.partials.styles')
    @yield('page-styles')
    @stack('styles')
</head>

<body>
@include('front-v1.partials.shared.header')

<div class="container">
    <div class="row">
        <div class="col-12 mt-3" id="flash-message">
            @include('partials.flashes')
        </div>
    </div>
</div>


@yield('content')

@include('front-v1.partials.shared.footer')

<footer id="phone-nav" class="d-block d-md-none sticky-footer bg-light">
    @include('front-v1.partials.phone_nav')
</footer>

@include('front-v1.partials.back_to_top')

@include('front-v1.partials.shared.social_media_button')

@include('front-v1.partials.scripts')
@yield('page-scripts')
@stack('scripts')
</body>


</html>

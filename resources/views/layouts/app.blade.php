<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title ?? config('app.name') }}</title>
    @include('front-v1.partials.metas')
    @include('front-v1.partials.styles')
    @yield('page-styles')
</head>

<body>
@include('front-v1.partials.nav')

<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            @include('partials.flashes')
        </div>
    </div>
</div>
@yield('content')



@include('front-v1.partials.footer')

@include('front-v1.partials.phone_nav')

@include('front-v1.partials.cart')



@include('front-v1.partials.scripts')
@yield('page-scripts')
</body>


</html>

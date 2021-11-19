<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front-v1.partials.metas')
    @yield('page-metas')
    @stack('metas')

    @include('front-v1.partials.styles')
    @yield('page-styles')
    @stack('styles')
</head>

<body>
{{--INITIALIZE TEMPLATE--}}
@php($current_route_name=request()->route()->getName())
@php($excluded_route_names=['login', 'verify.show'])

@if(!in_array($current_route_name , $excluded_route_names))
    @include('front-v1.partials.shared.header')
@endif

@if($errors->any())
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3" id="flash-message">
                @include('partials.flashes')
            </div>
        </div>
    </div>
@endif


@yield('content')

{{--REMOVE FROM LOGIN AND VERIFY TEMPLATES--}}
@if(!in_array($current_route_name ,$excluded_route_names))

    @include('front-v1.partials.shared.footer')
    <footer id="phone-nav" class="d-block d-md-none sticky-footer bg-light">
        @include('front-v1.partials.phone_nav')
    </footer>
    @include('front-v1.partials.back_to_top')
    @include('front-v1.partials.shared.social_media_button')

@endif

{{--SCRIPTS--}}
@include('front-v1.partials.scripts')
@yield('page-scripts')
@stack('scripts')
</body>


</html>

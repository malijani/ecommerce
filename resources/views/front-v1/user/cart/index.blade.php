@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container-fluid my-3 rounded">
        <div class="row">


            {{--FINAL DESCRIPTION--}}
            <div class="col-12 col-lg-2 mt-3 py-3" id="cart_total">
                @include('front-v1.user.cart.cart_total')
            </div>
            {{--./FINAL DESCRIPTION--}}


            <div class="col-12  col-lg-8 py-4 text-center" id="cart_items">{{--PRODUCTS--}}
                @include('front-v1.user.cart.cart_items')
            </div>{{--./PRODUCTS--}}

            @include('front-v1.partials.shared.social_media_aside')

        </div>{{--row--}}
        @include('front-v1.partials.shared.page_image_menu')
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--container--}}

@endsection


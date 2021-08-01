@extends('layouts.app')

@include('front-v1.partials.seo_metas', ['page_header' => $page_header ?? null])

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container-fluid my-2 rounded">
        <div class="row">
            {{--CART TOTAL--}}
            <div class="col-12 col-xl-4 text-center mt-2" id="cart_total">
                @include('front-v1.user.cart.cart_total')
            </div>
            {{--./CART TOTAL--}}
            {{--ORDERED ITEMS--}}
            <div class="col-12 col-xl-8 text-center mt-2" id="cart_items">
                @include('front-v1.user.cart.cart_items')
            </div>
            {{--./ORDERD ITEMS--}}
    </div>{{--row--}}
    @include('front-v1.partials.shared.page_image_menu')
    @include('front-v1.partials.shared.social_media_banner')
    </div>{{--container--}}

@endsection


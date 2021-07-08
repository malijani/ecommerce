@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container-fluid my-2 rounded">
        <div class="row">

            {{--MAIN CONTENT--}}
            <div class="col-12 col-lg-10 py-2">
                <div class="row">
                    {{--CART TOTAL--}}
                    <div class="col-12 col-xl-4 text-center" id="cart_total">
                        @include('front-v1.user.cart.cart_total')
                    </div>
                    {{--./CART TOTAL--}}
                    {{--ORDERED ITEMS--}}
                    <div class="col-12 col-xl-8 text-center" id="cart_items">
                        @include('front-v1.user.cart.cart_items')
                    </div>
                    {{--./ORDERD ITEMS--}}
                </div>

            </div>
            {{--./MAIN CONTENT--}}


            @include('front-v1.partials.shared.social_media_aside')

        </div>{{--row--}}
        @include('front-v1.partials.shared.page_image_menu')
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--container--}}

@endsection


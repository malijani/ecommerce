@extends('layouts.app')

@section('content')


    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('address') }}


    <div class="container-fluid my-3">
        <div class="row">

            {{--FINAL TOTAL PAY--}}
            <div class="col-12 col-xl-4 order-second order-xl-first mt-5 mt-xl-0">
                @include('front-v1.user.address.final_total')
            </div>
            {{--./FINAL TOTAL PAY--}}

            {{--ADDRESS--}}
            <div class="col-12 col-xl-8 order-first order-xl-second" id="addresses">
                @include('front-v1.partials.address')
            </div>
            {{--./ADDRESS--}}

            {{--BASKET BRIEF--}}
            <div class="col-12 mt-5">
                @include('front-v1.partials.basket_brief')
            </div>
            {{--./BASKET BRIEF--}}

        </div>{{--./MAIN ROW--}}

        @include('front-v1.partials.shared.page_image_menu')
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}



@endsection





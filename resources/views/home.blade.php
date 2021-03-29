@extends('layouts.app')


@section('content')

{{--        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('home') }}--}}
{{--TODO : MEGA MENU--}}
{{--TODO : WEBSITE BANNER GOES HERE--}}
{{--TODO : ADD CAROUSEL HERE!--}}
{{--TODO : MINIMAL FAQ GOES HERE--}}
{{--TODO : CATEGORIES GOES HERE--}}
{{--TODO : SUGGESTS GOES HERE--}}
{{--TODO : BRANDS PAGE DIRECTION--}} {{--TODO : SHOW MAIN COMPANY --}}
{{--TODO : NEW PRODUCTS, MOST ORDERED--}}
{{--TODO : WAY OF PRODUCT SELLING--}}
    <div class="container my-3">
        <div class="row">
            @include('front-v1.partials.categories', ['categories'=>$categories])
        </div>

        <div class="row mt-3 bg-white mb-5">
            <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                <h3 class="font-14">
                    <a class="text-dark" href="#">محصولات</a>
                </h3>
                <a href="#">
                    مشاهده همه
                    <i class="fa fa-eye"></i>
                </a>
            </div>
            <div class="col-12 mt-2 mb-5">
                @include('front-v1.partials.products', ['products'=>$products, 'carousel'=>false])
            </div>
        </div>
    </div>
@endsection

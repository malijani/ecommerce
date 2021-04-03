@extends('layouts.app')


@section('content')

    {{--        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('home') }}--}}
    {{--TODO : MEGA MENU--}}
    {{--TODO : ADD CAROUSEL HERE!--}}
    {{--TODO : MINIMAL FAQ GOES HERE--}}
    {{--TODO : CATEGORIES GOES HERE--}}
    {{--TODO : SUGGESTS GOES HERE--}}
    {{--TODO : BRANDS PAGE DIRECTION--}} {{--TODO : SHOW MAIN COMPANY --}}
    {{--TODO : NEW PRODUCTS, MOST ORDERED--}}
    {{--TODO : WAY OF PRODUCT SELLING--}}
    <div class="container my-3">
        {{--SHOW BANNER--}}
        @if(isset($banner))
            <div class="row my-3">
                <div class="col-12">
                    <a href="{{$banner->link}}" title="{{ $banner->pic_alt }}">
                        <img src="{{asset($banner->pic)}}"
                             alt="{{ $banner->pic_alt }}"
                             class="banner img rounded align-middle w-100"
                             id="banner"
                        >
                    </a>
                </div>
            </div>
        @endif
        {{--SHOW BRANDS--}}
        <div class="row mt-3 bg-white rounded p-3 ">
            <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                <h3 class="font-14">
                    <a class="text-dark" href="#">برند ها</a>
                </h3>
                <a href="#">
                    مشاهده همه
                    <i class="fa fa-eye"></i>
                </a>
            </div>
            @include('front-v1.partials.brands', ['brands'=>$brands])
        </div>
        {{--SHOW CATEGORIES--}}
        <div class="row mt-3 bg-white rounded p-3 ">
            <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                <h3 class="font-14">
                    <a class="text-dark" href="#">دسته بندی ها</a>
                </h3>
                <a href="#">
                    مشاهده همه
                    <i class="fa fa-eye"></i>
                </a>
            </div>
            @include('front-v1.partials.categories', ['categories'=>$categories])
        </div>
        {{--SHOW PRODUCTS--}}
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

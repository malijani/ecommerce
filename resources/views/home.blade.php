@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front-v1/slider-pro/css/slider-pro.css') }}">
@endpush

@section('content')

    <div class="container-fluid my-3">
        {{--SHOW BANNER--}}
        @if(!empty($banner) && $banner->count())
            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{$banner->link}}" title="{{ $banner->pic_alt }}">
                        <img src="{{asset($banner->pic)}}"
                             alt="{{ $banner->pic_alt ?? '' }}"
                             class="banner img rounded align-middle w-100"
                             id="banner"
                             loading="lazy"
                        >
                    </a>
                </div>
            </div>
        @endif
        {{--./SHOW BANNER--}}

        {{--SHOW SLIDERS--}}
        @if(!empty($sliders) && $sliders->count())
            <div class="row mt-3">
                <div class="col-12">
                    {{--SLIDERS--}}
                    <div id="sliders" class="slider-pro">
                        <div class="sp-slides">
                            @foreach($sliders as $slider)
                                <div class="sp-slide rounded">
                                    <a href="{{ $slider->link }}">
                                        <img class="sp-image rounded" src="{{ asset($slider->pic) }}"
                                             data-src="{{ asset($slider->pic) }}"
                                             data-retina="{{ asset($slider->pic) }}"
                                             alt="{{ $slider->pic_alt }}"
                                             loading="lazy"
                                        >
                                    </a>
                                    <p class="rounded sp-layer sp-black sp-padding"
                                       data-horizontal="0" data-vertical="0"
                                       data-show-transition="right" data-hide-transition="up" data-show-delay="400"
                                       data-hide-delay="200">
                                        {{ $slider->title }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{--./SLIDERS--}}
            </div>
        @endif
        {{--./SHOW SLIDERS--}}


        {{--SHOW ABOUT IMAGE MENU--}}
        @include('front-v1.partials.shared.about_image_menus')
        {{--./SHOW ABOUT IMAGE MENU--}}

        {{--SHOW MAIN IMAGE MENU--}}
        @if(!empty($main_image_menus) && $main_image_menus->count())
            @include('front-v1.partials.main_image_menu', ['items'=>$main_image_menus])
        @endif
        {{--./SHOW MAIN IMAGE MENU--}}

        {{--SHOW BIG IMAGE MENU--}}
        @if(!empty($big_image_menus) && $big_image_menus->count())
            @include('front-v1.partials.big_image_menu', ['items'=>$big_image_menus])
        @endif
        {{--./SHOW BIG IMAGE MENU--}}

        {{--SHOW BRANDS--}}
        @if(!empty($brands) && $brands->count())
            <div class="row mt-3 rounded p-3 bg-light">
                <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                    <h3 class="font-16">
                        <a class="text-dark" href="{{ route('brand.index') }}">
                            برند ها
                        </a>
                    </h3>
                    <a href="{{ route('brand.index') }}">
                        مشاهده همه
                        <i class="fal fa-eye"></i>
                    </a>
                </div>
                @include('front-v1.partials.brands', ['brands'=>$brands])
            </div>
        @endif
        {{--./SHOW BRANDS--}}

        {{--SHOW CATEGORIES--}}
        @if(!empty($categories) && $categories->count())
            <div class="row mt-3 bg-white rounded p-3 ">
                <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                    <h3 class="font-16">
                        <a class="text-dark"
                           href="{{ route('category.index') }}"
                        >
                            دسته بندی ها
                        </a>
                    </h3>
                    <a href="{{ route('category.index') }}">
                        مشاهده همه
                        <i class="fal fa-eye"></i>
                    </a>
                </div>
                @include('front-v1.partials.categories', ['categories'=>$categories])
            </div>
        @endif
        {{--./SHOW CATEGORIES--}}

        {{--SHOW PRODUCTS--}}
        @if(!empty($products) && $products->count())
            <div class="row mt-3 bg-white rounded p-3 mb-3">
                <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                    <h3 class="font-14">
                        <a class="text-dark"
                           href="{{ route('product.index') }}"
                        >
                            محصولات برتر
                        </a>
                    </h3>
                    <a href="{{ route('product.index') }}"
                    >
                        مشاهده همه
                        <i class="fal fa-eye"></i>
                    </a>
                </div>
                <div class="col-12 mt-2 mb-5">
                    <div class="row wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        @include('front-v1.partials.products', ['products'=>$products, 'carousel'=>false])
                    </div>
                </div>
            </div>
        @endif
        {{--./SHOW PRODUCTS--}}

        {{--SHOW IMAGE PAGE MENU--}}
        @if(!empty($page_image_menus) && $page_image_menus->count())
            @include('front-v1.partials.page_image_menu', ['items'=>$page_image_menus])
        @endif
        {{--./SHOW IMAGE PAGE MENU--}}


        {{--SHOW FOOTER IMAGE MENU--}}
        @if(!empty($footer_image_menus) && $footer_image_menus->count())
            @include('front-v1.partials.big_image_menu', ['items'=>$footer_image_menus])
        @endif
        {{--./SHOW FOOTER IMAGE MENU--}}


    </div>
@endsection

@push('scripts')
    <script src="{{ asset('front-v1/slider-pro/js/jquery.sliderPro.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#sliders').sliderPro({
                width: '100%',
                height: 500,
                imageScaleMode: 'exact',
                fade: true,
                fadeDuration: 2000,
                orientation: 'horizontal',
                responsive: true,
                autoHeight: true,
                autoSlideSize: false,
                autoScaleLayers: false,
                arrows: true,
                buttons: true,
                waitForLayers: true,
                autoplay: true,
                autoplayDelay: 10000,
                autoplayDirection: 'backwards',
                breakpoints: {
                    500: {
                        orientation: 'vertical',
                        arrows: false,
                        buttons: false,
                    }
                }

            });

        });
    </script>
@endpush

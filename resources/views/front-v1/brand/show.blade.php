@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands.brand', $brand) }}


    <div class="container-fluid">
        <div class="row my-2">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2">

                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <div class="row align-items-center bg-light pt-md-2 rounded">

                            <div class="col-12 col-md-6 order-last order-md-first my-2 my-md-0 text-center">
                                <h4 class="card-title px-md-5 font-22 font-weight-bolder">
                                    {{ $brand->title }}
                                </h4>
                                <h5 class="font-18 font-weight-bolder text-muted">
                                    {{ $brand->title_en }}
                                </h5>
                            </div>

                            <div class="col-12 col-md-6 order-first order-md-last text-center">
                                <img class="img img-fluid rounded"
                                     src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                                     alt="{{ $brand->pic_alt ?? $brand->title_en }}"
                                >
                            </div>

                        </div>

                        <div class="card-text px-md-5 my-4">
                            {!! $brand->text !!}
                        </div>
                        <hr class="w-50">


                        @if(!empty($products) && $products->count())
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">محصولات</h6>
                                @include('front-v1.partials.carousel.products', ['products'=> $products])
                            </div>
                        @endif

                    </div>
                </div>


            </div>
            {{--./SHOW MAIN CONTENT--}}
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>

        </div>

        @include('front-v1.partials.shared.social_media_banner')

    </div>
@endsection



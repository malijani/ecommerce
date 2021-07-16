@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands') }}


    <div class="container-fluid">
        <div class="row my-2">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 ">
                <div class="card mb-3 shadow-lg">
                    <img src="{{ asset('images/asset/404.png') }}"
                         alt="برند مورد نظر یافت نشد!"
                         class="card-img-top img img-fluid img-size-swiper p-1 rounded"
                    >
                    <div class="card-body">
                        <h5 class="card-title px-5 text-center">
                            برند {{ $not_found  ?? ' مورد نظر شما '}} یافت نشد!
                        </h5>
                        @if(!empty($brands) && $brands->count())
                            <hr class="w-50">
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">
                                    از اینجا شروع کن:
                                </h6>
                                @include('front-v1.partials.carousel.brands', ['brands'=>$brands])
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            {{--./SHOW MAIN CONTENT--}}

            @include('front-v1.partials.shared.social_media_aside')

        </div>

        @include('front-v1.partials.shared.social_media_banner')

    </div>
@endsection


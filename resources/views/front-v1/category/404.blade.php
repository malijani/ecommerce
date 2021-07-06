@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories') }}

    <div class="container-fluid">
        <div class="row my-2">
            <div class="d-none d-lg-block col-lg-2" id="basket_aside_content">
                @include('front-v1.partials.shared.basket_aside')
            </div>

            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 ">
                <div class="card mb-3 shadow-lg">
                    <img src="{{ asset('images/asset/404.png') }}"
                         alt="دسته بندی مورد نظر یافت نشد!"
                         class="card-img-top img img-fluid img-size-swiper p-1 rounded"
                    >
                    <div class="card-body">
                        <h5 class="card-title px-5 text-center">
                            دسته بندی {{ $not_found  ?? ' مورد نظر شما '}} یافت نشد!
                        </h5>
                        <hr class="w-50">
                        @if(!empty($categories) && $categories->count())
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">
                                    از اینجا شروع کن:
                                </h6>
                                @include('front-v1.partials.carousel.categories', ['categories'=>$categories])
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



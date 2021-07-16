@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories.category', $category) }}

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

                <div class="card mb-3 shadow-lg">
                    <div class="card-body">
                        <div class="row align-items-center bg-light pt-md-2 rounded">

                            <div class="col-12 col-md-6 order-last order-md-first my-2 my-md-0 text-center">
                                <h4 class="card-title px-md-5 font-22 font-weight-bolder">
                                    {{ $category->title }}
                                </h4>
                            </div>

                            <div class="col-12 col-md-6 order-first order-md-last text-center">
                                <img class="img img-fluid rounded"
                                     src="{{ asset($category->pic ?? 'images/fallback/category.png') }}"
                                     alt="{{ $category->pic_alt ?? $category->title_en }}"
                                >
                            </div>

                        </div>
                        <div class="card-text px-md-5 my-4">
                            {!! $category->text !!}
                        </div>

                        <hr class="w-50">
                        @if(!empty($sub_categories) && $sub_categories->count())
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">زیر دسته ها</h6>
                                @include('front-v1.partials.carousel.categories', ['categories'=>$sub_categories])
                            </div>
                        @endif

                        @if(!empty($products) && $products->count())
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">محصولات</h6>
                                @include('front-v1.partials.carousel.products', ['products'=> $products])
                            </div>
                        @endif
                        @if(!empty($articles) && $articles->count())
                            <div class="my-5 p-0">
                                <h6 class="font-16 text-dark pr-3">مقالات</h6>
                                @include('front-v1.partials.carousel.articles', ['articles' =>$articles])
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



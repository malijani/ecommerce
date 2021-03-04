@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories.category', $category) }}

    <div class="container my-3 rounded">
        <div class="row bg-white">
            <div class="col-12 py-4 text-center">
                <h1 class="font-24">{{$category->title}}</h1>
            </div>

            <div class="col-12">

                @foreach($products as $product)
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <img class="img-fluid mb-3"
                             src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png') }}"
                             alt="{{$product->files()->defaultFile()->title}}"
                        >
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{$product->price}} تومان</span>
                            <small class="discount">۵٬۴۰۰</small>
                        </div>
                        <h4 class="font-14 mt-2 text-right">{{ $product->title }}</h4>
                        <span class="position-absolute left-top-0">
                            <button class="add_card">+</button>
                        </span>
                    </div>
                @endforeach

            </div>
            <div class="col-12 p-4">
                {!! $category->long_text !!}
            </div>
        </div>{{--row--}}


        <div class="row my-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>


    </div>{{--container--}}
@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/parallax/parallax.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let mainImg = $('.main-img')
            let parallaxWindow = $('.parallax-window');
            let image = mainImg.attr('src');
            if (typeof $.fn.parallax !== 'undefined') {
                mainImg.hide();
                parallaxWindow.parallax({
                    imageSrc: image,
                    // naturalWidth: '100vw',
                    // naturalHeight: '100vh',
                    zIndex: '0',
                    bleed: '0',
                    speed: '0.01',
                    iosFix: true,
                    androidFix: true,
                    // position: 'center center',
                });

                /*
                * parallax mirror is container of parallax image
                * it will be created after parallax window initialization
                */
                let parallaxMirror = $('.parallax-mirror');
                parallaxMirror.addClass("rounded img-size-swiper")
                /*
                * parallax slider is image of parallax in mirror container
                */
                let parallaxSlider = $('.parallax-slider');
                parallaxSlider.addClass("img img-fluid card-img-top")
            } else {
                mainImg.show();
            }
        });
    </script>
@endsection


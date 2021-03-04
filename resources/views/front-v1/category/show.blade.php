@extends('layouts.app')


@section('content')

{{--    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog.article', $product) }}--}}

    <div class="container my-3 rounded">
        <div class="row bg-white">
            <div class="col-12 py-4 text-center">
                <h1 class="font-24">{{$article->title}}</h1>
            </div>

            <div class="col-12">
                <div class="parallax-window img-size-swiper rounded">
                    <img class="img img-fluid card-img-top main-img"
                         src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                         alt="{{$article->pic_alt ?? $article->title_en}}"
                    >
                </div>
            </div>

            <div class="col-12 p-4">
                {!! $article->long_text !!}
            </div>

        </div>{{--row--}}
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


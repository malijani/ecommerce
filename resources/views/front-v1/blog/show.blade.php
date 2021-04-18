@extends('layouts.app')

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog.article', $article) }}

    <div class="container my-3 rounded">
        <div class="row bg-white">
            <div class="col-12 ">
                <div class="py-4 text-center">
                    <h1 class="font-24">{{$article->title}}</h1>
                </div>
            </div>

            <div class="col-12 mb-5">
                <div class="parallax-window rounded">
                    <img class="img img-fluid main-img w-100"
                         src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                         alt="{{$article->pic_alt ?? $article->title_en}}"
                         width="100vh"
                    >
                </div>
            </div>

            <div class="col-12 p-4">
                {!! $article->long_text !!}
            </div>

        </div>{{--row--}}


        {{--COMMENTS--}}
        <div class="row bg-white mb-5 mt-3 py-3 rounded">
                @include('front-v1.partials.comment_template', ['comments'=>$comments, 'model'=>'Article','model_id'=>$article->id])
        </div>
        {{--./COMMENTS--}}
    </div>{{--container--}}




@endsection

@section('page-scripts')
    {{--PARALLAX--}}
    <script src="{{ asset('front-v1/parallax/parallax.min.js') }}"></script>
    {{--CKEDITOR--}}
    {{--<script src="{{ asset('front-v1/ckeditor/ckeditor.js') }}"></script>--}}

    <script>
        $(document).ready(function () {
            /****START*******/
            /*PARALLAX IMAGE*/
            /****************/
            let mainImg = $('.main-img')
            let parallaxWindow = $('.parallax-window');
            let image = mainImg.attr('src');
            if (typeof $.fn.parallax !== 'undefined') {
                mainImg.hide();
                parallaxWindow.parallax({
                    imageSrc: image,
                    naturalWidth: '100%',
                    //naturalHeight: '100vh',
                    zIndex: '0',
                    bleed: '0',
                    speed: '0.1',
                    iosFix: true,
                    androidFix: true,
                    //position: 'center center',
                });

                /*
                * parallax mirror is container of parallax image
                * it will be created after parallax window initialization
                */
                let parallaxMirror = $('.parallax-mirror');
                parallaxMirror.addClass("rounded")
                /*
                * parallax slider is image of parallax in mirror container
                */
                let parallaxSlider = $('.parallax-slider');
                parallaxSlider.addClass("img img-fluid card-img-top rounded w-100")
            } else {
                mainImg.show();
            }
            /****************/
            /*PARALLAX IMAGE*/
            /*****END********/

            /***START***/
            /*COMMENTS*/
            /**********/
            $('.f-reply').hide();
            $('.btn-reply').click(function (){
                $('.f-reply').hide();
                let service = $(this).attr('id');
                let service_id = "#f-"+service;
                $(service_id).show('slow');
            })

            /**********/
            /*COMMENTS*/
            /***END****/
        });

    </script>
@endsection


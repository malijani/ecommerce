@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page.show', $page) }}

    <div class="container-fluid my-3">{{--MAIN CONTAINER--}}
        <div class="row justify-content-center">{{--MAIN ROW--}}

            {{--ASIDE CONTENT--}}
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--./ASIDE CONTENT--}}

            {{--MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg p-0">
                <div class="card border-0 p-0 rounded">
                    <div class="card-header text-center border-bottom-0">
                        <h3 class="h1" id="pageHeaderTitle">{{ $page->title }}</h3>
                    </div>
                    <div class="card-body p-1 p-lg-3 pb-3 ">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            {{--./MAIN CONTENT--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>

        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}

@endsection

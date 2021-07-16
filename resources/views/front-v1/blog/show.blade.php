@extends('layouts.app')

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog.article', $article) }}

    <div class="container-fluid my-3">
        <div class="row justify-content-center">

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>


            <div class="col-12 col-lg-8 my-2 shadow-lg rounded">{{--MAIN CONTENT--}}
                @include('front-v1.blog.article_show')
            </div>{{--./MAIN CONTENT--}}

            @include('front-v1.partials.shared.social_media_aside')
        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER-FLUID--}}




@endsection

{{--@push('scripts')
@endpush--}}


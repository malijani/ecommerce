@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog') }}
    {{--CONTAINER-FLUID--}}
    <div class="container-fluid my-3">
        {{--MAIN ROW--}}
        <div class="row justify-content-center">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>

            {{--SHOW ARTICLES--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg rounded py-md-4">
                <div class="row">
                    <section>
                        <div class="h1 text-center text-dark" id="pageHeaderTitle">
                            وبلاگ {{ config('app.short.name') }}
                        </div>
                        @foreach($articles as $article)
                            @include('front-v1.blog.article_brief')
                        @endforeach
                    </section>

                </div>
                {{--PAGINATION--}}
                @if($articles->hasPages())
                    <div class="row my-3 p-3">
                        <div class="mx-auto">
                            {{ $articles->links() }}
                        </div>
                    </div>
                @endif
                {{--./PAGINATION--}}
            </div>
            {{--./SHOW ARTICLES--}}

            @include('front-v1.partials.shared.social_media_aside')
        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./CONTAINER-FLUID--}}

@endsection

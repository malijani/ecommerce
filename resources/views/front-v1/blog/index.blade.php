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
            <div class="col-12 col-lg-8 my-2 shadow rounded py-md-4">
                @if(!empty($articles) && $articles->count())

                    <div class="row">
                        <section>
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

                @else
                    <div class="text-center">
                        <h4>مقاله ای برای نمایش وجود ندارد!</h4>
                    </div>
                @endif
            </div>
            {{--./SHOW ARTICLES--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>

        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./CONTAINER-FLUID--}}

@endsection

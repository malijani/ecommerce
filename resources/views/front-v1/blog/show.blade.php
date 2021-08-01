@extends('layouts.app')

@include('front-v1.partials.seo_metas', ['page_header' => $page_header ?? null])
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


            <div class="col-12 col-lg-8 my-2 shadow rounded">{{--MAIN CONTENT--}}
                @include('front-v1.blog.article_show')
            </div>{{--./MAIN CONTENT--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
                @if(!empty($other_articles) && $other_articles->count())
                    <div class="card p-0 mt-2 border-radius-0 border-0 shadow-sm">
                        <div class="card-header text-center">
                            <h6>سایر مقالات</h6>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            @foreach($other_articles as $other_article)
                                @if($other_article->id == $article->id)
                                    @continue
                                @endif
                                <li class="list-group-item">
                                    <a href="{{ route('blog.show', $other_article->title_en) }}"
                                       class="text-dark font-weight-bolder"
                                       title="مشاهده مقاله  {{ $other_article->title }}"
                                    >
                                        {{ $other_article->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                @endif
            </div>

        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER-FLUID--}}




@endsection

{{--@push('scripts')
@endpush--}}


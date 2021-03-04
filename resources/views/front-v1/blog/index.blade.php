@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog') }}

    <div class="container my-3">

        <div class="row">
            @foreach($articles as $article)
                <div class="col-12 col-lg-3 my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="d-flex align-items-center justify-content-center img-size-swiper">
                            <img class="img img-fluid"
                                 src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                                 alt="{{$article->pic_alt ?? $article->title_en}}"
                            >
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$article->title}}</h5>
                            <p class="card-text">{{ html_entity_decode($article->short_text_limited ?? $article->long_text_limited) }}</p>
                            <a href="{{ route('blog.show', $article->title_en) }}" class="btn btn-primary">ادامه
                                مطلب</a>
                        </div>
                    </div>

                </div>{{--col-12--}}
            @endforeach

        </div>{{--row--}}
        <div class="row my-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>{{--container--}}

@endsection

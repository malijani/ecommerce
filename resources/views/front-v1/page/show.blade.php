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
            <div class="col-12 col-lg-8 my-2 shadow p-0">
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

                @if(!empty($other_pages) && $other_pages->count())
                    <div class="card p-0 mt-2 border-radius-0 border-0 shadow-sm">
                        <div class="card-header text-center">
                            <h6>سایر صفحات</h6>
                        </div>
                        <ul class="list-group list-group-flush text-center">
                            @foreach($other_pages as $other_page)
                                @if($other_page->id == $page->id)
                                    @continue
                                @endif
                                <li class="list-group-item">
                                    <a href="{{ route('page.show', $other_page->title_en) }}"
                                       class="text-dark font-weight-bolder"
                                       title="مشاهده صفحه {{ $other_page->title }}"
                                    >
                                        {{ $other_page->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                @endif

            </div>

        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}

@endsection

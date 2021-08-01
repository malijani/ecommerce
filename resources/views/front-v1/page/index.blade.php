@extends('layouts.app')

@include('front-v1.partials.seo_metas', ['page_header' => $page_header ?? null])

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page') }}

    <div class="container-fluid my-3">{{--MAIN CONTAINER--}}

        <div class="row justify-content-center">{{--MAIN ROW--}}

            {{--ASIDE CONTENT--}}
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--ASIDE CONTENT--}}


            <div class="col-12 col-lg-8 my-2 shadow rounded">
                <div class="row">
                    @foreach($pages as $page)
                        @include('front-v1.page.page_brief', ['page' => $page, 'loop'=> $loop])
                    @endforeach
                    {{--PAGINATION--}}
                    @if($pages->hasPages())
                        <div class="mx-auto my-3">
                            {{ $pages->links() }}
                        </div>
                    @endif
                    {{--PAGINATION--}}
                </div>


            </div>

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>

        </div>{{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}

@endsection

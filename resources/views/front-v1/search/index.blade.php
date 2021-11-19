@extends('layouts.app')

@include('front-v1.partials.seo_metas', ['page_header' => $page_header ?? null])

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands') }}

    <div class="container-fluid">
        <div class="row my-2">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow rounded py-md-4">
                <div class="row">
                    <div class="col-12" id="search-form">
                          @include('front-v1.search.form_content')
                    </div>
                    <div class="col-12" id="search-box">

                    </div>
                </div>
            </div>
            {{--./SHOW MAIN CONTENT--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>
        </div>

        @include('front-v1.partials.shared.social_media_banner')

    </div>
@endsection

@push('scripts')

    <script>
        /*$('#search-form').on('submit', function (e) {
            e.preventDefault();
        });*/
    </script>
@endpush

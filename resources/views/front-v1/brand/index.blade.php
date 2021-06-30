@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands') }}

    <div class="container-fluid">
        <div class="row my-2">
            @include('front-v1.partials.shared.basket_aside')
            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg rounded py-md-4">
                @if(!empty($brands) && $brands->count())
                    @include('front-v1.partials.brands', ['brands'=>$brands])

                    <div class="row justify-content-center my-3">
                        {{ $brands->links() }}
                    </div>
                @else
                    <div class="text-center">
                        <h4>برندی برای نمایش وجود ندارد!</h4>
                    </div>
                @endif
            </div>
            {{--./SHOW MAIN CONTENT--}}

            @include('front-v1.partials.shared.social_media_aside')
        </div>

        @include('front-v1.partials.shared.social_media_banner')

    </div>
@endsection

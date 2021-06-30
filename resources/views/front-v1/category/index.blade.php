@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories') }}

    <div class="container-fluid">
        <div class="row my-2">

            @include('front-v1.partials.shared.basket_aside')

            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 px-0 px-md-4 rounded shadow-lg">
                @if(!empty($categories) && $categories->count())
                @foreach($categories as $parent_category)
                    <a href="{{ route('category.show', $parent_category->title_en) }}"
                       title="مشاهده دسته بندی {{ $parent_category->title }}"
                    >
                        <div class="row my-2 bg-light align-items-center">

                            <div class="col text-center pt-1">
                                <img src="{{ asset($parent_category->pic ?? 'images/fallback/category.png') }}"
                                     alt="{{ $parent_category->pic_alt ?? $parent_category->title_en }}"
                                     class="img img-fluid rounded pr-0"
                                >
                            </div>
                            <div class="col text-dark text-right">
                                <h3 class="font-20">
                                    {{ $parent_category->title }}
                                    <i class="fal fa-arrow-alt-down align-middle pr-3"></i>
                                </h3>

                            </div>


                        </div>
                    </a>

                    <div class="my-5">
                        @include('front-v1.partials.carousel.categories', ['categories'=>$parent_category->childrenRecursive, 'level'=>$loop->iteration])
                    </div>
                    @if($loop->last)
                        @continue
                    @else
                        <hr class="w-50">
                    @endif
                @endforeach
                @else
                    <div class="text-center">
                        <h4>دسته بندی برای نمایش وجود ندارد!</h4>
                    </div>
                @endif
            </div>
            {{--./SHOW MAIN CONTENT--}}


            @include('front-v1.partials.shared.social_media_aside')

        </div>


     @include('front-v1.partials.shared.social_media_banner')

    </div>

@endsection

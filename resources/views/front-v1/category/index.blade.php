@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories') }}

    <div class="container-fluid">
        <div class="row my-2">
            {{--SHOW BASKET BRIEF--}}
            <div class="d-none d-lg-block col-lg-2">
                <div class="row rounded py-2">
                    <div class="col-12">
                        <div class="bg-primary"
                             style="height: 300px">
                        </div>
                    </div>
                </div>
            </div>
            {{--./SHOW BASKET BRIEF--}}

            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8">
                @foreach($categories as $parent_category)
                    <a href="{{ route('category.show', $parent_category->title_en) }}"
                       class="text-dark pr-3"
                       title="مشاهده دسته بندی {{ $parent_category->title }}"
                    >
                        <div class="row my-2 py-1 bg-light align-items-center">

                            <div class="col-4">
                                <img src="{{ $parent_category->pic ?? 'images/fallback/category.png' }}"
                                     alt="{{ $parent_category->pic_alt ?? $parent_category->title_en }}"
                                     class="img img-fluid rounded pr-0 pb-0"
                                >
                            </div>
                            <div class="col-4">
                                <h3>
                                    {{ $parent_category->title }}
                                    <i class="fal fa-arrow-alt-down align-middle pr-3"></i>
                                </h3>
                            </div>


                        </div>
                    </a>

                    <div class="my-4">
                        @include('front-v1.partials.carousel.categories', ['categories'=>$parent_category->childrenRecursive, 'level'=>$loop->iteration])
                    </div>
                @endforeach
            </div>
            {{--./SHOW MAIN CONTENT--}}


            {{--SHOW SOCIAL MEDIA SIDE IMAGES--}}
            <div class="d-none d-lg-block col-lg-2">
                <div class="row">
                    @if(!empty($social_medias) && $social_medias->count())
                        @foreach($social_medias as $social_media)
                            <div class="col-12 py-2">
                                <img src="{{ $social_media->side_image }}"
                                     alt="{{ $social_media->title }}"
                                     class="img img-fluid w-100 rounded"
                                >
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{--./SHOW SOCIAL MEDIA SIDE IMAGES--}}

        </div>


        {{--SHOW SOCIAL MEDIA BANNER IMAGES--}}
        @if(!empty($social_medias) && $social_medias->count())
            <div class="row my-5">
                @foreach($social_medias as $social_media)
                    <div class="d-block d-lg-none col-12">
                        <img src="{{ asset($social_media->banner_image)  }}"
                             alt="{{ $social_media->title }}"
                             class="img img-fluid w-100 rounded social_media_banner_img"

                        >
                    </div>
                @endforeach
            </div>
        @endif
        {{--./SHOW SOCIAL MEDIA BANNER IMAGES--}}

    </div>

@endsection

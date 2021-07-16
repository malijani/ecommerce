<div class="row">{{--ARTICLE SHOW--}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="text-dark font-24">
                    {{$article->title}}
                </h3>
            </div>

            <div class="col-12">
                <div class="row align-items-center justify-content-around">
                    <div class="badge badge-secondary p-2 mt-1">
                        <i class="fal fa-user-alt align-middle ml-2"></i>
                        نویسنده {{ $article->user->full_name }}
                    </div>

                    <div class="badge badge-secondary p-2 mt-1">
                        <i class="fal fa-watch align-middle ml-2"></i>
                        زمان مطالعه {{ $article->period }} دقیقه
                    </div>

                    <div class="badge badge-secondary p-2 mt-1">
                        <i class="fal fa-eye align-middle ml-2"></i>
                        {{ $article->visit }} بازدید
                    </div>


                    <a href="{{ route('category.show', $article->category->title_en) }}"
                       title="مشاهده دسته بندی {{ $article->category->title_en }}"
                       class="text-light"
                    >
                        <div class="badge badge-secondary p-2 mt-1">
                            <i class="fal fa-list-alt align-middle ml-2"></i>

                            دسته بندی {{ $article->category->title }}

                        </div>
                    </a>


                    <a href="#comments"
                       title="رفتن به بخش نظرات"
                       class="text-light"
                    >
                        <div class="badge badge-secondary p-2 mt-1">
                            <i class="fal fa-comment align-middle ml-2"></i>

                            {{ $article->activeComments->count() }} نظر

                        </div>
                    </a>

                    <a href="#ratings"
                       title="رفتن به بخش ثبت رأی"
                       class="text-light"
                    >
                        <div class="badge badge-secondary p-2 mt-1">
                            <i class="fal fa-star align-middle ml-2"></i>
                            {{ $article->ratingsCount() }} رأی
                        </div>
                    </a>

                    <div class="p-2 mt-1">
                        @include('front-v1.partials.rating_stars', ['model'=> $article])
                    </div>

                </div>
            </div>


        </div>
        <img class="card-img-top"
             src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
             alt="{{$article->pic_alt ?? $article->title_en}}"
        >

        <div class="card-body border-bottom mt-2 p-0 p-md-3 bg-light">


            <div class="card-text px-2">
                {!! $article->long_text !!}
            </div>
            <div class="card-footer border-top-0">
                <small class="text-muted">
                    آخرین بروز رسانی {{ verta($article->updated_at)->formatDifference() }}
                </small>
            </div>



            {{--ARTICLE SUGGESTION--}}
            <div class="col-12 my-2">
                <div class="row align-items-center">
                    @if(!empty($article->bef))
                        <div
                            class="col-12 col-md-6 mt-2 mt-md-0 ml-auto text-right bg-light before_product_suggestion">
                            <a href="{{ route('blog.show' , $article->bef->title_en) }}"
                               class="text-dark"
                            >
                                <div class="row align-items-center justify-content-between ">
                                    <div class="col-1">
                                                <span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                    </div>
                                    <div class="col-6 text-center">
                                        <p>
                                            {{ $article->bef->title }}
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <img src="{{ asset($article->bef->pic) }}"
                                             alt="{{ $article->bef->pic_alt }}"
                                             id="main-image"
                                             class="img-fluid product-image rounded product_suggest_img"

                                        >
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endif
                    @if(!empty($article->af))
                        <div
                            class="col-12 col-md-6 mt-2 mt-md-0 mr-auto text-left bg-light after_product_suggestion">
                            <a href="{{ route('blog.show' , $article->af->title_en) }}"
                               class="text-dark"
                            >
                                <div class="row align-items-center justify-content-between ">

                                    <div class="col-4">
                                        <img src="{{ asset($article->af->pic) }}"
                                             alt="{{ $article->af->pic_alt }}"
                                             id="main-image"
                                             class="img-fluid product-image rounded product_suggest_img"

                                        >
                                    </div>

                                    <div class="col-6 text-center">
                                        <p>
                                            {{ $article->af->title }}
                                        </p>

                                    </div>

                                    <div class="col-1">
                                                <span>
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            {{--ARTICLE SUGGESTION--}}

        </div>




        <div class="col-12">
            {{--RATING--}}
            <div class="row bg-white py-3 mt-3 rounded">
                @include('front-v1.partials.rating', ['user_rate'=>getUserRating($article), 'model'=>$article])
            </div>
            {{--./RATING--}}

            {{--COMMENTS--}}
            <div class="row bg-white mb-5 mt-3 py-3 rounded">
                @include('front-v1.partials.comment_template', ['comments'=>$comments,'model'=>$article])
            </div>
            {{--./COMMENTS--}}

        </div>
    </div>
</div>{{--./ARTICLE SHOW--}}


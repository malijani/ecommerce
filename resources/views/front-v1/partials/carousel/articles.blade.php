<div class="container-fluid mt-1 mt-md-2">
    <div class="row align-items-center">

        <div class="oc-articles-{{ $level ?? '0'  }}-prev col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-right fa-2x"></i>
        </div>
        <div class="col-12 col-md-10">
            <div class="oc-articles-{{ $level ?? '0'  }} owl-carousel owl-theme">
                @foreach($articles as $article)
                    <a href="{{ route('blog.show', $article->title_en) }}"
                       title="مشاهده  مقاله  {{ $article->title  }}"
                    >
                        <div class="row justify-content-between align-items-center rounded mx-1 text-center py-4">
                                {{--SHOW IMAGE --}}
                                <div class="col-12">
                                    <img class="img img-fluid rounded"
                                         src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                                         alt="{{ $product->pic_alt ?? $article->title_en }}"
                                    >
                                </div>

                                {{--SHOW TITLE & TITLE EN--}}
                                <div class="col-12 py-2 mt-1 font-weight-bolder font-18 text-dark">
                                    <span class="text-right">
                                        {{ $article->title }}
                                    </span>
                                </div>

                                {{--SHOW PRICE--}}
                                <div class="col-12 mt-1 font-14 text-dark">
                                    {{ $article->short_text_limited }}
                                </div>
                            <div class="col-12 mt-1">
                                <button class="btn btn-outline-secondary w-100">
                                    ادامه مطلب
                                </button>
                            </div>
                            </div>

                    </a>

                @endforeach
            </div>
        </div>
        <div class="oc-articles-{{ $level ?? '0' }}-next col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-left fa-2x"></i>
        </div>

        {{--MOBILE BUTTONS--}}
        <div class="col-12 d-md-none text-center mt-2">
            <div class="row">
                <div class="oc-articles-{{ $level ?? '0' }}-prev col-6 ">
                        <span class="btn btn-outline-secondary">
                            <i class="fal fa-chevron-right align-middle"></i>
                        </span>
                </div>
                <div class="oc-articles-{{ $level ?? '0' }}-next col-6">
                        <span class="btn btn-outline-secondary">
                            <i class="fal fa-chevron-left align-middle ml-0"></i>
                        </span>
                </div>
            </div>
        </div>
        {{--./MOBILE BUTTONS--}}

    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {

            let articles_owl = $('.oc-articles-{{ $level ?? '0' }}');

            articles_owl.owlCarousel({
                loop: @if($articles->count() > 4) true @else false @endif,
                autoplay: @if($articles->count() > 4) true @else false @endif,
                rtl: true,
                margin: 20,
                autoplayHoverPause: true,
                autoplayTimeout: 5000,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                nav: false,
                navElement: 'span',
                dots: false,
                rewind: false,
                responsiveClass: true,
                responsiveRefreshRate: true,
                responsive: {
                    0: {
                        items: 1,
                        slideBy: 1,
                    },
                    576: {
                        items: 1,
                        slideBy: 1,
                    },
                    768: {
                        items: 2,
                        slideBy: 1,
                    },
                    999: {
                        items: 3,
                        slideBy: 1,
                    },
                    1400: {
                        items: 4,
                        slideBy: 1,
                    }
                }
            });
            $('.oc-articles-{{ $level ?? '0' }}-next').on('click', function () {
                articles_owl.trigger('next.owl.carousel');
                articles_owl.trigger('stop.owl.autoplay');
            });
            $('.oc-articles-{{ $level ?? '0' }}-prev').on('click', function () {
                articles_owl.trigger('prev.owl.carousel');
                articles_owl.trigger('stop.owl.autoplay');
            });

        });
    </script>
@endpush



<div class="container-fluid mt-2">
    <div class="row align-items-center">
        <div class="oc-categories-prev col-1 text-center cursor-pointer">
            <i class="far fa-angle-right fa-2x"></i>
        </div>
        <div class="col-10">
            <div class="oc-categories owl-carousel owl-theme">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->title_en) }}"
                       title="مشاهده محصولات و جزییات دسته بندی {{ $category->title  }}"
                    >
                        <div class="row justify-content-between align-items-center bg-light rounded mx-1">

                            <div class="col-8 text-center font-16 font-weight-bolder text-dark"
                            >
                                    {{ $category->title }}
                            </div>
                            <div class="col-4 p-0">
                                <img class="img img-fluid rounded pl-0"
                                     src="{{ asset($category->pic ?? 'images/fallback/category.png') }}"
                                     alt="{{ $category->pic_alt ?? $category->title_en }}"
                                >
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="oc-categories-next col-1 text-center cursor-pointer">
            <i class="far fa-angle-left fa-2x"></i>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            let categories_owl = $('.oc-categories');

            categories_owl.owlCarousel({
                loop:@if($categories->count() > 4) true @else false @endif,
                rtl: true,
                margin: 20,
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 5000,
                animateIn: 'linear',
                animateOut: 'linear',
                nav: false,
                navElement: 'span',
                dots: false,
                rewind: false,
                responsiveClass: true,
                responsiveRefreshRate:true,
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
            $('.oc-categories-next').on('click', function () {
                categories_owl.trigger('next.owl.carousel');
                categories_owl.trigger('stop.owl.autoplay');
            });
            $('.oc-categories-prev').on('click', function () {
                categories_owl.trigger('prev.owl.carousel');
                categories_owl.trigger('stop.owl.autoplay');
            });

        });
    </script>
@endpush



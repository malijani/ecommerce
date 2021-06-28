<div class="container-fluid mt-1 mt-md-2">
    <div class="row align-items-center">

        {{--MOBILE BUTTONS--}}
        <div class="col-12 d-md-none text-center mb-2">
            <div class="row">
                <div class="oc-brands-{{ $level ?? '0' }}-prev col-6 ">
                        <span class="btn btn-outline-secondary">
                            <i class="fal fa-chevron-right align-middle"></i>
                        </span>
                </div>
                <div class="oc-brands-{{ $level ?? '0' }}-next col-6">
                        <span class="btn btn-outline-secondary">
                            <i class="fal fa-chevron-left align-middle ml-0"></i>
                        </span>
                </div>
            </div>
        </div>
        {{--./MOBILE BUTTONS--}}


        <div class="oc-brands-{{ $Level ?? '0' }}-prev col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-right fa-2x"></i>
        </div>
        <div class="col-12 col-md-10">
            <div class="oc-brands-{{ $Level ?? '0' }} owl-carousel owl-theme">
                @foreach($brands as $brand)
                    <a href="{{ route('brand.show', $brand->title_en) }}"
                       title="مشاهده محصولات و جزییات برند {{ $brand->title  }}"
                    >
                        <div class="row justify-content-between align-items-center bg-light rounded mx-1">
                            <div class="col-8 text-center font-16 font-weight-bolder text-dark"
                            >
                                <div class="pt-1">
                                    {{ $brand->title }}
                                </div>
                                <div class="pt-1">
                                    {{ str_replace('-', ' ', $brand->title_en) }}
                                </div>


                            </div>
                            <div class="col-4 p-0">
                                <img class="img img-fluid rounded pl-0"
                                     src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                                     alt="{{ $brand->pic_alt ?? $brand->title_en }}"
                                >
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="oc-brands-{{ $Level ?? '0' }}-next col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-left fa-2x"></i>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            let brands_owl = $('.oc-brands-{{ $Level ?? '0' }}');

            brands_owl.owlCarousel({
                loop: @if($brands->count() > 4) true @else false @endif,
                autoplay: @if($brands->count() > 4) true @else false @endif,
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

            $('.oc-brands-{{ $Level ?? '0' }}-next').on('click', function () {
                brands_owl.trigger('next.owl.carousel');
                brands_owl.trigger('stop.owl.autoplay');
            });
            $('.oc-brands-{{ $Level ?? '0' }}-prev').on('click', function () {
                brands_owl.trigger('prev.owl.carousel');
                brands_owl.trigger('stop.owl.autoplay');
            });

        });
    </script>
@endpush



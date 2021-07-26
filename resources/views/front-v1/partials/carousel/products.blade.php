<div class="container-fluid mt-1 mt-md-2">
    <div class="row align-items-center">

        <div class="oc-products-{{ $level ?? '0'  }}-prev col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-right fa-2x"></i>
        </div>
        <div class="col-12 col-md-10">
            <div class="oc-products-{{ $level ?? '0'  }} owl-carousel owl-theme">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->title_en) }}"
                       title="مشاهده  جزییات محصول {{ $product->title  }}"
                    >
                        <div class="@if(empty($product->entity)) border border-danger rounded @endif ">
                            <div class="row justify-content-between align-items-center rounded mx-1 text-center pb-md-4">
                                {{--SHOW IMAGE AND BADGES(DISCOUNT,ENTITY)--}}
                                <div class="col-12">
                                    <img class="img img-fluid rounded img-size-swiper"
                                         src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/product.png') }}"
                                         alt="{{ $product->files()->defaultFile()->title ?? $product->title_en }}"
                                    >

                                    @if(empty($product->entity))
                                        <span class="badge badge-danger position-absolute right-bottom-0 p-1 mr-3">
                                        ناموجود
                                        <em>!</em>
                                    </span>
                                    @else
                                        @if(!empty($product->discount_percent))
                                            <span class="badge badge-success position-absolute right-bottom-0 p-1 mr-3">
                                        {{ $product->discount_percent . '% تخفیف' }}
                                    </span>
                                        @endif
                                    @endif
                                </div>

                                {{--SHOW TITLE & TITLE EN--}}
                                <div class="col-12 py-2 mt-1 mt-md-3  font-weight-bolder font-18 text-dark">
                                    <span class="text-right">
                                        {{ $product->title . ' | ' }}
                                    </span>
                                    <br>
                                    <span class="text-left">
                                    {{ str_replace('-', ' ', $product->title_en) }}
                                    </span>
                                </div>

                                {{--SHOW PRICE--}}
                                <div class="col-12 mt-1 mt-md-3 font-weight-bolder font-18 text-dark">
                                    @if(in_array($product->price_type, [0,1]))

                                        @if(!empty($product->discount_percent))
                                            <sup class="discount">
                                                {{ number_format($product->price) }}
                                            </sup>
                                        @endif
                                        <span>
                                        {{ number_format($product->final_price) . ' تومن '}}
                                    </span>
                                    @elseif($product->price_type == 2)
                                        <span>
                                            <i class="fal fa-phone"></i>
                                            تماس بگیرید
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>

                @endforeach
            </div>
        </div>
        <div class="oc-products-{{ $level ?? '0' }}-next col-1 text-center cursor-pointer d-none d-md-block">
            <i class="far fa-angle-left fa-2x"></i>
        </div>

        {{--MOBILE BUTTONS--}}
        <div class="col-12 d-md-none text-center mt-2">
            <div class="row">
                <div class="oc-products-{{ $level ?? '0' }}-prev col-6 ">
                        <span class="btn btn-outline-secondary">
                            <i class="fal fa-chevron-right align-middle"></i>
                        </span>
                </div>
                <div class="oc-products-{{ $level ?? '0' }}-next col-6">
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

            let products_owl = $('.oc-products-{{ $level ?? '0' }}');

            products_owl.owlCarousel({
                loop: @if($products->count() > 4) true @else false @endif,
                autoplay: @if($products->count() > 4) true @else false @endif,
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
            $('.oc-products-{{ $level ?? '0' }}-next').on('click', function () {
                products_owl.trigger('next.owl.carousel');
                products_owl.trigger('stop.owl.autoplay');
            });
            $('.oc-products-{{ $level ?? '0' }}-prev').on('click', function () {
                products_owl.trigger('prev.owl.carousel');
                products_owl.trigger('stop.owl.autoplay');
            });

        });
    </script>
@endpush



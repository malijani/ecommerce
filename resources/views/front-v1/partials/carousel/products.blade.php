<div class="container-fluid mt-2">
    <div class="row align-items-center">
        <div class="oc-products-prev col-1 text-center cursor-pointer">
            <i class="far fa-angle-right fa-2x"></i>
        </div>
        <div class="col-10">
            <div class="oc-products owl-carousel owl-theme">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->title_en) }}"
                       title="مشاهده  جزییات محصول {{ $product->title  }}"
                    >
                        <div
                            class="row justify-content-between align-items-center rounded @if(empty($product->entity)) border border-danger @endif mx-1 text-center py-4">

                            <div class="col-12">
                                <img class="img img-fluid rounded "
                                     src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/product.png') }}"
                                     alt="{{ $product->files()->defaultFile()->title ?? $product->title_en }}"
                                     style="min-height: 500px; max-height: 500px"
                                >
                                @if(!empty($product->discount_percent))
                                    <span class="badge badge-primary position-absolute left-top-0 p-3 ml-3 font-18">
                                        {{ $product->discount_percent . '%' }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-12 py-2 mt-3 font-weight-bolder text-dark">
                                <span class="text-right">
                                    {{ $product->title . ' | ' }}
                                </span>
                                <br>
                                <span class="text-left">
                                    {{ str_replace('-', ' ', $product->title_en) }}
                                </span>

                            </div>
                            <div class="col-12 mt-3 font-weight-bolder text-dark">
                                @if(!empty($product->discount_percent))
                                    <sup class="discount">
                                        {{ number_format($product->price) }}
                                    </sup>
                                @endif

                                {{ number_format($product->final_price) . ' تومن '}}

                            </div>
                        </div>
                    </a>

                @endforeach
            </div>
        </div>
        <div class="oc-products-next col-1 text-center cursor-pointer">
            <i class="far fa-angle-left fa-2x"></i>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {

            let products_owl = $('.oc-products');

            products_owl.owlCarousel({
                loop: @if($products->count() > 4) true @else false @endif,
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
            $('.oc-products-next').on('click', function () {
                products_owl.trigger('next.owl.carousel');
                products_owl.trigger('stop.owl.autoplay');
            });
            $('.oc-products-prev').on('click', function () {
                products_owl.trigger('prev.owl.carousel');
                products_owl.trigger('stop.owl.autoplay');
            });

        });
    </script>
@endpush



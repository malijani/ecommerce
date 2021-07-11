<div class="container-fluid">
    <div class="row align-items-baseline justify-content-center">
        @foreach($products as $product)

            <div class="col-12 col-md-6 col-lg-4 col-xl-3 my-4">
                <a href="{{ route('product.show', $product->title_en) }}"
                   title="مشاهده  جزییات محصول {{ $product->title  }}"
                >
                    <div class="@if(empty($product->entity)) border border-danger @endif bg-light rounded">
                        <div class="row justify-content-between align-items-center rounded mx-1 text-center py-4">
                            {{--SHOW IMAGE AND BADGES(DISCOUNT,ENTITY)--}}
                            <div class="col-12 ">
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
            </div>
        @endforeach
    </div>
</div>



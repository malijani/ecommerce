@foreach($products as $product)
    <a href="{{ route('product.show', $product->title_en) }}">
        <div class="@if(!$carousel) col-12 col-md-3 col-lg-2 @endif text-center py-3">
            <div class="d-flex align-items-center justify-content-center img-size-swiper rounded">
                <img class="img card-img-top"
                     src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png') }}"
                     alt="{{$product->files()->defaultFile()->title}}"
                >
            </div>

            <h4 class="font-14 mt-2 text-right">{{ $product->title }}</h4>


            {{--SHOW PRICE--}}
            <div class="d-flex justify-content-between align-items-center py-3">
                @if($product->price_type=="0" && $product->discount_percent != "0")
                    <span>{{$product->show_discount_price}} تومن</span>
                    <span class="discount">{{ $product->show_price}} تومن</span>

                    <span class="position-absolute discount-label font-12 m-5">
                            {{ $product->discount_percent }}%  تخفیف
                </span>

                @elseif($product->price_type=="1")
                    <span>{{$product->show_price}} تومن</span>
                @else
                    <span class="badge badge-info">
                    <i class="fa fa-phone"></i>
                    تماس بگیرید
                </span>
                @endif
            </div>

        </div>
    </a>

@endforeach

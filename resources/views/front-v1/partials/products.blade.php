@if(isset($products))

    @foreach($products as $product)
        <!--Grid column-->
        <div class="@if(!$carousel) col-lg-3 col-md-6 mb-4 @endif">

            <!--Card-->
            <div class="card ">

                <!--Card image-->
                <div class="view overlay">
                    <img
                        src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/product.png') }}"
                        class="card-img-top img img-fluid img-size-swiper"
                        alt="{{ $product->files()->defaultFile()->title }}"
                    >
                    <a href="{{ route('product.show', $product->title_en) }}">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
                <!--Card image-->

                <!--Card content-->
                <div class="card-body text-center">
                    <!--Category & Title-->
                    {{--<a href="{{ route('category.show', $product->category->title_en) }}"
                       class="grey-text font-8"
                    >
                        <span>{{ $product->category->title }}</span>
                    </a>--}}
                    <h5>
                        <strong>
                            <a href="{{ route('product.show', $product->title_en) }}"
                               class="dark-grey-text font-16"
                            >
                                {{ $product->title }}
                                <br>
                                {{ str_replace('-', ' ', $product->title_en) }}
                                @if($product->price_type=="0" && $product->discount_percent != "0")
                                    <br>
                                    <span class="badge badge-success">
                                                 {{ $product->discount_percent }}%  تخفیف
                                            </span>
                                @endif
                            </a>
                        </strong>
                    </h5>

                    <h4>
                        <strong>
                            <a href="{{ route('product.show', $product->title_en) }}"
                               class="text-dark"
                            >
                                @if($product->price_type=="0" && $product->discount_percent != "0")
                                    <span class="font-weight-bold">
                                            {{ $product->show_discount_price }} تومن
                                        </span>
                                    <span class="discount text-muted font-12">
                                            {{ $product->show_price }}
                                        </span>

                                @elseif($product->price_type=="1")
                                    <span class="font-weight-bold">
                                            {{ $product->show_price }} تومن
                                        </span>
                                @else
                                    <span class="badge badge-info">
                                            <i class="fa fa-phone"></i>
                                            تماس بگیرید
                                        </span>
                                @endif
                            </a>
                        </strong>
                    </h4>

                </div>
                <!--Card content-->
            </div>
            <!--Card-->
        </div>
        <!--Grid column-->
    @endforeach
@endif

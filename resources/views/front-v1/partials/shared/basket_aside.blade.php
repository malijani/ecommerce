{{--SHOW BASKET BRIEF--}}
<div class="row rounded py-2">
    <div class="col-12">
        <a class="btn btn-custom w-100"
           data-toggle="collapse"
           href="#basket_aside_collapse"
           role="button"
           aria-expanded="false"
           aria-controls="basket_aside_collapse">
            <i class="fal fa-shopping-basket align-middle"></i>
            سبد خرید
        </a>

        <aside class="basket_aside">
            <div class="row collapse @if(Request::routeIs('product.*') || Request::routeIs('brand.*')) show @endif"
                 id="basket_aside_collapse"
            >

                @if(!empty(session()->get('basket')))
                    <div class="col-12">
                        <a role="link"
                           href="{{ route('cart.index') }}"
                           class="btn basket_aside_button w-100"
                        >
                            <i class="fal fa-shopping-cart"></i>
                            رفتن به سبد خرید
                        </a>
                    </div>
                    @foreach(array_reverse(session()->get('basket')) as $key=>$value)


                        <div class="col-12">
                            <a href="{{ route('product.show',$value['title_en']) }}"
                               title="{{ $value['title'] }}"
                            >
                                <div class="card text-center my-1 py-3 basket_aside_card">
                                    <img class="card-img-top img img-fluid img-responsive product_basket_aside_image"
                                         src="{{ asset($value['pic']) }}"
                                         alt="{{ $value['title'] }}">
                                    <div class="card-body p-0 pt-1 text-dark">
                                        <div class="row">
                                            <div class="col-12 text-center"
                                                 id=""
                                            >
                                                <h5 class="card-title font-16">
                                                    {{ $value['title'] }}
                                                </h5>
                                                <h6 class="font-14">
                                                    {{ str_replace('-', ' ', $value['title_en']) }}
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-12 p-1">
                                                    @if(is_array($value['attribute'])&&count($value['attribute']))
                                                        {{--SHOW ATTRIBUTES--}}
                                                        <div class="row align-items-center">
                                                            @foreach($value['attribute'] as $product_attr_key => $attr_array)
                                                                <div class="col-12">
                                                                    @foreach($attr_array as $attr_key => $attr_value)
                                                                        @if($attr_key == "quantity")
                                                                            <span
                                                                                class="text-dark font-weight-bolder font-14">
                                                                            {{ $attr_value }} عدد
                                                                        </span>
                                                                        @else
                                                                            <span class="badge badge-light">
                                                                               {{ $attr_value }}
                                                                        </span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    @else
                                                        <span class="text-dark font-weight-bolder font-14">{{ $value['quantity'] }} عدد</span>
                                                    @endif
                                                </div>
                                                <div class="col-12 p-1">
                                                    <span>{{ number_format($value['price']) }} تومن</span>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach

                @else
                    <div class="col-12 text-center">
                        <div class="card basket_aside_card bg-light">
                            <div class="card-body">
                                <h5 class="font-16 text-dark">
                                    سبد خرید خالی
                                </h5>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </aside>
    </div>
</div>
{{--./SHOW BASKET BRIEF--}}

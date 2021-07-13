{{--SHOW BASKET BRIEF--}}

<div class="row">
    <div class="col-12">
        @if(!empty(session()->get('basket')))
            <div class="card border-0 shadow-sm">

                <div class="card-header border-bottom-0 text-center">
                    <h5 class="">
                        <a href="{{ route('cart.index') }}"
                           class="btn btn-light w-100 font-18 font-weight-bolder"
                        >
                            <i class="fal fa-shopping-cart fa-2x align-middle"></i>
                            سبد خرید
                        </a>
                    </h5>
                </div>

                <div class="card-body row align-items-stretch justify-content-center">
                    @foreach(array_reverse(session()->get('basket')) as $key=>$value)
                        <div class="col-12 col-md-6 col-lg-4 my-2">
                            <a href="{{ route('product.show',$value['title_en']) }}"
                               title="{{ $value['title'] }}"
                            >
                                <div class="card text-center my-1 py-1 border-0 bg-light h-100">
                                    <img class="card-img-top img img-fluid img-responsive rounded basket_brief_img"
                                         src="{{ asset($value['pic']) }}"
                                         alt="{{ $value['title'] }}"
                                         loading="lazy"
                                    >
                                    <div class="card-body text-dark">
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
                                                                            <span class="badge badge-secondary">
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
                </div>
            </div>

        @else
            <div class="col-12 text-center">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="font-16 text-dark">
                            سبد خرید خالی!
                        </h5>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>
{{--./SHOW BASKET BRIEF--}}

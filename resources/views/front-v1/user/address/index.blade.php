@extends('layouts.app')

@section('content')


    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('address') }}


    <div class="container-fluid my-3">
        <div class="row">

            {{--FINAL TOTAL PAY--}}
            <div class="col-12 col-xl-4 order-second order-xl-first">
                @include('front-v1.user.address.final_total')
            </div>
            {{--./FINAL TOTAL PAY--}}

            {{--ADDRESS--}}
            <div class="col-12 col-xl-8 order-first order-xl-second">
                @include('front-v1.partials.address')
            </div>
            {{--./ADDRESS--}}

            {{--BASKET BRIEF--}}
            <div class="col-12 mt-5">
                @include('front-v1.partials.basket_brief')
            </div>
            {{--./BASKET BRIEF--}}

        </div>{{--./MAIN ROW--}}

        @include('front-v1.partials.shared.page_image_menu')
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}


    <div class="container my-3 rounded">
        <div class="row bg-white">


            <div class="col-12  col-lg-8 py-4 order-1">{{--addresses--}}
                @include('front-v1.partials.address') {{--It gets default_address, addresses--}}
            </div>{{--./addresses--}}


            {{--SHOW BASKET--}}
            <div class="col-12  col-lg-8 py-4 order-2 order-md-3">
                <h4>سبد سفارش</h4>
                @foreach($basket as $key=>$value)
                    <div class="row d-flex align-items-center text-center mb-4 ml-1 mr-1  p-3 rounded bg-whitesmoke"
                         id="product-{{$key}}">
                        {{--SHOW IMAGE--}}
                        <div class="col-md-3">
                            <a href="{{ route('product.show', $value['title_en'])  }}">
                                <img src="{{ asset($value['pic']) }}"
                                     alt="{{ $value['title']  }}"
                                     class="img-fluid img-cart rounded"
                                >
                            </a>
                        </div>
                        {{--SHOW TITLE--}}
                        <div class="col-md-3 my-3 my-md-0">
                            <a href="{{ route('product.show', $value['title_en'])  }}" class="text-dark">
                                <p class="font-weight-bolder">{{$value['title']}}</p>
                            </a>
                        </div>
                        {{--SHOW QUANTITY--}}
                        <div class="col-md-2">
                            @if(count($value['attribute']))
                                <button type="button"
                                        class="text-dark bg-white btn my-0 font-weight-bolder">
                                    {{ $value['quantity'] }}
                                </button>
                                عدد
                            @else
                                <div
                                    class="btn-group btn-group direction-ltr border rounded"
                                    role="group"
                                >
                                    <button type="button"
                                            class="text-dark bg-white btn my-0 font-weight-bolder"
                                    >
                                        {{ $value['quantity']  }}
                                    </button>
                                </div>
                                عدد
                            @endif
                        </div>
                        {{--SHOW PRICE--}}
                        <div class="col-md-3 my-3 my-md-0">
                            <b>{{ number_format($value['price']) }} تومن</b>
                            @if($value['total_discount'] > 0)
                                <br>
                                <em class="text-success">
                                    {{ " ٪ " . $value['discount_percent']}}
                                    تخفیف گرفتی
                                    <br>
                                    {{ number_format($value['total_discount']) . " تومن " }}


                                </em>
                            @endif
                        </div>
                        {{--BREAK POINT COL--}}
                        @if(is_array($value['attribute'])&&count($value['attribute']))
                            {{--SHOW ATTRIBUTES--}}
                            <div class="col-12 col-md-4 align-middle">
                                <h5> ویژگی ها:</h5>
                            </div>
                            <div class="col-12 col-md-8 mt-3">
                                <div class="d-flex">
                                    <div class=" m-3 p-3 alert-info w-100 rounded"
                                         id="product-attr-{{$key}}"
                                    >
                                        <div class="row align-items-center">
                                            @foreach($value['attribute'] as $product_attr_key => $attr_array)
                                                @foreach($attr_array as $attr_key => $attr_value)
                                                    <div class="col mt-2 mb-2 font-weight-bold">
                                                        @if($attr_key == "quantity")
                                                            <div
                                                                class="btn-group btn-group direction-ltr border rounded"
                                                                role="group"
                                                            >


                                                                <button type="button"
                                                                        class="text-dark bg-white btn my-0 font-weight-bolder"
                                                                >
                                                                    {{ $attr_value }}
                                                                </button>

                                                            </div>
                                                        @else
                                                            {{ $attr_value }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                                {{--BREAK POINT--}}
                                                <div class="w-100"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>{{--./PRODUCTS--}}
            {{--./SHOW BASKET--}}


        </div>{{--row--}}
    </div>{{--container--}}
@endsection





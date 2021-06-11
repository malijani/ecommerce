@extends('layouts.app')

@section('content')


    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('address') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">


            <div class="col-12  col-lg-8 py-4 order-1">{{--addresses--}}
                @include('front-v1.partials.address') {{--It gets default_address, addresses--}}
            </div>{{--./addresses--}}


            <div class="col-12 col-lg-4 py-4 order-3 order-md-2">{{--FINAL DESCRIPTION--}}
                <h3>فاکتور نهایی سفارش</h3>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">تعداد کالا</th>
                            <td>{{ $total['count'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">وزن مرسوله</th>
                            <td>{{ $total['weight'] }} گرم</td>
                        </tr>
                        <tr class="text-success">
                            <th>
                                تخفیف نهایی
                                @if(isset($total['discount_code']))
                                    ({{ $total['discount_code'] }})
                                @endif
                            </th>
                            <td>{{ number_format($total['discount']) }} تومن</td>
                        </tr>
                        <tr class="font-weight-bolder">
                            <th scope="row">هزینه نهایی سفارش</th>
                            <td>{{ number_format($total['final_price']) }} تومن</td>
                        </tr>

                        <tr class="font-weight-bolder">
                            <th scope="row" class="text-center align-middle">
                                <label for="z_pal" class=" align-middle">
                                    <input type="radio"
                                           name="z_pal"
                                           class="align-middle w-50"
                                           checked
                                    >
                                    <img src="{{ asset('images/asset/payment_gateways/z_pal.png') }}"
                                         alt="درگاه امن زرین پال"
                                         class="img img-fluid align-middle w-25"
                                    >
                                </label>
                            </th>
                            <td class="text-right align-middle">
                                پرداخت امن زرین پال
                            </td>

                        </tr>

                        <tr class="">
                            <td colspan="2">
                                <a href="{{ route('factor.create') }}"
                                   type="button"
                                   class="btn btn-outline-success w-100 font-weight-bolder"
                                >
                                    <i class="far fa-dollar-sign align-middle mx-1"></i>
                                    پرداخت نهایی
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>{{--./FINAL DESCRIPTION--}}


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





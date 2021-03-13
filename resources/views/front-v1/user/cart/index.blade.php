@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">

            <div class="col-12 col-lg-8 py-4">{{--PRODUCTS--}}
                <h4>سبد خرید</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        @foreach($basket as $key=>$value)
                            <tr dir="ltr" class="text-left">
                                <pre>
                                {{ print_r($basket[$key]) }}
                                </pre>
                            </tr>
                            <tr class="text-center">


                                <td class="align-middle w-25">
                                    <a href="{{ route('product.show', $value['title_en'])  }}">
                                        <img src="{{ asset($value['pic']) }}"
                                             alt="{{ $value['title']  }}"
                                             class="img-fluid img-cart"
                                        >
                                    </a>
                                </td>
                                <td class="align-middle ">

                                    {{$value['title']}}

                                </td>

                                <td class="align-middle">
                                    @if(count($value['attribute']))
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                @foreach($value['attribute'] as $product_attr)
                                                    @if(is_array($product_attr))
                                                        @foreach($product_attr as $attr)
                                                            <tr class="text-center border">
                                                                <td class="align-middle">{{ $attr }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    @endif
                                </td>

                                <td class="align-middle ">
                                    {{--TODO : MAKE IT WORK--}}
                                    <div class="btn-group btn-group-lg direction-ltr border rounded" role="group"
                                         aria-label="Basic example">
                                        <button href="https://stavitastore.net/cart_delete/757"
                                                class="text-dark bg-white btn border-0 my-0">-
                                        </button>
                                        <button type="button"
                                                class="text-dark bg-white btn my-0">{{ $value['quantity'] }}</button>
                                        <button href="https://stavitastore.net/cart/757"
                                                class="text-dark bg-white btn border-0 my-0">+
                                        </button>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <b>{{ number_format($value['price']) }} تومن</b>
                                    @if($value['total_discount'] > 0)
                                        <br>
                                        <em class="text-success">{{ number_format($value['total_discount']) }} تخفیف
                                            گرفتی</em>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a href=""><i class="fa fa-trash fa-3x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>{{--./PRODUCTS--}}

            <div class="col-12 col-lg-4 py-4">{{--FINAL DESCRIPTION--}}
                مجموع سبد
            </div>{{--./FINAL DESCRIPTION--}}

        </div>{{--row--}}
    </div>{{--container--}}
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            // TODO : MAKE IT AJAX!!
        });
    </script>
@endsection


@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}


    <div class="container my-3 rounded">
        <div class="row bg-white">

            <div class="col-12  col-lg-8 py-4">{{--PRODUCTS--}}
                <h4>سبد خرید</h4>
                @foreach($basket as $key=>$value)
                    <div class="row d-flex align-items-center text-center mb-5" id="product-{{$key}}">
                        {{--SHOW IMAGE--}}
                        <div class="col-3">
                            <a href="{{ route('product.show', $value['title_en'])  }}">
                                <img src="{{ asset($value['pic']) }}"
                                     alt="{{ $value['title']  }}"
                                     class="img-fluid img-cart"
                                >
                            </a>
                        </div>
                        {{--SHOW TITLE--}}
                        <div class="col-2">
                            <a href="{{ route('product.show', $value['title_en'])  }}" class="text-dark">
                                <p class="font-weight-bolder">{{$value['title']}}</p>
                            </a>
                        </div>
                        {{--SHOW QUANTITY--}}
                        <div class="col-2">
                            @if(count($value['attribute']))
                                <button type="button"
                                        class="text-dark bg-white btn my-0 font-weight-bolder">
                                    {{ $value['quantity'] }}
                                </button>
                            @else
                                {{-- TODO : Adding/Removing product like Buying section--}}
                                <div class="btn-group btn-group-lg direction-ltr border rounded"
                                     role="group"
                                     aria-label="Basic example">
                                    <button
                                        class="text-dark bg-white btn border-0 my-0">-
                                    </button>
                                    <button type="button"
                                            class="text-dark bg-white btn my-0">{{ $value['quantity'] }}</button>
                                    <button href="https://stavitastore.net/cart/757"
                                            class="text-dark bg-white btn border-0 my-0">+
                                    </button>
                                </div>
                            @endif
                        </div>
                        {{--SHOW PRICE--}}
                        <div class="col-3">
                            <b>{{ number_format($value['price']) }} تومن</b>
                            @if($value['total_discount'] > 0)
                                <br>
                                <em class="text-success">{{ number_format($value['total_discount']) }} تخفیف
                                    گرفتی</em>
                            @endif
                        </div>
                        <div class="col-1">
                            <button type="button"
                                    class="btn btn-light"
                                    onclick="del({{$key}});"
                                    id="del-{{$key}}"
                                    data-target="{{ route('cart.destroy', [$key]) }}"
                            >
                                <i class="fa fa-trash fa-2x text-danger"></i>
                            </button>
                        </div>
                        {{--BREAK POINT COL--}}
                        @if(is_array($value['attribute'])&&count($value['attribute']))
                            {{--SHOW ATTRIBUTES--}}
                            <div class="col-12 mt-3">
                                <button class="btn btn-outline-info w-100"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#product-attr-{{$key}}"
                                        id="product-attr-button-{{$key}}"
                                        aria-expanded="true"
                                        aria-controls="collapseExample"
                                >
                                    <i class="fa fa-caret-square-o-up fa-2x"></i>
                                </button>

                                <div class="d-flex">
                                    <div class="collapse show m-3 p-3 alert-info w-100 rounded"
                                         id="product-attr-{{$key}}"
                                    >
                                        <div class="row align-items-center">
                                            @foreach($value['attribute'] as $attr_array)
                                                @foreach($attr_array as $attr_key => $attr_value)
                                                    <div class="col mt-2 mb-2 font-weight-bold">
                                                        @if($attr_key == "quantity")
                                                            <div
                                                                class="btn-group btn-group direction-ltr border roundd"
                                                                role="group"
                                                            >
                                                                <a href="{{--TODO : ADD REMOVE FOR ATTR--}}"
                                                                   class="text-dark bg-white btn border-0 my-0"
                                                                >
                                                                    -
                                                                </a>

                                                                <button type="button"
                                                                        class="text-dark bg-white btn my-0 font-weight-bolder"
                                                                >
                                                                    {{ $attr_value }}
                                                                </button>

                                                                <a href="{{--TODO : ADD PLUS FOR ATTR--}}"
                                                                   class="text-dark bg-white btn border-0 my-0"
                                                                >
                                                                    +
                                                                </a>
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


                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody class="text-center">
                        @foreach($basket as $key=>$value)
                            <tr dir="ltr" class="text-left">
                                <pre>
                                {{ print_r($basket[$key]) }}
                                </pre>
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
    <script type="text/javascript" src="{{ asset('front-v1/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        /*DELETE A PRODUCT FROM SHOPPING CART*/
        function del(id) {
            swal({
                title: " از حذف محصول مطمعنی؟",
                icon: "warning",
                buttons: ['نه! حذف نکن.', 'آره، حذف کن.'],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        // console.log('delete');
                        $.ajax({
                            url: $("#del-" + id).attr('data-target'),
                            type: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                '_method': 'DELETE',
                                'id': id,
                            },
                            success: function () {
                                location.reload();
                            },
                            error: function () {
                                swal({
                                    text: "خطای غیر منتظره ای رخ داده.",
                                    icon: 'error',
                                    button: "فهمیدم.",
                                });
                            }
                        });
                    }
                });
        }

        $(document).ready(function () {
            /*CONTROL THE DIRECTION OF CARET IN ATTRIBUTE SHOW*/
            @foreach($basket as $key=>$value)
            @if(is_array($value['attribute']) && count($value['attribute']))
            $("#product-attr-{{$key}}").on('show.bs.collapse', function () {
                console.error('showing{{$key}}');
                $("#product-attr-button-{{$key}}").html('<i class="fa fa-caret-square-o-up fa-2x"></i>');
            });
            p
            $("#product-attr-{{$key}}").on('hide.bs.collapse', function () {
                console.error('hiding{{$key}}');
                $("#product-attr-button-{{$key}}").html('<i class="fa fa-caret-square-o-down fa-2x"></i>');
            });

            @endif
            @endforeach

        });
    </script>
@endsection


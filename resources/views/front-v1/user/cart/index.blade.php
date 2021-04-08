@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">


            <div class="col-12  col-lg-8 py-4">{{--PRODUCTS--}}
                <h4>سبد خرید</h4>
                @foreach($basket as $key=>$value)
                    <div class="row d-flex align-items-center text-center mb-4 ml-1 mr-1  p-3 rounded bg-whitesmoke" id="product-{{$key}}">
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
                        <div class="col-md-2">
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
                            @else
                                <div
                                    class="btn-group btn-group direction-ltr border rounded"
                                    role="group"
                                >
                                    <button type="button"
                                            data-target="{{route('cart.update', $key)}}"
                                            onclick="update(this, 'remove');"
                                            id="remove-one-{{$key}}"
                                            class="text-dark bg-white btn border-0 my-0"
                                    >
                                        -
                                    </button>

                                    <button type="button"
                                            class="text-dark bg-white btn my-0 font-weight-bolder"
                                    >
                                        {{ $value['quantity']  }}
                                    </button>

                                    <button type="button"
                                            data-target="{{route('cart.update', $key)}}"
                                            onclick="update(this, 'add');"
                                            id="add-one-{{$key}}"
                                            class="text-dark bg-white btn border-0 my-0"
                                    >
                                        +
                                    </button>
                                </div>
                            @endif
                        </div>
                        {{--SHOW PRICE--}}
                        <div class="col-md-3">
                            <b>{{ number_format($value['price']) }} تومن</b>
                            @if($value['total_discount'] > 0)
                                <br>
                                <em class="text-success">{{ number_format($value['total_discount']) }} تخفیف
                                    گرفتی</em>
                            @endif
                        </div>
                        <div class="col-md-1">
                            <button type="button"
                                    class="btn btn-light"
                                    onclick="del({{$key}});"
                                    id="del-{{$key}}"
                                    data-target="{{ route('cart.destroy', [$key] ) }}"
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
                                            @foreach($value['attribute'] as $product_attr_key => $attr_array)
                                                @foreach($attr_array as $attr_key => $attr_value)
                                                    <div class="col mt-2 mb-2 font-weight-bold">
                                                        @if($attr_key == "quantity")
                                                            <div
                                                                class="btn-group btn-group direction-ltr border rounded"
                                                                role="group"
                                                            >
                                                                <button type="button"
                                                                        data-target="{{route('cart.update', $key)}}"
                                                                        onclick="update(this, 'remove', {{$product_attr_key}});"
                                                                        id="remove-one-{{$key}}-{{$product_attr_key}}"
                                                                   class="text-dark bg-white btn border-0 my-0"
                                                                >
                                                                    -
                                                                </button>

                                                                <button type="button"
                                                                        class="text-dark bg-white btn my-0 font-weight-bolder"
                                                                >
                                                                    {{ $attr_value }}
                                                                </button>

                                                                <button type="button"
                                                                        data-target="{{route('cart.update', $key)}}"
                                                                        onclick="update(this, 'add', {{$product_attr_key}});"
                                                                        id="add-one-{{$key}}-{{$product_attr_key}}"
                                                                        class="text-dark bg-white btn border-0 my-0"
                                                                >
                                                                    +
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

            <div class="col-12 col-lg-4 py-4">{{--FINAL DESCRIPTION--}}
                <h6>مجموع سبد</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th scope="row">تعداد کالا</th>
                            <td>{{ $total['count'] }} عدد</td>
                        </tr>
                        <tr>
                            <th scope="row">وزن مرسوله</th>
                            <td>{{ $total['weight'] }} گرم</td>
                        </tr>
                        <tr class="">
                            <th scope="row">جمع قیمت(بدون تخفیف)</th>
                            <td>{{ number_format($total['raw_price']) }} تومن</td>
                        </tr>
                        <tr class="text-success">
                            <th scope="row">جمع تخفیف</th>
                            <td>{{ number_format($total['discount']) }} تومن</td>
                        </tr>
                        <tr class="font-weight-bolder">
                            <th scope="row">قیمت نهایی</th>
                            <td>{{ number_format($total['final_price']) }} تومن</td>
                        </tr>
                        <tr class="">
                            <td colspan="2">
                                <a href="{{ route('address.index') }}"
                                   type="button"
                                   class="btn btn-outline-success w-100 font-weight-bolder"
                                >
                                    ثبت سفارش
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

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
                                location.reload();
                            }
                        });
                    }
                });
        }

        function update(element, type, attribute=null){
            // type : how to manipulate on product? 'add' or 'remove'
            // attribute is optional : attribute of product :
            //         if you're looking for product id that is stored in basket
            //         "data-target" is generated for the product! /update/20
            let update_url = $(element).attr('data-target');
            $.ajax({
                url:  update_url,
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    '_method': "PUT",
                    'type': type,
                    'attribute': attribute,
                },
                success: function(){
                    location.reload();
                },
                error: function(){
                    location.reload();
                }
            });
        }

        $(document).ready(function () {
            /*CONTROL THE DIRECTION OF CARET IN ATTRIBUTE SHOW*/
            @foreach($basket as $key=>$value)
            @if(is_array($value['attribute']) && count($value['attribute']))
            $("#product-attr-{{$key}}").on('show.bs.collapse hide.bs.collapse', function (e) {
                if (e.type === 'show') {
                $("#product-attr-button-{{$key}}").html('<i class="fa fa-caret-square-o-up fa-2x"></i>');
                } else {
                    $("#product-attr-button-{{$key}}").html('<i class="fa fa-caret-square-o-down fa-2x"></i>');
                }
            });
            @endif
            @endforeach
        });
    </script>
@endsection


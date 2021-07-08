@if(!empty(session()->get('basket')) && count(session()->get('basket')) )
    @php($basket = session()->get('basket'))
    <h4>سبد خرید</h4>

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
            <div class="col-md-2 my-3 my-md-0">
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
                        class="btn-group direction-ltr border rounded"
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
                    عدد
                @endif
            </div>
            {{--SHOW PRICE--}}
            <div class="col-md-3 my-3 my-md-0">
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
                    <i class="fal fa-trash-alt fa-2x text-danger"></i>
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
                        <i class="far fa-caret-circle-up fa-2x text-dark"></i>
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





    @push('scripts')
        <script>
            /*DELETE A PRODUCT FROM SHOPPING CART*/
            function del(id) {
                let main_node = $("#product-" + id);
                Swal.fire({
                    title: 'سفارش از سبد خرید حذف بشه؟',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'بله، حذف کن',
                    denyButtonText: 'نه، حذف نکن',
                    confirmButtonColor: '#d33',
                    denyButtonColor: "#3085d6",
                    reverseButtons: true,
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // console.log('delete');
                            $.ajax({
                                url: $("#del-" + id).attr('data-target'),
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    '_method': 'DELETE',
                                    'id': id,
                                },
                                success: function (data) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: "success",
                                        title: "<h5>" + data.message + "</h5>",
                                        showConfirmButton: false,
                                        timer: 1500,
                                    }).then(() => {
                                        /*UPDATE PARTIALS*/
                                        $("#header_basket_total").html(data.basket_total);
                                        $('#cart_total').html(data.cart_total);
                                        $('#cart_items').html(data.cart_items);
                                    });

                                },
                                error: function (data) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: "error",
                                        title: "<h5>" + data.responseJSON.message + "</h5>",
                                        showConfirmButton: false,
                                        timer: 1500,
                                    });
                                },

                            });
                        }
                    });
            }

            function update(element, type, attribute = null) {
                // type : how to manipulate on product? 'add' or 'remove'
                // attribute is optional : attribute of product :
                //         if you're looking for product id that is stored in basket
                //         "data-target" is generated for the product! /update/20
                let update_url = $(element).attr('data-target');
                $.ajax({
                    url: update_url,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        '_method': "PUT",
                        'type': type,
                        'attribute': attribute,
                    },
                    success: function () {
                        location.reload();
                    },
                    error: function () {
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
                        $("#product-attr-button-{{$key}}").html('<i class="far fa-caret-circle-up fa-2x text-dark"></i>');
                    } else {
                        $("#product-attr-button-{{$key}}").html('<i class="far fa-caret-circle-down fa-2x text-dark"></i>');
                    }
                });
                @endif
                @endforeach
            });
        </script>
    @endpush



@else

    <i class="fa fa-info-circle fa-2x"></i>
    <h4 class="d-inline mx-1">سبد خرید شما خالیست.</h4>

    <div class="my-3">
        <a href="{{ route('home') }}"
           class="btn btn-light w-50 font-16 border p-4 font-weight-bolder"
        >
            <i class="fa fa-shoe-prints fa-rotate-270 fa-2x align-middle"></i>
            ادامه خرید
        </a>
    </div>

@endif





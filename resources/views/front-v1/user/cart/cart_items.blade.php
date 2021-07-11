@if(!empty(session()->get('basket')) && count(session()->get('basket')) )
    @php($basket = session()->get('basket'))

    <div class="card shadow-sm mt-3 mt-md-0">
        <h5 class="card-header border-bottom-0">
            سبد خرید
        </h5>
        <div class="card-body">
            @foreach($basket as $key=>$value)
                <div class="row my-3 align-items-center justify-content-center rounded bg-light"
                     id="product-{{$key}}"
                >
                    {{--SHOW IMAGE & TITLE--}}
                    <div class="col-md-4">
                        <a href="{{ route('product.show', $value['title_en'])  }}"
                           title="{{ $value['title'] }}"
                           class="text-dark"
                        >
                            <img src="{{ asset($value['pic']) }}"
                                 alt="{{ $value['title']  }}"
                                 class="img img-fluid img-cart rounded"
                                 loading="lazy"
                            >
                            <h6 class="font-weight-bolder mt-1">
                                {{$value['title']}}
                            </h6>
                            <p class="text-muted mt-1">
                                {{ str_replace('-', ' ', $value['title_en'])}}
                            </p>
                        </a>
                    </div>


                    {{--SHOW QUANTITY & PRICE--}}
                    <div class="col-md-7">
                        <div class="row align-items-center">


                            <div class="col-12 my-3 py-3  my-md-3">
                                @if(is_array($value['attribute'])&&count($value['attribute']))
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-dark font-weight-bolder">
                                                مجموع
                                                {{ $value['quantity'] }}
                                                عدد
                                            </p>
                                        </div>

                                        @foreach($value['attribute'] as $product_attr_key => $attr_array)
                                            <div class="col-12 mt-3">
                                                @foreach($attr_array as $attr_key => $attr_value)
                                                    @if($attr_key == "quantity")
                                                        <div
                                                            class="btn-group btn-group direction-ltr border rounded"
                                                            role="group"
                                                        >
                                                            <button type="button"
                                                                    data-target="{{route('cart.update', $key)}}"
                                                                    onclick="update(this, 'remove', {{$product_attr_key}});"
                                                                    id="remove-one-{{$key}}-{{$product_attr_key}}"
                                                                    class="text-light bg-danger btn border-0 my-0"
                                                            >
                                                                <i class="fa fa-minus"></i>
                                                            </button>

                                                            <button type="button"
                                                                    class="text-dark bg-white btn my-0 font-weight-bolder"
                                                            >
                                                                {{ $attr_value }}
                                                                عدد
                                                            </button>

                                                            <button type="button"
                                                                    data-target="{{route('cart.update', $key)}}"
                                                                    onclick="update(this, 'add', {{$product_attr_key}});"
                                                                    id="add-one-{{$key}}-{{$product_attr_key}}"
                                                                    class="text-light bg-success btn border-0 my-0"
                                                            >
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <span class="badge badge-secondary p-2 font-16 ml-1">
                                                            {{ $attr_value }}
                                                        </span>
                                                    @endif
                                                @endforeach{{--LOOP ON EACH ATTRIBUTE--}}
                                            </div>
                                        @endforeach{{--LOOP ON ATTRIBUTE ARRAYS--}}
                                    </div>
                                @else
                                    <div
                                        class="btn-group direction-ltr border rounded"
                                        role="group"
                                    >
                                        <button type="button"
                                                data-target="{{route('cart.update', $key)}}"
                                                onclick="update(this, 'remove');"
                                                id="remove-one-{{$key}}"
                                                class="text-light bg-danger btn border-0 my-0"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <button type="button"
                                                class="text-dark bg-white btn my-0 font-weight-bolder"
                                        >
                                            {{ $value['quantity']  }}
                                            عدد
                                        </button>

                                        <button type="button"
                                                data-target="{{route('cart.update', $key)}}"
                                                onclick="update(this, 'add');"
                                                id="add-one-{{$key}}"
                                                class="text-light bg-success btn border-0 my-0"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>


                            <div class="col-12 my-3 py-3  my-md-3">
                                <b>{{ number_format($value['price']) }} تومن</b>
                                @if($value['total_discount'] > 0)
                                    <br>
                                    <em class="text-success">
                                        {{ number_format($value['total_discount']) }} تخفیف گرفتی
                                    </em>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{--SHOW DELETE BUTTON--}}
                    <div class="col-md-1 mt-3 mt-md-0 d-flex justify-content-center">
                        <button type="button"
                                class="btn btn-light"
                                onclick="del({{$key}});"
                                id="del-{{$key}}"
                                data-target="{{ route('cart.destroy', [$key] ) }}"
                        >
                            <i class="fal fa-trash-alt fa-2x text-danger"></i>
                        </button>
                    </div>

                </div>
            @endforeach

        </div>{{--./CARD BODY--}}
    </div>{{--./CARD--}}








    @push('scripts')
        <script>
            /*DELETE A PRODUCT FROM SHOPPING CART*/
            function del(id) {
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
                    success: function (data) {
                        /*UPDATE PARTIALS*/
                        $("#header_basket_total").html(data.basket_total);
                        $('#cart_total').html(data.cart_total);
                        $('#cart_items').html(data.cart_items);
                    },
                    error: function (data) {
                        Swal.fire({
                            position: 'top',
                            icon: "error",
                            title: "<h5>" + data.responseJSON.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
            }
        </script>
    @endpush



@else

    <div class="card border-0 shadow-lg">
        <div class="card-header py-4">
            <i class="fa fa-info-circle fa-2x align-middle"></i>
            <h4 class="d-inline mx-1">سبد خرید شما خالیست.</h4>
        </div>
        <div class="card-body py-4">
            <div class="my-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <a href="{{ route('product.index') }}"
                           class="btn btn-light w-100 p-4 font-weight-bolder shadow-sm"
                        >
                            <i class="fal fa-shoe-prints fa-rotate-270 fa-2x align-middle"></i>
                            ادامه خرید
                        </a>
                    </div>
                    <div class="col-12 col-md-6">
                        <a href="{{ route('dashboard.index') }}"
                           class="btn btn-light w-100 p-4 font-weight-bolder shadow-sm"
                        >
                            <i class="fal fa-desktop-alt fa-2x align-middle"></i>
                            داشبورد
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endif





<div class="row">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header border-bottom-0">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 text-center text-md-right my-1 my-md-0">
                        <h4>فاکتور {{ $factor->uuid }}</h4>
                    </div>
                    {{--IF STATUS !=1 USER CAN PAY--}}
                    @if($factor->status != "1")
                        <div class="col-12 col-md-4 text-center my-1 my-md-0">
                            <a class="btn btn-custom btn-lg w-100 font-16 font-weight-bolder"
                               id="factor_pay_button"
                               href="{{ route('factor.pay', $factor->uuid) }}"
                            >
                                <i class="fal fa-clipboard-list-check fa-2x align-middle mx-2"></i>
                                <span class="">
                                پرداخت فاکتور
                            </span>
                            </a>
                        </div>

                        <div class="col-12 col-md-4 text-center text-mdl-left my-1 my-md-0">
                            <button class="btn btn-light"
                                    title="حذف فاکتور {{ $factor->uuid }}"
                                    id="delete_factor"
                                    data-url="{{ route('dashboard.orders.destroy', $factor->uuid) }}"
                            >
                                <i class="fal fa-trash-alt fa-2x text-danger"></i>
                            </button>
                        </div>

                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    {{--PAY STATUS TABLE--}}
                    <div class="col-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-right">
                                    <td colspan="2">
                                        <h5>
                                            مشخصات پرداخت
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        وضعیت پرداخت
                                    </th>
                                    <td class="align-middle text-right">
                                        @if($factor->status == "0")
                                            <span class="badge badge-danger font-14 p-2">پرداخت نشده</span>
                                        @elseif($factor->status == "1")
                                            <span class="badge badge-success font-14 p-2">پرداخت شده</span>
                                        @elseif($factor->status == "2")
                                            <span class="badge badge-warning font-14 p-2">خطا در پرداخت</span>
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($factor->driver))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            درگاه
                                        </th>
                                        <td class="align-middle text-right">
                                            @if($factor->driver == 'behpardakht')
                                                <span>به پرداخت بانک ملت</span>
                                            @elseif($factor->driver == 'zarinpal')
                                                <span>زرین پال</span>
                                            @else
                                                <span>نامشخص</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->pay_trans_id))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            کد پرداخت
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->pay_trans_id ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->pay_tracking))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            رهگیری پرداخت
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->pay_tracking ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->paid_at))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            پرداخت شده در
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ (!empty($factor->paid_at)) ? verta($factor->paid_at)->formatJalaliDate() : '-/-/-' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->pay_reference))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            مرجع پرداخت
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->pay_reference ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->error_code))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            کد خطای پرداخت
                                        </th>
                                        <td class="align-middle text-right ltr">
                                            {{ $factor->error_code ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->error_message))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-right" w-50
                                        >
                                            پیام خطای پرداخت
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->error_message ?? '-' }}
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--PRICE STATUS TABLE--}}
                    <div class="col-12 mt-2 ">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-right">
                                    <td colspan="2">
                                        <h5>
                                            هزینه ها و تخفیف
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        قیمت نهایی
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ number_format($factor->price) . " تومن " }}
                                    </td>
                                </tr>
                                @if(!empty($factor->discount_price))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            قیمت خام
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ number_format($factor->raw_price) .  " تومن " }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->discount_price))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            میزان تخفیف
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ number_format($factor->discount_price) . " تومن " }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->discount_code))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            کد تخفیف
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->discount_code ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DELIVERY STATUS TABLE--}}
                    <div class="col-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-right">
                                    <td colspan="2">
                                        <h5>
                                            وضعیت مرسوله
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        تعداد محصول
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ $factor->count . " عدد "}}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        مجموع وزن
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ number_format($factor->weight) . " گرم " }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        وضعیت ارسال
                                    </th>
                                    <td class="align-middle text-right">
                                        @if($factor->delivery == "0")
                                            <span class="badge badge-primary font-14 p-2">در انبار</span>
                                        @elseif($factor->delivery == "1")
                                            <span class="badge badge-primary font-14 p-2">پست شده</span>
                                        @else
                                            <span class="badge badge-primary font-14 p-2">تحویل داده شده</span>
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($factor->post_tracking))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            کد رهگیری
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->post_tracking ?? '-'}}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->shipping_cost))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            هزینه شرکت پستی
                                            <br>
                                            (پرداخت در محل)
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ number_format($factor->shipping_cost) . " تومن " }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--SHIPPING STATUS TABLE--}}
                    <div class="col-12 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <td colspan="2"
                                        class="align-middle text-right"
                                    >
                                        <h5>
                                            مشخصات تحویل گیرنده
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        شخص
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ $factor->shipping_name_family }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        تلفن همراه
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ $factor->shipping_mobile }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        آدرس
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ $factor->shipping_address }}
                                    </td>
                                </tr>
                                @if(!empty($factor->shipping_tell))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            تلفن ثابت
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->shipping_tell }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->shipping_post_code))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center w-50"
                                        >
                                            کد پستی
                                        </th>
                                        <td class="align-middle text-right">
                                            {{ $factor->shipping_post_code }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DATES STATUS--}}
                    <div class="col-12 mt-2 mb-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <h5>
                                            ثبت و بروزرسانی
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        ثبت شده در
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ verta($factor->created_at)->formatJalaliDate()  }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center w-50"
                                    >
                                        بروز رسانی در
                                    </th>
                                    <td class="align-middle text-right">
                                        {{ verta($factor->updated_at)->formatJalaliDate() }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    {{--USER ASK--}}
                    <div class="col-12 my-1">
                        <div class="row bg-whitesmoke rounded py-2">
                            <label for="user_ask"
                                   class="col-form-label col-12 font-16 font-weight-bold text-right"
                            >
                                ثبت درخواست
                            </label>

                            <div class="col-12 my-2">
                                <textarea name="user_ask"
                                          id="user_ask"
                                          class="textarea-custom form-control"
                                          rows="5"
                                          placeholder="درخواست اختصاصی شما برای این فاکتور"
                                >{{ $factor->description }}</textarea>
                            </div>
                            <div class="col-12 my-2">
                                <button class="form-control btn btn-custom font-16 font-weight-bold"
                                        data-url="{{ route('dashboard.orders.update', $factor->uuid) }}"
                                        id="submit_user_ask"
                                >
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>


                    {{--ADMIN COMMENT--}}
                    <div class="col-12 mt-2 mb-1">
                        <div class="row bg-light rounded p-2 align-items-center">
                            <label for="user_ask"
                                   class="col-form-label col-12 font-16 font-weight-bold text-right"
                            >
                                پاسخ ادمین
                            </label>
                            <div class="col-12 my-md-2 rounded">
                                <div class="font-16 p-4">
                                    {!!   $factor->comment ?? '-----' !!}
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--ORDERED PRODUCTS--}}
                    <div class="col-12 mt-4 mb-0">
                        <hr>
                        <div class="font-weight-bolder font-20 text-center">
                            <h3>سبد سفارش</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        @foreach($factor->products as $factor_product)
                            {{--FACTOR PRODUCT SHOW--}}
                            <div
                                class="row d-flex align-items-center text-center mb-4 mx-1 p-3 rounded bg-light"
                                id="product-{{$factor_product->product->id}}">
                                {{--SHOW IMAGE--}}
                                <div class="col-md-3">
                                    <a href="{{ route('product.show', $factor_product->product->title_en)  }}">
                                        <img src="{{ asset($factor_product->product->files()->defaultFile()->link) }}"
                                             alt="{{ $factor_product->product->files()->defaultFile()->title  }}"
                                             class="img-fluid img-cart rounded"
                                        >
                                    </a>
                                </div>
                                {{--SHOW TITLE--}}
                                <div class="col-md-4 my-md-0">
                                    <a href="{{ route('product.show', $factor_product->product->title_en)  }}"
                                       class="text-dark">
                                        <p class="font-weight-bolder">{{ $factor_product->product->title }}</p>
                                    </a>
                                </div>
                                {{--SHOW QUANTITY--}}
                                <div class="col-md-2">
                                    <button type="button"
                                            class="text-dark bg-white btn my-0 font-weight-bolder">
                                        {{ $factor_product->count }}
                                        عدد
                                    </button>

                                </div>
                                {{--SHOW PRICE--}}
                                <div class="col-md-3 my-3 my-md-0">
                                    <b>{{ number_format($factor_product->price) }} تومن</b>
                                    @if($factor_product->discount_price > 0)
                                        <br>
                                        <em class="text-success">
                                            {{ number_format($factor_product->discount_price) . " تومن "}} تخفیف گرفتی
                                            <br>
                                            (٪ {{ $factor_product->discount_percent }})
                                        </em>

                                    @endif
                                </div>
                                {{--BREAK POINT COL--}}
                                @if(!empty($factor_product->attributes)&& count($factor_product->attributes))
                                    {{--SHOW ATTRIBUTES--}}
                                    <div class="col-12 col-md-3 mt-3 text-right text-md-center">
                                        <h6>
                                            ویژگی ها:
                                        </h6>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <hr>
                                        <div class="d-flex">
                                            <div class=" rounded w-100"
                                                 id="product-attr-{{$factor_product->product->id}}"
                                            >
                                                <div class="row align-items-center">
                                                    @foreach($factor_product->attributes as $product_attribute)
                                                        <div class="col-12 text-right  font-weight-bold">
                                                            <button type="button"
                                                                    class="text-dark bg-white btn my-0 font-weight-bolder mx-md-2"
                                                            >
                                                                {{ $product_attribute->count }}
                                                                عدد
                                                            </button>

                                                            {{ $product_attribute->attribute }}
                                                            <hr>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        /*AJAX TO CHANGE COMMENTS OF FACTOR*/
        $(document).ready(function () {
            /*FACTOR PAYMENT SECTION*/


            /*DELETE FACTOR SECTION*/
            let delete_factor_button = $("#delete_factor")
            delete_factor_button.on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Swal.fire({
                    title: "آیا از فاکتور مطمعنید؟",
                    text: "با حذف فاکتور، قادر به بازگردانی آن نخواهید بود!",
                    icon: "warning",
                    confirmButtonText: 'بله، حذف کن.',
                    denyButtonText: 'نه، حذف نکن.',
                    confirmButtonColor: '#d33',
                    denyButtonColor: '#3085d6',
                    showDenyButton: true,
                    showConfirmButton: true,
                    /*customClass: {
                        confirmButton: 'btn btn-outline-success mx-2 px-4',
                        denyButton: 'btn btn-danger mx-2 px-4'
                    },*/
                    /*buttonsStyling: false*/
                })
                    .then((swResult) => {
                        if (swResult.isConfirmed) {
                            $.ajax({
                                url: delete_factor_button.attr('data-url'),
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    '_method': 'DELETE',
                                },
                                success: function (result) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: result.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                    }).then(function () {
                                        window.location.href = result.url;
                                    });
                                },
                                error: function (result) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: "error",
                                        title: result.responseJSON.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                    }).then(function () {
                                        window.location.href = result.responseJSON.url;
                                    });
                                }
                            });
                        }
                    });
            });


            /* USER ASK SECTION*/
            let submit_user_ask = $("#submit_user_ask");
            let user_ask_content = $("#user_ask");
            submit_user_ask.on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                if (user_ask_content.val()) {
                    $.ajax({
                        url: submit_user_ask.attr('data-url'),
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'PATCH',
                            'content': user_ask_content.val(),
                        },
                        success: function (result) {
                            Swal.fire({
                                position: 'top',
                                icon: "success",
                                title: result.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        },
                        error: function (result) {
                            Swal.fire({
                                position: 'top',
                                icon: "error",
                                title: result.responseJSON.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: "error",
                        title: 'درخواست بدون محتوا',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            });
        });
    </script>
@endpush

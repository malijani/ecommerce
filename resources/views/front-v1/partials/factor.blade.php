<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 text-center text-md-right my-1 my-md-0">
                        <h4>فاکتور {{ $factor->uuid }}</h4>
                    </div>
                    {{--IF STATUS !=1 USER CAN PAY--}}
                    @if($factor->status != "1")
                        <div class="col-12 col-md-4 text-center my-1 my-md-0">
                            <a class="btn btn-outline-success btn-lg w-100 font-16 font-weight-bolder"
                               id="factor_pay_button"
                               href="{{ route('factor.pay', $factor->uuid) }}"
                            >
                                <i class="fal fa-clipboard-list-check fa-2x align-middle mx-2"></i>
                                <span class="">
                                پرداخت فاکتور
                            </span>
                            </a>
                        </div>
                        @if($factor->status != "1")
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
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    {{--PAY STATUS TABLE--}}
                    <div class="col-12 col-md-8 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
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
                                        class="align-middle text-center"
                                    >
                                        وضعیت پرداخت
                                    </th>
                                    <td class="align-middle text-center">
                                        @if($factor->status == "0")
                                            <span class="badge badge-danger font-14 p-2">پرداخت نشده</span>
                                        @elseif($factor->status == "1")
                                            <span class="badge badge-success font-14 p-2">پرداخت شده</span>
                                        @else
                                            <span class="badge badge-warning font-14 p-2">خطا در پرداخت</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        کد پرداخت
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->pay_trans_id ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        رهگیری پرداخت
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->pay_tracking ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        پرداخت شده در
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ (!empty($factor->paid_at)) ? verta($factor->paid_at)->formatJalaliDate() : '-/-/-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        مرجع پرداخت
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->pay_reference ?? '-' }}
                                    </td>
                                </tr>


                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        کد خطای پرداخت
                                    </th>
                                    <td class="align-middle text-center ltr">
                                        {{ $factor->error_code ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        پیام خطای پرداخت
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->error_message ?? '-' }}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--PRICE STATUS TABLE--}}
                    <div class="col-12 col-md-4 mt-2 ">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
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
                                        class="align-middle text-center"
                                    >
                                        قیمت نهایی
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ number_format($factor->price) . " تومن " }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        قیمت خام
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ number_format($factor->raw_price) .  " تومن " }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        میزان تخفیف
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ number_format($factor->discount_price) . " تومن " }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        کد تخفیف
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->discount_code ?? '-' }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DELIVERY STATUS TABLE--}}
                    <div class="col-12 col-md-6 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
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
                                        class="align-middle text-center"
                                    >
                                        تعداد محصول
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->count . " عدد "}}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        مجموع وزن
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ number_format($factor->weight) . " گرم " }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        وضعیت ارسال
                                    </th>
                                    <td class="align-middle text-center">
                                        @if($factor->delivery == "0")
                                            <span class="badge badge-primary font-14 p-2">در انبار</span>
                                        @elseif($factor->delivery == "1")
                                            <span class="badge badge-primary font-14 p-2">پست شده</span>
                                        @else
                                            <span class="badge badge-primary font-14 p-2">تحویل داده شده</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        کد رهگیری
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->post_tracking ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        هزینه شرکت پستی
                                        <br>
                                        (پرداخت در محل)
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ number_format($factor->shipping_cost) . " تومن " }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--SHIPPING STATUS TABLE--}}
                    <div class="col-12 col-md-6 mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <td colspan="2"
                                        class="align-middle text-center"
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
                                        class="align-middle text-center"
                                    >
                                        شخص
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->shipping_name_family }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        تلفن همراه
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->shipping_mobile }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        آدرس
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ $factor->shipping_address }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        تلفن ثابت
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ (!empty($factor->shipping_tell))? $factor->shipping_tell : '-' }}
                                    </td>
                                </tr>


                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        کد پستی
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ (!empty($factor->shipping_post_code)) ? $factor->shipping_post_code : '-' }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DATES STATUS--}}
                    <div class="col-12 col-md-6 mt-2 mb-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <h5>
                                            ثبت و بروزرسانی
                                        </h5>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        ثبت شده در
                                    </th>
                                    <td class="align-middle text-center">
                                        {{ verta($factor->created_at)->formatJalaliDate()  }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        بروز رسانی در
                                    </th>
                                    <td class="align-middle text-center">
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
                                   class="col-form-label col-12 col-md-4 font-16 font-weight-bold text-center"
                            >
                                ثبت درخواست


                            </label>

                            <div class="col-12 col-md-8 my-2">
                                <textarea name="user_ask"
                                          id="user_ask"
                                          class="form-control"
                                          rows="5"
                                          placeholder="درخواست اختصاصی شما برای این فاکتور"
                                >{{ $factor->description }}</textarea>
                            </div>
                            <div class="col-12 col-md-8 col-md-offset-4  my-2">
                                <button class="form-control btn btn-success font-14 font-weight-bold"
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
                        <div class="row bg-whitesmoke rounded p-2">
                            <label for="user_ask"
                                   class="col-form-label col-12 col-md-4 font-16 font-weight-bold text-center"
                            >
                                پاسخ ادمین
                            </label>
                            <div class="col-12 col-md-8 bg-white my-md-2 rounded">
                                <div class="font-16 ">
                                    {{ $factor->comment ?? '-----'}}
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--ORDERED PRODUCTS--}}
                    <div class="col-12 mt-4 mb-0">
                        <div class="font-weight-bolder font-20 text-center">
                            <h3>سبد سفارش</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        @foreach($factor->products as $factor_product)
                            {{--FACTOR PRODUCT SHOW--}}
                            <div
                                class="row d-flex align-items-center text-center mb-4 mx-1 p-3 rounded bg-whitesmoke"
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
                                <div class="col-md-4 my-3 my-md-0">
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
                                    <div class="col-12 col-md-3 mt-3">
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
                                                        <div class="col-12 text-center text-md-right  font-weight-bold">
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

                Swal.fire({
                    title: "آیا از فاکتور مطمعنید؟",
                    text: "با حذف فاکتور، قادر به بازگردانی آن نخواهید بود!",
                    icon: "warning",
                    confirmButtonText: 'حذف کن',
                    denyButtonText: 'نه!',
                    confirmButtonColor: '#3085d6',
                    denyButtonColor: '#d33',
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

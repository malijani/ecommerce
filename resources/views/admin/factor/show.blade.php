@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left text-muted">
                        برگشت
                        <i class="fal fa-arrow-left"></i>
                    </a>
                </div>
            </div>{{--./card-header--}}
            <div class="card-body">
                <div class="row justify-content-center">
                    {{--PAY STATUS TABLE--}}
                    <div class="col-12 col-md-6 float-left">
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
                                @if(!empty($factor->pay_trans_id))
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
                                @endif
                                @if(!empty($factor->pay_tracking))
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
                                @endif
                                @if(!empty($factor->paid_at))
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
                                @endif
                                @if(!empty($factor->pay_reference))
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
                                @endif
                                @if(!empty($factor->user_ip))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center"
                                        >
                                            آیپی کاربر
                                        </th>
                                        <td class="align-middle text-center ltr">
                                            {{ $factor->user_ip ?? '0.0.0.0' }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($factor->error_code))
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
                                @endif
                                @if(!empty($factor->error_message))
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
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--PRICE STATUS TABLE--}}
                    <div class="col-12 col-md-6 float-left mt-2  mt-md-0">
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
                                @if(!empty($factor->discount_price))
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
                                @endif
                                @if(!empty($factor->discount_price))
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
                                @endif
                                @if(!empty($factor->discount_code))
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
                                @endif
                                <tr class="text-success text-center" >
                                    <th scope="row" class="align-middle">
                                        <span>
                                            <i class="fa fa-2x align-middle fa-dollar"></i>
                                        </span>
                                        مجموع سود
                                    </th>
                                    <td class="align-middle">
                                        <span class="ltr">
                                        {{ number_format($factor->profit) }}
                                        </span>
                                        تومن

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DELIVERY STATUS TABLE--}}
                    <div class="col-12 col-md-6 float-left mt-2">
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
                                        <label for="delivery">
                                            وضعیت ارسال
                                        </label>
                                    </th>
                                    <td class="align-middle text-center">
                                        <select name="delivery"
                                                id="delivery"
                                                class="form-control custom-select"
                                        >
                                            <option value="0"
                                                {{ ($factor->delivery == '0') ? 'selected' : '' }}
                                            >
                                                در انبار
                                            </option>
                                            <option value="1"
                                                {{ ($factor->delivery == '1') ? 'selected' : '' }}
                                            >
                                                پست شده
                                            </option>

                                            <option value="2"
                                                {{ ($factor->delivery == '2') ? 'selected' : '' }}
                                            >
                                                تحویل داده شده
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        <label for="post-tracking">
                                            کد رهگیری
                                        </label>
                                    </th>
                                    <td class="align-middle text-center">
                                        <input type="text"
                                               name="post-tracking"
                                               id="post-tracking"
                                               maxlength="50"
                                               class="form-control"
                                               value="{{ (!empty($factor->post_tracking)) ? $factor->post_tracking : null }}"
                                               placeholder="کد رهگیری پستی را پس از ارسال مرسوله وارد کنید"
                                        >

                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"
                                        class="align-middle text-center"
                                    >
                                        <label for="shipping-cost">
                                            هزینه شرکت پستی
                                            <br>
                                            (پرداخت در محل)
                                        </label>
                                    </th>
                                    <td class="align-middle text-center">
                                        <input type="text"
                                               name="shipping-cost"
                                               id="shipping-cost"
                                               value="{{ (!empty($factor->shipping_cost)) ? $factor->shipping_cost : null }}"
                                               class="form-control"
                                               maxlength="10"
                                               placeholder="هزینه دریافتی در محل سرویس ارائه دهنده پستی (تومن) "

                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button
                                            class="form-control btn btn-outline-info"
                                            id="submit_post_section"
                                            name="submit_post_section"
                                            data-url="{{ route('factors.shipping', $factor->id) }}"
                                        >
                                            ثبت تغییرات پستی
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--SHIPPING STATUS TABLE--}}
                    <div class="col-12 col-md-6 float-left mt-2">
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
                                @if(!empty($factor->shipping_tell))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center"
                                        >
                                            تلفن ثابت
                                        </th>
                                        <td class="align-middle text-center">
                                            {{ $factor->shipping_tell ?? '-' }}
                                        </td>
                                    </tr>
                                @endif

                                @if(!empty($factor->shipping_post_code))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center"
                                        >
                                            کد پستی
                                        </th>
                                        <td class="align-middle text-center">
                                            {{  $factor->shipping_post_code ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--DATES STATUS--}}
                    <div class="col-12 col-md-6 float-left mt-2 mb-2">
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
                                @if(!empty($factor->deleted_at))
                                    <tr>
                                        <th scope="row"
                                            class="align-middle text-center"
                                        >
                                            حذف شده در
                                        </th>
                                        <td class="align-middle text-center">
                                            {{ verta($factor->deleted_at)->formatJalaliDate() }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--USER ASK--}}
                    <div class="col-12 my-1">
                        <div class="row bg-info-gradient rounded justify-content-center align-items-center p-2">
                            <div
                                class="col-12 col-md-4 font-16 font-weight-bold text-center text-white align-middle"
                            >
                                <span>
                                    درخواست کاربر
                                </span>
                            </div>
                            <div class="col-12 col-md-8 my-md-2 bg-white rounded">
                                <div class="font-16 p-4">
                                    {{ $factor->description ?? '-----' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--ADMIN COMMENT--}}
                    <div class="col-12 mt-2 mb-2">
                        <div class="row bg-success-gradient rounded p-2 justify-content-center align-items-center">
                            <label for="admin_comment"
                                   class="col-12 col-md-4 font-16 font-weight-bold text-center"
                            >
                                پاسخ ادمین
                            </label>
                            <div class="col-12 col-md-8 my-md-2 rounded">
                                    <textarea id="admin_comment"
                                              name="admin_comment"
                                              class="form-control"
                                              rows="5"
                                              placeholder="پاسخ شما به درخواست کاربر"
                                    >{{ $factor->comment}}</textarea>
                            </div>
                            <div class="col-12  my-2">
                                <button class="form-control btn btn-light"
                                        name="submit_admin_comment"
                                        id="submit_admin_comment"
                                        data-url="{{ route('factors.comment', $factor->id) }}"
                                >
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </div>

                    {{--ORDERED PRODUCTS--}}
                    <div class="col-12 mt-5 mb-0">
                        <div class="font-weight-bolder font-20 text-center">
                            <h3>سبد سفارش</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        @foreach($factor->products as $factor_product)
                            {{--FACTOR PRODUCT SHOW--}}
                            <div
                                class="row d-flex align-items-center text-center mb-4 mx-1 p-3 rounded bg-light-gradient"
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
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>



@endsection

@section('page-scripts')
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('adminrc/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            /*POST ATTRIBUTES SECTION*/
            let delivery = $("#delivery");
            let post_tracking = $("#post-tracking");
            let shipping_cost = $("#shipping-cost");
            let submit_post_section = $("#submit_post_section");
            submit_post_section.on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: submit_post_section.attr('data-url'),
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'delivery': delivery.val(),
                        'shipping_cost': shipping_cost.val(),
                        'post_tracking': post_tracking.val()
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
            });

            /* ADMIN COMMENT SECTION*/
            let submit_admin_comment = $("#submit_admin_comment");
            let admin_comment_content = $("#admin_comment");
            submit_admin_comment.on('click', function (e) {
                e.preventDefault();
                if (admin_comment_content.val()) {
                    $.ajax({
                        url: submit_admin_comment.attr('data-url'),
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'content': admin_comment_content.val(),
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
                        title: 'پاسخ بدون محتوا',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            });

        });


    </script>
@endsection

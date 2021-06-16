@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

{{--@section('nav-buttons')
@endsection--}}

@section('content')
    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست سفارشات</h3>
            </div>
            {{--START CARD BODY--}}
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    {{--PAID FACTORS--}}
                    @if(!empty($factors['paid']) && count($factors['paid']))
                        <div class="col-12 my-2">
                            <a class="btn btn-outline-primary w-100"
                               data-toggle="collapse"
                               href="#paidFactors"
                               role="button"
                               aria-expanded="false"
                               aria-controls="paidFactors"
                            >
                                <i class="fal fa-2x fa-check-square align-middle ml-2"></i>
                                پرداخت شده

                            </a>
                            <div class="collapse show" id="paidFactors">
                                <div class="card card-body">
                                    {{--PAID FACTORS TABLE--}}
                                    <div class="table-responsive" id="paid-factors-content">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="datatable-paid-factors">
                                            <thead>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>سود</td>
                                                <td>مرجع پرداخت</td>
                                                <td>تعداد محصول</td>
                                                <td>وضعیت ارسال</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['paid'] as $factor)
                                                <tr class="text-center" id="data-{{$factor->id}}">
                                                    {{--ID--}}
                                                    <td class="align-middle">
                                                        <span class="badge badge-info">
                                                            No. {{ $factor->id }}
                                                        </span>

                                                        <a href="{{ route('factors.show', $factor->id) }}"
                                                           class="btn btn-light"
                                                        >
                                                            {{ $factor->uuid }}
                                                        </a>


                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ route('users.show', $factor->user->id) }}">
                                                            {{ $factor->user->name }}
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($factor->price) . ' تومن ' }}
                                                        @if(!empty($factor->discount_code))
                                                            <br>
                                                            <span
                                                                class="text-success">{{ $factor->discount_code  }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-success">
                                                        <span class="ltr">
                                                        {{ number_format($factor->profit) }}
                                                        </span>
                                                        تومن
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $factor->pay_reference }}
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد '}}
                                                    </td>
                                                    <td class="align-middle">

                                                        <div class="form-group row align-items-center">

                                                            <label for="shipping_status_{{$factor->id}}"
                                                                   class="col-form-label col-2 badge
                                                                    {{  ($factor->delivery == '0')? 'badge-warning' : null }}
                                                                   {{ ($factor->delivery == '1') ? 'badge-info' : null }}
                                                                   {{ ($factor->delivery == '2') ? 'badge-success' : null }}
                                                                       ">
                                                                <i class="fal fa-2x align-middle fa-truck"></i>
                                                                <span class="d-none">
                                                                        {{ $factor->delivery }}
                                                                    </span>
                                                            </label>

                                                            <div class="col-10">
                                                                <select
                                                                    class="shipping_status form-control custom-select"
                                                                    data-url="{{ route('factors.shipping', $factor->id) }}"
                                                                    name="shipping_status"
                                                                    id="shipping_status_{{$factor->id}}"
                                                                >
                                                                    <option value="0"
                                                                        {{ ($factor->delivery == '0') ? 'selected' : null }}
                                                                    >
                                                                        در انبار
                                                                    </option>

                                                                    <option value="1"
                                                                        {{ ($factor->delivery == '1') ? 'selected' : null }}
                                                                    >
                                                                        پست شده
                                                                    </option>

                                                                    <option value="2"
                                                                        {{ ($factor->delivery == '2') ? 'selected' : null }}
                                                                    >
                                                                        تحویل داده شده
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- @if($factor->delivery == "0")
                                                             <span class="badge badge-warning">در انبار</span>
                                                             <span class="d-none">{{ $factor->delivery }}</span>
                                                         @elseif($factor->delivery == "1")
                                                             <span class="badge badge-info">پست شده</span>
                                                             <span class="d-none">{{ $factor->delivery }}</span>
                                                         @else
                                                             <span class="badge badge-success">تحویل داده شده</span>
                                                             <span class="d-none">{{ $factor->delivery }}</span>
                                                         @endif--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>سود</td>
                                                <td>مرجع پرداخت</td>
                                                <td>تعداد محصول</td>
                                                <td>وضعیت ارسال</td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    {{--./PAID FACTORS TABLE--}}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--FAILURE FACTORS--}}
                    @if(!empty($factors['failure']) && count($factors['failure']))
                        <div class="col-12 my-2">
                            <a class="btn btn-outline-warning w-100"
                               data-toggle="collapse"
                               href="#failureFactors"
                               role="button"
                               aria-expanded="false"
                               aria-controls="failureFactors"
                            >
                                <i class="fal fa-2x fa-warning align-middle mr-2"></i>
                                فعال دارای خطا

                            </a>
                            <div class="collapse" id="failureFactors">
                                <div class="card card-body">
                                    {{--FAILURE FACTORS TABLE--}}
                                    <div class="table-responsive" id="failure-factors-content">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="datatable-failure-factors">
                                            <thead>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>تعداد محصول</td>
                                                <td>کد خطا</td>
                                                <td>پیام خطا</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['failure'] as $factor)
                                                <tr class="text-center" id="data-{{$factor->id}}">
                                                    {{--ID--}}
                                                    <td class="align-middle">
                                                        <a href="{{ route('factors.show', $factor->id) }}"
                                                           class="btn btn-light"
                                                        >
                                                            {{ $factor->uuid }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ route('users.show', $factor->user->id) }}">
                                                            {{ $factor->user->name }}
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($factor->price) . ' تومن ' }}
                                                        @if(!empty($factor->discount_code))
                                                            <br>
                                                            <span
                                                                class="text-success">{{ $factor->discount_code  }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد ' }}
                                                    </td>
                                                    <td class="align-middle ltr">
                                                        {{ $factor->error_code }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $factor->error_message }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>تعداد محصول</td>
                                                <td>کد خطا</td>
                                                <td>پیام خطا</td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    {{--./FAILURE FACTORS TABLE--}}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--UNPAID(ACTIVE) FACTORS--}}
                    @if(!empty($factors['unpaid']) && count($factors['unpaid']))
                        <div class="col-12 my-2">
                            <a class="btn btn-outline-info w-100"
                               data-toggle="collapse"
                               href="#unpaidFactors"
                               role="button"
                               aria-expanded="false"
                               aria-controls="unpaidFactors"
                            >
                                <i class="fal fa-2x fa-tasks-alt align-middle mr-2"></i>
                                فعال پرداخت نشده

                            </a>
                            <div class="collapse" id="unpaidFactors">
                                <div class="card card-body">
                                    {{--ACTIVE FACTORS TABLE--}}
                                    <div class="table-responsive" id="unpaid-factors-content">

                                        <table class="table table-striped table-bordered table-hover"
                                               id="datatable-unpaid-factors">
                                            <thead>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>تعداد محصول</td>
                                                <td>تاریخ ثبت</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['unpaid'] as $factor)
                                                <tr class="text-center" id="data-{{$factor->id}}">
                                                    {{--ID--}}
                                                    <td class="align-middle">
                                                        <a href="{{ route('factors.show', $factor->id) }}"
                                                           class="btn btn-light"
                                                        >
                                                            {{ $factor->uuid }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ route('users.show', $factor->user->id) }}">
                                                            {{ $factor->user->name }}
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($factor->price) . ' تومن ' }}
                                                        @if(!empty($factor->discount_code))
                                                            <br>
                                                            <span
                                                                class="text-success">{{ $factor->discount_code  }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد ' }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ verta($factor->created_at)->formatJalaliDate() }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>تعداد محصول</td>
                                                <td>تاریخ ثبت</td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    {{--./ACTIVE FACTORS TABLE--}}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--DELETED FACTORS--}}
                    @if(!empty($factors['deleted']) && count($factors['deleted']))
                        <div class="col-12 my-2">
                            <a class="btn btn-outline-primary w-100"
                               data-toggle="collapse"
                               href="#deletedFactors"
                               role="button"
                               aria-expanded="false"
                               aria-controls="deletedFactors"
                            >
                                <i class="fal fa-2x fa-trash-alt align-middle mr-2"></i>
                                حذف شده

                            </a>
                            <div class="collapse" id="deletedFactors">
                                <div class="card card-body">
                                    {{--DELETED FACTORS TABLE--}}
                                    <div class="table-responsive" id="deleted-factors-content">

                                        <table class="table table-striped table-bordered table-hover"
                                               id="datatable-deleted-factors">
                                            <thead>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>وضعیت</td>
                                                <td>تعداد محصول</td>
                                                <td>تاریخ حذف</td>
                                                <td>عملیات</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['deleted'] as $factor)
                                                <tr class="text-center" id="data-{{$factor->id}}">
                                                    {{--ID--}}
                                                    <td class="align-middle">
                                                        <a href="{{ route('factors.show', $factor->id) }}"
                                                           class="btn btn-light"
                                                        >
                                                            {{ $factor->uuid }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ route('users.show', $factor->user->id) }}">
                                                            {{ $factor->user->name }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ number_format($factor->price) . ' تومن ' }}
                                                        @if(!empty($factor->discount_code))
                                                            <br>
                                                            <span
                                                                class="text-success">{{ $factor->discount_code  }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="align-middle">
                                                        @if($factor->status == '0')
                                                            <span class="badge badge-danger">
                                                                پرداخت نشده
                                                            </span>
                                                        @elseif($factor->status == '1')
                                                            <span class="badge badge-success">
                                                                پرداخت شده
                                                            </span>
                                                        @elseif($factor->status == '2')
                                                            <span class="badge badge-warning">
                                                                دارای خطا
                                                            </span>
                                                            <br>
                                                            <span>
                                                                {{ $factor->error_code }}
                                                            </span>
                                                            <br>
                                                            <span>
                                                                {{ $factor->error_message }}
                                                            </span>

                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد '}}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ verta($factor->deleted_at)->formatJalaliDate() }}
                                                    </td>
                                                    {{--OPERATION--}}
                                                    <td class="align-middle">

                                                        <button
                                                            id="restore_factor_{{ $factor->id }}"
                                                            data-url="{{ route('factors.restore', $factor->id) }}"
                                                            class="restore_factor btn btn-outline-danger"
                                                        >
                                                            <i class="fal fa-2x align-middle fa-trash-restore"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>وضعیت</td>
                                                <td>تعداد محصول</td>
                                                <td>تاریخ حذف</td>
                                                <td>عملیات</td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    {{--./DELETED FACTORS TABLE--}}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--ARCHIVED FACTORS--}}
                    @if(!empty($factors['archived']) && count($factors['archived']))
                        <div class="col-12 my-2">
                            <a class="btn btn-outline-primary w-100"
                               data-toggle="collapse"
                               href="#archivedFactors"
                               role="button"
                               aria-expanded="false"
                               aria-controls="archivedFactors"
                            >
                                <i class="fal fa-2x fa-archive align-middle mr-2"></i>
                                آرشیو

                            </a>
                            <div class="collapse" id="archivedFactors">
                                <div class="card card-body">
                                    {{--ARCHIVED FACTORS TABLE--}}
                                    <div class="table-responsive" id="archived-factors-content">

                                        <table class="table table-striped table-bordered table-hover"
                                               id="datatable-archived-factors">
                                            <thead>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>وضعیت</td>
                                                <td>تعداد محصول</td>
                                                <td>آخرین بروزرسانی</td>
                                                <td>عملیات</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['archived'] as $factor)
                                                <tr class="text-center" id="data-{{$factor->id}}">
                                                    {{--ID--}}
                                                    <td class="align-middle">
                                                        <a href="{{ route('factors.show', $factor->id) }}"
                                                           class="btn btn-light"
                                                        >
                                                            {{ $factor->uuid }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ route('users.show', $factor->user->id) }}">
                                                            {{ $factor->user->name }}
                                                        </a>
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ number_format($factor->price) . ' تومن ' }}
                                                        @if(!empty($factor->discount_code))
                                                            <br>
                                                            <span
                                                                class="text-success">{{ $factor->discount_code  }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="align-middle">
                                                        @if($factor->status == '0')
                                                            <span class="badge badge-danger">
                                                                پرداخت نشده
                                                            </span>
                                                        @elseif($factor->status == '2')
                                                            <span class="badge badge-warning">
                                                                دارای خطا
                                                            </span>
                                                            <br>
                                                            <span>
                                                                {{ $factor->error_code }}
                                                            </span>
                                                            <br>
                                                            <span>
                                                                {{ $factor->error_message }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد '}}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ verta($factor->updated_at)->formatJalaliDate() }}
                                                    </td>
                                                    {{--OPERATION--}}
                                                    <td class="align-middle">

                                                        <button data-url="{{ route('factors.unarchive', $factor->id) }}"
                                                                id="unarchive_factor_{{$factor->id}}"
                                                                class="unarchive_factor btn btn-outline-warning"
                                                        >
                                                            <i class="fal fa-2x align-middle fa-redo"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>وضعیت</td>
                                                <td>تعداد محصول</td>
                                                <td>آخرین بروزرسانی</td>
                                                <td>عملیات</td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    {{--./ARCHIVED FACTORS TABLE--}}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>{{--END ROW--}}
            </div>{{--END CARD BODY--}}
        </div>{{--END CARD--}}
    </div>{{--END COL-12--}}
@endsection

@section('page-scripts')
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            /*UNARCHIVE FACTOR SECTION*/
            let unarchive_factor = $(".unarchive_factor");
            unarchive_factor.on('click', function(e){
               e.preventDefault();
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (result) {
                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: result.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(function(){
                            location.reload();
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

            /*RESTORE FACTOR SECTION*/
            let restore_factor = $(".restore_factor");
            restore_factor.on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (result) {
                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: result.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(function(){
                            location.reload();
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

            /*SHORT HAND CHANGE SHIPPING STATUS*/
            let shipping_status = $(".shipping_status");
            shipping_status.on('change', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'delivery': $(this).val(),
                        'text' : $(this).find("option:selected").text(),
                        'short_access' : true,
                    },
                    success: function (result) {
                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: result.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(function(){
                            location.reload();
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

            $('#datatable-paid-factors').DataTable({
                "responsive": true,
                "language": {
                    'search': ' جست و جو : ',
                    'lengthMenu': 'نمایش  _MENU_  تایی ',
                    'zeroRecords': 'چیزی یافت نشد',
                    'info': 'نمایش صفحه _PAGE_ از _PAGES_',
                    'infoEmpty': 'رکوردی یافت نشد',
                    'infoFiltered': '(فیلتر شده از _MAX_ مجموعه رکوردها)',

                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                'pageLength': 100,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false
            });
            $('#datatable-unpaid-factors').DataTable({
                "responsive": true,
                "language": {
                    'search': ' جست و جو : ',
                    'lengthMenu': 'نمایش  _MENU_  تایی ',
                    'zeroRecords': 'چیزی یافت نشد',
                    'info': 'نمایش صفحه _PAGE_ از _PAGES_',
                    'infoEmpty': 'رکوردی یافت نشد',
                    'infoFiltered': '(فیلتر شده از _MAX_ مجموعه رکوردها)',

                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                'pageLength': 100,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false
            });

            $('#datatable-deleted-factors').DataTable({
                "responsive": true,
                "language": {
                    'search': ' جست و جو : ',
                    'lengthMenu': 'نمایش  _MENU_  تایی ',
                    'zeroRecords': 'چیزی یافت نشد',
                    'info': 'نمایش صفحه _PAGE_ از _PAGES_',
                    'infoEmpty': 'رکوردی یافت نشد',
                    'infoFiltered': '(فیلتر شده از _MAX_ مجموعه رکوردها)',

                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                'pageLength': 100,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false
            });
            $('#datatable-failure-factors').DataTable({
                "responsive": true,
                "language": {
                    'search': ' جست و جو : ',
                    'lengthMenu': 'نمایش  _MENU_  تایی ',
                    'zeroRecords': 'چیزی یافت نشد',
                    'info': 'نمایش صفحه _PAGE_ از _PAGES_',
                    'infoEmpty': 'رکوردی یافت نشد',
                    'infoFiltered': '(فیلتر شده از _MAX_ مجموعه رکوردها)',

                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                'pageLength': 100,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false
            });
            $('#datatable-archived-factors').DataTable({
                "responsive": true,
                "language": {
                    'search': ' جست و جو : ',
                    'lengthMenu': 'نمایش  _MENU_  تایی ',
                    'zeroRecords': 'چیزی یافت نشد',
                    'info': 'نمایش صفحه _PAGE_ از _PAGES_',
                    'infoEmpty': 'رکوردی یافت نشد',
                    'infoFiltered': '(فیلتر شده از _MAX_ مجموعه رکوردها)',

                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی"
                    }
                },
                'pageLength': 100,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false
            });
        });


    </script>
@endsection

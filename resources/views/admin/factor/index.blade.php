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
                                                <td>مرجع پرداخت</td>
                                                <td>تعداد محصول</td>
                                                <td>وضعیت ارسال</td>
                                                <td>عملیات</td>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($factors['paid'] as $factor)
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
                                                        {{ $factor->pay_reference }}
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $factor->count . ' عدد '}}
                                                    </td>
                                                    <td class="align-middle">
                                                        @if($factor->delivery == "0")
                                                            <span class="badge badge-primary">در انبار</span>
                                                        @elseif($factor->delivery == "1")
                                                            <span class="badge badge-primary">پست شده</span>
                                                        @else
                                                            <span class="badge badge-primary">تحویل داده شده</span>
                                                        @endif
                                                    </td>
                                                    {{--OPERATION--}}
                                                    <td class="align-middle">

                                                        <a href="{{ route('factors.edit', $factor->id) }}"
                                                           class="btn btn-info"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                            <tfoot>
                                            <tr class="text-center">
                                                <td>#</td>
                                                <td>کاربر</td>
                                                <td>مبلغ</td>
                                                <td>مرجع پرداخت</td>
                                                <td>تعداد محصول</td>
                                                <td>وضعیت ارسال</td>
                                                <td>عملیات</td>
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
                                                <td>عملیات</td>
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
                                                    {{--OPERATION--}}
                                                    <td class="align-middle">

                                                        <a href="{{ route('factors.edit', $factor->id) }}"
                                                           class="btn btn-info"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

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
                                                <td>عملیات</td>
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
                                                <td>عملیات</td>
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
                                                    {{--OPERATION--}}
                                                    <td class="align-middle">

                                                        <a href="{{ route('factors.edit', $factor->id) }}"
                                                           class="btn btn-info"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

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
                                                <td>عملیات</td>
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

                                                        <a href="{{ route('factors.edit', $factor->id) }}"
                                                           class="btn btn-info"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

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

                                                        <a href="{{ route('factors.edit', $factor->id) }}"
                                                           class="btn btn-info"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

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
    <script type="text/javascript" src="{{ asset('adminrc/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            let destroy_button = $('.destroy-button');
            destroy_button.on('click', function () {
                let delete_address = $(this).attr('data-url');

                swal({
                    title: "آیا از حذف کاربر مطمعنید؟",
                    text: "با حذف کاربر، قادر به بازگردانی آن نخواهید بود!",
                    icon: "warning",
                    buttons: ['نه! حذفش نکن.', 'آره، حذفش کن.'],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            // console.log('delete');
                            $.ajax({
                                url: delete_address,
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    '_method': 'DELETE',
                                },
                                success: function (result) {
                                    location.reload();
                                },
                                error: function () {
                                    swal({
                                        text: "خطای غیر منتظره ای رخ داده، لطفا با توسعه دهنده در میان بگذارید.",
                                        icon: 'error',
                                        button: "فهمیدم.",
                                    });
                                }
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

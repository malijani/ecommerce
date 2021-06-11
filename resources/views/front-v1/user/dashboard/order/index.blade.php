@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.orders') }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('front-v1/datatables/dataTables.bootstrap4.css')}}">
@endpush

@section('dashboard-content')
    <h4 class="mb-5">لیست سفارش های شما</h4>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-hover" id="datatable-user-orders">
                        <thead>
                        <tr class="text-center">
                            <td>فاکتور</td>
                            <td>هزینه</td>
                            <td>وضعیت پرداخت</td>
                            <td>وضعیت تحویل</td>
                            <td>تعداد محصولات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($factors as $factor)
                            <tr class="text-center" id="data-{{$factor->uuid}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">
                                    <a href="{{ route('dashboard.orders.show', $factor->uuid ) }}"
                                       class="badge badge-light font-16"
                                       title="برای مشاهده جزییات فاکتور؛ کلیک کنید!"
                                    >
                                        {{ $factor->uuid }}
                                    </a>
                                </td>
                                {{--SHOW PRICE--}}
                                <td class="align-middle text-center">
                                    {{ number_format($factor->price) . " تومن " }}
                                    @if(!empty($factor->discount_price))
                                        <br>
                                        <span
                                            class="text-success">{{ number_format($factor->discount_price) . " تومن تخفیف "  }}</span>
                                    @endif
                                </td>

                                {{--SHOW PAY STATUS--}}
                                <td class="align-middle text-center">
                                    @if($factor->status == "0")
                                        <span class="badge badge-danger">پرداخت نشده</span>
                                    @elseif($factor->status == "1")
                                        <span class="badge badge-success">پرداخت شده</span>
                                    @else
                                        <span class="badge badge-warning">خطا در پرداخت</span>
                                    @endif
                                </td>
                                {{--SHOW DELIVERY STATUS--}}
                                <td class="align-middle text-center">
                                    @if($factor->delivery == "0")
                                        <span class="badge badge-primary">در انبار</span>
                                    @elseif($factor->delivery == "1")
                                        <span class="badge badge-primary">پست شده</span>
                                    @else
                                        <span class="badge badge-primary">تحویل داده شده</span>
                                    @endif
                                </td>

                                {{--SHOW PRODUCTS COUNT--}}
                                <td class="align-middle text-center">
                                    {{ $factor->count . " عدد " }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        @if(!empty($deleted_factors) && count($deleted_factors))
            <div class="row">
                <div class="col-12 mt-4">

                    <div class="">
                        <a class="btn btn-outline-info w-100 text-center font-16 font-weight-bolder"
                           data-toggle="collapse"
                           href="#deletedFactorsCollapse"
                           role="button"
                           aria-expanded="false"
                           aria-controls="deletedFactorsCollapse"
                        >
                            <i class="fal fa-eye"></i>
                            <span class="align-middle">
                                مشاهده فاکتور های حذف شده
                            </span>
                        </a>
                    </div>
                    <div class="collapse" id="deletedFactorsCollapse">
                        <div class="card card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="deleted_factos_table">
                                    <thead>
                                    <tr class="text-center alert-info">
                                        <td colspan="2">
                                            برای بازگردانی فاکتور حذف شده، شماره فاکتور را به همراه درخواست خود به پشتیبانی تیکت
                                            بزنید.
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="font-weight-bolder">
                                            فاکتور
                                        </td>
                                        <td class="font-weight-bolder">
                                            تاریخ حذف
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deleted_factors as $deleted_date => $deleted_uuid)
                                        <tr class="text-center">
                                            <td class="font-16">
                                                {{ $deleted_uuid }}
                                            </td>
                                            <td class="font-16">
                                                {{ verta($deleted_date)->formatJalaliDate() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('front-v1/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front-v1/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#datatable-user-orders').DataTable({
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
                'pageLength': 25,
                'order': [],
                "info": false,
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "autoWidth": true
            });

        });


    </script>
@endpush




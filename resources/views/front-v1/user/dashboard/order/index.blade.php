@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.orders') }}
@endsection

@section('dashboard-content')
    <div class="card border-0 p-0">
        <div class="card-header">
            <h4 class="my-2">لیست سفارش های شما</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @if(!empty($factors))

                        {{--SHOW ACTIVE FACTORS--}}

                        @if(!empty($factors['active_factors']) && count($factors['active_factors']))
                            <div class="col-12 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="btn btn-light w-100 text-center font-16 font-weight-bolder"
                                           data-toggle="collapse"
                                           href="#activeFactorsCollapse"
                                           role="button"
                                           aria-expanded="false"
                                           aria-controls="activeFactorsCollapse"
                                        >
                                            <i class="fal fa-file-invoice-dollar fa-2x align-middle ml-2"></i>
                                            <span class="align-middle">
                                        فاکتور های فعال
                                    </span>
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="collapse show" id="activeFactorsCollapse">

                                            <div class="table-responsive" id="table-content">

                                                <table class="table table-striped table-hover">
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

                                                    @foreach($factors['active_factors'] as $active_factor)
                                                        <tr class="text-center" id="data-{{$active_factor->uuid}}">
                                                            {{--SHOW ID--}}
                                                            <td class="align-middle">
                                                                <a href="{{ route('dashboard.orders.show', $active_factor->uuid ) }}"
                                                                   class="badge badge-light font-16"
                                                                   title="برای مشاهده جزییات فاکتور؛ کلیک کنید!"
                                                                >
                                                                    {{ $active_factor->uuid }}
                                                                </a>
                                                            </td>
                                                            {{--SHOW PRICE--}}
                                                            <td class="align-middle text-center">
                                                                {{ number_format($active_factor->price) . " تومن " }}
                                                                @if(!empty($active_factor->discount_price))
                                                                    <br>
                                                                    <span
                                                                        class="text-success">{{ number_format($active_factor->discount_price) . " تومن تخفیف "  }}</span>
                                                                @endif
                                                            </td>

                                                            {{--SHOW PAY STATUS--}}
                                                            <td class="align-middle text-center">
                                                                @if($active_factor->status == "0")
                                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                                @elseif($active_factor->status == "1")
                                                                    <span class="badge badge-success">پرداخت شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-warning">خطا در پرداخت</span>
                                                                @endif
                                                            </td>
                                                            {{--SHOW DELIVERY STATUS--}}
                                                            <td class="align-middle text-center">
                                                                @if($active_factor->delivery == "0")
                                                                    <span class="badge badge-primary">در انبار</span>
                                                                @elseif($active_factor->delivery == "1")
                                                                    <span class="badge badge-primary">پست شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-primary">تحویل داده شده</span>
                                                                @endif
                                                            </td>

                                                            {{--SHOW PRODUCTS COUNT--}}
                                                            <td class="align-middle text-center">
                                                                {{ $active_factor->count . " عدد " }}
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

                        {{--SHOW PAID FACTORS--}}
                        @if(!empty($factors['paid_factors']) && count($factors['paid_factors']))
                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="btn btn-light w-100 text-center font-16 font-weight-bolder"
                                           data-toggle="collapse"
                                           href="#paidFactorsCollapse"
                                           role="button"
                                           aria-expanded="false"
                                           aria-controls="paidFactorsCollapse"
                                        >
                                            <i class="fal fa-check-square fa-2x align-middle ml-2"></i>
                                            <span class="align-middle">
                                 فاکتور های پرداخت شده
                                </span>
                                        </a>

                                    </div>
                                    <div class="card-body p-0">
                                        <div class="collapse show" id="paidFactorsCollapse">
                                            <div class="table-responsive" id="table-content">
                                                <table class="table table-striped table-hover"
                                                       id="datatable-user-paid-orders">
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
                                                    @foreach($factors['paid_factors'] as $paid_factor)
                                                        <tr class="text-center" id="data-{{$paid_factor->uuid}}">
                                                            {{--SHOW ID--}}
                                                            <td class="align-middle">
                                                                <a href="{{ route('dashboard.orders.show', $paid_factor->uuid ) }}"
                                                                   class="badge badge-light font-16"
                                                                   title="برای مشاهده جزییات فاکتور؛ کلیک کنید!"
                                                                >
                                                                    {{ $paid_factor->uuid }}
                                                                </a>
                                                            </td>
                                                            {{--SHOW PRICE--}}
                                                            <td class="align-middle text-center">
                                                                {{ number_format($paid_factor->price) . " تومن " }}
                                                                @if(!empty($paid_factor->discount_price))
                                                                    <br>
                                                                    <span
                                                                        class="text-success">{{ number_format($paid_factor->discount_price) . " تومن تخفیف "  }}</span>
                                                                @endif
                                                            </td>

                                                            {{--SHOW PAY STATUS--}}
                                                            <td class="align-middle text-center">
                                                                @if($paid_factor->status == "0")
                                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                                @elseif($paid_factor->status == "1")
                                                                    <span class="badge badge-success">پرداخت شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-warning">خطا در پرداخت</span>
                                                                @endif
                                                            </td>
                                                            {{--SHOW DELIVERY STATUS--}}
                                                            <td class="align-middle text-center">
                                                                @if($paid_factor->delivery == "0")
                                                                    <span class="badge badge-primary">در انبار</span>
                                                                @elseif($paid_factor->delivery == "1")
                                                                    <span class="badge badge-primary">پست شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-primary">تحویل داده شده</span>
                                                                @endif
                                                            </td>

                                                            {{--SHOW PRODUCTS COUNT--}}
                                                            <td class="align-middle text-center">
                                                                {{ $paid_factor->count . " عدد " }}
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

                        {{--SHOW ARCHIVED FACTOS--}}
                        @if(!empty($factors['archived_factors']) && count($factors['archived_factors']))
                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="btn btn-light w-100 text-center font-16 font-weight-bolder"
                                           data-toggle="collapse"
                                           href="#archivedFactorsCollapse"
                                           role="button"
                                           aria-expanded="false"
                                           aria-controls="archivedFactorsCollapse"
                                        >
                                            <i class="fal fa-archive fa-2x align-middle ml-2"></i>
                                            <span class="align-middle">
                                 فاکتور های آرشیو شده
                                </span>
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="collapse" id="archivedFactorsCollapse">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-borderless"
                                                       id="archived_factors_table">
                                                    <thead>
                                                    <tr class="text-center alert-warning">
                                                        <td colspan="3">
                                                            فاکتور های آرشیو شده بیش از ۲ روز ثبت و پرداخت نشده اند.
                                                        </td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class="font-weight-bolder">
                                                            فاکتور
                                                        </td>
                                                        <td class="font-weight-bolder">
                                                            آخرین بروز رسانی
                                                        </td>
                                                        <td class="font-weight-bolder">
                                                            وضعیت
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($factors['archived_factors'] as $archived_factor)
                                                        <tr class="text-center">
                                                            <td class="font-16">
                                                                {{ $archived_factor->uuid }}
                                                            </td>
                                                            <td class="font-16">
                                                                {{ verta($archived_factor->updated_at)->formatJalaliDate() }}
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                @if($archived_factor->status == "0")
                                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                                @elseif($archived_factor->status == "1")
                                                                    <span class="badge badge-success">پرداخت شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-warning">خطا در پرداخت</span>
                                                                @endif
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

                        {{--SHOW DELETED FACTORS--}}
                        @if(!empty($factors['deleted_factors']) && count($factors['deleted_factors']))
                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="btn btn-light w-100 text-center font-16 font-weight-bolder"
                                           data-toggle="collapse"
                                           href="#deletedFactorsCollapse"
                                           role="button"
                                           aria-expanded="false"
                                           aria-controls="deletedFactorsCollapse"
                                        >
                                            <i class="fal fa-trash-alt fa-2x align-middle ml-2"></i>
                                            <span class="align-middle">
                                 فاکتور های حذف شده
                                </span>
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="collapse" id="deletedFactorsCollapse">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-borderless"
                                                       id="deleted_factors_table">
                                                    <thead>
                                                    <tr class="text-center alert-info">
                                                        <td colspan="3">
                                                            برای بازگردانی فاکتور حذف شده، شماره فاکتور را به همراه
                                                            درخواست خود به
                                                            پشتیبانی تیکت
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
                                                        <td class="font-weight-bolder">
                                                            وضعیت
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($factors['deleted_factors'] as $deleted_factor)
                                                        <tr class="text-center">
                                                            <td class="font-16">
                                                                {{ $deleted_factor->uuid }}
                                                            </td>
                                                            <td class="font-16">
                                                                {{ verta($deleted_factor->deleted_at)->formatJalaliDate() }}
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                @if($deleted_factor->status == "0")
                                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                                @elseif($deleted_factor->status == "1")
                                                                    <span class="badge badge-success">پرداخت شده</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-warning">خطا در پرداخت</span>
                                                                @endif
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
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection



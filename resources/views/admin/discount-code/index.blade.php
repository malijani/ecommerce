@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('discount-codes.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست کد های تخفیف</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-discount-codes">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>کد</td>
                            <td>درصد تخفیف</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($discount_codes as $discount_code)
                            <tr class="text-center" id="data-{{$discount_code->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $discount_code->id }}</td>

                                {{--SHOW CODE--}}
                                <td class="align-middle text-center">
                                    {{ $discount_code->code }}
                                </td>
                                {{--SHOW PERCENT--}}
                                <td class="align-middle text-center">
                                    % {{ $discount_code->percent }}
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($discount_code->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($discount_code->status ==0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">

                                    <input class="status big-checkbox mb-1 w-100 text-green"
                                           type="checkbox"
                                           @if($discount_code->status == 1) checked @endif
                                           id="status-{{$discount_code->id}}"
                                           title="تعیین بعنوان پیشفرض"
                                           data-url="{{ route('discount-codes.update', $discount_code->id) }}"
                                           readonly
                                    >
                                    <a href="{{ route('discount-codes.edit', $discount_code->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{ $discount_code->id }}"
                                            title="حذف کد تخفیف"
                                            data-url="{{route('discount-codes.destroy', $discount_code->id)}}"
                                    >
                                        <i class="fa fa-trash-o text-white"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>

                        <tr class="text-center">
                            <td>شماره</td>
                            <td>کد</td>
                            <td>درصد تخفیف</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>

                        </tfoot>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript" src="{{ asset('adminrc/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            /*SET STATUS ON THE FLY*/
            let status = $('.status');
            status.on('click', function () {
                status.not(this).prop('checked', false);
                let update_address = $(this).attr('data-url');
                $.ajax({
                    url: update_address,
                    type: 'POST',
                    data: {
                        '_method': 'PATCH',
                        'status': 'on',
                        'ajax': '1',
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


            });

            let destroy_button = $('.destroy-button');
            destroy_button.on('click', function () {
                let delete_address = $(this).attr('data-url');

                swal({
                    title: "آیا از حذف کد تخفیف مطمعنید؟",
                    text: "با حذف کد تخفیف، قادر به بازگردانی آن نخواهید بود!",
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

            /*EDIT BY CLICK ON TITLE*/
            $('#datatable-discount-codes').DataTable({
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
                'pageLength': 50,
                'order': [],
                "info": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": true
            });

        });


    </script>
@endsection

@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('factors.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')
    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست سفارشات</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-factors">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>کاربر</td>
                            <td>پرداختی</td>
                            <td>آیدی</td>
                            <td>مرجع</td>
                            <td>وضعیت</td>
                            <td>هزینه ارسال</td>
                            <td>دریافت شده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($factors as $factor)
                            <tr class="text-center" id="data-{{$factor->id}}">
                                {{--ID--}}
                                <td class="align-middle">{{ $factor->id }}</td>

                                {{--OPERATION--}}
                                <td class="align-middle">

                                    <a href="{{ route('factors.edit', $factor->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$factor->id}}"
                                            title="حذف کاربر"
                                            data-url="{{route('factors.destroy', $user->id)}}"
                                    >
                                        <i class="fa fa-trash-o text-white"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <td>کاربر</td>
                            <td>پرداختی</td>
                            <td>آیدی</td>
                            <td>مرجع</td>
                            <td>وضعیت</td>
                            <td>هزینه ارسال</td>
                            <td>دریافت شده</td>
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

            $('#datatable-factors').DataTable({
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
                "autoWidth": true
            });

        });


    </script>
@endsection

@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('favicons.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست فاواکن های {{ config('app.brand.name') }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-favicons">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>وضعیت</td>
                            <td>آیکن</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($favicons as $website_favicon)
                            <tr class="text-center" id="data-{{$website_favicon->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $website_favicon->id }}</td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($website_favicon->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($website_favicon->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>
                                {{--SHOW PIC--}}
                                <td class="align-middle text-center w-25">
                                        <img src="{{ asset($website_favicon->pic) }}"
                                             class="img-fluid w-25"
                                        >
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">

                                    <input class="status big-checkbox mb-1 w-100 text-green"
                                           type="radio"
                                           @if($website_favicon->status == 1) checked @endif
                                           id="status-{{$website_favicon->id}}"
                                           title="تعیین بعنوان پیشفرض"
                                           data-url="{{ route('favicons.update', $website_favicon->id) }}"
                                           readonly
                                    >
                                    <a href="{{ route('favicons.edit', $website_favicon->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$website_favicon->id}}"
                                            title="حذف لوگو"
                                            data-url="{{route('favicons.destroy', $website_favicon->id)}}"
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
                            <td>وضعیت</td>
                            <td>آیکن</td>
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

            /*SET DEFAULT IMAGE ON FLY*/
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
                    title: "آیا از حذف فاواکن مطمعنید؟",
                    text: "با حذف فاواکن، قادر به بازگردانی آن نخواهید بود!",
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
            $('#datatable-favicons').DataTable({
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
                'pageLength': 10,
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

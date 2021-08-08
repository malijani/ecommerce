@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('footer-links.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست لینک های فوتر</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-footer-links">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>سر دسته</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($footer_links as $link)

                            <tr class="text-center" id="data-{{$link->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $link->id }}</td>
                                {{--SHOW ITEM--}}
                                <td class="align-middle">{{ $link->item->title }}</td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $link->title }}
                                </td>
                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    @if($link->link != "#")
                                        <a href="{{ $link->link }}">{{ $link->link }}</a>
                                    @else
                                        {{ $link->link }}
                                    @endif
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($link->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($link->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>


                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('footer-links.edit', $link->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$link->id}}"
                                            title="حذف لینک فوتر"
                                            data-url="{{route('footer-links.destroy', $link->id)}}"
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
                            <td>عنوان</td>
                            <td>لینک</td>
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

            let destroy_button = $('.destroy-button');
            destroy_button.on('click', function () {
                let delete_address = $(this).attr('data-url');
                swal({
                    title: "آیا از حذف لینک فوتر مطمعنید؟",
                    text: "با حذف لینک فوتر، قادر به بازگردانی آن نخواهید بود!",
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

            $('#datatable-footer-links').DataTable({
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

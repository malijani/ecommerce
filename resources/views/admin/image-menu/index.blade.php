@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('image-menus.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست منو های تصویری</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-image-menus">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>تصویر</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>دسته بندی</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($image_menus as $image_menu)
                            <tr class="text-center" id="data-{{$image_menu->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $image_menu->id }}</td>
                                {{--SHOW image--}}
                                <td class="align-middle text-center w-25">
                                    <span class="hide">{{ $image_menu->title }}</span>
                                    <img src="{{ asset($image_menu->image) }}"
                                         alt="{{ $image_menu->title }}"
                                         class="img-fluid w-25"
                                    >
                                </td>

                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $image_menu->title }}
                                </td>

                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    <a href="{{ $image_menu->link }}">
                                        {{ $image_menu->link }}
                                    </a>
                                </td>
                                {{--SHOW TYPE--}}
                                <td class="align-middle.text-center">
                                    {{ $image_menu->type_text }}
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($image_menu->status === 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($image_menu->status === 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">

                                    <a href="{{ route('image-menus.edit', $image_menu->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$image_menu->id}}"
                                            title="حذف منو تصویری"
                                            data-url="{{route('image-menus.destroy', $image_menu->id)}}"
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
                            <td>تصویر</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>دسته بندی</td>
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
                    title: "آیا از حذف منو تصویر مطمعنید؟",
                    text: "با حذف منو تصویری، قادر به بازگردانی آن نخواهید بود!",
                    icon: "warning",
                    buttons: ['نه! حذفش نکن.', 'آره، حذفش کن.'],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: delete_address,
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    '_method': 'DELETE',
                                },
                                success: function () {
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

            $('#datatable-image-menus').DataTable({
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

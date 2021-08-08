@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('pages.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست صفحات وبسایت</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-pages">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>اولویت</td>
                            <td>بازدید</td>
                            <td>عنوان</td>
                            <td>محتوا</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
                            <td>منو</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($pages as $page)

                            <tr class="text-center" id="data-{{$page->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $page->id }}</td>
                                {{--SHOW SORT--}}
                                <td class="align-middle">{{ $page->sort }}</td>
                                {{--SHOW VISITS--}}
                                <td class="align-middle text-center">
                                    {{ $page->visit }}
                                </td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $page->menu_title }}<hr>{{ $page->title }}<hr>{{ $page->title_en }}
                                </td>
                                {{--SHOW CONTENT--}}
                                <td class="align-middle text-center">
                                    {{ strip_tags($page->content_short) }}
                                </td>
                                {{--SHOW KEYWORDS--}}
                                <td class="align-middle text-center">
                                    {{ $page->keywords_short }}
                                </td>
                                {{--SHOW DESCRIPTION--}}
                                <td class="align-middle text-center">
                                    {{ $page->description_short }}
                                </td>

                                {{--SHOW MENU--}}
                                <td class="align-middle">
                                    @if($page->menu == 1)
                                        <span class="badge badge-success">نمایش</span>
                                        <span class="hide">{{ $page->menu }}</span>
                                    @elseif($page->menu == 0)
                                        <span class="badge badge-warning">عدم نمایش</span>
                                        <span class="hide">{{ $page->menu }}</span>
                                    @else
                                        نامشخص
                                    @endif
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($page->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                        <span class="hide">{{ $page->status }}</span>
                                    @elseif($page->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                        <span class="hide">{{ $page->status }}</span>
                                    @else
                                        نامشخص
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('pages.edit', $page->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$page->id}}"
                                            title="حذف صفحه"
                                            data-url="{{ route('pages.destroy', $page->id) }}"
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
                            <td>اولویت</td>
                            <td>بازدید</td>
                            <td>عنوان</td>
                            <td>محتوا</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
                            <td>منو</td>
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
                    title: "آیا از حذف صفحه مطمعنید؟",
                    text: "با حذف صفحه، قادر به بازگردانی آن نخواهید بود!",
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

            /*EDIT BY CLICK ON TITLE*/
            $('#datatable-pages').DataTable({
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

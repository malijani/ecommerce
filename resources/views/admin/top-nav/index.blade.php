@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('top-navs.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-6">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ناوبری صفحه متوسط تا بزرگ</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-medium-navs">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($top_navs_medium as $top_nav_medium)

                            <tr class="text-center" id="data-{{$top_nav_medium->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $top_nav_medium->id }}</td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $top_nav_medium->title }}
                                </td>
                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    @if($top_nav_medium->link != "#")
                                        <a href="{{ $top_nav_medium->link }}">{{ $top_nav_medium->link }}</a>
                                    @else
                                        {{ $top_nav_medium->link }}
                                    @endif
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($top_nav_medium->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($top_nav_medium->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>


                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('top-navs.edit', $top_nav_medium->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$top_nav_medium->id}}"
                                            title="حذف اسلایدر"
                                            data-url="{{route('top-navs.destroy', $top_nav_medium->id)}}"
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


    <div class="col-md-6">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ناوبری صفحه کوچک</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-small-navs">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($top_navs_small as $top_nav_small)

                            <tr class="text-center" id="data-{{$top_nav_small->id}}">

                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $top_nav_small->id }}</td>

                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $top_nav_small->title }}
                                </td>

                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    @if($top_nav_small->link != "#")
                                        <a href="{{ $top_nav_small->link }}">{{ $top_nav_small->link }}</a>
                                    @else
                                        {{ $top_nav_small->link }}
                                    @endif
                                </td>

                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($top_nav_small->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($top_nav_small->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>


                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('top-navs.edit', $top_nav_small->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$top_nav_small->id}}"
                                            title="حذف اسلایدر"
                                            data-url="{{route('top-navs.destroy', $top_nav_small->id)}}"
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
                    title: "آیا از حذف ناوبری مطمعنید؟",
                    text: "با حذف ناوبری، قادر به بازگردانی آن نخواهید بود!",
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

            /*EDIT BY CLICK ON TITLE*/
            $('#datatable-medium-navs').DataTable({
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

        $('#datatable-small-navs').DataTable({
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



    </script>
@endsection

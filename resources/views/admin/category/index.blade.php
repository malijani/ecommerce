@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/jstree/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .jstree-open > .jstree-anchor > .fa-folder:before {
            content: "\f07c";
        }

        .jstree-default .jstree-icon.none {
            width: 0;
        }
    </style>
@endsection

@section('nav-buttons')
    <a href="{{ route('categories.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')


    <div class="col-md-6">
        <!-- TREE box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست دسته بندی ها</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{--            JSTREE TO SHOW CATEGORIES REQURSIVE--}}
                <div id="jstree-categories">
                    <ul>
                        <li>
                            <a onclick="cat(0)" id="parents">سردسته ها</a>
                        </li>
                        @foreach($categories as $category)
                            <li id="jstree-data{{$category->id}}">
                                <a onclick="cat({{ $category->id }})">{{ $category->title }}</a>
                                @if($category->childrenRecursive->count())
                                    @include('admin.category.partials.index_category_child', ['children'=>$category->childrenRecursive])
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            {{--            END JSTREE--}}
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-12">
            <div class="border border-info bg-white py-2 px-2">
                <h6>ثبت دو سردسته زیر حیاتی است: </h6>
                <ul class="pr-4">
                    <li>products => محصولات</li>
                    <li>articles => مقالات</li>
                </ul>
                <p> *
                    محصولات و مقالات بعنوان دسته بندی های اصلی و اولین زیرشاخه های آنان بعنوان عنوان گروه بندی و زیر شاخه های سوم به بعد بعنوان موارد دسته بندی محسوب می‌شوند.
                </p>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست فرزندان</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">
                    {{--RENDER TABLE HERE WITH AJAX--}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript" src="{{ asset('adminrc/plugins/jstree/jstree.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">

        function del(id) {

            swal({
                title: "آیا از حذف دسته بندی مطمعنید؟",
                text: "با حذف دسته بندی، قادر به بازگردانی آن نخواهید بود!",
                icon: "warning",
                buttons: ['نه! حذفش نکن.', 'آره، حذفش کن.'],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        // console.log('delete');
                        $.ajax({
                            url: $("#del" + id).attr('data-url'),
                            type: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                '_method': 'DELETE',
                                'id': id,
                            },
                            success: function (result) {
                                $('#data' + id).remove();
                                $('#jstree-data' + id).remove();
                                swal({
                                    title: result,
                                    text: "دسته بندی شما با موفقیت حذف شد :)",
                                    icon: "success",
                                    button: "حله!",
                                });
                            },
                            error: function () {
                                swal({
                                    text: "خطای غیر منتظره ای رخ داده، لطفا با توسعه دهنده در میان بگذارید.",
                                    icon: 'error',
                                    button: "فهمیدم.",
                                });
                            }
                        });
                        swal({
                            text: "دسته بندی شما با موفقیت حذف شد :)",
                            icon: "success",
                            button: "حله!",
                        });
                    } else {
                        swal({
                            text: "دسته بندی حذف نشد!",
                            icon: 'info',
                            button: 'فهمیدم!',
                        });
                    }
                });
        }


        function cat(id, selector = $("#table-content")) {
            let url = '{{ url('admin/categories/') }}' + '/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,
                },
                success: function (result) {
                    // console.log(result);
                    selector.html('');
                    selector.html(result);
                    // SET datatable-categories AS DATA TABLE

                    $("#datatable-categories").DataTable({
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
                },
                error: function () {
                    // alert('erorr');
                    // swal("Error!", 'مشکلی رخ داده! لطفاً دوباره امتحان نمایید.', 'Problem');
                    $("#datatable-categories").html('');
                    $("#datatable-categories").html('<h3 class="text-danger text-center">جهت دریافت اطلاعات مشکلی به وجود آمده است</h3>')
                }
            });
        }


        $(document).ready(function () {

            // SET jstree-ctegories AS JS TREE
            $('#jstree-categories').jstree({
                'core': {
                    'check_callback': true
                },
                'plugins': ['types', 'dnd'],
                'types': {
                    'default': {
                        'icon': 'fa fa-folder'
                    },
                    'html': {
                        'icon': 'fa fa-file-code-o'
                    },
                    'svg': {
                        'icon': 'fa fa-file-picture-o'
                    },
                    'css': {
                        'icon': 'fa fa-file-code-o'
                    },
                    'img': {
                        'icon': 'fa fa-file-image-o'
                    },
                    'js': {
                        'icon': 'fa fa-file-text-o'
                    }
                }
            });

            // INITIALIZE PARENT TABLE ON PAGE LOAD
            $("#parents").click();

        });


    </script>
@endsection

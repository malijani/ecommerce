@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('articles.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست مقالات</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">
                    <table class="table table-striped table-bordered table-hover" id="datatable-articles">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>بازدید</td>
                            <td>وضعیت</td>
                            <td>دسته بندی</td>
                            <td>تصویر شاخص</td>
                            <td>متن</td>
                            <td>آخرین بروز رسانی</td>
                            <td>ثبت کننده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($articles as $article)
                            <tr class="text-center" id="data{{ $article->id }}">
                                <td class="align-middle">{{ $article->id }}</td>
                                <td class="align-middle">{{ $article->title }}<br>{{ $article->title_en }}</td>
                                <td class="align-middle">{{ $article->visit }}</td>
                                <td class="align-middle">
                                    @if($article->status==0)
                                        <span class="badge badge-danger p-2"><i class="fa fa-times"></i></span>
                                        <span class="hide">{{ $article->status }}</span>
                                    @elseif($article->status==1)
                                        <span class="badge badge-success p-2"><i class="fa fa-check"></i></span>
                                        <span class="hide">{{ $article->status }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $article->category->title }}</td>

                                <td class="align-middle">
                                    <img src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                                         alt="{{ $article->pic_alt ?? $article->title_en }}"
                                         width="100vw"
                                         height="100vh"
                                    >
                                    <span class="hide">{{ $article->sort }}</span>
                                </td>

                                <td class="align-middle">{{ $article->short_text ?? $article->long_text_limited }}</td>
                                <td class="align-middle">{{ $article->jalali_updated_at }}</td>
                                <td class="align-middle">{{ $article->user->full_name }}</td>


                                <td class="align-middle">
                                    <a title="ویرایش"
                                       href="{{ route('articles.edit',['article'=>$article->id]) }}"
                                       class="btn btn-outline-primary btn-sm m-1"
                                       role="button"
                                       id="ed{{$article->id}}"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button title="حذف"
                                            href="#"
                                            class="btn btn-outline-danger btn-sm m-1"
                                            id="del{{$article->id}}"
                                            data-url="articles/{{$article->id}}"
                                            onclick="del({{$article->id}});"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>



{{--                                    <a title="نظرات"--}}
{{--                                       href="COMMENTS_ROUTE"--}}
{{--                                       class="btn btn-outline-success btn-sm"--}}
{{--                                       role="button"--}}
{{--                                    >--}}
{{--                                        <i class="fa fa-comment-o"></i>--}}
{{--                                        <span class="text-danger">--}}
{{--                                            {{ $article->comments != null ? $item->comments->where('status', 0)->count() : 0 }}--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>بازدید</td>
                            <td>وضعیت</td>
                            <td>دسته بندی</td>
                            <td>تصویر شاخص</td>
                            <td>متن</td>
                            <td>آخرین بروز رسانی</td>
                            <td>ثبت کننده</td>
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

        function del(id) {
            swal({
                title: "آیا از حذف مقاله مطمعنید؟",
                text: "با حذف مقاله، قادر به بازگردانی آن نخواهید بود!",
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
                                swal({
                                    title: result,
                                    text: "مقاله با موفقیت حذف شد :)",
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
                            text: "مقاله با موفقیت حذف شد :)",
                            icon: "success",
                            button: "حله!",
                        });
                    } else {
                        swal({
                            text: "مقاله حذف نشد!",
                            icon: 'info',
                            button: 'فهمیدم!',
                        });
                    }
                });
        }

        $(document).ready(function () {
            $("#datatable-articles").DataTable({
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

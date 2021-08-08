@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">مدیریت نظرات کاربران وبسایت</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-comments">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>کاربر</td>
                            <td>مرتبط با</td>
                            <td>محتوا</td>
                            <td>در جواب</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($comments as $comment)

                            <tr class="text-center" id="data-{{$comment->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $comment->id }}</td>
                                {{--SHOW USER--}}
                                <td class="align-middle text-center">
                                    @if(!is_null($comment->user))
                                        <span>{{ $comment->user->full_name }}</span>
                                    @else
                                        <span>مهمان</span>
                                    @endif
                                </td>
                                {{--SHOW COMMENTABLE CONTENT--}}
                                <td class="align-middle text-center">
                                    <a href="{{ $comment->commentable->getLink() }}">
                                        {{ $comment->commentable->title }}
                                    </a>
                                </td>
                                {{--SHOW CONTENT--}}
                                <td class="align-middle text-center">
                                    {{ $comment->content }}
                                </td>
                                {{--SHOW PARENT--}}
                                <td class="align-middle text-center">
                                    @if($comment->parent_id != 0)
                                        {{ \App\Comment::withoutTrashed()->find($comment->parent_id)->content }}
                                    @else
                                        -
                                    @endif
                                </td>


                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($comment->status == 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                        <span class="hide">{{ $comment->status }}</span>

                                        <input name="unverify"
                                               id="unverify-{{$comment->id}}"
                                               data-url="{{ route('comments.update', $comment->id) }}"
                                               type="checkbox"
                                               class="unverify form-control big-checkbox"
                                               title="عدم تایید کامنت"
                                        >

                                    @elseif($comment->status == 0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                        <span class="hide">{{ $comment->status }}</span>

                                        <input name="verify"
                                               id="verify-{{$comment->id}}"
                                               data-url="{{ route('comments.update', $comment->id) }}"
                                               type="checkbox"
                                               class="verify form-control big-checkbox"
                                               title="تایید کامنت"
                                        >

                                    @else
                                        نامشخص
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('comments.edit', $comment->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$comment->id}}"
                                            title="حذف نظر کاربر"
                                            data-url="{{ route('comments.destroy', $comment->id) }}"
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
                            <td>کاربر</td>
                            <td>مرتبط با</td>
                            <td>محتوا</td>
                            <td>در جواب</td>
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
            /**VERIFY**/
            let verify = $('.verify');
            verify.on('click', function () {
                let verify_address = $(this).attr('data-url');
                $.ajax({
                    url: verify_address,
                    type: 'POST',
                    data: {
                        '_method': 'PUT',
                        'verify': 'on',
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

            });
            /**END VERIFY**/


            /**UNVERIFY**/
            let unverify = $('.unverify');
            unverify.on('click', function () {
                let verify_address = $(this).attr('data-url');
                $.ajax({
                    url: verify_address,
                    type: 'POST',
                    data: {
                        '_method': 'PUT',
                        'verify': 'off',
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

            });
            /**END UNVERIFY**/




            let destroy_button = $('.destroy-button');
            destroy_button.on('click', function () {
                let delete_address = $(this).attr('data-url');

                swal({
                    title: "آیا از حذف نظر مطمعنید؟",
                    text: "با حذف نظر، قادر به بازگردانی آن نخواهید بود!",
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
            $('#datatable-comments').DataTable({
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

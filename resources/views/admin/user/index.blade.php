@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('users.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')
        <div class="col-md-12">
            <!-- DETAILS box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست کاربران</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="table-content">

                        <table class="table table-striped table-bordered table-hover" id="datatable-users">
                            <thead>
                            <tr class="text-center">
                                <td>#</td>
                                <td>نمایه</td>
                                <td>نام</td>
                                <td>ارتباط</td>
                                <td>سطح دسترسی</td>
                                <td>تایید اطلاعات تماس</td>
                                <td>وضعیت</td>
                                <td>تاریخ ثبت</td>
                                <td>عملیات</td>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($users as $user)
                                <tr class="text-center" id="data-{{$user->id}}">
                                    {{--ID--}}
                                    <td class="align-middle">{{ $user->id }}</td>
                                    {{--PROFILE PIC--}}
                                    <td class="align-middle">
                                        <img src="{{ asset($user->pic ?? 'images/fallback/user.png') }}"
                                             alt="{{ $user->pic_alt ?? 'نمایه کاربر' }}"
                                             width="100vw"
                                             height="100vh"
                                             class="img img-bordered-sm rounded-circle"
                                        >
                                        <span class="hide">{{ $user->id }}</span>
                                    </td>

                                    {{--NAME , FAMILY + SHOW FULL DETAILS--}}
                                    <td class="align-middle">
                                        <a
                                            href="{{ route('users.show', $user->id) }}"
                                            target="_blank"
                                        >
                                            {{ $user->full_name }}
                                        </a>
                                    </td>
                                    {{--MOBILE, EMAIL--}}
                                    <td class="align-middle">{{$user->mobile}} <br> {{ $user->email }}</td>
                                    {{--LEVEL--}}
                                    <td class="align-middle">
                                        @if($user->isAdmin())
                                            <span class="badge badge-primary">ادمین</span>
                                        @elseif($user->isNormal())
                                            <span class="badge badge-success">کاربر عادی</span>
                                        @else
                                            <span class="badge badge-warning">کاربر نامشخص</span>
                                        @endif
                                    </td>
                                    {{--VERIFIED--}}
                                    <td class="align-middle">
                                        @if(!is_null($user->email_verified_at))
                                            <span class="badge badge-success">
                                            <i class="fa fa-check-square-o"></i>
                                                <span class="hide">1</span>
                                        </span>
                                        @else
                                            <span class="badge badge-danger">
                                            <i class="fa fa-minus-square-o"></i>
                                                <span class="hide">0</span>
                                        </span>
                                        @endif
                                    </td>
                                    {{--STATUS--}}
                                    <td class="align-middle">
                                        @if($user->status==0)
                                            <span class="badge badge-danger p-2"><i class="fa fa-times"></i></span>
                                            <span class="hide">{{ $user->status }}</span>
                                        @elseif($user->status==1)
                                            <span class="badge badge-success p-2"><i class="fa fa-check"></i></span>
                                            <span class="hide">{{ $user->status }}</span>
                                        @endif
                                    </td>
                                    {{--CREATED_AT--}}
                                    <td class="align-middle">{{ $user->created_at }}</td>
                                    {{--OPERATION--}}
                                    <td class="align-middle">

                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="btn btn-info"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <button class="destroy-button btn btn-danger"
                                                id="del-{{$user->id}}"
                                                title="حذف کاربر"
                                                data-url="{{route('users.destroy', $user->id)}}"
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
                                <td>نمایه</td>
                                <td>نام</td>
                                <td>ارتباط</td>
                                <td>سطح دسترسی</td>
                                <td>تایید اطلاعات تماس</td>
                                <td>وضعیت</td>
                                <td>تاریخ ثبت</td>
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
        <div class="col-md-6 offset-3">
            {{ $users->links() }}
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

            $('#datatable-users').DataTable({
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

@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('tickets.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">مدیریت تیکت های کاربران وبسایت</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-tickets">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>کد تیکت</td>
                            <td>کاربر</td>
                            <td>عنوان</td>
                            <td>پیام</td>
                            <td>دسته بندی</td>
                            <td>اولویت</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($tickets as $ticket)

                            <tr class="text-center" id="data-{{$ticket->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $ticket->id }}</td>
                                {{--SHOW CODE--}}
                                <td class="align-middle">{{ $ticket->uuid }}</td>
                                {{--SHOW USER--}}
                                <td class="align-middle text-center">
                                    <span>{{ $ticket->user->full_name}}</span>
                                    <hr>
                                    <span>{{ $ticket->user->contact_information }}</span>
                                </td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $ticket->title }}
                                </td>
                                {{--SHOW CONTENT--}}
                                <td class="align-middle text-center">
                                    {!! $ticket->limited_message !!}
                                    @if(!is_null($ticket->file))
                                        <hr>
                                        <a href="{{ route('ticket-files.show', $ticket->id) }}"
                                        >
                                            دانلود فایل
                                        </a>
                                    @endif
                                </td>
                                {{--SHOW CATEGORY--}}
                                <td class="align-middle text-center">
                                    @if(!is_null($ticket->category_id))
                                        {{ $ticket->category->title }}
                                    @else
                                        <span>دسته بندی حذف شده</span>
                                    @endif
                                </td>
                                {{--SHOW PRIORITY--}}
                                <td class="align-middle">
                                    @if($ticket->priority == 0)
                                        <span class="badge badge-info">{{ $ticket->priority_text }}</span>
                                    @elseif($ticket->priority == 1)
                                        <span class="badge badge-warning">{{ $ticket->priority_text }}</span>
                                    @elseif($ticket->priority == 2)
                                        <span class="badge badge-danger">{{ $ticket->priority_text }}</span>
                                    @else
                                        <span class="badge badge-light">نامشخص</span>
                                    @endif
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($ticket->status === 0)
                                        <span class="badge badge-danger">{{ $ticket->status_text }}</span>
                                    @elseif($ticket->status === 1)
                                        <span class="badge badge-warning">{{ $ticket->status_text }}</span>
                                    @elseif($ticket->status === 2)
                                        <span class="badge badge-success">{{ $ticket->status_text }}</span>
                                    @else
                                        <span class="badge badge-light">نامشخص</span>
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('tickets.edit', $ticket->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$ticket->id}}"
                                            title="حذف تیکت کاربر"
                                            data-url="{{ route('tickets.destroy', $ticket->id) }}"
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
                            <td>کد تیکت</td>
                            <td>کاربر</td>
                            <td>عنوان</td>
                            <td>پیام</td>
                            <td>دسته بندی</td>
                            <td>اولویت</td>
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
                        '_token': '{{ csrf_token() }}',
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
                        '_token': '{{ csrf_token() }}',
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
                    title: "آیا از حذف تیکت مطمعنید؟",
                    text: "با حذف تیکت، قادر به بازگردانی آن نخواهید بود!",
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

            /*EDIT BY CLICK ON TITLE*/
            $('#datatable-tickets').DataTable({
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

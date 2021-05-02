@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('social-media-buttons.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست دکمه های صفحات مجازی</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-social-media-buttons">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>وضعیت</td>
                            <td>تصویر</td>
                            <td>متن جایگزین</td>
                            <td>لینک</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($social_media_buttons as $social_media_button)
                            <tr class="text-center" id="data-{{$social_media_button->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $social_media_button->id }}</td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($social_media_button->status === 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($social_media_button->status===0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>
                                {{--SHOW IMAGE--}}
                                <td class="align-middle text-center w-25">
                                    <span class="hide">{{ $social_media_button->title }}</span>
                                    <img src="{{ asset($social_media_button->image) }}"
                                         alt="{{ $social_media_button->title }}"
                                         class="img-fluid w-25"
                                    >
                                </td>

                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $social_media_button->title }}
                                </td>

                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    <a href="{{ $social_media_button->link }}">
                                        {{ $social_media_button->link }}
                                    </a>

                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">

                                    <input class="status big-checkbox mb-1 w-100 text-green"
                                           type="radio"
                                           @if($social_media_button->status ===1) checked @endif
                                           id="status-{{$social_media_button->id}}"
                                           title="تعیین بعنوان پیشفرض"
                                           data-url="{{ route('social-media-buttons.update', $social_media_button->id) }}"
                                           readonly
                                    >
                                    <a href="{{ route('social-media-buttons.edit', $social_media_button->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$social_media_button->id}}"
                                            title="حذف دکمه صفحه مجازی"
                                            data-url="{{route('social-media-buttons.destroy', $social_media_button->id)}}"
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
                            <td>تصویر</td>
                            <td>متن جایگزین</td>
                            <td>لینک</td>
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
                        '_token': '{{ csrf_token() }}',
                        '_method': 'PATCH',
                        'status': 'on',
                        'ajax': '1',
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
                    title: "آیا از حذف دکمه صفحه مجازی مطمعنید؟",
                    text: "با حذف دکمه صفحه مجازی، قادر به بازگردانی آن نخواهید بود!",
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
            $('#datatable-social-media-buttons').DataTable({
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

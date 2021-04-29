@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('social-medias.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست صفحات شبکه های اجتماعی</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-social-medias">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>آیکن</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>تصاویر</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($social_medias as $social_media)

                            <tr class="text-center" id="data-{{$social_media->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $social_media->id }}</td>
                                {{--SHOW ICON--}}
                                <td class="align-middle">
                                    <i class="fab fa-2x fa-{{ $social_media->icon }}"></i>
                                </td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $social_media->title }}
                                </td>
                                {{--SHOW LINK--}}
                                <td class="align-middle text-center">
                                    <a href="{{ $social_media->link }}">{{ $social_media->link }}</a>
                                </td>
                                {{--SHOW PICTURES--}}
                                <td class="align-middle">
                                    <img src="{{ asset($social_media->side_image) }}"
                                         alt="تصویر کوچک شبکه اجتماعی"
                                         class="img img-fluid rounded w-25 h-auto"
                                    >
                                    <hr>
                                    <img src="{{ asset($social_media->banner_image) }}"
                                         alt="تصویر بزرگ شبکه اجتماعی"
                                         class="img img-fluid rounded w-25 h-auto"
                                    >
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($social_media->status === 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                    @elseif($social_media->status===0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                    @else
                                        نامشخص
                                    @endif
                                </td>


                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('social-medias.edit', $social_media->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$social_media->id}}"
                                            title="حذف صفحه شبکه اجتماعی"
                                            data-url="{{route('social-medias.destroy', $social_media->id)}}"
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
                            <td>آیکن</td>
                            <td>عنوان</td>
                            <td>لینک</td>
                            <td>تصاویر</td>
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
                    title: "آیا از حذف صفحه شبکه اجتماعی مطمعنید؟",
                    text: "با حذف شبکه اجتماعی، قادر به بازگردانی آن نخواهید بود!",
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

            $('#datatable-social-medias').DataTable({
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

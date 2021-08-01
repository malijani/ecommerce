@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('header-pages.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست متای صفحات ایندکس</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-header-pages">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>صفحه</td>
                            <td>عنوان</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
                            <td>ثبت کننده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($header_pages as $header)

                            <tr class="text-center" id="data-{{$header->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $header->id }}</td>
                                {{--SHOW PAGE NAME--}}
                                <td class="align-middle">
                                    <a href="{{ route('header-pages.show', $header->id) }}">
                                        {{ $header->page }}
                                    </a>
                                </td>
                                {{--SHOW TITLE--}}
                                <td class="align-middle text-center">
                                    {{ $header->title }}
                                </td>
                                {{--SHOW keywords--}}
                                <td class="align-middle text-center">
                                    {{ $header->keywords }}
                                </td>
                                {{--SHOW DESCRIPTION--}}
                                <td class="align-middle text-center">
                                    {{ $header->description }}
                                </td>
                                {{--USER--}}
                                <td class="align-middle">{{ $header->user->full_name }}</td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('header-pages.edit', $header->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$header->id}}"
                                            title="حذف پرسش متداول"
                                            data-url="{{ route('header-pages.destroy', $header->id) }}"
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
                            <td>صفحه</td>
                            <td>عنوان</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
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


    <div class="col-12">
        <div class="card">
            <div class="card-body border border-info">
                <article>
                    <h4>ثابت های متا</h4>
                    <ul class="px-4">
                        <li>home</li>
                        <li>faq</li>
                        <li>pages</li>
                        <li>articles</li>
                        <li>products</li>
                        <li>categories</li>
                        <li>brands</li>
                        <li>cart</li>
                        <li>address</li>
                        <li>dashboard-index</li>
                        <li>dashboard-ticket-index</li>
                        <li>dashboard-ticket-create</li>
                        <li>dashboard-order-index</li>
                        <li>dashboard-address-index</li>
                        <li>dashboard-profile-index</li>

                    </ul>
                    <p>
                        و سایر صفحات افزوده شده حتماً ثبت شوند.
                    </p>

                </article>
            </div>
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
                    title: "آیا از حذف هدر صفحه مطمعنید؟",
                    text: "با حذف هدر صفحه، قادر به بازگردانی آن نخواهید بود!",
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
                                success: function (data) {
                                    swal({
                                        text: data.message,
                                        icon: 'success',
                                        button: "فهمیدم.",
                                    }).then(() => {
                                        location.reload();
                                    });


                                },
                                error: function (data) {
                                    swal({
                                        text: data.responseJSON.message,
                                        icon: 'error',
                                        button: "فهمیدم.",
                                    });
                                }
                            });
                        }
                    });
            });

            /*EDIT BY CLICK ON TITLE*/
            $('#datatable-header-pages').DataTable({
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

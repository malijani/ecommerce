@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('brands.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست برند ها</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-brands">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>تصویر</td>
                            <td>توضیحات</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
                            <td>وضعیت</td>
                            <td>آخرین بروز رسانی</td>
                            <td>ثبت کننده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($brands as $brand)
                            <tr class="text-center" id="data{{$brand->id}}">
                                <td class="align-middle">{{ $brand->id }}</td>
                                <td class="align-middle">{{ $brand->title }}<br>{{ $brand->title_en }}</td>
                                <td class="align-middle">
                                    <img src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                                         alt="{{ $brand->pic_alt ?? $brand->title_en }}"
                                         width="100vw"
                                         height="100vh"
                                    >
                                    <span class="hide">{{ $brand->sort }}</span>
                                </td>
                                <td class="align-middle">{!! $brand->text_limit !!}</td>
                                <td class="align-middle">{{ $brand->keywords }}</td>
                                <td class="align-middle">{{ $brand->description_limit }}</td>
                                <td class="align-middle">
                                    @if($brand->status==0)
                                        <span class="badge badge-danger p-2"><i class="fa fa-times"></i></span>
                                        <span class="hide">{{ $brand->status }}</span>
                                    @elseif($brand->status==1)
                                        <span class="badge badge-success p-2"><i class="fa fa-check"></i></span>
                                        <span class="hide">{{ $brand->status }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $brand->updated_at }}</td>
                                <td class="align-middle">{{ $brand->user->name }} {{ $brand->user->family }}</td>
                                <td class="align-middle">

                                    <button title="حذف"
                                            href="#"
                                            class="btn btn-outline-danger btn-sm m-1"
                                            id="del{{$brand->id}}"
                                            data-url="brands/{{$brand->id}}"
                                            onclick="del({{$brand->id}});"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <a title="ویرایش"
                                       href="{{ route('brands.edit',['brand'=>$brand->id]) }}"
                                       class="btn btn-outline-primary btn-sm m-1"
                                       role="button"
                                       id="ed{{$brand->id}}"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>تصویر</td>
                            <td>توضیحات</td>
                            <td>کلمات کلیدی</td>
                            <td>توضیحات کلمات کلیدی</td>
                            <td>وضعیت</td>
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
                title: "آیا از حذف برند مطمعنید؟",
                text: "با حذف برند، قادر به بازگردانی آن نخواهید بود!",
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
                                    text: "برند با موفقیت حذف شد :)",
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
                            text: "برند با موفقیت حذف شد :)",
                            icon: "success",
                            button: "حله!",
                        });
                    } else {
                        swal({
                            text: "برند حذف نشد!",
                            icon: 'info',
                            button: 'فهمیدم!',
                        });
                    }
                });
        }




        $(document).ready(function () {

            $('#datatable-brands').DataTable({
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

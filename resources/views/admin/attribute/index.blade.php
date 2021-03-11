@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('content')

    <div class="col-md-12">
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <form action="{{ route('attributes.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="title" class="col-form-label col-md-2 text-center">عنوان ویژگی جدید</label>
                        <div class="col-md-4">
                            <input type="text"
                                   maxlength="70"
                                   minlength="2"
                                   name="title"
                                   id="title"
                                   placeholder="وزن"
                                   autocomplete="off"
                                   value="{{old('title')}}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   required
                            >
                            @include('partials.form_error',['input'=>'title'])
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="form-control btn btn-primary">افزودن ویژگی</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست ویژگی ها</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-attributes">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>مشخصات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($attributes as $attribute)
                            <tr class="text-center" id="data{{$attribute->id}}">
                                <td class="align-middle">{{ $attribute->id }}</td>
                                <td class="align-middle text-center">
                                    <span class="hide">{{ $attribute->title }}</span>
                                    <form action="{{ route('attributes.update', ['attribute'=>$attribute->id])  }}" method="POST">
                                        @csrf
                                        {{method_field('PUT')}}
                                        <div class="form-group row">

                                            <label for="title-{{$loop->index}}" class="col-form-label col-2">عنوان : </label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                       maxlength="70"
                                                       minlength="2"
                                                       name="title"
                                                       id="title-{{$loop->index}}"
                                                       placeholder="وزن"
                                                       autocomplete="off"
                                                       value="{{$attribute->title}}"
                                                       class="form-control text-center"
                                                       required
                                                >
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="form-control btn btn-outline-warning">ویرایش</button>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                        class="form-control btn btn-outline-danger"
                                                        id="del{{$attribute->id}}"
                                                        data-url="attributes/{{$attribute->id}}"
                                                        onclick="del({{$attribute->id}});"
                                                >حذف</button>
                                            </div>
                                        </div>

                                    </form>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <td>مشخصات</td>
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
                title: "آیا از حذف ویژگی مطمعنید؟",
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
                                    text: "ویژگی با موفقیت حذف شد :)",
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
                            text: "ويزگی با موفقیت حذف شد :)",
                            icon: "success",
                            button: "حله!",
                        });
                    } else {
                        swal({
                            text: "ویژگی حذف نشد!",
                            icon: 'info',
                            button: 'فهمیدم!',
                        });
                    }
                });
        }


        $(document).ready(function () {


            /*EDIT BY CLICK ON TITLE*/



            $('#datatable-attributes').DataTable({
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

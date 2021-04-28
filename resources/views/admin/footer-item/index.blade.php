@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('content')

    <div class="col-md-12">
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <form action="{{ route('footer-items.store') }}" method="POST">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label for="title" class="col-form-label col-md-2 text-center">عنوان سر دسته</label>
                        <div class="col-md-2">
                            <input type="text"
                                   maxlength="70"
                                   minlength="2"
                                   name="title"
                                   id="title"
                                   placeholder="تاییدیه و مجوز ها"
                                   autocomplete="off"
                                   value="{{old('title')}}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   required
                            >
                            @include('partials.form_error',['input'=>'title'])
                        </div>

                        <label for="title_en" class="col-form-label col-md-2 text-center">عنوان انگلیسی</label>
                        <div class="col-md-2">
                            <input type="text"
                                   maxlength="70"
                                   minlength="2"
                                   name="title_en"
                                   id="title_en"
                                   placeholder="licenses"
                                   autocomplete="off"
                                   value="{{old('title_en')}}"
                                   class="form-control @error('title_en') is-invalid @enderror ltr"
                                   required
                            >
                            @include('partials.form_error',['input'=>'title_en'])
                        </div>


                        <div class="col-2">
                            <div class="form-check">

                                <input type="checkbox"
                                       class="form-check-input @error('status') is-invalid @enderror"
                                       id="status"
                                       name="status"
                                    {{ (old('status') ? 'checked' : '') }}
                                >
                                @include('partials.form_error',['input'=>'status'])
                                <label class="form-check-label" for="status">وضعیت</label>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="form-control btn btn-primary">افزودن آیتم</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست آیتم های فوتر</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-footer-items">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>مشخصات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($footer_items as $item)
                            <tr class="text-center" id="data{{$item->id}}">
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle text-center">
                                    <span class="hide">{{ $item->title }}</span>
                                    <form action="{{ route('footer-items.update', $item->id)  }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <input type="text"
                                                       maxlength="70"
                                                       minlength="2"
                                                       name="title"
                                                       id="title-{{$loop->index}}"
                                                       placeholder="تاییدیه و مجوز ها"
                                                       autocomplete="off"
                                                       value="{{$item->title}}"
                                                       class="form-control text-center"
                                                       required
                                                >
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text"
                                                       maxlength="70"
                                                       minlength="2"
                                                       name="title_en"
                                                       id="title-en-{{$loop->index}}"
                                                       placeholder="licenses"
                                                       autocomplete="off"
                                                       value="{{$item->title_en}}"
                                                       class="form-control text-center ltr"
                                                       required
                                                >
                                            </div>

                                            <div class="col-2">
                                                <div class="form-check">
                                                    <input type="checkbox"
                                                           class="big-checkbox form-control @error('status') is-invalid @enderror"
                                                           id="status-{{$loop->index}}"
                                                           name="status"
                                                        {{ ($item->status == 1 ? 'checked' : '') }}
                                                    >
                                                    @include('partials.form_error',['input'=>'status'])

                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="submit" class="form-control btn  btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button"
                                                        class="destroy-button form-control btn btn-outline-danger"
                                                        data-url="{{ route('footer-items.destroy', $item->id) }}"
                                                        data-id="{{ $item->id }}"
                                                >
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
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



        $(document).ready(function () {


            let destroy_button = $('.destroy-button');
            destroy_button.on('click', function(){
                let destroy_url = $(this).attr('data-url');
                let id = $(this).attr('data-id');
                swal({
                    title: "آیا از حذف سر دسته فوتر مطمعنید؟",
                    text: "با حذف سر دسته فوتر تمامی لینک های مرتبط با آن حذف می شوند!!",
                    icon: "warning",
                    buttons: ['نه! حذفش نکن.', 'آره، حذفش کن.'],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: destroy_url,
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    '_method': 'DELETE',
                                },
                                success: function (result) {
                                    $('#data' + id).remove();
                                    swal({
                                        title: result,
                                        text: " سردسته فوتر با موفقیت حذف شد :)",
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
                                text: "سردسته فوتر با موفقیت حذف شد :)",
                                icon: "success",
                                button: "حله!",
                            });
                        } else {
                            swal({
                                text: "سردسته فوتر حذف نشد!",
                                icon: 'info',
                                button: 'فهمیدم!',
                            });
                        }
                    });
            });


            $('#datatable-footer-items').DataTable({
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
                'pageLength': 50,
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

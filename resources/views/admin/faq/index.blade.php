@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('faqs.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    مشخصات صفحه پرسشهای متداول
                </h3>
            </div>

            <div class="card-body">
                @if(isset($faq_page))
                    <form action="{{ route('faq-page.update', $faq_page->id) }}" method="POST">
                        @csrf
                        @method("PATCH")
                        {{--TITLE: 100--}}
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">عنوان صفحه</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       maxlength="100"
                                       minlength="5"
                                       value="{{ old('title') ?? $faq_page->title }}"
                                       required
                                >
                            </div>
                        </div>

                        {{--KEYWORDS : 70--}}
                        <div class="form-group row">
                            <label for="keywords" class="col-sm-2 col-form-label">کلمات کلیدی</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('keywords') is-invalid @enderror"
                                       id="keywords"
                                       name="keywords"
                                       maxlength="70"
                                       minlength="5"
                                       value="{{ old('keywords') ?? $faq_page->keywords }}"
                                       required
                                >
                            </div>
                        </div>
                        {{--DESCRIPTION : 255--}}
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">توضیحات کلمات کلیدی</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       name="description"
                                       maxlength="255"
                                       minlength="5"
                                       value="{{ old('description') ?? $faq_page->description }}"
                                       required
                                >
                            </div>
                        </div>
                        {{--SUBMIT--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="form-control btn btn-outline-success">بروز رسانی</button>
                            </div>
                        </div>

                    </form>
                @else
                    <form action="{{ route('faq-page.store') }}" method="POST">
                        @csrf
                        {{--TITLE: 100--}}
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">عنوان صفحه</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       maxlength="100"
                                       minlength="5"
                                       value="{{ old('title') }}"
                                       required
                                >
                            </div>
                        </div>

                        {{--KEYWORDS : 70--}}
                        <div class="form-group row">
                            <label for="keywords" class="col-sm-2 col-form-label">کلمات کلیدی</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('keywords') is-invalid @enderror"
                                       id="keywords"
                                       name="keywords"
                                       maxlength="70"
                                       minlength="5"
                                       value="{{ old('keywords') }}"
                                       required
                                >
                            </div>
                        </div>
                        {{--DESCRIPTION : 255--}}
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">توضیحات کلمات کلیدی</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       name="description"
                                       maxlength="255"
                                       minlength="5"
                                       value="{{ old('description') }}"
                                       required
                                >
                            </div>
                        </div>
                        {{--SUBMIT--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="form-control btn btn-outline-success">ثبت</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست پرسشهای متداول</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover" id="datatable-faqs">
                        <thead>
                        <tr class="text-center">
                            <td>شماره</td>
                            <td>اولویت</td>
                            <td>پرسش</td>
                            <td>پاسخ</td>
                            <td>وضعیت</td>
                            <td>نحوه مشاهده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($faqs as $faq)

                            <tr class="text-center" id="data-{{$faq->id}}">
                                {{--SHOW ID--}}
                                <td class="align-middle">{{ $faq->id }}</td>
                                {{--SHOW SORT--}}
                                <td class="align-middle">{{ $faq->sort }}</td>
                                {{--SHOW QUESTION--}}
                                <td class="align-middle text-center">
                                    {{ $faq->question }}
                                </td>
                                {{--SHOW ANSWER--}}
                                <td class="align-middle text-center">
                                    {{ strip_tags($faq->answer_short) }}
                                </td>
                                {{--SHOW STATUS--}}
                                <td class="align-middle">
                                    @if($faq->status === 1)
                                        <i class="fa fa-2x fa-check-square-o text-success"></i>
                                        <span class="hide">{{ $faq->status }}</span>
                                    @elseif($faq->status===0)
                                        <i class="fa fa-2x fa-minus-square-o text-danger"></i>
                                        <span class="hide">{{ $faq->status }}</span>
                                    @else
                                        نامشخص
                                    @endif
                                </td>
                                {{--SHOW COLLAPSING--}}
                                <td class="align-middle text-center">
                                    @if($faq->collapse == 1 )
                                        <i class="fa fa-expand fa-2x"></i>
                                        <span class="hide">{{ $faq->collapse }}</span>
                                    @elseif($faq->collapse == 0)
                                        <i class="fa fa-compress fa-2x"></i>
                                        <span class="hide">{{ $faq->collapse }}</span>
                                    @else
                                        نامشخص
                                    @endif
                                </td>

                                {{--OPERATIONS--}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('faqs.edit', $faq->id) }}"
                                       class="btn btn-info"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="destroy-button btn btn-danger"
                                            id="del-{{$faq->id}}"
                                            title="حذف پرسش متداول"
                                            data-url="{{ route('faqs.destroy', $faq->id) }}"
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
                            <td>اولویت</td>
                            <td>پرسش</td>
                            <td>پاسخ</td>
                            <td>وضعیت</td>
                            <td>نحوه مشاهده</td>
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
                    title: "آیا از حذف پرسش متداول مطمعنید؟",
                    text: "با حذف پرسش متداول، قادر به بازگردانی آن نخواهید بود!",
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
            $('#datatable-faqs').DataTable({
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

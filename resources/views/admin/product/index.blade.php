@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection

@section('nav-buttons')
    <a href="{{ route('products.create') }}" role="button" class="btn btn-lg btn-outline-primary">
        <i class="fa fa-plus-square"></i>
    </a>
@endsection

@section('content')

    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">لیست محصولات</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">
                    <table class="table table-striped table-bordered table-hover" id="datatable-articles">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>موجودی</td>
                            <td>نوع</td>
                            <td>مدل تحویل</td>
                            <td>گارانتی</td>
                            <td>نوع قیمت</td>
                            <td>(تومان)قیمت</td>
                            <td>درصد تخفیف</td>
                            <td>بازدید</td>
                            <td>وضعیت</td>
                            <td>دسته بندی</td>
                            <td>برند</td>
                            <td>تصاویر</td>
                            <td>آخرین بروز رسانی</td>
                            <td>ثبت کننده</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($products as $product)
                            <tr class="text-center" id="data{{ $product->id }}">
                                <td class="align-middle">{{ $product->id }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        {{ $product->title }}<br>{{ $product->title_en }}
                                    </a>
                                </td>
                                <td class="align-middle">{{ $product->entity}}</td>
                                <td class="align-middle">{{ $product->origin_text }}</td>
                                <td class="align-middle">{{ $product->deliver_text }}</td>
                                <td class="align-middle">{{ $product->warranty_text }}</td>
                                <td class="align-middle">{{ $product->price_type_text }}</td>
                                <td class="align-middle">{{ $product->price }}</td>
                                <td class="align-middle">{{ $product->discount_percent }}</td>

                                <td class="align-middle">{{ $product->visit }}</td>
                                <td class="align-middle">
                                    @if($product->status==0)
                                        <span class="badge badge-danger p-2"><i class="fa fa-times"></i></span>
                                        <span class="hide">{{ $product->status }}</span>
                                    @elseif($product->status==1)
                                        <span class="badge badge-success p-2"><i class="fa fa-check"></i></span>
                                        <span class="hide">{{ $product->status }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $product->category->title }}</td>
                                <td class="align-middle">{{ $product->brand->title }}</td>

                                <td class="align-middle">
                                    {{--                                    <img src="{{ asset($product->pic ?? 'images/fallback/article.png') }}"--}}
                                    {{--                                         alt="{{ $product->pic_alt ?? $product->title_en }}"--}}
                                    {{--                                         width="100vw"--}}
                                    {{--                                         height="100vh"--}}
                                    {{--                                    >--}}


                                    @if($product->files->count())
                                        {{--CAROUSEL--}}
                                        <div id="carouselControls{{$product->id}}" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($product->files as $pic)
                                                    {{--                                            {{$pic->link . ' => ' .$pic->title}}<br>--}}
                                                    <div class="carousel-item @if($loop->first) active @endif">
                                                        <img class="d-block"
                                                             src="{{ asset($pic->link) }}"
                                                             alt="{{ $pic->title }}"
                                                             width="100vw"
                                                             height="100vh"
                                                        >
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselControls{{$product->id}}"
                                               role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">قبل</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselControls{{$product->id}}"
                                               role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">بعد</span>
                                            </a>
                                        </div>
                                        {{--./CAROUSEL--}}
                                    @else
                                        <img src="{{asset('images/fallback/product.png')}}" alt="محصول فاقد تصویر"
                                             class="img-0 img" width="100vw" height="100vh">
                                    @endif
                                    <span class="hide">{{ $product->sort }}</span>
                                </td>

{{--                                <td class="align-middle">{{ $product->short_text ?? $product->long_text_limited }}</td>--}}
                                <td class="align-middle">{{ $product->jalali_updated_at }}</td>
                                <td class="align-middle">{{ $product->user->name }} {{ $product->user->family }}</td>


                                <td class="align-middle">
                                    <a title="ویرایش"
                                       href="{{ route('products.edit',['product'=>$product->id]) }}"
                                       class="btn btn-outline-primary btn-sm m-1"
                                       role="button"
                                       id="ed{{$product->id}}"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button title="حذف"
                                            href="#"
                                            class="btn btn-outline-danger btn-sm m-1"
                                            id="del{{$product->id}}"
                                            data-url="products/{{$product->id}}"
                                            onclick="del({{$product->id}});"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>


                                    {{--                                    <a title="نظرات"--}}
                                    {{--                                       href="COMMENTS_ROUTE"--}}
                                    {{--                                       class="btn btn-outline-success btn-sm"--}}
                                    {{--                                       role="button"--}}
                                    {{--                                    >--}}
                                    {{--                                        <i class="fa fa-comment-o"></i>--}}
                                    {{--                                        <span class="text-danger">--}}
                                    {{--                                            {{ $product->comments != null ? $item->comments->where('status', 0)->count() : 0 }}--}}
                                    {{--                                        </span>--}}
                                    {{--                                    </a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <td>عنوان</td>
                            <td>موجودی</td>
                            <td>نوع</td>
                            <td>مدل تحویل</td>
                            <td>گارانتی</td>
                            <td>نوع قیمت</td>
                            <td>(تومان)قیمت</td>
                            <td>درصد تخفیف</td>
                            <td>بازدید</td>
                            <td>وضعیت</td>
                            <td>دسته بندی</td>
                            <td>برند</td>
                            <td>تصاویر</td>
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
                title: "آیا از حذف محصول مطمعنید؟",
                text: "با حذف محصول، قادر به بازگردانی آن نخواهید بود!",
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
                                    text: "محصول با موفقیت حذف شد :)",
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
                            text: "محصول با موفقیت حذف شد :)",
                            icon: "success",
                            button: "حله!",
                        });
                    } else {
                        swal({
                            text: "محصول حذف نشد!",
                            icon: 'info',
                            button: 'فهمیدم!',
                        });
                    }
                });
        }

        $(document).ready(function () {
            $("#datatable-articles").DataTable({
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

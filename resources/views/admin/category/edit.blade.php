@extends('layouts.app_admin')

@section('content')


    <div class="col-md-12">

        <div class="card card-primary">

            <div class="card-header">
                <div class="card-title">{{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left text-white">
                        برگشت
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('categories.update', ['category'=>$category->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="title">
                                <i class="fa fa-star text-danger"></i>
                                عنوان دسته بندی
                            </label>
                            <input name="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   minlength="3"
                                   maxlength="70"
                                   placeholder=" عنوان دسته بندی به فارسی : تست"
                                   title="مقدار دهی الزامی"
                                   value="{{ $category->title }}"
                                   required
                            >
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="title_en">
                                <i class="fa fa-star text-danger"></i>
                                عنوان دسته بندی (لینک) انگلیسی
                            </label>
                            <input
                                name="title_en"
                                type="text"
                                   class="form-control @error('title_en') is-invalid @enderror"
                                   id="title_en"
                                   placeholder="عنوان به انگلیسی : test"
                                   minlength="3"
                                   maxlength="70"
                                   title="مقدار دهی الزامی"
                                   value="{{ $category->title_en }}"
                                   required
                            >
                            @error('title_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="status">وضعیت دسته بندی</label>
                            <select
                                name="status"
                                id="status"
                                title="با انتخاب فعال، دسته بندی شما قابل استفاده و نمایش خواهد بود"
                                class="form-control @error('status') is-invalid @enderror"
                            >
                                <option {{ $category->status ==1 ? 'selected' : '' }} value="1"> فعال</option>
                                <option {{ $category->status ==0 ? 'selected' : '' }} value="0">غیر فعال</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="menu">نمایش در منو وبسایت</label>
                            <select
                                name="menu"
                                id="menu"
                                title="با انتخاب نمایش، دسته بندی شما در منو وبسایت قابل دسترس خواهد بود"
                                class="form-control @error('menu') is-invalid @enderror"
                            >
                                <option {{ $category->menu ==1 ? 'selected' : '' }} value="1"> نمایش</option>
                                <option {{ $category->menu ==0 ? 'selected' : '' }} value="0">عدم نمایش</option>
                            </select>
                            @error('menu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="parent_id">انتخاب گروه</label>
                        <select
                            name="parent_id"
                            id="parent_id"
                            class="form-control d-block"
                            title="با انتخاب گروه، دسته بندی ایجاد شده جزو زیر مجموعه های این دسته بندی خواهد شد."
                        >

                            <option value="0" selected>دسته بندی والد</option>
                            @foreach($categories as $parent_category)
                                <option value="{{ $parent_category->id }}"
                                    @if(!is_null($parent_id) && $parent_category->id == $parent_id)
                                        selected
                                    @endif
{{--                                    @if($parent_category->id == $category->id)--}}
{{--                                        disabled--}}
{{--                                    @endif--}}
                                >{{ '+>'.' '.$parent_category->title }}</option>
                                @if($parent_category->childrenRecursive->count())
                                    @include('admin.category.partials.edit_form_category_child', ['last_parent'=>$parent_category->id,'parent_id'=>$parent_id ?? null, 'category_id'=>$category->id,'this_children'=>$children, 'children'=>$parent_category->childrenRecursive, 'level'=>1])
                                @endif
                            @endforeach
                        </select>
                    </div>



                    @if(isset($category->pic))
                        <div class="form-row text-center rounded">
                            <div class="col-md-12">
                                <input type="hidden" name="delete_pic" id="delete_pic">
                                <img id="image-checkable"
                                     src="{{ asset($category->pic) }}"
                                     class="img-fluid align-middle"
                                     alt="{{ $category->pic_alt ?? $category->title_en }}"
                                     width="200vw"
                                     height="200vh"
                                     title="برای حذف تصویر کلیک کنید."
                                >
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="pic">
                                تصویر دسته بندی
                            </label>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input
                                        type="file"
                                        name="pic"
                                        class="custom-file-input form-control @error('pic') is-invalid @enderror"
                                    >
                                    <label class="custom-file-label" for="pic">
                                        انتخاب تصویر
                                    </label>
                                </div>
                            </div>
                            <small id="picHelp" class="form-text text-muted">لطفاً تصاویر با طول و عرض یکسان را وارد نمایید، با آپلود تصویر جدید تصویر قبلی به صورت خودکار حذف خواهد شد.</small>

                            @error('pic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="pic_alt">متن جانشین تصویر </label>
                            <input
                                name="pic_alt"
                                type="text"
                                class="form-control @error('pic_alt') is-invalid @enderror"
                                minlength="3"
                                maxlength="70"
                                placeholder="دسته بندی تست"
                                title="این متن در صورت لود نشدن تصویر نمایش داده خواهد شد"
                                value="{{ $category->pic_alt }}"
                            >
                            @error('pic_alt')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="color">
                                رنگ دسته بندی
                            </label>
                            <input
                                name="color"
                                type="color"
                                class="form-control @error('color') is-invalid @enderror"
                                minlength="3"
                                maxlength="10"
                                placeholder="#000000"
                                title=" تعیین رنگ بندی دسته بندی"
                                dir="ltr"
                                value="{{ $category->color }}"
                            >
                            @error('color')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keywords">
                            (سئو)کلمات کلیدی
                        </label>
                        <input
                            type="text"
                            name="keywords"
                            class="form-control @error('keywords') is-invalid @enderror"
                            minlength="3"
                            maxlength="70"
                            placeholder="تست، لیست نمونه، خرید نمونه"
                            title="برای سئو بهتر این موارد تعیین شوند"
                            value="{{ $category->keywords }}"
                        >
                        @error('keywords')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">
                            توضیحات کلمات کلیدی(سئو)
                        </label>
                        <input
                            name="description"
                            type="text"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="این نمونه تستی برای توضیحات سئو درج شده، چگونه دسته بندی تستی را از لحاظ سئو پر بار کنیم؟"
                            minlength="10"
                            maxlength="255"
                            title="توضیحات کلمات کلیدی را به صورت جمله های مرتبط پر جست و جو وارد کنید"
                            value="{{ $category->description }}"
                        >
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="text">
                                توضیحات دسته بندی
                            </label>
                            <textarea name="text"
                                      id="text"
                                      rows="10"
                                      class="form-control @error('text') is-invalid @enderror"
                                      placeholder="دسته بندی چیست؟..."
                                      dir="rtl"
                            >{{ $category->text }}</textarea>
                            @error('text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-outline-success">ثبت</button>

                </div>
            </form>
        </div>
    </div>
    <!-- /.card -->
@endsection

@section('page-scripts')

    <script type="text/javascript" src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/img-checkbox/jquery.imgcheckbox.js') }}"></script>
    <script type="text/javascript">

        $("#image-checkable").imgCheckbox({
            "styles": {
                "span.imgCheckbox.imgChked img": {
                    // It's important to note that overriding the "filter" property will remove grayscaling
                    "filter": "blur(5px)",

                    // This is just css: remember compatibility
                    "-webkit-filter": "blur(5px)",

                    // Let's change the amount of scaling from the default of "0.8"
                    "transform": "scale(0.9)"
                }

            },
            checkMarkSize:"100px",
            checkMarkPosition:'center',
            checkMarkImage:"{{ asset('images/asset/delete.png') }}",
            addToForm:false,
            onclick: function(el){
                var isChecked = el.hasClass("imgChked");
                var input = $("#delete_pic");
                    // imgEl = el.children()[0];  // the img element
                if(isChecked===true){
                    input.val('on');
                } else {
                    input.val('');
                }
                // console.log(isChecked);
                // console.log(imgEl.name + " is now " + (isChecked? "checked": "not-checked") + "!");
            }
        });

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });


        CKEDITOR.replace('text', {
            height: 400,
            baseFloatZIndex: 10005,
            contentsLangDirection: 'rtl',
            contentsLanguage:'fa',
            {{--exportPdf_tokenUrl: "{{ \Illuminate\Support\Str::random(15) }}",--}}
            font_names :  'Vazir;'+
                'Arial/Arial, Helvetica, sans-serif;' +
                'Comic Sans MS/Comic Sans MS, cursive;' +
                'Courier New/Courier New, Courier, monospace;' +
                'Georgia/Georgia, serif;' +
                'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
                'Tahoma/Tahoma, Geneva, sans-serif;' +
                'Times New Roman/Times New Roman, Times, serif;' +
                'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
                'Verdana/Verdana, Geneva, sans-serif',
            font_defaultLabel: 'Vazir',
            forcePasteAsPlainText: false,
            forceEnterMode : true,
            editorplaceholder: 'دسته بندی چیست؟...',
        });
    </script>
@endsection


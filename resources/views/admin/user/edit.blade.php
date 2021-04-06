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
            <form role="form"
                  action="{{ route('brands.update', ['brand'=>$brand->id]) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="title">
                                <i class="fa fa-star text-danger"></i>
                                عنوان برند
                            </label>
                            <input name="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   minlength="3"
                                   maxlength="70"
                                   placeholder=" عنوان برند به فارسی : سامسونگ"
                                   title="مقدار دهی الزامی"
                                   value="{{ $brand->title }}"
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
                                عنوان برند (لینک) انگلیسی
                            </label>
                            <input
                                name="title_en"
                                type="text"
                                   class="form-control @error('title_en') is-invalid @enderror"
                                   id="title_en"
                                   placeholder="عنوان به انگلیسی : samsung"
                                   minlength="3"
                                   maxlength="70"
                                   title="مقدار دهی الزامی"
                                   value="{{ $brand->title_en }}"
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
                        <div class="col-md-12">
                            <label for="status">وضعیت برند</label>
                            <select
                                name="status"
                                id="status"
                                title="با انتخاب فعال، برند قابل استفاده و نمایش خواهد بود"
                                class="form-control @error('status') is-invalid @enderror"
                            >
                                <option {{ $brand->status ==1 ? 'selected' : '' }} value="1"> فعال</option>
                                <option {{ $brand->status ==0 ? 'selected' : '' }} value="0">غیر فعال</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    @if(isset($brand->pic))
                        <div class="form-row text-center rounded">
                            <div class="col-md-12">
                                <input type="hidden" name="delete_pic" id="delete_pic">
                                <img id="image-checkable"
                                     src="{{ asset($brand->pic) }}"
                                     class="img-fluid align-middle"
                                     alt="{{ $brand->pic_alt ?? $brand->title_en }}"
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
                                تصویر برند
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
                                placeholder="تصویر برند"
                                title="این متن در صورت لود نشدن تصویر نمایش داده خواهد شد"
                                value="{{ $brand->pic_alt }}"
                            >
                            @error('pic_alt')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="color">
                                رنگ برند
                            </label>
                            <input
                                name="color"
                                type="text"
                                class="form-control @error('color') is-invalid @enderror"
                                minlength="3"
                                maxlength="10"
                                placeholder="#000000"
                                title=" تعیین رنگ بندی برند"
                                dir="ltr"
                                value="{{ $brand->color }}"
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
                            placeholder="سامسونگ، برند سامسونگ، محصولات سامسونگ"
                            title="برای سئو بهتر این موارد تعیین شوند"
                            value="{{ $brand->keywords }}"
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
                            placeholder="در مورد سامسونگ، اطلاعات شرکت سامسونگ، اجناس تولیدی شرکت سامسونگ"
                            minlength="10"
                            maxlength="255"
                            title="توضیحات کلمات کلیدی را به صورت جمله های مرتبط پر جست و جو وارد کنید"
                            value="{{ $brand->description }}"
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
                                      placeholder="توضیحات اجمالی در رابطه با برند..."
                                      dir="rtl"
                            >{{ $brand->text }}</textarea>
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
            editorplaceholder: 'توضیحات اجمالی در رابطه با برند...',
        });
    </script>
@endsection


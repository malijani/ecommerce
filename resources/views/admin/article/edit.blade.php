@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/select2/select2.min.css') }}">
@endsection

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
            <form role="form" action="{{ route('articles.update', ['article'=>$article->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        {{--                        TITLE--}}
                        <div class="col-md-6">
                            <label for="title">
                                عنوان مقاله
                                <i class="fa fa-asterisk text-danger"></i>
                            </label>
                            <input name="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   minlength="3"
                                   maxlength="70"
                                   placeholder=" عنوان مقاله به فارسی : مقاله "
                                   title="مقدار دهی الزامی"
                                   value="{{ $article->title }}"
                                   autocomplete="off"
                                   autofocus
                                   required
                            >
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{--                        TITLE_EN--}}
                        <div class="col-md-6">
                            <label for="title_en">
                                عنوان مقاله (لینک) انگلیسی
                                <i class="fa fa-asterisk text-danger"></i>
                            </label>
                            <input
                                name="title_en"
                                type="text"
                                class="form-control @error('title_en') is-invalid @enderror"
                                id="title_en"
                                placeholder="عنوان به انگلیسی : article"
                                minlength="3"
                                maxlength="70"
                                title="مقدار دهی الزامی"
                                value="{{ $article->title_en }}"
                                required
                                autocomplete="off"
                            >
                            @error('title_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                        @if(isset($article->pic))
                            <div class="form-group text-center rounded">
                                <div class="col-md-12">
                                    <input type="hidden" name="delete_pic" id="delete_pic">
                                    <img id="image-checkable"
                                         src="{{ asset($article->pic) }}"
                                         class="img-fluid align-middle"
                                         alt="{{ $article->pic_alt ?? $article->title_en }}"
                                         width="200vw"
                                         height="200vh"
                                         title="برای حذف تصویر کلیک کنید."
                                    >
                                </div>
                            </div>
                        @endif

                    {{--PIC--}}
                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="pic_alt" class="text-center">
                                عنوان تصویر شاخص
                                <i class="fa fa-asterisk text-danger"></i>
                            </label>

                            <input
                                type="text"
                                class="form-control @error('pic_alt') is-invalid @enderror "
                                name="pic_alt"
                                title="این متن در صورت لود نشدن تصویر نمایش داده خواهد شد، برای سئو هرچه بهتر وارد نمایید"
                                value="{{ $article->pic_alt }}"
                            >
                            <small id="picHelp" class="form-text text-muted"> با آپلود تصویر جدید تصویر قبلی به صورت خودکار حذف خواهد شد.</small>
                            @error('pic_alt')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">

                            <label for="pic" class="text-center">
                                تصویر شاخص
                                <i class="fa fa-asterisk text-danger"></i>
                            </label>

                            <input
                                type="file"
                                name="pic"
                                class="form-control @error('pic') is-invalid @enderror"
                            >
                            @error('pic')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="parent_id">انتخاب دسته بندی</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="select2 form-control d-block"
                                title="با انتخاب دسته بندی، مقاله شما از طریق دسته بندی منتخب قابل دسترسی خواهد بود."
                            >
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            @if($category->id == $article->category_id)
                                                selected
                                            @endif
                                    >{{ '+>'.' '.$category->title }}</option>
                                    @if($category->childrenRecursive->count())
                                        @include('admin.article.partials.edit_form_category_child', ['category_id'=>$article->category_id, 'children'=>$category->childrenRecursive, 'level'=>1])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status">وضعیت مقاله</label>
                            <select
                                name="status"
                                id="status"
                                title="با انتخاب نمایش، مقاله شما قابل استفاده و نمایش خواهد بود"
                                class="form-control @error('status') is-invalid @enderror"
                            >
                                <option {{ $article->status ==1 ? 'selected' : '' }} value="1">نمایش</option>
                                <option {{ $article->status ==0 ? 'selected' : '' }} value="0">عدم نمایش</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="period">
                                زمان مطالعه
                            </label>
                            <input
                                name="period"
                                type="text"
                                class="form-control @error('period') is-invalid @enderror"
                                id="period"
                                placeholder="زمان تخمینی مطالعه مقاله به دقیقه : 5"
                                value="{{ $article->period }}"
                            >
                            @error('period')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="before">مقاله قبلی</label>
                            <select
                                name="before"
                                id="before"
                                title="با انتخاب مقاله قبلی مسیر روشنی برای کاربر و سئو تعیین کنید."
                                class="select2 form-control @error('before') is-invalid @enderror"
                            >
                                <option {{ $article->before==0 ? 'selected' : '' }} value="0">بدون مقاله قبلی</option>
                                @foreach($articles as $article_item)
                                    <option value="{{ $article_item->id }}"
                                            @if($article->before == $article_item->id)
                                                selected
                                            @endif
                                    >{{ $article_item->title }}</option>
                                @endforeach
                            </select>
                            @error('before')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="after">مقاله بعدی</label>
                            <select
                                name="after"
                                id="after"
                                title="با انتخاب مقاله بعدی مسیر روشنی برای کاربر و سئو تعیین کنید."
                                class="select2 form-control @error('before') is-invalid @enderror"
                            >
                                <option {{ $article->after==0 ? 'selected' : '' }} value="0">بدون مقاله بعدی</option>
                                @foreach($articles as $article_item)
                                    <option value="{{ $article_item->id }}"
                                            @if($article->after==$article_item->id)
                                            selected
                                        @endif
                                    >{{ $article_item->title }}</option>
                                @endforeach
                            </select>
                            @error('after')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-12 mt-3">
                            <label for="keywords">
                                (سئو)کلمات کلیدی
                            </label>
                            <input
                                type="text"
                                name="keywords"
                                class="form-control @error('keywords') is-invalid @enderror"
                                minlength="3"
                                maxlength="70"
                                placeholder="مقاله، عنوان مقاله، دلیل ایجاد"
                                title="برای سئو بهتر این موارد تعیین شوند"
                                value="{{ $article->keywords }}"
                            >
                            @error('keywords')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3 mb-3">
                            <label for="description">
                                توضیحات کلمات کلیدی(سئو)
                            </label>
                            <input
                                name="description"
                                type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="این نمونه تستی برای توضیحات سئو درج شده، چگونه مقاله تستی را از لحاظ سئو پر بار کنیم؟"
                                minlength="10"
                                maxlength="255"
                                title="توضیحات کلمات کلیدی را به صورت جمله های مرتبط پر جست و جو وارد کنید"
                                value="{{ $article->description }}"
                            >
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="short_text">
                            متن کوتاه مقاله
                        </label>
                        <input
                            type="text"
                            name="short_text"
                            class="form-control @error('short_text') is-invalid @enderror"
                            minlength="3"
                            maxlength="250"
                            placeholder="لورم ایپسوم ..."
                            title="برای نمایی از متن کوتاه مقاله این مورد را تعیین نمایید"
                            value="{{ $article->short_text }}"
                        >
                        @error('short_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="long_text">
                                متن مقاله
                                <i class="fa fa-asterisk text-danger"></i>
                            </label>
                            <textarea name="long_text"
                                      id="long_text"
                                      rows="10"
                                      class="form-control @error('long_text') is-invalid @enderror"
                                      placeholder="متن مقاله...."
                                      dir="rtl"
                                      title="مقدار دهی الزامی"
                            >{{ $article->long_text }}</textarea>
                            @error('long_text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                </div>
                <button type="submit" class="btn btn-block btn-outline-success">ویرایش</button>
            </form>
        </div>
    </div>
    <!-- /.card -->
@endsection

@section('page-scripts')

    <script type="text/javascript" src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/img-checkbox/jquery.imgcheckbox.js') }}"></script>
    <script type="text/javascript">
        // function add_row() {
        //     $('.row-file').append(
        //         '<div class="col-md-6 form-row">' +
        //         '<label for="file[title]" class="col-md-3 col-form-label text-center">عنوان</label>' +
        //         '<div class="col-md-9">' +
        //         '<input name="file[title][]" type="text" class="form-control" ' +
        //         '</div>' +
        //         '</div>'+
        //         '</div>' +
        //         '<div class="col-md-6 form-row">' +
        //         '<label for="file[file]" class="col-md-3 col-form-label text-center">فایل تصویر</label>' +
        //         '<div class="col-md-9">' +
        //         '<input type="file" id="files" class="form-control" name="file[file][]" />' +
        //         '</div>' +
        //         '</div>'
        //     );
        // }
        //
        // function del_row() {
        //     $('.row-file .form-row:last').remove();
        //     $('.row-file .form-row:last').remove();
        // }


        CKEDITOR.replace('long_text', {
            height: 400,
            baseFloatZIndex: 10005,
            contentsLangDirection: 'rtl',
            direction: 'rtl',
            contentsLanguage: 'fa',
            content: 'fa',
            language: 'fa',
            exportPdf_tokenUrl: "{{ \Illuminate\Support\Str::random(15) }}",


            filebrowserImageBrowseUrl: '{{route('unisharp.lfm.show')}}',
            filebrowserImageUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Images', '_token'=>''])}}',
            filebrowserBrowseUrl: '{{route('unisharp.lfm.show', ['type'=>'Files'])}}',
            filebrowserUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Files', '_token'=>''])}}',


            font_names: 'Vazir;' +
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
            forceEnterMode: true,
            editorplaceholder: 'متن مقاله...',
        });


        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).ready(function () {
            $('.select2').select2({
                dir: "rtl",
            });



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
        });
    </script>
@endsection


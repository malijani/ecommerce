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
            <form role="form" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                   value="{{ old('title') }}"
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
                                value="{{ old('title_en') }}"
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
                                value="{{ old('pic_alt') }}"
                            >
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
                                    <option value="{{ $category->id }}">{{ '+>'.' '.$category->title }}</option>
                                    @if($category->childrenRecursive->count())
                                        @include('admin.article.partials.create_form_category_child', ['children'=>$category->childrenRecursive, 'level'=>1])
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
                                <option {{ old('status') ==1 ? 'selected' : '' }} value="1">نمایش</option>
                                <option {{ old('status') ==0 ? 'selected' : '' }} value="0">عدم نمایش</option>
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
                                value="{{ old('period', 5) }}"
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
                                <option {{ old('before')==0 ? 'selected' : '' }} value="0">بدون مقاله قبلی</option>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}"
                                            @if(old('before')==$article->id)
                                            selected
                                        @endif
                                    >{{ $article->title }}</option>
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
                                <option {{ old('after')==0 ? 'selected' : '' }} value="0">بدون مقاله بعدی</option>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}"
                                            @if(old('after')==$article->id)
                                            selected
                                        @endif
                                    >{{ $article->title }}</option>
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
                                value="{{ old('keywords') }}"
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
                                value="{{ old('description') }}"
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
                            value="{{ old('short_text') }}"
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
                            >{!! old('long_text') !!}</textarea>
                            @error('long_text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                </div>
                <button type="submit" class="btn btn-block btn-outline-success">ثبت</button>
            </form>
        </div>
    </div>
    <!-- /.card -->
@endsection

@section('page-scripts')

    <script type="text/javascript" src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminrc/plugins/select2/select2.min.js') }}"></script>
    @include('admin.partials.ckeditor')
    <script type="text/javascript">
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).ready(function () {
            $('.select2').select2({
                dir: "rtl",
            });
        });
    </script>
@endsection


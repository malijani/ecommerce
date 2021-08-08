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
            <div class="card-body">
                <!-- form start -->
                <form class="form" action="{{ route('pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">{{--TITLE--}}
                            <div class="form-group row">
                                <label for="title"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان صفحه
                                </label>
                                <div class="col-md-10">
                                    <input id="title"
                                           name="title"
                                           type="text"
                                           maxlength="100"
                                           minlength="5"
                                           class="form-control @error('question') is-invalid @enderror"
                                           placeholder="عنوان صفحه : قوانین و مقررات وبسایت"
                                           value="{{ old('title') ?? $page->title }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'title'])
                                </div>
                            </div>
                        </div>{{--./TITLE--}}

                        <div class="col-md-6">{{--TITLE_EN--}}
                            <div class="form-group row">
                                <label for="title_en"
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان انگلیسی صفحه
                                </label>
                                <div class="col-md-9">
                                    <input id="title_en"
                                           name="title_en"
                                           type="text"
                                           maxlength="70"
                                           minlength="5"
                                           class="form-control @error('title_en') is-invalid @enderror"
                                           placeholder="عنوان انگلیسی صفحه برای ساخت لینک : web page title"
                                           value="{{ old('title_en') ?? $page->title_en }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'title_en'])
                                </div>
                            </div>
                        </div>{{--./TITLE_EN--}}

                        <div class="col-md-12">{{--KEYWORDS--}}
                            <div class="form-group row">
                                <label for="keywords"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    کلمات کلیدی
                                </label>
                                <div class="col-md-10">
                                    <input id="keywords"
                                           name="keywords"
                                           type="text"
                                           maxlength="70"
                                           minlength="5"
                                           class="form-control @error('keywords') is-invalid @enderror"
                                           placeholder="کلمات کلیدی برای سئو صفحه"
                                           value="{{ old('keywords') ?? $page->keywords }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'keywords'])
                                </div>
                            </div>
                        </div>{{--./KEYWORDS--}}


                        <div class="col-md-12">{{--DESCRIPTION--}}
                            <div class="form-group row">
                                <label for="description"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    توضیحات کلمات کلیدی
                                </label>
                                <div class="col-md-10">
                                    <input id="description"
                                           name="description"
                                           type="text"
                                           maxlength="255"
                                           minlength="5"
                                           class="form-control @error('description') is-invalid @enderror"
                                           placeholder="توضیحات جمله ای کلمات کلیدی برای سئو صفحه"
                                           value="{{ old('description') ?? $page->description }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'description'])
                                </div>
                            </div>
                        </div>{{--./DESCRIPTION--}}


                        <div class="col-md-12">{{--CONTENT--}}
                            <div class="form-group row">
                                <label for="content"
                                       class="col-form-label col-md-12 text-center text-md-right">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    محتوا
                                </label>
                                <div class="col-md-12">
                                    <textarea id="content"
                                              name="content"
                                              class="form-control @error('content') is-invalid @enderror"
                                              placeholder="محتوای صفحه"
                                              required
                                              rows="50"
                                    >{!! old('content') ?? $page->content !!}</textarea>
                                    @include('partials.form_error', ['input'=>'content'])
                                </div>
                            </div>
                        </div>{{--./CONTENT--}}


                        <div class="col-md-4">{{--STATUS--}}
                            <div class="form-group row">
                                <label for="status" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    وضعیت
                                </label>
                                <div class="col-md-8">
                                    <select name="status"
                                            id="status"
                                            class="form-control @error('status') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        <option value="0" @if(old('status') == 0 || $page->status == 0) selected @endif>عدم نمایش</option>
                                        <option value="1" @if(old('status') == 1 || $page->status == 1) selected @endif>نمایش</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'status'])
                                </div>
                            </div>
                        </div>{{--STATUS--}}


                        <div class="col-md-4">
                            <div class="form-group row">{{--MENU--}}
                                <label for="menu" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    نمایش در منو
                                </label>
                                <div class="col-md-8">
                                    <select name="menu"
                                            id="menu"
                                            class="form-control @error('menu') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        <option value="0" @if(old('menu') == 0 || $page->menu == 0) selected @endif>عدم نمایش</option>
                                        <option value="1" @if(old('menu')==1 || $page->menu == 1) selected @endif>نمایش</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'menu'])
                                </div>
                            </div>{{--./MENU--}}
                            <div class="form-group row">{{--MENU TITLE--}}
                                <label for="menu_title" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    عنوان منو
                                </label>
                                <div class="col-md-8">
                                    <input id="menu_title"
                                           name="menu_title"
                                           type="text"
                                           maxlength="20"
                                           minlength="4"
                                           class="form-control @error('menu_title') is-invalid @enderror"
                                           placeholder="عنوانی که در منو قابل نمایش خواهد بود : تماس با ما"
                                           value="{{ old('menu_title')?? $page->menu_title }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'menu_title'])
                                </div>
                            </div>{{--./MENU_TITLE--}}
                        </div>


                        <div class="col-md-4">{{--SORT--}}
                            <div class="form-group row">
                                <label for="sort" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    اولویت
                                </label>
                                <div class="col-md-8">
                                    <input name="sort"
                                           id="sort"
                                           type="number"
                                           min="0"
                                           max="255"
                                           class="form-control @error('sort') is-invalid @enderror"
                                           required
                                           placeholder="ترتیب نمایش به کاربر : 1-255"
                                           value="{{ old('sort')  ?? $page->sort }}"
                                    >
                                    @include('partials.form_error', ['input'=>'sort'])
                                </div>
                            </div>
                        </div>{{--./SORT--}}


                        <div class="col-12">{{--SUBMIT BUTTON--}}
                            <div class="form-group row my-5 text-center">
                                <button type="submit" class="btn btn-outline-primary form-control">
                                    ذخیره
                                </button>
                            </div>
                        </div>{{--./SUBMIT BUTTON--}}
                    </div>


                </form>

            </div>{{--./MAIN FIELDS ROW--}}
            {{--./FORM END--}}
        </div>
    </div>

    <!-- /.card -->
@endsection


@section('page-scripts')
    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    @include('admin.partials.ckeditor', ['input_id'=>'content'])

@endsection

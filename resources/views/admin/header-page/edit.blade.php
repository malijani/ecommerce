@extends('layouts.app_admin')

@section('content')

    <div class="col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    {{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left">
                        برگشت
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">

                <form action="{{ route('header-pages.update', $header_page->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    {{--PAGE : 50--}}
                    <div class="form-group row">
                        <label for="page" class="col-sm-2 col-form-label">
                            عنوان انگلیسی صفحه
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control ltr text-right @error('page') is-invalid @enderror"
                                   id="page"
                                   name="page"
                                   maxlength="50"
                                   minlength="2"
                                   placeholder="test-page (عنوان انگلیسی صفحه ساز در نظر گرفته شود)"
                                   value="{{ old('page') ?? $header_page->page }}"
                                   required
                            >
                        </div>
                    </div>

                    {{--TITLE: 100--}}
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">
                            عنوان صفحه
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   maxlength="100"
                                   minlength="5"
                                   placeholder="پست های {{ config('app.brand.name') }}"
                                   value="{{ old('title') ?? $header_page->title }}"
                                   required
                            >
                        </div>
                    </div>

                    {{--KEYWORDS : 70--}}
                    <div class="form-group row">
                        <label for="keywords" class="col-sm-2 col-form-label">
                            کلمات کلیدی
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control @error('keywords') is-invalid @enderror"
                                   id="keywords"
                                   name="keywords"
                                   maxlength="70"
                                   minlength="5"
                                   placeholder="کلمات کلیدی سئو"
                                   value="{{ old('keywords') ?? $header_page->keywords }}"
                                   required
                            >
                        </div>
                    </div>
                    {{--DESCRIPTION : 255--}}
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">
                            توضیحات کلمات کلیدی
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control @error('description') is-invalid @enderror"
                                   id="description"
                                   name="description"
                                   maxlength="255"
                                   minlength="5"
                                   placeholder="توضیحات کلمات کلیدی سئو"
                                   value="{{ old('description') ?? $header_page->description }}"
                                   required
                            >
                        </div>
                    </div>

                    {{--AUTHOR : DISABLED--}}
                    <div class="form-group row">
                        <label for="author" class="col-sm-2 col-form-label">
                            نویسنده
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control"
                                   id="author"
                                   name="author"
                                   value="{{ $header_page->user->full_name }}"
                                   disabled
                            >
                        </div>
                    </div>

                    {{--SUBMIT--}}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="form-control btn btn-outline-success">
                                ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets.create') }}
@endsection
@section('dashboard-content')
    <h4>ثبت تیکت جدید</h4>

    <div class="row bg-whitesmoke">
        <div class="col-12">
            <form action="{{ route('dashboard.tickets.store') }}" method="POST" enctype="multipart/form-data">

                <div class="row">
                    {{--CATEGORIES--}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="category_id" class="col-form-label col-2 text-center">
                                <i class="fa fa-asterisk text-danger"></i>
                                دسته بندی تیکت
                            </label>
                            <div class="col-md-10">
                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="select2 form-control @error('category_id') is-invalid @enderror"
                                    required
                                >
                                    @if(is_null(old('category_id')))
                                        <option value="" selected>لطفاً دسته بندی تیکت را انتخاب کنید.</option>
                                    @endif

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if(old('category_id') === $category->id) selected @endif
                                        >
                                            {{ $category->title }}
                                        </option>
                                    @endforeach

                                </select>
                                @include('partials.form_error', ['input'=>'category_id'])
                            </div>
                        </div>
                    </div>
                    {{--./CATEGORIES--}}

                    {{--TITLE--}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="title"
                                   class="col-form-label col-md-2 text-center">
                                <i class="fa fa-asterisk text-danger"></i>
                                عنوان تیکت
                            </label>
                            <div class="col-md-10">
                                <input id="title"
                                       name="title"
                                       type="text"
                                       maxlength="100"
                                       minlength="5"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="توضیح کوتاه از مشکل یا پیام شما"
                                       value="{{ old('title') }}"
                                       required
                                >
                                @include('partials.form_error', ['input'=>'title'])
                            </div>
                        </div>
                    </div>
                    {{--./TITLE--}}

                    {{--MESSAGE--}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="message"
                                   class="col-form-label col-md-2 text-center">
                                <i class="fa fa-asterisk text-danger"></i>
                                پیام
                            </label>
                            {{--TODO : COMPLETE IT--}}
                            <div class="col-md-10">
                                    <textarea id="message"
                                              name="message"
                                              class="form-control @error('message') is-invalid @enderror"
                                              placeholder="با تشکر از انتخاب ما، بسته شما به سمت مقصد ارسال شد با کد رهگیری : ..."
                                              required
                                              rows="20"
                                    >{{ old('message') }}</textarea>
                                @include('partials.form_error', ['input'=>'message'])
                            </div>
                        </div>
                    </div>
                    {{--./MESSAGE--}}

                    {{--FILE--}}
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="pic"
                                   class="col-form-label col-md-2 text-center">
                                فایل
                            </label>
                            <div class="col-md-10">
                                <input id="file"
                                       name="file"
                                       type="file"
                                       class="form-control @error('file') is-invalid @enderror"
                                       accept="video/*,audio/*,image/*,application/*,text/*"
                                >
                                @include('partials.form_error', ['input'=>'file'])
                            </div>
                        </div>
                    </div>
                    {{--./FILE--}}


                    {{--PRIORITY--}}
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="priority" class="col-form-label col-md-6 text-center">
                                <i class=" fa fa-asterisk text-danger"></i>
                                اولویت
                            </label>
                            <div class="col-md-6">
                                <select name="priority"
                                        id="priority"
                                        class="form-control @error('priority') is-invalid @enderror"
                                        required
                                >
                                    @if(is_null(old('priority')))
                                        <option value="" selected>انتخاب کنید...</option>
                                    @endif
                                    <option value="0" @if(old('priority')==='0') selected @endif>پایین</option>
                                    <option value="1" @if(old('priority')==='1') selected @endif>متوسط</option>
                                    <option value="2" @if(old('priority')==='2') selected @endif>مهم</option>
                                </select>
                                @include('partials.form_error', ['input'=>'priority'])
                            </div>
                        </div>
                    </div>
                    {{--./PRIORITY--}}

                    {{--STATUS--}}
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="status" class="col-form-label col-md-6 text-center">
                                <i class=" fa fa-asterisk text-danger"></i>
                                وضعیت
                            </label>
                            <div class="col-md-6">
                                <select name="status"
                                        id="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        required
                                >
                                    @if(is_null(old('status')))
                                        <option value="" selected>انتخاب کنید...</option>
                                    @endif
                                    <option value="0" @if(old('status')==='0') selected @endif>باز</option>
                                    <option value="1" @if(old('status')==='1') selected @endif>پاسخ داده شده</option>
                                    <option value="2" @if(old('status')==='2') selected @endif>بسته شده</option>
                                </select>
                                @include('partials.form_error', ['input'=>'status'])
                            </div>
                        </div>
                    </div>
                    {{--./STATUS--}}


                    {{--SUBMIT BUTTON--}}
                    <div class="col-12">
                        <div class="form-group row my-5 text-center">
                            <button type="submit" class="btn btn-outline-primary form-control">
                                ثبت تیکت برای کاربر مورد نظر
                            </button>
                        </div>
                    </div>
                    {{--./SUBMIT BUTTON--}}
                </div>


            </form>
        </div>
    </div>
@endsection

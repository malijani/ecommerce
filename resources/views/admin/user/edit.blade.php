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
            <form role="form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="card-body">
                    <div class="row">
                        {{--NAME--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-2 col-form-label text-center">
                                    نام
                                </label>
                                <div class="col-md-8">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') ?? $user->name }}"
                                           required
                                           autocomplete="name"
                                           autofocus
                                           placeholder="نام کاربر"
                                    >
                                    @include('partials.form_error', ['input'=>'name'])
                                </div>
                            </div>
                        </div>
                        {{--FAMILY--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="family"
                                       class="col-md-2 col-form-label text-center">
                                    نام خانوادگی
                                </label>

                                <div class="col-md-8">
                                    <input id="family" type="text"
                                           class="form-control @error('family') is-invalid @enderror"
                                           name="family"
                                           value="{{ old('family') ?? $user->family }}"
                                           required
                                           autocomplete="family"
                                           placeholder="نام خانوادگی کاربر"

                                    >
                                    @include('partials.form_error', ['input'=>'family'])
                                </div>
                            </div>
                        </div>
                        {{--MOBILE--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="mobile"
                                       class="col-md-2 col-form-label text-center"
                                >
                                    تلفن همراه
                                </label>

                                <div class="col-md-8">
                                    <input id="mobile"
                                           type="text"
                                           class="ltr form-control @error('mobile') is-invalid @enderror"
                                           name="mobile"
                                           value="{{ old('mobile') ?? $user->mobile }}"
                                           minlength="11"
                                           maxlength="11"
                                           required
                                           autocomplete="mobile"
                                           placeholder="09103234432"
                                    >

                                    @include('partials.form_error', ['input'=>'mobile'])
                                </div>
                            </div>
                        </div>
                        {{--EMAIL--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-2 col-form-label text-center"
                                >
                                    آدرس ایمیل
                                </label>

                                <div class="col-md-8">
                                    <input id="email"
                                           type="email"
                                           class="ltr form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') ?? $user->email }}"
                                           required
                                           autocomplete="email"
                                           placeholder="user@info.com"
                                    >

                                    @include('partials.form_error', ['input'=>'email'])
                                </div>
                            </div>
                        </div>
                        {{--PASSWORD--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-2 col-form-label text-center"
                                >
                                    رمز عبور
                                </label>

                                <div class="col-md-8">
                                    <input id="password"
                                           type="password"
                                           class="ltr form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           placeholder="************"
                                           value="{{ $user->password }}"
                                    >

                                    @include('partials.form_error', ['input'=>'password'])
                                </div>
                            </div>
                        </div>
                        {{--CONFIRM PASSWORD--}}
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-2 col-form-label text-center"
                                >
                                    تایید رمز عبور
                                </label>

                                <div class="col-md-8">
                                    <input id="password-confirm"
                                           type="password"
                                           class="ltr form-control"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           placeholder="*********"
                                           value="{{ $user->password }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row px-4 py-4">
                                {{--LEVEL--}}
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="level"
                                               class="col-md-4 col-form-label text-center"
                                        >
                                            سطح دسترسی
                                        </label>
                                        <div class="col-md-8">
                                            <select name="level"
                                                    class="form-control"
                                                    id="level"
                                            >
                                                <option value="0" @if(old('level') ?? $user->level == 0) selected @endif>کاربر عادی
                                                </option>
                                                <option value="121" @if(old('level') ?? $user->level == 121) selected @endif>ادمین
                                                </option>
                                            </select>

                                            @include('partials.form_error', ['input'=>'level'])
                                        </div>
                                    </div>
                                </div>
                                {{--STATUS--}}
                                <div class="col-4">
                                    <div class="form-group row justify-content-center">
                                        <label for="status"
                                               class="col-md-4 col-form-label text-center"
                                        >
                                            وضعیت
                                        </label>
                                        <div class="col-md-8">
                                            <select name="status"
                                                    class="form-control"
                                                    id="status"
                                            >
                                                <option value="0" @if(old('status') ?? $user->status == 0) selected @endif> غیر فعال
                                                </option>
                                                <option value="1" @if(old('status') ?? $user->status == 1) selected @endif>فعال</option>
                                            </select>

                                            @include('partials.form_error', ['input'=>'email'])
                                        </div>
                                    </div>
                                </div>
                                {{--CONFIRM--}}
                                <div class="col-4">
                                    <div class="form-group row justify-content-center">
                                        <label for="verified"
                                               class="col-md-4 col-form-label text-center"
                                        >
                                            تایید اطلاعات تماس
                                        </label>
                                        <div class="col-md-8">
                                            <select name="verified"
                                                    class="form-control"
                                                    id="verified"
                                            >
                                                <option value="0" @if(old('verified') == 0 || is_null($user->email_verified_at)) selected @endif>عدم تایید
                                                </option>
                                                <option value="1" @if(old('verified') == 1 || isset($user->email_verified_at)) selected @endif>تایید
                                                </option>
                                            </select>

                                            @include('partials.form_error', ['input'=>'verified'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row my-4">
                    <div class="col-12 px-3">
                        <button type="submit" class="btn btn-block btn-outline-success">ثبت</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>

@endsection

@section('page-scripts')

    <script type="text/javascript" src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('text', {
            height: 400,
            baseFloatZIndex: 10005,
            contentsLangDirection: 'rtl',
            contentsLanguage: 'fa',
            exportPdf_tokenUrl: "{{ \Illuminate\Support\Str::random(15) }}",
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
            editorplaceholder: 'شرکت کره ای سامسونگ از قدیمی ترین شرکت های عرصه تکنولوژی است...',
        });


        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection


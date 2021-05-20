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
            <form role="form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row">
                        {{--PIC--}}
                        <div class="col-md-12">
                            <div class="form-group row justify-content-center">
                                <label for="pic"
                                       class="profile-pic col-form-label col-md-12 position-relative text-center">
                                    <img src="{{ asset('images/fallback/user.png') }}"
                                         alt="تصویر پروفایل"
                                         class="img img-fluid rounded"
                                         id="preview"
                                    >


                                </label>
                            </div>
                            <div class="col-md-8">
                                <input id="pic"
                                       type="file"
                                       name="pic"
                                       accept=".jpg,.jpeg,.png"
                                       onchange="showImage(this);"
                                       hidden
                                >
                                @include('partials.form_error', ['input'=>'pic'])
                            </div>
                        </div>


                        {{--NAME--}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-2 col-form-label text-center">
                                    نام
                                </label>
                                <div class="col-md-8">
                                    <input id="name"
                                           type="text"
                                           class="form-control text-center @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name') }}"
                                           autocomplete="name"
                                           placeholder="نام کاربر"
                                    >
                                    @include('partials.form_error', ['input'=>'name'])
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

                                <div class="col-md-10">
                                    <input id="mobile"
                                           type="text"
                                           class="ltr form-control  text-center @error('mobile') is-invalid @enderror"
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           minlength="11"
                                           maxlength="11"
                                           required
                                           autofocus
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

                                <div class="col-md-10">
                                    <input id="email"
                                           type="email"
                                           class="ltr form-control text-center @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           autocomplete="email"
                                           placeholder="user@info.com"
                                    >

                                    @include('partials.form_error', ['input'=>'email'])
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                {{--LEVEL--}}
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="level"
                                               class="col-md-2 col-form-label text-center"
                                        >
                                            سطح دسترسی
                                        </label>
                                        <div class="col-md-10">
                                            <select name="level"
                                                    class="form-control"
                                                    id="level"
                                            >
                                                <option value="0" @if(old('level') == 0) selected @endif>کاربر عادی
                                                </option>
                                                <option value="121" @if(old('level') == 121) selected @endif>ادمین
                                                </option>
                                            </select>

                                            @include('partials.form_error', ['input'=>'level'])
                                        </div>
                                    </div>
                                </div>
                                {{--STATUS--}}
                                <div class="col-6">
                                    <div class="form-group row justify-content-center">
                                        <label for="status"
                                               class="col-md-2 col-form-label text-center"
                                        >
                                            وضعیت
                                        </label>
                                        <div class="col-md-10">
                                            <select name="status"
                                                    class="form-control"
                                                    id="status"
                                            >
                                                <option value="0" @if(old('status') == 0) selected @endif> غیر فعال
                                                </option>
                                                <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                            </select>

                                            @include('partials.form_error', ['input'=>'email'])
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
        </div>{{--./CARD--}}

    </div>{{--./COL--}}


@endsection

@section('page-scripts')

    <script>
        // Set image src for selected image tag
        function readURL(input, img) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    img.attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Show image preview for each file input
        function showImage(element) {
            //$('input[name="file[file]['+id+']"]').attr('name');
            function id(element) {
                let name = $(element).attr('name');
                return name[name.length - 2];
            }

            readURL(element, $('#preview'));
        }

    </script>
@endsection


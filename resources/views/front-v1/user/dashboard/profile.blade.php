@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.profile') }}
@endsection

@section('dashboard-content')
    <h4>مدیریت حساب کاربری</h4>
    <form role="form" action="{{ route('dashboard.profile.update', $user->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}

        <div class="card-body">

            {{--NAME--}}
            <div class="form-group row justify-content-center">
                <label for="name"
                       class="col-md-2 col-form-label text-md-left">
                    نام
                </label>
                <div class="col-md-6">
                    <input id="name"
                           type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') ?? $user->name }}"
                           required
                           autocomplete="name"
                           placeholder="نام کاربر"
                    >
                    @include('partials.form_error', ['input'=>'name'])
                </div>
            </div>

            {{--FAMILY--}}
            <div class="form-group row justify-content-center">
                <label for="family"
                       class="col-md-2 col-form-label text-md-left">
                    نام خانوادگی
                </label>

                <div class="col-md-6">
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

            {{--MOBILE--}}
            <div class="form-group row justify-content-center">
                <label for="mobile"
                       class="col-md-2 col-form-label text-md-left"
                >
                    تلفن همراه
                </label>

                <div class="col-md-6">
                    <input id="mobile"
                           type="number"
                           class="ltr form-control text-center @error('mobile') is-invalid @enderror"
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

            {{--EMAIL--}}
            <div class="form-group row justify-content-center">
                <label for="email"
                       class="col-md-2 col-form-label text-md-left"
                >
                    آدرس ایمیل
                </label>

                <div class="col-md-5">
                    <input
                        class="form-control"
                           value="{{ $user->email }}"
                           readonly
                    >
                </div>

                <div class="col-md-1 mt-1 text-center">
                    @if(!is_null($user->email_verified_at))
                        <span class="badge badge-success font-14">
                            تایید شده
                            <i class="fa fa-check align-middle"></i>
                        </span>
                    @else
                        <span class="badge badge-danger">
                            تایید نشده
                            <i class="fa fa-plus fa-rotate-270"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>


        {{--PASSWORD UPDATE SECTION--}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <button class="btn btn-outline-dark w-100" type="button" data-toggle="collapse"
                        data-target="#passwordCollapse" aria-expanded="false" aria-controls="passwordCollapse">
                    بروز رسانی رمز عبور
                </button>
            </div>
        </div>

        <div class="collapse @if($errors->current_password->any() || $errors->password->any()) show @endif"
             id="passwordCollapse">

            <div class="card card-body">


                {{--CURRENT PASSWORD--}}
                <div class="form-group row justify-content-center">
                    <label for="current_password"
                           class="col-md-3 col-form-label text-md-left"
                    >
                        رمز عبور فعلی
                        <i class="fa fa-asterisk text-danger"></i>
                    </label>

                    <div class="col-md-6">
                        <input id="current_password"
                               type="password"
                               class="ltr form-control @error('current_password') is-invalid @enderror"
                               name="current_password"
                               placeholder="************"
                               value=""
                        >

                        @include('partials.form_error', ['input'=>'current_password'])
                    </div>
                </div>

                {{--PASSWORD--}}
                <div class="form-group row justify-content-center">
                    <label for="password"
                           class="col-md-3 col-form-label text-md-left"
                    >
                        رمز عبور جدید
                        <i class="fa fa-asterisk text-danger"></i>
                    </label>

                    <div class="col-md-6">
                        <input id="password"
                               type="password"
                               class="ltr form-control @error('password') is-invalid @enderror"
                               name="password"
                               autocomplete="new-password"
                               placeholder="************"
                               value=""
                        >

                        @include('partials.form_error', ['input'=>'password'])
                    </div>
                </div>

                {{--CONFIRM PASSWORD--}}
                <div class="form-group row justify-content-center">
                    <label for="password-confirm"
                           class="col-md-3 col-form-label text-md-left"
                    >
                        تکرار رمز عبور جدید
                        <i class="fa fa-asterisk text-danger"></i>
                    </label>

                    <div class="col-md-6">
                        <input id="password-confirm"
                               type="password"
                               class="ltr form-control"
                               name="password_confirmation"
                               autocomplete="new-password"
                               placeholder="************"
                               value=""
                        >
                    </div>
                </div>

            </div>
        </div>

        {{--./PASSWORD UPDATE SECTION--}}


        <div class="row my-4">
            <div class="col-12 px-3">
                <button type="submit" class="btn btn-block btn-outline-info">اعمال ویرایش</button>
            </div>
        </div>
    </form>

@endsection


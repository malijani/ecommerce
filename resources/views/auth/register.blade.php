@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-5 font-20">عضویت در {{ config('app.short.name') }}</div>
                    <div class="card-body">

                        {{--@include('partials.flashes')--}}

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-center">نام</label>

                                <div class="col-md-6">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autocomplete="name"
                                           autofocus
                                    >

                                    @include('partials.form_error', ['input'=>'name'])
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="family"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    نام خانوادگی
                                </label>

                                <div class="col-md-6">
                                    <input id="family"
                                           type="text"
                                           class="form-control @error('family') is-invalid @enderror"
                                           name="family"
                                           value="{{ old('family') }}"
                                           required
                                           autocomplete="family"
                                    >

                                    @error('family')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    تلفن همراه
                                </label>

                                <div class="col-md-6">
                                    <input id="mobile"
                                           type="text"
                                           class="ltr form-control @error('mobile') is-invalid @enderror"
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           minlength="11"
                                           maxlength="11"
                                           required
                                           autocomplete="mobile"
                                    >
                                    @include('partials.form_error', ['input'=>'mobile'])
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-center">
                                    آدرس ایمیل
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="ltr form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                    >

                                   @include('partials.form_error', ['input'=>'email'])
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    رمز عبور
                                </label>

                                <div class="col-md-6">
                                    <input id="password"
                                           type="password"
                                           class="ltr form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                    >

                                    @include('partials.form_error', ['input'=>'password'])
                                </div>
                            </div>


                            <div class="form-group row align-items-center justify-content-center">
                                <label for="captcha"
                                       class="col-form-label col-md-4 text-left"
                                >
                                    {!! captcha_img('default') !!}
                                </label>

                                <div class="col-md-2">
                                    <input type="text"
                                           name="captcha"
                                           id="captcha"
                                           class="form-control ltr @error('captcha') is-invalid @enderror"
                                           minlength="5"
                                           maxlength="5"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'captcha'])
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-outline-primary form-control">
                                        ثبت نام
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

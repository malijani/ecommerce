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
                                <label for="name"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    <i class="fal fa-asterisk text-danger"></i>
                                    نام
                                </label>

                                <div class="col-md-6">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror ltr"
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
                                <label for="mobile"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    <i class="fal fa-asterisk text-danger"></i>
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
                                <label for="password"
                                       class="col-md-4 col-form-label text-center"
                                >
                                    <i class="fal fa-asterisk text-danger"></i>
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


                            <div class="form-group row align-items-center justify-content-start">
                                <label for="captcha_text"
                                       class="col-form-label col-12 col-md-8 col-lg-4 text-center"
                                >
                                    {!! captcha_img('default') !!}
                                </label>

                                <div class="col-md-4 col-lg-6">
                                    <input type="text"
                                           name="captcha_text"
                                           id="captcha_text"
                                           class="form-control ltr @error('captcha_text') is-invalid @enderror"
                                           minlength="5"
                                           maxlength="5"
                                           required
                                           autocomplete="off"
                                    >
                                    @include('partials.form_error', ['input'=>'captcha_text'])
                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col-12 text-center">
                                <span class="text-muted">
                                    ثبت نام در {{ config('app.short.name') }} به منزله پذیرش قوانین و مقررات آن است!
                                </span>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12">
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-5 font-20">ورود به {{ config('app.name') }}</div>

                    <div class="card-body">
                        @if($requested)
                        <div class="row">
                            <div class="col-12 text-center text-md-right mb-4">
                                <a href="{{ route('verify.show') }}"
                                   class="btn btn-light font-weight-bolder"
                                >
                                    <i class="far fa-arrow-alt-right"></i>
                                   وارد کردن کد
                                </a>
                            </div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

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
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label pr-4" for="remember">
                                            مرا به خاطر بسپار
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 ">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-outline-primary form-control ">
                                        ورود
                                    </button>

                                </div>
                            </div>
                        </form>


                    </div>{{--CARD BODY--}}
                </div>{{--CARD--}}
            </div>{{--COL--}}
        </div>{{--ROW--}}
    </div>{{--CONTAINER--}}

@endsection

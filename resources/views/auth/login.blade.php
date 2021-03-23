@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center p-5 font-20">ورود به {{ config('app.name') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-center">ایمیل</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="ltr form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-center">پسورد</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="ltr form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label pr-4" for="remember">
                                        مرا به خاطر بسپار
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 ">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    ورود
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        پسوردتو فراموش کردی؟
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>



                    <div class="row mt-4 p-4">
                        <div class="col-12 text-center">
                            توی {{ config('app.name') }} اکانت نداری؟ یکی بساز!
                        </div>
                        <div class="col-12 text-center w-100 mt-2">
                            <a href="{{ route('register') }}" class="btn btn-outline-info">ساخت حساب کاربری در {{ config('app.name') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

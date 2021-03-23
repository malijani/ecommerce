@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-5 text-center font-20">تایید رمز عبور</div>

                <div class="card-body">
                    <div class="mt-2 mb-4">
                        قبل از ادامه هرگونه عملیاتی، لطفاً رمز عبور خود را تایید کنید.
                    </div>
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-center">رمز عبور</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="ltr form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    تایید پسورد
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        رمز عبورتو فراموش کردی؟
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

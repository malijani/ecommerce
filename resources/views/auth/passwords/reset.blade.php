@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-5 text-center font-20">بازنشانی رمز عبور</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="mobile" value="{{ $mobile }}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-center">رمز عبور</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="ltr form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-center">تایید رمز عبور</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="ltr form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary font-weight-bolder">
                                    بازنشانی پسورد
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

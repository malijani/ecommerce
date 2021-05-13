@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-5 text-center font-20">باز نشانی پسورد</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.send-code') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <label for="mobile"
                                   class="col-md-2 col-form-label text-center"
                            >
                                <i class="fal fa-asterisk text-danger"></i>
                                تلفن همراه
                            </label>

                            <div class="col-md-4">
                                <input id="mobile"
                                       type="text"
                                       class="ltr form-control @error('mobile') is-invalid @enderror"
                                       name="mobile"
                                       value="{{ old('mobile') }}"
                                       minlength="11"
                                       maxlength="11"
                                       autocomplete="mobile"
                                       required
                                >
                                @include('partials.form_error', ['input'=>'mobile'])
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="form-control btn btn-outline-primary">
                                    ارسال کد احراز هویت
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="mb-5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

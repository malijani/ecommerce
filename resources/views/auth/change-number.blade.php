@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-5 font-20">تایید حساب کاربری</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 text-center text-md-right mb-4">
                                <a href="{{ route('verify.index') }}"
                                   class="btn btn-light font-weight-bolder"
                                >
                                    <i class="far fa-arrow-alt-right"></i>
                                    بازگشت به تایید شماره
                                </a>
                            </div>

                            <div class="col-12">
                                <form action="{{ route('verify.change-number') }}" method="POST">
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
                                                   value="{{ old('mobile')?? $mobile }}"
                                                   minlength="11"
                                                   maxlength="11"
                                                   autocomplete="mobile"
                                                   required
                                            >
                                            @include('partials.form_error', ['input'=>'mobile'])
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-12 col-md-6">
                                            <button type="submit"
                                                    class="form-control btn btn-outline-primary"
                                            >
                                               تغییر شماره تلفن همراه
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
        </div>
    </div>

@endsection


@section('page-scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection

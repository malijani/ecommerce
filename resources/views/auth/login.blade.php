@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-5 font-20">ورود به {{ config('app.short.name') }}</div>

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
                                <div class="col-md-12">
                                    <input id="mobile"
                                           type="text"
                                           class="ltr font-weight-bolder font-16 text-center form-control @error('mobile') is-invalid @enderror"
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           pattern="09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}"
                                           minlength="11"
                                           maxlength="11"
                                           required
                                           autocomplete="mobile"
                                           placeholder="شماره تلفن همراه 09103944579"
                                    >
                                    @include('partials.form_error', ['input'=>'mobile'])
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
@section('page-scripts')
    <script>
        let
            persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
            arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
            fixNumbers = function (str) {
                if (typeof str === 'string') {
                    for (let i = 0; i < 10; i++) {
                        str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
                    }
                }
                return str;
            };

        $(document).ready(function() {
            let mobile_input = $("#mobile")
            mobile_input.on('keyup', function(){
                mobile_input.val(fixNumbers(mobile_input.val()));
            });
        });
    </script>
@endsection


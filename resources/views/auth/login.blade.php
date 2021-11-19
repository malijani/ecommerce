@extends('layouts.app')

@section('content')

    <div class="container-fluid h-100 bg-light">

        <div class="row justify-content-center h-100 align-items-center position-relative">

            <div class="login-bg position-absolute h-100 w-100"></div>

            <div class="col-xl-4 col-lg-5 col-md-6 col-12">

                <div class="card shadow border-0 border-radius-0 login-card">
                    {{--LOGIN LOGO--}}
                    <div class="card-header text-center font-20 bg-white p-0">
                        <img class="card-img-top" src="{{ asset('images/asset/logos/logo-text.png') }}"
                             alt="{{ config('app.brand.name') }}"
                        >
                    </div>
                    {{--./LOGIN LOGO--}}


                    <div class="card-body p-xs-4 p-2 mt-3">
                        <div class="row justify-content-end">
                            @if($requested)
                                <div class="col-sm-6 col-xs-12 text-right">
                                    <a href="{{ route('verify.show') }}"
                                       class="text-dark font-weight-bolder"
                                    >
                                        <i class="far fa-arrow-alt-right"></i>
                                        وارد کردن کد
                                    </a>
                                </div>
                            @endif

                            <div class="col-sm-6 col-xs-12 text-left">

                                <a href="{{ route('home') }}"
                                   class="text-dark font-weight-bolder"
                                >
                                    <span>بازگشت به سایت</span>
                                    <i class="far fa-arrow-alt-left"></i>
                                </a>
                            </div>
                        </div>


                        {{--TITLE--}}
                        <div class="card-title text-center mt-3 mb-5">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-sm-8 col-12 font-weight-bolder font-22">
                                    ورود به حساب کاربری
                                </div>
                            </div>

                        </div>
                        {{--./TITLE--}}

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row justify-content-center align-items-center">

                                <div class="col-12 mb-4">
                                    <label for="mobile" class="sr-only"></label>
                                    <input id="mobile"
                                           type="text"
                                           class="ltr input-custom font-weight-bolder py-4 text-center bg-light form-control @error('mobile') is-invalid @enderror @if(!empty(session()->get('error'))) is-invalid @endif"
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           {{--pattern="09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}"--}}
                                           minlength="11"
                                           maxlength="11"
                                           required
                                           autocomplete="mobile"
                                           placeholder="شماره تلفن همراه 09103944579"
                                    >
                                    @include('partials.form_error', ['input'=>'mobile'])
                                    @if(session()->get('error'))
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{session()->get('error')}}</strong></span>
                                    @endif
                                </div>


                            </div>

                            <div class="form-group row justify-content-center mb-0 ">
                                <div class="col-md-8 col-12">
                                    <button type="submit"
                                            class="btn btn-custom form-control font-20 font-weight-bolder pt-1"
                                    >
                                        دریافت کد
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
@push('scripts')
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

        $(document).ready(function () {
            let mobile_input = $("#mobile")
            mobile_input.on('keyup', function () {
                mobile_input.val(fixNumbers(mobile_input.val()));
            });
        });


        $('.login-bg').css('background-image', 'url("' + "{{ asset('images/asset/backgrounds/gym-min.jpg') }}" + '")')
        /*$('.login-header').css('background-image', 'url("' + "{{ asset('images/asset/logos/logo-full.png') }}" + '")')*/
    </script>
@endpush


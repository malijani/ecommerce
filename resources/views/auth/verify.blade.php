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
                            <div class="col-xs-12 text-left">
                                <a href="{{ route('login') }}"
                                   class="text-dark"
                                >
                                    <span class="text-muted">تغییر شماره تلفن</span>
                                    <span class="font-weight-bolder">{{ $mobile }}</span>
                                    <i class="far fa-arrow-alt-left"></i>

                                </a>
                            </div>
                        </div>

                        <div class="card-title text-center mt-3 mb-5">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-sm-8 col-12 font-weight-bolder font-22">
                                    تایید تلفن همراه
                                </div>
                            </div>

                        </div>

                        <form action="{{ route('verify') }}" method="POST">
                            @csrf
                            <div class="form-group row justify-content-center align-items-center">

                                {{-- <label for="code"
                                        class="col-form-label col-md-1 text-center"
                                 >
                                     کد
                                 </label>--}}
                                <div class="col-md-12 my-2" id="verify-input-wrapper">
                                    <label for="code" class="sr-only">کد شش رقمی</label>
                                    <input type="text"
                                           name="code"
                                           id="code"
                                           class="form-control input-custom font-weight-bolder font-16 text-center ltr @error('code') is-invalid @enderror"
                                           placeholder="کد شش رقمی ارسالی"
                                           autocomplete="off"
                                           pattern="\d*"
                                           minlength="6"
                                           maxlength="6"
                                           required
                                           autofocus
                                    >
                                    @include('partials.form_error', ['input'=>'code'])
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-8 col-12">
                                    <button type="submit"
                                            class="btn btn-custom form-control font-20 font-weight-bolder pt-1"
                                    >
                                        اعتبار سنجی
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="row mt-2 py-4">
                        <div class="col-12 text-center">
                            <button class="btn btn-light font-weight-bolder"
                                    data-target="{{ route('verify.resend') }}"
                                    id="resend-code"
                            >
                                ارسال مجدد کد
                            </button>
                            <div id="resend-timer">
                                <div class="font-weight-bolder font-16">
                                    <b> برای درخواست مجدد کد <span id="resend-timer-val">0</span> ثانیه صبر کنید</b>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(function () {
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


            let code_input = $("#code")
            code_input.on('keyup', function () {
                code_input.val(fixNumbers(code_input.val()));
            });

            let resend_code = $("#resend-code");
            let resend_timer = $("#resend-timer");
            let resend_timer_value = $("#resend-timer-val");
            let timer, countDownDate;

            resend_code.on('click', function () {
                $(this).hide();

                $.ajax({
                    url: $(this).attr('data-target'),
                    type: 'GET',
                    success: function (result) {
                        if (code_input.hasClass('is-invalid')) {
                            code_input.removeClass('is-invalid');
                        }
                        $("#verify-message").remove();
                        $("#verify-input-wrapper").append('<span class="text-success d-block" role="alert" id="verify-message"></span>');
                        $("#verify-message").append('<strong>' + result + '</strong>');

                        resend_timer.delay(1000).fadeIn(1000);
                        clearInterval(timer);
                        setTimer(true);

                    },
                    error: function (result) {
                        /*# DANGER MODE INPUT*/
                        $("#code").addClass('is-invalid');
                        /*# SHOW MESSAGE*/
                        $("#verify-message").remove();
                        $("#verify-input-wrapper").append('<span class="invalid-feedback d-block" role="alert" id="verify-message"></span>');
                        $("#verify-message").append('<strong>' + result.responseJSON + '</strong>')


                        resend_timer.delay(1000).fadeIn(1000);
                        clearInterval(timer);
                        setTimer(true);
                    }
                });
            });


            /*### BETTER TIMER ###*/
            resend_code.hide();
            function setTimer(manual) {
                if (manual === true) {
                    countDownDate = new Date();
                    countDownDate.setSeconds(countDownDate.getSeconds() + {{ config('verify.resend_delay') }});
                } else {
                    countDownDate = new Date("{{ $should_end_at }}").getTime();
                }

                timer = setInterval(function () {
                    // Get today's date and time
                    let now = new Date().getTime();
                    // Find the distance between now and the count down date
                    let distance = countDownDate - now;
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    if (distance < 1) {
                        resend_code.delay(1000).fadeIn(1000);
                        resend_timer.hide(1000).fadeOut(1000);
                        clearInterval(timer);
                    } else {
                        resend_timer_value.text(seconds)
                    }
                }, 1000);
            }

            setTimer(false);
            /*### SET BACKGROUND IMAGE ###*/
            $('.login-bg').css('background-image', 'url("' + "{{ asset('images/asset/backgrounds/gym-min.jpg') }}" + '")');
        });
    </script>
@endpush

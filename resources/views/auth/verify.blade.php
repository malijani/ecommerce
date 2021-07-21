@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-5 font-20">تایید حساب کاربری</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 text-center text-md-left mb-4">
                                <a href="{{ route('login') }}"
                                   class="btn btn-light font-weight-bolder"
                                >
                                    تغییر شماره تلفن ({{ $mobile }})
                                    <i class="far fa-arrow-alt-left"></i>

                                </a>
                            </div>

                            <div class="col-12">
                                <form action="{{ route('verify') }}" method="POST">
                                    @csrf
                                    <div class="form-group row justify-content-center">

                                       {{-- <label for="code"
                                               class="col-form-label col-md-1 text-center"
                                        >
                                            کد
                                        </label>--}}
                                        <div class="col-md-12">
                                            <input type="text"
                                                   name="code"
                                                   id="code"
                                                   class="form-control input-custom font-weight-bolder font-16 text-center ltr @error('code') is-invalid @enderror"
                                                   placeholder="کد ارسالی به شماره شما"
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
                                        <div class="col-12">
                                            <button type="submit"
                                                    class="form-control btn btn-custom"
                                            >
                                                اعتبار سنجی
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                        <b> برای درخواست مجدد کد <span id="resend-timer-val"></span> ثانیه صبر کنید</b>
                                    </div>
                                </div>
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

            let code_input = $("#code")
            code_input.on('keyup', function(){
                code_input.val(fixNumbers(code_input.val()));
            });

            let resend_code = $("#resend-code");
            let resend_timer = $("#resend-timer");
            let resend_timer_value = $("#resend-timer-val");
            let timer;
            function setTimer() {
                let delay = 60;
                resend_code.hide();
                timer = setInterval(function () {
                    resend_timer_value.text(delay--);
                    if (delay === 0) {
                        resend_code.delay(1000).fadeIn(1000);
                        resend_timer.hide(1000).fadeOut(1000);
                    }
                }, 1000);
            }
            setTimer();

            resend_code.on('click', function () {
                $.ajax({
                    url: $(this).attr('data-target'),
                    type: 'GET',
                    success: function (result) {
                        $("#flash-message").html(
                            '<div class="alert alert-success alert-block">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong class="mr-3">' + result + '</strong>' +
                            '</div>'
                        );
                        resend_timer.delay(1000).fadeIn(1000);
                        clearInterval(timer);
                        setTimer();

                    },
                    error: function (result) {
                        $("#flash-message").html(
                            '<div class="alert alert-danger alert-block">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong class="mr-3">' + result.responseJSON + '</strong>' +
                            '</div>'
                        );
                        resend_timer.delay(1000).fadeIn(1000);
                        clearInterval(timer);
                        setTimer();
                    }
                });
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')

    @yield('bread-crumb')

    <div class="container-fluid my-3">
        {{--MAIN ROW--}}
        <div class="row justify-content-center">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>

            <div class="col-12 col-lg-8 my-2 shadow-lg rounded p-md-0">{{--USER CONTROLL--}}
                @include('front-v1.user.dashboard.buttons')

                @yield('dashboard-content')
            </div>{{--./USER CONTROLL--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>

        </div>{{--row--}}

        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--container--}}
@endsection


@push('scripts')
    <script>
        $("#logout").on('click tap touchstart', function () {
            let logout_url = $(this).attr('data-url');
            Swal.fire({
                position: 'top',
                title: "<h4>قصد خروج از حساب کاربری خود را دارید؟</h4>",
                icon: "warning",
                confirmButtonText: 'خروج از حساب کاربری',
                denyButtonText: 'نه!',
                confirmButtonColor: '#d33',
                denyButtonColor: '#3085d6',
                showDenyButton: true,
                showConfirmButton: true,
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: logout_url,
                            type: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function () {
                                window.location.reload();
                            },
                            error: function () {
                                swal({
                                    text: "خطای غیر منتظره ای رخ داده، لطفاً بعداً تلاش نمایید.",
                                    icon: 'error',
                                    button: "فهمیدم.",
                                });
                            }
                        });
                    }
                });
        });
    </script>
@endpush



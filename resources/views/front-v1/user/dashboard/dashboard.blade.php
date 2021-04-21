@extends('layouts.app')

@section('content')

    @yield('bread-crumb')

    <div class="container my-3 rounded">
        <div class="row bg-white">

            <div class="col-md-3">{{--USER NAVIGATION BUTTONS--}}
                <div class="border rounded my-md-5 mt-5 bg-light">
                    {{--dashboard--}}
                    <div class="user-control text-center">
                        <a href="{{ route('dashboard.index') }}"
                           class="btn {{ Request::routeIs('dashboard.index') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
                        >
                            <i class="fal fa-desktop fa-2x align-middle px-2"></i>
                            داشبورد
                        </a>
                    </div>
                    {{--tickets--}}
                    <div class="user-control text-center">
                        <a href="{{ route('dashboard.ticket.index') }}"
                           class="btn {{ Request::routeIs('dashboard.ticket.*') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
                        >
                            <i class="fal fa-ticket-alt fa-2x align-middle px-2"></i>
                            پشتیبانی
                        </a>
                    </div>
                    {{--orders--}}
                    <div class="user-control text-center">
                        <a href="{{ route('dashboard.orders.index') }}"
                           class="btn {{ Request::routeIs('dashboard.orders.*') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
                        >
                            <i class="fal fa-list-alt fa-2x align-middle px-2"></i>
                            سفارش ها
                        </a>
                    </div>
                    {{--addresses--}}
                    <div class="user-control text-center">
                        <a href="{{ route('dashboard.addresses.index') }}"
                           id="show-address"
                           class="btn {{ Request::routeIs('dashboard.addresses.*') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
                        >
                            <i class="fal fa-location-arrow fa-2x align-middle px-2"></i>
                            آدرس ها
                        </a>
                    </div>


                    {{--user details--}}
                    <div class="user-control text-center">
                        <a href="{{ route('dashboard.profile.index') }}"
                           class="btn {{ Request::routeIs('dashboard.profile.*') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
                        >
                            <i class="fal fa-user-cog fa-2x align-middle px-2"></i>
                            حساب کاربری
                        </a>
                    </div>
                    @if(\Illuminate\Support\Facades\Route::has('logout'))
                        {{--logout--}}
                        <div class="user-control text-center">
                            <a href="#"
                               id="logout"
                               data-url="{{ route('logout') }}"
                               class="btn btn-outline-secondary w-95 my-2 font-weight-bolder"
                            >
                                <i class="fal fa-sign-out fa-2x align-middle px-2"></i>
                                خروج از سیستم
                            </a>
                        </div>
                    @endif
                </div>
            </div>{{--./USER NAVIGATION BUTTONS--}}

            <div class="col-md-9">{{--USER CONTROLL--}}
                <div class="my-md-5 p-3">
                    @yield('dashboard-content')
                </div>
            </div>{{--./USER CONTROLL--}}
        </div>{{--row--}}
    </div>{{--container--}}
@endsection


@section('page-scripts')
    <script type="text/javascript" src="{{ asset('front-v1/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#logout").on('click', function () {
                let logout_url = $(this).attr('data-url');
                swal({
                    title: "قصد خروج از حساب کاربری خود را دارید؟",
                    icon: "warning",
                    buttons: ['خیر', 'بله'],
                    dangerMode: true,
                })
                    .then((logout) => {
                        if (logout) {
                            // console.log('delete');
                            $.ajax({
                                url: logout_url,
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                },
                                success: function (result) {
                                    location.reload();
                                },
                                error: function () {
                                    swal({
                                        text: "خطای غیر منتظره ای رخ داده، لطفا با پشتیبانی وبسایت در میان بگذارید.",
                                        icon: 'error',
                                        button: "فهمیدم.",
                                    });
                                }
                            });
                        }
                    });
            });
        });
    </script>
@endsection



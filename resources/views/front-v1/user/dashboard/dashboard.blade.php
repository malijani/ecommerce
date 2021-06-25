@extends('layouts.app')

@section('page-styles')
    @stack('styles')
@endsection
@section('content')

    @yield('bread-crumb')

    <div class="container-fluid my-3 rounded">
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
                        <a href="{{ route('dashboard.tickets.index') }}"
                           class="btn {{ Request::routeIs('dashboard.tickets.*') ? 'btn-secondary text-white' : 'btn-outline-secondary' }} w-95 my-2 font-weight-bolder"
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
                            فاکتور ها
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
                            پروفایل
                        </a>
                    </div>
                    @if(\Illuminate\Support\Facades\Route::has('logout'))
                        {{--logout--}}
                        <div class="user-control text-center">
                            <button
                                id="logout"
                                data-url="{{ route('logout') }}"
                                class="btn btn-outline-secondary w-95 my-2 font-weight-bolder"
                            >
                                <i class="fal fa-sign-out fa-2x align-middle px-2"></i>
                                خروج
                            </button>
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
    <script>
        $(document).ready(function () {
            $("#logout").on('click', function () {
                let logout_url = $(this).attr('data-url');
                Swal.fire({
                    title: "قصد خروج از حساب کاربری خود را دارید؟",
                    icon: "warning",
                    /*buttons: ['خیر', 'بله'],*/
                    confirmButtonText: 'خروج',
                    denyButtonText: 'خیر!',
                    confirmButtonColor: '#3085d6',
                    denyButtonColor: '#d33',
                    showDenyButton: true,
                    showConfirmButton: true,
                    /*customClass: {
                        confirmButton: 'btn btn-outline-success mx-2 px-4',
                        denyButton: 'btn btn-danger mx-2 px-4'
                    },*/
                    /*buttonsStyling: false*/
                    dangerMode: true,
                })
                    .then((logout) => {
                        if (logout.isConfirmed) {
                            // console.log('delete');
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
        });
    </script>
    @stack('scripts')
@endsection



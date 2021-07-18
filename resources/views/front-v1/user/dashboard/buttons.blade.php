<div class="row d-lg-none my-3">
    {{--dashboard--}}
    <div class="col-12 col-md-6 text-center">
        <a href="{{ route('dashboard.index') }}"
           class="btn {{ Request::routeIs('dashboard.index') ? 'btn-custom-active' : 'btn-custom' }} w-100"
        >
            <i class="fal fa-user-alt fa-2x align-middle px-2"></i>
            داشبورد
        </a>
    </div>
    {{--tickets--}}
    <div class="col-12 col-md-6 text-center">
        <a href="{{ route('dashboard.tickets.index') }}"
           class="btn {{ Request::routeIs('dashboard.tickets.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
        >
            <i class="fal fa-ticket-alt fa-2x align-middle px-2"></i>
            پشتیبانی
        </a>
    </div>
    {{--orders--}}
    <div class="col-12 col-md-6 text-center">
        <a href="{{ route('dashboard.orders.index') }}"
           class="btn {{ Request::routeIs('dashboard.orders.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
        >
            <i class="fal fa-list-alt fa-2x align-middle px-2"></i>
            فاکتور ها
        </a>
    </div>
    {{--addresses--}}
    <div class="col-12 col-md-6 text-center">
        <a href="{{ route('dashboard.addresses.index') }}"
           id="show-address"
           class="btn {{ Request::routeIs('dashboard.addresses.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
        >
            <i class="fal fa-location-arrow fa-2x align-middle px-2"></i>
            آدرس ها
        </a>
    </div>
    {{--user details--}}
    <div class="col-12 col-md-6 text-center">
        <a href="{{ route('dashboard.profile.index') }}"
           class="btn {{ Request::routeIs('dashboard.profile.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
        >
            <i class="fal fa-user-cog fa-2x align-middle px-2"></i>
            پروفایل
        </a>
    </div>
    @if(\Illuminate\Support\Facades\Route::has('logout'))
        {{--logout--}}
        <div class="col-12 col-md-6 text-center">
            <button
                id="logout"
                data-url="{{ route('logout') }}"
                class="btn btn-custom w-100"
            >
                <i class="fal fa-sign-out fa-2x align-middle px-2"></i>
                خروج
            </button>
        </div>
    @endif
</div>

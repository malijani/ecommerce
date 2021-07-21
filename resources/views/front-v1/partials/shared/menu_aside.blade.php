<div class="row rounded py-2">
    <div class="col-12 px-lg-1 px-xl-3">
        <aside id="side_nav">

            {{--DASHBOARD--}}
            <div class="user-control text-center">
                <a href="{{ route('dashboard.index') }}"
                   class="btn {{ Request::routeIs('dashboard.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    <i class="fal fa-user-alt align-middle px-2"></i>
                    داشبورد
                </a>
                @if(Request::routeIs('dashboard.*'))
                    <div class="card mb-2 border-0 border-radius-0">
                        {{--tickets--}}
                        <div class="user-control text-center">
                            <a href="{{ route('dashboard.tickets.index') }}"
                               class="btn {{ Request::routeIs('dashboard.tickets.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                            >
                                <i class="fal fa-ticket-alt align-middle px-2"></i>
                                پشتیبانی
                            </a>
                        </div>
                        {{--orders--}}
                        <div class="user-control text-center">
                            <a href="{{ route('dashboard.orders.index') }}"
                               class="btn {{ Request::routeIs('dashboard.orders.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                            >
                                <i class="fal fa-list-alt align-middle px-2"></i>
                                فاکتور ها
                            </a>
                        </div>
                        {{--addresses--}}
                        <div class="user-control text-center">
                            <a href="{{ route('dashboard.addresses.index') }}"
                               id="show-address"
                               class="btn {{ Request::routeIs('dashboard.addresses.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                            >
                                <i class="fal fa-location-arrow align-middle px-2"></i>
                                آدرس ها
                            </a>
                        </div>
                        {{--user details--}}
                        <div class="user-control text-center">
                            <a href="{{ route('dashboard.profile.index') }}"
                               class="btn {{ Request::routeIs('dashboard.profile.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                            >
                                <i class="fal fa-user-cog align-middle px-2"></i>
                                پروفایل
                            </a>
                        </div>
                        @if(\Illuminate\Support\Facades\Route::has('logout'))
                            {{--logout--}}
                            <div class="user-control text-center">
                                <button
                                    id="logout"
                                    data-url="{{ route('logout') }}"
                                    class="logout btn btn-custom w-100"
                                >
                                    <i class="fal fa-sign-out align-middle px-2"></i>
                                    خروج
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{--PRODUCTS--}}
            <div class="user-control text-center">
                <a href="{{ route('product.index') }}"
                   class="btn {{ Request::routeIs('product.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    محصولات
                </a>
            </div>

            {{--BLOG--}}
            <div class="user-control text-center">
                <a href="{{ route('blog.index') }}"
                   class="btn {{ Request::routeIs('blog.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    وبلاگ
                </a>
            </div>

            {{--CATEGORIES--}}
            <div class="user-control text-center">
                <a href="{{ route('category.index') }}"
                   class="btn {{ Request::routeIs('category.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    دسته بندی ها
                </a>
            </div>

            {{--BRANDS--}}
            <div class="user-control text-center">
                <a href="{{ route('brand.index') }}"
                   class="btn {{ Request::routeIs('brand.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    برند ها
                </a>
            </div>

            {{--FAQ--}}
            <div class="user-control text-center">
                <a href="{{ route('faq.index') }}"
                   class="btn {{ Request::routeIs('faq.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    پرسش های متداول
                </a>
            </div>

            {{--PAGES--}}
            <div class="user-control text-center">
                <a href="{{ route('page.index') }}"
                   class="btn {{ Request::routeIs('page.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    صفحات
                </a>
            </div>



        </aside>

    </div>
</div>

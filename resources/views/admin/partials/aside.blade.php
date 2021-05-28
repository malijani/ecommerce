<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="{{ route('admin.home') }}" class="brand-link">
        <div class="row justify-content-center align-items-center">

            <div class="col-6 text-center">
                <span class="brand-text font-weight-light">پنل مدیریت</span>
            </div>
            <div class="col-6 text-center">
                <img src="{{ asset($logo->pic ?? 'images/fallback/logo.png') }}"
                     alt="{{ $logo->pic_alt ?? config('app.short.name') }}"
                     class="elevation-3 img-fluid bg-white rounded align-middle w-75"
                     style="opacity: .8"
                >
            </div>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-left">
                <div class="image mr-2">
                    <img src="{{ asset(Auth::user()->pic ?? 'images/fallback/user.png') }}"
                         class="img-circle elevation-2"
                         alt="{{ Auth::user()->uuid }}"
                    >
                </div>
                <div class="info">
                    <span class="text-white">
                        {{ \Illuminate\Support\Facades\Auth::user()->full_name }}
                    </span>

                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->



                    {{--ORDERS--}}
                    <li class="nav-item">
                        <a href="{{ route('factors.index') }}"
                           class="nav-link {{ Request::routeIs('factors.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-th-list"></i>
                            <p>
                                سفارشات
                            </p>
                        </a>
                    </li>


                    <li class="nav-item has-treeview {{Request::routeIs('users.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{Request::routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fal fa-user"></i>
                            <p>
                                کاربران
                                <i class="right fal fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                   class="nav-link {{Request::routeIs('users.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}"
                                   class="nav-link {{Request::routeIs('users.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن کاربر</p>
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="nav-item has-treeview {{(Request::routeIs('tickets.*') || Request::routeIs('ticket-categories.*')) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{(Request::routeIs('tickets.*') || Request::routeIs('ticket-categories.*'))? 'active' : '' }}">
                            <i class="nav-icon fal fa-ticket"></i>
                            <p>
                                تیکت ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tickets.index') }}"
                                   class="nav-link {{Request::routeIs('tickets.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست تیکت ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ticket-categories.index') }}"
                                   class="nav-link {{Request::routeIs('ticket-categories.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>دسته بندی تیکت ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('comments.index') }}"
                           class="nav-link {{ Request::routeIs('comments.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-comment"></i>
                            <p>
                                نظرات
                            </p>
                        </a>
                    </li>


                    {{--PAGES--}}
                    <li
                        class="nav-item has-treeview {{Request::routeIs('pages.*') ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{Request::routeIs('pages.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-file-code"></i>
                            <p>
                                صفحه ساز
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('pages.index') }}"
                                   class="nav-link {{Request::routeIs('pages.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست صفحات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pages.create') }}"
                                   class="nav-link {{Request::routeIs('pages.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن صفحه</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item has-treeview {{Request::routeIs('categories.*') ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{Request::routeIs('categories.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-list-alt"></i>
                            <p>
                                دسته بندی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}"
                                   class="nav-link {{Request::routeIs('categories.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست دسته بندی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}"
                                   class="nav-link {{Request::routeIs('categories.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن دسته بندی</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li
                        class="nav-item has-treeview {{Request::routeIs('brands.*') ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{Request::routeIs('brands.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-list"></i>
                            <p>
                                برند ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('brands.index') }}"
                                   class="nav-link {{Request::routeIs('brands.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست برند ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('brands.create') }}"
                                   class="nav-link {{Request::routeIs('brands.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن برند</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li
                        class="nav-item has-treeview {{Request::routeIs('articles.*') ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{ Request::routeIs('articles.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-newspaper"></i>
                            <p>
                                مقالات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('articles.index') }}"
                                   class="nav-link {{ Request::routeIs('articles.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست مقالات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('articles.create') }}"
                                   class="nav-link {{ Request::routeIs('articles.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن مقاله</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item has-treeview {{ (Request::routeIs('products.*')||Request::routeIs('attributes.*')) ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{ (Request::routeIs('products.*')||Request::routeIs('attributes.*')) ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-cubes"></i>
                            <p>
                                محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}"
                                   class="nav-link {{ Request::routeIs('products.index') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لیست محصولات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}"
                                   class="nav-link {{ Request::routeIs('products.create') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>افزودن محصول</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('attributes.index') }}"
                                   class="nav-link {{ Request::routeIs('attributes.*') ? 'active' : '' }}"
                                >
                                    <i class="nav-icon fal fa-sitemap"></i>
                                    <p>
                                        ویژگی های محصول
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{--DISCOUNT CODES--}}
                    <li class="nav-item">
                        <a href="{{ route('discount-codes.index') }}"
                           class="nav-link {{ Request::routeIs('discount-codes.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-percent"></i>
                            <p>
                                کد های تخفیف
                            </p>
                        </a>
                    </li>


                    {{--SOCIAL MEDIA--}}
                    <li
                        class="nav-item has-treeview {{ (Request::routeIs('social-medias.*')|| Request::routeIs('social-media-buttons.*')) ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{ (Request::routeIs('social-medias.*')|| Request::routeIs('social-media-buttons.*')) ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-chart-network"></i>
                            <p>
                                صفحات مجازی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('social-medias.index') }}"
                                   class="nav-link {{Request::routeIs('social-medias.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>بنر های صفحات مجازی</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('social-media-buttons.index') }}"
                                   class="nav-link {{Request::routeIs('social-media-buttons.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>دکمه های صفحات مجازی</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{--FAQ--}}
                    <li class="nav-item">
                        <a href="{{ route('faqs.index') }}"
                           class="nav-link {{ Request::routeIs('faqs.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-question-circle"></i>
                            <p>
                                پرسشهای متداول
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('top-navs.index') }}"
                           class="nav-link {{ Request::routeIs('top-navs.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-bars"></i>
                            <p>
                                ناوبری ایستا
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('logos.index') }}"
                           class="nav-link {{ Request::routeIs('logos.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fab fa-creative-commons"></i>
                            <p>
                                لوگو ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('favicons.index') }}"
                           class="nav-link {{ Request::routeIs('favicons.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fab fa-amilia"></i>
                            <p>
                                فاواکن ها
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}"
                           class="nav-link {{ Request::routeIs('banners.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-file-image"></i>
                            <p>
                                بنر ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sliders.index') }}"
                           class="nav-link {{ Request::routeIs('sliders.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-sliders-h"></i>
                            <p>
                                اسلایدر ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('image-menus.index') }}"
                           class="nav-link {{ Request::routeIs('image-menus.*') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-grip-lines"></i>
                            <p>
                                منو های تصویری
                            </p>
                        </a>
                    </li>


                    <li
                        class="nav-item has-treeview {{ (Request::routeIs('footer-items.*')||Request::routeIs('footer-links.*') || Request::routeIs('footer-images.*') || Request::routeIs('footer-texts.*') || Request::routeIs('footer-licenses.*')) ? 'menu-open' : '' }}"
                    >
                        <a href="#"
                           class="nav-link {{ (Request::routeIs('footer-items.*')||Request::routeIs('footer-links.*') || Request::routeIs('footer-images.*') || Request::routeIs('footer-texts.*') || Request::routeIs('footer-licenses.*')) ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-info"></i>
                            <p>
                                مدیریت فوتر
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('footer-images.index') }}"
                                   class="nav-link {{ Request::routeIs('footer-images.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-picture-o nav-icon"></i>
                                    <p>تصاویر فوتر</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('footer-items.index') }}"
                                   class="nav-link {{ Request::routeIs('footer-items.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>سردسته های فوتر</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('footer-links.index') }}"
                                   class="nav-link {{ Request::routeIs('footer-links.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>لینک های فوتر</p>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('footer-texts.index') }}"
                                   class="nav-link {{ Request::routeIs('footer-texts.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>متن های فوتر</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('footer-licenses.index') }}"
                                   class="nav-link {{ Request::routeIs('footer-licenses.*') ? 'active' : '' }}"
                                >
                                    <i class="fal fa-circle nav-icon"></i>
                                    <p>مجوز های فوتر</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.fm-frame') }}"
                           class="nav-link {{ Request::routeIs('admin.fm-frame') ? 'active' : '' }}"
                        >
                            <i class="nav-icon fal fa-file"></i>
                            <p>
                                مدیریت فایل
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</aside>

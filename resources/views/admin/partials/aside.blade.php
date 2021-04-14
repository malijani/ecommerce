<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset($logo->pic ?? 'images/fallback/logo.png') }}"
             alt="{{ $logo->pic_alt ?? config('app.name') }}"
             class="brand-image img-circle elevation-3"
             style="opacity: .8"
        >
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
                <div class="image mr-2">
                    <img src="{{ asset('images/fallback/user.png') }}"
                         class="img-circle elevation-2"
                         alt="User Image"
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


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن کاربر</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>
                                دسته بندی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست دسته بندی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن دسته بندی</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                برند ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('brands.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست برند ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('brands.create') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن برند</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-newspaper-o"></i>
                            <p>
                                مقالات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('articles.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست مقالات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('articles.create') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن مقاله</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cubes"></i>
                            <p>
                                محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست محصولات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن محصول</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('attributes.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>
                                ویژگی های محصول
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('faqs.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-question-circle-o"></i>
                            <p>
                                پرسشهای متداول
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('top-navs.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-navicon"></i>
                            <p>
                                ناوبری ایستا
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('logos.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-cc"></i>
                            <p>
                                لوگو ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-file-image-o"></i>
                            <p>
                                بنر ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sliders.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-sliders"></i>
                            <p>
                                اسلایدر ها
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('footer-images.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-image"></i>
                            <p>
                                تصویر فوتر وبسایت
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('admin.fm-frame') }}" class="nav-link">
                            <i class="nav-icon fa fa-file-o"></i>
                            <p>
                                مدیریت فایل
                            </p>
                        </a>
                    </li>

                    {{--                    <li class="nav-item has-treeview">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-trash"></i>--}}
                    {{--                            <p>--}}
                    {{--                                سطل زباله--}}
                    {{--                                <i class="right fa fa-angle-left"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="{{ route('t-categories.index') }}" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>دسته بندی های حذف شده</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}

                    {{--                        </ul>--}}
                    {{--                    </li>--}}

                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="pages/widgets.html" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-th"></i>--}}
                    {{--                            <p>--}}
                    {{--                                ویجت‌ها--}}
                    {{--                                <span class="right badge badge-danger">جدید</span>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item has-treeview">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-pie-chart"></i>--}}
                    {{--                            <p>--}}
                    {{--                                چارت‌ها--}}
                    {{--                                <i class="right fa fa-angle-left"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/charts/chartjs.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>نمودار ChartJS</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/charts/flot.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>نمودار Flot</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/charts/inline.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>نمودار Inline</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item has-treeview">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-tree"></i>--}}
                    {{--                            <p>--}}
                    {{--                                اشیای گرافیکی--}}
                    {{--                                <i class="fa fa-angle-left right"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/UI/general.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>عمومی</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/UI/icons.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>آیکون‌ها</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/UI/buttons.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>دکمه‌ها</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/UI/sliders.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>اسلایدر‌ها</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item has-treeview">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-edit"></i>--}}
                    {{--                            <p>--}}
                    {{--                                فرم‌ها--}}
                    {{--                                <i class="fa fa-angle-left right"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/forms/general.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>اجزا عمومی</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/forms/advanced.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>پیشرفته</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/forms/editors.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>ویشرایشگر</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item has-treeview">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fa fa-table"></i>--}}
                    {{--                            <p>--}}
                    {{--                                جداول--}}
                    {{--                                <i class="fa fa-angle-left right"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/tables/simple.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>جداول ساده</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="pages/tables/data.html" class="nav-link">--}}
                    {{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
                    {{--                                    <p>جداول داده</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-header">مثال‌ها</li>--}}
                </ul>
            </nav>
        </div>
    </div>
</aside>

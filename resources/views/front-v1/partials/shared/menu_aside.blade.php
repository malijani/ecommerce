<div class="row rounded py-2">
    <div class="col-12 px-lg-1 px-xl-3">
        <aside id="side_nav">
            <div class="user-control text-center">
                <a href="{{ route('product.index') }}"
                   class="btn {{ Request::routeIs('product.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    محصولات
                </a>
            </div>

            <div class="user-control text-center">
                <a href="{{ route('blog.index') }}"
                   class="btn {{ Request::routeIs('blog.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    وبلاگ
                </a>
            </div>

            <div class="user-control text-center">
                <a href="{{ route('page.index') }}"
                   class="btn {{ Request::routeIs('page.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    صفحات
                </a>
            </div>

            <div class="user-control text-center">
                <a href="{{ route('brand.index') }}"
                   class="btn {{ Request::routeIs('brand.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    برند ها
                </a>
            </div>
            <div class="user-control text-center">
                <a href="{{ route('category.index') }}"
                   class="btn {{ Request::routeIs('category.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    دسته بندی ها
                </a>
            </div>

            <div class="user-control text-center">
                <a href="{{ route('faq.index') }}"
                   class="btn {{ Request::routeIs('faq.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    پرسش های متداول
                </a>
            </div>




            <div class="user-control text-center">
                <a href="{{ route('dashboard.index') }}"
                   class="btn {{ Request::routeIs('dashboard.*') ? 'btn-custom-active' : 'btn-custom' }} w-100"
                >
                    داشبورد
                </a>
            </div>
        </aside>

    </div>
</div>

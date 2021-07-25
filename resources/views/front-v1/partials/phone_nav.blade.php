<section>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center border-top">

            <a href="{{ route('home') }}"
               class="col px-1 py-2 text-center text-dark"
            >
                <i class="fal fa-home-alt fa-2x {{ Request::routeIs('home') ? 'text-info' : '' }}"></i>
            </a>


            <a href="{{ route('cart.index') }}"
               class="col px-1 py-2 text-center text-dark"
            >
                <span class="fa-stack has-badge"
                      data-count="{{ session()->get('total')['count'] ?? '0' }}"
                >
                    <i class="fal fa-shopping-cart fa-2x {{ Request::routeIs('cart.*') ? 'text-info' : '' }}"></i>
                </span>
            </a>

            <a href="{{ route('dashboard.index') }}"
               class="col px-1 py-2 text-center text-dark"
            >
                <i class="fal fa-user fa-2x {{ Request::routeIs('dashboard.*') ? 'text-info' : '' }}"></i>
            </a>

            <a href="{{ route('category.index') }}"
               class="col px-1 py-2 text-center text-dark"
            >
                <i class="fal fa-list-alt fa-2x {{ Request::routeIs('category.*') ? 'text-info' : '' }}"></i>
            </a>

            <a href="{{ route('blog.index') }}"
               class="col px-1 py-2 text-center text-dark"
            >
                <i class="fal fa-newspaper fa-2x {{ Request::routeIs('blog.*') ? 'text-info' : '' }}"></i>
            </a>

        </div>
    </div>
</section>

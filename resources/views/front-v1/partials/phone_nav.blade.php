<footer id="phone-nav" class="d-block d-md-none mt-3 sticky-footer bg-light">
    <section>
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center border-top">

                <a href="{{ route('home') }}"
                   class="col px-1 py-2 text-center text-dark"
                >
                    <i class="fal fa-home-alt fa-2x"></i>
                </a>

                <a href="{{ route('dashboard.index') }}"
                   class="col px-1 py-2 text-center text-dark"
                >
                    <i class="fal fa-user fa-2x"></i>
                </a>

                <a href="{{ route('cart.index') }}"
                   class="col px-1 py-2 text-center text-dark"
                >
                    <i class="fal  fa-shopping-cart fa-2x"></i>
                </a>

                <a href="{{ route('category.index') }}"
                   class="col px-1 py-2 text-center text-dark"
                >
                    <i class="fal fa-cubes fa-2x"></i>
                </a>

                <a href="{{ route('blog.index') }}"
                   class="col px-1 py-2 text-center text-dark"
                >
                    <i class="fal fa-newspaper fa-2x "></i>
                </a>

            </div>
        </div>
    </section>
</footer>

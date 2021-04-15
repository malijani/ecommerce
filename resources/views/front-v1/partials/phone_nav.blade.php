<footer id="phone-nav">
    <div class="container-fluid mt-5 d-block d-md-none bg-whitesmoke sticky-footer">

        <div class="row justify-content-center align-items-center">
            <div class="col-12 border-top text-center">
                <div class="d-flex p-1 py-3">

                    <a href="{{ route('home') }}" class="col  text-black-50">
                        <i class="fal fa-home-alt fa-2x"></i>
                    </a>

                    <a href="{{ route('dashboard.index') }}" class="col  text-black-50">
                        <i class="fal fa-user fa-2x"></i>
                    </a>

                    <a href="{{ route('cart.index') }}" class="col  text-black-50">
                        <i class="fal  fa-shopping-cart fa-2x"></i>
                    </a>

                    <a href="{{ route('category.index') }}" class="col  text-black-50">
                        <i class="fal fa-cubes fa-2x"></i>
                    </a>

                    <a href="{{ route('blog.index') }}" class="col  text-black-50">
                        <i class="fal fa-newspaper fa-2x "></i>
                    </a>

                </div>
            </div>
        </div>
    </div>

</footer>

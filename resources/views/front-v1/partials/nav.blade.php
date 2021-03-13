<div class="py-2 px-2 bg-white text-dark sticky-top border-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 col-md-4 d-flex justify-content-center align-items-center mb-2">

                {{--SHOPPING CART--}}
                <a href="{{ route('cart.index') }}"
                   title="سبد خرید"
                   role="button"
                class="btn btn-primary mx-1"
                >
                    <i class="fa fa-shopping-cart"></i>
                    سبد خرید
                </a>


                {{--USER LOGIN/REGISTER--}}
                @if (\Illuminate\Support\Facades\Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <form action="{{ route('logout') }}" method="post" class="form-inline">
                                @csrf
                                <button class="btn btn-outline-dark mx-1" role="button" type="submit" >
                                    <i class="fa fa-sign-out"></i>
                                    خروج
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary mx-1" role="button">
                                <i class="fa fa-sign-in"></i>
                                ورود
                            </a>

                            @if (\Illuminate\Support\Facades\Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary mx-1" role="button">
                                    <i class="fa fa-user-plus"></i>
                                    عضویت
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>

            {{--LOGO SECTION : MOBILE--}}
            <div class="col-3 col-md-8 d-block d-lg-none text-left">
                <img class="img-fluid" src="{{asset('front-v1/img/logo.png')}}">
            </div>

            {{--SEARCH SECTION : TODO : LIVEWIRE SEARCHING--}}
            <div class="col-12 col-md-12 col-lg-6 ltr d-flex align-items-center">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupAddon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control text-right" placeholder="جستجوی محصول" aria-label="Input group example" aria-describedby="btnGroupAddon">
                </div>
            </div>

            {{--LOGO SECTION--}}
            <div class="col-2 d-none d-lg-block text-left">
                <img class="img-fluid" src="https://via.placeholder.com/50">
            </div>
        </div>

        <div class="row ">
            <div class="col-12 d-none d-lg-block">
                <div class="row">
                    {{--USER ADDRESS SHOW--}}
                    <div class="col-lg-3 font-14">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="col-1">
                                <i class="fa fa-location-arrow"></i>
                            </div>
                            <div class="col-11">
                                <span>آدرس شما</span>
                                <br>
                                <span> تهران ، اسکندری شمالی > </span>
                            </div>
                        </div>
                    </div>

{{--                    TODO : CREATE MEGA MENU--}}
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <a class="mx-2" href="{{ route('home') }}">
                            <i class="fa fa-home"></i>
                            خانه
                        </a>

                        <a class="mx-2" href="{{ route('product.index') }}">
                        <i class="fa fa-diamond"></i>
                            محصولات
                        </a>

                        <a class="mx-2" href="{{ route('blog.index') }}">
                            <i class="fa fa-file"></i>
                            وبلاگ
                        </a>

                        <a class="mx-2" href="{{ route('category.index') }}">
                            <i class="fa fa-list"></i>
                             دسته بندی ها
                        </a>
                    </div>
                    <div class="col-lg-3 text-left">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

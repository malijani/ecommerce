<div class="py-2 px-2 bg-white text-dark sticky-top border-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 col-md-4 d-flex justify-content-center align-items-center mb-2">
                <button data-toggle="modal" data-target="#modalrightmenu" class="btn btn-sm btn-primary font-12 ml-1">
                    <i class="fa fa-shopping-cart navbar-toggler-icon"></i>
                    سبد خرید
                </button>
                <button class="btn btn-sm btn-outline-primary font-12 mr-1">
                    <i class="fa fa-user"></i>
                    ورود/عضویت
                </button>
            </div>
            <div class="col-3 col-md-8 d-block d-lg-none text-left">
                <img class="img-fluid" src="{{asset('front-v1/img/logo.png')}}">
            </div>
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
            <div class="col-2 d-none d-lg-block text-left">
                <img class="img-fluid" src="https://via.placeholder.com/50">
            </div>
        </div>
        <div class="row ">
            <div class="col-12 d-none d-lg-block">
                <div class="row">
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
                            مقالات
                        </a>

                        <a class="mx-2" href="#">
                            <i class="fa fa-list"></i>
                            دسته بندی
                        </a>
                    </div>
                    <div class="col-lg-3 text-left">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

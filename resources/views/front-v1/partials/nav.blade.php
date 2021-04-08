{{--NAVBAR--}}


<div class="container-fluid">
    <div class="bg-dark text-white  text-right rounded pt-3 pb-5">
        <div class="container">
            {{--DISPLAY > MD--}}
            <div class="row d-sm-block d-none justify-content-center ">
                {{--TODO : DYNAMIC TOP NAVBAR--}}
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class=" font-12 text-white font-weight-bolder">برند ها</a>
                </div>
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class=" font-12 text-white font-weight-bolder">مشاوره</a>
                </div>
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class=" font-12 text-white font-weight-bolder">پرسش های متداول</a>
                </div>
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class=" font-12 text-white font-weight-bolder">درباره جیم لند</a>
                </div>
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class="font-12 text-white font-weight-bolder">قوانین و مقررات</a>
                </div>
                <div class="col-md-2 mx-auto mt-2">
                    <a href="#" class="font-12 text-white font-weight-bolder">تماس با ما</a>
                </div>
            </div>
            {{--DISPLAY < MD--}}
            <div class="row d-block d-md-none text-center py-3">
                <div class="col-12">
                    <a href="#" class="font-12 text-white font-weight-bolder">
                        جهت مشاوره با ما تماس بگیرید!
                    </a>
                </div>

            </div>
        </div>
    </div>


    <div class="bg-white text-dark rounded">
        <div class="container">
            <div class="row mt-2">

                {{--SHOW LOGO--}}
                {{--DISPLAY > MD--}}
                <div class="d-none d-md-block col-md-2 text-center">
                    <img class="img-fluid rounded " src="{{asset($logo->pic??'images/fallback/logo.png')}}"
                         alt="{{$logo->pic_alt??config('app.name')}}">
                </div>
                {{--DISPLAY < MD--}}
                <div class="d-sm-block d-md-none col-md-1 text-center py-3 border-bottom">
                    <img class="img-fluid rounded" src="{{asset($logo->pic??'images/fallback/logo.png')}}"
                         alt="{{$logo->pic_alt??config('app.name')}}">
                </div>
                {{--./SHOW LOGO--}}


                {{--SHOW SEARCH BAR--}}
                {{--DISPLAY > MD--}}
                <div class="d-none d-md-block col-md-4 col-lg-6 my-auto">
                    <div class="input-group">
                        <input type="text" class="form-control"
                               placeholder="جست و جوی محصول، مقاله، دسته بندی، برند و ..."
                               aria-label="Input group example" aria-describedby="btnGroupAddon">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{--DISPLAY < MD--}}
                <div class="d-sm-block d-md-none col-12 my-3">
                    <div class="input-group">
                        <input type="text" class="form-control"
                               placeholder="جست و جوی محصول، مقاله، دسته بندی، برند و ..."
                               aria-label="Input group example" aria-describedby="btnGroupAddon">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{--./SHOW SEARCH BAR--}}

                {{--SHOW LOGIN AND CART--}}
                <div class=" col-md-6 col-lg-4 py-3 my-auto text-center">

                    {{--USER INFO--}}
                    @if (\Illuminate\Support\Facades\Route::has('login'))

                        @auth
                            {{--<form action="{{ route('logout') }}" method="post" class="form-inline w-100">
                                @csrf
                                <button class="btn btn-outline-dark mx-1" role="button" type="submit">
                                    <i class="fa fa-sign-out"></i>
                                    خروج
                                </button>
                            </form>--}}
                            <a href="#USER_DASHBOARD" class="mx-1 py-1 px-2 text-dark rounded" role="button">
                                <i class="fa fa-user"></i>
                                {{ \Illuminate\Support\Facades\Auth::user()->full_name }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="mx-1 py-1 px-2 text-dark rounded" role="button">
                                <i class="fa fa-user fa-2x align-middle"></i>
                            </a>

                        @endauth

                    @endif
                    {{--./USER INFO--}}


                    {{--SHOPPING CART--}}

                    <a href="{{ route('cart.index') }}"
                       title="سبد خرید"
                       role="button"
                       class="bg-lightgreen mx-1 py-1 px-2 text-dark rounded"

                    >
                        <i class="fa fa-shopping-cart"></i>
                        {{--SHOW COUNT OF ITEMS IN CART--}}
                        @if(session()->get('basket'))
                            <span class="border border-dark rounded px-2 ">{{ count(session()->get('basket')) }}</span>
                        @else
                            <span class="border border-dark rounded px-2 ">0</span>
                        @endif
                        {{--SHOW TOTAL PRICE OF CART--}}
                        @if(session()->get('total'))
                            <span class="">{{ number_format(session()->get('total')['final_price']) }} تومن</span>
                        @else
                            <span class="">0 تومن</span>
                        @endif
                    </a>

                </div>
                {{--./SHOW LOGIN AND CART--}}
            </div>
        </div>
    </div>
</div>

{{--<div class="bg-white text-dark rounded mt-3 d-none d-md-block sticky-top">
    <div class="container-fluid ">

        <div class="row text-center justify-content-center py-3">

            <div class="col-md-2 mx-auto mt-2">
                <a class="text-info" href="{{ route('home') }}">
                    <i class="fa fa-home"></i>
                    {{ config('app.name') ?? 'خانه' }}
                </a>
            </div>

            <div class="col-md-2 mx-auto mt-2">
                <a class="mx-2" href="{{ route('product.index') }}">
                    <i class="fa fa-diamond"></i>
                    محصولات
                </a>
            </div>
            <div class="col-md-2 mx-auto mt-2">
                <a class="mx-2" href="{{ route('blog.index') }}">
                    <i class="fa fa-file"></i>
                    وبلاگ
                </a>
            </div>
            <div class="col-md-2 mx-auto mt-2">
                <a class="mx-2" href="{{ route('category.index') }}">
                    <i class="fa fa-list"></i>
                    دسته بندی ها
                </a>
            </div>
            <div class="col-md-2 mx-auto mt-2">
                <a class="mx-2" href="{{ route('brand.index') }}">
                    <i class="fa fa-barcode"></i>
                    برند ها
                </a>
            </div>

        </div>
    </div>

</div>--}}

{{--<div class="bg-white text-dark rounded mt-3 sticky-top">
    <nav class="navbar navbar-expand-lg">

        <a class="navbar-brand mr-5 text-dark" href="{{ route('home') }}">{{ config('app.name')?? 'خانه'}}</a>

        <button class="navbar-toggler ml-5" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse text-right ml-5" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index') }}">محصولات</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        وبلاگ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="text-uppercase text-white">وبلاگ {{ config('app.name') }}</span>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('blog.index') }}">تمامی پست ها</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">
                                    <a href="">
                                        <img src="https://dummyimage.com/200x100/ccc/000&text=image+link" alt=""
                                             class="img-fluid">
                                    </a>
                                    <p class="text-white">Short image call to action</p>

                                </div>
                                <!-- /.col-md-4  -->
                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        دسته بندی ها
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="text-uppercase text-white">Category 2</span>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">
                                    <a href="">
                                        <img src="https://dummyimage.com/200x100/ccc/000&text=image+link" alt=""
                                             class="img-fluid">
                                    </a>
                                    <p class="text-white">Short image call to action</p>

                                </div>
                                <!-- /.col-md-4  -->
                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        برند ها
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="text-uppercase text-white">Category 3</span>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->
                                <div class="col-md-4">

                                    <a href="">
                                        <img src="https://dummyimage.com/200x100/ccc/000&text=image+link" alt=""
                                             class="img-fluid">
                                    </a>
                                    <p class="text-white">Short image call to action</p>

                                </div>
                                <!-- /.col-md-4  -->
                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>

            </ul>
        </div>


    </nav>
</div>--}}
{{--<div class="container-fluid sticky-top">
    <nav class="yamm navbar navbar-expand-lg navbar-light bg-white mt-3">

        <div class="container w-100">
            --}}{{--BRAND--}}{{--
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa fa-home fa-2x align-middle"></i>
                {{ config('app.name')  ?? 'خانه'}}
            </a>
            --}}{{--./BRAND--}}{{--

            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse" data-target="#navbar-collapse-1"
                    aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbar-collapse-1">
                <ul class="navbar-nav">
                    --}}{{--PRODUCTS--}}{{--
                    <li class="nav-item dropdown yamm-fw">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">محصولات</a>
                        <div class="dropdown-menu p-0">
                            <!-- Content container to add padding-->
                            <div class="yamm-content">
                                <div class="row">
                                    <ul class="col-sm-3 list-unstyled">
                                        <li>
                                            <p><strong>Section Title</strong></p>
                                        </li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                    </ul>
                                    <ul class="col-sm-3 list-unstyled">
                                        <li>
                                            <p><strong>Links Title</strong></p>
                                        </li>
                                        <li><a href="#"> Link Item</a></li>
                                        <li><a href="#"> Link Item</a></li>
                                        <li><a href="#"> Link Item</a></li>
                                        <li><a href="#"> Link Item</a></li>
                                        <li><a href="#"> Link Item</a></li>
                                        <li><a href="#"> Link Item</a></li>
                                    </ul>
                                    <ul class="col-sm-3 list-unstyled">
                                        <li>
                                            <p><strong>Section Title</strong></p>
                                        </li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                    </ul>
                                    <ul class="col-sm-3 list-unstyled">
                                        <li>
                                            <p><strong>Section Title</strong></p>
                                        </li>
                                        <li>List Item</li>
                                        <li>List Item</li>
                                        <li>
                                            <ul>
                                                <li><a href="#"> Link Item</a></li>
                                                <li><a href="#"> Link Item</a></li>
                                                <li><a href="#"> Link Item</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- Accordion demo-->
                    <li class="nav-item dropdown yamm-fw"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">برند ها</a>
                        <div class="dropdown-menu p-0">
                            <div class="yamm-content">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne">Collapsible Group Item #1</button>
                                            </h2>
                                        </div>
                                        <div class="collapse show" id="collapseOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="card-text">Ut consectetur ullamcorper purus a rutrum.<br>Etiam dui nisi, hendrerit feugiat scelerisque et, cursus eu magna.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">Collapsible Group Item #2</button>
                                            </h2>
                                        </div>
                                        <div class="collapse" id="collapseTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="card-text">Ut consectetur ullamcorper purus a rutrum.<br>Etiam dui nisi, hendrerit feugiat scelerisque et, cursus eu magna.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">Collapsible Group Item #3</button>
                                            </h2>
                                        </div>
                                        <div class="collapse" id="collapseThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="card-text">Ut consectetur ullamcorper purus a rutrum.<br>Etiam dui nisi, hendrerit feugiat scelerisque et, cursus eu magna.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- Classic dropdown-->
                    <li class="nav-item dropdown yamm-fw"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">مقالات</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" tabindex="-1" href="#"> Action</a><a class="dropdown-item" tabindex="-1" href="#"> Another action</a><a class="dropdown-item" tabindex="-1" href="#"> Something else here</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" tabindex="-1" href="#"> Separated link</a>
                        </div>
                    </li>
                    <!-- Pictures-->
                    <li class="nav-item dropdown yamm-fw"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">تماس با ما</a>
                        <div class="dropdown-menu p-0">
                            <div class="yamm-content">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-2">
                                        <a href="#">
                                            <img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg">
                                        </a>
                                    </div>
                                    <div class="col-xs-6 col-sm-2"><a href="#"><img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg"></a></div>
                                    <div class="col-xs-6 col-sm-2"><a href="#"><img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg"></a></div>
                                    <div class="col-xs-6 col-sm-2"><a href="#"><img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg"></a></div>
                                    <div class="col-xs-6 col-sm-2"><a href="#"><img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg"></a></div>
                                    <div class="col-xs-6 col-sm-2"><a href="#"><img class="img-thumbnail img-fluid" alt="150x190" src="demo/img/190.jpg"></a></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>--}}

@include(config('laravel-menu.views.bootstrap-items'), ['items' => $NavBar->roots()])



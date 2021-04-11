{{--NAVBAR--}}


<div class="container-fluid">
    <div class="bg-dark text-white  text-right rounded pt-3 pb-5">
        {{--TODO : DYNAMIC TOP NAVBAR--}}
        <div class="container">
            {{--DISPLAY > MD--}}
            <div class="row d-sm-block d-none justify-content-center ">

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
            <div class="row d-block d-md-none text-center">
                <div class="col-12">
                    <a href="#" class="font-12 text-white font-weight-bolder ">
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
                            <div class="d-sm-block mb-3 d-md-inline mb-md-0">
                                <a href="{{ route('dashboard.index') }}" class="mx-1 py-1 pl-3 text-dark rounded"
                                   role="button"
                                   title=" داشبورد {{ \Illuminate\Support\Facades\Auth::user()->full_name }} "
                                >
                                    <i class="fal fa-desktop fa-2x align-middle"></i>
                                    داشبورد
                                </a>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="mx-1 py-1 px-2 text-dark rounded" role="button">
                                <i class="far fa-user-alt fa-2x align-middle"></i>
                                ورود
                            </a>

                        @endauth

                    @endif
                    {{--./USER INFO--}}


                    {{--SHOPPING CART--}}
                    <div class="d-sm-block mt-2 d-md-inline mt-md-0">
                        <a href="{{ route('cart.index') }}"
                           title="سبد خرید"
                           role="button"
                           class="bg-lightgreen mx-1 py-2 px-2 text-dark rounded"

                        >
                            <i class="far fa-shopping-cart fa-2x align-middle"></i>
                            {{--SHOW COUNT OF ITEMS IN CART--}}
                            @if(session()->get('basket'))
                                <span
                                    class="border border-dark rounded px-2 ">{{ count(session()->get('basket')) }}</span>
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
                </div>
                {{--./SHOW LOGIN AND CART--}}
            </div>
        </div>
    </div>
</div>

{{-- STICKY NAVBAR--}}
<div class="container-fluid sticky-top">
    <nav class="yamm navbar navbar-expand-lg navbar-light bg-white mt-3 p-3 shadow-sm">

        <div class="container w-100">
            {{--BRAND--}}
            <a class="navbar-brand"
               href="{{ route($NavBar->active()->link->path['route']) }}"
            >
                <i class="fal fa-home-alt fa-2x align-middle"></i>
                {{ $NavBar->active()->title }}
            </a>
            {{--./BRAND--}}

            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse" data-target="#navbar-collapse-1"
                    aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbar-collapse-1">
                <ul class="navbar-nav">


                    {{--GENERATE ITEMS--}}
                    @foreach($NavBar->all() as $menu)

                        @if($loop->first)
                            @continue;
                        @endif
                        {{--GENERATE ITEMS WITH SUB ITEMS--}}
                        @if($menu->hasChildren())
                            <li class="nav-item dropdown yamm-fw mx-2">

                                <a class="nav-link dropdown-toggle btn p-2" href="#"
                                   data-toggle="dropdown"
                                >
                                    {{ $menu->title }}
                                </a>

                                <div class="dropdown-menu p-0">
                                    <!-- Content container to add padding-->
                                    <div class="yamm-content text-center">
                                        <div class="row">
                                            <div class="col-12 mx-auto my-3">
                                                <a target="_blank"
                                                   href="{{ route($menu->link->path['route']) }}"
                                                   class="font-weight-bolder"
                                                >
                                                    {{ $menu->data['header'] }}
                                                </a>
                                            </div>
                                            @foreach($menu->children() as $menu_child)
                                                <ul class="col-sm-3 list-unstyled p-2">

                                                    <li>
                                                        <a target="_blank"
                                                           href="{{ $menu_child->link->path['url'] }}"
                                                           class="btn"
                                                        >
                                                            {{ $menu_child->title }}
                                                        </a>
                                                    </li>

                                                </ul>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else

                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>




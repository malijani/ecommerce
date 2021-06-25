{{--NAVBAR--}}
<div class="container-fluid">
    {{--TOP NAVS--}}
    {{--DISPLAY > MD--}}
    <div class="d-none d-md-block rounded-bottom bg-info-custom">
        <div class="row mr-5">
            @foreach($top_navs_medium as $top_nav_medium)
                <div class="mr-4 py-2">
                    <a href="{{ $top_nav_medium->link }}"
                       target="_blank"
                       class="text-dark-custom">
                        {{ $top_nav_medium->title }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    {{--DISPLAY < MD--}}
    <div class="d-block d-md-none rounded-bottom bg-info-custom">
        <div class="row">
            @foreach($top_navs_small as $top_nav_small)
                <div class="py-2 col text-center">
                    <a href="{{ $top_nav_small->link }}"
                       target="_blank"
                       class="text-dark-custom font-16">
                        {{ $top_nav_small->title }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    {{--./TOP NAVS--}}


    {{--LOGO--}}
    <div class="pt-md-2 rounded ">
        <div class="row align-items-center">
            {{--SHOW LOGO--}}
            @if(\Request::routeIs('home'))
                <div id="parallax_header" class="col-12 my-2 mt-md-0 text-center parallax_header">
                    {{-- <a href="{{ route('home') }}"
                        title="{{$logo->pic_alt??config('app.short.name')}}"
                     >
                         <img class="img-fluid rounded align-middle logo-image"
                              src="{{asset($logo->pic??'images/fallback/logo.png')}}"
                              alt="{{$logo->pic_alt??config('app.short.name')}}"
                         >
                     </a>--}}
                </div>
                {{--./SHOW LOGO--}}
            @endif

            {{--SHOW SEARCH BAR--}}
            <div class="col-12 col-lg-5 text-center mx-auto my-4">
                <livewire:search/>
            </div>
            {{--./SHOW SEARCH BAR--}}



            {{--SHOW LOGIN AND CART--}}
            <div class="col-12 col-lg-6 text-center mx-auto my-4">
                {{--USER INFO--}}
                @if (\Illuminate\Support\Facades\Route::has('login'))

                    @auth
                        <div class="d-sm-block mb-3 d-md-inline mb-md-0">
                            <a href="{{ route('dashboard.index') }}" class="mx-1 py-1 pl-3 text-dark rounded"
                               role="button"
                               title=" داشبورد {{ \Illuminate\Support\Facades\Auth::user()->full_name }} "
                               target="_blank"
                            >
                                <i class="fal fa-desktop-alt fa-2x align-middle"></i>

                                <span class="mr-2"
                                      dir="ltr">{{ \Illuminate\Support\Facades\Auth::user()->full_name }}</span>
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
                <div class="d-block d-md-inline my-4  mt-md-0">
                    <a href="{{ route('cart.index') }}"
                       title="سبد خرید"
                       role="button"
                       class="bg-lightgreen mx-1 py-2 px-2 text-dark rounded"
                       target="_blank"

                    >
                        <i class="far fa-shopping-cart fa-2x align-middle"></i>
                        {{--   --}}{{--SHOW COUNT OF ITEMS IN CART--}}{{--
                           @if(session()->get('basket'))
                               <span
                                   class="border border-dark rounded px-2 ">{{ count(session()->get('basket')) }}</span>
                           @else
                               <span class="border border-dark rounded px-2 ">0</span>
                           @endif--}}
                        {{--SHOW TOTAL PRICE OF CART--}}
                        @if(session()->get('total'))
                            <span
                                class="border border-dark rounded px-2 ">{{ session()->get('total')['count'] }}</span>
                            <span
                                class="mr-2"> {{ number_format(session()->get('total')['final_price']) }} تومن</span>
                        @else

                            <span class="border border-dark rounded px-2 ">0</span>
                            <span class="mr-2"> 0 تومن </span>
                        @endif
                    </a>
                </div>
            </div>
            {{--./SHOW LOGIN AND CART--}}
        </div>

    </div>
    {{--./LOGO--}}
</div>
{{--MENU--}}
<div class="container-fluid sticky-top nav_container">
    <div class="boxed bg-light">
        <div id="site-header-wrap">
            <!-- Header -->
            <header id="header" class="header header-container clearfix">
                <div class=" clearfix" id="site-header-inner">

                    <div id="logo" class="logo">
                        <a href="{{ route('home') }}"
                           title="{{config('app.short.name')}}"
                        >
                            <img
                                src="{{asset('images/asset/logos/logo.png')}}"
                                alt="{{$logo->pic_alt??config('app.short.name')}}"
                                width="107" height="24"
                                data-retina="{{asset('images/asset/logos/logo-min.png')}}"
                                data-width="107" data-height="24"
                            >
                        </a>
                    </div>
                    <!-- /.logo -->
                    <div class="mobile-button"><span></span></div>

                    <div class="nav-wrap ">
                        <nav id="main_nav" class="main_nav ">
                            <ul class="menu">
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        @if(!empty($category))
                                            <li class="@if($loop->first) active @endif">
                                                <a href="{{ route('category.show', $category['title_en']) }}">
                                                    {{ $category['title'] }}
                                                </a>
                                                @if(!empty($category['active_children']))
                                                    @include('front-v1.partials.shared.submenu_categories', ['child_categories' => $category['active_children']])
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                                @if(!empty($brands) && $brands->count())
                                    <li>
                                        <a href="{{ route('brand.index') }}">
                                            برند ها
                                        </a>
                                        <ul class="submenu">
                                            @foreach($brands as $brand)
                                                <li>
                                                    <a href="{{ route('brand.show', $brand->title_en) }}">
                                                        {{ $brand->title  }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                                @if(!empty($pages) && $pages->count())
                                    @foreach($pages as $page)
                                        <li>
                                            <a href="{{ route('page.show', $page->title_en)  }}">
                                                {{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif

                                @if(!empty($custom_pages) && count($custom_pages))
                                    @foreach($custom_pages as $page)
                                        <li>
                                            <a href="{{ $page['route'] }}">
                                                {{ $page['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif

                                @if (\Illuminate\Support\Facades\Route::has('login'))
                                    @auth
                                        <li>
                                            <a href="{{ route('dashboard.index') }}"
                                               title=" داشبورد {{ \Illuminate\Support\Facades\Auth::user()->full_name }} "
                                            >
                                                <span
                                                    class="mr-2">{{ \Illuminate\Support\Facades\Auth::user()->full_name }}</span>
                                                <i class="fal fa-user-alt fa-2x align-middle"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('login') }}"
                                               class="mx-1 py-1 px-2 text-dark rounded">
                                                <i class="far fa-user-alt fa-2x align-middle"></i>
                                                ورود
                                            </a>
                                        </li>
                                    @endauth
                                @endif

                            </ul>
                        </nav>
                        <!-- /.mainnav -->
                    </div>

                    <!-- /.nav-wrap -->
                </div>
                <!-- /.container-fluid -->
            </header>
            <!-- /header -->
        </div>
        <!-- /#site-header-wrap -->
    </div>
</div>
{{--MENU--}}


{{-- STICKY NAVBAR--}}
{{--<div class="container-fluid sticky-top">
    <nav class="yamm navbar navbar-expand-lg navbar-light bg-white mt-3 p-3 shadow-sm">

        <div class="container w-100">
            --}}{{--BRAND--}}{{--
            <a class="navbar-brand"
               href="{{ route($NavBar->active()->link->path['route']) }}"
            >
                <i class="fal fa-home-alt fa-2x align-middle"></i>
                {{ $NavBar->active()->title }}
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
                <ul class="navbar-nav p-0">


                    --}}{{--GENERATE ITEMS--}}{{--
                    @foreach($NavBar->all() as $menu)
                        --}}{{--SKIP ACTIVE : IT COMES FIRST--}}{{--
                        @if($loop->first)
                            @continue;
                        @endif
                        --}}{{--SKIP PAGE : JUST DONT WANNA BE AS DROP DOWN MENU--}}{{--
                        @if($menu->nickname == "page")
                            @continue;
                        @endif

                        --}}{{--GENERATE PARENTS WITH SUB MENUS--}}{{--
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
                        @endif
                    @endforeach

                    --}}{{--FAQ--}}{{--
                    <li class="nav-item mx-2">

                        <a class="nav-link btn p-2"
                           href="{{route($NavBar->item('faq')->link->path['route'])}}"
                           target="_blank"
                        >
                            {{ $NavBar->item('faq')->title }}

                        </a>
                    </li>

                    --}}{{--SHOW MENU PAGES--}}{{--
                    @if($NavBar->item('page')->hasChildren())
                        @foreach($NavBar->item('page')->children() as $page_child)
                            <li class="nav-item mx-2">

                                <a class="nav-link btn p-2"
                                   href="{{$page_child->link->path['url']}}"
                                   target="_blank"
                                >
                                    {{ $page_child->title }}

                                </a>
                            </li>
                        @endforeach
                    @endif

                    --}}{{--USER DASHBOARD--}}{{--
                    @auth
                        <li class="nav-item mx-2">

                            <a class="nav-link btn p-2"
                               href="{{route($NavBar->item('dashboard')->link->path['route'])}}"
                               target="_blank"
                            >
                                {{ $NavBar->item('dashboard')->title }}

                            </a>
                        </li>
                    @else
                        @if (\Illuminate\Support\Facades\Route::has('login'))
                            <li class="nav-item mx-2">
                                <a class="nav-link btn p-2"
                                   href="{{ route('login') }}"
                                >
                                    حساب کاربری
                                </a>
                            </li>
                        @endif
                    @endauth

                    --}}{{--SHOPPING CART--}}{{--
                    <li class="nav-item mx-2">

                        <a class="nav-link btn p-2"
                           href="{{route($NavBar->item('cart')->link->path['route'])}}"
                           target="_blank"
                        >
                            {{ $NavBar->item('cart')->title }}

                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>--}}

@push('scripts')
    <script>
        $(document).ready(function () {
            /*SET LOGO AS PARALLAX_HEADER*/
            let parallax_header = $("#parallax_header");
            parallax_header.css("background-image", "url({{asset($logo->pic??'images/fallback/logo.png')}})")

            /*DISABLE LINK HREF EVENT ON NAV HEADINGS*/
            /*let menu_headers = $(".submenu").siblings();
            menu_headers.on('click touch', function(e){
                e.preventDefault();
            });*/

        });
    </script>

@endpush


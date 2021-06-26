{{--HEADER ITEMS--}}
<div class="container-fluid">

    {{--TOP NAVS--}}
    {{--DISPLAY > MD--}}
    <div class="d-none d-md-block rounded-bottom bg-light">
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
    <div class="d-block d-md-none rounded-bottom bg-light">
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



    <div class="pt-md-2 rounded ">
        <div class="row align-items-center">

            {{--SHOW LOGO--}}
            @if(\Request::routeIs('home'))
                <div id="parallax_header"
                     class="col-12 my-2 mt-md-0 text-center parallax_header"
                     title="{{ $logo->pic_alt ??  config('app.short.name') }}"
                >
                </div>
            @endif
            {{--./SHOW LOGO--}}

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
                {{--./SHOPPING CART--}}
            </div>
            {{--./SHOW LOGIN AND CART--}}

        </div>
        {{--./ROW--}}
    </div>
</div>
{{--./HEADER ITEMS--}}

{{--MENU--}}
<div class="sticky-top nav_container">
    {{--BOXED--}}
    <div class="boxed bg-light">
        {{--HEADER WRAPPER--}}
        <div id="site-header-wrap">
            {{--HEADER--}}
            <header id="header" class="header header-container clearfix">
                {{--CONTAINER FLUID--}}
                <div class="container-fluid clearfix" id="site-header-inner">
                    {{--NAVBAR LOGO--}}
                    <div id="logo" class="logo">
                        <a href="{{ route('home') }}"
                           title="رفتن به صفحه اصلی {{config('app.short.name')}}"
                        >
                            <img
                                src="{{asset('images/asset/logos/logo.png')}}"
                                alt="{{$logo->pic_alt??config('app.short.name')}}"
                                width="107" height="24"
                                data-retina="{{asset('images/asset/logos/logo-min.png')}}"
                                data-width="107" data-height="24"
                                loading="lazy"
                            >
                        </a>
                    </div>
                    {{--./NAVBAR LOGO--}}
                    <div class="mobile-button"><span></span></div>

                    {{--NAVBAR WRAPPER--}}
                    <div class="nav-wrap ">
                    {{--MAIN NAVBAR--}}
                        <nav id="main_nav" class="main_nav ">
                            <ul class="menu">
                                {{--SHOW MULTI LEVEL ITEMS : CATEGORIES--}}
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
                                {{--./SHOW MULTI LEVEL ITEMS : CATEGORIES--}}

                                {{--SHOW ONE LEVEL ITEMS : BRANDS--}}
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
                                {{--./SHOW ONE LEVEL ITEMS : BRANDS--}}

                                {{--SHOW SINGLE ITEMS : PAGES--}}
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
                                                <i class="fal fa-user-alt align-middle"></i>
                                                داشبورد
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('login') }}"
                                               title="ورود یا ایجاد حساب کاربری در {{ config('app.short.name') }}"
                                            >
                                                <i class="far fa-user-alt align-middle"></i>
                                                ورود
                                            </a>
                                        </li>
                                    @endauth
                                @endif
                                {{--./SHOW SINGLE ITEMS : PAGES--}}
                            </ul>
                        </nav>
                        {{--./MAIN NAVBAR--}}
                    </div>
                    {{--./NAVBAR WRAPPER--}}
                </div>
                {{--./CONTAINER FULID--}}
            </header>
            {{--./HEADER--}}
        </div>
        {{--./HEADER WRAPPER--}}
    </div>
    {{--./BOXED--}}
</div>
{{--./MENU--}}

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


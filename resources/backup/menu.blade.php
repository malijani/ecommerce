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

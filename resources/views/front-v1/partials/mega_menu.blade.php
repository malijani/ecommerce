<div class="menu__main_wrapper mt-4 sticky-top">
    <nav class="menu__navbar">

        <div class="menu__brand_and_icon">
            <a href="{{ route('home') }}"
               title="رفتن به صفحه اصلی {{config('app.short.name')}}"
               class="menu__navbar_brand mr-3"
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

            <button type="button"
                    class="menu__navbar_toggle btn ml-3"
            >
                <i class="fal fa-bars"></i>
            </button>
        </div>

        <div class="menu__navbar_collapse">
            <ul class="menu__navbar_nav text-right">
                {{--CATEGORIES--}}
                @if(!empty($categories))
                    @foreach($categories as $category)
                        @if(!empty($category))

                            <li>
                                <a href="javascript:void(0)" class="menu__menu_link">

                                    {{ $category['title'] }}

                                    <span class="menu__drop_icon">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                </a>


                                <div class="menu__sub_menu py-3">
                                    @if(!empty($category['active_children']))
                                        
                                        @foreach($category['active_children'] as $sub_cat)
                                            <div class="menu__sub_menu_item">
                                                <h4>
                                                    <a href="{{ route('category.show', $sub_cat['title_en']) }}">
                                                        {{ $sub_cat['title'] }}
                                                    </a>
                                                </h4>

                                                @if(!empty($sub_cat['children_recursive']))
                                                    <ul>
                                                        @include('front-v1.partials.shared.submenu_categories', ['child_categories' => $sub_cat['children_recursive']])
                                                    </ul>
                                                @endif

                                            </div>
                                        @endforeach


                                    @endif

                                    <div class="menu__sub_menu_item p-0">
                                        <a href="@if($loop->first){{ route('product.index') }} @else {{ route('blog.index') }} @endif">
                                            <img src="{{ asset($category['pic'] ?? 'images/fallback/category.png') }}"
                                                 alt="{{ $category['pic_alt'] ?? $category['title_en']}}"
                                                 class="img img-fluid"
                                            >
                                        </a>
                                    </div>
                                </div>


                            </li>

                        @endif
                    @endforeach
                @endif
                {{--./CATEGORIES--}}

                {{--BRANDS--}}
                @if(!empty($brands) && $brands->count())

                    <li>
                        <a href="javascript:void(0)"
                           class="menu__menu_link"
                        >
                            برند ها
                            <span class="menu__drop_icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </a>

                        <div class="menu__sub_menu py-3 ">
                            <div class="menu__sub_menu_item px-1 text-right">
                                <ul>
                                    <li>
                                        <a href="{{ route('brand.index') }}">
                                            <h4 class="text-dark">
                                                مشاهده تمامی برند ها
                                            </h4>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            @foreach($brands as $brand)
                                <div class="menu__sub_menu_item px-1 text-right">
                                    <ul>
                                        <li>
                                            <a href="{{ route('brand.show', $brand->title_en) }}">
                                                <p class="text-dark font-18">
                                                    {{ $brand->title  }}
                                                    | {{ str_replace('-', ' ', $brand->title_en) }}
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach

                        </div>
                    </li>
                @endif
                {{--./BRANDS--}}

                {{--PAGES--}}
                @if(!empty($pages) && $pages->count())
                    @foreach($pages as $page)
                        <li>
                            <a href="{{ route('page.show', $page->title_en)  }}">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                @endif
                {{--./PAGES--}}

                {{--CUSTOM PAGES--}}
                @if(!empty($custom_pages) && count($custom_pages))
                    @foreach($custom_pages as $page)
                        <li>
                            <a href="{{ $page['route'] }}">
                                {{ $page['title'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
                {{--./CUSTOM PAGES--}}

                {{--LOGIN & DASHBOARD--}}
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
                {{--./LOGIN & DASHBOARD--}}

            </ul>
        </div>
    </nav>
</div>



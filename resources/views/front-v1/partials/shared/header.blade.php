

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
    <div class="d-block d-md-none rounded-bottom">
        <div class="row">
            @foreach($top_navs_small as $top_nav_small)
                <div class="col py-2 text-center bg-light">
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
            {{--@if(\Request::routeIs('home'))
                <div id="parallax_header"
                     class="col-12 my-2 mt-md-0 text-center parallax_header"
                     title="{{ $logo->pic_alt ??  config('app.short.name') }}"
                >
                    <img src="{{asset($logo->pic??'images/fallback/logo.png')}}"
                         alt="{{ $logo->pic_alt ?? config('app.short.name') }}"
                         id="parallax_header_img"
                    >
                </div>
            @endif--}}
            {{--./SHOW LOGO--}}

            {{--SHOW SEARCH BAR--}}
            <div class="col-12 col-lg-5 text-center mx-auto my-4">
                <livewire:search/>
            </div>
            {{--./SHOW SEARCH BAR--}}

            {{--SHOW LOGIN AND CART--}}
            <div class="col-12 col-lg-6 text-center mx-auto">
                {{--USER INFO--}}
                @if (\Illuminate\Support\Facades\Route::has('login'))
                    @auth
                        <div class="d-sm-block my-4 d-md-inline my-md-0">
                            <a href="{{ route('dashboard.index') }}" class="mx-1 py-1 pl-3 text-dark rounded"
                               role="button"
                               title=" داشبورد {{ auth()->user()->name_or_mobile }} "
                            >
                                <i class="fal fa-desktop-alt fa-2x align-middle"></i>

                                <span class="mr-2"
                                      dir="ltr">{{ auth()->user()->name_or_mobile }}</span>
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
                <div class="d-block d-md-inline my-4  my-md-0" id="header_basket_total">
                    @include('front-v1.partials.shared.basket_total')
                </div>
                {{--./SHOPPING CART--}}
            </div>
            {{--./SHOW LOGIN AND CART--}}

        </div>
        {{--./ROW--}}
    </div>
</div>
{{--./HEADER ITEMS--}}

{{--STYLES AND SCRIPTS INCLUDED HERE!--}}
@include('front-v1.partials.mega_menu')


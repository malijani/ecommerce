{{--DISPLAY > MD--}}
<div class="container-fluid d-none d-md-block bg-grey-300 rounded-bottom ">
    <div class="">
        <div class="row mr-5">

            @foreach($top_navs_medium as $top_nav_medium)
                <div class="mr-4 py-2">
                    <a href="{{ $top_nav_medium->link }}"
                       target="_blank"
                       class="text-cyan-600-dark">
                        {{ $top_nav_medium->title }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{--DISPLAY < MD--}}
<div class="container-fluid d-block d-md-none rounded-bottom bg-grey-300">
    <div class="">
        <div class="row">

            @foreach($top_navs_small as $top_nav_small)
                <div class="py-2 col text-center">
                    <a href="{{ $top_nav_small->link }}"
                       target="_blank"
                       class="text-cyan-600-dark">
                        {{ $top_nav_small->title }}
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</div>

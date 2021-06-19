{{--SHOW LOGO--}}
{{--DISPLAY > MD--}}
<div class="d-none d-md-block col-md-4 text-center">
    <a href="{{ route('home') }}">
        <img class="img-fluid rounded align-middle" src="{{asset($logo->pic??'images/fallback/logo.png')}}"
             alt="{{$logo->pic_alt??config('app.short.name')}}">
    </a>
</div>
{{--DISPLAY < MD--}}
<div class="d-sm-block d-md-none col-md-1 text-center py-3 border-bottom">
    <a href="{{ route('home') }}">
        <img class="img-fluid rounded align-middle" src="{{asset($logo->pic??'images/fallback/logo.png')}}"
             alt="{{$logo->pic_alt??config('app.short.name')}}">
    </a>
</div>
{{--./SHOW LOGO--}}

@if(isset($footer_static_navs->links) && $footer_static_navs->links->count() > 0)
    @foreach($footer_static_navs->links as $footer_nav_link)
        <div class="col-12 col-md @if($loop->first) mt-0 @else mt-3 mt-md-0 @endif">
            <a href="{{ $footer_nav_link->link }}"
               class="text-lime-a100"
            >
                {{ $footer_nav_link->title }}
            </a>
        </div>
    @endforeach
@else
    <div class="col-12">
        <p class="text-lime-a100 mt-3">
            تمامی حقوق مادی و معنوی این وبسایت متعلق به {{ config('app.short.name') }} می‌باشد و هرگونه
            سوء
            استفاده تحت پیگرد قانونی قرار میگیرد؛ {{ config('app.short.name') }} هیچ شعبه دیگری ندارد.
        </p>
    </div>
@endif

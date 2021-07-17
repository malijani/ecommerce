{{--@dd($page)--}}
<div class="col-12 px-0 px-lg-3 @if($loop->first) mt-lg-3 @elseif($loop->last) mb-3 @endif text-right">
    <a href="{{ route('page.show', $page->title_en) }}"
       class="text-dark"
       title="مشاهده صفحه {{ $page->title }}"
    >
        <div class="card p-0 border-radius-0 shadow-sm mt-3 border-0">
            <div class="card-header pb-0">
                <h4 class="card-title">
                    {{ $page->title }}
                </h4>
            </div>
            <div class="card-body px-1 p-md-3">
                <p class="card-text d-inline">
                    {{ $page->content_short }}
                </p>
                <a href="{{ route('page.show', $page->title_en) }}"
                   title="مشاهده صفحه {{ $page->title }}"
                >ادامه صفحه...</a>
            </div>
        </div>
    </a>
</div>


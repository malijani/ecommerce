{{--SHOW BASKET BRIEF--}}
<div class="d-none d-lg-block col-lg-2">
    <div class="row rounded py-2">
        <div class="col-12">
            <aside class="basket_aside">
                @if(!empty(session()->get('basket')))
                    @foreach(session()->get('basket') as $basket_item)
                        {{ $basket_item['title'] }}
                    @endforeach
                @else
                    محصولی وجود ندارد
                @endif
            </aside>
        </div>
    </div>
</div>
{{--./SHOW BASKET BRIEF--}}

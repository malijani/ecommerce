@if($footer_items->count()>0)
    @foreach($footer_items as $footer_item)
        @if($footer_item->links->count() > 0)
            <div class="col-12 col-md @if($loop->first) mt-0 @else mt-3 @endif mt-md-1">
                <h5>
                    {{ $footer_item->title }}
                </h5>
                <hr class="w-50">
                <div class="row">

                    @foreach($footer_item->links as $footer_item_link)
                        <div class="col-12 mt-3">
                            <a href="{{ $footer_item_link->link }}"
                               class="text-dark"
                            >
                                {{ $footer_item_link->title }}
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif
    @endforeach
@endif

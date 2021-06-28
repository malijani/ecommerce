@if(!empty($items) && $items->count())
    <div class="row mt-5 py-3 rounded align-items-center justify-content-center bg-light">
        @foreach($items as $item)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg my-3 my-md-4 text-center">
                <div class="row align-items-center">
                    <div class="col-12">
                        <a href="{{ $item->link }}"
                           title="{{ $item->title }}"
                        >
                            <img src="{{ asset($item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="img img-fluid rounded page_img_menu"
                                 loading="lazy"
                            >
                        </a>
                    </div>
                    <div class="col-12 mt-2 ">
                        <a href="{{ $item->link }}"
                           class="text-dark"
                        >
                            <span class="font-weight-bolder">{{ $item->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

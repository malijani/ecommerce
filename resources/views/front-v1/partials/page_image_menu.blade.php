@if(!empty($items) && $items->count())
    <div class="row mt-5 py-2 bg-white rounded align-items-center justify-content-center">
        @foreach($items as $item)
            <div class="col-12 col-md my-2 my-md-0 text-center">
                <div class="row align-items-center">
                    <div class="col-12">
                        <a href="{{ $item->link }}"
                           title="{{ $item->title }}"
                        >
                            <img src="{{ asset($item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="img img-fluid h-100"
                            >
                        </a>
                    </div>
                    <div class="col-12 mt-2 ">
                        <a href="{{ $item->link }}"
                           class="text-dark"
                        >
                            <span class="font-16">{{ $item->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

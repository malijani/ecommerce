@if(isset($items))
    <div class="row my-2 py-3 bg-white rounded">
        @foreach($items as $item)
            <div class="col-6 col-sm-4 col-md my-2 my-md-0 text-center">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ $item->link }}"
                           title="{{ $item->title }}"
                        >
                            <img src="{{ asset($item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="img img-fluid"
                            >
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="{{ $item->link }}"
                           class="text-dark"
                        >
                            <span class="font-weight-bold font-12">{{ $item->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

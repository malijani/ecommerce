@if(isset($items))
    <div class="row my-2 p-0 align-items-center justify-content-center">
        @foreach($items as $item)
            <div class="col-12 col-md-6 my-2 my-md-0">
                <a href="{{ $item->link }}">
                    <img src="{{ asset($item->image) }}"
                         alt="{{ $item->title }}"
                         class="img img-fluid rounded"
                    >
                </a>
            </div>
        @endforeach
    </div>
@endif

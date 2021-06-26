@if(isset($items))
    <div class="row mt-3 align-items-center justify-content-center bg-light">
        @foreach($items as $item)
            <div class="col-11 col-md-5 mx-1 my-1 my-md-0 p-1 text-center align-middle">
                <a href="{{ $item->link }}">
                    <img src="{{ asset($item->image) }}"
                         alt="{{ $item->title }}"
                         class="img img-fluid rounded"
                         loading="lazy"
                    >
                </a>
            </div>
        @endforeach
    </div>
@endif

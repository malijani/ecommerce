<div class="row mt-3 align-items-center justify-content-around bg-light">
    @foreach($items as $item)
        <div class="col-12 col-md-12 col-lg my-lg-0 py-2 text-center align-middle">
            <a href="{{ $item->link }}">
                <img src="{{ asset($item->image) }}"
                     alt="{{ $item->title }}"
                     class="img img-fluid rounded big_image_menu w-100"
                     loading="lazy"
                >
            </a>
        </div>
    @endforeach
</div>


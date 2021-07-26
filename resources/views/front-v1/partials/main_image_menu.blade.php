<div class="row mt-3 py-4 py-md-3 bg-light rounded">
    @foreach($items as $item)
        <div class="col-6 col-md my-3 my-md-0 text-center">
            <div class="row">
                <div class="col-12">
                    <a href="{{ $item->link }}"
                       title="{{ $item->title }}"
                    >
                        <img src="{{ asset($item->image) }}"
                             alt="{{ $item->title }}"
                             class="img img-fluid"
                             loading="lazy"
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

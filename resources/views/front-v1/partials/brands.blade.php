@foreach($brands as $brand)
<div class="px-3 my-2 col-sm-12 col-md-4 col-lg-3 col-xl-3">
    <a href="{{ route('brand.show', $brand->title_en) }}"
       class="card d-flex flex-row justify-content-between align-items-center font-14 font-weight-bolder text-dark">
        <div class="col-8 text-center">{{ $brand->title }}</div>
        <div class="col-4 px-0">
            <img class="img-fluid"
                 src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                 alt="{{ $brand->pic_alt ?? $brand->title_en }}"
            >
        </div>
    </a>
</div>
@endforeach

<div class="container-fluid">
    <div class="row">
        @foreach($brands as $brand)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3 px-4 my-2">
                <a href="{{ route('brand.show', $brand->title_en) }}"
                   title="مشاهده جزییات برند {{ $brand->title }}"
                >
                    <div
                        class="row  align-items-center justify-content-center pt-1 text-center text-dark bg-light rounded">
                        <div class="col-6">
                                <span>
                                    {{ $brand->title }}
                                </span>
                            <br>
                            <span class="font-14 text-muted">
                                    {{ str_replace('-', ' ', $brand->title_en) }}
                                </span>
                        </div>
                        <div class="col-6">
                            <img src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                                 alt="{{ $brand->pic_alt ?? $brand->title_en }}"
                                 class="img img-fluid h-100 w-100 rounded"
                            >
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>



@foreach($categories as $category)
<div class="px-3 my-2 col-sm-12 col-md-4 col-lg-3 col-xl-3">
    <a href="{{ route('category.show', ['category'=>$category->title_en]) }}" class="card d-flex flex-row justify-content-between align-items-center font-14 text-dark">
        <div class="col-8 text-center font-weight-bolder">{{ $category->title }}</div>
        <div class="col-4 px-0">
            <img class="img-fluid"
                 src="{{ asset($category->pic ?? 'images/fallback/category.png') }}"
                 alt="{{ $category->pic_alt ?? $category->title_en }}"
            >
        </div>
    </a>
</div>

@endforeach

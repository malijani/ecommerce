@foreach($categories as $category)
<div class="px-1 col-sm-12 col-md-3 col-lg-2 col-xl-2 my-1">
    <a href="{{ route('category.show', ['category'=>$category->title_en]) }}" class="card d-flex flex-row justify-content-between align-items-center font-14 text-dark">
        <div class="col-8">{{ $category->title }}</div>
        <div class="col-4 px-0">
            <img class="img-fluid"
                 src="{{ asset($category->pic ?? 'images/fallback/category.png') }}"
                 alt="{{ $category->pic_alt ?? $category->title_en }}"
            >
        </div>
    </a>
</div>

@endforeach

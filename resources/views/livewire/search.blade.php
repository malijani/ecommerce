<div>

    {{--TODO : ADD PROFESSIONAL SEARCH PAGE FOR SITE--}}
    <div class="search_input_group">

        <input
            id="search_input"
            name="q"
            type="text"
            class="search_input form-control"
            wire:model.debounce.1s="search"
            placeholder=" "
        >
        <label for="search_input"
               class="search_input_label"
        >
            جستجوی محصول، مقاله، برند و ...
            <i class="fal fa-search align-middle text-dark"></i>
        </label>
    </div>

    @if(!empty($products) && $products->count() ||!empty($articles)  && $articles->count()|| !empty($brands) && $brands->count() || !empty($categories) && $categories->count())
        <div class="rounded-bottom  shadow-sm search-result-wrapper position-absolute py-4 bg-light">
            @if(isset($products))
                @foreach($products as $product)
                    @include('front-v1.partials.search_result', ['route'=>route('product.show', $product->title_en), 'img_src'=>asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png'), 'img_alt'=>$product->files()->defaultFile()->title, 'title'=>$product->title])
                @endforeach
            @endif
            @if(isset($articles))
                @foreach($articles as $article)
                    @include('front-v1.partials.search_result', ['route'=>route('blog.show', $article->title_en), 'img_src'=>asset($article->pic ?? 'images/fallback/article.png'), 'img_alt'=>$article->pic_alt ?? $article->title_en, 'title'=>$article->title])
                @endforeach
            @endif
            @if(isset($brands))
                @foreach($brands as $brand)
                    @include('front-v1.partials.search_result', ['route'=>route('brand.show', $brand->title_en), 'img_src'=>asset($brand->pic ?? 'images/fallback/brand.png'), 'img_alt'=>$brand->pic_alt ?? $brand->title_en, 'title'=>$brand->title])
                @endforeach
            @endif

            @if(isset($categories))
                @foreach($categories as $category)
                    @include('front-v1.partials.search_result', ['route'=>route('category.show', $category->title_en), 'img_src'=>asset($category->pic ?? 'images/fallback/category.png'), 'img_alt'=>$category->pic_alt ?? $category->title_en, 'title'=>$category->title])
                @endforeach
            @endif
        </div>
    @endif


</div>

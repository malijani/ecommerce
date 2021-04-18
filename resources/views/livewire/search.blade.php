<div>

    <div class="input-group">
        <input
            name="q"
            {{--id="query"--}}
            type="text"
            class="form-control"
            wire:model.debounce.1s="search"
            placeholder="جست و جوی محصول، مقاله، برند و ..."
        >
        <div class="input-group-prepend">
            <div
                class="input-group-text"
                id="search-button"
            >
                <i class="fa fa-search"></i>
            </div>
        </div>
    </div>


    @if(isset($products) || isset($articles) || isset($brands))
        <div class="container">
            <div class="row search-result-wrapper position-absolute py-4 bg-grey-50 rounded-bottom shadow-sm">
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


        </div>

    @endif

</div>

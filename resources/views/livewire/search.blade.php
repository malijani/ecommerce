<div>
    <div class="input-group">
        <input type="text" class="form-control"
               wire:model="search"
               placeholder="جست و جوی محصول، مقاله، دسته بندی، برند و ..."
        >
        <div class="input-group-prepend">
            <div class="input-group-text" id="search-button">
                <i class="fa fa-search"></i>
            </div>
        </div>
    </div>


    @if(isset($products))
        <div class="container">
            <div class="row results position-absolute py-4 bg-grey-50 rounded-bottom shadow-sm" style="z-index:1022;">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->title_en) }}"
                       class="text-dark font-weight-bolder font-16"
                    >
                        <div class="col-12 pt-2">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-12 col-sm-4 col-md-3 text-right">
                                    <img class="img img-fluid rounded"
                                         src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png') }}"
                                         alt="{{$product->files()->defaultFile()->title}}"
                                    >
                                </div>
                                <div class="col-md-9 text-center text-md-right">
                                    {{ $product->title }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif


</div>

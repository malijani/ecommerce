<div class="col-md mt-3 mt-md-0 pt-md-1">
    <h4 class="font-16 font-weight-bolder">
        محصولات پیشنهادی
    </h4>
    <hr class="w-75">
    <div class="row justify-content-center align-items-center">
        @if($footer_product_proposals->count()>0)
            @foreach($footer_product_proposals as $product_proposal)
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-4">
                            <a href="{{ $product_proposal->getLink() }}">
                                <img src="{{ asset($product_proposal->files()->defaultFile()->link) }}"
                                     alt="{{ $product_proposal->files()->defaultFile()->title }}"
                                     class="img img-fluid rounded"
                                >
                            </a>
                        </div>
                        <div class="col-8 mt-1">
                            <a href="{{ $product_proposal->getLink() }}"
                               class="text-dark"
                            >
                                <p class="font-16 font-weight-bolder">
                                    {{ $product_proposal->title }}
                                    | {{ str_replace('-', ' ', $product_proposal->title_en) }}
                                </p>
                                <p class="font-16">
                                    {{ number_format($product_proposal->discount_price) }} تومن
                                </p>
                                <div class="font-8 text-right">
                                    @include('front-v1.partials.rating_stars', ['model'=>$product_proposal])
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        @else
            <div class="col-12 mt-3">
                <p class="font-16 font-weight-bolder">
                    محصولی جهت پیشنهاد وجود ندارد!
                </p>
            </div>
        @endif
    </div>
</div>

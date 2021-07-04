{{--SHOW BASKET BRIEF--}}
<div class="d-none d-lg-block col-lg-2">
    <div class="row rounded py-2">
        <div class="col-12">
            <aside class="basket_aside">
                <div class="row">

                    @if(!empty(session()->get('basket')))
                        @foreach(session()->get('basket') as $basket_item)
                            <div class="col-12">
                                <div class="card text-center my-1 py-3 basket_aside_card">
                                    <img class="card-img-top img img-fluid img-responsive product_basket_aside_image"
                                         src="{{ asset($basket_item['pic']) }}"
                                         alt="{{ $basket_item['title'] }}">
                                    <div class="card-body text-dark">
                                        <div class="row">
                                            <div class="col-12 text-center"
                                                 id=""
                                            >
                                                <h5 class="card-title font-18">
                                                {{ $basket_item['title'] }}
                                                </h5>
                                                <h6 class="font-14">
                                                    {{ $basket_item['title_en'] }}
                                                </h6>
                                            </div>
                                        </div>

                                        <p class="card-text">{{ $basket_item['quantity'] }}</p>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    <div class="col-12">
                            <button role="link"
                                    class="btn basket_aside_button w-100"
                            >
                                <i class="fal fa-shopping-cart"></i>
                                رفتن به سبد خرید
                            </button>
                    </div>
                    @else
                        محصولی وجود ندارد
                    @endif

                </div>
            </aside>
        </div>
    </div>
</div>
{{--./SHOW BASKET BRIEF--}}

@push('scripts')
    <script>
        $(document).ready(function(){
            let basket_link = $(".basket_aside_button");
            basket_link.on('click', function(){
                window.location.replace("{{ route('cart.index') }}")
            });
        });
    </script>
@endpush

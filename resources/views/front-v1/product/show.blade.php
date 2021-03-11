@extends('layouts.app')

@section('page-styles')

@endsection

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('products.product', $product) }}


    <div class="container my-3 rounded">
        <div class="row px-0 bg-white py-3">
            {{--PRODUCT IMAGES--}}
            <div class="col-lg-6 mb-5 ">
                <div class="row">
                    <div class="col-2 product-thumbnails">
                        @foreach($product->files as $file)
                            <img src="{{ asset($file->link) }}"
                                 alt="{{ $file->title }}"
                                 class="img-thumbnail img-bordered-sm"
                                 id="product-thumbnail-{{$loop->index}}"
                            >
                        @endforeach
                    </div>

                    <div class="col-10" id="main-image-container">
                        <img src="{{ asset($product->files()->defaultFile()->link) }}"
                             alt="{{ $product->files()->defaultFile()->title }}"
                             id="main-image"
                             class="img-fluid product-image"
                        >
                    </div>

                </div>
            </div>

            {{-- PRODUCT MAIN CONTENT--}}
            <div class="col-lg-6 product-details pl-md-5 ftco-animate fadeInUp ftco-animated">
                <h3>{{ $product->title }}</h3>
                <div class="rating d-flex">
                    <p class="text-left mr-4">
                        {{--TODO : IMPLEMENT RATING--}}
                        <a href="#" class="mr-2">5.0</a>
                        <a href="#"><span class="fa fa-star-o"></span></a>
                        <a href="#"><span class="fa fa-star-o"></span></a>
                        <a href="#"><span class="fa fa-star-o"></span></a>
                        <a href="#"><span class="fa fa-star-o"></span></a>
                        <a href="#"><span class="fa fa-star-o"></span></a>
                    </p>
                    <p class="text-left mr-4">
                        <a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">رای</span></a>
                    </p>
                    <p class="text-left">
                        <a href="#" class="mr-2" style="color: #000;">500 <span
                                style="color: #bbb;">فروخته شده</span></a>
                    </p>
                </div>
                <p class="price">
                    @if($product->price_type=="0" && $product->discount_percent != "0")
                        <span>{{$product->show_discount_price}} تومان</span>
                        <small class="discount">{{ $product->show_price}}</small>
                        <span class="discount-label font-12">
                            {{ $product->discount_percent }}%  تخفیف
                            </span>
                    @elseif($product->price_type=="1")
                        <span>{{$product->show_price}} تومان</span>
                    @else
                        <span class="badge badge-info">
                                <i class="fa fa-phone"></i>
                                تماس بگیرید
                            </span>
                    @endif
                </p>
                <p>
                    {{ $product->short_text }}
                </p>


                <div class="col-12">
                    {{--TODO : SEND ORDER FORM TO OrderController--}}
                    <form action="">

                        {{--CUSTOMIZE ORDER WITH ATTRIBUTES--}}
                        @if(count($attributes))
                            <div class="form-group row">
                                @foreach($attributes as $attr_id=>$attr_values)
                                    <div class="col-md-12 ">
                                        <label for="order-attribute-{{ $attr_id }}"
                                               class="col-form-label col-md-2 text-center">{{ key($attr_values)}}
                                            :</label>
                                        <div class="col-md-6 mt-1 text-right">
                                            <select name="order-attribute-{{$attr_id}}"
                                                    id="order-attribute-{{$attr_id}}"
                                                    class="form-control"
                                            >
                                                @foreach($attr_values as $attr_value)
                                                    @foreach($attr_value as $attribute)
                                                        <option value="{{ $loop->index  }}"> {{ $attribute }} </option>
                                                    @endforeach
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        @endif

                        {{--SHOW DYNAMIC ENTITY--}}
                        <div class="form-group row">
                            <label for="order-product-count"
                                   class="text-dark">موجودی:
                                <span id="entity" class="font-weight-bolder">{{ $product->entity - 1 }}</span>
                                عدد</label>
                        </div>

                        {{--SET AMOUNT OF PRODUCT ORDER--}}
                        <div class="form-group row">

                            <button type="button"
                                    role="link"
                                    class="btn btn-sm btn-outline-success form-control m-1"
                                    id="add-product-count"
                            >
                                <i class="fa fa-plus"></i>
                            </button>


                            <input
                                class="text-center form-control font-weight-bolder"
                                name="order-product-count"
                                type="number"
                                id="order-product-count"
                                value="{{ old("order-product-count") ?? 1 }}"
                                min="1"
                                max="{{ $product->entity - 1 }}"
                            >

                            <button type="button"
                                    class="btn btn-sm btn-outline-danger form-control m-1"
                                    id="sub-product-count"
                            >
                                <i class="fa fa-minus"></i>
                            </button>


                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary form-control"
                        >
                            اضافه به سبد خرید
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>{{--container--}}




@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/zoom/jquery.zoom.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            let mainImg = $('#main-image');
            /*INITIALIZE ZOOM*/
            mainImg.wrap('<span style="display:inline-block"></span>')
                .css('display', 'block')
                .parent()
                .zoom();
            /*CHANGE PRODUCT IMAGE & SET ZOOM ON CHANGE*/
            @foreach($product->files as $file)
            $("#product-thumbnail-" +{{$loop->index}}).on('click', function () {
                mainImg.trigger('zoom.destroy');
                mainImg.attr('src', $(this).attr('src'))
                    .wrap('<span style="display:inline-block"></span>')
                    .css('display', 'block')
                    .parent()
                    .zoom();
            });
            @endforeach


            /*USER ORDER HANDLING*/
            let orderProductCount = $("#order-product-count");
            let addProductCount = $("#add-product-count");
            let subProductCount = $("#sub-product-count");
            let entity = $("#entity");
            let productCount = parseInt(entity.text());
            let count = productCount;
            addProductCount.on('click', function () {
                if (orderProductCount.val() <= count) {
                    let newValue = parseInt(orderProductCount.val());
                    orderProductCount.val(++newValue);
                    entity.text(--productCount)
                }
            });

            subProductCount.on('click', function () {
                if (orderProductCount.val() > 1) {
                    let newValue = parseInt(orderProductCount.val());
                    orderProductCount.val(--newValue);
                    entity.text(++productCount)
                }
            });


            console.log()
        });
    </script>

@endsection

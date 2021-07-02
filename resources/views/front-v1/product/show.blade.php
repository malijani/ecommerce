@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('front-v1/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-v1/owl-carousel/assets/owl.theme.default.min.css') }}">
@endsection

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('products.product', $product) }}


    <div class="container-fluid my-3 rounded">
        <div class="row my-2">
            @include('front-v1.partials.shared.basket_aside')

            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg rounded py-md-4">

                <div class="row my-2">
                    {{--SHOW PRODUCT IMAGES--}}
                    <div class="col-12 col-md-6 mb-5 ">
                        <div class="row align-items-center">
                            {{--SELECTED IMAGE--}}
                            <div class="col-12 rounded" id="main-image-container">
                                <img src="{{ asset($product->files()->defaultFile()->link) }}"
                                     alt="{{ $product->files()->defaultFile()->title }}"
                                     id="main-image"
                                     class="img-fluid product-image rounded w-100 h-100"
                                     style="max-height: 600px; object-fit: cover; overflow-y: hidden"
                                >
                            </div>
                            {{--./SELECTED IMAGE--}}

                            {{--OWL THUMBNAILS--}}
                            <div class="col-12 mt-2 mt-md-0">
                                <div class="row align-items-center justify-content-center m-0 text-center">

                                    <div class="oc_product_images_prev cursor-pointer col-1 mx-auto text-center">
                                        <i class="fal fa-angle-right fa-2x align-middle"></i>
                                    </div>


                                    <div class="owl-carousel product-thumbnails col-9 mx-auto"
                                         id="oc_product_images"
                                    >
                                        @foreach($product->files as $file)
                                            <img src="{{ asset($file->link) }}"
                                                 alt="{{ $file->title }}"
                                                 class="img-thumbnail"
                                                 id="product-thumbnail-{{$loop->index}}"
                                                 style="max-height: 100px; overflow-y: hidden; object-fit: cover"
                                            >
                                        @endforeach

                                    </div>

                                    <div class="oc_product_images_next cursor-pointer col-1 mx-auto text-center">
                                        <i class="fal fa-angle-left fa-2x align-middle"></i>
                                    </div>

                                </div>
                            </div>
                            {{--./OWL THUMBNAILS--}}

                        </div>

                    </div>
                    {{--./SHOW PRODUCT IMAGES--}}

                    {{--SHOW BRIEF AND PURCHASE--}}
                    <div class="col-12 col-md-6">
                        <div class="row">
                            {{--SHOW TITLE--}}
                            <div class="col-12 text-center">
                                <h1 class="font-20 text-dark">
                                    {{ $product->title . ' | ' . str_replace('-', ' ', $product->title_en)}}
                                </h1>
                            </div>
                            {{--./SHOW TITLE--}}

                            {{--SHOW PRICE--}}
                            <div
                                class="price col-12 col-md-11 mx-auto my-md-3 py-3 font-22 text-center bg-light rounded">
                                @if(in_array($product->price_type, [0,1]))

                                    @if(!empty($product->discount_percent))
                                        <sup class="discount">
                                            {{ number_format($product->price) }}
                                        </sup>
                                    @endif
                                    <span>
                                        {{ number_format($product->final_price) . ' تومن '}}
                                    </span>
                                @elseif($product->price_type == 2)
                                    <span>
                                        <i class="fal fa-phone"></i>
                                        تماس بگیرید
                                    </span>
                                @endif
                                @if(!empty($product->discount_percent))
                                    <span class="badge badge-success mr-3">
                                        {{ $product->discount_percent . '% تخفیف' }}
                                    </span>
                                @endif
                            </div>
                            {{--./SHOW PRICE--}}


                            {{--ORDER FORM--}}
                            <div class="col-12 my-1 my-md-3 ">
                                @if($product->status != 2 && $product->price_type != 2 &&  $product->entity > 0)
                                    <form action="{{ route('cart.store') }}"
                                          method="POST"
                                          id="product_shop_form"
                                    >
                                        @csrf
                                        {{--PRODUCT ID INPUT--}}
                                        <input type="hidden" name="order[product_id]" value="{{ $product->id }}">


                                        {{--CUSTOMIZE ORDER WITH ATTRIBUTES--}}
                                        @if(count($attributes))
                                            <div class="form-group row align-items-center">
                                                @foreach($attributes as $attr_id=>$attr_values)
                                                    <div class="col-md-12">
                                                        <label for="order-attribute-{{ $attr_id }}"
                                                               class="col-form-label col-12 col-md-2 text-right align-middle">
                                                            {{ key($attr_values)}} :
                                                        </label>
                                                        <div class="col-12 col-md-10 mt-1">
                                                            <select name="order[attribute][{{ $attr_id }}]"
                                                                    id="order-attribute-{{$attr_id}}"
                                                                    class="form-control order-attributes"
                                                            >
                                                                @foreach($attr_values as $attr_value)
                                                                    @if(is_array($attr_value))
                                                                        @foreach($attr_value as $attribute)
                                                                            <option
                                                                                value="{{ $attribute  }}"> {{ $attribute }} </option>
                                                                        @endforeach
                                                                    @else
                                                                        <option
                                                                            value="{{ $attr_value }}">{{ $attr_value }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @include('partials.form_error',['input'=>'order.attribute.'.$attr_id])
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif


                                        {{--SET AMOUNT OF PRODUCT ORDER--}}
                                        <div class="form-group row align-items-end justify-content-center">
                                            <div class="col-12 col-md-6 mx-auto">

                                                {{--SHOW DYNAMIC ENTITY--}}
                                                <div class="form-group row">
                                                    <label for="order-count"
                                                           class="text-dark col-form-label col-md-12 text-center">
                                                        موجودی:
                                                        <span id="entity" class="font-weight-bolder">
                                                            {{ $product->entity - 1 }}
                                                        </span>
                                                        عدد
                                                    </label>
                                                </div>
                                                {{--CONTROL PRODUCT ORDER COUNT--}}
                                                <div class="input-group rounded">
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                                class="btn btn-danger rounded font-weight-bolder"
                                                                id="sub-product-count"
                                                        >
                                                            <i class="fas fa-minus "></i>
                                                        </button>
                                                    </div>
                                                    <input
                                                        class="text-center form-control font-weight-bolder"
                                                        name="order[count]"
                                                        type="number"
                                                        id="order-count"
                                                        value="{{ old("order.count") ?? 1 }}"
                                                        min="1"
                                                        max="{{ $product->entity}}"
                                                    >
                                                    <div class="input-group-prepend">
                                                        <button type="button"
                                                                class="btn btn-success rounded font-weight-bolder"
                                                                id="add-product-count"

                                                        >
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-12 col-md-6 mx-auto my-2 my-md-0">
                                                {{--SUBMIT FORM--}}
                                                <button
                                                    type="submit"
                                                    class="p-0 btn btn-lg btn-outline-success form-control font-18 font-weight-bolder"
                                                    id="product_order_submit"
                                                >
                                                    <i class="fal fa-cart-plus align-middle"></i>
                                                    خرید
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                @else
                                    {{--SHOW PRODUCT DOESN'T EXISTS--}}
                                    <div class="text-danger border border-danger rounded text-center py-3">
                                        <i class="fa fa-times-circle-o fa-2x"></i>
                                        <span class="align-middle px-2 font-20">
                                            ناموجود
                                            <em>!</em>
                                        </span>
                                    </div>
                                    {{--./SHOW PRODUCT DOESN'T EXISTS--}}
                                @endif
                            </div>
                            {{--./ORDER FORM--}}


                            {{--SHORT TEXT--}}
                            <div class="col-12 p-1 p-md-3">
                                <p>
                                    {{ $product->short_text }}
                                </p>
                            </div>
                            {{--./SHORT TEXT--}}

                            {{--SHOW BRIEF--}}
                            <div class="col-12 mb-3">
                                <div class="row justify-content-center align-items-center">
                                    <hr class="w-50">
                                    {{--RATES--}}
                                    <div class="col-12 my-1 my-md-3">
                                        <a href="#ratings">
                                            @include('front-v1.partials.rating_stars', ['model'=>$product])
                                        </a>
                                    </div>
                                    {{--./RATES--}}
                                    <hr class="w-50">
                                    <div class="col-12">
                                        <div class="row align-items-between align-items-center">
                                            <div class="col text-center">
                                                <p>
                                                    <a href="#ratings"
                                                       class="px-1"
                                                    >
                                            <span class="text-dark">
                                                <i class="fal fa-star align-middle ml-1"></i>
                                                {{ $product->ratingsCount() }}
                                            </span>
                                                        <span class="text-muted">
                                                رای
                                            </span>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col text-center">
                                                <p>
                                                    <a href="#comments"
                                                       class="px-1"
                                                    >
                                            <span class="text-dark">
                                                <i class="fal fa-comment align-middle ml-1"></i>
                                                {{ $product->comments->count() }}
                                            </span>
                                                        <span class="text-muted">
                                                نظر
                                            </span>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col text-center">
                                                <p>
                                                  <span
                                                      class="px-1"
                                                  >
                                                <span class="text-dark">
                                                    <i class="fal fa-truck align-middle ml-1"></i>
                                                    {{ $product->sold }}
                                                </span>
                                                <span class="text-muted">
                                                    فروش
                                                </span>
                                            </span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{--./SHOW BRIEF--}}
                        </div>

                    </div>
                    {{--./SHOW BRIEF AND PURCHASE--}}
                </div>


                {{--SHOW ABOUT IMAGE MENU--}}
                <div class="col-12">
                    @include('front-v1.partials.shared.about_image_menus')
                </div>
                {{--./SHOW ABOUT IMAGE MENU--}}
            </div>
            {{--./SHOW MAIN CONTENT--}}

            @include('front-v1.partials.shared.social_media_aside')
        </div> {{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}







    {{-- | OLD |--}}

    <div class="container-fluid">
        <div class="row">
            {{--SHOW MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg rounded py-md-4">
                {{--PRODUCT SHOW--}}


                {{--PRODUCT DETAILS--}}
                <div class="row p-0 p-md-3  my-2">
                    <div class="col-xs-12 ">
                        <nav>
                            <div class="nav nav-tabs nav-fill font-weight-bolder" id="nav-tab" role="tablist">
                                {{--DESCRIPTION--}}
                                <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab"
                                   href="#nav-description"
                                   role="tab" aria-controls="nav-description" aria-selected="true">
                                    توضیحات
                                </a>
                                {{--DETAILS--}}
                                <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab"
                                   href="#nav-details"
                                   role="tab" aria-controls="nav-details" aria-selected="false">
                                    مشخصات
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            {{--DESCRIPTION--}}
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                 aria-labelledby="nav-description-tab">
                                <div class="p-0 p-md-5">
                                    {!! $product->long_text !!}
                                </div>

                            </div>
                            {{--DETAILS--}}
                            <div class="tab-pane fade" id="nav-details" role="tabpanel"
                                 aria-labelledby="nav-details-tab">
                                @foreach($product->details as $detail)
                                    <div class="row mt-2 p-2 border-bottom font-weight-bold font-16">

                                        <div class="col-4 text-md-center border-left">
                                            {{ $detail->title }}
                                        </div>
                                        <div class="col-8 pr-5 text-md-right my-auto">
                                            {{ $detail->detail }}
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div>
                </div>
                {{--./RPODUCT DETAILS--}}

                {{--RATING--}}
                <div class="row py-3 mt-3 rounded" id="ratings">
                    @include('front-v1.partials.rating', ['user_rate'=>getUserRating($product), 'model'=>$product])
                </div>
                {{--./RATING--}}


                {{--COMMENTS--}}
                <div class="row mb-5 mt-3 py-3 rounded">
                    @include('front-v1.partials.comment_template', ['comments'=>$comments,'model'=>$product])
                    {{--'model'=>'Article','model_id'=>$article->id--}}
                </div>
                {{--./COMMENTS--}}

                {{--SIMILAR PRODUCTS--}}
                @if(count($similar_products))
                    <div class="row mt-5 bg-white mb-5">
                        <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                            <h3 class="font-14">
                                <span class="text-dark">محصولات مشابه</span>
                            </h3>
                        </div>

                        <div class="col-12 mt-2 mb-5">
                            <div class="row align-items-center justify-content-center">
                                <div class="oc-prev col-2 text-center cursor-pointer">
                                    <i class="far fa-angle-right fa-4x"></i>
                                </div>
                                <div class="col-8">
                                    <div class="owl-carousel">
                                        @include('front-v1.partials.products', ['products'=>$similar_products, 'carousel'=>true])
                                    </div>
                                </div>
                                <div class="oc-next col-2 text-center cursor-pointer">
                                    <i class="far fa-angle-left fa-4x"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
                {{--./SIMILAR PRODUCTS--}}
            </div>
            {{--./SHOW MAIN CONTENT--}}
        </div>
    </div>



@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/zoom/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('front-v1/owl-carousel/owl.carousel.min.js') }}"></script>
    {{--INCLUDE RATING SCRIPT FROM ITS PARTIAL--}}
    @stack('rating-script')
    {{--INCLUDE COMMENT SCRIPT FROM ITS PARTIAL--}}
    @stack('comment-script')
    {{--PAGE SCRIPT--}}
    <script>
        $(document).ready(function () {

            let mainImg = $('#main-image');
            /*INITIALIZE ZOOM*/
            mainImg.wrap('<span style="display:inline-block" class="rounded"></span>')
                .css('display', 'block')
                .parent()
                .zoom();
            /*CHANGE PRODUCT IMAGE & SET ZOOM ON CHANGE*/
            @foreach($product->files as $file)
            $("#product-thumbnail-" +{{$loop->index}}).on('click', function () {
                mainImg.trigger('zoom.destroy');
                mainImg.attr('src', $(this).attr('src'))
                    .wrap('<span style="display:inline-block" class="rounded"></span>')
                    .css('display', 'block')
                    .parent()
                    .zoom();
            });
            @endforeach

            /*USER ORDER HANDLING*/
            let orderProductCount = $("#order-count");
            let addProductCount = $("#add-product-count");
            let subProductCount = $("#sub-product-count");
            let entity = $("#entity");
            let productCount = parseInt(entity.text());
            let count = productCount;
            addProductCount.on('click', function () {
                if (orderProductCount.val() <= count) {
                    let newValue = parseInt(orderProductCount.val());
                    orderProductCount.val(++newValue);
                    entity.text(--productCount);
                }
            });

            subProductCount.on('click', function () {
                if (orderProductCount.val() > 1) {
                    let newValue = parseInt(orderProductCount.val());
                    orderProductCount.val(--newValue);
                    entity.text(++productCount)
                }
            });

            orderProductCount.on('input change', function () {
                if ($(this).val() <= 0) {
                    $(this).val(1);
                    entity.text({{ $product->entity - 1 }})
                } else if ($(this).val() > {{ $product->entity }}) {
                    $(this).val({{ $product->entity}});
                    entity.text("0");
                } else {
                    entity.text({{$product->entity - 1 }} -$(this).val());
                }

            });


            $("#product_shop_form").submit(function (e) {

                e.preventDefault();

                let form = $(this);
                let url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data) {
                        location.reload(); // show response from the php script.
                    }
                });


            });


            /*THUMBNAILS OWL CAROUSEL*/
            let product_images_owl = $("#oc_product_images")
            product_images_owl.owlCarousel({
                rtl: true,
                margin: 10,
                autoplay: false,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                nav: false,
                navElement: 'div',
                dots: false,
                rewind: false,
                responsiveClass: true,
            });

            $('.oc_product_images_next').on('click', function () {
                product_images_owl.trigger('next.owl.carousel');
            });
            $('.oc_product_images_prev').on('click', function () {
                product_images_owl.trigger('prev.owl.carousel');
            });


            /***START***/
            /*COMMENTS*/
            /**********/
            $('.f-reply').hide();
            $('.btn-reply').click(function () {
                $('.f-reply').hide();
                let service = $(this).attr('id');
                let service_id = "#f-" + service;
                $(service_id).show('slow');
            })

            /**********/
            /*COMMENTS*/
            /***END****/

        });
    </script>

@endsection

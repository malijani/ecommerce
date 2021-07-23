@extends('layouts.app')

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('products.product', $product) }}


    <div class="container-fluid my-3 rounded">
        <div class="row my-2">
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
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


                                    <div class="owl-carousel  product_thumbnails col-9 mx-auto"
                                         id="oc_product_images"
                                    >
                                        @foreach($product->files as $file)
                                            <img src="{{ asset($file->link) }}"
                                                 alt="{{ $file->title }}"
                                                 class="img-thumbnail suggest_img"
                                                 id="product-thumbnail-{{$loop->index}}"
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
                            <div class="col-12 text-center py-2  border-bottom">
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

                            {{--CATEGORY AND BRAND--}}
                            <div class="col-12 my-2 my-md-3">
                                <div class="row justify-content-end align-items-center">
                                    <div class="col text-center text-md-left">
                                        <span class="">
                                        <span class="text-muted">
                                            برند
                                        </span>
                                            <span>
                                            <a href="{{ route('brand.show', $product->brand->title_en) }}"
                                               class="badge badge-secondary p-2"
                                            >
                                                {{ $product->brand->title . ' | ' . str_replace('-', ' ', $product->brand->title_en) }}
                                            </a>
                                        </span>
                                        </span>
                                        <span class="">
                                        <span class="text-muted">
                                            دسته
                                        </span>
                                            <span>
                                            <a href="{{ route('category.show', $product->category->title_en) }}"
                                               class="badge badge-secondary p-2"
                                            >
                                                {{ $product->category->title }}
                                            </a>
                                        </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{--./CATEGORY AND BRAND--}}

                            {{--ORDER FORM--}}
                            <div class="col-12 my-1 my-md-3 ">
                                @if($product->status != 2 && $product->price_type != 2 &&  $product->entity > 0)
                                    <form action="{{ route('cart.store') }}"
                                          method="POST"
                                          id="product_shop_form"
                                    >
                                        @csrf
                                        {{--PRODUCT ID INPUT--}}
                                        <input type="hidden" name="order[product_id]" value="{{ $product->title_en }}">


                                        {{--CUSTOMIZE ORDER WITH ATTRIBUTES--}}
                                        @if(count($attributes))
                                            <div class="row align-items-center">
                                                @foreach($attributes as $attr_id=>$attr_values)
                                                    <div class="col-12">
                                                        <div
                                                            class="attr_select_group form-group row align-items-center">
                                                            <label for="order-attribute-{{ $attr_id }}"
                                                                   class="col-form-label col-4 col-md-3 text-center align-middle attr_select_label">
                                                                {{ key($attr_values)}}
                                                            </label>
                                                            <div class="col-8 col-md-9">
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
                                                    class="p-0 btn btn-lg btn-custom form-control font-18 font-weight-bolder"
                                                    id="product_order_submit"
                                                >
                                                    <i class="fal fa-cart-plus align-middle"></i>
                                                    افزودن به سبد خرید
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
                                    <div class="col-12 mt-2 mb-3 mb-md-4">
                                        <a href="#ratings">
                                            @include('front-v1.partials.rating_stars', ['model'=>$product])
                                        </a>
                                    </div>
                                    {{--./RATES--}}

                                    {{--RATES COUNT, COMMENTS COUNT, SOLD COUNT--}}
                                    <div class="col-12 my-1 my-md-2">
                                        <div class="row align-items-between align-items-center">
                                            <div class="col-12 col-md text-center">
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
                                            <div class="col-12 col-md text-center">
                                                <p>
                                                    <a href="#comments"
                                                       class="px-1"
                                                    >
                                            <span class="text-dark">
                                                <i class="fal fa-comment align-middle ml-1"></i>
                                                {{ $product->activeComments->count() }}
                                            </span>
                                                        <span class="text-muted">
                                                نظر
                                            </span>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-12 col-md text-center">
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
                                    {{--./RATES COUNT, COMMENTS COUNT, SOLD COUNT--}}

                                    {{--ORIGIN, DELIVER, WARRANTY--}}
                                    <div class="col-12 my-1 my-md-2">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-12 col-md text-center">
                                                <p>
                                                <span class="text-muted">
                                                    <i class="fal fa-certificate"></i>
                                                {{ $product->origin_text }}
                                                </span>
                                                </p>
                                            </div>
                                            <div class="col-12 col-md text-center">
                                                <p>
                                                <span class="text-muted">
                                                    <i class="fal fa-tachometer"></i>
                                                {{ $product->deliver_text }}
                                                </span>
                                                </p>
                                            </div>
                                            <div class="col-12 col-md text-center">
                                                <p>
                                                <span class="text-muted">
                                                    <i class="fal fa-award"></i>
                                                {{ $product->warranty_text }}
                                                </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    {{--./ORIGIN, DELIVER, WARRANTY--}}
                                    <hr class="w-50">
                                </div>
                            </div>
                            {{--./SHOW BRIEF--}}
                        </div>

                    </div>
                    {{--./SHOW BRIEF AND PURCHASE--}}



                    {{--SHOW ABOUT IMAGE MENU--}}
                    <div class="col-12 ">
                        @include('front-v1.partials.shared.about_image_menus')
                    </div>
                    {{--./SHOW ABOUT IMAGE MENU--}}

                    {{--SHOW DETAILS AND DESCRITION--}}
                    <div class="col-12 mt-3 border-bottom">
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

                        <div class="tab-content" id="nav-tabContent">
                            {{--DESCRIPTION--}}
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                 aria-labelledby="nav-description-tab">
                                <div class="p-1 p-md-3">
                                    {!! $product->long_text !!}
                                </div>
                            </div>
                            {{--DETAILS--}}
                            <div class="tab-pane fade" id="nav-details" role="tabpanel"
                                 aria-labelledby="nav-details-tab">
                                @foreach($product->details as $detail)
                                    <div
                                        class="row mt-2 p-2 @if(!$loop->last) border-bottom @endif font-weight-bold font-16">

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
                    {{--./SHOW DETAILS AND DESCRIPTION--}}

                    {{--RATING SECTION--}}
                    <div class="col-12">
                        <div class="row">
                            @include('front-v1.partials.rating', ['user_rate'=>getUserRating($product), 'model'=>$product])
                        </div>
                    </div>
                    {{--./RATING SECTION--}}

                    {{--COMMENT SECTION--}}
                    <div class="col-12">
                        <div class="row py-2">
                            @include('front-v1.partials.comment_template', ['comments'=>$comments,'model'=>$product])
                        </div>
                    </div>
                    {{--./COMMENT SECTION--}}


                    {{--PRODUCT SUGGESTIONS--}}
                    <div class="col-12 mt-4">
                        <div class="row align-items-center">
                            @if(!empty($product->bef))
                                <div
                                    class="col-12 col-md-6 mt-2 mt-md-0 ml-auto text-right bg-light product_suggestion">
                                    <a href="{{ route('product.show' , $product->bef->title_en) }}"
                                       class="text-dark"
                                    >
                                        <div class="row align-items-center justify-content-between ">
                                            <div class="col-1">
                                                <span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </div>
                                            <div class="col-6 text-center">
                                                <p>
                                                    {{ $product->bef->title }}
                                                </p>
                                                <p>
                                                    {{ str_replace('-', ' ', $product->bef->title_en) }}
                                                </p>
                                            </div>
                                            <div class="col-4">
                                                <img src="{{ asset($product->bef->files()->defaultFile()->link) }}"
                                                     alt="{{ $product->bef->files()->defaultFile()->title }}"
                                                     id="main-image"
                                                     class="img-fluid product-image rounded suggest_img"

                                                >
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            @endif
                            @if(!empty($product->af))
                                <div
                                    class="col-12 col-md-6 mt-2 mt-md-0 mr-auto text-left bg-light after_suggestion">
                                    <a href="{{ route('product.show' , $product->af->title_en) }}"
                                       class="text-dark"
                                    >
                                        <div class="row align-items-center justify-content-between ">

                                            <div class="col-4">
                                                <img src="{{ asset($product->af->files()->defaultFile()->link) }}"
                                                     alt="{{ $product->af->files()->defaultFile()->title }}"
                                                     id="main-image"
                                                     class="img-fluid product-image rounded suggest_img"

                                                >
                                            </div>

                                            <div class="col-6 text-center">
                                                <p>
                                                    {{ $product->af->title }}
                                                </p>
                                                <p>
                                                    {{ str_replace('-', ' ', $product->af->title_en) }}
                                                </p>
                                            </div>

                                            <div class="col-1">
                                                <span>
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{--PRODUCT SUGGESTIONS--}}

                    {{--SHOW SIMILAR PRODUCTS--}}
                    @if(!empty($similar_products) && $similar_products->count())
                        <div class="col-6 ml-auto mt-3 mt-md-5">
                            <a class="text-dark display-4 font-16 font-weight-bolder"
                               href="{{ route('product.index') }}"
                            >
                                محصولات مشابه
                            </a>
                        </div>

                        @include('front-v1.partials.carousel.products', ['products'=>$similar_products])
                    @endif
                    {{--./SHOW PRODUCTS--}}


                </div>
            </div>
            {{--./SHOW MAIN CONTENT--}}

            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.social_media_aside')
            </div>
        </div> {{--./MAIN ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./MAIN CONTAINER--}}

@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/zoom/jquery.zoom.min.js') }}"></script>
    @stack('scripts')
    {{--PAGE SCRIPT--}}
    <script>
        $(document).ready(function () {

            /***START*****/
            /*ZOOM IMAGE */
            /*************/
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

            /*************/
            /*ZOOM IMAGE */
            /*****END*****/

            /***START****/
            /*ORDER FORM*/
            /************/
            /*USER ORDER HANDLING*/
            let orderProductCount = $("#order-count");
            let addProductCount = $("#add-product-count");
            let subProductCount = $("#sub-product-count");
            let entity = $("#entity");

            addProductCount.add(subProductCount).on('click', function () {
                let remainingProductCount = orderProductCount.attr('max');
                let productCount = parseInt(entity.text());
                let orderProductCountInt = parseInt(orderProductCount.val());
                if (isNaN(productCount) || isNaN(orderProductCountInt) || orderProductCount.val() === "") {
                    orderProductCount.val(1);
                    entity.text(remainingProductCount - 1);
                }
            });
            addProductCount.on('click', function () {
                let remainingProductCount = orderProductCount.attr('max');
                let productCount = parseInt(entity.text());
                let orderProductCountInt = parseInt(orderProductCount.val());
                if (orderProductCountInt < remainingProductCount) {
                    orderProductCount.val(++orderProductCountInt);
                    entity.text(--productCount);
                }
            });
            subProductCount.on('click', function () {
                let productCount = parseInt(entity.text());
                let orderProductCountInt = parseInt(orderProductCount.val());
                if (orderProductCountInt > 1) {
                    orderProductCount.val(--orderProductCountInt);
                    entity.text(++productCount)
                }
            });
            orderProductCount.on('input change', function () {
                let remainingProductCount = orderProductCount.attr('max');
                let productCount = parseInt(entity.text());
                let orderCount = parseInt($(this).val());

                if (isNaN(orderCount) || orderCount <= 0 || $(this).val() === "" || productCount < 0 || isNaN(productCount) || productCount === "") {
                    $(this).val(1);
                    entity.text(remainingProductCount - 1);
                } else if (orderCount >= remainingProductCount) {
                    $(this).val(remainingProductCount);
                    entity.text("0");
                } else {
                    entity.text(remainingProductCount - orderCount);
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
                        /*UPDATE SECTIONS OF PRODUCT*/
                        $("#basket_aside_content").html(data.basket_aside);
                        $("#header_basket_total").html(data.basket_total);

                        /*SHOW PRODUCT DOESN'T EXISTS*/
                        if (data.quantity <= 0) {
                            form.html('<div class="text-danger border border-danger rounded text-center py-3">' +
                                '<i class="fa fa-times-circle-o fa-2x"></i>' +
                                '<span class="align-middle px-2 font-20">' +
                                'ناموجود' +
                                '<em>!</em>' +
                                '</span>' +
                                '</div>');
                        }
                        /*UPDATE ENTITY  : ONE OF THEM IS IN ORDER COUNT!*/
                        entity.text(data.quantity - 1);
                        /*RESET ORDER COUNT*/
                        orderProductCount.val(1);
                        /*SET MAX ATTRIBUTE OF INPUT COUNT*/
                        orderProductCount.attr({'max': data.quantity});

                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: "<h5>" + data.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            if (isNaN(entity.text()) || entity.text() === '') {
                                let remainingProductCount = orderProductCount.attr('max');
                                orderProductCount.val(1);
                                entity.text(remainingProductCount - 1);

                            }
                        });
                    },

                    error: function (data) {
                        Swal.fire({
                            position: 'top',
                            icon: "error",
                            title: "<h5>" + data.responseJSON.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            if (isNaN(entity.text()) || entity.text() === '') {
                                let remainingProductCount = orderProductCount.attr('max');
                                orderProductCount.val(1);
                                entity.text(remainingProductCount - 1);
                            }
                        });
                    },

                });
            });
            /************/
            /*ORDER FORM*/
            /****END*****/


            /***********START*********/
            /*THUMBNAILS OWL CAROUSEL*/
            /*************************/
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
            /*************************/
            /*THUMBNAILS OWL CAROUSEL*/
            /**********END************/


        });
    </script>

@endsection

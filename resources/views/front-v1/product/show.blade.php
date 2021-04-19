@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('front-v1/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-v1/owl-carousel/assets/owl.theme.default.min.css') }}">
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


            <div class="col-lg-6 product-details pl-md-5">{{-- PRODUCT MAIN CONTENT--}}
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
                <div class="price w-50 pr-5">
                    <p class="border p-2 rounded text-center">

                        @if($product->price_type=="0" && $product->discount_percent != "0")
                            <span class="font-weight-bolder">{{$product->show_discount_price}} تومن</span><br>
                            <span class="discount font-weight-bold">{{ $product->show_price}} تومن</span>
                            <span class="discount-label font-12 text-center">
                            {{ $product->discount_percent }}%  تخفیف
                            </span>
                        @elseif($product->price_type=="1")
                            <span class="font-weight-bolder">{{$product->show_price}} تومن</span>
                        @else
                            <span class="badge badge-info">
                                <i class="fa fa-phone"></i>
                                تماس بگیرید
                            </span>
                        @endif
                    </p>

                </div>
                <div class="short-text d-flex justify-content-end w-75 mb-3">
                    <p class="text-center">
                        {{ $product->short_text }}
                    </p>
                </div>

                <div class="col-12">{{--ORDER SECTION--}}
                    @if($product->status != 2 && $product->price_type != 2 &&  $product->entity > 0)
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order[product_id]" value="{{ $product->id }}">
                            {{--CUSTOMIZE ORDER WITH ATTRIBUTES--}}
                            @if(count($attributes))
                                <div class="form-group row">
                                    @foreach($attributes as $attr_id=>$attr_values)
                                        <div class="col-md-12">
                                            <label for="order-attribute-{{ $attr_id }}"
                                                   class="col-form-label col-md-2 text-right">{{ key($attr_values)}}
                                                :</label>
                                            <div class="col-md-6 mt-1">
                                                <select name="order[attribute][{{ $attr_id }}]"
                                                        id="order-attribute-{{$attr_id}}"
                                                        class="form-control"
                                                >
                                                    @foreach($attr_values as $attr_value)
                                                        @if(is_array($attr_value))
                                                            @foreach($attr_value as $attribute)
                                                                <option
                                                                    value="{{ $attribute  }}"> {{ $attribute }} </option>
                                                            @endforeach
                                                        @else
                                                            <option value="{{ $attr_value }}">{{ $attr_value }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @include('partials.form_error',['input'=>'order.attribute.'.$attr_id])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{--SHOW DYNAMIC ENTITY--}}
                            <div class="form-group row">
                                <label for="order-count"
                                       class="text-dark col-form-label col-md-12 text-center">موجودی:
                                    <span id="entity" class="font-weight-bolder">
                                    {{ $product->entity -1 }}
                                </span>
                                    عدد</label>
                            </div>

                            {{--SET AMOUNT OF PRODUCT ORDER--}}
                            <div class="form-group row justify-content-center">
                                <div class="col-8">
                                    <button type="button"
                                            role="link"
                                            class="btn btn-sm btn-outline-success form-control m-1"
                                            id="add-product-count"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>

                                    <input
                                        class="text-center form-control font-weight-bolder"
                                        name="order[count]"
                                        type="number"
                                        id="order-count"
                                        value="{{ old("order.count") ?? 1 }}"
                                        min="1"
                                        max="{{ $product->entity}}"
                                    >

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger form-control m-1"
                                            id="sub-product-count"
                                    >
                                        <i class="fa fa-minus"></i>
                                    </button>

                                </div>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary form-control"
                            >
                                <i class="fa fa-plus-square px-2"></i>
                                افزودن به سبد خرید
                            </button>

                        </form>
                    @else
                        <div class="alert alert-danger rounded text-center">
                            <i class="fa fa-times-circle-o fa-2x"></i>
                            <strong class="align-middle px-2">ناموجود</strong>

                        </div>
                    @endif

                </div>{{--./ORDER SECTION--}}
            </div>{{--./PRODUCT MAIN CONTENT--}}
        </div>


        <div class="row bg-white p-3 my-2">
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
                        <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details"
                           role="tab" aria-controls="nav-details" aria-selected="false">
                            مشخصات
                        </a>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    {{--DESCRIPTION--}}
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                         aria-labelledby="nav-description-tab">
                        <div class="p-5">
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

        {{--COMMENTS--}}
        <div class="row bg-white mb-5 mt-3 py-3 rounded">
            @include('front-v1.partials.comment_template', ['comments'=>$comments, 'model'=>'Product','model_id'=>$product->id])
        </div>
        {{--./COMMENTS--}}

        @if(count($similar_products))
            <div class="row mt-5 bg-white mb-5">
                <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                    <h3 class="font-14">
                        <a class="text-dark" href="#">محصولات مشابه</a>
                    </h3>
                </div>

                <div class="col-12 mt-2 mb-5">
                    <div class="row align-items-center justify-content-center">
                        <div class="oc-prev col-1 text-center cursor-pointer">
                            <i class="far fa-angle-right fa-4x"></i>
                        </div>
                        <div class="col-9">
                            <div class="owl-carousel">
                                @include('front-v1.partials.products', ['products'=>$similar_products, 'carousel'=>true])
                            </div>
                        </div>
                        <div class="oc-next col-1 text-center cursor-pointer">
                            <i class="far fa-angle-left fa-4x"></i>
                        </div>
                    </div>

                </div>
            </div>
        @endif {{--./similar products--}}


    </div>{{--./product show container--}}




@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/zoom/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('front-v1/owl-carousel/owl.carousel.min.js') }}"></script>
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


            /*OWL CAROUSEL*/
            let owl = $('.owl-carousel');
            owl.owlCarousel({
                rtl: true,
                margin: 20,
                autoplay: false,
                autoplayHoverPause: true,
                autoplayTimeout: 3000,
                animateIn: 'linear',
                animateOut: 'linear',
                nav: false,
                navElement: 'div',
                dots: false,
                rewind: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        slideBy: 1,
                    },
                    576: {
                        items: 2,
                        slideBy: 1,
                    },
                    768: {
                        items: 3,
                        slideBy: 2,
                    },
                    999: {
                        items: 5,
                        slideBy: 2,
                    },
                    1400: {
                        items: 7,
                        slideBy: 3,
                    }
                }
            });

            $('.oc-next').on('click', function () {
                owl.trigger('next.owl.carousel');
            });
            $('.oc-prev').on('click', function () {
                owl.trigger('prev.owl.carousel');
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

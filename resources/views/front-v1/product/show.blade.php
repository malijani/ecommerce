@extends('layouts.app')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('front-v1/jquery-zoom-image-carousel/style.css') }}">
@endsection

@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('products.product', $product) }}


    <div class="container my-3 rounded">


        <div class="row px-0 bg-white py-3">
            <div class="col-lg-6 mb-5">


                <!-- Primary carousel image -->

                <div class="show" href="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png') }}">
                    <img
                        src="{{ asset($product->files()->defaultFile()->link ?? 'images/fallback/article.png') }}"
                        alt="{{$product->files()->defaultFile()->title}}"
                        id="show-img"
                    >
                </div>

                <!-- Secondary carousel image thumbnail gallery -->

                <div class="small-img">
                    <img src="images/next-icon.png" class="icon-left" alt="" id="prev-img">
                    <div class="small-container">
                        <div id="small-img-roll">
                            @foreach($product->files as $file)
                            <img
                                src="{{ asset($file->link) }}"
                                alt="{{ $file->title }}"
                                class="show-small-img"
                            >
                            @endforeach
                        </div>
                    </div>
                    <img src="images/next-icon.png" class="icon-right" alt="" id="next-img">
                </div>




            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate fadeInUp ftco-animated">
                <h3>{{ $product->title }}</h3>
                <div class="rating d-flex">
                    <p class="text-left mr-4">
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
                <div class="row mt-4">
                    <div class="col-md-12">
                        <p style="color: #000;">موجودی:  <span class="entity">{{ $product->entity }}</span> عدد</p>
                    </div>
                </div>
                <p><a href="cart.html" class="btn btn-primary py-3 px-5">اضافه به سبد خرید </a></p>
            </div>
        </div>

    </div>{{--container--}}
@endsection

@section('page-scripts')

    <script src="{{asset('front-v1/jquery-zoom-image-carousel/scripts/zoom-image.js')}}"></script>
    <script src="{{asset('front-v1/jquery-zoom-image-carousel/scripts/main.js')}}"></script>


@endsection

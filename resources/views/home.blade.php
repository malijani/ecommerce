@extends('layouts.app')


@section('content')

    {{--    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('home') }}--}}

    <div class="container-fluid my-3">
        <div class="row">
            @include('front-v1.partials.categories', ['categories'=>$categories])
        </div>

        <div class="row mt-3 bg-white mb-5">
            <div class="col-12 p-3 d-flex justify-content-between align-items-center">
                <h3 class="font-14">
                    <a class="text-dark" href="#">پرفروش ترین ها</a>
                </h3>
                <a href="#">
                    مشاهده همه
                    <i class="fa fa-eye"></i>
                </a>
            </div>
            <div class="col-12 mt-2 mb-5">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <img class="img-fluid mb-3"
                             src="https://via.placeholder.com/300"
                             alt="نارنگی داخلی ۱ کیلوگرمی">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>۵٬۱۳۰ تومان</span>
                            <small class="discount">۵٬۴۰۰</small>
                        </div>
                        <h4 class="font-14 mt-2 text-right">قند شکسته پردیس ۴۰۰ گرمی قند شکسته پردیس ۴۰۰ گرمی</h4>
                        <span class="position-absolute left-top-0">
                        <button class="add_card">+</button>
                    </span>
                        <span class="position-absolute discount-label font-12">
                        38% تخفیف
                    </span>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <img class="img-fluid mb-3"
                             src="https://via.placeholder.com/300"
                             alt="نارنگی داخلی ۱ کیلوگرمی">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>۵٬۱۳۰ تومان</span>
                            <small class="discount">۵٬۴۰۰</small>
                        </div>
                        <h4 class="font-14 mt-2 text-right">قند شکسته پردیس ۴۰۰ گرمی قند شکسته پردیس ۴۰۰ گرمی</h4>
                        <span class="position-absolute left-top-0">
                        <button class="add_card">+</button>
                    </span>

                    </div>
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <img class="img-fluid mb-3"
                             src="https://via.placeholder.com/300"
                             alt="نارنگی داخلی ۱ کیلوگرمی">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>۵٬۱۳۰ تومان</span>
                            <small class="discount">۵٬۴۰۰</small>
                        </div>
                        <h4 class="font-14 mt-2 text-right">قند شکسته پردیس ۴۰۰ گرمی قند شکسته پردیس ۴۰۰ گرمی</h4>
                        <span class="position-absolute left-top-0">
                        <button class="add_card">+</button>
                    </span>
                        <span class="position-absolute discount-label font-12">
                        38% تخفیف
                    </span>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <img class="img-fluid mb-3"
                             src="https://via.placeholder.com/300"
                             alt="نارنگی داخلی ۱ کیلوگرمی">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>۵٬۱۳۰ تومان</span>
                            <small class="discount">۵٬۴۰۰</small>
                        </div>
                        <h4 class="font-14 mt-2 text-right">قند شکسته پردیس ۴۰۰ گرمی قند شکسته پردیس ۴۰۰ گرمی</h4>
                        <span class="position-absolute left-top-0">
                        <button class="add_card">+</button>
                    </span>
                        <span class="position-absolute discount-label font-12">
                        38% تخفیف
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

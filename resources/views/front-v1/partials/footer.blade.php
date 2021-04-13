<footer class="mt-5 mt-sm-3 p-4 p-sm-2 font-14">

    {{--LICENSES--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <a href="{{ $footer_image->link ?? '#' }}">
                <img src="{{ asset($footer_image->pic ?? 'images/fallback/footer_licenses.png') }}"
                     alt="مجوز های {{ $footer_image->pic_alt ?? config('app.name') ?? ' وبسایت' }}"
                     class="img img-fluid rounded"
                >
                </a>
            </div>
        </div>
    </div>

    {{--NEW BRIEFES--}}
    <div class="container-fluid">
        <div class="mt-5 bg-white p-3 rounded text-center">
            <div class="row">
                <div class="col-md-3 pt-0 pt-md-1">جدید ترین محصولات</div>
                <div class="col-md-3 pt-4 pt-md-1">جدید ترین نظرات</div>
                <div class="col-md-3 pt-4 pt-md-1">مجوز ها</div>
                <div class="col-md-3 pt-4 pt-md-1">جدید ترین مقالات</div>
            </div>
        </div>
    </div>

    {{--PROPOSALS--}}
    <div class="container-fluid">
        {{--BRIEF OF WEBSITE--}}
        <div class="mt-5 bg-dark text-lime-a100 text-center p-3 font-weight-bolder rounded">
            <div class="row">
                <div class="col-md-3 mt-0 mt-md-1">دارای مجوز وزارت صمت</div>
                <div class="col-md-3 mt-3 mt-md-1">تماس بگیرید : 9103944579(+98)</div>
                <div class="col-md-3 mt-3 mt-md-1">پردازش سفارشات ۷ روز هفته ۲۴ ساعت شبانه روز</div>
                <div class="col-md-3 mt-3 mt-md-1">ارسال به سراسر کشور</div>
            </div>
        </div>
        {{--SERVICES AND SOCIAL MEDIAS--}}
        <div class="mt-0 bg-grey-300 text-center p-4 font-16">
            <div class="row">
                <div class="col-md-3 mt-0 mt-md-1">
                    موضوع قابل نمایش
                </div>
                <div class="col-md-3 mt-3 mt-md-1">
                    خدمات {{ config('app.name') }}
                </div>
                <div class="col-md-6 mt-3 mt-md-1">
                    شبکه های اجتماعی
                    <div>
                        <i class="fa fa-instagram"></i>
                        <i class="fa fa-telegram"></i>
                        <i class="fa fa-facebook"></i>
                        <i class="fa fa-linkedin"></i>
                    </div>
                </div>
            </div>
        </div>
        {{--COPYRIGHT--}}
        <div class="mt-0 bg-awesome text-center p-2  text-lime-a100 rounded">
            <div class="row align-items-center">
                <div class="col-12">
                    <span>
                        <i class="far fa-copyright"></i>
                        کپی رایت @ 1400.
                        طراحی و توسعه توسط
                        <a href="https://github.com/malijani"
                           title="توسعه دهنده وبسایت {{ config('app.name') }}"
                           class="text-warning"
                        >
                            محمد علی جانی
                        </a>

                    </span>
                </div>
            </div>
        </div>

    </div>


</footer>

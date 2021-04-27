<footer class="mt-5 mt-sm-3 p-4 p-sm-2 font-14">

    {{--LICENSES--}}
    <div class="container">
        <div class="row justify-content-center rounded">
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
                <div class="col-md-3 pt-0 pt-md-1">
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
                                                <img src="{{ $product_proposal->files()->defaultFile()->link }}"
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
                                                    {{ $product_proposal->title }} | {{ str_replace('-', ' ', $product_proposal->title_en) }}
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

                <div class="col-md-3 pt-4 pt-md-1">
                    <h4 class="font-16 font-weight-bolder">
                        نقد کاربران
                    </h4>
                    <hr class="w-75">
                    <div class="row align-items-center justify-content-center">
                        @if($footer_last_comments->count() > 0)
                            @foreach($footer_last_comments as $last_comment)
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('product.show', $last_comment->product->title_en) }}">
                                                <img
                                                    src="{{ asset($last_comment->product->files()->defaultFile()->link) }}"
                                                    alt="{{ $last_comment->product->files()->defaultFile()->title }}"
                                                    class="img img-fluid rounded"
                                                >
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <a href=" {{ route('product.show', $last_comment->product->title_en)."#comment-". $last_comment->id }}"
                                               class="text-dark"
                                            >
                                                <p class="font-16 font-weight-bolder">
                                                    {{ $last_comment->product->title }}
                                                </p>
                                                <p class="font-weight-bold text-right">
                                                    توسط
                                                    @if(isset($last_comment->user))
                                                        {{ $last_comment->user->full_name }}
                                                    @else
                                                        کاربر مهمان
                                                    @endif
                                                </p>
                                                <div class="text-right">
                                                    {{ Str::words($last_comment->content, 5) }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 mt-3">
                                <p class="font-16 font-weight-bolder">
                                    نظری از سمت کاربران جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 pt-4 pt-md-1">
                    <h4 class="font-16 font-weight-bolder">
                        جدید ترین مقالات
                    </h4>
                    <hr class="w-75">
                    <div class="row justify-content-center align-items-center">
                        @if($footer_last_articles->count()>0)
                            @foreach($footer_last_articles as $last_article)
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('blog.show', $last_article->title_en) }}">
                                                <img src="{{ asset($last_article->pic) }}"
                                                     alt="{{ $last_article->pic_alt }}"
                                                     class="img img-fluid rounded"
                                                >
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <a href="{{ route('blog.show', $last_article->title_en) }}"
                                               class="text-dark font-16 font-weight-bolder"
                                            >
                                                {{ $last_article->title }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="font-16 font-weight-bolder">
                                    مقاله ای جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                {{--TODO : ADD LICENSE CONTROLLER ADMIN--}}
                <div class="col-md-3 pt-4 pt-md-1">
                    <h4 class="font-16 font-weight-bolder">
                        تاییدیه و مجوز ها
                    </h4>
                    <hr class="w-75">
                    <div class="row justify-content-center align-items-center">
                      {{--  @if($footer_licenses->count()>0)
                            @foreach($footer_licenses as $footer_license)
                                {{ $footer_license->title }}
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="font-16 font-weight-bolder">
                                    مجوز یا تاییدیه ای جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--PROPOSALS--}}
    <div class="container-fluid">
        {{--BRIEF OF WEBSITE--}}
        <div class="mt-5 bg-dark text-lime-a100 text-center p-3 font-weight-bolder rounded-top">
            <div class="row">
                {{--TODO : MAKE FOOTER STATIC NAV CONTROLLER--}}
                <div class="col-md-3 mt-0 mt-md-1">دارای مجوز وزارت صمت</div>
                <div class="col-md-3 mt-3 mt-md-1">تماس بگیرید : 9103944579(+98)</div>
                <div class="col-md-3 mt-3 mt-md-1">پردازش سفارشات ۷ روز هفته ۲۴ ساعت شبانه روز</div>
                <div class="col-md-3 mt-3 mt-md-1">ارسال به سراسر کشور</div>
            </div>
        </div>
        {{--SERVICES AND SOCIAL MEDIAS--}}
        <div class="mt-0 bg-grey-300 text-center p-4 font-16">
            <div class="row">
                {{--TODO : MAKE FOOTER DESCRIPTION TABS CONTROLLER--}}
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
        <div class="mt-0 bg-awesome text-center p-2  text-lime-a100 rounded-bottom">
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
        <div class="d-block d-md-none min-vh-25"></div>

    </div>


</footer>

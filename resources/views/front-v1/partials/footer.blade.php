<footer class="mt-5 mt-sm-3 p-4 p-sm-2 font-14">

    {{--FOOTER IMAGE--}}
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

                <div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
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
                <div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
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
                <div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
                    <h4 class="font-16 font-weight-bolder">
                        تاییدیه و مجوز ها
                    </h4>
                    <hr class="w-75">
                    <div class="row justify-content-center align-items-center">
                        @if($footer_licenses->count()>0)

                            @foreach($footer_licenses->links as $footer_license_link)
                                <div class="col-12 mt-3">
                                    <a href="{{ $footer_license_link->link }}"
                                       class="text-dark font-weight-bolder font-14"
                                    >
                                        {{ $footer_license_link->title }}
                                    </a>
                                </div>

                            @endforeach

                        @else
                            <div class="col-12">
                                <p class="font-16 font-weight-bolder">
                                    مجوز یا تاییدیه ای جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--PROPOSALS--}}
    <div class="container-fluid">
        {{--FOOTER NAVBAR--}}
        <div class="mt-5 bg-dark text-center p-3 font-weight-bolder rounded-top">
            <div class="row align-items-center">
                @if(isset($footer_static_navs->links) && $footer_static_navs->links->count() > 0)
                    @foreach($footer_static_navs->links as $footer_nav_link)
                        <div class="col-12 col-md @if($loop->first) mt-0 @else mt-3 mt-md-0 @endif">
                            <a href="{{ $footer_nav_link->link }}"
                               class="text-lime-a100"
                            >
                                {{ $footer_nav_link->title }}
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-lime-a100 mt-3">
                            تمامی حقوق مادی و معنوی این وبسایت متعلق به {{ config('app.name') }} می‌باشد و هرگونه سوء
                            استفاده تحت پیگرد قانونی قرار میگیرد؛ {{ config('app.name') }} هیچ شعبه دیگری ندارد.
                        </p>
                    </div>
                @endif
            </div>
        </div>
        {{--SERVICES AND SOCIAL MEDIAS--}}
        <div class="mt-0 bg-grey-300 text-center p-4 font-16">
            <div class="row mb-3">
                @if($footer_items->count()>0)
                    @foreach($footer_items as $footer_item)
                        @if($footer_item->links->count() > 0)
                            <div class="col-12 col-md @if($loop->first) mt-0 @else mt-3 @endif mt-md-1">
                                <h5>
                                    {{ $footer_item->title }}
                                </h5>
                                <hr class="w-50">
                                <div class="row">

                                    @foreach($footer_item->links as $footer_item_link)
                                        <div class="col-12 mt-3">
                                            <a href="{{ $footer_item_link->link }}"
                                               class="text-dark"
                                            >
                                                {{ $footer_item_link->title }}
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                {{--SOCIAL MEDIA--}}
                <div class="col-md-4 mt-3 mt-md-1" id="social_medias">
                    <h5>
                        شبکه های اجتماعی
                    </h5>
                    <hr class="w-50">
                    <div>
                        @if(isset($social_medias) && $social_medias->count() > 1)
                            @foreach($social_medias as $social_media)
                                <a target="_blank"
                                   href="{{ $social_media->link }}"
                                   title="{{ $social_media->title }}"
                                   class="text-dark mx-1"
                                >
                                    <i class="fab fa-{{ $social_media->icon }} fa-2x align-middle"></i>
                                </a>
                            @endforeach
                        @endif
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

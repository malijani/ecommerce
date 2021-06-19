<footer class="mt-5 mt-sm-3 p-4 p-sm-2 font-14">

    {{--FOOTER IMAGE--}}
    @include('front-v1.partials.shared.footer_image')

    {{--NEW BRIEFES--}}

    <div class="container-fluid">
        <div class="mt-5 bg-white p-3 rounded text-center">
            <div class="row">
                {{--PROPOSALS--}}
                @include('front-v1.partials.shared.footer_product_propose')

                {{--COMMENTS--}}
                @include('front-v1.partials.shared.footer_last_comments')

                {{--ARTICLES--}}
                @include('front-v1.partials.shared.footer_last_articles')

                {{--LICENSES--}}
                @include('front-v1.partials.shared.footer_licenses')
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{--FOOTER NAVBAR--}}
        <div class="mt-5 bg-dark text-center p-3 font-weight-bolder rounded-top">
            <div class="row align-items-center">
                {{--STATIC NAVS--}}
                @include('front-v1.partials.shared.footer_static_navs')
            </div>
        </div>
        {{--SERVICES AND SOCIAL MEDIAS--}}
        <div class="mt-0 bg-grey-300 text-center p-4 font-16">
            <div class="row">
                {{--FOOTER ITEMS--}}
                @include('front-v1.partials.shared.footer_items')

                {{--SOCIAL MEDIA--}}
                @include('front-v1.partials.shared.footer_social_medias')
            </div>
        </div>
        {{--TEXT AND LICENSE IMAGES--}}

        <div class="mt-0 p-3 mb-0 bg-grey-50">
            <div class="row align-items-center">
                {{--LICENSE IMAGES--}}
                @include('front-v1.partials.shared.footer_license_images')
                {{--TEXT INTRO--}}
                @include('front-v1.partials.shared.footer_text_intro')
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
                           title="توسعه دهنده وبسایت {{ config('app.short.name') }}"
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

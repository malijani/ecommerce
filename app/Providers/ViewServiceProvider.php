<?php

namespace App\Providers;

use App\Http\View\Composers\AboutImageMenuComposer;
use App\Http\View\Composers\FaviconComposer;
use App\Http\View\Composers\FooterImageComposer;
use App\Http\View\Composers\FooterItemComposer;
use App\Http\View\Composers\FooterLastArticleComposer;
use App\Http\View\Composers\FooterLastCommentComposer;
use App\Http\View\Composers\FooterLicenseComposer;
use App\Http\View\Composers\FooterLicenseImageComposer;
use App\Http\View\Composers\FooterProductProposeComposer;
use App\Http\View\Composers\FooterSocialMediaComposer;
use App\Http\View\Composers\FooterStaticNavComposer;
use App\Http\View\Composers\FooterTextIntroComposer;
use App\Http\View\Composers\LogoComposer;
use App\Http\View\Composers\SocialMediaButtonComposer;
use App\Http\View\Composers\TopNavComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('front-v1.partials.shared.favicon', FaviconComposer::class);
        View::composer('front-v1.partials.shared.top_nav', TopNavComposer::class);
        View::composer('front-v1.partials.shared.logo', LogoComposer::class);
        View::composer('front-v1.partials.shared.footer_image', FooterImageComposer::class);
        View::composer('front-v1.partials.shared.footer_product_propose', FooterProductProposeComposer::class);
        View::composer('front-v1.partials.shared.footer_last_comments', FooterLastCommentComposer::class);
        View::composer('front-v1.partials.shared.footer_last_articles', FooterLastArticleComposer::class);
        View::composer('front-v1.partials.shared.footer_licenses', FooterLicenseComposer::class);
        View::composer('front-v1.partials.shared.footer_static_navs', FooterStaticNavComposer::class);
        View::composer('front-v1.partials.shared.footer_items', FooterItemComposer::class);
        View::composer('front-v1.partials.shared.footer_social_medias', FooterSocialMediaComposer::class);
        View::composer('front-v1.partials.shared.footer_text_intro', FooterTextIntroComposer::class);
        View::composer('front-v1.partials.shared.footer_license_images', FooterLicenseImageComposer::class);
        View::composer('front-v1.partials.shared.about_image_menus', AboutImageMenuComposer::class);
        View::composer('front-v1.partials.shared.social_media_button', SocialMediaButtonComposer::class);
    }
}

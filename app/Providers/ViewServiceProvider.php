<?php

namespace App\Providers;

use App\Http\View\Composers\AboutImageMenuComposer;
use App\Http\View\Composers\AdminAsideComposer;
use App\Http\View\Composers\FaviconComposer;
use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\LogoComposer;
use App\Http\View\Composers\MenuComposer;
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
        /*FOOTER*/
        View::composer('front-v1.partials.footer', FooterComposer::class);
        /*MENU*/
        View::composer('front-v1.partials.nav', MenuComposer::class);
        /*ADMIN ASIDE*/
        View::composer('admin.partials.aside', AdminAsideComposer::class);
        /*PARTIALS*/
        View::composer('front-v1.partials.shared.favicon', FaviconComposer::class);
        View::composer('front-v1.partials.shared.top_nav', TopNavComposer::class);
        View::composer('front-v1.partials.shared.logo', LogoComposer::class);
        View::composer('front-v1.partials.shared.about_image_menus', AboutImageMenuComposer::class);
        View::composer('front-v1.partials.shared.social_media_button', SocialMediaButtonComposer::class);
    }
}

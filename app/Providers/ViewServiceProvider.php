<?php

namespace App\Providers;

use App\Http\View\Composers\AboutImageMenuComposer;
use App\Http\View\Composers\AdminAsideComposer;
use App\Http\View\Composers\FaviconComposer;
use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\MenuComposer;
use App\Http\View\Composers\SocialMediaButtonComposer;
use App\Http\View\Composers\SocialMediaComposer;
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
        /*ADMIN*/
        View::composer('admin.partials.aside', AdminAsideComposer::class);
        /*FRONTEND*/
        View::composer(['front-v1.partials.shared.favicon', 'admin.partials.metas'], FaviconComposer::class);
        View::composer('front-v1.partials.shared.header', MenuComposer::class);
        View::composer('front-v1.partials.shared.about_image_menus', AboutImageMenuComposer::class);
        View::composer('front-v1.partials.shared.social_media_button', SocialMediaButtonComposer::class);
        View::composer('front-v1.*', SocialMediaComposer::class);
        View::composer('front-v1.partials.shared.footer', FooterComposer::class);
    }
}

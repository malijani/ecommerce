<?php

namespace App\Providers;

use App\Article;
use App\Comment;
use App\Favicon;
use App\FooterImage;
use App\FooterItem;
use App\FooterLicense;
use App\FooterText;
use App\ImageMenu;
use App\License;
use App\Logo;
use App\Product;
use App\SocialMedia;
use App\SocialMediaButton;
use App\TopNav;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Nagy\LaravelRating\Models\Rating;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

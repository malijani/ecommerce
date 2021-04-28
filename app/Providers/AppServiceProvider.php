<?php

namespace App\Providers;

use App\Article;
use App\Comment;
use App\FooterImage;
use App\FooterItem;
use App\License;
use App\Logo;
use App\Product;
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

        /*MEDIUM SCREEN NAVIGATION ITEMS*/
        $top_navs_medium = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 1)
            ->orderBy('id')
            ->orderByDesc('status')
            ->get();
        View::share('top_navs_medium', $top_navs_medium);
        /*SMALL SCREEN NAVIGATION ITEMS*/
        $top_navs_small = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 0)
            ->orderByDesc('id')
            ->get();
        View::share('top_navs_small', $top_navs_small);

        /*WEBSITE LOGO*/
        $logo = Logo::withoutTrashed()->where('status', '1')->first();
        View::share('logo', $logo);

        /*FOOTER IMAGE*/
        $footer_image = FooterImage::withoutTrashed()->where('status', '1')->first();
        View::share('footer_image', $footer_image);

        /*FOOTER PRODUCTS*/

        $footer_product_proposals =  Product::withoutTrashed()
            ->where('status', 1)
            ->where('entity', '>', 0)
            ->where('visit', '>', 10)
            ->where('discount_percent', '>', 1)
            ->where('origin', 1)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get()
            ->filter(function($item){
                return $item->ratingsAvg() > 4;
            });
        View::share('footer_product_proposals', $footer_product_proposals);

        /*LAST COMMENTS*/
        $footer_last_comments = Comment::withoutTrashed()
            ->where('commentable_type', 'App\\Product')
            ->with('product:id,title,title_en')
            ->where('status', 1)
            ->limit(5)
            ->orderByDesc('updated_at')
            ->get()
            ->filter(function($item){
               if(isset($item->user)){
                   return $item->user->isNormal();
               } else {
                   return $item;
               }
            });
        View::share('footer_last_comments', $footer_last_comments);

        /*LAST ARTICLES*/
        $footer_last_articles = Article::withoutTrashed()
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        View::share('footer_last_articles', $footer_last_articles);

        /*ITEMS OF OPTIONAL AND STATIC LINKS*/
         $footer_licenses = FooterItem::query()->item('licenses');
         View::share('footer_licenses', $footer_licenses);

         $footer_static_navs = FooterItem::query()->item('static-nav');
         View::share('footer_static_navs' , $footer_static_navs);

         $footer_items = FooterItem::query()
             ->where('status', 1)
             ->get()
             ->filter(function($item){
                 return !in_array($item->title_en, ['licenses', 'static-nav']);
             });
         View::share('footer_items', $footer_items);

    }
}

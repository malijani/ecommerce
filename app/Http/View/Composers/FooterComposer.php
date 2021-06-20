<?php

namespace App\Http\View\Composers;


use App\Article;
use App\Comment;
use App\FooterImage;
use App\FooterItem;
use App\FooterLicense;
use App\FooterText;
use App\Product;
use App\SocialMedia;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        /*FOOTER IMAGE*/
        $footer_image = FooterImage::withoutTrashed()
            ->where('status', '1')
            ->first();

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

        /*LAST ARTICLES*/
        $footer_last_articles = Article::withoutTrashed()
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        /*LICENSES*/
        $footer_licenses = FooterItem::query()
            ->item('licenses');

        /*STATIC NAVS*/
        $footer_static_navs = FooterItem::query()
            ->item('static-nav');

        /*ITEMS*/
        $footer_items = FooterItem::query()
            ->where('status', 1)
            ->get()
            ->filter(function($item){
                return !in_array($item->title_en, ['licenses', 'static-nav']);
            });

        /*SOCIAL MEDIA*/
        $footer_social_medias = SocialMedia::query()
            ->where('status', 1)
            ->get();

        /*FOOTER TEXT*/
        $footer_text_intro = FooterText::query()
            ->where('status', 1)
            ->first();

        /*LICENSE IMAGES*/
        $footer_license_images = FooterLicense::query()
            ->where('status', 1)
            ->get();

        $view->with([
            'footer_image' => $footer_image,
            'footer_product_proposals' => $footer_product_proposals,
            'footer_last_comments' => $footer_last_comments,
            'footer_last_articles' => $footer_last_articles,
            'footer_licenses' => $footer_licenses,
            'footer_static_navs' => $footer_static_navs,
            'footer_items' => $footer_items,
            'footer_social_medias' => $footer_social_medias,
            'footer_text_intro' => $footer_text_intro,
            'footer_license_images' =>$footer_license_images,
        ]);
    }
}

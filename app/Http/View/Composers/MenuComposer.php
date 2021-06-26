<?php

namespace App\Http\View\Composers;

use App\Brand;
use App\Category;
use App\Logo;
use App\Page;
use App\TopNav;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        /*WEBSITE LOGO*/
        $logo = Logo::withoutTrashed()
            ->where('status', '1')
            ->first();

        /*MEDIUM SCREEN NAVIGATION ITEMS*/
        $top_navs_medium = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 1)
            ->orderBy('id')
            ->orderByDesc('status')
            ->get();

        /*SMALL SCREEN NAVIGATION ITEMS*/
        $top_navs_small = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 0)
            ->orderByDesc('id')
            ->get();


        /*NAVBAR*/
        $products = Category::withoutTrashed()
            ->with('activeChildren')
            ->where('title_en', 'products')
            ->first();

        $articles = Category::withoutTrashed()
            ->with('activeChildren')
            ->where('title', 'مقالات')
            ->first();

        $categories = [
            'products' => $products->toArray(),
            'articles' => $articles->toArray()
        ];



        $brands = Brand::withoutTrashed()
            ->where('status', 1)
            ->get();


        $pages = Page::withoutTrashed()
            ->where('menu', 1)
            ->where('status', 1)
            ->orderBy('sort')
            ->get();
        $custom_pages =[
            'faq' => [
                'title' => 'پرسش های متداول',
                'route' => route('faq.index')
            ],
        ];

        $view->with([
            'top_navs_medium' => $top_navs_medium,
            'top_navs_small' => $top_navs_small,
            'logo' => $logo,
            'categories' => $categories,
            'brands' => $brands,
            'pages' => $pages,
            'custom_pages' => $custom_pages,
        ]);

    }
}

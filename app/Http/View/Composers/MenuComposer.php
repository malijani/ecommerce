<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        /*TODO : CREATE A BETTER MENU*/
        /*\Menu::make('NavBar', function ($menu) {

            $menu->add(config('app.short.name') ?? 'خانه', [
                'route' => 'home',
                'nickname' => 'home',
            ])->activate();



            $menu->add('محصولات', ['route' => 'product.index', 'nickname' => 'product'])
                ->data(['header' => 'نمایش کامل محصولات']);

            $products = Category::withoutTrashed()
                ->with('activeChildren')
                ->where('title', 'محصولات')
                ->first();

            foreach ($products->children as $product_category) {
                $menu->item('product')->add($product_category->title, route('category.show', $product_category->title_en));
            }


            $menu->add('وبلاگ', ['route' => 'blog.index', 'nickname' => 'blog'])
                ->data('header', 'نمایش کامل مقالات');
            $articles = Category::withoutTrashed()
                ->with('activeChildren')
                ->where('title', 'مقالات')
                ->first();

            foreach ($articles->activeChildren as $article_category) {
                $menu->item('blog')->add($article_category->title, route('category.show', $article_category->title_en));
            }


            $menu->add('برند ها', ['route' => 'brand.index', 'nickname' => 'brand'])
                ->data('header', 'نمایش کامل برند ها');
            $brands = Brand::withoutTrashed()
                ->get();
            foreach ($brands as $brand) {
                $menu->item('brand')->add($brand->title, route('brand.show', $brand->title_en));
            }


            $menu->add('پرسشهای متداول', ['route' => 'faq.index', 'nickname' => 'faq']);

            $menu->add('حساب کاربری', ['route' => 'dashboard.index', 'nickname' => 'dashboard']);

            $menu->add('سبد خرید', ['route' => 'cart.index', 'nickname' => 'cart']);


            $menu->add('صفحات', ['route' => 'page.index', 'nickname' => 'page']);
            $pages = Page::withoutTrashed()
                ->where('menu', 1)
                ->where('status', 1)
                ->orderBy('sort')
                ->get();
            if (isset($pages)) {
                foreach ($pages as $page) {
                    $menu->item('page')->add($page->menu_title, route('page.show', $page->title_en));
                }
            }
        });*/
        /*HOME*/


        $view->with([

        ]);
    }
}

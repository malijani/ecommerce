<?php

namespace App\Http\Middleware;
use App\Brand;
use App\Category;
use Closure;



class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {



        \Menu::make('NavBar', function ($menu) {
            /*HOME*/
            $menu->add(config('app.name')??'خانه' , [
                'route'=>'home',
                'nickname'=>'home',
            ])->activate();


            /*PRODUCTS*/
            $menu->add('محصولات', ['route'=>'product.index', 'nickname'=>'product'])
                ->data(['header'=>'نمایش کامل محصولات']);

            $products = Category::withoutTrashed()
                ->with('activeChildren')
                ->where('title', 'محصولات')
                ->first();

            foreach($products->children as $product_category){
                $menu->item('product')->add($product_category->title , route('category.show', $product_category->title_en));
            }

            /*BLOG*/
            $menu->add('وبلاگ', ['route'=>'blog.index', 'nickname'=>'blog'])
                ->data('header', 'نمایش کامل مقالات');
            $articles = Category::withoutTrashed()
                ->with('activeChildren')
                ->where('title', 'مقالات')
                ->first();

            foreach ($articles->activeChildren as $article_category){
                $menu->item('blog')->add($article_category->title, route('category.show', $article_category->title_en));
            }

            /*BRANDS*/
            $menu->add('برند ها', ['route'=>'brand.index', 'nickname'=>'brand'])
            ->data('header', 'نمایش کامل برند ها');
            $brands = Brand::withoutTrashed()
                ->get();
            foreach ($brands as $brand){
                $menu->item('brand')->add($brand->title, route('brand.show', $brand->title_en));
            }

            /*USER PROFILE*/
            $menu->add('داشبورد', ['route'=>'dashboard.index', 'nickname'=>'dashboard']);
            /*SHOPPING CART*/
            $menu->add('سبد خرید', ['route'=>'cart.index', 'nickname'=>'cart']);

        });

        //dd(\Menu::get('NavBar')->item('product'));

        return $next($request);
    }
}

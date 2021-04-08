<?php

namespace App\Http\Middleware;
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
            $home = $menu->add(config('app.name')??'خانه' , [
                'route'=>'home',
                'nickname'=>'home',
            ])->active();
            $home->divide();

            $product = $menu->add('محصولات', ['route'=>'product.index', 'nickname'=>'product']);
            $product->add('زیر دسته محصول', 'gainer');

            $blog = $menu->add('وبلاگ', ['route'=>'blog.index', 'nickname'=>'blog']);
            $blog->add('زیر دسته وبلاگ' , 'blog');

            $brand = $menu->add('برند ها', ['route'=>'brand.index', 'nickname'=>'brand']);
            $brand->add('زیردسته برند', 'brand');
        });

        return $next($request);
    }
}

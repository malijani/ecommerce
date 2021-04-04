<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Brand;
use App\Category;
use App\Logo;
use App\Product;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware(['auth']);
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $banner = Banner::withoutTrashed()->where('status', '1')->first();
        $sliders = Slider::withoutTrashed()
            ->where('status', '1')
            ->orderByDesc('status')
            ->orderBy('sort')
            ->orderByDesc('id')
            ->get();
        // TODO : MAKE PRODUCT OR ARTICLES AS ENUM OR TINYINT SELECTION TYPE
        // get Products category by title_en : products :> it's important
        $categories = Category::withoutTrashed()
            ->where('title_en', 'products')
            ->with('children')
            ->where('menu', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->firstOrFail()
            ->children()
            ->get();

        $brands = Brand::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('id')
            ->take(4)
            ->get();
        $products = Product::withoutTrashed()
            ->where('status', 1)
            ->where('entity', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        return view('home', [
            'categories'=>$categories,
            'products'=>$products,
            'banner'=>$banner,
            'sliders'=>$sliders,
            'brands'=>$brands,
        ]);
    }
}

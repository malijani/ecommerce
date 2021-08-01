<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Brand;
use App\Category;
use App\HeaderPage;
use App\ImageMenu;
use App\Product;
use App\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Show the landing page of website
     *
     * @return View
     */
    public function home() : View
    {
        $banner = Banner::withoutTrashed()->where('status', '1')->first();
        $sliders = Slider::withoutTrashed()
            ->where('status', '1')
            ->orderByDesc('status')
            ->orderBy('sort')
            ->orderByDesc('id')
            ->get();

        // get Products category by title_en : products :> it's important
        try {
            $categories = Category::withoutTrashed()
                ->where('title_en', 'products')
                ->with('children')
                ->where('menu', 1)
                ->orderBy('created_at', 'DESC')
                ->orderBy('sort', 'ASC')
                ->firstOrFail()
                ->children()
                ->get();
        } catch (\Exception $e) {
            $categories = null;
        }

        $brands = Brand::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        $products = Product::withoutTrashed()
            ->where('status', 1)
            ->orderByDesc('entity')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        $main_image_menus = ImageMenu::query()
            ->where('type', 1)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $big_image_menus = ImageMenu::query()
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $footer_image_menus = ImageMenu::query()
            ->where('type', 4)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'home')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = config('app.long.title');
        }


        return view('home', [
            'title' => $title,
            'page_header' => $page_header,
            'categories' => $categories,
            'products' => $products,
            'banner' => $banner,
            'sliders' => $sliders,
            'brands' => $brands,
            'main_image_menus' => $main_image_menus,
            'big_image_menus' => $big_image_menus,
            'footer_image_menus' => $footer_image_menus,
        ]);
    }
}

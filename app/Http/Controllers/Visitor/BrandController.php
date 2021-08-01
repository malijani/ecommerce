<?php

namespace App\Http\Controllers\Visitor;

use App\Brand;
use App\HeaderPage;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {

        $brands = Brand::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('id')
            ->paginate(20);

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'brands')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'لیست برند های ' . config('app.brand.name');
        }

        return response()->view('front-v1.brand.index', [
            'title' => $title,
            'page_header' => $page_header,
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function show(string $slug): Response
    {
        $brand = Brand::withoutTrashed()
            ->where('title_en', $slug)
            ->first();

        if (empty($brand)) {
            $title = 'برند ' . $slug . ' در وبسایت ' . config('app.brand.name') . ' یافت نشد. ';
            $brands = Brand::withoutTrashed()
                ->where('status', 1)
                ->orderBy('sort')
                ->orderByDesc('id')
                ->limit(20)
                ->get();
            return response()
                ->view('front-v1.brand.404', [
                    'title' => $title,
                    'not_found' => $slug,
                    'brands' => $brands
                ]);
        }


        $products = Product::withoutTrashed()
            ->where('brand_id', $brand->id)
            ->get();

        $title = 'نمایش برند ' . $brand->title;
        $page_header = new \stdClass();
        $page_header->keywords = $brand->keywords;
        $page_header->description = $brand->description;
        $page_header->author = $brand->user->full_name;
        $page_header->url = route('brand.show', $brand->title_en);
        $page_header->image = asset($brand->pic ?? 'images/fallback/brand.png');
        $page_header->type = 'brand';

        return response()->view('front-v1.brand.show', [
            'title' => $title,
            'page_header' => $page_header,
            'brand' => $brand,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

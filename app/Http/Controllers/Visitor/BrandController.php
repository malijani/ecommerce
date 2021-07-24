<?php

namespace App\Http\Controllers\Visitor;

use App\Brand;
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
    public function index() : Response
    {
        $title = 'لیست برند ها';
        $brands = Brand::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('id')
            ->paginate(20);
        return response()->view('front-v1.brand.index', [
            'brands' => $brands,
            'title' => $title
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
    public function show(string $slug) : Response
    {
        $brand = Brand::withoutTrashed()
            ->where('title_en', $slug)
            ->first();

        if(empty($brand)){
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

        $title = 'نمایش برند '. $brand->title ;
        $products = Product::withoutTrashed()
            ->where('brand_id', $brand->id)
            ->get();

        return response()->view('front-v1.brand.show', [
            'brand' => $brand,
            'products'=>$products,
            'title'=>$title,
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

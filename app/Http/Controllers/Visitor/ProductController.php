<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $products = Product::withoutTrashed()
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->paginate(100);

        return response()->view('front-v1.product.index',[
            'products'=>$products,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        $product = Product::withoutTrashed()
            ->where('title_en', $slug)
            ->with('bef', 'af', 'category', 'user', 'brand', 'files')
            ->active()
            ->firstOrFail();

        $title = $product->title;
        return response()->view('front-v1.product.show', [
            'title' =>$title,
            'product'=>$product,
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

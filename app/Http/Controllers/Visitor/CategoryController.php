<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() : Response
    {
        return response()->view('front-v1.category.index');
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
     * @return  Response
     */
    public function show(string $slug) : Response
    {
        $category = Category::withoutTrashed()
            ->with('user', 'children')
            ->where('title_en', $slug)
            ->firstOrFail();
        $sub_categories = $category->activeChildren()->get();
        $products = Product::withoutTrashed()
            ->with('user', 'category', 'files')
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->paginate(100);

        $title = $category->title;

        return  response()->view('front-v1.category.show', [
            'title'=>$title,
            'category'=>$category,
            'products'=>$products,
            'sub_categories'=>$sub_categories,
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

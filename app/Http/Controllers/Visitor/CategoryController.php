<?php

namespace App\Http\Controllers\Visitor;

use App\Article;
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
    public function index(): Response
    {
        $title = 'لیست دسته بندی های وبسایت '. config('app.brand.name');
        $categories = Category::withoutTrashed()
            ->with('children')
            ->where('parent_id', 0)
            ->get();


        return response()->view('front-v1.category.index',[
            'title' => $title,
            'categories'=>$categories,
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
     * @return  Response
     */
    public function show(string $slug): Response
    {
        $category = Category::withoutTrashed()
            ->with('user', 'children', 'products', 'articles')
            ->where('title_en', $slug)
            ->first();


        if(empty($category)){
            $categories = Category::withoutTrashed()
                ->with('children')
                ->where('parent_id', 0)
                ->limit(20)
                ->get();
            $title = 'دسته بندی ' . $slug . ' در ' . config('app.brand.name'). ' یافت نشد! ';
            return response()
                ->view('front-v1.category.404', [
                    'categories' => $categories,
                    'title'=>  $title,
                    'not_found' => $slug
                ]);
        }

        $sub_categories = $category->activeChildren()->get();

        $products = Product::withoutTrashed()
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        $articles = Article::withoutTrashed()
            ->where('category_id', $category->id)
            ->orderByDesc('created_at')
            ->orderBy('sort')
            ->get();

        $title = $category->title;

        return response()->view('front-v1.category.show', [
            'title' => $title,
            'category' => $category,
            'products' => $products,
            'articles' => $articles,
            'sub_categories' => $sub_categories,
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

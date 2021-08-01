<?php

namespace App\Http\Controllers\Visitor;

use App\Article;
use App\HeaderPage;
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

        $categories = Category::withoutTrashed()
            ->with('children')
            ->where('parent_id', 0)
            ->get();

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'categories')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'لیست دسته بندی های وبسایت ' . config('app.brand.name');
        }

        return response()->view('front-v1.category.index', [
            'title' => $title,
            'page_header' => $page_header,
            'categories' => $categories,
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


        if (empty($category)) {
            $categories = Category::withoutTrashed()
                ->with('children')
                ->where('parent_id', 0)
                ->limit(20)
                ->get();
            $title = 'دسته بندی ' . $slug . ' در ' . config('app.brand.name') . ' یافت نشد! ';
            return response()
                ->view('front-v1.category.404', [
                    'categories' => $categories,
                    'title' => $title,
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
        $page_header = new \stdClass();
        $page_header->keywords = $category->keywords;
        $page_header->description = $category->description;
        $page_header->author = $category->user->full_name;
        $page_header->url = route('category.show', $category->title_en);
        $page_header->image = asset($category->pic ?? 'images/fallback/category.png');
        $page_header->type = 'category';

        return response()->view('front-v1.category.show', [
            'title' => $title,
            'page_header' => $page_header,
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

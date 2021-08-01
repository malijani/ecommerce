<?php

namespace App\Http\Controllers\Visitor;

use App\Article;
use App\HeaderPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $articles = Article::withoutTrashed()
            ->with('category')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->orderBy('sort', 'ASC')
            ->paginate(10);

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'articles')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = ' وبلاگ ' . config('app.brand.name');
        }

        return view('front-v1.blog.index', [
            'title' => $title,
            'page_header' => $page_header,
            'articles' => $articles,
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
     * @param string slug
     * @return mixed
     */
    public function show($slug)
    {
        $article = Article::withoutTrashed()
            ->with('user', 'category', 'bef', 'af')
            ->active()
            ->where('title_en', $slug)
            ->first();

        if (empty($article)) {
            $title = 'مقاله ' . $slug . ' در ' . config('app.brand.name') . ' یافت نشد ';

            $articles = Article::withoutTrashed()
                ->with('category')
                ->active()
                ->orderBy('created_at', 'DESC')
                ->orderBy('id', 'DESC')
                ->orderBy('sort', 'ASC')
                ->limit(10)
                ->get();

            return response()->view('front-v1.blog.404', [
                'articles' => $articles,
                'title' => $title,
                'not_found' => $slug,
            ]);
        }

        $comments = $article->comments()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->active()
            ->sort()
            ->get();

        $similar_articles = Article::withoutTrashed()
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->orderBy('sort', 'ASC')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(10)
            ->get();


        $other_articles = Article::withoutTrashed()
            ->with('category')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->orderBy('sort', 'ASC')
            ->limit(10)
            ->get();

        $article->increment('visit', 1);

        $title = $article->title;
        $page_header = new \stdClass();
        $page_header->keywords = $article->keywords;
        $page_header->description = $article->description;
        $page_header->author = $article->user->full_name;
        $page_header->url = route('blog.show', $article->title_en);
        $page_header->image = asset($article->pic ?? 'images/fallback/article.png');
        $page_header->type = 'article';

        return view('front-v1.blog.show', [
            'title' => $title,
            'page_header' => $page_header,
            'article' => $article,
            'comments' => $comments,
            'similar_articles' => $similar_articles,
            'other_articles' => $other_articles,
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

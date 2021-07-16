<?php

namespace App\Http\Controllers\Visitor;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'وبلاگ';
        $articles = Article::withoutTrashed()
            ->with('user', 'category', 'before', 'after')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->orderBy('sort', 'ASC')
            ->paginate(10);

        return view('front-v1.blog.index', [
            'title' => $title,
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
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::withoutTrashed()
            ->with('user', 'category', 'bef', 'af')
            ->active()
            ->where('title_en', $slug)
            ->first();

        if(empty($article)){
            $articles = "";
            $title = "مقاله ". $slug . " یافت نشد!";
            return response()->view('front-v1.blog.404', [
                'articles' => $articles,
                'title' => $title,
            ]);
        }
        $title = $article->title;

        $comments = $article->comments()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->active()
            ->sort()
            ->get();

        $article->increment('visit', 1);

        return view('front-v1.blog.show', [
            'title' => $title,
            'article' => $article,
            'comments' => $comments,
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

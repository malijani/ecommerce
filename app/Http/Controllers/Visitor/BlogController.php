<?php

namespace App\Http\Controllers\Visitor;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            ->paginate(12);

        return view('front-v1.blog.index', [
            'title'=>$title,
            'articles'=>$articles,
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
     * @param  \Illuminate\Http\Request  $request
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
            ->with('user', 'category', 'before', 'after')
            ->active()
            ->where('title_en' , $slug)
            ->firstOrFail();
        $title = $article->title;

        return view('front-v1.blog.show', [
           'title'=>$title,
            'article'=>$article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

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
            ->paginate(12);

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
            ->with('user', 'category', 'before', 'after')
            ->active()
            ->where('title_en', $slug)
            ->firstOrFail();

        $comments = $article->comments()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->active()
            ->sort()
            ->get();

        $title = $article->title;


        $user_rate = null ;
        $user = Auth::user();
        if(!is_null($user) && $user->isRated($article)){
            $user_rate = $user->getRatingValue($article);
        }

        $article->increment('visit');

        return view('front-v1.blog.show', [
            'title' => $title,
            'article' => $article,
            'comments' => $comments,
            'user_rate' => $user_rate,
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
        $article = Article::withoutTrashed()->find($id);
        if(is_null(Auth::id())){
            return response()->json('user_anonymous');
        } else {
            $user = Auth::user();
        }
        if(is_null($article)){
            return response()->json('article_404');
        }

        $request->validate([
            'rate'=>'required|numeric|min:1|max:5',
        ]);

        $user->rate($article, $request->input('rate'));

        return response()->json('رای شما با موفقیت ثبت شد!');

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

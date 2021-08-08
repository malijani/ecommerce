<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index() : View
    {
        $title = 'مدیریت مقالات';
        $articles = Article::withoutTrashed()
            ->with('user', 'category')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        return view('admin.article.index', [
            'title' => $title,
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create() : View
    {
        $title = 'ثبت مقاله جدید';
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', 1)
            ->where('title_en', 'articles')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $articles = Article::withoutTrashed()
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        return view('admin.article.create', [
            'title' => $title,
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'numeric'],
            'before' => ['required', 'numeric'],
            'after' => ['required', 'numeric'],
            'title' => ['required', 'min:2', 'max:70', 'unique:articles,title'],
            'title_en' => ['required', 'min:2', 'max:70', 'unique:articles,title_en'],
            'keywords' => ['nullable', 'min:2', 'max:70'],
            'description' => ['nullable', 'min:3', 'max:255'],
            'short_text' => ['nullable', 'min:3', 'max:255'],
            'long_text' => ['required', 'min:10', 'max:40000'],
            'period' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['nullable', 'min:2', 'max:70'],
        ]);

        $pic = imageUploader($request, 'pic', 'article');

        Article::query()->create(array_merge(
            $request->except('pic', 'title_en'),
            ['pic' => $pic],
            ['title_en' => Str::slug($request->input('title_en'))],
            ['user_id' => Auth::id()]
        ));

        return redirect(route('articles.index'))->with('success', 'مقاله با موفقیت ثبت شد');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {

        $article = Article::withoutTrashed()
            ->with('user', 'category')
            ->findOrFail($id);
        $title = ' ویرایش مقاله ' . $article->title;
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $articles = Article::withoutTrashed()
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        return view('admin.article.edit', [
            'article' => $article,
            'categories' => $categories,
            'title' => $title,
            'articles' => $articles,
        ]);
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
        $article = Article::withoutTrashed()->findOrFail($id);
        $request->validate([
            'category_id' => ['required', 'numeric'],
            'before' => ['required', 'numeric'],
            'after' => ['required', 'numeric'],
            'title' => ['required', 'min:2', 'max:70', 'unique:articles,title,' . $article->id],
            'title_en' => ['required', 'min:2', 'max:70', 'unique:articles,title_en,' . $article->id],
            'keywords' => ['nullable', 'min:2', 'max:70'],
            'description' => ['nullable', 'min:3', 'max:255'],
            'short_text' => ['nullable', 'min:3', 'max:255'],
            'long_text' => ['required', 'min:10', 'max:40000'],
            'period' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['nullable', 'min:2', 'max:70'],
        ]);


        if ($request->has('delete_pic') && $request->input('delete_pic') == "on") {
            if (!is_null($article->pic)) {
                unlink(public_path($article->pic));
            }
        }


        $pic = imageUploader($request, 'pic', 'article');


        if (!is_null($pic) && !is_null($article->pic)) {
            unlink(public_path($article->pic));
        }

        $article->update(array_merge(
            $request->except(['pic', 'title_en']),
            ['pic' => $pic ?? $article->pic],
            ['title_en' => Str::slug($request->input('title_en'))]
        ));
        return redirect(route('articles.index'))->with('success', ' مقاله ' . $article->title . ' با موفقیت به روز رسانی شد ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $article = Article::withoutTrashed()->findOrFail($id);
        $article->delete();
//        return redirect(route('articles.index'))->with('success', ' مقاله '.$article->title . ' با موفقیت حذف شد! ');
        return response()->json('مقاله ' . $article->title . ' با موفقیت حذف شد');

    }


}

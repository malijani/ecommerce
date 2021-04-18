<?php

namespace App\Http\Controllers\Visitor;

use App\Comment;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @param string $model
     * @param int $id
     * @return RedirectResponse
     */
    public function store(Request $request, string $model, int $id): RedirectResponse
    {

        $request->validate([
            'content' => 'bail|required|string|min:4|max:10000',
            'parent_id' => 'bail|required|numeric|min:0',
        ], [
            'content' => [
                'required' => 'تعیین محتوای نظر الزامیست',
                'string' => 'نوع داده ای نظر شما غیر مجاز است',
                'min' => 'حداقل چهار کاراکتر برای تعیین نظر الزامیست',
                'max' => 'حداکثر ده هزار کاراکتر برای نظر کاربران تعبیه شده',
            ],
            'parent_id' => [
                'required' => 'تعیین والد نظر الزامیست',
                'numeric' => 'آیدی والد عدد است',
            ],
        ]);

        $parent_id = $request->input('parent_id');
        if ($parent_id != 0) {
            $parent = Comment::withoutTrashed()->find($parent_id);
            if (!$parent) {
                $parent_id = 0;
            }
        }

        $allowed = ['Article', 'Product'];
        $object = app('App\\' . $model)::withoutTrashed()->find($id);
        if (!in_array($model, $allowed) || !$object) {
            return redirect()->back()->with('error', 'مشکل احتمالی در مسیر دهی وبسایت!');
        }

        $comment = new Comment();
        $comment->user_id = Auth::id() ?? null;
        $comment->commentable_type = 'App\\' . $model;
        $comment->commentable_id = $id;
        $comment->content = $request->input('content');
        $comment->parent_id = $parent_id;
        $message = 'نظر شما با موفقیت ثبت شد و پس از تایید مدیریت نمایش داده خواهد شد';
        if(Auth::user()->isAdmin()) {
            $comment->status = 1;
            $message = 'پاسخ شما ثبت شد';
        }
        $comment->save();

        return redirect()->back()->with('success', $message);
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

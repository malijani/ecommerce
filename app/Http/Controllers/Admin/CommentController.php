<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت نظرات وبسایت';
        $comments = Comment::withoutTrashed()
            ->with('children')
            ->sort()
            ->get();

        return response()->view('admin.comment.index', [
            'title' => $title,
            'comments' => $comments
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
        $comment = Comment::withoutTrashed()->findOrFail($id);

        $request->validate([
            'verify' => 'required|string|max:3|in:on,off',
        ]);
        $verify = $request->input('verify');
        if ($verify == 'on') {
            $comment->status = 1;
        } else {
            $comment->status = 0;
        }
        $comment->save();

        return response()->redirectToRoute('comments.index')->with('success', 'کامنت شماره ' . $comment->id . ' تایید شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::withoutTrashed()->with('children')->findOrFail($id);
        if ($comment->parent_id == 0) {
            // MAKE DEPTH 1 CHILDREN AS PARENT
            foreach ($comment->children()->get() as $comment_child) {
                $comment_child->parent_id = 0;
                $comment_child->save();
            }
        }
        $comment->delete();
        return response()->redirectToRoute('comments.index')->with('warning', 'کامنت ' . $comment->id . ' حذف شد');
    }
}

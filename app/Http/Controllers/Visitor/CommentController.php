<?php

namespace App\Http\Controllers\Visitor;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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
     * @return mixed
     */
    public
    function store(Request $request, string $model, int $id)
    {
        $rules = [
            'content' => 'bail|required|string|min:4|max:10000',
            'parent_id' => 'bail|required|numeric|min:0',
            'comment_captcha' => 'bail|required|captcha'
        ];
        $messages = [
            'content.required' => 'تعیین محتوای نظر الزامیست',
            'content.string' => 'نوع داده ای نظر شما غیر مجاز است',
            'content.min' => 'حداقل چهار کاراکتر برای تعیین نظر الزامیست',
            'content.max' => 'حداکثر ده هزار کاراکتر برای نظر کاربران تعبیه شده',

            'parent_id.required' => 'تعیین والد نظر الزامیست',
            'parent_id.numeric' => 'آیدی والد عدد است',

            'comment_captcha.required' => 'لطفاً کد کپچا را وارد نمایید.',
            'comment_captcha.captcha' => 'کد کپچا اشتباه است! با کلیک روی دکمه، کپچا را بروز رسانی کنید.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => $validator->errors()->toJson(),
                ], Response::HTTP_BAD_REQUEST);
            }
            return redirect()->back()->with('error', implode(',', $validator->errors()->all()));
        }

        $parent_id = $request->input('parent_id');
        if ($parent_id != 0) {
            $parent = Comment::withoutTrashed()->find($parent_id);
            if (empty($parent)) {
                $parent_id = 0;
            }
        }

        $allowed = ['Article', 'Product'];
        $object = app('App\\' . $model)::withoutTrashed()->find($id);
        if (empty($object) || !in_array($model, $allowed)) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'مسیر دهی نامعتبر!',
                ], Response::HTTP_BAD_REQUEST);
            }
            return redirect()->back()->with('error', 'مشکل احتمالی در مسیر دهی وبسایت!');
        }

        $comment = new Comment();
        $comment->user_id = Auth::id() ?? null;
        $comment->commentable_type = 'App\\' . $model;
        $comment->commentable_id = $id;
        $comment->content = $request->input('content');
        $comment->parent_id = $parent_id;
        /*CHECK COMMENTER ACCESS CONTROL LEVEL*/
        if (!empty(Auth::id()) && Auth::user()->isAdmin()) {
            $comment->status = 1;
            $message = 'نظر شما ثبت شد';
        } else {
            $comment->status = 0;
            $message = 'نظر شما با موفقیت ثبت شد و پس از تایید مدیریت نمایش داده خواهد شد';
        }
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
        return redirect()->back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}

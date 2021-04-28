<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت لینک صفحات مجازی';
        $social_medias = SocialMedia::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();
        return response()->view('admin.social-media.index', [
            'title'=>$title,
            'social_medias' => $social_medias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ایجاد لینک صفحه مجازی جدید';
        return response()->view('admin.social-media.create', [
            'title'=>$title,
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social_media = SocialMedia::query()->findOrFail($id);
        $title = 'ویرایش لینک صفحه مجازی '. $social_media->title;
        return response('admin.social-media.edit', [
            'social_media'=>$social_media,
            'title'=>$title
        ]);
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

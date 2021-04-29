<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
            'title' => $title,
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
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:70',
            'link' => 'required|string|min:1|max:100',
            'icon' => 'required|string|min:2|max:50',
            'status' => 'required|numeric|in:0,1',
            'side_image' => 'required|mimes:jpg,jpeg,png,gif|max:10240',
            'banner_image' => 'required|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $user_id = Auth::id();
        $side_image = imageUploader($request, 'side_image', 'social_media');
        $banner_image = imageUploader($request, 'banner_image', 'social_media');

        $social_media = SocialMedia::query()->create(array_merge(
            $request->except('side_image', 'banner_image'),
            ['side_image' => $side_image],
            ['banner_image' => $banner_image],
            ['user_id' => $user_id]
        ));
        return response()->redirectToRoute('social-medias.index')->with('success', 'صفحه شبکه اجتماعی ' . $social_media->title . ' با موفقیت افزوده شد. ');
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
        $social_media = SocialMedia::query()->findOrFail($id);
        $title = 'ویرایش لینک صفحه مجازی ' . $social_media->title;
        return response()->view('admin.social-media.edit', [
            'social_media' => $social_media,
            'title' => $title,
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
        $social_media = SocialMedia::query()->findOrFail($id);
        $request->validate([
            'title' => 'required|string|min:2|max:70',
            'link' => 'required|string|min:1|max:100',
            'icon' => 'required|string|min:2|max:50',
            'status' => 'required|numeric|in:0,1',
            'side_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:10240',
            'banner_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        if($request->hasFile('side_image')){
            File::delete(public_path().'/'.$social_media->side_image);
            $side_image = imageUploader($request, 'side_image', 'social_media');
        }

        if($request->hasFile('banner_image')) {
            File::delete(public_path().'/'.$social_media->banner_image);
            $banner_image = imageUploader($request, 'banner_image', 'social_media');
        }

        $social_media->update(array_merge(
            $request->except('side_image', 'banner_image'),
            ['side_image' => $side_image ?? $social_media->side_image],
            ['banner_image' => $banner_image ?? $social_media->banner_image ]
        ));

        return response()->redirectToRoute('social-medias.index')->with('success', 'صفحه شبکه اجتماعی ' . $social_media->title . 'با موفقیت بروز رسانی شد.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social_media = SocialMedia::query()->findOrFail($id);
        File::delete([public_path().'/'.$social_media->banner_image, public_path().'/'.$social_media->side_image]);
        $social_media->delete();
        return response()->json('صفحه شبکه اجتماعی '. $social_media->title . ' با موفقیت حذف شد');
    }
}

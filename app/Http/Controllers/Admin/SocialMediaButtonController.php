<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialMediaButton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaButtonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'دکمه های دسترسی سریع به صفحات مجازی';
        $social_media_buttons = SocialMediaButton::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();
        return response()->view('admin.social-media-button.index', [
            'title' => $title,
            'social_media_buttons' => $social_media_buttons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن دکمه شناور صفحه مجازی';
        return response()->view('admin.social-media-button.create', [
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
            'title' => 'required|string|min:2|max:50',
            'link' => 'required|string|min:2:max:100',
            'status' => 'required|numeric|in:0,1',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1024'
        ]);

        $image = imageUploader($request, 'image', 'social_media_button');

        if ($request->input('status') == 1) {
            /*DEACTIVATE LAST ACTIVE OBJECT*/
            $last_active_button = SocialMediaButton::query()->where('status', 1)->first();
            if (!is_null($last_active_button)) {
                $last_active_button->status = 0;
                $last_active_button->save();
            }
        }

        /*SAVE OBJECT*/
        SocialMediaButton::query()->create(array_merge(
            $request->except(['image']),
            ['image' => $image],
            ['user_id' => Auth::id()]
        ));

        /*REDIRECT TO INDEX*/
        return response()
            ->redirectToRoute('social-media-buttons.index')
            ->with('success', 'دکمه شبکه اجتماعی جدید با موفقیت افزوده شد');
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
        $social_media_button = SocialMediaButton::query()->findOrFail($id);
        $title = 'بروز رسانی دکمه شناور شبکه اجتماعی ' . $social_media_button->title;

        return response()->view('admin.social-media-button.edit', [
            'social_media_button' => $social_media_button,
            'title' => $title
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
        $social_media_button = SocialMediaButton::query()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT BUTTON*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            /*DISABLE LAST ACTIVATED OBJECT*/
            $last_active_button = SocialMediaButton::query()->where('status', 1)->first();
            if (!is_null($last_active_button) && $last_active_button->id == $id) {
                return response()
                    ->redirectToRoute('social-media-buttons.index')
                    ->with('warning', 'دکمه شناور شبکه اجتماعی بعنوان پیشفرض تعیین شده!');
            }
            /*Change SELECTED OBJECT Status*/
            $social_media_button->status = 1;
            $social_media_button->save();
            if (!is_null($last_active_button)) {
                /*DEACTIVATE LAST ACTIVE OBJECT*/
                $last_active_button->status = 0;
                $last_active_button->save();
            }
            return response()
                ->redirectToRoute('social-media-buttons.index')
                ->with('success', 'دکمه شناور شبکه اجتماعی بعنوان پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE OTHER FIELDS EXCEPT STATUS*/
        $request->validate([
            'image' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:1024'],
            'title' => ['required', 'string', 'min:2', 'max:50'],
            'link' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $image = $social_media_button->image;
        if ($request->has('image')) {
            unlink(public_path($image));
            $image = imageUploader($request, 'image', 'social_media_button');
        }

        $social_media_button->update(array_merge(
            $request->except(['image']),
            ['image' => $image]
        ));

        return response()
            ->redirectToRoute('social-media-buttons.index')
            ->with('success', 'دکمه شناور شبکه اجتماعی ' . $social_media_button->title . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $last_active_button = SocialMediaButton::query()->where('status', 1)->first();
        $social_media_button = SocialMediaButton::query()->findOrFail($id);
        if (!is_null($last_active_button)) {
            if ($last_active_button->id != $social_media_button->id) {
                $social_media_button->delete();
                unlink(public_path($social_media_button->image));
                return response()
                    ->redirectToRoute('social-media-buttons.index')
                    ->with('success', 'دکمه شناور شبکه اجتماعی با موفقیت حذف شد');
            } else {
                return response()
                    ->redirectToRoute('social-media-buttons.index')
                    ->with('error', 'دکمه شناور شبکه اجتماعی نباید دکمه پیشفرض باشد!');
            }
        } else {
            $social_media_button->delete();
            unlink(public_path($social_media_button->image));
            return response()
                ->redirectToRoute('social-media-buttons.index')
                ->with('success', 'دکمه شناور شبکه اجتماعی با موفقیت حذف شد');
        }
    }
}

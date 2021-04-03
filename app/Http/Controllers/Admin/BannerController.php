<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت بنر صفحه اصلی';
        $banners = Banner::withoutTrashed()
            ->orderByDesc('status')
            ->get();

        return response()->view('admin.banner.index', [
            'title' => $title,
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ثبت بنر جدید';
        return response()->view('admin.banner.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        /*VALIDATE REQUEST*/
        $request->validate([
            'pic' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:15', 'max:70'],
            'status' => ['sometimes', 'string', 'max:2'],
        ]);


        /*STORE FILE*/
        $pic = imageUploader($request, 'pic', 'banner');

        /*SET STATUS*/
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
            /*DEACTIVATE LAST ACTIVE BANNER*/
            $last_active_banner = Banner::query()->where('status', '1')->first();
            if(!is_null($last_active_banner)){
                $last_active_banner->status = 0;
                $last_active_banner->save();
            }
        }

        /*SAVE OBJECT*/
        Banner::query()->create(array_merge(
            $request->except(['pic', 'status']),
            ['pic' => $pic],
            ['status' => $status],
            ['user_id' => Auth::id()]
        ));

        /*REDIRECT TO INDEX*/
        return response()->redirectToRoute('banners.index')->with('success', 'بنر جدید با موفقیت افزوده شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // THIS METHOD IS EXCLUDED
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::withoutTrashed()->findOrFail($id);
        $title = "بروز رسانی بنر شماره  " . $banner->id;
        return response()->view('admin.banner.edit', [
            'banner' => $banner,
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
    public function update(Request $request, $id): RedirectResponse
    {
        $banner = Banner::withoutTrashed()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT IMAGE*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            /*CHECK ACTIVATE BANNER*/
            $last_active_banner = Banner::withoutTrashed()->where('status', 1)->first();
            if (!is_null($last_active_banner) && $last_active_banner->id == $id) {
                return response()->redirectToRoute('banners.index')->with('warning', 'بنر انتخاب شده ، بنر پیشفرض می‌باشد.');
            }
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            /*Change Banner Status*/
            $banner->status = 1;
            $banner->save();
            if (!is_null($last_active_banner)) {
                /*DEACTIVATE LAST ACTIVE BANNER*/
                $last_active_banner->status = 0;
                $last_active_banner->save();
            }
            return response()->redirectToRoute('banners.index')->with('success', 'بنر منتخب بعنوان بنر پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE PIC_ALT AND PIC*/
        $request->validate([
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:15', 'max:70'],
        ]);

        $pic = $banner->pic;
        if ($request->has('pic')) {
            unlink(public_path($pic));
            $pic = imageUploader($request, 'pic', 'banner');
        }

        $banner->update(array_merge(
            $request->except(['pic']),
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('banners.index')->with('success', 'بنر شماره ' . $banner->id . ' با موفقیت بروزرسانی شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $last_active_banner = Banner::withoutTrashed()->where('status', 1)->first();

        if (!is_null($last_active_banner)) {
            if ($last_active_banner->id != $id) {
                Banner::withoutTrashed()->findOrFail($id)->delete();
                return response()->redirectToRoute('banners.index')->with('success', 'بنر با موفقیت حذف شد');
            }
        }
        return response()->redirectToRoute('banners.index')->with('error', 'بنر انتخابی نباید بنر پیشفرض باشد!');

    }
}

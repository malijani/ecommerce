<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت لوگو وبسایت';
        $logos = Logo::withoutTrashed()
            ->orderByDesc('status')
            ->get();

        return response()->view('admin.logo.index', [
            'title' => $title,
            'logos' => $logos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن لوگو';
        return response()->view('admin.logo.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /*VALIDATE REQUEST*/
        $request->validate([
            'pic' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'status' => ['sometimes', 'string', 'max:2'],
        ]);


        /*STORE FILE*/
        $pic = imageUploader($request, 'pic', 'logo');

        /*SET STATUS*/
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
            /*DEACTIVATE LAST ACTIVE OBJECT*/
            $last_active_logo = Logo::query()->where('status', '1')->first();
            if (!is_null($last_active_logo)) {
                $last_active_logo->status = 0;
                $last_active_logo->save();
            }
        }

        /*SAVE OBJECT*/
        Logo::query()->create(array_merge(
            $request->except(['pic', 'status']),
            ['pic' => $pic],
            ['status' => $status],
            ['user_id' => Auth::id()]
        ));

        /*REDIRECT TO INDEX*/
        return response()->redirectToRoute('logos.index')->with('success', 'لوگو جدید با موفقیت ثبت شد');
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
        $logo = Logo::withoutTrashed()->findOrFail($id);
        $title = "بروز رسانی لوگو شماره  " . $logo->id;
        return response()->view('admin.logo.edit', [
            'logo' => $logo,
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $logo = Logo::withoutTrashed()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT IMAGE*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            /*CHECK ACTIVATE BANNER*/
            $last_active_logo = Logo::withoutTrashed()->where('status', 1)->first();
            if (!is_null($last_active_logo) && $last_active_logo->id == $id) {
                return response()->redirectToRoute('logos.index')->with('warning', 'لوگو انتخاب شده ، لوگو پیشفرض می‌باشد.');
            }
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            /*Change Banner Status*/
            $logo->status = 1;
            $logo->save();
            if (!is_null($last_active_logo)) {
                /*DEACTIVATE LAST ACTIVE BANNER*/
                $last_active_logo->status = 0;
                $last_active_logo->save();
            }
            return response()->redirectToRoute('logos.index')->with('success', 'لوگو منتخب بعنوان لوگو پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE PIC_ALT AND PIC*/
        $request->validate([
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
        ]);

        $pic = $logo->pic;
        if ($request->has('pic')) {
            unlink(public_path($pic));
            $pic = imageUploader($request, 'pic', 'logo');
        }

        $logo->update(array_merge(
            $request->except(['pic']),
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('logos.index')->with('success', 'لوگو شماره ' . $logo->id . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $last_active_logo = Logo::withoutTrashed()->where('status', 1)->first();
        $logo = Logo::withoutTrashed()->findOrFail($id);
        if (!is_null($last_active_logo)) {
            if ($last_active_logo->id != $logo->id) {
                $logo->delete();
                return response()->redirectToRoute('logos.index')->with('success', 'لوگو با موفقیت حذف شد');
            } else {
                return response()->redirectToRoute('logos.index')->with('error', 'لوگو انتخابی نباید لوگو پیشفرض باشد!');
            }
        } else {
            $logo->delete();
            return response()->redirectToRoute('logos.index')->with('success', 'لوگو با موفقیت حذف شد');
        }

    }
}

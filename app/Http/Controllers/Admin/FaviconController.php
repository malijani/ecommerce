<?php

namespace App\Http\Controllers\Admin;

use App\Favicon;
use App\Http\Controllers\Controller;
use App\Rules\CheckIfFavicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaviconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت فاواکن های وبسایت';
        $favicons = Favicon::query()
            ->orderByDesc('status')
            ->get();

        return response()->view('admin.favicon.index', [
            'title' => $title,
            'favicons' => $favicons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن فاواکن';
        return response()->view('admin.favicon.create', [
            'title' => $title,
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
        /*VALIDATE REQUEST*/
        $request->validate([
            'pic' => ['required', 'mimes:ico', 'max:300', new CheckIfFavicon],
            'status' => ['sometimes', 'string', 'max:2', 'in:on'],
        ]);


        /*STORE FILE*/
        $pic = icoUploader($request, 'pic', 'favicon');

        /*SET STATUS*/
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
            /*DEACTIVATE LAST ACTIVE OBJECT*/
            $last_active_fav = Favicon::query()->where('status', '=',1)->first();
            if (!is_null($last_active_fav)) {
                $last_active_fav->status = 0;
                $last_active_fav->save();
            }
        }

        /*SAVE OBJECT*/
        Favicon::query()->create(array_merge(
            ['pic' => $pic],
            ['status' => $status],
            ['user_id' => Auth::id()]
        ));

        /*REDIRECT TO INDEX*/
        return response()
            ->redirectToRoute('favicons.index')
            ->with('success', 'فاواکن جدید با موفقیت ثبت شد');
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
        $favicon = Favicon::query()->findOrFail($id);
        $title = "بروز رسانی فاواکن شماره  " . $favicon->id;
        return response()->view('admin.favicon.edit', [
            'website_fav' => $favicon,
            'title' => $title,
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
        $favicon = Favicon::query()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT OBJECT*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->ajax()) {
            /*CHECK ACTIVATE OBJECT*/
            $last_active_fav = Favicon::query()->where('status', 1)->first();
            if (!is_null($last_active_fav) && $last_active_fav->id == $id) {
                return response()
                    ->redirectToRoute('favicons.index')
                    ->with('warning', 'فاواکن انتخاب شده ، فاواکن پیشفرض می‌باشد.');
            }
            $request->validate([
                'status' => ['required', 'string', 'size:2', 'in:on'],
            ]);
            /*Change OBJECT Status*/
            $favicon->status = 1;
            $favicon->save();
            if (!is_null($last_active_fav)) {
                /*DEACTIVATE LAST ACTIVE OBJECT*/
                $last_active_fav->status = 0;
                $last_active_fav->save();
            }
            return response()
                ->redirectToRoute('favicons.index')
                ->with('success', 'فاواکن منتخب بعنوان فاواکن پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE PIC_ALT AND PIC*/
        $request->validate([
            'pic' => ['required', 'mimes:ico', 'max:300', new CheckIfFavicon],
        ]);

        $pic = $favicon->pic;
        if ($request->has('pic')) {
            unlink(public_path($pic));
            $pic = icoUploader($request, 'pic', 'favicon');
        }

        $favicon->update(array_merge(
            ['pic' => $pic]
        ));

        return response()
            ->redirectToRoute('favicons.index')
            ->with('success', 'فاواکن شماره ' . $favicon->id . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $last_active_fave = Favicon::query()->where('status', 1)->first();
        $favicon = Favicon::query()->findOrFail($id);
        if (!is_null($last_active_fave)) {
            if ($last_active_fave->id != $favicon->id) {
                unlink(public_path($favicon->pic));
                $favicon->delete();
                return response()
                    ->redirectToRoute('favicons.index')
                    ->with('success', 'فاواکن با موفقیت حذف شد');
            } else {
                return response()
                    ->redirectToRoute('favicons.index')
                    ->with('error', 'فاواکن انتخابی نباید فاواکن پیشفرض باشد!');
            }
        } else {
            unlink(public_path($favicon->pic));
            $favicon->delete();
            return response()
                ->redirectToRoute('favicons.index')
                ->with('success', 'فاواکن با موفقیت حذف شد');
        }
    }
}

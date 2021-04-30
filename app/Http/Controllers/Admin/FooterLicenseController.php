<?php

namespace App\Http\Controllers\Admin;

use App\FooterLicense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'نماد های فوتر';
        $footer_licenses = FooterLicense::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.footer-license.index', [
            'title' => $title,
            'footer_licenses' => $footer_licenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن نماد فوتر جدید';
        return response()->view('admin.footer-license.create', [
            'title' => $title
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
            'link' => 'required|string|min:2|max:100',
            'status' => 'required|numeric|in:0,1',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:1024'
        ]);

        $image = imageUploader($request, 'image', 'footer_license');

        $footer_license = FooterLicense::query()->create(array_merge(
            $request->except('image'),
            ['image' => $image],
            ['user_id' => Auth::id()]
        ));
        return response()
            ->redirectToRoute('footer-licenses.index')
            ->with('success', 'نماد فوتر ' . $footer_license->title . ' با موفقیت افزوده شد');

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
        $footer_license = FooterLicense::query()->findOrFail($id);
        $title = 'بروز رسانی نماد فوتر ' . $footer_license->title;
        return response()->view('admin.footer-license.edit', [
            'footer_license' => $footer_license,
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
        $footer_license = FooterLicense::query()->findOrFail($id);

        /*PATCH REQUEST*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            if ($footer_license->status == 0) {
                $footer_license->status = 1;
            } else {
                $footer_license->status = 0;
            }
            $footer_license->save();
            return response()
                ->redirectToRoute('footer-licenses.index')
                ->with('success', 'نماد مورد نظر به نماد های فعال افزوده شد.');
        }

        /*PUT REQUEST*/
        $request->validate([
            'title' => 'required|string|min:2|max:50',
            'link' => 'required|string|min:2|max:100',
            'status' => 'required|numeric|in:0,1',
            'image' => 'nullable|mimes:jpg,png,jpeg,gif|max:1024'
        ]);

        $image = $footer_license->image;
        if ($request->has('image')) {
            unlink(public_path($image));
            $image = imageUploader($request, 'image', 'footer_license');
        }

        $footer_license->update(array_merge(
            $request->except(['image']),
            ['image' => $image]
        ));

        return response()
            ->redirectToRoute('footer-licenses.index')
            ->with('success', 'نماد فوتر  ' . $footer_license->title . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $footer_license = FooterLicense::query()->findOrFail($id);
        $footer_license->delete();
        unlink(public_path($footer_license->image));
        return response()
            ->redirectToRoute('footer-licenses.index')
            ->with('success', 'نماد فوتر ' . $footer_license->title . ' با موفقیت حذف شد.');
    }
}

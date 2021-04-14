<?php

namespace App\Http\Controllers\Admin;

use App\FooterImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FooterImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'تصاویر فوتر';
        $footer_images = FooterImage::withoutTrashed()
            ->orderByDesc('status')
            ->get();

        return response()->view('admin.footer-image.index', [
            'title' => $title,
            'footer_images' => $footer_images,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        $title = 'ثبت تصویر فوتر جدید';
        return response()->view('admin.footer-image.create', [
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

        $request->validate([
            'pic' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:1', 'max:70'],
            'status' => ['sometimes', 'string', 'max:2'],
        ]);


        /*STORE FILE*/
        $pic = imageUploader($request, 'pic', 'footer');

        /*SET STATUS*/
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
            /*DEACTIVATE LAST ACTIVE FOOTER IMAGE*/
            $last_active_footer_image = FooterImage::query()->where('status', '1')->first();
            if (!is_null($last_active_footer_image)) {
                $last_active_footer_image->status = 0;
                $last_active_footer_image->save();
            }
        }

        /*SAVE OBJECT*/
        FooterImage::query()->create(array_merge(
            $request->except(['pic', 'status']),
            ['pic' => $pic],
            ['status' => $status],
            ['user_id' => Auth::id()]
        ));

        return response()->redirectToRoute('footer-images.index')->with('success', 'تصویر فوتر جدید با موفقیت افزوده شد');
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
        $footer_image = FooterImage::withoutTrashed()->findOrFail($id);
        $title = 'ویرایش تصویر فوتر شماره ' . $footer_image->id;
        return response()->view('admin.footer-image.edit', [
            'footer_image' => $footer_image,
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
        $footer_image = FooterImage::withoutTrashed()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT IMAGE*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            /*CHECK ACTIVATE FOOTER IMAGE*/
            $last_active_footer_image = FooterImage::withoutTrashed()->where('status', 1)->first();
            if (!is_null($last_active_footer_image) && $last_active_footer_image->id == $id) {
                return response()->redirectToRoute('footer-images.index')->with('warning', 'تصویر فوتر انتخاب شده ، تصویر پیشفرض می‌باشد.');
            }
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            /*Change FOOTER IMAGE Status*/
            $footer_image->status = 1;
            $footer_image->save();
            if (!is_null($last_active_footer_image)) {
                /*DEACTIVATE LAST ACTIVE FOOTER IMAGE*/
                $last_active_footer_image->status = 0;
                $last_active_footer_image->save();
            }
            return response()->redirectToRoute('footer-images.index')->with('success', 'تصویر فوتر منتخب بعنوان فوتر پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE PIC_ALT AND PIC*/
        $request->validate([
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:1', 'max:70'],
        ]);

        $pic = $footer_image->pic;
        if ($request->has('pic')) {
            unlink(public_path($pic));
            $pic = imageUploader($request, 'pic', 'footer');
        }

        $footer_image->update(array_merge(
            $request->except(['pic']),
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('footer-images.index')->with('success', 'تصویر فوتر شماره ' . $footer_image->id . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $last_active_footer_image = FooterImage::withoutTrashed()->where('status', 1)->first();
        $footer_image = FooterImage::withoutTrashed()->findOrFail($id);

        if (!is_null($last_active_footer_image)) {
            if ($last_active_footer_image->id != $id) {
                $footer_image->delete();
                return response()->redirectToRoute('footer-images.index')->with('success', 'تصویر فوتر با موفقیت حذف شد');
            } else {
                return response()->redirectToRoute('footer-images.index')->with('error', 'تصویر فوتر انتخابی نباید تصویر فوتر پیشفرض باشد!');
            }
        } else {
            $footer_image->delete();
            return response()->redirectToRoute('footer-images.index')->with('success', 'تصویر فوتر با موفقیت حذف شد');
        }

    }
}

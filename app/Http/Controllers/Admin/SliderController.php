<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت اسلایدر های وبسایت';
        $sliders = Slider::withoutTrashed()
            ->orderByDesc('status')
            ->orderBy('sort')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.slider.index', [
            'title' => $title,
            'sliders' => $sliders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن اسلایدر';
        return response()->view('admin.slider.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        /*VALIDATE REQUEST*/
        $request->validate([
            'pic' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:15', 'max:70'],
            'title'=> ['required', 'string', 'min:2', 'max:70'],
            'status' => ['sometimes', 'string', 'max:2'],
        ]);


        /*STORE FILE*/
        $pic = imageUploader($request, 'pic', 'slider');

        $status = 0;
        if ($request->has('status')) {
            $status = 1;
        }


        /*SAVE OBJECT*/
        Slider::query()->create(array_merge(
            $request->except(['pic', 'status']),
            ['pic' => $pic],
            ['status' => $status],
            ['user_id' => Auth::id()]
        ));

        /*REDIRECT TO INDEX*/
        return response()->redirectToRoute('sliders.index')->with('success', 'اسلایدر جدید با موفقیت افزوده شد');
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

        $slider = Slider::withoutTrashed()->findOrFail($id);
        $title = 'بروز رسانی اسلایدر  '. $slider->title;

        return response()->view('admin.slider.edit',[
           'slider'=>$slider,
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
    public function update(Request $request, $id) : RedirectResponse
    {
        $slider = Slider::withoutTrashed()->findOrFail($id);

        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT IMAGE*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);
            /*CHANGE SLIDER STATUS*/
            if($slider->status == 0){
                $slider->status = 1;
            } else {
                $slider->status = 0;
            }
            $slider->save();
            return response()->redirectToRoute('sliders.index')->with('success', 'اسلایدر منتخب به اسلایدر های قابل نمایش  افزوده شد.');
        }


        /*VIEW PUT REQUEST ONLY CHANGE PIC, PIC_ALT, TITLE, LINK*/
        $request->validate([
            'pic' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt' => ['required', 'string', 'min:2', 'max:70'],
            'title'=> ['required', 'string', 'min:2', 'max:70'],
            'link' => ['required', 'string', 'min:15', 'max:70'],
        ]);

        $pic = $slider->pic;
        if ($request->has('pic')) {
            unlink(public_path($pic));
            $pic = imageUploader($request, 'pic', 'slider');
        }

        $slider->update(array_merge(
            $request->except(['pic']),
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('sliders.index')->with('success', 'اسلایدر  ' . $slider->title . ' با موفقیت بروزرسانی شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id) : RedirectResponse
    {
        Slider::withoutTrashed()->findOrFail($id)->delete();
        return response()->redirectToRoute('sliders.index')->with('success', 'اسلایدر با موفقیت حذف شد');
    }
}

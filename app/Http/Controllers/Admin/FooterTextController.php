<?php

namespace App\Http\Controllers\Admin;

use App\FooterText;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت نوشته انتهایی فوتر';
        $footer_texts = FooterText::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();
        return response()->view('admin.footer-text.index', [
            'footer_texts' => $footer_texts,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن متن فوتر جدید';
        return response()->view('admin.footer-text.create', [
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
            'content' => 'required|string|min:10|max:6000',
            'status' => 'required|numeric|in:0,1',
        ]);

        if ($request->input('status') == 1) {
            /*DEACTIVATE LAST ACTIVE OBJECT*/
            $last_active_footer_text = FooterText::query()->where('status', '1')->first();
            if (!is_null($last_active_footer_text)) {
                $last_active_footer_text->status = 0;
                $last_active_footer_text->save();
            }
        }

        $footer_text = FooterText::query()->create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()],
        ));

        return response()->redirectToRoute('footer-texts.index')->with('success', 'متن فوتر ' . $footer_text->id . ' با موفقیت افزوده شد.');

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
        $footer_text = FooterText::query()->findOrFail($id);
        $title = 'بروز رسانی متن فوتر ' . $footer_text->title;
        return response()->view('admin.footer-text.edit', [
            'footer_text' => $footer_text,
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
        $footer_text = FooterText::query()->findOrFail($id);


        /*AJAX PATCH REQUEST : ONLY CHANGE DEFAULT OBJECT*/
        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            /*CHECK ACTIVATE OBJECT*/
            $last_active_footer_text = FooterText::query()->where('status', 1)->first();
            if (!is_null($last_active_footer_text) && $last_active_footer_text->id == $id) {
                return response()
                    ->redirectToRoute('footer-texts.index')
                    ->with('warning', 'متن فوتر انتخاب شده ، متن فوتر پیشفرض می‌باشد.');
            }
            $request->validate([
                'status' => ['required', 'string', 'in:on'],
            ]);
            /*Change OBJECT Status*/
            $footer_text->status = 1;
            $footer_text->save();
            if (!is_null($last_active_footer_text)) {
                /*DEACTIVATE LAST ACTIVE OBJECT*/
                $last_active_footer_text->status = 0;
                $last_active_footer_text->save();
            }
            return response()
                ->redirectToRoute('footer-texts.index')
                ->with('success', 'متن فوتر منتخب بعنوان متن فوتر پیشفرض تعیین شد.');
        }

        /*VIEW PUT REQUEST ONLY CHANGE TITLE AND CONTENT*/
        $request->validate([
            'title' => 'required|string|min:2|max:50',
            'content' => 'required|string|min:10|max:6000',
        ]);

        $footer_text->update($request->all());

        return response()
            ->redirectToRoute('footer-texts.index')
            ->with('success', 'متن فوتر  ' . $footer_text->title . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $footer_text = FooterText::query()->findOrFail($id);
        $last_active_footer_text = FooterText::query()->where('status', 1)->first();
        if (!is_null($last_active_footer_text)) {
            if ($last_active_footer_text->id != $footer_text->id) {
                $footer_text->delete();
                return response()
                    ->redirectToRoute('footer-texts.index')
                    ->with('success', 'متن فوتر با موفقیت حذف شد');
            } else {
                return response()
                    ->redirectToRoute('footer-texts.index')
                    ->with('error', 'متن فوتر انتخابی نباید متن فوتر پیشفرض باشد!');
            }
        } else {
            $footer_text->delete();
            return response()
                ->redirectToRoute('footer-texts.index')
                ->with('success', 'متن فوتر با موفقیت حذف شد');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\FaqPage;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "مدیریت پرسشهای متداول";

        $faqs = Faq::withoutTrashed()
            ->orderByDesc('status')
            ->orderBy('sort')
            ->get();

        $faq_page = FaqPage::query()->first();

        return response()->view('admin.faq.index', [
            'title' => $title,
            'faqs' => $faqs,

            'faq_page'=>$faq_page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ثبت پرسش متداول';

        return response()->view('admin.faq.create', [
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
            'question' => ['required', 'string', 'min:5', 'max:70'],
            'answer' => ['required', 'min:5'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'collapse' => ['required', 'numeric', 'in:0,1'],
            'sort' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);

        Faq::query()->create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        return response()->redirectToRoute('faqs.index')->with('success', 'پرسش متداول جدید با موفقیت افزوده شد!');
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
        $faq = Faq::withoutTrashed()->findOrFail($id);
        $title = 'ویرایش پرسش متداول شماره ' . $faq->id;

        return response()->view('admin.faq.edit', [
            'faq' => $faq,
            'title' => $title
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
        $faq = Faq::withoutTrashed()->findOrFail($id);
        $request->validate([
            'question' => ['required', 'string', 'min:5', 'max:70'],
            'answer' => ['required', 'min:5'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'collapse' => ['required', 'numeric', 'in:0,1'],
            'sort' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);

        $faq->update($request->all());

        return response()->redirectToRoute('faqs.index')->with('success', 'پرسش متداول شماره ' . $faq->id . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($id): RedirectResponse
    {
        $faq = Faq::withoutTrashed()->findOrFail($id);
        $faq->delete();
        return response()->redirectToRoute('faqs.index')->with('success', 'پرسش متداول شماره ' . $faq->id . ' حذف شد!');
    }
}

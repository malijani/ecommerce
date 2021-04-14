<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\FaqPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255']
        ]);

        FaqPage::query()->create($request->all());

        return response()->redirectToRoute('faqs.index')->with('success', 'مشخصات صفحه پرسشهای متداول ثبت شد');
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
        //
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
        $faq_page = FaqPage::query()->findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255']
        ]);

        $faq_page->update($request->all());

        return response()->redirectToRoute('faqs.index')->with('success', 'مشخصات صفحه پرسشهای متداول بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

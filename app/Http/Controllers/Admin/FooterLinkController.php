<?php

namespace App\Http\Controllers\Admin;

use App\FooterItem;
use App\FooterLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت لینک های فوتر';
        $footer_links = FooterLink::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.footer-link.index', [
            'title' => $title,
            'footer_links' => $footer_links
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن لینک فوتر جدید';
        $footer_items = FooterItem::query()->where('status', 1)->get();
        return response()->view('admin.footer-link.create', [
            'title' => $title,
            'footer_items' => $footer_items
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
            'title' => 'required|string|min:2|max:70',
            'link' => 'required|string|min:1|max:100',
            'status' => 'required|numeric|in:0,1',
            'item_id' => 'required|numeric|exists:footer_items,id'
        ]);
        $user_id = Auth::id();
        $footer_link = FooterLink::query()->create(array_merge(
            $request->all(),
            ['user_id' => $user_id]
        ));

        return response()->redirectToRoute('footer-links.index')->with('success', 'لینک فوتر ' . $footer_link->title . ' با موفقیت ثبت شد!');
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
        $footer_link = FooterLink::query()->findOrFail($id);
        $title = 'بروز رسانی لینک فوتر ' . $footer_link->title;
        $footer_items = FooterItem::query()->where('status', 1)->get();
        return response()->view('admin.footer-link.edit', [
            'footer_link' => $footer_link,
            'title' => $title,
            'footer_items' => $footer_items
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
        $footer_link = FooterLink::query()->findOrFail($id);
        $request->validate([
            'title' => 'required|string|min:2|max:70',
            'link' => 'required|string|min:1|max:100',
            'status' => 'required|numeric|in:0,1',
            'item_id' => 'required|numeric|exists:footer_items,id'
        ]);
        $footer_link->update($request->all());

        return response()->redirectToRoute('footer-links.index')->with('success', 'لینک فوتر '. $footer_link->title . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $footer_link = FooterLink::query()->findOrFail($id);
        $footer_link->delete();
        return response()->json('لینک فوتر '. $footer_link->title . ' با موفقیت حذف شد');
    }
}

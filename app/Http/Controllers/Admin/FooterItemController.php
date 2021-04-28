<?php

namespace App\Http\Controllers\Admin;

use App\FooterItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت آیتم های فوتر';
        $footer_items = FooterItem::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();
        return response()->view('admin.footer-item.index', [
            'title' => $title,
            'footer_items' => $footer_items
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:2', 'max:70'],
            'title_en' => ['required', 'string', 'min:2', 'max:70'],
            'status' => ['nullable', 'string', 'max:2'],
        ]);
        $user_id = Auth::id();
        $status = 0;
        if ($request->has('status') && $request->input('status') == 'on') {
            $status = 1;
        }

        $footer_item = FooterItem::query()->create(array_merge(
            $request->except('status'),
            ['status' => $status],
            ['user_id' => $user_id]
        ));

        return response()->redirectToRoute('footer-items.index')->with('success', 'سردسته فوتر ' . $footer_item->title . ' با موفقیت افزوده شد');
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $footer_item = FooterItem::query()->findOrFail($id);
        $request->validate([
            'title' => ['required', 'string', 'min:2', 'max:70'],
            'title_en' => ['required', 'string', 'min:2', 'max:70'],
            'status' => ['nullable', 'string', 'max:2'],
        ]);

        $status = 0;
        if ($request->has('status') && $request->input('status') == 'on') {
            $status = 1;
        }

        $footer_item->update(array_merge(
            $request->except('status'),
            ['status'=>$status]
        ));

        return response()->redirectToRoute('footer-items.index')->with('status', 'آیتم فوتر '. $footer_item->title . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $footer_item = FooterItem::query()->findOrFail($id);
        $footer_item->delete();
        return response()->json('سردسته فوتر '. $footer_item->title . ' با موفقیت حذف شد.');
        /*return response()->redirectToRoute('footer_items.index')->with('warning', 'سردسته فوتر '. $footer_item->title . ' با موفقیت حذف شد!');*/
    }
}

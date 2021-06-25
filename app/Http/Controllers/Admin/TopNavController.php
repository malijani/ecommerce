<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TopNav;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TopNavController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت ناوبری ایستا';
        $top_navs_medium = TopNav::withoutTrashed()
            ->where('screen', 1)
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->orderBy('sort')
            ->get();

        $top_navs_small = TopNav::withoutTrashed()
            ->where('screen', 0)
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->orderBy('sort')
            ->get();

        return response()->view('admin.top-nav.index', [
            'title' => $title,
            'top_navs_medium' => $top_navs_medium,
            'top_navs_small' => $top_navs_small,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : Response
    {
        $title = 'ایجاد ناوبری جدید';
        return response()->view('admin.top-nav.create', [
           'title'=>$title,
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
        $request->validate([
            'title'=> ['required', 'string', 'min:4', 'max:70', 'unique:top_navs,title'],
            'link'=> ['required', 'string', 'min:1', 'max:100'],
            'status' => ['required', 'integer', 'in:0,1'],
            'screen' => ['required', 'integer', 'in:0,1']
        ]);
        /*SET USER ID*/
        $user_id = Auth::id();
        /*FILL AND SAVE*/
        TopNav::query()->create(array_merge(
            $request->all(),
            ['user_id'=>$user_id]
        ));

        return response()->redirectToRoute('top-navs.index')->with('success', 'ناوبری ایستا با موفقیت ثبت شد');


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
        $nav_item = TopNav::withoutTrashed()->findOrFail($id);
        $title = 'بروز رسانی ناوبری '. $nav_item->title;

        return response()->view('admin.top-nav.edit', [
            'title'=>$title,
            'nav_item'=>$nav_item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id) : RedirectResponse
    {
        $nav_item = TopNav::withoutTrashed()->findOrFail($id);
        $request->validate([
            'title'=> ['required', 'string', 'min:4', 'max:70', 'unique:top_navs,title,'.$nav_item->id],
            'link'=> ['required', 'string', 'min:1', 'max:100'],
            'status' => ['required', 'integer', 'in:0,1'],
            'screen' => ['required', 'integer', 'in:0,1']
        ]);

        $nav_item->update($request->all());

        return response()->redirectToRoute('top-navs.index')->with('success', 'ناوبری '. $nav_item->title . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)  : RedirectResponse
    {
        $nav_item = TopNav::withoutTrashed()->findOrFail($id);
        $nav_item->forceDelete();
        return response()->redirectToRoute('top-navs.index')->with('success', 'ناوبری مورد نظر با موفقیت حذف شد!');
    }
}

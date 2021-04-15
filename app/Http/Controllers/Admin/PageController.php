<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت صفحات  ' . config('app.name');
        $pages = Page::withoutTrashed()
            ->orderBy('sort')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.page.index', [
            'title' => $title,
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ایجاد صفحه جدید';
        return response()->view('admin.page.create', [
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
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'menu_title' => ['required', 'string', 'min:4', 'max:20', 'unique:pages,menu_title'],
            'title_en' => ['required', 'string', 'min:5', 'max:70', 'unique:pages,title_en'],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'content' => ['required', 'min:5'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'menu' => ['required', 'numeric', 'in:0,1'],
            'sort' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);


        Page::query()->create(array_merge(
            $request->except('title_en'),
            ['title_en' => Str::slug($request->input('title_en'))],
            ['user_id' => Auth::id()]
        ));

        return response()->redirectToRoute('pages.index')->with('success', 'صفحه جدید با موفقیت ایجاد شد');
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
        $page = Page::withoutTrashed()->findOrFail($id);
        $title = 'بروز رسانی صفحه ' . $page->menu_title;

        return response()->view('admin.page.edit', [
            'page' => $page,
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

        $page = Page::withoutTrashed()->findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'menu_title' => ['required', 'string', 'min:4', 'max:20', 'unique:pages,menu_title,' . $page->id],
            'title_en' => ['required', 'string', 'min:5', 'max:70', 'unique:pages,title_en,' . $page->id],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'content' => ['required', 'min:5'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'menu' => ['required', 'numeric', 'in:0,1'],
            'sort' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);


        $page->update(array_merge(
            $request->except('title_en'),
            ['title_en' => Str::slug($request->input('title_en'))]
        ));

        return response()->redirectToRoute('pages.index')->with('success', 'صفحه ' . $page->menu_title . ' با موفقیت بروز رسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $page = Page::withoutTrashed()->findOrFail($id);
        $page->delete();
        return response()->redirectToRoute('pages.index')->with('success', 'صفحه  ' . $page->title . ' حذف شد!');
    }
}

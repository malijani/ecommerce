<?php

namespace App\Http\Controllers\Admin;

use App\HeaderPage;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class HeaderPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $header_pages = HeaderPage::query()
            ->get()
            ->sortByDesc('page')
            ->sortByDesc('created_at')
            ->all();

        $title = 'لیست متای صفحات '. config('app.brand.name');
        return view('admin.header-page.index', [
            'header_pages' => $header_pages,
            'title' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $title = 'افزودن هدر صفحه جدید';
        return view('admin.header-page.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'page' => ['required', 'string', 'min:2', 'max:50', 'unique:header_pages,page'],
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255']
        ]);

        $page = str_replace(' ', '-', $request->get('page'));

        HeaderPage::query()
            ->create(array_merge(
                $request->except('page'),
                ['page' => $page],
                ['user_id' => auth()->id()]
            ));

        return redirect(route('header-pages.index'))
            ->with('success', 'هدر جدید صفحه مورد نظر شما ثبت شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function show(int $id): RedirectResponse
    {
        return redirect(route('header-pages.edit', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $header_page = HeaderPage::query()->findOrFail($id);
        $title = ' ویرایش هدر صفحه ' . $header_page->page;
        return view('admin.header-page.edit', [
            'header_page' => $header_page,
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $header_page = HeaderPage::query()->findOrFail($id);

        $request->validate([
            'page' => ['required', 'string', 'min:2', 'max:50', 'unique:header_pages,page,' . $id],
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'keywords' => ['required', 'string', 'min:5', 'max:70'],
            'description' => ['required', 'string', 'min:5', 'max:255']
        ]);
        $page = str_replace(' ', '-', $request->get('page'));

        $header_page->update(array_merge(
            $request->except('page'),
            ['page' => $page],
            ['user_id' => auth()->id()]
        ));

        return redirect(route('header-pages.index'))
            ->with('success', 'هدر صفحه مورد نظر شما با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            HeaderPage::query()->find($id)->delete();
        } catch (Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage()
                ], Response::HTTP_FAILED_DEPENDENCY);
        }

        return response()
            ->json([
                'message' => 'هدر صفحه مورد نظر شما با موفقیت حذف شد',
            ]);


    }
}

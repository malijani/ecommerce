<?php

namespace App\Http\Controllers\Visitor;

use App\HeaderPage;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pages = Page::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('created_at')
            ->paginate(10);


        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'pages')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'صفحات وبسایت ' . config('app.brand.name');
        }


        return response()->view('front-v1.page.index', [
            'title' => $title,
            'page_header' => $page_header,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::withoutTrashed()
            ->where('status', 1)
            ->where('title_en', $slug)
            ->first();


        $other_pages = Page::withoutTrashed()
            ->where('status', 1)
            ->orderBy('sort')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        if (empty($page)) {
            $title = 'صفحه ' . $slug . ' در ' . config('app.brand.name') . ' یافت نشد! ';
            return response()->view('front-v1.page.404', [
                'title' => $title,
                'not_found' => $slug,
                'other_pages' => $other_pages,
            ]);
        }

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', $page->title_en)
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = $page->title;
        }

        $page->increment('visit');

        return response()->view('front-v1.page.show', [
            'title' => $title,
            'page_header' => $page_header,
            'page' => $page,
            'other_pages' => $other_pages,
        ]);
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
        //
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

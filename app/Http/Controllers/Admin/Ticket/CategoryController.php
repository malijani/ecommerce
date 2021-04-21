<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\TicketCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت دسته بندی تیکت ها';

        $categories = TicketCategory::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();


        return response()->view('admin.ticket-category.index', [
            'title' => $title,
            'categories' => $categories,
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
            'title' => 'required|string|min:2|max:100',
            'status' => 'nullable|string|max:2',
        ]);
        $status = $request->has('status') ? 1 : 0;

        TicketCategory::query()->create(array_merge(
            $request->except('status'),
            ['status' => $status]
        ));

        return response()->redirectToRoute('ticket-categories.index')->with('success', 'دسته بندی تیکت با موفقیت افزوده شد');

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
        $category = TicketCategory::query()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|min:2|max:100',
            'status' => 'nullable|string|max:2',
        ]);
        $status = $request->has('status') ? 1 : 0;

        $category->update(array_merge(
            $request->except('status'),
            ['status' => $status]
        ));

        return response()->redirectToRoute('ticket-categories.index')->with('success', 'دسته بندی شماره ' . $category->id . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = TicketCategory::query()->findOrFail($id);
        $category->forceDelete();
        return response()->json('عنوان دسته بندی '. $category->title . ' با موفقیت حذف شد');
    }
}

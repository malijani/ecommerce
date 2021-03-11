<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() : Response
    {
        $title = 'لیست ویژگی محصولات';
        $attributes = Attribute::query()->orderBy('created_at', 'DESC')->get();
        return response()->view('admin.attribute.index', [
           'title'=>$title,
            'attributes'=>$attributes,
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
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
           'title'=>['required','min:2','max:70','unique:attributes,title'],
        ]);
        Attribute::query()->create($request->all());
        return response()->redirectTo(route('attributes.index'))->with('success', 'ویژگی جدید با موفقیت افزوده شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id) : RedirectResponse
    {
        $attribute = Attribute::query()->findOrFail($id);
        $request->validate([
            'title'=>['required','min:2','max:70','unique:attributes,title,'.$id],
        ]);
        $attribute->update($request->all());
        return response()->redirectTo(route('attributes.index'))->with('success', 'ویژگی '. $attribute->getAttribute('title').' با موفقیت بروز رسانی شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id):Response
    {
        Attribute::query()->findOrFail($id)->forceDelete();
        return response('ویژگی با موفقیت حذف شد!');
    }
}

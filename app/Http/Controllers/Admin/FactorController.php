<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت فاکتور های '. config('app.short.name');
        $factors = [];
        $factors['paid'] = Factor::withoutTrashed()
            ->paidFactors()
            ->sort()
            ->get();
        $factors['unpaid'] = Factor::withoutTrashed()
            ->unpaidFactors()
            ->sort()
            ->get();
        $factors['failure'] = Factor::withoutTrashed()
            ->failureFactors()
            ->sort()
            ->get();
        $factors['archived'] = Factor::withoutTrashed()
            ->archivedFactors()
            ->sort()
            ->get();
        $factors['deleted'] = Factor::onlyTrashed()
            ->sort()
            ->get();

        return response()
            ->view('admin.factor.index', [
                'factors' => $factors,
                'title' => $title,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factor = Factor::withTrashed()->findOrFail($id);
        $title = 'جزییات فاکتور ' . $factor->uuid;
        return response()
            ->view('admin.factor.show', [
                'factor'=> $factor,
                'title' => $title
            ]);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function unArchive()
    {
        //
    }

    public function restore()
    {
        //
    }

}

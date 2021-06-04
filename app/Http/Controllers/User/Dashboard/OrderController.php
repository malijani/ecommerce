<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Factor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'سفارش های ثبت شده توسط شما در '. config('app.short.name');
        $factors = Factor::withoutTrashed()
            ->where('user_id' , Auth::id())
            ->orderByDesc('status')
            ->orderByDesc('updated_at')
            ->get();
        return response()->view('front-v1.user.dashboard.order.index', [
            'factors'=>$factors,
            'title'=>$title,
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
    public function show($uuid)
    {
        $factor = Factor::query()
            ->with('products', 'products.attributes')
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->first();

        if (empty($factor)) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', 'فاکتور مورد نظر شما یافت نشد!');
        }
        $title = 'جزییات فاکتور '. $factor->uuid . ' در '. config('app.short.name');
        return response()
            ->view('front-v1.user.dashboard.order.show', [
                'title' => $title,
                'factor' => $factor
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
    public function update(Request $request, $uuid)
    {
        /*ONLY AJAX ALLOWED*/
        if(!$request->ajax()){
            return response()
                ->redirectToRoute('dashboard.orders.show', $uuid)
                ->with('error', 'درخواست نامعتبر برای تعیین درخواست کاربر!');
        }
        /*CHECK IF CONTENT IS EMPTY*/
        if(empty($request->input('content'))){
            return response()
                ->json([
                    'class' => 'alert-danger',
                    'message'=> 'محتوای درخواست خالیست.',
                ], 204);
        }
        /*FIND FACTOR*/
        $factor = Factor::withoutTrashed()
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->first();
        /*CHECK IF FACTOR EXISTS*/
        if(empty($factor)){
            return response()->json([
                'class' => 'alert-danger',
                'message' => 'فاکتور مورد نظر یافت نشد!'
            ], 404);
        }
        /*SAVE FACTOR*/
        $factor->description = $request->input('content');
        $factor->save();
        /*RETURN SUCCESS STATUS*/
        return response()->json([
            'class' => 'alert-success',
            'message'=>'درخواست شما ثبت شد',

        ], 200);
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
}

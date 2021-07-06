<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     */
    public function store(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->back()->with('warning', 'درخواست امتیاز دهی نامعتبر!');
        }

        if(!Auth::check()){
            return response()->json([
                'message' => 'برای امتیاز دهی به حساب کاربری خود وارد شوید!',
            ], Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED);
        }

        $request->validate([
            'rate' => 'required|numeric|min:1|max:5',
            'rateable' => 'required|string|size:7|in:Article,Product',
            'rateable_id' => 'required|numeric|min:1',
        ]);
        $rateable = app('App\\' . $request->input('rateable'))::withoutTrashed()
            ->find($request->input('rateable_id'));

        if (empty($rateable)) {
            return response()->json([
                'message' => 'آیتم مورد نظر برای امتیاز دهی یافت نشد!'
            ], Response::HTTP_NOT_FOUND);
        }


        Auth::user()->rate($rateable, $request->input('rate'));

        $rating_summary = view('front-v1.partials.rating_summary', [
            'model'=>$rateable
        ])
        ->render();

        return response()->json([
            'message' => 'رای شما با موفقیت ثبت شد!',
            'rating_summary' => $rating_summary,
        ]);

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

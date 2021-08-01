<?php

namespace App\Http\Controllers\User\Dashboard;

use App\HeaderPage;
use App\Http\Controllers\Controller;
use App\ProvinceCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $addresses = Auth::user()->addresses;
        $default_address = Auth::user()->defaultAddress;
        $provinces = ProvinceCity::withoutTrashed()->where('parent', 0)->get();

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'dashboard-address-index')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'مدیریت آدرس های ارسال سفارش شما در ' . config('app.brand.name');
        }

        return response()->view('front-v1.user.dashboard.addresses', [
            'title' => $title,
            'page_header' => $page_header,
            'addresses' => $addresses,
            'default_address' => $default_address,
            'provinces' => $provinces,
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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\ProvinceCity;
use App\User;
use App\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        /*USER ADDRESS IS AFTER ORDERING PRODUCTS!*/
        /*THE TOTAL SESSION SHOULD BE EXISTS*/
        if(empty(session()->get('total'))){
            return redirect()->back()->with('error', 'شما هنوز محصولی جهت سفارش ثبت نکرده اید!');
        }

        $title = 'انتخاب آدرس ارسال بسته '. config('app.short.name');

        $addresses = Auth::user()->addresses;
        $default_address = Auth::user()->defaultAddress;
        $provinces = ProvinceCity::withoutTrashed()->where('parent', 0)->get();
        $total = session()->get('total');
        $basket = session()->get('basket');
        return response()->view('front-v1.user.address.index', [
            'title' => $title,
            'addresses' => $addresses,
            'default_address' => $default_address,
            'total' => $total,
            'provinces'=>$provinces,
            'basket' => $basket
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
        /*name_family, mobile, tell, province, city, address, post_code, status*/
        $request->validate([
            'name_family' => ['required', 'min:5', 'max:100'],
            'mobile' => ['required', 'iran_mobile'],
            'tell' => ['nullable', 'iran_phone_with_area_code'],
            'province' => ['required', 'max:50'],
            'city' => ['required', 'max:50'],
            'address' => ['required', 'max:1000'],
            'post_code' => ['nullable', 'iran_postal_code'],
            'status' => ['nullable', 'string', 'size:2'],
        ], [
            'name_family' => [
                'required' => 'تعیین نام و نام خانوادگی گیرنده مرسوله الزامیست.',
                'min' => 'حداقل طول نام و نام خانوادگی ۵ کاراکتر است.',
                'max' => 'حداکثر طول نام و نام خانوادگی ۱۰۰ کاراکتر است.',
            ],
            'mobile' => [
                'required'=>'ثبت شماره تلفن همراه گیرنده الزامیست.',
            ],
            'tell' => [],
            'province' => [
                'required' => 'تعیین استان مقصد مرسوله الزامیست.',
                'max' => 'حداکثر طول استان ۵۰ کاراکتر است.',
            ],
            'city' => [
                'required' => 'تعیین شهر مقصد مرسوله الزامیست.',
                'max' => 'حداکثر طول شهر ۵۰ کاراکتر است.',
            ],
            'address' => [
                'required' => 'تعیین آدرس دقیق مقصد مرسوله الزامیست.',
                'max' => 'حداکثر طول آدرس ۱۰۰۰ کاراکتر است.',
            ],
            'post_code' => [],
            'status' => [
                'string' => 'وضعیت آدرس نامعتبر است.',
                'size' => 'وضعیت آدرس نامعتبر است.'
            ],
        ]);

        $new_address = UserAddress::query()->create(array_merge(
            $request->except('status'), ['user_id' => Auth::id()]
        ));

        if ($request->has('status')) {
            $default_address = Auth::user()->default_address;
            if (!is_null($default_address)) {
                $default_address->status = false;
                $default_address->save();
            }
        }

        $new_address->status = true;
        $new_address->save();

        return back()->with('success', 'آدرس جدید با موفقیت ذخیره شد');
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
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'status' => ['required', 'string', 'size:2'], // on
        ]);
        $target_address = UserAddress::withoutTrashed()->where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $default_address = Auth::user()->default_address;
        if (!is_null($default_address)) {
            $default_address->status = false;
            $default_address->save();
        }
        $target_address->status = true;
        $target_address->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        UserAddress::withoutTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id)
            ->forceDelete();
    }




}

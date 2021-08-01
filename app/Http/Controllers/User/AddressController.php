<?php

namespace App\Http\Controllers\User;

use App\HeaderPage;
use App\Http\Controllers\Controller;
use App\Page;
use App\ProvinceCity;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        if (empty(session()->get('total'))) {
            return redirect()->back()->with('error', 'شما هنوز محصولی جهت سفارش ثبت نکرده اید!');
        }

        $addresses = Auth::user()->addresses;
        $default_address = Auth::user()->defaultAddress;
        $provinces = ProvinceCity::withoutTrashed()->where('parent', 0)->get();

        $terms_conditions = Page::withoutTrashed()->where('title_en', 'terms-conditions')->first();

        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'address')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'انتخاب آدرس ارسال بسته ' . config('app.brand.name');
        }

        return response()->view('front-v1.user.address.index', [
            'title' => $title,
            'page_header' => $page_header,
            'addresses' => $addresses,
            'default_address' => $default_address,
            'provinces' => $provinces,
            'terms_conditions' => $terms_conditions,
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
                'required' => 'ثبت شماره تلفن همراه گیرنده الزامیست.',
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
            if (!empty($default_address)) {
                $default_address->status = false;
                $default_address->save();
            }
            $new_address->status = true;
        }

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
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        if (!$request->ajax()) {
            return back()->with('error', 'درخواست نامعتبر');
        }

        $target_address = UserAddress::withoutTrashed()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
        if (empty($target_address)) {
            return response()->json([
                'message' => 'آدرس مورد نظر شما یافت نشد!',
            ], Response::HTTP_NOT_FOUND);
        }

        $default_address = Auth::user()->default_address;
        if (!empty($default_address)) {
            $default_address->status = false;
            $default_address->save();
        }
        $target_address->status = true;
        $target_address->save();

        return response()->json([
            'message' => 'آدرس مورد نظر با موفقیت بعنوان پیشفرض تنظیم شد.',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function destroy(Request $request, int $id)
    {
        if (!$request->ajax()) {
            return back()->with('error', 'درخواست نامعتبر');
        }

        $address = UserAddress::withoutTrashed()
            ->where('user_id', Auth::id())
            ->find($id);

        if (empty($address)) {
            return response()->json([
                'message' => 'آدرس مورد نظر یافت نشد!',
            ], Response::HTTP_NOT_FOUND);
        }
        try {
            $address->forceDelete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'در انجام درخواست مشکلی به وجود آمده',
            ], Response::HTTP_FORBIDDEN);
        }
        return response()->json([
            'message' => 'آدرس مورد نظر با موفقیت حذف شد!',
        ], Response::HTTP_OK);
    }


}

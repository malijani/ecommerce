<?php

namespace App\Http\Controllers\Admin;

use App\DiscountCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت کد های تخفیف';
        $discount_codes = DiscountCode::query()
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.discount-code.index', [
            'title' => $title,
            'discount_codes' => $discount_codes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ثبت کد تخفیف جدید';
        return response()->view('admin.discount-code.create', [
            'title' => $title,
        ]);
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
            'code' => 'required|string|min:2|max:10|unique:discount_codes,code',
            'percent' => 'required|numeric|min:1|max:100',
            'status' => 'required|numeric|in:0,1'
        ]);

        $discount_code = DiscountCode::query()->create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        return response()
            ->redirectToRoute('discount-codes.index')
            ->with('success', 'کد تخفیف ' . $discount_code->code . ' با موفقیت ایجاد شد!');
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
        $discount_code = DiscountCode::query()->findOrFail($id);
        $title = 'بروز رسانی کد تخفیف ' . $discount_code->code;

        return response()->view('admin.discount-code.edit', [
            'discount_code' => $discount_code,
            'title' => $title
        ]);
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
        $discount_code = DiscountCode::query()->findOrFail($id);

        /*CHECK IF REQUEST COMES FROM AJAX*/
        if ($request->has('ajax') && $request->input('ajax') == '1') {
            $request->validate([
                'status' => ['required', 'string', 'size:2'],
            ]);

            if ($discount_code->status == 1) {
                $discount_code->status = 0;
            } else {
                $discount_code->status = 1;
            }
            $discount_code->save();

            return response()
                ->redirectToRoute('discount-codes.index')
                ->with('success', 'کد تخفیف ' . $discount_code->code . ' فعال شد!');
        }


        $request->validate([
            'code' => 'required|string|min:2|max:10|unique:discount_codes,code,' . $id,
            'percent' => 'required|numeric|min:1|max:100',
            'status' => 'required|numeric|in:0,1'
        ]);

        $discount_code->update($request->all());

        return response()
            ->redirectToRoute('discount-codes.index')
            ->with('success', 'کد تخفیف ' . $discount_code->code . ' با موفقیت بروزرسانی شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount_code = DiscountCode::query()->findOrFail($id);
        $discount_code->delete();
        return response()
            ->redirectToRoute('discount-codes.index')
            ->with('warning', 'کد تخفیف ' . $discount_code->code . ' حذف شد!');
    }
}

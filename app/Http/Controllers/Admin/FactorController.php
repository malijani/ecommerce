<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class FactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت فاکتور های ' . config('app.brand.name');
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
        $factor = Factor::withTrashed()->findOrFail($id);
        $title = 'جزییات فاکتور ' . $factor->uuid;

        return response()
            ->view('admin.factor.show', [
                'factor' => $factor,
                'title' => $title,
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

    /**
     * Set Admin comment for factor
     */
    public function comment(Request $request, $id)
    {
        /*ONLY AJAX ALLOWED*/
        if (!$request->ajax()) {
            return response()
                ->json([
                    'message' => 'درخواست نامعتبر!',
                ], 403);

        }
        /*CHECK IF CONTENT IS EMPTY*/
        if (empty($request->input('content'))) {
            return response()
                ->json([
                    'class' => 'alert-danger',
                    'message' => 'محتوای درخواست خالیست.',
                ], 204);
        }
        /*FIND FACTOR*/
        $factor = Factor::withTrashed()
            ->find($id);
        /*CHECK IF FACTOR EXISTS*/
        if (empty($factor)) {
            return response()->json([
                'class' => 'alert-danger',
                'message' => 'فاکتور مورد نظر یافت نشد!'
            ], 404);
        }


        /*CHECK IF ASK EXISTS*/
        if ($factor->description === $request->input('content')) {
            return response()->json([
                'class' => 'alert-danger',
                'message' => 'این پاسخ ثبت شده !'
            ], Response::HTTP_FORBIDDEN);
        }
        /*SAVE FACTOR*/
        $factor->comment = $request->input('content');
        $factor->save();
        /*RETURN SUCCESS STATUS*/
        return response()->json([
            'class' => 'alert-success',
            'message' => 'پاسخ شما ثبت شد',

        ], 200);
    }

    /**
     * Set shipping attributes
     */
    public function shipping(Request $request, $id)
    {

        if (!$request->ajax()) {
            return response()
                ->json([
                    'message' => 'درخواست نامعتبر!',
                ], 403);
        }

        $factor = Factor::withTrashed()
            ->find($id);

        if (empty($factor)) {
            return response()
                ->json([
                    'message' => 'فاکتور مورد نظر یافت نشد!',
                ], 404);
        }

        /*SHORT ACCESS TO SHIPPING STATUS FROM FACTORS INDEX*/
        if ($request->has('short_access')) {
            $validator = Validator::make([
                'delivery' => 'required|in:0,1,2',
            ], [
                'delivery.required' => 'وضعیت ارسال بسته الزامیست',
                'delivery.in' => 'مقدار ارسالی نامعتبر است.',
            ]);

            if ($validator->fails()) {
                return response()
                    ->json([
                        'message' => array_values($validator->errors()->toArray()),
                    ], 402);
            }

            $factor->delivery = $request->input('delivery');
            $factor->save();
            return response()
                ->json([
                    'message' => 'وضعیت مرسوله فاکتور ' . $factor->uuid . ' به ' . $request->input('text') . ' تغییر کرد',
                ], 200);
        }

        /*CHANGE EVERYTHING ABOUT SHIPPING STATUS IN SHOW FACTOR*/
        $validator = Validator::make($request->all(), [
            'delivery' => 'required|in:0,1,2',
            'post_tracking' => ['required', 'max:50'],
            'shipping_cost' => 'required|max:10',
        ], [
                'delivery.required' => 'تعیین وضعیت ارسال بسته الزامیست',
                'delivery.in' => 'مقدار وضعیت مرسوله اشتباه است',
                'post_tracking.required' => 'تعیین کد رهگیری پستی الزامیست',
                'post_tracking.max' => 'کد رهگیری پستی حداکثر ۵۰ کاراکتر است',
                'shipping_cost.required' => 'تعیین هزینه سرویس ارسال الزامیست',
                'shipping_cost.max' => 'هزینه پستی حداکثر دارای ده کاراکتر است',
            ]
        );

        if ($validator->fails()) {
            return \response()
                ->json([
                    'message' => array_values($validator->errors()->toArray()),
                ], 402);
        }

        $factor->delivery = $request->input('delivery');
        $factor->post_tracking = $request->input('post_tracking');
        $factor->shipping_cost = $request->input('shipping_cost');
        $factor->save();

        return response()->json([
            'message' => 'مشخصات پستی مرسوله بروزرسانی شد.'
        ], 200);
    }

    /**
     * Recycle deleted factor
     */
    public function restore(Request $request, $id)
    {
        if (!request()->ajax()) {
            return response()
                ->json([
                    'message' => 'درخواست نامعتبر',
                ], 403);
        }

        $factor = Factor::onlyTrashed()
            ->find($id);
        if (empty($factor)) {
            return response()
                ->json([
                    'message' => 'فاکتور مورد نظر در بخش فاکتور های حذف شده وجود ندارد!',
                ], 404);
        }
        /*RESTORE THE SELECTED FACTOR*/
        if ($factor->restore()) {
            $factor->updated_at = now();
            $factor->save();
            return response()
                ->json([
                    'message' => 'فاکتور ' . $factor->uuid . ' با موفقیت بازگردانی شد.',
                ], 200);
        } else {
            return response()
                ->json([
                    'message' => 'خطا!  ' . $factor->uuid . ' بازگردانی نشد!',
                ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Restore archived factor by changing updated_at to now
     */
    public function unArchive(Request $request, $id)
    {
        if (!request()->ajax()) {
            return response()
                ->json([
                    'message' => 'درخواست نامعتبر',
                ], 403);
        }

        $factor = Factor::withoutTrashed()
            ->find($id);
        if (empty($factor)) {
            return response()
                ->json([
                    'message' => 'فاکتور مورد نظر در بخش فاکتور های آرشیو شده وجود ندارد!',
                ], 404);
        }

        /*UNARCHIVE THE SELECTED FACTOR*/
        $factor->updated_at = now();
        $factor->save();
        return response()
            ->json([
                'message' => 'فاکتور ' . $factor->uuid . ' با موفقیت از آرشیو خارج شد.',
            ], 200);

    }


}

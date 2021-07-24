<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Factor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $title = 'سفارش های ثبت شده توسط شما در ' . config('app.brand.name');
        $user = Auth::user();
        $factors = [];
        $factors['active_factors'] = $user->factors()
            ->activeFactors()
            ->sort()
            ->get();

        $factors['paid_factors'] = $user->factors()
            ->paidFactors()
            ->sort()
            ->get();

        $factors['archived_factors'] = $user->factors()
            ->archivedFactors()
            ->sort()
            ->select('uuid', 'updated_at', 'status')
            ->get();


        $factors['deleted_factors'] = $user->factors()
            ->deletedFactors()
            ->select('uuid', 'deleted_at', 'status')
            ->get();

        return response()->view('front-v1.user.dashboard.order.index', [
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
    public function show($uuid)
    {

        $user = Auth::user();
        $factor = $user->factors()
            ->with('products', 'products.attributes')
            ->factorShow()
            ->where('uuid', $uuid)
            ->first();

        /*$factor = Factor::query()
            ->with('products', 'products.attributes')
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->first();*/

        if (empty($factor)) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', 'فاکتور مورد نظر شما یافت نشد!');
        }
        $title = 'جزییات فاکتور ' . $factor->uuid . ' در ' . config('app.brand.name');
        return response()
            ->view('front-v1.user.dashboard.order.show', [
                'title' => $title,
                'factor' => $factor
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
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function update(Request $request, string $uuid)
    {
        /*ONLY AJAX ALLOWED*/
        if ($request->ajax()) {
            /*CHECK IF CONTENT IS EMPTY*/
            if (empty($request->input('content'))) {
                return response()
                    ->json([
                        'class' => 'alert-danger',
                        'message' => 'محتوای درخواست خالیست.',
                    ], 204);
            }
            $request->validate([
                'content' => 'bail|required|max:255',
            ],[
               'content.required' => 'تعیین محتوای درخواست الزامیست.',
                'content.max' => 'حداکثر درخواست ۲۵۵ کاراکتر تعیین شده.'
            ]);
            /*FIND FACTOR*/
            $factor = Factor::withoutTrashed()
                ->where('user_id', Auth::id())
                ->where('uuid', $uuid)
                ->first();
            /*CHECK IF FACTOR EXISTS*/
            if (empty($factor)) {
                return response()->json([
                    'class' => 'alert-danger',
                    'message' => 'فاکتور مورد نظر یافت نشد!'
                ], 404);
            }

            /*CHECK IF FACTOR IS DELIVERED*/
            if (!empty($factor->delivered)) {
                return response()->json([
                    'class' => 'alert-danger',
                    'message' => 'بسته ارسال شده است.'
                ], Response::HTTP_NO_CONTENT);
            }

            /*CHECK IF ASK EXISTS*/
            if ($factor->description === $request->input('content')) {
                return response()->json([
                    'class' => 'alert-danger',
                    'message' => 'درخواست تکراری!'
                ], Response::HTTP_FORBIDDEN);
            }
            /*SAVE FACTOR*/
            $factor->description = $request->input('content');
            $factor->save();
            /*RETURN SUCCESS STATUS*/
            return response()->json([
                'class' => 'alert-success',
                'message' => 'درخواست شما ثبت شد',

            ], 200);
        }

        return response()
            ->json([
                'message' => 'درخواست نامعتبر!',
            ], 403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request, string $uuid)
    {

        /*ONLY AJAX REQUEST IS ALLOWED*/
        if ($request->ajax()) {
            /*GET FACTOR*/
            $factor = Factor::withoutTrashed()
                ->where('user_id', Auth::id())
                ->where('uuid', $uuid)
                ->first();
            /*CHECK FACTOR EXISTENCE*/
            if (empty($factor)) {
                return response()->json([
                    'message' => 'فاکتور مورد نظر یافت نشد!',
                    'url' => route('dashboard.orders.index')
                ], Response::HTTP_NOT_FOUND);
            }
            /*CHECK IF FACTOR IS PAID*/
            /*CHECK IF FACTOR IS PAID*/
            if ($factor->status == '1') {
                return response()->json([
                    'message' == 'این فاکتور پرداخت شده و غیرقابل حذف کردن است.',
                    'url' => route('dashboard.orders.show', $factor->uuid),
                ], Response::HTTP_BAD_REQUEST);
            }
            /*DELETE FACTOR*/
            try {
                $factor->delete();

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'خطا در حذف فاکتور',
                    'url' => route('dashboard.orders.show', $factor->uuid)
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'message' => 'فاکتور ' . $factor->uuid . ' با موفقیت حذف شد.',
                'url' => route('dashboard.orders.index')
            ], Response::HTTP_OK, [], JSON_UNESCAPED_SLASHES);
        }
        return response()->json([
            'message' => 'درخواست نامعتبر!',
            'url' => route('dashboard.orders.index'),
        ], Response::HTTP_FORBIDDEN);
    }

}

<?php

namespace App\Http\Controllers\User\Factor;

use App\Factor;
use App\FactorProduct;
use App\FactorProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*TODO : MERGE PAYMENT CONTROLLER WITH FACTOR FOR BETTER CONTROLLING OF FACTOR*/

class FactorController extends Controller
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
     */
    public function create()
    {
        $basket = session()->get('basket');
        $total = session()->get('total');

        if (empty($basket) || empty($total)) {
            session()->forget(['basket', 'total']);
            return redirect()
                ->back()
                ->with('error', 'سبد خرید شما خالیست؛ لطفاً دوباره تلاش کنید.');
        }


        $user = Auth::user();
        if(empty($user)){
            return response()
                ->redirectToRoute('home')
                ->with('error', 'در تشخیص حساب کاربری مشکلی ایجاد شده! لفطا دوباره وارد شوید و تلاش کنید.');
        }

        $shipping = $user->default_address->toArray();

        /*CREATE FACTOR*/
        $factor_array = [
            'uuid' => generateUniqueString(app('App\\Factor'), 'uuid', 10),
            'user_id' => $user->id,
            'shipping_name_family' => $shipping['name_family'],
            'shipping_address' => $shipping['address'],
            'shipping_mobile' => $shipping['mobile'],
            'shipping_tell' => $shipping['tell'],
            'shipping_post_code' => $shipping['post_code'],
            'price' => $total['final_price'],
            'raw_price' => $total['raw_price'],
            'discount_price' => $total['discount'],
            'discount_code' => $total['discount_code'],
            'weight' => $total['weight'],
            'count' => $total['count'],
        ];

        $factor = Factor::query()->create($factor_array);

        /*$factor_id is usable for FactorProducts*/
        /*STORE FACTOR PRODUCTS WITH ATTRIBUTES*/
        $description = function ($array) { // remove 'quantity' from basket product attribute
            unset($array['quantity']);
            return $array;
        };

        /*STORE FACTOR PRODUCTS*/
        foreach ($basket as $product_id => $product_specifics) {
            $factor_product = FactorProduct::query()->create([
                'factor_id' => $factor->id,
                'product_id' => $product_id,
                'price_type' => $product_specifics['price_type'],
                'price' => $product_specifics['price'],
                'price_self_buy' => $product_specifics['price_self_buy'],
                'discount_percent' => $product_specifics['discount_percent'],
                'discount_price' => $product_specifics['total_discount'],
                'weight' => $product_specifics['weight'],
                'count' => $product_specifics['quantity']

            ]);

            /*STORE PRODUCT ATTRIBUTES*/
            if (!empty($product_specifics['attribute'])) {
                foreach ($product_specifics['attribute'] as $attributes) {
                    FactorProductAttribute::query()->create([
                        'factor_product_id' => $factor_product->id, // STANDS FOR SAVED FACTOR_PRODUCT
                        'product_id' => $product_id,
                        'count' => $attributes['quantity'],
                        'attribute' => implode(",", $description($attributes)),
                    ]);
                }
            }
        }

        session()->forget(['basket', 'total']);

        return response()
            ->redirectToRoute('payment.pay', $factor->uuid)
            ->with('success', 'فاکتور شما با موفقیت ثبت شد!');
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
     * @param int $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
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

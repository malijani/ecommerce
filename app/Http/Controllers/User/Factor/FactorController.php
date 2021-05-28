<?php

namespace App\Http\Controllers\User\Factor;

use App\Factor;
use App\FactorProduct;
use App\FactorProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        /*CREATE FACTOR*/
        $factor_array = [
            'user_id' => Auth::id(),
            'price' => $total['final_price'],
            'raw_price' => $total['raw_price'],
            'discount_price' => $total['discount'],
            'discount_code' => $total['discount_code'],
            'weight' => $total['weight'],
        ];

        $factor = Factor::query()->create($factor_array);

        /*$factor_id is usable for FactorProducts*/
        /*STORE FACTOR PRODUCTS WITH ATTRIBUTES*/
        $description = function ($array) { // remove 'quantity' from basket product attribute
            unset($array['quantity']);
            return $array;
        };

        foreach ($basket as $product_id => $product_specifics) {
            $factor_product = FactorProduct::query()->create([
                'factor_id' => $factor->id,
                'product_id' => $product_id,
                'price_type' => $product_specifics['price_type'],
                'price' => $product_specifics['price'],
                'discount_percent' => $product_specifics['discount_percent'],
                'discount_price' => $product_specifics['total_discount'],
                'weight' => $product_specifics['weight'],
                'count' => $product_specifics['quantity']
            ]);

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

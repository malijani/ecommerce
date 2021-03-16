<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'سبد خرید';
        $basket = session()->get('basket');

        if (is_null($basket) || count($basket) == 0) {
            return response()->view('front-v1.user.cart.null', [
                'title' => $title,
            ]);
        }


        return response()->view('front-v1.user.cart.index', [
            'title' => $title,
            'basket' => $basket,
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
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        /*PREPARE ATTRIBUTE IDS AND VALUE FOR VALIDATION */
        if ($request->has('order.attribute')) {
            $request->request->add(['attr_id' => collect($request->input('order.attribute'))->keys()->toArray()]);
            $request->request->add(['attr_value' => collect($request->input('order.attribute'))->values()->toArray()]);
        }

        $request->validate([
            'order' => ['required', 'array', 'max:3', 'min:2'],
            'order.product_id.*' => ['required', 'numeric', 'exists:products,id'],
            'order.count' => ['required', 'numeric'],
            /*order.attribute is combined attr_id, attr_value*/
            'order.attribute' => ['sometimes', 'required', 'array', 'max:6'],
            'attr_id' => ['sometimes', 'required', 'exists:attributes,id'],
            'attr_value' => ['sometimes', 'required', 'exists:attribute_product,attr_value'],
        ]);
        /*
         * $request :
         *     'order.product_id', 'order.attribute.X', 'order.count'
        */
        $product = Product::withoutTrashed()->with('files', 'attrs')->findOrFail($request->input('order.product_id'));
        /*CHECK EXISTENCE OF PRODUCT*/
        if ($product->getAttribute('entity') <= 0 || $product->getAttribute('price_type') == 2 || $product->getAttribute('status' == 2)) {
            return redirect()->back()->with('error', 'اتمام موجودی محصول برای سفارش و اطلاعات بیشتر با مدیریت تماس بگیرید.');
        }


        /*PREPARE VALUES*/
        $quantity = $request->input('order.count');
        $attribute = [];
        if ($request->has('order.attribute')) {
            $attr_id = $request->input('attr_id');
            $attr_id = array_merge($attr_id, ['quantity']); // ['attr_id',...,'attr_id', 'quantity']
            $attr_value = array_merge($request->input('order.attribute'), ['quantity' => $quantity]);
            $attribute = [array_combine($attr_id, $attr_value)];
        }

        /*FUNCTION TO REMOVE QUANTITY KEY FROM ARRAY*/
        $quantity_remover = function ($array) {
            if (is_array($array) && array_key_exists('quantity', $array)) {
                return array_diff_key($array, array_flip(['quantity']));
            } else {
                return [];
            }
        };

        /*SESSION SECTION*/
        $basket = session()->get('basket');
        if (!$basket) {
            $basket = [
                $product->id => [
                    'title' => $product->title,
                    'title_en' => $product->title_en,
                    'quantity' => $request->input('order.count'),
                    'attribute' => $attribute,
                    'price' => $request->input('order.count') * $product->final_price,
                    'price_type' => $product->price_type,
                    'discount_percent' => $product->discount_percent,
                    'total_discount' => ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $request->input('order.count')) : 0,
                    'pic' => $product->files()->defaultFile()->link,
                ],
            ];

        } elseif (isset($basket[$product->id])) {
            $quantity = &$basket[$product->id]['quantity'];
            $price = &$basket[$product->id]['price'];
            $total_discount = &$basket[$product->id]['total_discount'];

            $order_attribute = &$basket[$product->id]['attribute'];
            $attr_diff = null;

            if (count($order_attribute) > 0) {
                foreach ($order_attribute as $order_attr_key => $order_attr_val) {
                    $check_diff = array_diff($quantity_remover($attribute[0]), $quantity_remover($order_attr_val));
                    if (!$check_diff) {
                        /*INCREMENT ORDER ATTRIBUTE QUANTITY*/
                        $attr_diff = $order_attr_key;
                    }
                }
            }

            if ($product->entity > $quantity) {
                $quantity += $request->input('order.count');
                $price += $request->input('order.count') * $product->final_price;
                $total_discount += ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $request->input('order.count')) : 0;
                if (!is_null($attr_diff)) {
                    $order_attribute[$attr_diff]['quantity'] += $request->input('order.count');
                } else {
                    $order_attribute = array_merge($order_attribute, $attribute);
                }

            } else {
                return redirect()->back()->with('warning', 'تعداد محصول درخواستی شما در انبار موجود نیست');
            }
        } else {
            $basket[$product->id] =
                [
                    'title' => $product->title,
                    'title_en' => $product->title_en,
                    'quantity' => $request->input('order.count'),
                    'attribute' => $attribute,
                    'price' => $request->input('order.count') * $product->final_price,
                    'price_type' => $product->price_type,
                    'discount_percent' => $product->discount_percent,
                    'total_discount' => ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $request->input('order.count')) : 0,
                    'pic' => $product->files()->defaultFile()->link,
                ];
        }

        session()->put('basket', $basket);


        return response()->redirectTo(route('cart.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @return void
     */
    public function update(Request $request, int $id) : void
    {
        // attribute is optional
        $request->validate([
            'type'=>['required', 'string', 'max:6'],
            'attribute'=>['nullable','numeric', 'max:6'],
        ]);


        // set shorthand of ajax request data
        $type = $request->input('type');
        $attribute = $request->input('attribute')??null;
        /*closure to manipulate more faster with less amount of code*/
        $manipulator = function($type, $quantity){
            if ($type=='remove'){
                $quantity--;
            } elseif ($type=='add'){
                $quantity++;
            }
            return $quantity;
        };

        // find product
        $product = Product::query()->findOrFail($id);
        // get basket session
        $basket = session()->get('basket');
        // manipulate product
        /*check ordered product existence*/
        if(isset($basket[$id]) && is_array($basket[$id])){
            /*set $product pointer from $basket array to manipulate it directly*/
            $ordered_product = &$basket[$id];
            /*check quantity of ordered product if its right manipulate it!*/
            if(($type=='remove' && $ordered_product['quantity'] > 1) || ($type=="add" && $ordered_product['quantity'] < $product->entity)){
                /*manipulate quantity*/
                $ordered_product['quantity'] = $manipulator($type, $ordered_product['quantity']);
                /*change prices*/
                $ordered_product['price'] = $ordered_product['quantity'] * $product->final_price;
                $ordered_product['total_discount'] = ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $ordered_product['quantity']) : 0;
                /*check if request also has attribute*/
                if (!is_null($attribute) && isset($ordered_product['attribute'][$attribute])){

                    /*check if product attribute quantity has the right amount*/
                    if(($type=='remove' && $ordered_product['attribute'][$attribute]['quantity']>1) || $ordered_product['attribute'][$attribute]['quantity'] >=1){
                        $ordered_product['attribute'][$attribute]['quantity']=$manipulator($type, $ordered_product['attribute'][$attribute]['quantity']);
                    } else {
                        unset($basket[$id]['attribute'][$attribute]);
                    }
                }
            }
            /*check quantity of ordered product if its less than one, remove whole product*/
            elseif($type=='remove' && $ordered_product['quantity']<=1){
                unset($basket[$id]);
            }
        }
        session()->put('basket', $basket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : void
    {
        $basket = session()->get('basket');
        if (isset($basket[$id])) {
            unset($basket[$id]);
            session()->put('basket', $basket);
        }
    }


}

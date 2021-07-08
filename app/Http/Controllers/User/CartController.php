<?php

namespace App\Http\Controllers\User;

use App\DiscountCode;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{

    /**
     * Compute the total order attributes
     *
     * @return array
     */
    protected function resetTotal(): array
    {
        $basket = session()->get('basket');
        $total = [
            'raw_price' => 0,
            'final_price' => 0,
            'discount' => 0,
            'count' => 0,
            'weight' => 0,
            'discount_code' => null
        ];
        if (!empty($basket)) {
            foreach ($basket as $order) {
                $total['raw_price'] += (int)$order['raw_price'];
                $total['final_price'] += (int)$order['price'];
                $total['discount'] += (int)$order['total_discount'];
                $total['count'] += (int)$order['quantity'];
                $total['weight'] += (int)$order['weight'];
            }
        }
        session()->put('total', $total);
        return $total;
    }

    /**
     * Compute the discount from discount code
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function applyDiscount(Request $request): RedirectResponse
    {
        $total = session()->get('total');
        if (is_null($total) || count($total) == 0) {
            return back()->with('error', 'مجموع سبد خرید برای اعمال کد تخفیف وجود ندارد!');
        }
        if (!is_null($total['discount_code'])) {
            return redirect(route('address.index'))->with('warning', 'شما قبلاً یک کد تخفیف را اعمال نموده اید!');
        }


        $request->validate([
            'discount_code' => 'nullable|string|min:2|max:10|exists:discount_codes,code'
        ], [
            'string' => 'نوع داده ای کد تخفیف اشتباه است، کاراکتر وارد کنید.',
            'min' => 'حداقل طول کد تخفیف ۲ کاراکتر است',
            'max' => 'حداکثر طول کد تخفیف ۱۰ کاراکتر است.',
            'exists' => 'این کد تخفیف وجود ندارد!',
        ]);
        if ($request->has('discount_code') && !empty($request->input('discount_code'))) {

            $discount_percent = DiscountCode::query()
                ->where('code', $request->input('discount_code'))
                ->first()
                ->percent;

            $discount_amount = ($total['final_price'] * $discount_percent) / 100;

            // total : discount , final_price, discount_code
            $total['final_price'] -= (int)$discount_amount;
            $total['discount'] += (int)$discount_amount;
            $total['discount_code'] = $request->input('discount_code');

            session()->put('total', $total);

            return redirect(route('address.index'))->with('success', 'کد تخفیف با موفقیت اعمال شد!');
        } else {
            return redirect(route('address.index'));
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'سبد خرید';
        $basket = session()->get('basket');
        /*show null page of basket*/
        if (is_null($basket) || count($basket) == 0) {
            return response()->view('front-v1.user.cart.null', [
                'title' => $title,
            ]);
        }

        $total = $this->resetTotal();

        return response()->view('front-v1.user.cart.index', [
            'title' => $title,
            'basket' => $basket,
            'total' => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public
    function store(Request $request)
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

        $product = Product::withoutTrashed()
            ->with('files', 'attrs')
            ->where('title_en', $request->input('order.product_id'))
            ->first();
        /*CHECK IF PRODUCT DOESN'T EXISTS*/
        if (empty($product)) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'محصول مورد نظر یافت نشد!',
                ], Response::HTTP_NOT_FOUND);
            }
            return redirect()->back()->with('warning', 'محصول مورد نظر یافت نشد!');
        }

        /*CHECK IF ORDER COUNT IS BIGGER THAN PRODUCT ENTITY*/
        if ($product->entity < $request->input('order.count')) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'تعداد درخواستی در انبار موجود نیست!',
                ], Response::HTTP_NOT_FOUND);
            }
            return redirect()->back()->with('warning', ' تعداد درخواستی در انبار موجود نیست!');
        }

        /*CHECK IF PRODUCT IS READY FOR ONLINE SELL*/
        if ($product->entity <= 0 || $product->price_type == 2 || $product->status == 2) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'اتمام موجودی محصول! لطفاً با مدیر در ارتباط باشید.'
                ], Response::HTTP_NO_CONTENT);
            }
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
                    'raw_price' => $request->input('order.count') * $product->price,
                    'price_type' => $product->price_type,
                    'discount_percent' => $product->discount_percent,
                    'total_discount' => ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $request->input('order.count')) : 0,
                    'weight' => $request->input('order.count') * $product->weight,
                    'pic' => $product->files()->defaultFile()->link,
                ],
            ];

        } elseif (isset($basket[$product->id])) {
            $quantity = &$basket[$product->id]['quantity'];
            $price = &$basket[$product->id]['price'];
            $total_discount = &$basket[$product->id]['total_discount'];
            $weight = &$basket[$product->id]['weight'];
            $order_attribute = &$basket[$product->id]['attribute'];
            $raw_price = &$basket[$product->id]['raw_price'];
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
                $raw_price += $request->input('order.count') * $product->price;
                $weight += (int)$request->input('order.count') * (int)$product->weight;
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
                    'raw_price' => $request->input('order.count') * $product->price,
                    'price_type' => $product->price_type,
                    'discount_percent' => $product->discount_percent,
                    'total_discount' => ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $request->input('order.count')) : 0,
                    'weight' => $request->input('order.count') * $product->weight,
                    'pic' => $product->files()->defaultFile()->link,
                ];
        }

        session()->put('basket', $basket);
        $this->resetTotal();

        /*RENDER ALL PARTIALS AND REMAINING COUNT OF PRODUCT*/
        $basket_aside = view('front-v1.partials.shared.basket_aside')->render();
        $basket_total = view('front-v1.partials.shared.basket_total')->render();
        $remaining_quantity = $product->entity - $quantity;

        if ($request->ajax()) {
            return response()->json([
                'basket_aside' => $basket_aside,
                'basket_total' => $basket_total,
                'quantity' => $remaining_quantity,
                'message' => ' محصول ' . $product->title . ' با موفقیت به سبد خرید شما افزوده شد.'
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'محصول با موفقیت به سبد خرید افزوده شد!');
        /*return response()->redirectTo(route('cart.index'));*/
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, int $id): void
    {
        // attribute is optional
        $request->validate([
            'type' => ['required', 'string', 'max:6'],
            'attribute' => ['nullable', 'numeric', 'max:6'],
        ]);


        // set shorthand of ajax request data
        $type = $request->input('type');
        $attribute = $request->input('attribute') ?? null;
        /*closure to manipulate more faster with less amount of code*/
        $manipulator = function ($type, $quantity, $step = 1) {
            if ($type == 'remove') {
                $quantity -= $step;
            } elseif ($type == 'add') {
                $quantity += $step;
            }
            return $quantity;
        };

        // find product
        $product = Product::query()->findOrFail($id);
        // get basket session
        $basket = session()->get('basket');
        // manipulate product
        /*check ordered product existence*/
        if (isset($basket[$id]) && is_array($basket[$id])) {
            /*set $product pointer from $basket array to manipulate it directly*/
            $ordered_product = &$basket[$id];
            /*check quantity of ordered product if its right manipulate it!*/
            if (($type == 'remove' && $ordered_product['quantity'] > 1) || ($type == "add" && $ordered_product['quantity'] < $product->entity)) {
                /*manipulate quantity*/
                $ordered_product['quantity'] = $manipulator($type, $ordered_product['quantity']);
                /*change prices*/
                $ordered_product['price'] = $ordered_product['quantity'] * $product->final_price;
                $ordered_product['raw_price'] = $ordered_product['quantity'] * $product->price;
                $ordered_product['total_discount'] = ($product->price_type == 0 && $product->discount_percent > 0) ? (($product->price - $product->discount_price) * $ordered_product['quantity']) : 0;
                /*change weight*/
                $ordered_product['weight'] = $ordered_product['quantity'] * $product->weight;
                /*check if request also has attribute*/
                if (!is_null($attribute) && isset($ordered_product['attribute'][$attribute])) {
                    $ordered_product_attribute = &$ordered_product['attribute'][$attribute];
                    /*check if product attribute quantity has the right amount*/
                    if (($type == 'remove' && $ordered_product_attribute['quantity'] > 1) || ($type == 'add' && $ordered_product_attribute['quantity'] >= 1)) {
                        $ordered_product_attribute['quantity'] = $manipulator($type, $ordered_product['attribute'][$attribute]['quantity']);
                    } else {
                        unset($basket[$id]['attribute'][$attribute]);
                    }
                }
            } /*check quantity of ordered product if its less than one, remove whole product*/
            elseif ($type == 'remove' && $ordered_product['quantity'] <= 1) {
                unset($basket[$id]);
            }
        }

        session()->put('basket', $basket);
        $this->resetTotal();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public
    function destroy(int $id, Request $request)
    {
        $basket = session()->get('basket');
        $total = session()->get('total');
        if (isset($basket[$id]) && isset($total)) {
            /*UNSET PRODUCT*/
            unset($basket[$id]);
            /*UPDATE SESSIONS*/
            session()->put('basket', $basket);
            $this->resetTotal();
        }
        if($request->ajax()){
            return response()
                ->json([
                    'message' => 'محصول مورد نظر با موفقیت از سبد خرید حذف شد!',
                ], Response::HTTP_OK);
        }
        return response()
            ->redirectToRoute('cart.index')
            ->with('success', 'محصول مورد نظر با موفقیت از سبد خرید حذف شد.');
    }
}

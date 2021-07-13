<?php

namespace App\Http\Controllers\User\Factor;

use App\Factor;
use App\FactorProduct;
use App\FactorProductAttribute;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class FactorController extends Controller
{


    protected function getFactor($uuid)
    {
        return Factor::query()
            ->with('products', 'products.attributes')
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->first();
    }

    /*CHECK IF FACTOR IS VALID*/
    protected function controlFactor($factor)
    {
        /*codes=> 1 : return to order.index, 2: return to factor show*/
        try {
            if (empty($factor)) {
                throw new \Exception('فاکتور مورد نظر شما یافت نشد!', 1);
            }
            if ($factor->status == "1") {
                throw new \Exception('فاکتور ' . $factor->uuid . ' پرداخت شده! ', 2);
            }
            if ($factor->created_at < Carbon::today()->subDays(2)) {
                throw new \Exception('فاکتور جدیدی ثبت کنید! فاکتور شما آرشیو شده.', 2);
            }
            /*CHECK IF PRODUCT QUANTITY EXISTS*/
            foreach ($factor->products as $ordered_product){
                $product = Product::withoutTrashed()
                    ->where('id', $ordered_product->product_id)
                    ->first();
                if($product->entity < $ordered_product->count){
                    throw new \Exception(' موجودی محصول '. $product->title . ' به اتمام رسیده! ', 2);
                }
            }

        } catch
        (\Exception $e) {
            return [$e->getMessage(), $e->getCode()];
        }
        return ['فاکتور معتبر', 200];
    }


    /*CHECK IF USER CAN CREATE OR PAY A FACTOR*/
    protected function controlUserFactor($user)
    {
        /*codes=> 1 : return to order.index, 2: return to factor show*/
        $userActiveFactors = $user->factors()->activeFactors()->get();
        try {
            if (!empty($userActiveFactors) && count($userActiveFactors)) {
                throw new \Exception('کاربر گرامی شما حداقل یک فاکتور فعال پرداخت نشده دارید.', 1);
            }
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            return [$message, $code];
        }
        return ['کاربر توانایی پرداخت فاکتور را دارد.', 200];

    }


    public function store(Request $request)
    {

        $user = Auth::user();
        /*CONTROL USER PERMISSION TO CREATE NEW FACTOR*/
        $control_user = $this->controlUserFactor($user);
        if ($control_user[1] == 1) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', $control_user[0]);
        }


        $basket = session()->get('basket');
        $total = session()->get('total');

        if (empty($basket) || empty($total)) {
            session()->forget(['basket', 'total']);
            return redirect()
                ->back()
                ->with('error', 'سبد خرید شما خالیست؛ لطفاً دوباره تلاش کنید.');
        }


        $user = Auth::user();
        if (empty($user)) {
            return response()
                ->redirectToRoute('home')
                ->with('error', 'در تشخیص حساب کاربری مشکلی ایجاد شده! لفطا دوباره وارد شوید و تلاش کنید.');
        }

        $shipping = $user->default_address;
        if(empty($shipping)){
            return back()
                ->with('error', 'آدرسی برای ارسال سفارش ثبت یا انتخاب نشده!');
        }
        $shipping = $shipping->toArray();

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
            ->redirectToRoute('factor.pay', $factor->uuid)
            ->with('success', 'فاکتور شما با موفقیت ثبت شد!');
    }


    public function pay($uuid)
    {
        $user = Auth::user();

        $factor = $user->factors()
            ->with('products')
            ->activeFactors()
            ->where('uuid', $uuid)
            ->first();

        $control_factor = $this->controlFactor($factor);
        if ($control_factor[1] == 1) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', $control_factor[0]);
        } elseif ($control_factor[1] == 2) {
            return response()
                ->redirectToRoute('dashboard.orders.show', $factor->uuid)
                ->with('error', $control_factor[0]);
        }


        /*CREATE INVOICE BASED ON FACTOR*/
        $invoice = (new Invoice)->amount((int)$factor->price);
        $invoice->detail([
            'mobile' => $user->mobile,
            'description' => 'پرداخت فاکتور شماره ' . $factor->uuid . ' وبسایت ' . config('app.short.name'),
        ]);

        /*GO TO ZARINPAL AND BACK TO FACTOR SHOW*/
        $payment = Payment::callbackUrl(route('factor.verify', $factor->uuid))->purchase($invoice);

        //dd($invoice,$invoice->getDriver(),$invoice->getAmount(), $invoice->getDetails(), $invoice->getTransactionId(), $invoice->getUuid());
        $factor->pay_trans_id = $invoice->getTransactionId();
        $factor->pay_tracking = $invoice->getUuid();
        $factor->save();

        /*GO TO GATE PAY PAGE*/
        return $payment->pay()->render();

    }

    public function verify($uuid, Request $request)
    {
        $user = Auth::user();
        $factor = $user->factors()
            ->with('products')
            ->activeFactors()
            ->where('uuid', $uuid)
            ->first();

        /* Verify Payment*/
        try {
            /*CHANGE PRODUCT QUANTITY*/
            $receipt = Payment::amount((int)$factor->price)
                ->transactionId($factor->pay_trans_id)
                ->verify();
            $factor->pay_reference = $receipt->getReferenceId();
            $factor->status = 1;
            $factor->paid_at = now();
            $factor->error_code = null;
            $factor->error_message = null;
            foreach ($factor->products as $ordered_product){
                $product = Product::withoutTrashed()
                    ->where('id', $ordered_product->product_id)
                    ->first();
                $product->entity -= $ordered_product->count;
                $product->sold += $ordered_product->count;
                $product->save();
            }
            session()->flash('success', 'فاکتور شما با موفقیت پرداخت شد');

        } catch (InvalidPaymentException $e) {
            $factor->status = 2; // Failure payment
            $factor->error_code = $e->getCode();
            $factor->error_message = $e->getMessage();
            session()->flash('error', $e->getMessage());
        }
        $factor->user_ip = $request->ip();
        $factor->save();

        /*SHOW VIEW*/
        return response()
            ->redirectToRoute('dashboard.orders.show', $factor->uuid);
    }


}

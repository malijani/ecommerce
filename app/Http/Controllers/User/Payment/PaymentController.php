<?php

namespace App\Http\Controllers\User\Payment;

use App\Factor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{

    protected function getFactor($uuid)
    {
        return Factor::query()
            ->with('products', 'products.attributes')
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->first();

    }

    public function pay($uuid)
    {
        $factor = $this->getFactor($uuid);
        if (empty($factor)) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', 'فاکتور مورد نظر شما یافت نشد!');
        }
        if ($factor->status == "1") {
            return response()
                ->redirectToRoute('dashboard.orders.show', $factor->uuid)
                ->with('error', 'این فاکتور پرداخت شده است!');
        }

        $user = Auth::user();
        /*CREATE INVOICE BASED ON FACTOR*/
        $invoice = (new Invoice)->amount((int)$factor->price);
        $invoice->detail([
            'mobile' => $user->mobile,
            'description' => 'پرداخت فاکتور شماره ' . $factor->uuid . ' وبسایت ' . config('app.short.name'),
        ]);

        /*GO TO ZARINPAL AND BACK TO FACTOR SHOW*/
        $payment = Payment::callbackUrl(route('payment.verify', $factor->uuid))->purchase($invoice);

        //dd($invoice,$invoice->getDriver(),$invoice->getAmount(), $invoice->getDetails(), $invoice->getTransactionId(), $invoice->getUuid());
        $factor->pay_trans_id = $invoice->getTransactionId();
        $factor->pay_tracking = $invoice->getUuid();
        $factor->save();

        /*GO TO GATE PAY PAGE*/
        return $payment->pay()->render();
    }

    public function verify($uuid)
    {
        $factor = $this->getFactor($uuid);
        if (empty($factor)) {
            return response()
                ->redirectToRoute('dashboard.orders.index')
                ->with('error', 'فاکتور مورد نظر شما یافت نشد!');
        }
        if ($factor->status == "1") {
            return response()
                ->redirectToRoute('dashboard.orders.show', $factor->uuid)
                ->with('error', 'این فاکتور پرداخت شده است!');
        }
        /* Verify Payment*/
        try {
            $receipt = Payment::amount((int)$factor->price)
                ->transactionId($factor->pay_trans_id)
                ->verify();
            $factor->pay_reference = $receipt->getReferenceId();
            $factor->status = 1;
            $factor->paid_at = now();
            session()->flash('success', 'فاکتور شما با موفقیت پرداخت شد');

        } catch (InvalidPaymentException $e) {
            $factor->status = 2; // Failure payment
            session()->flash('error', $e->getMessage());
        }
        $factor->save();

        /*SHOW VIEW*/
        return response()
            ->redirectToRoute('dashboard.orders.show', $factor->uuid);
    }
}

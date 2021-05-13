<?php
namespace App\Helpers;

use MohsenBostan\GhasedakSms;
use SanjabVerify\Contracts\VerifyMethod;

class SmsVerifyMethod implements VerifyMethod
{
    public function send(string $receiver, string $code) : bool
    {
        // Send code to receiver
        $message = 'کد تایید ' . config('app.short.name') . " : ". $code;
        $sms_response = GhasedakSms::sendSingleSMS($message, $receiver);
        if ($sms_response['result']['message'] == 'success') {
            return true; // If code sent successfully then return true
        }
        return false; // If send code failed return false
    }
}

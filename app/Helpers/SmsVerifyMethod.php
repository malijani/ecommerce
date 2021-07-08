<?php

namespace App\Helpers;
use Ghasedak\GhasedakApi;
use SanjabVerify\Contracts\VerifyMethod;

class SmsVerifyMethod implements VerifyMethod
{
    public function send(string $receiver, string $code): bool
    {
        $api = new GhasedakApi(config("ghasedak-sms.api_key", ""));

        $type = 1;
        $template = "gymlandauth";
        $param1 = $code;
        $sms_response = $api->Verify($receiver, $type, $template, $param1);

        if ($sms_response->result->message == 'success' && $sms_response->result->code == 200) {
            return true; // If code sent successfully then return true
        }
        return false; // If send code failed return false
    }
}

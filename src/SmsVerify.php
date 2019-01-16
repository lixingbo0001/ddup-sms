<?php

namespace Ddup\Sms;

use Ddup\Sms\Exceptions\SmsException;

class SmsVerify
{
    public static function verifyAndDel($number, $code)
    {
        self::verify($number, $code);
        SmsHelper::delete($number);

        return true;
    }

    public static function verify($number, $code)
    {
        $sendCode = SmsHelper::hasSend($number);

        if (!$code) {
            throw new SmsException("验证码无效", SmsException::invalid_sms_verify_code, [
                'send_code'  => $sendCode,
                'input_code' => $code
            ]);
        }

        if ($sendCode != $code) {
            throw new SmsException("验证码错误", SmsException::invalid_sms_verify_code, [
                'send_code'  => $sendCode,
                'input_code' => $code
            ]);
        }

        return true;
    }
}
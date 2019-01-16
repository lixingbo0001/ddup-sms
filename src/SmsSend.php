<?php

namespace Ddup\Sms;


use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\Contracts\Cacheable;
use Ddup\Sms\Exceptions\SmsException;
use Ddup\Sms\Contracts\SmsInterface;

class SmsSend
{
    public function __construct(OptionStruct $config, Cacheable $cacheable, SmsInterface $sms)
    {
        SmsHelper::setCacher($cacheable);
        SmsHelper::setConfig($config);
        SmsHelper::setSms($sms);
    }

    public function send($number, $code = null, $params = [])
    {
        if (SmsHelper::hasSend($number)) {
            throw new SmsException("请稍后重试");
        }

        $code = $code ?: SmsHelper::getCode();

        if (!SmsHelper::hander()->send($number, '您的验证码是：' . $code)) {
            throw new SmsException('短信发送失败', SmsException::sms_send_fail, [
                'request'  => [
                    'mobile' => $number,
                    'msg'    => '您的验证码是：' . $code
                ],
                'response' => SmsHelper::hander()->result()->getMsg()
            ]);
        }

        SmsHelper::save($number, $code);

        return true;
    }


}
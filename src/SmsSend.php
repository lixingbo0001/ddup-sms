<?php

namespace Ddup\Sms;


use Ddup\Sms\Exceptions\SmsException;
use Ddup\Sms\Kernel\ServiceContainer;

class SmsSend
{
    private $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container;

        SmsHelper::setApp($container);
    }

    public function send($number, $code = null)
    {
        $api = clone SmsHelper::hander();

        if (SmsHelper::hasSend($number)) {
            throw new SmsException("请稍后重试");
        }

        $code = $code ?: SmsHelper::getCode();

        if (!$api->send($number, '您的验证码是：' . $code)) {
            throw new SmsException('短信发送失败', SmsException::sms_send_fail, [
                'request'  => [
                    'mobile' => $number,
                    'msg'    => '您的验证码是：' . $code
                ],
                'response' => $api->result()->getMsg()
            ]);
        }

        SmsHelper::save($number, $code);

        return $api;
    }


}
<?php namespace Ddup\Sms\Test;


use Ddup\Sms\SmsSend;
use Ddup\Sms\SmsVerify;

class SmsSendTest extends TestCase
{

    function test_send()
    {
        $sms = new SmsSend($this->container);

        $api = $sms->send(self::mobile, 1234);

        $this->assertTrue($api->result()->isSuccess(), $api->result()->getMsg());
    }

    function test_del()
    {
        SmsVerify::verifyAndDel(self::mobile, 1234);

        try {
            SmsVerify::verifyAndDel(self::mobile, 1234);

        } catch (\Exception $exception) {
            $this->assertEquals('验证码错误', $exception->getMessage());
        }
    }

    function test_expire()
    {
        $this->container->config->expires = 0;

        $sender = new SmsSend($this->container);

        $sender->send(self::mobile, 1234);

        try {
            SmsVerify::verifyAndDel(self::mobile, 1234);

        } catch (\Exception $exception) {
            $this->assertEquals('验证码错误', $exception->getMessage());
        }
    }
}
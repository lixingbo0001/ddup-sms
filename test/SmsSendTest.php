<?php namespace Ddup\Sms\Test;

use Ddup\Sms\SmsChLan\ChLanSms;
use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\SmsSend;
use Ddup\Sms\SmsVerify;
use Ddup\Sms\Test\Provider\CacheProvider;

class SmsSendTest extends TestCase
{
    function test_verify()
    {
        try {
            SmsVerify::verify(self::mobile, 1234);
        } catch (\Exception $exception) {
            $this->assertEquals('短信服务没有初始化', $exception->getMessage());
        }
    }

    function test_send()
    {
        $config = new OptionStruct(self::config);
        $api    = new ChLanSms($config);
        $sms    = new SmsSend($config, new CacheProvider(), $api);

        $sms->send(self::mobile, 1234);

        SmsVerify::verifyAndDel(self::mobile, 1234);

        try {
            SmsVerify::verifyAndDel(self::mobile, 1234);

        } catch (\Exception $exception) {
            $this->assertEquals('验证码错误', $exception->getMessage());
        }

        $this->assertTrue($api->result->isSuccess(), $api->result->getMsg());
    }

    function test_expire()
    {
        $config          = new OptionStruct(self::config);
        $config->expires = 0;
        $api             = new ChLanSms($config);
        $sms             = new SmsSend($config, new CacheProvider(), $api);

        $sms->send(self::mobile, 1234);

        try {
            SmsVerify::verifyAndDel(self::mobile, 1234);

        } catch (\Exception $exception) {
            $this->assertEquals('验证码错误', $exception->getMessage());
        }
    }
}
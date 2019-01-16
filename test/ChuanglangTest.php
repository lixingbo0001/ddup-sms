<?php namespace Ddup\Sms\Test;

use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\SmsChLan\ChLanSms;

class ChuanglangTest extends TestCase
{
    function test_send()
    {
        $api = new ChLanSms($this->container, new OptionStruct([
            'expires'  => 60,
            'table'    => 'mt_sms_nobody',
            'sign'     => '【侨友卡】',
            'account'  => 'N5200624',
            'password' => 'ftjJhPqT3',
            'host'     => 'http://smssh1.253.com',
        ]));

        $api->send(self::mobile, '登高一呼时才懂，始终在为你心痛');

        $this->assertTrue($api->result->isSuccess(), $api->result->getMsg());
    }
}
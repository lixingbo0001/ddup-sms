<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/1/15
 * Time: 下午1:45
 */

namespace Ddup\Sms\Test;


class TestCase extends \PHPUnit\Framework\TestCase
{
    const mobile = 13127503298;

    const config = [
        'expires'  => 60,
        'table'    => 'mt_sms_nobody',
        'sign'     => '【侨友卡】',
        'account'  => 'N5200624',
        'password' => 'ftjJhPqT3',
        'host'     => 'http://smssh1.253.com',
    ];
}
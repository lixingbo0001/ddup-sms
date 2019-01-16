<?php namespace Ddup\Sms\Contracts;


use Ddup\Part\Api\ApiResultInterface;

interface SmsInterface
{
    public function send($number, $msg, $sign = null);

    function result():ApiResultInterface;
}
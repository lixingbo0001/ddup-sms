<?php namespace Ddup\Sms\Contracts;


interface SmsInterface
{
    public function send($number, $sign, $msg);
}
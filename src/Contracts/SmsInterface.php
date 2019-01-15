<?php namespace Providers\Sms\Contracts;

interface SmsInterface
{

    public function send($number, $sign, $msg, Array $params);

    public function getResponse();

    public function getRequest();

}
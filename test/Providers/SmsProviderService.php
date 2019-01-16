<?php

namespace Ddup\Sms\Test\Providers;


use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\ServiceContainer;
use Ddup\Sms\SmsChLan\ChLanSms;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SmsProviderService implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if ($pimple instanceof ServiceContainer) {

            $config = new OptionStruct([
                'expires'  => 60,
                'table'    => 'mt_sms_nobody',
                'sign'     => '【侨友卡】',
                'account'  => 'N5200624',
                'password' => 'ftjJhPqT3',
                'host'     => 'http://smssh1.253.com',
            ]);

            $pimple->config = $config;

            $pimple->sms = (function () use ($pimple, $config) {

                return new ChLanSms($pimple, $config);
            });
        }
    }
}
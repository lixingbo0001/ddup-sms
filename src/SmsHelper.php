<?php

namespace Ddup\Sms;


use Ddup\Part\Libs\Str;
use Ddup\Sms\Kernel\ServiceContainer;

class SmsHelper
{
    /**
     * @var ServiceContainer
     */
    private static $app;
    private static $len = 4;

    static function setApp(ServiceContainer $app)
    {
        self::$app = $app;
    }

    private static function cacher()
    {
        return self::$app->cacher;
    }

    public static function hander()
    {
        return self::$app->sms;
    }

    private static function config()
    {
        return self::$app->config;
    }

    static function getCode()
    {
        return Str::rand(self::$len, range(0, 9));
    }

    static function getCacheName($number)
    {
        return self::config()->table . $number;
    }

    static function hasSend($number)
    {
        $name = self::getCacheName($number);

        return self::cacher()->get($name);
    }

    static function delete($number)
    {
        $name = self::getCacheName($number);

        self::cacher()->del($name);
    }

    static function save($number, $code)
    {
        $name = self::getCacheName($number);

        self::cacher()->set($name, $code, self::config()->expires);
    }
}
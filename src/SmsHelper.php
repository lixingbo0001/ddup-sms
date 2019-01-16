<?php

namespace Ddup\Sms;


use Ddup\Part\Libs\Str;
use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\Contracts\Cacheable;
use Ddup\Sms\Contracts\SmsInterface;
use Ddup\Sms\Exceptions\SmsException;

class SmsHelper
{

    /**
     * @var Cacheable
     */
    private static $cacher;

    /**
     * @var OptionStruct
     */
    private static $config;

    /**
     * @var SmsInterface
     */
    private static $sms;

    private static $len = 4;

    static function setCacher(Cacheable $cacheable)
    {
        self::$cacher = $cacheable;
    }

    private static function checkInited($provider)
    {
        if (!$provider) {
            throw new SmsException('短信服务没有初始化');
        }
    }

    private static function cacher()
    {
        self::checkInited(self::$cacher);
        return self::$cacher;
    }

    public static function hander()
    {
        self::checkInited(self::$sms);
        return self::$sms;
    }

    private static function config()
    {
        self::checkInited(self::$config);
        return self::$config;
    }

    static function setSms(SmsInterface $sms)
    {
        self::$sms = $sms;
    }

    static function setConfig(OptionStruct $config)
    {
        self::$config = $config;
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
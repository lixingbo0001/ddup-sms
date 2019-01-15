<?php

namespace Providers\Sms;


use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\Exceptions\SmsException;
use Providers\Sms\Contracts\SmsInterface;
use Illuminate\Support\Facades\Redis;
use Libs\Str;


class SmsVerify
{

    /**
     * @var SmsInterface
     */
    private        $sms;
    private static $config;

    public function __construct(OptionStruct $config, SmsInterface $sms)
    {
        self::$config = $config;
        $this->sms    = $sms;
    }

    private function getCode()
    {
        return Str::rand(4, range(0, 9));
    }

    private static function getCacheName($number)
    {
        return self::$config->table . $number;
    }

    private static function hasSend($number)
    {
        $name = self::getCacheName($number);

        return Redis::get($name);
    }

    private function save($number, $code)
    {
        $name = $this->getCacheName($number);

        Redis::set($name, $code);

        Redis::expire($name, self::$config->expires);
    }

    private static function delete($number)
    {
        $name = self::getCacheName($number);
        Redis::del($name);
    }

    public function send($number, $params = [])
    {
        if ($this->hasSend($number)) {
            throw new SmsException("请稍后重试");
        }

        $code = $this->getCode();

        if (!$this->sms->send($number, self::$config->sign, '您的验证码是：' . $code, $params)) {
            throw new SmsException('短信发送失败', SmsException::sms_send_fail, [
                'request' => $this->sms->getRequest(), 'response' => $this->sms->getResponse()
            ]);
        }

        $this->save($number, $code);

        return true;
    }

    public static function verifyAndDel($number, $code)
    {
        self::verify($number, $code);
        self::delete($number);

        return true;
    }

    public static function verify($number, $code)
    {
        $sendCode = self::hasSend($number);

        if (!$code) {
            throw new SmsException("验证码无效", SmsException::invalid_sms_verify_code, [
                'send_code'  => $sendCode,
                'input_code' => $code
            ]);
        }

        if ($sendCode != $code) {
            throw new SmsException("验证码错误", SmsException::invalid_sms_verify_code, [
                'send_code'  => $sendCode,
                'input_code' => $code
            ]);
        }

        return true;
    }
}
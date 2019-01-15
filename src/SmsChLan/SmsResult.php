<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/1/15
 * Time: 上午11:24
 */

namespace Ddup\Sms\SmsChLan;


use Ddup\Part\Api\ApiResultInterface;
use Ddup\Part\Libs\Helper;

class SmsResult implements ApiResultInterface
{

    private $_result;

    public function __construct($response)
    {
        $this->_result = Helper::toCollection($response);
    }

    public function getMsg()
    {
        return $this->_result->get('errorMsg');
    }

    public function getData()
    {
        return $this->_result;
    }

    public function isSuccess()
    {
        return $this->getCode() == '0';
    }

    public function getCode()
    {
        return $this->_result->get('code');
    }
}
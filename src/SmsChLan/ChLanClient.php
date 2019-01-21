<?php

/**
 * User: lixingbo
 * Description: 创蓝
 * Date: 2019/1/15
 * Time: 上午11:24
 */

namespace Ddup\Sms\SmsChLan;


use Ddup\Part\Api\ApiResultInterface;
use Ddup\Sms\Config\OptionStruct;
use Ddup\Sms\Kernel\BaseClient;
use Ddup\Sms\Kernel\ServiceContainer;

class ChLanClient extends BaseClient
{
    private $config;

    public function __construct(ServiceContainer $container, OptionStruct $struct)
    {
        $this->config = $struct;

        parent::__construct($container);
    }

    public function newResult($ret):ApiResultInterface
    {
        return new ChLanSmsResult($ret);
    }

    public function getTimeout()
    {
        return $this->config->timeout;
    }

    public function getBaseUri()
    {
        return $this->config->host;
    }

    public function requestOptions()
    {
        return [
            'headers' => [
                'content-type' => 'application/json'
            ]
        ];
    }

    public function requestParams()
    {
        return [
            'account'  => $this->config->account,
            'password' => $this->config->password
        ];
    }

    public function request($method, $endpoint, $options = [])
    {
        $ret = parent::request($method, $endpoint, $options);

        $this->parseResult($ret);

        return $ret;
    }

}
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
use Ddup\Sms\Contracts\SmsInterface;
use Ddup\Sms\Kernel\ServiceContainer;

class ChLanSms implements SmsInterface
{

    private $api_send_url          = 'msg/send/json';
    private $api_var_url           = 'msg/variable/json';
    private $api_balance_query_url = 'msg/balance/json';

    private $config;
    private $client;

    public function __construct(ServiceContainer $container, OptionStruct $struct)
    {
        $this->config = $struct;
        $this->client = new ChLanClient($container, $struct);
    }

    public function result():ApiResultInterface
    {
        return $this->client->result();
    }

    public function sendVariable($msg, $params)
    {
        $post_data = [
            'msg'    => urlencode($msg),
            'report' => true,
            'params' => $params
        ];

        return $this->client->json($this->api_var_url, $post_data);
    }

    public function queryBalance()
    {
        return $this->client->json($this->api_balance_query_url, []);
    }

    private function sign($sign)
    {
        return is_null($sign) ? $this->config->sign : $sign;
    }

    public function send($number, $msg, $sign = null)
    {
        $sign = $this->sign($sign);

        $post_data = [
            'msg'    => urlencode($sign . $msg),
            'report' => true,
            'phone'  => $number
        ];

        return $this->client->json($this->api_send_url, $post_data);
    }
}
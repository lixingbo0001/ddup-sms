<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/1/16
 * Time: 下午5:17
 */

namespace Ddup\Sms\Contracts;


interface Cacheable
{
    function set($name, $value, int $seconds = null);

    function get($name);

    function del($name);

    function expire($name, int $seconds);
}
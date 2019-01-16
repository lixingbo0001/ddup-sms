<?php namespace Ddup\Sms\Providers;


use Ddup\Sms\Contracts\Cacheable;

class CacheMook implements Cacheable
{
    private $respository = [];

    function set($name, $value, int $seconds = null)
    {
        $this->respository[$name] = [
            'expire' => time() + $seconds,
            'value'  => $value
        ];
    }

    function get($name)
    {
        if (!isset($this->respository[$name])) return null;

        $row = array_get($this->respository, $name);

        if ($row['expire'] <= time()) {

            self::del($name);

            return null;
        }

        return $row['value'];
    }

    function del($name)
    {
        return array_forget($this->respository, $name);
    }

    function expire($name, int $seconds)
    {
        if (!isset($this->respository[$name])) return false;

        $this->respository[$name]['expire'] = time() + $seconds;

        return true;
    }


}
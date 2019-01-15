<?php namespace Ddup\Sms\Config;

use Ddup\Part\Struct\StructReadable;

class OptionStruct extends StructReadable
{
    public $timeout  = 3;
    public $table    = '';
    public $expires  = 600;
    public $sign     = '';
    public $account  = '';
    public $password = '';
    public $host     = '';
}
<?php namespace Ddup\Sms\Config;

use Ddup\Part\Struct\StructReadable;

class Config extends StructReadable
{
    public $timeout = 3;
    public $table   = '';
    public $expires = 600;
}
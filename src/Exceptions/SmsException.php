<?php namespace Ddup\Sms\Exceptions;

use Ddup\Part\Exception\ExceptionCustomCodeAble;

class SmsException extends ExceptionCustomCodeAble
{
    const invalid_sms_verify_code = 'invalid_sms_verify_code';
    const sms_send_fail           = 'sms_send_fail';
}
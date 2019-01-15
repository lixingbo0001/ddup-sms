<?php namespace Ddup\Sms\Exceptions;

class SmsException extends \Exception
{
    const invalid_sms_verify_code = 'invalid_sms_verify_code';
    const sms_send_fail           = 'sms_send_fail';
}
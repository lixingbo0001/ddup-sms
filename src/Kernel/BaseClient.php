<?php namespace Ddup\Sms\Kernel;


use Ddup\Part\Api\ApiResulTrait;
use Ddup\Part\Request\HasHttpRequest;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LogLevel;

abstract class BaseClient
{

    use HasHttpRequest;
    use ApiResulTrait;

    protected $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;

        $this->registerMiddleware();
    }

    private function logMiddleware()
    {
        $formatter = new MessageFormatter('{url} {method} {req_body}');

        return Middleware::log($this->container->logger, $formatter, LogLevel::DEBUG);
    }

    private function registerMiddleware()
    {
        $this->pushMiddleware(self::logMiddleware(), 'log');
    }
}
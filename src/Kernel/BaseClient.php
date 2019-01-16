<?php namespace Ddup\Sms\Kernel;


use Ddup\Part\Api\ApiResulTrait;
use Ddup\Part\Request\HasHttpRequest;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;

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
        $formatter = new MessageFormatter('request => {request}');

        return Middleware::log($this->container->logger, $formatter);
    }

    private function registerMiddleware()
    {
        $this->pushMiddleware(self::logMiddleware(), 'log');
    }
}
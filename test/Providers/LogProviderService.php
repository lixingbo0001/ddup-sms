<?php

namespace Ddup\Sms\Test\Providers;


use Ddup\Logger\Cli\CliLogger;
use Ddup\Sms\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogProviderService implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if ($pimple instanceof ServiceContainer) {
            $pimple->logger = (function () {
                $logger = new CliLogger();
                return $logger;
            });
        }
    }
}
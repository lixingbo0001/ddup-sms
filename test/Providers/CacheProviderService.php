<?php

namespace Ddup\Sms\Test\Providers;

use Ddup\Sms\ServiceContainer;
use Ddup\Sms\Providers\CacheMook;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CacheProviderService implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        if ($pimple instanceof ServiceContainer) {
            $pimple->cacher = (function () {
                $cache = new CacheMook();
                return $cache;
            });
        }
    }
}
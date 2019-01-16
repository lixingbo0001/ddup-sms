<?php

namespace Ddup\Sms\Kernel;

use Ddup\Sms\Config\Config;
use Ddup\Sms\Contracts\Cacheable;
use Ddup\Sms\Contracts\SmsInterface;
use Pimple\Container;
use Psr\Log\LoggerInterface;

/**
 * Class ServiceContainer
 * @property LoggerInterface $logger
 * @property Cacheable $cacher
 * @property SmsInterface $sms
 * @property Config $config
 * @package Ddup\Sms
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * Constructor.
     *
     * @param array $config
     * @param array $prepends
     * @param string|null $id
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        $this->registerProviders($this->getProviders());

        parent::__construct($prepends);

        $this->userConfig = $config;
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}

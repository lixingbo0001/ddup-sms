<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/1/15
 * Time: 下午1:45
 */

namespace Ddup\Sms\Test;

use Ddup\Sms\Kernel\ServiceContainer;
use Ddup\Sms\Test\Providers\SmsProviderService;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ServiceContainer
     */
    protected $container;

    const mobile = 13127503298;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $container = new ServiceContainer();

        $container->registerProviders([
            SmsProviderService::class
        ]);

        $this->container = $container;
    }

}
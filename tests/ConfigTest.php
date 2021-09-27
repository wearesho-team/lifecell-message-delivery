<?php

namespace Wearesho\Delivery\Lifecell\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class ConfigTest
 * @package Wearesho\Delivery\Lifecell\Tests
 */
class ConfigTest extends TestCase
{
    protected Delivery\Lifecell\Config $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Delivery\Lifecell\Config();
    }

    public function testGetAuth(): void
    {
        $this->config->auth = 'Auth123';
        $this->assertEquals(
            'Auth123',
            $this->config->getAuth()
        );
    }
}

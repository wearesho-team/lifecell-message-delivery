<?php

namespace Wearesho\Delivery\Lifecell\Tests;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Delivery\Lifecell\Tests
 * @coversDefaultClass \Wearesho\Delivery\Lifecell\
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Delivery\Lifecell\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Delivery\Lifecell\EnvironmentConfig;
    }

    public function testGetAuth(): void
    {
        putenv('LIFECELL_SMS_AUTH=testAuth');
        $this->assertEquals('testAuth', $this->config->getAuth());
    }

    public function testSender(): void
    {
        putenv('LIFECELL_SMS_SENDER_NAME=wearesho');
        $this->assertEquals('wearesho', $this->config->getSenderName());
        putenv('LIFECELL_SMS_SENDER_NAME');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getSenderName();
    }
}

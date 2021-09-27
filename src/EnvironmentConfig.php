<?php

namespace Wearesho\Delivery\Lifecell;

use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Delivery\Lifecell
 */
class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    public function __construct(string $keyPrefix = 'LIFECELL_SMS_')
    {
        parent::__construct($keyPrefix);
    }

    /**
     * @throws Environment\MissingEnvironmentException
     */
    public function getSenderName(): string
    {
        return $this->getEnv('SENDER_NAME');
    }

    /**
     * @throws Environment\MissingEnvironmentException
     */
    public function getAuth(): string
    {
        return $this->getEnv('AUTH');
    }
}

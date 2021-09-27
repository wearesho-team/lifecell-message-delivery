<?php

namespace Wearesho\Delivery\Lifecell;

/**
 * Class Config
 * @package Wearesho\Delivery\Lifecell
 */
class Config implements ConfigInterface
{
    public string $sender = 'test';

    public ?string $auth;

    public function getSenderName(): string
    {
        return $this->sender;
    }

    public function getAuth(): string
    {
        return  $this->auth;
    }
}

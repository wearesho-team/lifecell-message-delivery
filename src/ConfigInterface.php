<?php

namespace Wearesho\Delivery\Lifecell;

/**
 * Interface ConfigInterface
 * @package Wearesho\Delivery\Lifecell
 */
interface ConfigInterface
{
    public function getSenderName(): string;

    public function getAuth(): string;
}

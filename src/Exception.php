<?php

namespace Wearesho\Delivery\Lifecell;

use Wearesho\Delivery;

/**
 * Class Exception
 * @package Wearesho\Delivery\Lifecell
 */
class Exception extends Delivery\Exception
{
    public const ERR_UNKNOWN = 200;
    public const ERR_FORMAT = 201;
    public const ERR_AUTHORIZATION = 202;
    public const ERR_USER_DISABLE = 205;
    public const ERR_API_DISABLE = 209;
    public const ERR_IP_DENIED = 210;
    public const ERR_THROTTLE = 212;
}

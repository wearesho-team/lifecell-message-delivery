# AlphaSMS Integration

[![Latest Stable Version](https://poser.pugx.org/wearesho-team/lifecell-message-delivery/v/stable.png)](https://packagist.org/packages/wearesho-team/alphasms-message-delivery)
[![Total Downloads](https://poser.pugx.org/wearesho-team/lifecell-message-delivery/downloads.png)](https://packagist.org/packages/wearesho-team/alphasms-message-delivery)
[![Build Status](https://travis-ci.org/wearesho-team/lifecell-message-delivery.svg?branch=master)](https://travis-ci.org/wearesho-team/alphasms-message-delivery)
[![codecov](https://codecov.io/gh/wearesho-team/lifecell-message-delivery/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/alphasms-message-delivery)

[wearesho-team/message-delivery](https://github.com/wearesho-team/message-delivery) implementation of
[Delivery\ServiceInterface](https://github.com/wearesho-team/message-delivery/blob/1.3.4/src/ServiceInterface.php)

## Installation

```bash
composer require wearsho-team/lifecell-message-delivery
```

## Usage

### Configuration

[ConfigInterface](./src/ConfigInterface.php) have to be used to configure requests. Available implementations:

- [Config](./src/Config.php) - simple implementation using class properties
- [EnvironmentConfig](./src/EnvironmentConfig.php) - loads configuration values from environment using
  [getenv](http://php.net/manual/ru/function.getenv.php)

| Variable                 | Description                                              |
|--------------------------|----------------------------------------------------------|
| LIFECELL_SMS_AUTH        | Authorization for request                                |
| LIFECELL_SMS_SENDER_NAME | Alphaname that is used to send a text message            |


### Additional methods

Besides implementing Delivery\ServiceInterface [Service](./src/Service.php) provides

```php
<?php

use Wearesho\Delivery;

$config = new Delivery\Lifecell\Config;
$config->auth = 'auth123';
$config->sender = 'SenderName';

$service = new Delivery\Lifecell\Service($config, new GuzzleHttp\Client);
```

## License

[MIT](./LICENSE)

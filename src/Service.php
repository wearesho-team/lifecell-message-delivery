<?php

namespace Wearesho\Delivery\Lifecell;

use Psr\Http\Message\ResponseInterface;
use Wearesho\Delivery;
use GuzzleHttp;

/**
 * Class Service
 * @package Wearesho\Delivery\Lifecell
 */
class Service implements Delivery\ServiceInterface
{
    protected const BASE_URI = 'https://api.omnicell.com.ua/ip2sms';

    /** @var GuzzleHttp\ClientInterface */
    protected $client;

    /** @var ConfigInterface */
    protected $config;

    public function __construct(ConfigInterface $config, GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param Delivery\MessageInterface $message
     *
     * @throws Delivery\Exception
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function send(Delivery\MessageInterface $message): void
    {
        if (!preg_match('/^(\+)?380\d{9}$/', $message->getRecipient())) {
            throw new Delivery\Exception("Unsupported recipient format");
        }
        $sender = $message instanceof Delivery\ContainsSenderName
            ? $message->getSenderName()
            : $this->config->getSenderName();
        $requestObject = [
            "id" => "single",
            "validity" => "+30 min", // qwe
            "extended" => true,
            "source" => $sender,
            "desc" => "sms", // qwe
            "type" => "SMS",
            "to" => [
                ["msisdn" => $message->getRecipient()]
            ],
            "body" => [
                "value" => $message->getText()
            ],
        ];

        $this->fetchBody(
            $this->client->send($this->formRequest($requestObject))
        );
    }


    protected function formRequest(array $body): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            static::BASE_URI,
            [
                GuzzleHttp\RequestOptions::HEADERS => [
                    'Authorization' => 'Basic ' . $this->config->getAuth(),
                    'Content-Type' => 'application/json',
                ],
                GuzzleHttp\RequestOptions::JSON => json_encode($body)
            ]
        );
    }

    /**
     * @param ResponseInterface $response
     * @return array|null
     * @throws Delivery\Exception
     */
    protected function fetchBody(ResponseInterface $response): ?array
    {
        $body = $response->getBody()->getContents();

        try {
            $json = json_decode($body, true, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw  new Delivery\Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
        if (is_null($json)) {
            throw new Delivery\Exception("Response contain invalid body: " . $body, Exception::ERR_FORMAT, null);
        }

        return $json;
    }
}

<?php

namespace Wearesho\Delivery\Lifecell\Tests;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class ServiceTest
 * @package Wearesho\Delivery\Lifecell\Tests
 * @coversDefaultClass \Wearesho\Delivery\Lifecell\Service
 */
class ServiceTest extends TestCase
{
    protected const ERR_UNKNOWN = 200;
    protected const ERR_FORMAT = 201;

    /** @var Delivery\Lifecell\Service */
    protected $service;

    /** @var Delivery\Lifecell\Config */
    protected $config;

    /** @var GuzzleHttp\Handler\MockHandler */
    protected $mock;

    /** @var array */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Delivery\Lifecell\Config();
        $this->config->auth = 'TestAuth';
        $this->config->sender = 'sender';

        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $this->container = [];
        $history = GuzzleHttp\Middleware::history($this->container);

        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->service = new Delivery\Lifecell\Service(
            $this->config,
            new GuzzleHttp\Client(
                [
                    'handler' => $stack,
                ]
            )
        );
    }

    public function testSendMessage(): void
    {
        $this->mock->append(
            new GuzzleHttp\Psr7\Response(
                200,
                [],
                json_encode([
                                "state" => [
                                    "value" => "Accepted"
                                ],
                                "id" => "6614012446421",
                                "date" => "Tue, 20 Nov 2018 08:55:46 +0200",
                                "execTime" => "40"
                            ])
            )
        );
        $message = new Delivery\Message('Some Text', '380000000000');
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->service->send($message);

        /** @var GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals(
            [
                "id" => "single",
                "validity" => "+30 min", // qwe
                "extended" => true,
                "source" => 'sender',
                "desc" => "sms", // qwe
                "type" => "SMS",
                "to" => [
                    ["msisdn" => '380000000000']
                ],
                "body" => [
                    "value" => 'Some Text'
                ],
            ],
            json_decode($request->getHeaders()['json'][0], true)
        );
    }


    public function testInvalidResponse(): void
    {
        $this->expectException(Delivery\Exception::class);
        $this->expectExceptionMessage(
            'Response contain invalid body: '
        );
        $this->expectExceptionCode(Delivery\Lifecell\Exception::ERR_FORMAT);

        $this->mock->append(
            $this->mockResponse('<invalid')
        );

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->service->send(new Delivery\Message('content', '380000000000'));
    }

    /**
     * @expectedException \Wearesho\Delivery\Exception
     * @expectedExceptionMessage Unsupported recipient format
     */
    public function testInvalidRecipient(): void
    {
        $message = new Delivery\Message("Text", "123");
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->service->send($message);
    }

//    protected function mockFailedResponse(int $code): GuzzleHttp\Psr7\Response
//    {
//        return $this->mockResponse("<error>$code</error>");
//    }

    protected function mockResponse(string $content): GuzzleHttp\Psr7\Response
    {
        return new GuzzleHttp\Psr7\Response(
            200,
            [],
            $content
        );
    }
}

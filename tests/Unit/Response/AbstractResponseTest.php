<?php

namespace Anticaptcha\Tests\Unit\Response;

use Anticaptcha\Response\AbstractResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AbstractResponseTest extends TestCase
{
    public function testErrorFields(): void
    {
        $httpResponse = new Response(
            200,
            [],
            '{"errorId": 1,"errorCode": "ERROR_KEY_DOES_NOT_EXIST","errorDescription": "Account authorization key not found in the system"}'
        );

        $response = TestResponse::fromHttpResponse($httpResponse);

        self::assertEquals(true, $response->hasError());
        self::assertEquals(1, $response->getErrorId());
        self::assertEquals('ERROR_KEY_DOES_NOT_EXIST', $response->getErrorCode());
        self::assertEquals('Account authorization key not found in the system', $response->getErrorDescription());

        self::assertNull($response->payload);
    }

    public function testCorrectPayload(): void
    {
        $httpResponse = new Response(
            200,
            [],
            '{"errorId": 0,"payload":"test"}'
        );

        $response = TestResponse::fromHttpResponse($httpResponse);

        self::assertEquals(false, $response->hasError());
        self::assertEquals(0, $response->getErrorId());
        self::assertEquals('', $response->getErrorCode());
        self::assertEquals('', $response->getErrorDescription());

        self::assertEquals('test', $response->payload);
    }
}

class TestResponse extends AbstractResponse
{
    public ?string $payload = null;
}
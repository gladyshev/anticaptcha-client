<?php

namespace Anticaptcha\Tests\Unit;

use Anticaptcha\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testSuccess(): void
    {
        $config = new Configuration(
            $clientKey = 'key',
            $apiUrl = 'https://api.anti-captcha.com',
            $languagePool = 'rn',
            $callbackUrl = 'https://example.com/callback'
        );

        self::assertEquals($clientKey, $config->getClientKey());
        self::assertEquals($apiUrl, $config->getApiUrl());
        self::assertEquals($languagePool, $config->getLanguagePool());
        self::assertEquals($callbackUrl, $config->getCallbackUrl());
        self::assertEquals(857, $config->getSoftId());
    }

    public function testClientKeyBuilder(): void
    {
        $config = Configuration::fromClientKey('key');

        self::assertEquals('key', $config->getClientKey());
        self::assertEquals(Configuration::DEFAULT_API_URL, $config->getApiUrl());
        self::assertNull($config->getLanguagePool());
        self::assertNull($config->getCallbackUrl());
        self::assertEquals(857, $config->getSoftId());
    }
}

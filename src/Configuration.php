<?php

namespace Anticaptcha;

final class Configuration implements ConfigurationInterface
{
    public const DEFAULT_API_URL = 'https://api.anti-captcha.com';
    public const DEFAULT_SOFT_ID = 857;  // ID of this library

    private string $apiKey;
    private string $apiUrl;
    private ?string $languagePool;
    private ?string $callbackUrl;
    private ?int $softId;

    public function __construct(
        string $clientKey,
        string $apiUrl = self::DEFAULT_API_URL,
        ?string $languagePool = null,
        ?string $callbackUrl = null,
        ?int $softId = self::DEFAULT_SOFT_ID
    ) {
        $this->apiKey = $clientKey;
        $this->apiUrl = $apiUrl;
        $this->languagePool = $languagePool;
        $this->callbackUrl = $callbackUrl;
        $this->softId = $softId;
    }

    public static function fromClientKey(string $clientKey): self
    {
        return new self($clientKey);
    }

    public function getClientKey(): string
    {
        return $this->apiKey;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getLanguagePool(): ?string
    {
        return $this->languagePool;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
    }

    public function getSoftId(): ?int
    {
        return $this->softId;
    }
}

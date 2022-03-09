<?php

namespace Anticaptcha;

final class Configuration implements ConfigurationInterface
{
    private string $apiKey;
    private string $apiUrl;
    private ?string $languagePool;
    private ?string $callbackUrl;

    public function __construct(
        string $clientKey,
        string $apiUrl = 'https://api.anti-captcha.com',
        ?string $languagePool = null,
        ?string $callbackUrl = null
    ) {
        $this->apiKey = $clientKey;
        $this->apiUrl = $apiUrl;
        $this->languagePool = $languagePool;
        $this->callbackUrl = $callbackUrl;
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

    public function getSoftId(): int
    {
        return 857;
    }
}

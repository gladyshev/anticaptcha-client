<?php

namespace Anticaptcha;

interface ConfigurationInterface
{
    public function getClientKey(): string;
    public function getApiUrl(): string;
    public function getSoftId(): ?int;
    public function getCallbackUrl(): ?string;
    public function getLanguagePool(): ?string;
}

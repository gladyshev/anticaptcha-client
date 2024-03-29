<?php

require __DIR__ . '/../vendor/autoload.php';

$configuration = new \Anticaptcha\Configuration(
    getenv('__ANTICAPTCHA_KEY__'),
    languagePool: \Anticaptcha\Enum\LanguagePool::RN,
);

$httpClient = new \GuzzleHttp\Client();

$client = new \Anticaptcha\Client(
    $configuration,
    $httpClient
);

$result = $client->resolveImage(__DIR__.'/data/yandex.gif');

var_dump(
    $result->getTaskId(),
    $result->solution
);

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

$createResult = $client->createTaskByImage(__DIR__ . '/data/yandex.gif');

$getTaskResult = $client->getTaskResult($createResult->getTaskId());
$getTaskResult->wait();

var_dump($getTaskResult->solution); // string(14) "замочка"

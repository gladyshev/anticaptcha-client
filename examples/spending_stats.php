<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(
    new \Anticaptcha\Configuration(getenv('__ANTICAPTCHA_KEY__')),
    new GuzzleHttp\Client()
);

$stats = $client->getSpendingStats();

var_dump($stats);

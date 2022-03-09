<?php

use Anticaptcha\Configuration;

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(
    new Configuration(getenv('__ANTICAPTCHA_KEY__')),
    new GuzzleHttp\Client()
);

$balanceResult = $client->getBalance();

var_dump($balanceResult);

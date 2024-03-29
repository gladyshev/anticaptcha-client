<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(
    new \Anticaptcha\Configuration(getenv('__ANTICAPTCHA_KEY__')),
    new GuzzleHttp\Client()
);

$stats = $client->getQueueStats(
    \Anticaptcha\Enum\QueueId::IMAGE_TO_TEXT_RL
);

var_dump($stats);

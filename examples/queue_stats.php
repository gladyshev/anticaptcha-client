<?php
/**
 * @project Anticaptcha library
 */

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(getenv('__ANTICAPTCHA_KEY__'));

$stats = $client->getQueueStats(\Anticaptcha\Entity\QueueStats::QUEUE_IMAGE_TO_TEXT_RU);

var_dump($stats);

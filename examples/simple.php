<?php
/**
 * @project Anticaptcha library
 */

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(getenv('__ANTICAPTCHA_KEY__'));

$taskId = $client->createTaskByImage(__DIR__.'/data/yandex.gif');
$result = $client->getTaskResult($taskId);
$result->await();

var_dump($result->getSolution()->getText()); // string(14) "замочка"

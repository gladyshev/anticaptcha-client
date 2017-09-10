<?php
/**
 * @project Anticaptcha library
 */

require __DIR__ . '/../vendor/autoload.php';

$client = new \Anticaptcha\Client(getenv('__ANTICAPTCHA_KEY__'));

$balance = $client->getBalance();

var_dump($balance);

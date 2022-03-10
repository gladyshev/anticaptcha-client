<?php

require __DIR__ . '/../vendor/autoload.php';

$configuration = \Anticaptcha\Configuration::fromClientKey(
    getenv('__ANTICAPTCHA_KEY__')
);

$httpClient = new \GuzzleHttp\Client();

$client = new \Anticaptcha\Client(
    $configuration,
    $httpClient
);

$task = new \Anticaptcha\Task\AntiGateTask([
    'websiteURL' => 'http://antigate.com/logintest.php',
    'templateName' => 'Sign-in and wait for control text',
    'variables' => [
        "login_input_css"       => "#login",
        "login_input_value"     => "the login",
        "password_input_css"    => "#password",
        "password_input_value"  => "test password",
        "control_text"          =>  "You have been logged successfully"
    ]
]);

$createTaskResponse = $client->createTask($task);

$getTaskResponse = $client->getTaskResult($createTaskResponse->getTaskId());
$getTaskResponse->wait(5, 600);

var_dump(
    $getTaskResponse->getTaskId(),
    $getTaskResponse->solution
);

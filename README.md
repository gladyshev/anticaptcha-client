anticaptcha-client
==================
Powerful and easy [anti-captcha.com](http://getcaptchasolution.com/djbj8qnktb) API wrapper.

[![Build Status](https://scrutinizer-ci.com/g/gladyshev/anticaptcha-client/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gladyshev/anticaptcha-client/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gladyshev/anticaptcha-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gladyshev/anticaptcha-client/?branch=master)

### Install 

```bash
$ composer require gladyshev/anticaptcha-client
```
or 
```php
"require": {
  ...
  "gladyshev/anticaptcha-client": "^2.0"
  ...
}
```

### Examples
More examples in [examples](/examples) folder.

```php
$configuration = new \Anticaptcha\Configuration(
    getenv('__ANTICAPTCHA_KEY__')
); 

// PSR-18 HTTP-client
$httpClient = new \GuzzleHttp\Client(); 

$client = new \Anticaptcha\Client(
    $configuration, 
    $httpClient
);

$result = $client->resolveImage(__DIR__.'/data/yandex.gif');

var_dump($result->solution);

/*
array(2) {
  ["text"]=>
  string(14) "замочка"
  ["url"]=>
  string(43) "http://69.39.235.18/510/164683106482493.gif"
}
*/
```

The library strictly follows the API documentation, so full features can be found by looking at the [official documentation](https://anti-captcha.com/apidoc) of the service.
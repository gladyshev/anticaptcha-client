<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

use Anticaptcha\Language\Language;

/**
 * Translation
 * @param $message
 * @param array $params
 * @return string
 */
function t($message, $params = [])
{
    $message = Language::translate($message, Client::$language);
    foreach ($params as $token => $replace) {
        $message = str_replace('{' . $token . '}', $replace, $message);
    }
    return $message;
}

/**
 * @param $code
 * @return mixed|string
 */
function getErrorMessageById($code)
{
    $messages = [
        0 => 'Unknown error.',
        1 => 'Account authorization key not found in the system',
        2 => 'No idle captcha workers are available at the moment, please try a bit later or try increasing your maximum bid here',
        3 => 'The size of the captcha you are uploading is less than 100 bytes.',
        4 => 'The size of the captcha you are uploading is more than 500,000 bytes.',
        10 => 'Account has zeo or negative balance',
        11 => 'Request with current account key is not allowed from your IP. Please refer to IP list section located here',
        12 => 'Captcha could not be solved by 5 different workers',
        13 => '100% recognition feature did not work due to lack of amount of guess attempts',
        14 => 'Request to API made with method which does not exist',
        15 => 'Could not determine captcha file type by its exif header or image type is not supported. The only allowed formats are JPG, GIF, PNG',
        16 => 'Captcha you are requesting does not exist in your current captchas list or has been expired. Captchas are removed from API after 5 minutes after upload.',
        20 => '"comment" property is required for this request',
        21 => 'Your IP is blocked due to API inproper use. Check the reason at https://anti-captcha.com/panel/tools/ipsearch',
        22 => 'Task property is empty or not set in createTask method. Please refer to API v2 documentation.',
        23 => 'Task type is not supported or inproperly printed. Please check "type" parameter in task object.',
        24 => 'Some of the required values for successive user emulation are missing.',
        25 => 'Could not connect to proxy related to the task, connection refused',
        26 => 'Could not connect to proxy related to the task, connection timeout',
        27 => 'Connection to proxy for task has timed out',
        28 => 'Proxy IP is banned by target service',
        29 => 'Task denied at proxy checking state. Proxy must be non-transparent to hide our server IP.',
        30 => 'Recaptcha task timeout, probably due to slow proxy server or Google server',
        31 => 'Recaptcha server reported that site key is invalid',
        32 => 'Recaptcha server reported that domain for this site key is invalid',
        33 => 'Recaptcha server reported that browser user-agent is not compatible with their javascript',
        34 => 'Recaptcha server reported that stoken parameter has expired. Make your application grab it faster.',
        35 => 'Proxy does not support transfer of image data from Google servers',
        36 => 'Proxy does not support long GET requests with length about 2000 bytes and does not support SSL connections',
        37 => 'Could not connect to Factory Server API within 5 seconds',
        38 => 'Incorrect Factory Server JSON response, something is broken',
        39 => 'Factory Server API did not send any errorId',
        40 => 'Factory Server API reported errorId != 0, check this error',
        41 => 'Some of the required property values are missing in Factory form specifications. Customer must send all required values.',
        42 => 'Expected other type of property value in Factory form structure. Customer must send specified value type.',
        43 => 'Factory control belong to another account, check your account key.',
        44 => 'Factory Server general error code',
        45 => 'Factory Platform general error code.',
        46 => 'Factory task lifetime protocol broken during task workflow.',
        47 => 'Task not found or not available for this operation',
    ];

    $code = intval($code);

    return isset($messages[$code]) ? $messages[$code] : $messages[0];
}

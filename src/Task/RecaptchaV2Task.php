<?php

namespace Anticaptcha\Task;

/**
 * @see https://anti-captcha.com/apidoc/task-types/RecaptchaV2Task
 */
class RecaptchaV2Task extends RecaptchaV2ProxylessTask
{
    use ProxyTrait;

    public function getType(): string
    {
        return 'RecaptchaV2Task';
    }
}

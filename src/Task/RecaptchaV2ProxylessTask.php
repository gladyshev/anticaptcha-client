<?php

namespace Anticaptcha\Task;

/**
 * @see https://anti-captcha.com/apidoc/task-types/RecaptchaV2TaskProxyless
 */
class RecaptchaV2ProxylessTask extends AbstractTask
{
    /*
     * Address of a target web page. Can be located anywhere on the web site, even in a member area. Our workers don't
     * navigate there but simulate the visit instead.
     */
    public string $websiteURL;

    /*
     * Recaptcha website key.
     */
    public string $websiteKey;

    /*
     * Value of 'data-s' parameter. Applies only to Recaptchas on Google web sites.
     */
    public ?string $recaptchaDataSValue = null;

    /*
     * Specify whether or not Recaptcha is invisible. This will render an appropriate widget for our workers.
     */
    public ?bool $isInvisible = null;

    public function getType(): string
    {
        return 'RecaptchaV2TaskProxyless';
    }
}

<?php

namespace Anticaptcha\Task;

class RecaptchaV3EnterpriseProxylessTask extends AbstractTask
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
     * Filters workers with a particular score. It can have one of the following values:
     * 0.3
     * 0.7
     * 0.9
     */
    public float $minScore;

    /*
     * Recaptcha's "action" value. Website owners use this parameter to define what users are doing on the page.
     * Example:
     * grecaptcha.execute('site_key', {action:'login_test'})
     */
    public ?string $pageAction = null;

    /*
     * Set this flag to "true" if you need this V3 solved with Enterprise API. Default value is "false" and Recaptcha
     * is solved with non-enterprise API. Can be determined by a javascript call like in the following example:
     * grecaptcha.enterprise.execute('site_key', {..})
     */
    public bool $isEnterprise = true;


    public function getType(): string
    {
        return 'RecaptchaV3TaskProxyless';
    }
}

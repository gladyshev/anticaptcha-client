<?php

namespace Anticaptcha\Task;

class RecaptchaV2EnterpriseProxylessTask extends AbstractTask
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
     * Additional parameters which should be passed to "grecaptcha.enterprise.render" method along with sitekey.
     * Example of what you should search for:
     *
     * grecaptcha.enterprise.render("some-div-id", {
     *     sitekey: "6Lc_aCMTAAAAABx7u2N0D1XnVbI_v6ZdbM6rYf16",
     *     theme: "dark",
     *     s: "2JvUXHNTnZl1Jb6WEvbDyBMzrMTR7oQ78QRhBcG07rk9bpaAaE0LRq1ZeP5NYa0N...ugQA"
     * });
     *
     * In this example, you will notice a parameter "s" which is not documented, but obviously required. Send it to
     * the API, so that we render the Recaptcha widget with this parameter properly.
     */
    public ?array $enterprisePayload = null;

    /*
     * Use this parameter to send the domain name from which the Recaptcha script should be served. Can have only one
     * of two values: "www.google.com" or "www.recaptcha.net". Do not use this parameter unless you understand what you
     * are doing.
     */
    public ?string $apiDomain = null;

    public function getType(): string
    {
        return 'RecaptchaV2EnterpriseTaskProxyless';
    }
}

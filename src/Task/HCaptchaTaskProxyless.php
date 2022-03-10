<?php

namespace Anticaptcha\Task;

class HCaptchaTaskProxyless extends AbstractTask
{
    /*
     * Address of a target web page. Can be located anywhere on the web site, even in a member area. Our workers don't
     * navigate there but simulate the visit instead.
     */
    public string $websiteURL;

    /*
     * hCaptcha sitekey
     */
    public string $websiteKey;
}

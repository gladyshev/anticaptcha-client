<?php

namespace Anticaptcha\Task;

class GeeTestTaskProxyless extends AbstractTask
{
    /*
     * Address of a target web page. Can be located anywhere on the web site, even in a member area. Our workers don't
     * navigate there but simulate the visit instead.
     */
    public string $websiteURL;

    /*
     * The domain public key, rarely updated.
     */
    public string $gt;

    /*
     * Changing token key. Make sure you grab a fresh one for each captcha; otherwise, you'll be charged for an error
     * task.
     */
    public string $challenge;

    /*
     * Optional API subdomain. May be required for some implementations.
     */
    public ?string $geetestApiServerSubdomain = null;

    /*
     * Required for some implementations. Send the JSON encoded into a string. The value can be traced in browser
     * developer tools. Put a breakpoint before calling the "initGeetest" function.
     */
    public ?string $geetestGetLib = null;
}

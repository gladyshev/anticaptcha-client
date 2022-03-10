<?php

namespace Anticaptcha\Task;

class AntiGateTask extends AbstractTask
{
    /*
     * Address of a target web page. Can be located anywhere on the web site, even in a member area. Our workers don't
     * navigate there but simulate the visit instead.
     */
    public string $websiteURL;

    /*
     * Name of a scenario template from our database. You can use an existing template or create your own. You may
     * search for an existing template below this table.
     */
    public string $templateName;

    /*
     * An object containing template's variables and their values.
     */
    public array $variables;

    /*
     * Proxy IP address ipv4/ipv6. No host names or IP addresses from local networks.
     */
    public ?string $proxyAddress = null;

    /*
     * Proxy port
     */
    public ?int $proxyPort = null;

    /*
     * Login for proxy which requires authorization (basic)
     */
    public ?string $proxyLogin = null;

    /*
     * Proxy password
     */
    public ?string $proxyPassword = null;
}

<?php

namespace Anticaptcha\Task;

trait ProxyTrait
{
    /*
     * Type of proxy:
     *   http - usual http/https proxy
     *   socks4 - socks4 proxy
     *   socks5 - socks5 proxy
     */
    public string $proxyType;

    /*
     * Proxy IP address ipv4/ipv6. No host names or IP addresses from local networks.
     */
    public string $proxyAddress;

    /*
     * Proxy port
     */
    public int $proxyPort;

    /*
     * Login for proxy which requires authorization (basic)
     */
    public ?string $proxyLogin = null;

    /*
     * Proxy password
     */
    public ?string $proxyPassword = null;

    /*
     * Browser's User-Agent used in emulation. You must use a modern-browser signature; otherwise, Google will ask you
     * to "update your browser".
     */
    public string $userAgent;

    /*
     * Additional cookies that we should use in Google domains.
     */
    public ?string $cookies = null;
}

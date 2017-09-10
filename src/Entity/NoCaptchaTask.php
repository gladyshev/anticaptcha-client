<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

use Anticaptcha\Exception\InvalidArgumentException;
use function Anticaptcha\t;

/**
 * Class NoCaptchaTask
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class NoCaptchaTask extends NoCaptchaTaskProxyless
{
    const PROXY_TYPE_HTTP = 'http';
    const PROXY_TYPE_SOCKS4 = 'socks4';
    const PROXY_TYPE_SOCKS5 = 'socks5';

    /**
     * Type of the proxy.
     *
     * http - usual http/https proxy
     * socks4 - socks4 proxy
     * socks5 - socks5 proxy
     *
     * @var string
     */
    protected $proxyType;

    /**
     * Proxy IP address ipv4/ipv6. Not allowed to use:
     * - host names instead of IPs
     * - transparent proxies (where client IP is visible)
     * - proxies from local networks (192.., 10.., 127...)
     *
     * @var string
     */
    protected $proxyAddress;

    /**
     * Proxy port.
     *
     * @var int
     */
    protected $proxyPort;

    /**
     * Login for proxy which requires authorizaiton (basic).
     * @var string
     */
    protected $proxyLogin = '';

    /**
     * Proxy password.
     *
     * @var string
     */
    protected $proxyPassword = '';

    /**
     * Browser's User-Agent which is used in emulation. It is required that you use a signature of a modern browser,
     * otherwise Google will ask you to "update your browser".
     *
     * @var string
     */
    protected $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36';

    /**
     * Additional cookies which we must use during interaction with target page or Google.
     * Format: cookiename1=cookievalue1; cookiename2=cookievalue2
     *
     * @var string
     */
    protected $cookies;

    /**
     * NoCaptchaTask constructor.
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        if (empty($options['proxyType'])) {
            throw new InvalidArgumentException(t('The \'proxyType\' field is required.'));
        }

        if (empty($options['proxyAddress'])) {
            throw new InvalidArgumentException(t('The \'proxyAddress\' field is required.'));
        }

        if (empty($options['proxyPort'])) {
            throw new InvalidArgumentException(t('The \'proxyPort\' field is required.'));
        }

        parent::__construct($options);
    }

    public function getType()
    {
        return 'NoCaptchaTask';
    }

    /**
     * @return string
     */
    public function getProxyType()
    {
        return $this->proxyType;
    }

    /**
     * @return string
     */
    public function getProxyAddress()
    {
        return $this->proxyAddress;
    }

    /**
     * @return int
     */
    public function getProxyPort()
    {
        return $this->proxyPort;
    }

    /**
     * @return string
     */
    public function getProxyLogin()
    {
        return $this->proxyLogin;
    }

    /**
     * @return string
     */
    public function getProxyPassword()
    {
        return $this->proxyPassword;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return string
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type' => $this->getType(),
            'websiteURL' => $this->getWebsiteURL(),
            'websiteKey' => $this->getWebsiteKey(),
            'websiteSToken' => $this->getWebsiteSToken(),
            'proxyType' => $this->getProxyType(),
            'proxyAddress' => $this->getProxyAddress(),
            'proxyPort' => $this->getProxyPort(),
            'proxyLogin' => $this->getProxyLogin(),
            'proxyPassword' => $this->getProxyPassword(),
            'userAgent' => $this->getUserAgent(),
            'cookies' => $this->getCookies()
        ];
    }
}

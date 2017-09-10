<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

/**
 * Class Credentials
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class Credentials implements CredentialsInterface
{
    /**
     * @var string
     */
    protected $clientKey = '';

    /**
     * Credentials constructor.
     *
     * @param $clientKey
     */
    public function __construct($clientKey)
    {
        $this->clientKey = $clientKey;
    }

    /**
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }
}

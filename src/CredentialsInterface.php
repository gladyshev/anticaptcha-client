<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

/**
 * Interface CredentialsInterface
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
interface CredentialsInterface
{
    /**
     * @return string
     */
    public function getClientKey();
}

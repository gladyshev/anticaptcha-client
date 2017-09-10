<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

/**
 * Class ServiceInterface
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
interface ServiceInterface
{
    /**
     * @param string$method
     * @param array $params
     * @return array
     */
    public function call($method, array $params);
}

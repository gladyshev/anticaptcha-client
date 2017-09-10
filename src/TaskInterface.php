<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

/**
 * Interface TaskInterface
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
interface TaskInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public function toArray();
}

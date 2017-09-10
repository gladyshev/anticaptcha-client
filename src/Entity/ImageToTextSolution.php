<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

/**
 * Class ImageToTextSolution
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class ImageToTextSolution extends Entity
{
    /**
     * Captcha answer.
     *
     * @var string
     */
    protected $text;

    /**
     * Web address where captcha file can be downloaded. Available withing 48 hours after task creation.
     *
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }
}

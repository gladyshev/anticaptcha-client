<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

/**
 * Class NoCaptchaSolution
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class NoCaptchaSolution extends Entity
{
    /**
     * Hash string which is required for interacting with submit form on target website. It looks like this:
     * <textarea id="g-recaptcha-response" ..></textarea>
     * @var string
     */
    protected $gRecaptchaResponse;

    /**
     * Control sum of gRecaptchaResponse value in MD5. It may present in API output only while sending isExtended
     * property with true value in getTaskResult method. This property is made for specially for debugging,
     * just to make sure your application receives exact google hash.
     *
     * @var string
     */
    protected $gRecaptchaResponseMD5;

    /**
     * @return string
     */
    public function getGRecaptchaResponse()
    {
        return $this->gRecaptchaResponse;
    }

    /**
     * @return string
     */
    public function getGRecaptchaResponseMD5()
    {
        return $this->gRecaptchaResponseMD5;
    }
}

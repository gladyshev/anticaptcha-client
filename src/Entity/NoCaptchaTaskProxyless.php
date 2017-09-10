<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

use Anticaptcha\Exception\InvalidArgumentException;
use Anticaptcha\TaskInterface;
use function Anticaptcha\t;


/**
 * Class NoCaptchaTaskProxyless
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class NoCaptchaTaskProxyless extends Entity implements TaskInterface
{
    /**
     * Address of target web page.
     *
     * @var string
     */
    protected $websiteURL;

    /**
     * Recaptcha website key
     * <div class="g-recaptcha" data-sitekey="THAT_ONE"></div>
     *
     * @var string
     */
    protected $websiteKey;

    /**
     * @var string
     */
    protected $websiteSToken = '';

    public function __construct(array $options = [])
    {
        if (empty($options['websiteURL'])) {
            throw new InvalidArgumentException(t('The \'websiteURL\' field is required.'));
        }

        if (empty($options['websiteKey'])) {
            throw new InvalidArgumentException(t('The \'websiteKey\' field is required.'));
        }

        parent::__construct($options);
    }

    /**
     * Defines type of the task.
     * @return string
     */
    public function getType()
    {
        return 'NoCaptchaTaskProxyless';
    }

    /**
     * @return string
     */
    public function getWebsiteURL()
    {
        return $this->websiteURL;
    }

    /**
     * @return string
     */
    public function getWebsiteKey()
    {
        return $this->websiteKey;
    }

    /**
     * @return string
     */
    public function getWebsiteSToken()
    {
        return $this->websiteSToken;
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
            'websiteSToken' => $this->getWebsiteSToken()
        ];
    }
}

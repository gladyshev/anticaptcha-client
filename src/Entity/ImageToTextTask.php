<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

use Anticaptcha\Exception\InvalidArgumentException;
use Anticaptcha\TaskInterface;
use function Anticaptcha\t;

/**
 * Class ImageToTextTask
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 * @see https://anticaptcha.atlassian.net/wiki/spaces/API/pages/5079091/ImageToTextTask+solve+usual+image+captcha
 */
class ImageToTextTask extends Entity implements TaskInterface
{
    /**
     * File body encoded in base64. Make sure to send it without line breaks.
     * @var string
     */
    protected $body;

    /**
     * false - no requirements
     * true - worker must enter an answer with at least one "space".
     * @var bool
     */
    protected $phrase = false;

    /**
     * false - no requirements
     * true - worker will see a special mark telling that answer must be entered with case sensitivity.
     * @var bool
     */
    protected $case = false;

    /**
     * 0 - no requirements
     * 1 - only number are allowed
     * 2 - any letters are allowed except numbers
     * @var int
     */
    protected $numeric = 0;

    /**
     * false - no requirements
     * true - worker will see a special mark telling that answer must be calculated
     * @var bool;
     */
    protected $math = false;

    /**
     * 0 - no requirements
     * >1 - defines minimum length of the answer
     *
     * @var int
     */
    protected $minLength = 0;

    /**
     * 0 - no requirements
     * >1 - defines maximum length of the answer
     * @var int
     */
    protected $maxLength = 0;

    /**
     * From image task builder.
     *
     * @param string $path      # Path po the image
     * @param array $options    # Recognition options
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromImage($path, array $options = [])
    {
        if (!is_readable($path)) {
            throw new InvalidArgumentException(t('Image is not found.'));
        }
        $options['body'] = base64_encode(file_get_contents($path));
        return new static($options);
    }
    /**
     * From Base64 task builder.
     *
     * @param string $string      # Base64 string
     * @param array $options      # Recognition options
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromBase64($string, array $options = [])
    {
        $options['body'] = $string;
        return new static($options);
    }

    /**
     * ImageToTextTask constructor.
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        if (empty($options['body'])) {
            throw new InvalidArgumentException(t('The \'body\' field is required.'));
        }
        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isPhrase()
    {
        return $this->phrase;
    }

    /**
     * @return bool
     */
    public function isCase()
    {
        return $this->case;
    }

    /**
     * @return int
     */
    public function getNumeric()
    {
        return $this->numeric;
    }

    /**
     * @return bool
     */
    public function isMath()
    {
        return $this->math;
    }

    /**
     * @return int
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'ImageToTextTask';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type' => $this->getType(),
            'body' => $this->getBody(),
            'phrase' => $this->isPhrase(),
            'case' => $this->isCase(),
            'numeric' => $this->getNumeric(),
            'math' => $this->isMath(),
            'minLength' => $this->getMinLength(),
            'maxLength' => $this->getMaxLength()
        ];
    }
}

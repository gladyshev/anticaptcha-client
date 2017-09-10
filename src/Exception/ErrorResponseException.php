<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Exception;

use Throwable;

/**
 * Class ErrorResponseException
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class ErrorResponseException extends Exception
{
    /**
     * @var string
     */
    protected $errorCode;

    /**
     * ErrorResponseException constructor.
     *
     * @param string $errorDescription
     * @param string $errorCode
     * @param int $errorId
     * @param Throwable|null $previous
     */
    public function __construct(
        $errorDescription = '',
        $errorId = 0,
        $errorCode = '',
        Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;
        parent::__construct($errorDescription, $errorId, $previous);
    }

    /**
     * @return int
     */
    public function getErrorId()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->message;
    }
}

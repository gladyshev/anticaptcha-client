<?php

namespace Anticaptcha\Response;

use Anticaptcha\Entity;
use Exception;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class Response
 */
abstract class AbstractResponse extends Entity
{
    /*
     * Error identifier.
     * 0 - no errors, operation completed successfully.
     * >1 - error identifier. Error code and short description transferred in errorCode and errorDescription properties.
     */
    public int $errorId = 0;

    /*
     * An error code, won't be included in the output if request produced no errors.
     */
    public string $errorCode = '';

    /*
     * Short description of the error
     */
    public string $errorDescription = '';

    /**
     * @param ResponseInterface $httpResponse
     *
     * @return $this
     *
     * @throws Exception
     */
    public static function fromHttpResponse(ResponseInterface $httpResponse): self
    {
        $properties = json_decode(
            $httpResponse->getBody()->__toString(),
            true,
            JSON_THROW_ON_ERROR
        );

        if (!is_array($properties)) {
            throw new RuntimeException(
                sprintf('Unexpected API response. Dump: %s', var_export($httpResponse, true))
            );
        }

        return new static($properties);
    }

    public function hasError(): bool
    {
        return $this->errorId > 0;
    }

    public function getErrorId(): int
    {
        return $this->errorId;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrorDescription(): string
    {
        return $this->errorDescription;
    }
}

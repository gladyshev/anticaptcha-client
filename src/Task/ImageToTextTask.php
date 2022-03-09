<?php

namespace Anticaptcha\Task;

use InvalidArgumentException;

/**
 * @see https://anti-captcha.com/apidoc/task-types/ImageToTextTask
 */
class ImageToTextTask extends AbstractTask
{
    /*
     * File body encoded in base64. Make sure to send it without line breaks.
     */
    public string $body;

    /*
     * false - no requirements
     * true - worker must enter an answer with at least one "space".
     */
    public bool $phrase = false;

    /*
     * false - no requirements
     * true - worker will see a special mark telling that answer must be entered with case sensitivity.
     */
    public bool $case = false;

    /*
     * 0 - no requirements
     * 1 - only number are allowed
     * 2 - any letters are allowed except numbers
     */
    public int $numeric = 0;

    /*
     * false - no requirements
     * true - worker will see a special mark telling that answer must be calculated;
     */
    public bool $math = false;

    /*
     * 0 - no requirements
     * >1 - defines minimum length of the answer
     */
    public int $minLength = 0;

    /*
     * 0 - no requirements
     * >1 - defines maximum length of the answer
     */
    public int $maxLength = 0;

    /**
     * From image task builder.
     *
     * @param string $path      # Path po the image
     * @param array $options    # Recognition options
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromImage(string $path, array $options = [])
    {
        if (!is_readable($path)) {
            throw new InvalidArgumentException(
                sprintf('Image "%s" is not found.', $path)
            );
        }

        $options['body'] = base64_encode(file_get_contents($path));

        return new static($options);
    }
    /**
     * From Base64 task builder.
     *
     * @param string $base64Content      # Base64 string
     * @param array $options      # Recognition options
     * @return static
     */
    public static function fromBase64(string $base64Content, array $options = []): self
    {
        $options['body'] = $base64Content;

        return new static($options);
    }

    public function getType(): string
    {
        return 'ImageToTextTask';
    }
}

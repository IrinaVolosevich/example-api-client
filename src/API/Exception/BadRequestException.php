<?php

namespace Ivolosevich\ExampleApiClient\API\Exception;

use Throwable;

/**
 * Class BadRequestException
 * @package Ivolosevich\ExampleApiClient\API\Exception
 */
class BadRequestException extends \Exception
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * BadRequestException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

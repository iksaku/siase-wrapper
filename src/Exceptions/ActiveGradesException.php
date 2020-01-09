<?php

namespace iksaku\SIASE\Exceptions;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class ActiveGradesException extends UnexpectedValueException
{
    /**
     * ActiveGradesException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            4,
            $previous
        );
    }
}

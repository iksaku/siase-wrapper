<?php

namespace iksaku\SIASE\Exceptions;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class LoginException extends UnexpectedValueException
{
    /**
     * LoginException constructor.
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            'Unable to login, please check your credentials',
            1,
            $previous
        );
    }
}

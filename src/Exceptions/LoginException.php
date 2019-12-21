<?php

namespace SIASE\Exceptions;

use Exception;
use Throwable;

class LoginException extends Exception
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

<?php

namespace SIASE\Exceptions;

use Exception;
use Throwable;

class AuthenticationException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Wrong Credentials', 1, $previous);
    }
}

<?php

namespace SIASE\Exceptions;

use Exception;
use Throwable;

class LoginException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Unable to login, check your credentials', 1, $previous);
    }
}
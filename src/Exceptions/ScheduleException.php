<?php

namespace SIASE\Exceptions;

use Exception;
use Throwable;

class ScheduleException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Unable to fetch Schedule', 2, $previous);
    }
}

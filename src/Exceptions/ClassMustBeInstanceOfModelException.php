<?php

namespace iksaku\SIASE\Exceptions;

use Throwable;
use UnexpectedValueException;

class ClassMustBeInstanceOfModelException extends UnexpectedValueException
{
    public function __construct(string $model, Throwable $previous = null)
    {
        parent::__construct(
            "Factory::create() requires instance of Model, {$model} class given.",
            10,
            $previous
        );
    }
}

<?php

namespace SIASE\Exceptions;

use Exception;
use SIASE\Models\Student;
use Throwable;

class KardexException extends Exception
{
    /**
     * KardexException constructor.
     * @param Student $student
     * @param Throwable|null $previous
     */
    public function __construct(Student $student, Throwable $previous = null)
    {
        parent::__construct(
            'Unable to fetch Kardex for Student \''.$student->getName().'\'',
            2,
            $previous
        );
    }
}

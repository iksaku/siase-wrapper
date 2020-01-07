<?php

namespace iksaku\SIASE\Exceptions;

use iksaku\SIASE\Models\Student;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class KardexException extends UnexpectedValueException
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

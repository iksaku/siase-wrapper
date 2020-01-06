<?php

namespace SIASE\Exceptions;

use SIASE\Models\Student;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class ActiveGradesException extends UnexpectedValueException
{
    /**
     * ActiveGradesException constructor.
     * @param Student $student
     * @param Throwable|null $previous
     */
    public function __construct(Student $student, Throwable $previous = null)
    {
        parent::__construct(
            'Unable to fetch Active Grades for Student \''.$student->getName().'\'',
            4,
            $previous
        );
    }
}

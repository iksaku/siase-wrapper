<?php

namespace SIASE\Exceptions;

use SIASE\Models\Student;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class ScheduleException extends UnexpectedValueException
{
    /**
     * ScheduleException constructor.
     * @param Student $student
     * @param Throwable|null $previous
     */
    public function __construct(Student $student, Throwable $previous = null)
    {
        parent::__construct(
            'Unable to fetch Schedule for Student \''.$student->getName().'\'',
            3,
            $previous
        );
    }
}

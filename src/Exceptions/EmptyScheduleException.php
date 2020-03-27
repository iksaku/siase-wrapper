<?php

namespace iksaku\SIASE\Exceptions;

use iksaku\SIASE\Models\Student;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Throwable;

class EmptyScheduleException extends UnexpectedValueException
{
    /**
     * ScheduleException constructor.
     * @param Student $student
     * @param Throwable|null $previous
     */
    public function __construct(Student $student, Throwable $previous = null)
    {
        parent::__construct(
            'Schedule is empty for Student \''.$student->getName().'\'',
            3,
            $previous
        );
    }
}

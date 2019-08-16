<?php

namespace SIASE\Exceptions;

use Exception;
use SIASE\Student;
use Throwable;

class ScheduleException extends Exception
{
    /**
     * ScheduleException constructor.
     * @param Student $student
     * @param Throwable|null $previous
     */
    public function __construct(Student $student, Throwable $previous = null)
    {
        parent::__construct(
            'Unable to fetch Schedule for Student \''.$student->name.'\'',
            2,
            $previous
        );
    }
}

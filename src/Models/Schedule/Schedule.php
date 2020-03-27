<?php

namespace iksaku\SIASE\Models\Schedule;

use iksaku\SIASE\Encoders\ScheduleEncoder;
use iksaku\SIASE\Models\Model;

/**
 * Class Schedule.
 */
class Schedule extends Model
{
    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new ScheduleEncoder(),
        ], parent::getEncoders());
    }

    /**
     * Represents the Period on which the schedule will be running.
     * @var string
     */
    protected $period;

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * @param string $period
     */
    public function setPeriod(string $period)
    {
        $this->period = $period;
    }

    /**
     * Contains a list of Courses to attend in the running Period.
     * @var Course[]
     */
    protected $courses = [];

    /**
     * @return Course[]
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    /**
     * @param Course[] $courses
     */
    public function setCourses(array $courses)
    {
        sort($courses, SORT_REGULAR);
        $this->courses = $courses;
    }
}

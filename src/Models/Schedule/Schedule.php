<?php

namespace SIASE\Models\Schedule;

use SIASE\Models\Model;
use SimpleXMLElement;

class Schedule extends Model
{
    /**
     * Represents the Period on which the schedule will be running.
     *
     * @var string
     */
    public $period;

    /**
     * Contains a list of Courses to attend in the running period.
     *
     * @var Course[]
     */
    public $courses;

    /**
     * Schedule constructor.
     *
     * @param string $period
     * @param Course[] $courses
     */
    public function __construct(string $period, array $courses)
    {
        $this->period = $period;
        $this->courses = $courses;
    }

    /**
     * @param SimpleXMLElement $data
     * @return Schedule
     */
    public static function fromData(SimpleXMLElement $data)
    {
        /** @var Course[] $courses */
        $courses = [];

        // Create a new Course Object for every course data row
        foreach ($data->ttHorario->ttHorarioRow as $courseData) {
            /* @var SimpleXMLElement $courseData */
            $courses[] = Course::fromData($courseData);
        }

        // Build Schedule object
        return new self(
            (string) $data->pchPeriodo,
            $courses
        );
    }
}

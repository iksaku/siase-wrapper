<?php

namespace SIASE\Models\Schedule;

use SIASE\Encoders\ScheduleEncoder;
use SIASE\Models\Model;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class Schedule.
 */
class Schedule extends Model
{
    /**
     * Contains a list of Courses to attend in the running Period.
     * @var Course[]
     */
    protected $courses;

    /**
     * Represents the Period on which the schedule will be running.
     * @var string
     */
    protected $period;

    /**
     * Schedule constructor.
     * @param Course[] $courses
     * @param string $period
     */
    public function __construct(array $courses, string $period)
    {
        $this->period = $period;
        $this->courses = $courses;
    }

    /**
     * @return array
     */
    protected static function getNormalizers(): array
    {
        return [
            new ObjectNormalizer(
                null,
                null,
                null,
                new PhpDocExtractor()
            ),
            new ArrayDenormalizer(),
        ];
    }

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

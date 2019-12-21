<?php

namespace SIASE\Models\Schedule;

use Psr\Http\Message\ResponseInterface;
use SIASE\Encoders\ScheduleEncoder;
use SIASE\Exceptions\ScheduleException;
use SIASE\Models\Model;
use SIASE\Models\Student;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Schedule.
 */
class Schedule extends Model
{
    /**
     * Represents the Period on which the schedule will be running.
     * @var string
     */
    protected $period;

    /**
     * Contains a list of Courses to attend in the running Period.
     * @var Course[]
     */
    protected $courses;

    /**
     * Schedule constructor.
     * @param string $period
     * @param Course[] $courses
     */
    public function __construct(string $period, array $courses)
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
            /*new ScheduleNormalizer(),*/
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
     * @param Student $student
     * @return Schedule
     * @throws ScheduleException
     * @throws ExceptionInterface
     */
    public static function fetchFor(Student $student): self
    {
        /** @var ResponseInterface $response */
        $response = Request::make([
            'query' => [
                RequestArgument::STUDENT_ID => $student->getId(),
                RequestArgument::STUDENT_CAREER_CVE => $student->getCurrentCareer()->getCve(),
                RequestArgument::REQUEST_TYPE => RequestType::SCHEDULE,
            ],
        ]);

        /** @var Serializer $serializer */
        $serializer = static::serializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (isset($data['error']) && $data['error']) {
            throw new ScheduleException($student);
        }

        /** @var Schedule $schedule */
        $schedule = $serializer->denormalize($data, static::class/*, null, [
            AbstractNormalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [
                static::class => [
                    'period' => '',
                    'courses' => [],
                ],
            ],
        ]*/);

        return $schedule;
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

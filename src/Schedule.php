<?php

namespace SIASE;

use Psr\Http\Message\ResponseInterface;
use SIASE\Exceptions\ScheduleException;
use SIASE\Normalizers\ScheduleNormalizer;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
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
    public function __construct(string $period = '', array $courses = [])
    {
        $this->period = $period;
        $this->courses = $courses;
    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer([
            new ObjectNormalizer(null, new ScheduleNormalizer()),
        ], [
            new XmlEncoder(),
            new JsonEncoder(),
        ]);
    }

    /**
     * @param Student $student
     * @return Schedule
     * @throws ScheduleException
     * @throws ExceptionInterface
     */
    public static function requestFor(Student $student): self
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
        $serializer = self::getSerializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (filter_var($data['plgError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new ScheduleException($student);
        }

        /** @var Serializer $courseSerializer */
        $courseSerializer = Course::getSerializer();
        /** @var Course[] $courses */
        $courses = [];
        $coursesData = $data['ttHorario']['ttHorarioRow'];

        // If only 1 career listed...
        if (isset($coursesData['Id'])) {
            $coursesData = [$coursesData];
        }
        foreach ($coursesData as $course) {
            if (isset($courses[$course['Id']])) {
                $courses[$course['Id']]->addDays((int) $course['Dia']);
                $courses[$course['Id']]->adjustStartsAt($course['HoraInicio']);
                $courses[$course['Id']]->adjustEndsAt($course['HoraFin']);
            } else {
                if (!is_array($course['Dia'])) {
                    $course['Dia'] = [(int) $course['Dia']];
                }
                $courses[$course['Id']] = $courseSerializer->denormalize($course, Course::class);
            }
        }

        /** @var Schedule $schedule */
        $schedule = $serializer->denormalize($data, self::class);
        $schedule->setCourses(array_values($courses));

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
     * @param Course[] ...$courses
     */
    public function addCourses(...$courses)
    {
        $this->setCourses(array_unique(array_merge($this->courses, $courses), SORT_REGULAR));
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

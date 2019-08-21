<?php

namespace SIASE;

use Psr\Http\Message\ResponseInterface;
use SIASE\Exceptions\LoginException;
use SIASE\Normalizers\StudentNormalizer;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Throwable;

/**
 * Class Student.
 */
class Student extends Model
{
    const LOGIN_STUDENT_ID_ARGUMENT = '108be0d';

    const LOGIN_STUDENT_PASSWORD_ARGUMENT = 'd937aa6b';

    const LOGIN_TYPE_ARGUMENT = '0c19de58';

    const LOGIN_TYPE_STUDENT = '01';

    const /* @noinspection PhpUnused */
        LOGIN_TYPE_TEACHER = '02';

    /**
     * Id of the Student (Also known as 'Matricula').
     * @var int
     */
    protected $id;

    /**
     * Name of the Student.
     * @var string
     */
    protected $name;

    /**
     * Login token of the Student.
     * @var string
     */
    protected $trim;

    /**
     * Careers to which the Student has belonged to.
     * @var Career[]
     */
    protected $careers;

    /**
     * Return the Career to which student currently belongs.
     * @var Career
     */
    protected $current_career;

    /**
     * Currently active schedule of student.
     * @var Schedule
     */
    protected $schedule;

    /**
     * Student constructor.
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     */
    public function __construct(int $id, string $name, string $trim, array $careers)
    {
        $this->id = $id;
        $this->name = $name;
        $this->trim = $trim;
        $this->careers = $careers;
    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer([
            new ObjectNormalizer(null, new StudentNormalizer()),
        ], [
            new XmlEncoder(),
            new JsonEncoder(),
        ]);
    }

    /**
     * @param int $id
     * @param string $password
     * @return Student
     * @throws LoginException
     * @throws ExceptionInterface
     */
    public static function login(int $id, string $password): self
    {
        /** @var ResponseInterface $response */
        $response = Request::make([
            'query' => [
                self::LOGIN_STUDENT_ID_ARGUMENT => $id,
                self::LOGIN_STUDENT_PASSWORD_ARGUMENT => $password,
                self::LOGIN_TYPE_ARGUMENT => self::LOGIN_TYPE_STUDENT,
                RequestArgument::REQUEST_TYPE => RequestType::LOGIN,
            ],
        ]);

        /** @var Serializer $serializer */
        $serializer = self::getSerializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (filter_var($data['ttError']['ttErrorRow']['lError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new LoginException();
        }

        /** @var Serializer $careerSerializer */
        $careerSerializer = Career::getSerializer();
        /** @var Career[] $careers */
        $careers = [];
        $careersData = $data['ttCarrera']['ttCarreraRow'];

        // If only 1 career listed...
        if (isset($careersData['DesCarrera'])) {
            $careersData = [$careersData];
        }
        foreach ($careersData as $career) {
            $careers[] = $careerSerializer->denormalize($career, Career::class, null, [
                'default_constructor_arguments' => [
                    Career::class => [
                        'name' => '',
                        'short_name' => '',
                        'cve' => '',
                    ],
                ],
            ]);
        }

        /** @var Student $student */
        $student = $serializer->denormalize($data, self::class, null, [
            'default_constructor_arguments' => [
                self::class => [
                    'id' => 0,
                    'name' => '',
                    'trim' => '',
                    'careers' => [],
                ],
            ],
        ]);
        $student->setCareers($careers);

        return $student;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTrim(): string
    {
        return $this->trim;
    }

    /**
     * @param string $trim
     */
    public function setTrim(string $trim)
    {
        $this->trim = $trim;
    }

    /**
     * @return Career[]
     */
    public function getCareers(): array
    {
        return $this->careers;
    }

    /**
     * @param Career[] $careers
     */
    public function setCareers(array $careers)
    {
        $this->careers = $careers;
        $this->setCurrentCareer();
    }

    /**
     * @return Career|null
     */
    public function getCurrentCareer()
    {
        if (empty($this->current_career)) {
            $this->setCurrentCareer();
        }

        return $this->current_career;
    }

    /**
     * @param Career $current_career
     */
    public function setCurrentCareer(Career $current_career = null)
    {
        if (empty($current_career) && !empty($this->getCareers())) {
            $current_career = $this->getCareers()[count($this->careers) - 1];
        }

        $this->current_career = $current_career;
    }

    /**
     * @param bool $fetch
     * If set to False, we'll not try to fetch the current
     * Schedule even if there's no schedule currently available
     * @return Schedule|null
     */
    public function getSchedule(bool $fetch = true)
    {
        if (empty($this->schedule) && $fetch) {
            try {
                $this->setSchedule(Schedule::requestFor($this));
            } catch (Throwable $e) {
                trigger_error($e->getMessage());
            }
        }

        return $this->schedule;
    }

    /**
     * @param Schedule $schedule
     */
    public function setSchedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }
}

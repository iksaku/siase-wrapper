<?php

namespace SIASE\Models;

use GuzzleHttp\Promise\Promise;
use function GuzzleHttp\Promise\settle;
use Psr\Http\Message\ResponseInterface;
use SIASE\Api\RequestArgument;
use SIASE\Api\RequestType;
use SIASE\Encoders\StudentEncoder;
use SIASE\Exceptions\LoginException;
use SIASE\Models\ActiveGrades\ActiveGrades;
use SIASE\Models\Kardex\Kardex;
use SIASE\Models\Schedule\Schedule;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class Student.
 */
class Student extends Model
{
    /**
     * Student constructor.
     * @param int $id
     * @param string $name
     * @param string $token
     * @param Career[] $careers
     * @param Career|null $currentCareer
     */
    public function __construct(int $id, string $name, string $token, array $careers = [], Career $currentCareer = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->token = $token;
        $this->careers = $careers;
        $this->currentCareer = $currentCareer;
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
            new StudentEncoder(),
        ], parent::getEncoders());
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
        $response = client()->get('', [
            'query' => [
                RequestArgument::REQUEST_TYPE => RequestType::LOGIN,
                RequestArgument::LOGIN_TYPE => RequestArgument::LOGIN_TYPE_STUDENT,
                RequestArgument::LOGIN_ID => $id,
                RequestArgument::LOGIN_PASSWORD => $password,
            ],
        ]);

        /** @var Student $student */
        $student = static::getSerializer()->deserialize(
            $response->getBody()->getContents(),
            static::class,
            'xml'
        );

        return $student;
    }

    /**
     * @param string|string[] $data
     * @return $this
     */
    public function load($data): self
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        $promises = [];

        foreach ($data as $d) {
            $method = 'request'.ucfirst($d);
            if (method_exists($this, $method)) {
                $promises[] = $this->$method();
            }
        }

        settle($promises)->wait(false);

        return $this;
    }

    /**
     * Id of the Student (Also known as 'Matricula').
     * @var int
     */
    protected $id;

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
     * Name of the Student.
     * @var string
     */
    protected $name;

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
     * Login token of the Student.
     * @var string
     */
    protected $token;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * Careers to which the Student has belonged to.
     * @var Career[]
     */
    protected $careers;

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
        $this->setCurrentCareer(array_last($careers));
    }

    /**
     * Career to which Student currently belongs.
     * @var Career
     */
    protected $currentCareer;

    /**
     * @return Career|null
     */
    public function getCurrentCareer()
    {
        return $this->currentCareer;
    }

    /**
     * @param Career $currentCareer
     */
    public function setCurrentCareer(Career $currentCareer)
    {
        $this->currentCareer = $currentCareer;
    }

    /**
     * Active Grades of Student.
     * @var ActiveGrades
     */
    protected $activeGrades;

    /**
     * @return Promise
     */
    protected function requestActiveGrades(): Promise
    {
        /** @var Promise $promise */
        $promise = new Promise(function () use (&$promise) {
            if ($this->getActiveGrades() !== null) {
                $promise->resolve($this->getActiveGrades());

                return;
            }

            client()->getAsync('', [
                'query' => [
                    RequestArgument::REQUEST_TYPE => RequestType::ACTIVE_GRADES,
                    RequestArgument::STUDENT_ID => $this->getId(),
                    RequestArgument::STUDENT_CAREER_CVE => $this->getCurrentCareer()->getCve(),
                ],
            ])
                ->then(function (ResponseInterface $response) use ($promise) {
                    /** @var ActiveGrades $activeGrades */
                    $activeGrades = ActiveGrades::getSerializer()->deserialize(
                        $response->getBody()->getContents(),
                        ActiveGrades::class,
                        'xml',
                        ['student' => $this]
                    );

                    $this->setActiveGrades($activeGrades);

                    $promise->resolve($activeGrades);
                })->wait();
        });

        return $promise;
    }

    /**
     * @return ActiveGrades|null
     */
    public function getActiveGrades()
    {
        return $this->activeGrades;
    }

    /**
     * @param ActiveGrades $activeGrades
     */
    public function setActiveGrades(ActiveGrades $activeGrades): void
    {
        $this->activeGrades = $activeGrades;
    }

    /**
     * Kardex of Student.
     * @var Kardex
     */
    protected $kardex;

    /**
     * @return Promise
     */
    protected function requestKardex(): Promise
    {
        /** @var Promise $promise */
        $promise = new Promise(function () use (&$promise) {
            if ($this->getKardex() !== null) {
                $promise->resolve($this->getKardex());

                return;
            }

            client()->getAsync('', [
                'query' => [
                    RequestArgument::REQUEST_TYPE => RequestType::KARDEX,
                    RequestArgument::STUDENT_ID => $this->getId(),
                    RequestArgument::STUDENT_CAREER_CVE => $this->getCurrentCareer()->getCve(),
                ],
            ])
                ->then(function (ResponseInterface $response) use ($promise) {
                    /** @var Kardex $kardex */
                    $kardex = Kardex::getSerializer()->deserialize(
                        $response->getBody()->getContents(),
                        Kardex::class,
                        'xml',
                        ['student' => $this]
                    );

                    $this->setKardex($kardex);

                    $promise->resolve($kardex);
                })
                ->wait();
        });

        return $promise;
    }

    /**
     * @return Kardex|null
     */
    public function getKardex()
    {
        return $this->kardex;
    }

    /**
     * @param Kardex $kardex
     */
    public function setKardex(Kardex $kardex)
    {
        $this->kardex = $kardex;
    }

    /**
     * Currently active schedule of Student.
     * @var Schedule
     */
    protected $schedule;

    /**
     * @return Promise
     */
    protected function requestSchedule(): Promise
    {
        /** @var Promise $promise */
        $promise = new Promise(function () use (&$promise) {
            if ($this->getSchedule() !== null) {
                $promise->resolve($this->getSchedule());

                return;
            }

            $promise = client()->getAsync('', [
                'query' => [
                    RequestArgument::REQUEST_TYPE => RequestType::SCHEDULE,
                    RequestArgument::STUDENT_ID => $this->getId(),
                    RequestArgument::STUDENT_CAREER_CVE => $this->getCurrentCareer()->getCve(),
                ],
            ])
                ->then(function (ResponseInterface $response) use ($promise) {
                    /** @var Schedule $schedule */
                    $schedule = Schedule::getSerializer()->deserialize(
                        $response->getBody()->getContents(),
                        Schedule::class,
                        'xml',
                        ['student' => $this]
                    );

                    $this->setSchedule($schedule);

                    $promise->resolve($schedule);
                })
                ->wait();
        });

        return $promise;
    }

    /**
     * @return Schedule|null
     */
    public function getSchedule()
    {
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

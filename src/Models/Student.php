<?php

namespace SIASE\Models;

use Psr\Http\Message\ResponseInterface;
use SIASE\Encoders\StudentEncoder;
use SIASE\Exceptions\LoginException;
use SIASE\Models\Kardex\Kardex;
use SIASE\Models\Schedule\Schedule;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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
     * Return the Career to which Student currently belongs.
     * @var Career
     */
    protected $currentCareer;

    /**
     * Kardex of Student.
     * @var Kardex
     */
    protected $kardex;

    /**
     * Currently active schedule of Student.
     * @var Schedule
     */
    protected $schedule;

    /**
     * Student constructor.
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Career|null $currentCareer
     */
    public function __construct(int $id, string $name, string $trim, array $careers = [], Career $currentCareer = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->trim = $trim;
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
        $response = Request::make([
            'query' => [
                self::LOGIN_STUDENT_ID_ARGUMENT => $id,
                self::LOGIN_STUDENT_PASSWORD_ARGUMENT => $password,
                self::LOGIN_TYPE_ARGUMENT => self::LOGIN_TYPE_STUDENT,
                RequestArgument::REQUEST_TYPE => RequestType::LOGIN,
            ],
        ]);

        /** @var Serializer $serializer */
        $serializer = static::serializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (isset($data['error']) && $data['error']) {
            throw new LoginException();
        }

        /** @var Student $student */
        $student = $serializer->denormalize($data, static::class);

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
        if (empty($this->currentCareer)) {
            $this->setCurrentCareer();
        }

        return $this->currentCareer;
    }

    /**
     * @param Career $currentCareer
     */
    public function setCurrentCareer(Career $currentCareer = null)
    {
        if (empty($currentCareer) && !empty($this->getCareers())) {
            $currentCareer = $this->getCareers()[count($this->careers) - 1];
        }

        $this->currentCareer = $currentCareer;
    }

    /**
     * @param bool $fetch
     * If set to False, we'll not try to fetch the current
     * Kardex even if there's no kardex currently available
     * @return Kardex
     */
    public function getKardex(bool $fetch = true)
    {
        if (empty($this->kardex) && $fetch) {
            try {
                $this->setKardex(Kardex::fetchFor($this));
            } catch (Throwable $e) {
                trigger_error($e->getMessage());
            }
        }

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
     * @param bool $fetch
     * If set to False, we'll not try to fetch the current
     * Schedule even if there's no schedule currently available
     * @return Schedule|null
     */
    public function getSchedule(bool $fetch = true)
    {
        if (empty($this->schedule) && $fetch) {
            try {
                $this->setSchedule(Schedule::fetchFor($this));
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

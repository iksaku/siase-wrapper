<?php

namespace SIASE\Schedule;

use BadMethodCallException;
use SIASE\Model;
use SIASE\Normalizers\CourseNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Course.
 *
 * @method shouldAttendOnSunday
 * @method shouldAttendOnMonday
 * @method shouldAttendOnTuesday
 * @method shouldAttendOnWednesday
 * @method shouldAttendOnThursday
 * @method shouldAttendOnFriday
 * @method shouldAttendOnSaturday
 */
class Course extends Model
{
    /**
     * Id of the Course.
     * @var int
     */
    protected $id;

    /**
     * Name of the Course.
     * @var string
     */
    protected $name;

    /**
     * Abbreviation of Course's name.
     * @var string
     */
    protected $short_name;

    /**
     * Days on which the class is held.
     * @var int[]
     */
    protected $days;

    /**
     * Hour at which class starts (24h format).
     * @var string
     */
    protected $starts_at;

    /**
     * Hour at which class ends (24h format).
     * @var string
     */
    protected $ends_at;

    /**
     * Group number to which the Student belongs.
     * @var int
     */
    protected $group;

    /**
     * Room at which class is held.
     * @var string
     */
    protected $room;

    /**
     * Course constructor.
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param int|int[] $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     */
    public function __construct(int $id, string $name, string $short_name, $days, string $starts_at, string $ends_at, int $group, string $room)
    {
        $this->id = $id;
        $this->name = $name;
        $this->short_name = $short_name;
        $this->starts_at = $starts_at;
        $this->ends_at = $ends_at;
        $this->group = $group;
        $this->room = $room;

        if (!is_array($days)) {
            $days = [$days];
        }
        $this->days = $days;
    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer([
            new ObjectNormalizer(null, new CourseNormalizer()),
        ], [
            new XmlEncoder(),
            new JsonEncoder(),
        ]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/^shouldAttendOn(Sunday|Monday|Tuesday|Wednesday|Thursday|Friday|Saturday)$/', $name, $matches)) {
            $day = strtoupper($matches[1]);

            return in_array(constant('Carbon\Carbon::'.$day), $this->days);
        }

        $trace = debug_backtrace();

        throw new BadMethodCallException('Undefined method \''.$name.'\' in '.$trace[0]['file'].' in line '.$trace[0]['line']);
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
    public function getShortName(): string
    {
        return $this->short_name;
    }

    /**
     * @param string $short_name
     */
    public function setShortName(string $short_name)
    {
        $this->short_name = $short_name;
    }

    /**
     * @return int[]
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @param int[] ...$days
     */
    public function addDays(...$days)
    {
        $this->setDays(array_unique(array_merge($this->days, $days), SORT_NUMERIC));
    }

    /**
     * @param int[] $days
     */
    public function setDays(array $days)
    {
        sort($days, SORT_NUMERIC);
        $this->days = $days;
    }

    /**
     * @return string
     */
    public function getStartsAt(): string
    {
        return $this->starts_at;
    }

    /**
     * @param string $starts_at
     */
    public function adjustStartsAt(string $starts_at)
    {
        $this->starts_at = min($this->starts_at, $starts_at);
    }

    /**
     * @param string $starts_at
     */
    public function setStartsAt(string $starts_at)
    {
        $this->starts_at = $starts_at;
    }

    /**
     * @param string $ends_at
     */
    public function adjustEndsAt(string $ends_at)
    {
        $this->ends_at = max($this->ends_at, $ends_at);
    }

    /**
     * @return string
     */
    public function getEndsAt(): string
    {
        return $this->ends_at;
    }

    /**
     * @param string $ends_at
     */
    public function setEndsAt(string $ends_at)
    {
        $this->ends_at = $ends_at;
    }

    /**
     * @return int
     */
    public function getGroup(): int
    {
        return $this->group;
    }

    /**
     * @param int $group
     */
    public function setGroup(int $group)
    {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom(string $room)
    {
        $this->room = $room;
    }
}

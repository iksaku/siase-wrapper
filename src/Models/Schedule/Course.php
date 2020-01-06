<?php

namespace SIASE\Models\Schedule;

use BadMethodCallException;
use SIASE\Models\Model;

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
    protected $shortName;

    /**
     * Days on which the class is held.
     * @var int[]
     */
    protected $days;

    /**
     * Hour at which class starts (24h format).
     * @var string
     */
    protected $startsAt;

    /**
     * Hour at which class ends (24h format).
     * @var string
     */
    protected $endsAt;

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
     * @param string $shortName
     * @param int[] $days
     * @param string $startsAt
     * @param string $endsAt
     * @param int $group
     * @param string $room
     */
    public function __construct(int $id, string $name, string $shortName, array $days, string $startsAt, string $endsAt, int $group, string $room)
    {
        $this->id = $id;
        $this->name = $name;
        $this->shortName = $shortName;
        $this->days = $days;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->group = $group;
        $this->room = $room;
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
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return int[]
     */
    public function getDays(): array
    {
        return $this->days;
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
        return $this->startsAt;
    }

    /**
     * @param string $startsAt
     */
    public function setStartsAt(string $startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return string
     */
    public function getEndsAt(): string
    {
        return $this->endsAt;
    }

    /**
     * @param string $endsAt
     */
    public function setEndsAt(string $endsAt)
    {
        $this->endsAt = $endsAt;
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
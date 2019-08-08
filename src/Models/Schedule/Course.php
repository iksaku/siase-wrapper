<?php

namespace SIASE\Models\Schedule;

use SIASE\Models\Model;
use SimpleXMLElement;

class Course extends Model
{
    /**
     * Contains the representative Id to the Schedule.
     *
     * @var int
     */
    public $id;

    /**
     * Name of the Course.
     *
     * @var string
     */
    public $name;

    /**
     * Short name (abbreviation) of the Course.
     *
     * @var string
     */
    public $short_name;

    /**
     * Days of the week when you should attend the Course.
     *
     * @var string
     */
    public $day;

    /**
     * Course start hour.
     *
     * @var string
     */
    public $starts_at;

    /**
     * Course end hour.
     *
     * @var string
     */
    public $ends_at;

    /**
     * Course group number.
     *
     * @var int
     */
    public $group;

    /**
     * Room in which the Course is held.
     *
     * @var int
     */
    public $room;

    /**
     * Course constructor.
     *
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param string $day
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param int $room
     */
    public function __construct(int $id, string $name, string $short_name, string $day, string $starts_at, string $ends_at, int $group, int $room)
    {
        $this->id = $id;
        $this->name = $name;
        $this->short_name = $short_name;
        $this->day = $day;
        $this->starts_at = $starts_at;
        $this->ends_at = $ends_at;
        $this->group = $group;
        $this->room = $room;
    }

    /**
     * @param SimpleXMLElement $data
     * @return Course
     */
    public static function fromData(SimpleXMLElement $data)
    {
        // Build Course object
        return new self(
            (int) $data->Id,
            (string) $data->DescLMateria,
            (string) $data->DescCMateria,
            (string) $data->Dia,
            (string) $data->HoraInicio,
            (string) $data->HoraFin,
            (int) $data->Grupo,
            (int) $data->Salon
        );
    }
}

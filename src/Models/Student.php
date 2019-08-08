<?php

namespace SIASE\Models;

use SimpleXMLElement;

class Student extends Model
{
    /**
     * Represents the Id of the Student (Internally known as 'Matricula').
     *
     * @var int
     */
    public $id;

    /**
     * Contains the name of the Student.
     *
     * @var string
     */
    public $name;

    /**
     * References a Career Object to which the Student belongs.
     *
     * @var Career
     */
    public $career;

    /**
     * Represents a Session-id like identifier.
     * NOTE: This identifier may expire over time, and changes with every new session.
     *
     * @var int
     */
    public $trim;

    /**
     * Student constructor.
     *
     * @param int $id
     * @param string $name
     * @param Career $career
     * @param int $trim
     */
    public function __construct(int $id, string $name, Career $career, int $trim)
    {
        $this->id = $id;
        $this->name = $name;
        $this->career = $career;
        $this->trim = $trim;
    }

    /**
     * @param SimpleXMLElement $data
     * @return Student
     */
    public static function fromData(SimpleXMLElement $data)
    {
        /** @var Career $career */
        $career = Career::fromData($data->ttCarrera);

        // Build Student model
        return new self(
            (int) $data->pochMatricula,
            (string) $data->pochNombre,
            $career,
            (string) $data->poinTrim
        );
    }
}

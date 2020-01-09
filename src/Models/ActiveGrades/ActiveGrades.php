<?php

namespace iksaku\SIASE\Models\ActiveGrades;

use iksaku\SIASE\Encoders\ActiveGradesEncoder;
use iksaku\SIASE\Models\Model;

class ActiveGrades extends Model
{
    /**
     * List of grades in the Active Grade.
     * @var Grade[]
     */
    protected $grades;

    /**
     * ActiveGrades constructor.
     * @param Grade[] $grades
     */
    public function __construct(array $grades)
    {
        $this->grades = $grades;
    }

    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new ActiveGradesEncoder(),
        ], parent::getEncoders());
    }

    /**
     * @return Grade[]
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * @param Grade[] $grades
     */
    public function setGrades(array $grades): void
    {
        $this->grades = $grades;
    }
}

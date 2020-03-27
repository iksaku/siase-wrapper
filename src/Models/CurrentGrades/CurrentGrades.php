<?php

namespace iksaku\SIASE\Models\CurrentGrades;

use iksaku\SIASE\Encoders\CurrentGradesEncoder;
use iksaku\SIASE\Models\Model;

class CurrentGrades extends Model
{
    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new CurrentGradesEncoder(),
        ], parent::getEncoders());
    }

    /**
     * List of grades in the Active Grade.
     * @var Grade[]
     */
    protected $grades = [];

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

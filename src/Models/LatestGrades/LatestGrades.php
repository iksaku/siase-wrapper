<?php

namespace iksaku\SIASE\Models\LatestGrades;

use iksaku\SIASE\Encoders\LatestGradesEncoder;
use iksaku\SIASE\Models\Model;

class LatestGrades extends Model
{
    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new LatestGradesEncoder(),
        ], parent::getEncoders());
    }

    /**
     * List of grades in the Active Grade.
     * @var Grade[]
     */
    protected $grades;

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

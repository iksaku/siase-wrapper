<?php

namespace iksaku\SIASE\Models\Kardex;

use iksaku\SIASE\Encoders\KardexEncoder;
use iksaku\SIASE\Models\Model;

class Kardex extends Model
{
    /**
     * List of grades in the Kardex.
     * @var Grade[]
     */
    protected $grades;

    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new KardexEncoder(),
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
    public function setGrades(array $grades)
    {
        sort($grades, SORT_REGULAR);
        $this->grades = $grades;
    }
}

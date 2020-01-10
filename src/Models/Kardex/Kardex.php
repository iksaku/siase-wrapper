<?php

namespace iksaku\SIASE\Models\Kardex;

use iksaku\SIASE\Encoders\KardexEncoder;
use iksaku\SIASE\Models\Model;

class Kardex extends Model
{
    /**
     * List of grades in the Kardex.
     * @var KardexGrade[]
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
     * @return KardexGrade[]
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * @param KardexGrade[] $grades
     */
    public function setGrades(array $grades)
    {
        sort($grades, SORT_REGULAR);
        $this->grades = $grades;
    }
}

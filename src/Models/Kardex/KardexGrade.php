<?php

namespace iksaku\SIASE\Models\Kardex;

use iksaku\SIASE\Models\Model;

class KardexGrade extends Model
{
    /**
     * Course name.
     * @var string
     */
    protected $courseName;

    /**
     * Grade obtained for the Course.
     * @var int
     */
    protected $grade;

    /**
     * Semester on which Course was completed.
     * @var int
     */
    protected $semester;

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @param string $courseName
     */
    public function setCourseName(string $courseName): void
    {
        $this->courseName = $courseName;
    }

    /**
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @param int $grade
     */
    public function setGrade(int $grade): void
    {
        $this->grade = $grade;
    }

    /**
     * @return int
     */
    public function getSemester(): int
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     */
    public function setSemester(int $semester): void
    {
        $this->semester = $semester;
    }
}

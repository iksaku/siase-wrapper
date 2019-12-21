<?php

namespace SIASE\Models\Kardex;

use SIASE\Models\Model;

class Grade extends Model
{
    /**
     * Semester on which Course was completed.
     * @var int
     */
    protected $semester;

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
     * Grade constructor.
     * @param int $semester
     * @param string $courseName
     * @param int $grade
     */
    public function __construct(int $semester, string $courseName, int $grade)
    {
        $this->semester = $semester;
        $this->courseName = $courseName;
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
    public function setSemester(int $semester)
    {
        $this->semester = $semester;
    }

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
    public function setCourseName(string $courseName)
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
    public function setGrade(int $grade)
    {
        $this->grade = $grade;
    }
}

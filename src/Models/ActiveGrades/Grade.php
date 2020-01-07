<?php

namespace iksaku\SIASE\Models\ActiveGrades;

use iksaku\SIASE\Models\Model;

class Grade extends Model
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
     * Opportunity in which the Course is being held.
     * @var int
     */
    protected $opportunity;

    /**
     * Grade constructor.
     * @param string $courseName
     * @param int $grade
     * @param int $opportunity
     */
    public function __construct(string $courseName, int $grade, int $opportunity)
    {
        $this->courseName = $courseName;
        $this->grade = $grade;
        $this->opportunity = $opportunity;
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
    public function getOpportunity(): int
    {
        return $this->opportunity;
    }

    /**
     * @param int $opportunity
     */
    public function setOpportunity(int $opportunity): void
    {
        $this->opportunity = $opportunity;
    }
}

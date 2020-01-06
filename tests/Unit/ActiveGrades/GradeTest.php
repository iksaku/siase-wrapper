<?php

namespace SIASE\Tests\Unit\ActiveGrades;

use SIASE\Models\ActiveGrades\Grade;
use SIASE\Tests\Unit\TestCase;

class GradeTest extends TestCase
{
    /**
     * @return array
     */
    public function grade_provider(): array
    {
        return [
            [
                $courseName = 'Unique Course',
                $grade = 70,
                $opportunity = 1,
                new Grade($courseName, $grade, $opportunity),
            ],
        ];
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $opportunity
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_course_name(string $courseName, int $intGrade, int $opportunity, Grade $grade): void
    {
        $this->assertSame($courseName, $grade->getCourseName());

        $grade->setCourseName($courseName = 'Chaos Course');
        $this->assertSame($courseName, $grade->getCourseName());
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $opportunity
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade(string $courseName, int $intGrade, int $opportunity, Grade $grade): void
    {
        $this->assertSame($intGrade, $grade->getGrade());

        $grade->setGrade($intGrade = 100);
        $this->assertSame($intGrade, $grade->getGrade());
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $opportunity
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_opportunity(string $courseName, int $intGrade, int $opportunity, Grade $grade): void
    {
        $this->assertSame($opportunity, $grade->getOpportunity());

        $grade->setOpportunity($opportunity = 5);
        $this->assertSame($opportunity, $grade->getOpportunity());
    }
}

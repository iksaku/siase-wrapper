<?php

/** @noinspection PhpUnusedParameterInspection */

namespace SIASE\Tests\Unit\Kardex;

use SIASE\Kardex\Grade;
use SIASE\Tests\TestCase;

class GradeTest extends TestCase
{
    /**
     * @return array[]
     */
    public function grade_provider(): array
    {
        return [
            [
                $semester = 1,
                $courseName = 'Unique Course',
                $grade = 70,
                new Grade($semester, $courseName, $grade),
            ],
        ];
    }

    /**
     * @param int $semester
     * @param string $courseName
     * @param int $intGrade
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_semester(int $semester, string $courseName, int $intGrade, Grade $grade)
    {
        $this->assertSame($semester, $grade->getSemester());

        $grade->setSemester($semester = 10);
        $this->assertSame($semester, $grade->getSemester());
    }

    /**
     * @param int $semester
     * @param string $courseName
     * @param int $intGrade
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_course_name(int $semester, string $courseName, int $intGrade, Grade $grade)
    {
        $this->assertSame($courseName, $grade->getCourseName());

        $grade->setCourseName($courseName = 'The One');
        $this->assertSame($courseName, $grade->getCourseName());
    }

    /**
     * @param int $semester
     * @param string $courseName
     * @param int $intGrade
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_grade(int $semester, string $courseName, int $intGrade, Grade $grade)
    {
        $this->assertSame($intGrade, $grade->getGrade());

        $grade->setGrade($intGrade = 100);
        $this->assertSame($intGrade, $grade->getGrade());
    }
}

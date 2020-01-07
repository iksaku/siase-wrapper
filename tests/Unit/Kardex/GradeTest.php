<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit\Kardex;

use iksaku\SIASE\Models\Kardex\Grade;
use iksaku\SIASE\Tests\Unit\TestCase;

class GradeTest extends TestCase
{
    /**
     * @return array[]
     */
    public function grade_provider(): array
    {
        return [
            [
                $courseName = 'Unique Course',
                $grade = 70,
                $semester = 1,
                new Grade($courseName, $grade, $semester),
            ],
        ];
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $semester
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_semester(string $courseName, int $intGrade, int $semester, Grade $grade)
    {
        $this->assertSame($semester, $grade->getSemester());

        $grade->setSemester($semester = 10);
        $this->assertSame($semester, $grade->getSemester());
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $semester
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_course_name(string $courseName, int $intGrade, int $semester, Grade $grade)
    {
        $this->assertSame($courseName, $grade->getCourseName());

        $grade->setCourseName($courseName = 'The One');
        $this->assertSame($courseName, $grade->getCourseName());
    }

    /**
     * @param string $courseName
     * @param int $intGrade
     * @param int $semester
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_grade(string $courseName, int $intGrade, int $semester, Grade $grade)
    {
        $this->assertSame($intGrade, $grade->getGrade());

        $grade->setGrade($intGrade = 100);
        $this->assertSame($intGrade, $grade->getGrade());
    }
}

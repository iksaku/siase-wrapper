<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit\Kardex;

use iksaku\SIASE\Models\Kardex\KardexGrade;
use iksaku\SIASE\Tests\Unit\TestCase;

class KardexGradeTest extends TestCase
{
    /**
     * @return array[]
     */
    public function grade_provider(): array
    {
        return array_map(function (KardexGrade $kardexGrade) {
            return compact('kardexGrade');
        }, factory()->create(KardexGrade::class, 3));
    }

    /**
     * @param KardexGrade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_semester(KardexGrade $grade)
    {
        $this->assertIsInt($grade->getSemester());

        $grade->setSemester($semester = 10);
        $this->assertSame($semester, $grade->getSemester());
    }

    /**
     * @param KardexGrade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_course_name(KardexGrade $grade)
    {
        $this->assertIsString($grade->getCourseName());

        $grade->setCourseName($courseName = 'The One');
        $this->assertSame($courseName, $grade->getCourseName());
    }

    /**
     * @param KardexGrade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_grade(KardexGrade $grade)
    {
        $this->assertIsInt($grade->getGrade());

        $grade->setGrade($newGrade = 100);
        $this->assertSame($newGrade, $grade->getGrade());
    }
}

<?php

namespace iksaku\SIASE\Tests\Unit\LatestGrades;

use iksaku\SIASE\Models\LatestGrades\Grade;
use iksaku\SIASE\Tests\Unit\TestCase;

class GradeTest extends TestCase
{
    /**
     * @return array
     */
    public function grade_provider(): array
    {
        return array_map(function (Grade $grade) {
            return compact('grade');
        }, factory()->create(Grade::class, 3));
    }

    /**
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_course_name(Grade $grade): void
    {
        $this->assertIsString($grade->getCourseName());

        $grade->setCourseName($courseName = 'Chaos Course');
        $this->assertSame($courseName, $grade->getCourseName());
    }

    /**
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade(Grade $grade): void
    {
        $this->assertIsInt($grade->getGrade());

        $grade->setGrade($newGrade = 100);
        $this->assertSame($newGrade, $grade->getGrade());
    }

    /**
     * @param Grade $grade
     * @dataProvider grade_provider
     */
    public function test_grade_opportunity(Grade $grade): void
    {
        $this->assertIsInt($grade->getOpportunity());

        $grade->setOpportunity($opportunity = 5);
        $this->assertSame($opportunity, $grade->getOpportunity());
    }
}

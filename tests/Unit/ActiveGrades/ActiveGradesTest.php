<?php

namespace SIASE\Tests\Unit\ActiveGrades;

use SIASE\Models\ActiveGrades\ActiveGrades;
use SIASE\Models\ActiveGrades\Grade;
use SIASE\Tests\Unit\TestCase;

class ActiveGradesTest extends TestCase
{
    /**
     * @return array
     */
    public function active_grades_provider(): array
    {
        return [
            [
                $grades = [],
                new ActiveGrades($grades),
            ],
        ];
    }

    /**
     * @param array $grades
     * @param ActiveGrades $activeGrades
     * @dataProvider active_grades_provider
     */
    public function test_active_grades(array $grades, ActiveGrades $activeGrades): void
    {
        $this->assertSame($grades, $activeGrades->getGrades());

        $activeGrades->setGrades($grades = [
            new Grade('First Course', 90, 1),
            new Grade('Second Course', 100, 3),
        ]);
        $this->assertSame($grades, $activeGrades->getGrades());
    }
}

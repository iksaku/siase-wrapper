<?php

namespace iksaku\SIASE\Tests\Unit\CurrentGrades;

use iksaku\SIASE\Models\CurrentGrades\CurrentGrades;
use iksaku\SIASE\Models\CurrentGrades\Grade;
use iksaku\SIASE\Tests\Unit\TestCase;

class CurrentGradesTest extends TestCase
{
    /**
     * @return array
     */
    public function active_grades_provider(): array
    {
        return array_map(function (CurrentGrades $latestGrades) {
            return compact('latestGrades');
        }, factory()->create(CurrentGrades::class, 3));
    }

    /**
     * @param CurrentGrades $activeGrades
     * @dataProvider active_grades_provider
     */
    public function test_active_grades(CurrentGrades $activeGrades): void
    {
        $this->assertEmpty($activeGrades->getGrades());

        $activeGrades->setGrades($grades = factory()->create(Grade::class, 2));
        $this->assertSame($grades, $activeGrades->getGrades());
    }
}

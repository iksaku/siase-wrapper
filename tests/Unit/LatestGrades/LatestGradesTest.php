<?php

namespace iksaku\SIASE\Tests\Unit\LatestGrades;

use iksaku\SIASE\Models\LatestGrades\Grade;
use iksaku\SIASE\Models\LatestGrades\LatestGrades;
use iksaku\SIASE\Tests\Unit\TestCase;

class LatestGradesTest extends TestCase
{
    /**
     * @return array
     */
    public function active_grades_provider(): array
    {
        return array_map(function (LatestGrades $latestGrades) {
            return compact('latestGrades');
        }, factory()->create(LatestGrades::class, 3));
    }

    /**
     * @param LatestGrades $activeGrades
     * @dataProvider active_grades_provider
     */
    public function test_active_grades(LatestGrades $activeGrades): void
    {
        $this->assertEmpty($activeGrades->getGrades());

        $activeGrades->setGrades($grades = factory()->create(Grade::class, 2));
        $this->assertSame($grades, $activeGrades->getGrades());
    }
}

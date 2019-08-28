<?php

namespace SIASE\Tests\Unit\Kardex;

use SIASE\Kardex\Grade;
use SIASE\Kardex\Kardex;
use SIASE\Tests\TestCase;

class KardexTest extends TestCase
{
    /**
     * @return array[]
     */
    public function kardex_provider(): array
    {
        return [
            [
                $grades = [],
                new Kardex($grades),
            ],
        ];
    }

    /**
     * @param Grade[] $grades
     * @param Kardex $kardex
     * @dataProvider kardex_provider
     */
    public function test_kardex_grades(array $grades, Kardex $kardex)
    {
        $this->assertSame($grades, $kardex->getGrades());

        $kardex->setGrades($grades = [
            new Grade(1, 'First Course', 70),
            new Grade(2, 'Second Course', 80),
        ]);
        $this->assertSame($grades, $kardex->getGrades());

        $grades[] = new Grade(3, 'Third Course', 90);
        $kardex->addGrades(...$grades);
        $this->assertSame($grades, $kardex->getGrades());
    }
}

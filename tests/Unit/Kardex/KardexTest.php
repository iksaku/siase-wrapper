<?php

namespace iksaku\SIASE\Tests\Unit\Kardex;

use iksaku\SIASE\Models\Kardex\Grade;
use iksaku\SIASE\Models\Kardex\Kardex;
use iksaku\SIASE\Tests\Unit\TestCase;

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
            new Grade('First Course', 70, 1),
            new Grade('Second Course', 80, 2),
        ]);
        $this->assertSame($grades, $kardex->getGrades());
    }
}

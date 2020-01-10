<?php

namespace iksaku\SIASE\Tests\Unit\Kardex;

use iksaku\SIASE\Models\Kardex\Kardex;
use iksaku\SIASE\Models\Kardex\KardexGrade;
use iksaku\SIASE\Tests\Unit\TestCase;

class KardexTest extends TestCase
{
    /**
     * @return array[]
     */
    public function kardex_provider(): array
    {
        return array_map(function (Kardex $kardex) {
            return compact('kardex');
        }, factory()->create(Kardex::class, 3));
    }

    /**
     * @param Kardex $kardex
     * @dataProvider kardex_provider
     */
    public function test_kardex_grades(Kardex $kardex)
    {
        $this->assertEmpty($kardex->getGrades());

        $kardex->setGrades($grades = factory()->create(KardexGrade::class, 2));
        sort($grades, SORT_REGULAR);
        $this->assertSame($grades, $kardex->getGrades());
    }
}

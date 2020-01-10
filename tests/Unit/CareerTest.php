<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit;

use iksaku\SIASE\Models\Career;

class CareerTest extends TestCase
{
    /**
     * @return array
     */
    public function career_provider(): array
    {
        return array_map(function (Career $career) {
            return compact('career');
        }, factory()->create(Career::class, 3));
    }

    /**
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_name(Career $career)
    {
        $this->assertIsString($career->getName());

        $career->setName($name = $this->getFaker()->words(3, true));
        $this->assertSame($name, $career->getName());
    }

    /**
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_short_name(Career $career)
    {
        $this->assertIsString($career->getShortName());

        $career->setShortName($short_name = 'mcu');
        $this->assertSame($short_name, $career->getShortName());
    }

    /**
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_cve(Career $career)
    {
        $this->assertIsString($career->getCve());

        $career->setCve($cve = dechex($this->getFaker()->numberBetween()));
        $this->assertSame($cve, $career->getCve());
    }
}

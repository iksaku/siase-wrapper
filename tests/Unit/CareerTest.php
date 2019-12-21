<?php

/** @noinspection PhpUnusedParameterInspection */

namespace SIASE\Tests\Unit;

use SIASE\Models\Career;

class CareerTest extends TestCase
{
    /**
     * @return array
     */
    public function career_provider(): array
    {
        $faker = $this->getFaker();

        $name = $faker->words(3, true);
        preg_match_all('/(?<=\s|^)(.)/', $name, $matches);
        $short_name = implode('', $matches[0]);

        return [
            [
                $name,
                $short_name,
                $cve = dechex($faker->numberBetween(10, 10000)),
                new Career($name, $short_name, $cve),
            ],
        ];
    }

    /**
     * @param string $name
     * @param string $short_name
     * @param string $cve
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_name(string $name, string $short_name, string $cve, Career $career)
    {
        $this->assertSame($name, $career->getName());

        $career->setName($name = $this->getFaker()->words(3, true));
        $this->assertSame($name, $career->getName());
    }

    /**
     * @param string $name
     * @param string $short_name
     * @param string $cve
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_short_name(string $name, string $short_name, string $cve, Career $career)
    {
        $this->assertSame($short_name, $career->getShortName());

        $career->setShortName($short_name = 'mcu');
        $this->assertSame($short_name, $career->getShortName());
    }

    /**
     * @param string $name
     * @param string $short_name
     * @param string $cve
     * @param Career $career
     * @dataProvider career_provider
     */
    public function test_career_cve(string $name, string $short_name, string $cve, Career $career)
    {
        $this->assertSame($cve, $career->getCve());

        $career->setCve($cve = dechex($this->getFaker()->numberBetween()));
        $this->assertSame($cve, $career->getCve());
    }
}

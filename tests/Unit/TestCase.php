<?php

namespace iksaku\SIASE\Tests\Unit;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /** @var Generator */
    private static $faker;

    /**
     * @return Generator
     */
    public function getFaker(): Generator
    {
        if (empty($this->faker)) {
            self::$faker = Factory::create('es_ES');
        }

        return self::$faker;
    }
}

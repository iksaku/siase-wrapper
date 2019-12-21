<?php

namespace SIASE\Tests\Unit;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /** @var Generator */
    private $faker;

    /**
     * @return Generator
     */
    public function getFaker(): Generator
    {
        if (empty($this->faker)) {
            $this->faker = Factory::create('es_ES');
        }

        return $this->faker;
    }
}

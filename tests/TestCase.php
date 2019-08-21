<?php

namespace SIASE\Tests;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * @return Generator
     */
    public function getFakerGenerator(): Generator
    {
        return Factory::create('es_ES');
    }
}

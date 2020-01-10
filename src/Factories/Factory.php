<?php

namespace iksaku\SIASE\Factories;

use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use iksaku\SIASE\Exceptions\ClassMustBeInstanceOfModelException;
use iksaku\SIASE\Models\Model;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class Factory
{
    /** @var Factory */
    private static $instance;

    /** @var Faker */
    protected $faker;

    /** @var array */
    protected $definitions;

    /**
     * Factory constructor.
     * @param Faker $faker
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * @return Factory
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = (new static(FakerFactory::create('es_ES')))->load();
        }

        return self::$instance;
    }

    /**
     * @return Factory
     */
    private function load(): self
    {
        $factory = $this;

        $files = Finder::create()
            ->files()
            ->name('*.php')
            ->notName('Factory.php')
            ->in(__DIR__);

        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            require $file->getRealPath();
        }

        return $factory;
    }

    /**
     * @param string $class
     * @param callable $attributes
     * @return $this
     */
    public function define(string $class, callable $attributes)
    {
        $this->definitions[$class] = $attributes;

        return $this;
    }

    /**
     * @param string $class
     * @param int $amount
     * @return array
     */
    public function create(string $class, int $amount = 1): array
    {
        $result = [];

        for ($i = 0; $i < $amount; $i++) {
            $attributes = $this->definitions[$class]($this->faker) ?? null;

            $object = new $class();

            if (!($object instanceof Model)) {
                throw new ClassMustBeInstanceOfModelException($class);
            }

            if (!empty($attributes)) {
                try {
                    $object::getSerializer()->denormalize($attributes, $class, null, [
                        AbstractNormalizer::OBJECT_TO_POPULATE => $object,
                    ]);
                } catch (ExceptionInterface $e) {
                    trigger_error($e);
                }
            }

            $result[] = $object;
        }

        return $result;
    }
}

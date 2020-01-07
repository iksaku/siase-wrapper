<?php

namespace iksaku\SIASE\Models;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Model.
 */
abstract class Model
{
    /**
     * @return array
     */
    protected static function getNormalizers(): array
    {
        return [
            new GetSetMethodNormalizer(),
        ];
    }

    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return [
            new JsonEncoder(),
        ];
    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer(static::getNormalizers(), static::getEncoders());
    }

    /**
     * @return array
     * @throws ExceptionInterface
     */
    public function toArray(): array
    {
        return static::getSerializer()->normalize($this);
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        return static::getSerializer()->serialize($this, 'json');
    }

    /**
     * @return array
     * @throws ExceptionInterface
     */
    public function __debugInfo()
    {
        return $this->toArray();
    }
}

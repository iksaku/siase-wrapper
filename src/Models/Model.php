<?php

namespace SIASE\Models;

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
    final public static function serializer(): Serializer
    {
        return new Serializer(static::getNormalizers(), static::getEncoders());
    }

    /**
     * @return array
     * @throws ExceptionInterface
     */
    public function toArray(): array
    {
        return static::serializer()->normalize($this);
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        return static::serializer()->serialize($this, 'json');
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

<?php

namespace iksaku\SIASE\Models;

use JsonSerializable;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Model.
 */
abstract class Model implements JsonSerializable
{
    /**
     * @return array
     */
    protected static function getNormalizers(): array
    {
        return [
            new PropertyNormalizer(),
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
    public function toJson(): string
    {
        return $this->jsonSerialize();
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
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

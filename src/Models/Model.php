<?php

namespace iksaku\SIASE\Models;

use JsonSerializable;
use Serializable;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Model.
 */
abstract class Model implements JsonSerializable, Serializable
{
    /**
     * @return array
     */
    protected static function getNormalizers(): array
    {
        return [
            new PropertyNormalizer(
                null,
                null,
                new PhpDocExtractor(),
            ),
            new ArrayDenormalizer(),
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
        return static::getSerializer()->serialize($this, 'json');
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->toJson();
    }

    /**
     * @return string
     * @throws ExceptionInterface
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * @param string $serialized
     * @throws ExceptionInterface
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        self::getSerializer()->denormalize($data, static::class, null, [
            AbstractNormalizer::OBJECT_TO_POPULATE => $this,
        ]);
    }
}

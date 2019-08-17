<?php

namespace SIASE;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Model.
 */
abstract class Model
{
    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer([
            new ObjectNormalizer(),
        ], [
            new XmlEncoder(),
            new JsonEncoder(),
        ]);
    }

    /**
     * @return array
     * @throws ExceptionInterface
     */
    public function toArray(): array
    {
        return self::getSerializer()->normalize($this);
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        return self::getSerializer()->serialize($this, 'json');
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

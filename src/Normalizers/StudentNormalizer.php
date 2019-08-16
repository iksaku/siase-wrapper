<?php

namespace SIASE\Normalizers;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class StudentNormalizer implements NameConverterInterface
{
    /**
     * Converts a property name to its normalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function normalize($propertyName): string
    {
        return $propertyName;
    }

    /**
     * Converts a property name to its denormalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function denormalize($propertyName): string
    {
        switch ($propertyName) {
            case 'pochMatricula':
                return 'id';
            case 'pochNombre':
                return 'name';
            case 'poinTrim':
                return 'trim';
            default:
                return $propertyName;
        }
    }
}

<?php

namespace SIASE\Normalizers;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CareerNormalizer implements NameConverterInterface
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
            case 'CveCarrera':
                return 'cve';
            case 'Abreviatura':
                return 'short_name';
            case 'DesCarrera':
                return 'name';
            default:
                return $propertyName;
        }
    }
}

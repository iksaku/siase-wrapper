<?php

namespace SIASE\Normalizers;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class KardexGradeNormalizer implements NameConverterInterface
{
    /**
     * Converts a property name to its normalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function normalize($propertyName)
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
    public function denormalize($propertyName)
    {
        switch ($propertyName) {
            case 'Semestre':
                return 'semester';
            case 'Materia':
                return 'courseName';
            case 'Calificacion':
                return 'grade';
            default:
                return $propertyName;
        }
    }
}

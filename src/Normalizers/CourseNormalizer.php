<?php

namespace SIASE\Normalizers;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CourseNormalizer implements NameConverterInterface
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
            case 'Id':
                return 'id';
            case 'DescLMateria':
                return 'name';
            case 'DescCMateria':
                return 'short_name';
            case 'Dia':
                return 'days';
            case 'HoraInicio':
                return 'starts_at';
            case 'HoraFin':
                return 'ends_at';
            case 'Grupo':
                return 'group';
            case 'Salon':
                return 'room';
            default:
                return $propertyName;
        }
    }
}

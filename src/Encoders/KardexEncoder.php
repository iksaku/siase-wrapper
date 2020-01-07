<?php

namespace iksaku\SIASE\Encoders;

use iksaku\SIASE\Exceptions\KardexException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class KardexEncoder extends XmlEncoder
{
    /**
     * {@inheritdoc}
     * @throws KardexException
     */
    public function decode(string $data, string $format, array $context = [])
    {
        // Decode XML data
        $decoded = parent::decode($data, $format, $context);

        // Look for Kardex errors
        if (filter_var($decoded['vlError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new KardexException($context['student']);
        }

        // Map object data
        $data = [
            'grades' => [],
        ];

        // Map grade data
        $data['grades'] = array_map(function ($gradeData) {
            return [
                'courseName' => $gradeData['Materia'],
                'grade' => (int) $gradeData['Calificacion'],
                'semester' => (int) $gradeData['Semestre'],
            ];
        }, $decoded['ttKdx']['ttKdxRow']);

        // Return decoded data
        return $data;
    }
}

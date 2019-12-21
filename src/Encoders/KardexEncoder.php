<?php

namespace SIASE\Encoders;

use Symfony\Component\Serializer\Encoder\XmlEncoder;

class KardexEncoder extends XmlEncoder
{
    /**
     * {@inheritdoc}
     */
    public function decode(string $data, string $format, array $context = [])
    {
        // Decode XML data
        $decoded = parent::decode($data, $format, $context);

        // Look for Kardex errors
        if (filter_var($decoded['vlError'], FILTER_VALIDATE_BOOLEAN)) {
            return ['error' => true];
        }

        // Map object data
        $data = [
            'grades' => [],
        ];

        // Map grade data
        $data['grades'] = array_map(function ($gradeData) {
            return [
                'semester' => (int) $gradeData['Semestre'],
                'courseName' => $gradeData['Materia'],
                'grade' => (int) $gradeData['Calificacion'],
            ];
        }, $decoded['ttKdx']['ttKdxRow']);

        // Return decoded data
        return $data;
    }
}

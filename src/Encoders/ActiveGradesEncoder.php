<?php

namespace SIASE\Encoders;

use SIASE\Exceptions\ActiveGradesException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ActiveGradesEncoder extends XmlEncoder
{
    /**
     * {@inheritdoc}
     */
    public function decode(string $data, string $format, array $context = [])
    {
        // Decode XML data
        $decoded = parent::decode($data, $format, $context);

        // Look for Active Grades errors
        if (filter_var($decoded['plgError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new ActiveGradesException($context['student']);
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
                'opportunity' => (int) $gradeData['Oportunidad'],
            ];
        }, $decoded['ttCalif']['ttCalifRow']);

        // Return decoded data
        return $data;
    }
}

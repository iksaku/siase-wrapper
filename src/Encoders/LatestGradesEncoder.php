<?php

namespace iksaku\SIASE\Encoders;

use iksaku\SIASE\Exceptions\LatestGradesException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class LatestGradesEncoder extends XmlEncoder
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
            throw new LatestGradesException($decoded['pchError']);
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

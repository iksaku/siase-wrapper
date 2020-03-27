<?php

namespace iksaku\SIASE\Encoders;

use iksaku\SIASE\Exceptions\CurrentGradesException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class CurrentGradesEncoder extends XmlEncoder
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
            throw new CurrentGradesException($decoded['pchError']);
        }

        if (!isset($decoded['ttCalif']['ttCalifRow'])) {
            throw new EmptyGradesException($context['student']);
        }

        // Map object data
        $data = [
            'grades' => [],
        ];

        // Hot-Fix in case there's only one course
        if (isset($decoded['ttCalif']['ttCalifRow']['Materia'])) {
            $decoded['ttCalif']['ttCalifRow'] = [
                $decoded['ttCalif']['ttCalifRow'],
            ];
        }

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

<?php

namespace SIASE\Encoders;

use Symfony\Component\Serializer\Encoder\XmlEncoder;

class StudentEncoder extends XmlEncoder
{
    /**
     * {@inheritdoc}
     */
    public function decode(string $data, string $format, array $context = [])
    {
        // Decode XML Data
        $decoded = parent::decode($data, $format, $context);

        // Look for login errors
        if (filter_var($decoded['ttError']['ttErrorRow']['lError'], FILTER_VALIDATE_BOOLEAN)) {
            return [
                'error' => true,
            ];
        }

        // Map object data
        $data = [
            'id' => (int) $decoded['pochMatricula'],
            'name' => $decoded['pochNombre'],
            'trim' => $decoded['poinTrim'],
            'careers' => [],
            'currentCareer' => null,
        ];

        // Careers workflow
        $decodedCareers = $decoded['ttCarrera']['ttCarreraRow'];

        if (isset($decodedCareers['DesCarrera'])) {
            // Only one career found, convert it into single value array
            $decodedCareers = [$decodedCareers];
        }

        // Map career data
        $data['careers'] = array_map(function ($careerData) {
            return [
                'name' => $careerData['DesCarrera'],
                'shortName' => $careerData['Abreviatura'],
                'cve' => $careerData['CveCarrera'],
            ];
        }, $decodedCareers);

        // Return decoded data
        return $data;
    }
}

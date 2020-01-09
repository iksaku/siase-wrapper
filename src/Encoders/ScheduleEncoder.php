<?php

namespace iksaku\SIASE\Encoders;

use iksaku\SIASE\Exceptions\ScheduleException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ScheduleEncoder extends XmlEncoder
{
    /**
     * {@inheritdoc}
     * @throws ScheduleException
     */
    public function decode(string $data, string $format, array $context = [])
    {
        // Decode XML data
        $decoded = parent::decode($data, $format, $context);

        // Look for Schedule Errors
        if (filter_var($decoded['plgError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new ScheduleException($context['student']);
        }

        // Map object data
        $data = [
            'period' => ucwords(strtolower($decoded['pchPeriodo'])),
            'courses' => [],
        ];

        // Map course data
        $decodedCourses = $decoded['ttHorario']['ttHorarioRow'];

        if (isset($decodedCourses['Id'])) {
            // Only one course found, convert it into single value array
            $decodedCourses = [$decodedCourses];
        }

        foreach ($decodedCourses as $courseData) {
            // Map the course data as it would normally
            $mappedCourseData = [
                'id' => $id = (int) $courseData['Id'],
                'name' => ucwords(strtolower($courseData['DescLMateria'])),
                'shortName' => $courseData['DescCMateria'],
                'days' => [
                    (int) $courseData['Dia'],
                ],
                'startsAt' => $courseData['HoraInicio'],
                'endsAt' => $courseData['HoraFin'],
                'group' => (int) $courseData['Grupo'],
                'room' => $courseData['Salon'],
            ];

            if (isset($data['courses'][$id])) {
                // If specific course is present in more than one day or "class hour",
                // merge into a single relationship
                $existingData = $data['courses'][$id];

                // Merge if multiple days
                $mappedCourseData['days'] = array_unique(
                    array_merge($existingData['days'], $mappedCourseData['days']),
                    SORT_NUMERIC
                );

                // Merge if more than one "class hour"
                $mappedCourseData['startsAt'] = min($existingData['startsAt'], $mappedCourseData['startsAt']);
                $mappedCourseData['endsAt'] = max($existingData['endsAt'], $mappedCourseData['endsAt']);
            }

            // Assign the mapped course data into the schedule
            $data['courses'][$id] = $mappedCourseData;
        }

        // Return decoded data
        return $data;
    }
}

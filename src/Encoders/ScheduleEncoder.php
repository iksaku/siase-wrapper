<?php

namespace iksaku\SIASE\Encoders;

use iksaku\SIASE\Exceptions\EmptyScheduleException;
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

        if (!isset($decoded['ttHorario']['ttHorarioRow'])) {
            throw new EmptyScheduleException($context['student']);
        }

        // Map object data
        $data = [
            'period' => $decoded['pchPeriodo'],
            'courses' => [],
        ];

        // Hot-Fix in case there's only one course
        if (isset($decoded['ttHorario']['ttHorarioRow']['Id'])) {
            $decoded['ttHorario']['ttHorarioRow'] = [
                $decoded['ttHorario']['ttHorarioRow'],
            ];
        }

        // Map course data
        // Need to Keep it as Foreach loop due to multiple rows representing the same Course
        foreach ($decoded['ttHorario']['ttHorarioRow'] as $courseData) {
            // Map the course data as it would normally
            $mappedCourseData = [
                'id' => $id = (int) $courseData['Id'],
                'name' => $courseData['DescLMateria'],
                'shortName' => $courseData['DescCMateria'],
                'days' => [
                    (int) $courseData['Dia'],
                ],
                'startsAt' => $courseData['HoraInicio'],
                'endsAt' => $courseData['HoraFin'],
                'numberOfClasses' => 0,
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

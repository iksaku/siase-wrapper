<?php

namespace SIASE\Actions;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use SIASE\Exceptions\ScheduleException;
use SIASE\Models\Schedule\Schedule as ScheduleModel;
use SIASE\Models\Student;
use SimpleXMLElement;

class Schedule extends Action
{
    /**
     * @param Student $student
     * @throws ScheduleException|InvalidArgumentException
     */
    public static function handle(Student $student = null)
    {
        if (empty($student)) {
            throw self::getArgumentException('student', 'Student');
        }

        /** @var ResponseInterface $response */
        $response = (new Client())->get(self::SIASE_ENDPOINT, [
            'query' => [
                ActionArgument::ID => $student->id,
                ActionArgument::CAREER_CVE => $student->career->cve,
                ActionArgument::REQUEST_TYPE => 4,
            ],
        ]);

        /** @var SimpleXMLElement $data */
        $data = simplexml_load_string($response->getBody()->getContents());

        // Check if there's an error. Throw and exception if so...
        if (filter_var($data->plgError, FILTER_VALIDATE_BOOLEAN)) {
            throw new ScheduleException();
        }

        // Build Schedule Model
        return ScheduleModel::fromData($data);
    }
}

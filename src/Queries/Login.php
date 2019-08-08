<?php

namespace SIASE\Queries;

use GuzzleHttp\Client;
use SIASE\Exceptions\AuthenticationException;
use SIASE\Student;

class Login
{
    // This query names are kept here and not in Query class because they are different only for Login
    const ID_QUERY = '108be0d';

    const PASSWORD_QUERY = 'd937aa6b';

    /**
     * Attempts to login with the given credentials.
     *
     * @param int $id
     * @param string $password
     * @return Student
     * @throws AuthenticationException
     */
    public static function attempt(int $id, string $password)
    {
        // Create Guzzle http client
        $client = new Client();

        // Sends a GET request to SIASE (Includes discovered properties)
        $response = $client->get(Query::SIASE_ENDPOINT, [
            'query' => [
                self::ID_QUERY => $id,
                self::PASSWORD_QUERY => $password,
                Query::REQUEST_TYPE => RequestType::LOGIN,

                '0c19de58' => '01', // Undefined property, could be related to 'requesting client party'.
            ],
        ]);

        // Parse XML response into SimpleXML Object
        $data = simplexml_load_string($response->getBody()->getContents());

        // Validates that error property is 'true' and throws exception if so...
        if (filter_var($data->ttError->ttErrorRow->lError, FILTER_VALIDATE_BOOLEAN)) {
            throw new AuthenticationException();
        }

        // Builds the Student model
        return Student::fromData($data);
    }
}

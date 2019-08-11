<?php

namespace SIASE\Actions;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use SIASE\Exceptions\LoginException;
use SIASE\Models\Student;
use SimpleXMLElement;

class Login extends Action
{
    // Login-specific Arguments
    const ID_ARGUMENT = '108be0d';

    const PASSWORD_ARGUMENT = 'd937aa6b';
    
    const LOGIN_TYPE_ARGUMENT = '0c19de58';
    
    const LOGIN_TYPE_STUDENT = 1;
    
    const LOGIN_TYPE_TEACHER = 2;

    /**
     * Attempts to login in behalf of a Student.
     *
     * @param int $id
     * @param string $password
     * @return Student
     * @throws LoginException|InvalidArgumentException
     */
    public static function handle(int $id = null, string $password = null)
    {
        if (empty($id) || !is_int($id)) {
            throw self::getArgumentException('id', 'integer');
        }

        if (empty($password) || !is_string($password)) {
            throw self::getArgumentException('password', 'string');
        }

        /** @var ResponseInterface */
        $response = (new Client())->get(self::SIASE_ENDPOINT, [
            'query' => [
                self::ID_ARGUMENT => $id,
                self::PASSWORD_ARGUMENT => $password,
                self::LOGIN_TYPE_ARGUMENT => self::LOGIN_TYPE_STUDENT,
                ActionArgument::ACTION_TYPE => ActionType::LOGIN,
            ],
        ]);

        /** @var SimpleXMLElement */
        $data = simplexml_load_string($response->getBody()->getContents());

        // Check if there's an error. Throw an exception if so...
        if (filter_var($data->ttError->ttErrorRow->lError, FILTER_VALIDATE_BOOLEAN)) {
            throw new LoginException();
        }

        // Builds the Student model
        return Student::fromData($data);
    }
}

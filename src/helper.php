<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use iksaku\SIASE\Factories\Factory;

const SIASE_ENDPOINT = 'http://deimos.dgi.uanl.mx/cgi-bin/mnat.sh/AppNat.p';

if (!function_exists('client')) {
    /**
     * @return Client
     */
    function client(): Client
    {
        return new Client([
            'base_uri' => SIASE_ENDPOINT,
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
    }
}

if (!function_exists('array_value_first')) {
    /**
     * @param array|object $array
     * @return mixed
     */
    function array_value_first($array)
    {
        $key = array_key_first($array);

        if ($key === null) {
            return null;
        }

        return $array[$key];
    }
}

if (!function_exists('array_value_last')) {
    /**
     * @param array|object $array
     * @return mixed
     */
    function array_value_last($array)
    {
        $key = array_key_last($array);

        if ($key === null) {
            return null;
        }

        return $array[$key];
    }
}

if (!function_exists('factory')) {
    /**
     * @return Factory
     */
    function factory()
    {
        return Factory::getInstance();
    }
}

if (!function_exists('now')) {
    /**
     * @return Carbon
     */
    function now(): Carbon
    {
        return Carbon::now();
    }
}

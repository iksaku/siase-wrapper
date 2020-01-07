<?php

use GuzzleHttp\Client;

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

if (!function_exists('array_last')) {
    /**
     * @param array|object $array
     * @return mixed
     */
    function array_last(&$array)
    {
        $last = end($array);
        reset($array);

        return $last;
    }
}

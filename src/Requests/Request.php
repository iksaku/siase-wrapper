<?php

namespace SIASE\Requests;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Request
{
    const SIASE_ENDPOINT = 'http://deimos.dgi.uanl.mx/cgi-bin/mnat.sh/AppNat.p';

    /**
     * @param array $options
     * @return ResponseInterface
     */
    public static function make(array $options = [])
    {
        return (new Client())->get(self::SIASE_ENDPOINT, $options);
    }
}

<?php

namespace SIASE\Actions;

use InvalidArgumentException;

abstract class Action
{
    const SIASE_ENDPOINT = 'http://deimos.dgi.uanl.mx/cgi-bin/mnat.sh/AppNat.p';

    abstract public static function handle();

    /**
     * @param string $name
     * @param string $type
     * @return InvalidArgumentException
     */
    protected static function getArgumentException(string $name, string $type)
    {
        return new InvalidArgumentException('Excepted argument $'.$name.' to be type of '.$type.'.');
    }
}

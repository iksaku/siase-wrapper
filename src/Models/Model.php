<?php

namespace SIASE\Models;

use SimpleXMLElement;

abstract class Model
{
    /**
     * @param SimpleXMLElement $data
     * @return mixed
     */
    abstract public static function fromData(SimpleXMLElement $data);
}

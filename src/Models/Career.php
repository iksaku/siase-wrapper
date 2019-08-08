<?php

namespace SIASE\Models;

use SimpleXMLElement;

class Career extends Model
{
    /**
     * Contains the name of the Career.
     *
     * @var string
     */
    public $name;

    /**
     * Contains the short name (or abbreviation) of the Career.
     *
     * @var string
     */
    public $short_name;

    /**
     * Contains the CVE reference of the career (hexadecimal format).
     *
     * @var string
     */
    public $cve;

    /**
     * Career constructor.
     *
     * @param string $name
     * @param string $short_name
     * @param string $cve
     */
    public function __construct(string $name, string $short_name, string $cve)
    {
        $this->name = $name;
        $this->short_name = $short_name;
        $this->cve = $cve;
    }

    /**
     * @param SimpleXMLElement $data
     * @return Career
     */
    public static function fromData(SimpleXMLElement $data)
    {
        // Build Career model
        return new self(
            (string) $data->ttCarreraRow->DesCarrera,
            (string) $data->ttCarreraRow->Abreviatura,
            (string) $data->ttCarreraRow->CveCarrera
        );
    }
}

<?php

namespace SIASE;

use SimpleXMLElement;

class Career
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
     * Creates a new instance from array data (Parsed XML).
     *
     * @param SimpleXMLElement $data
     * @return Career
     */
    public static function fromData(SimpleXMLElement $data)
    {
        // Build Career model from data
        return new self(
            (string) $data->ttCarreraRow->DesCarrera,
            (string) $data->ttCarreraRow->Abreviatura,
            (string) $data->ttCarreraRow->CveCarrera
        );
    }
}

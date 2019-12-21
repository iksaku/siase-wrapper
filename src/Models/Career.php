<?php

namespace SIASE\Models;

/**
 * Class Career.
 */
class Career extends Model
{
    /**
     * Name of the Career.
     * @var string
     */
    protected $name;

    /**
     * Abbreviation of Career's name.
     * @var string
     */
    protected $shortName;

    /**
     * Token that identifies the Student in the Career it belongs to.
     * @var string
     */
    protected $cve;

    /**
     * Career constructor.
     * @param string $name
     * @param string $shortName
     * @param string $cve
     */
    public function __construct(string $name, string $shortName, string $cve)
    {
        $this->name = $name;
        $this->shortName = $shortName;
        $this->cve = $cve;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getCve(): string
    {
        return $this->cve;
    }

    /**
     * @param string $cve
     */
    public function setCve(string $cve)
    {
        $this->cve = $cve;
    }
}

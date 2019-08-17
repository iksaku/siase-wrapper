<?php

namespace SIASE;

use SIASE\Normalizers\CareerNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    protected $short_name;

    /**
     * Token that identifies the Student in the Career it belongs to.
     * @var string
     */
    protected $cve;

    /**
     * Career constructor.
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
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return new Serializer([
            new ObjectNormalizer(null, new CareerNormalizer()),
        ], [
            new XmlEncoder(),
            new JsonEncoder(),
        ]);
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
        return $this->short_name;
    }

    /**
     * @param string $short_name
     */
    public function setShortName(string $short_name)
    {
        $this->short_name = $short_name;
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

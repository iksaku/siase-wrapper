<?php

namespace iksaku\SIASE\Models\Kardex;

use iksaku\SIASE\Encoders\KardexEncoder;
use iksaku\SIASE\Models\Model;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Kardex extends Model
{
    /**
     * List of grades in the Kardex.
     * @var Grade[]
     */
    protected $grades;

    /**
     * Kardex constructor.
     * @param Grade[] $grades
     */
    public function __construct(array $grades)
    {
        $this->grades = $grades;
    }

    /**
     * @return array
     */
    protected static function getNormalizers(): array
    {
        return [
            new ObjectNormalizer(
                null,
                null,
                null,
                new PhpDocExtractor()
            ),
            new ArrayDenormalizer(),
        ];
    }

    /**
     * @return array
     */
    protected static function getEncoders(): array
    {
        return array_merge([
            new KardexEncoder(),
        ], parent::getEncoders());
    }

    /**
     * @return Grade[]
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * @param Grade[] $grades
     */
    public function setGrades(array $grades)
    {
        sort($grades, SORT_REGULAR);
        $this->grades = $grades;
    }
}

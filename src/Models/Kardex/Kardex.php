<?php

namespace SIASE\Models\Kardex;

use Psr\Http\Message\ResponseInterface;
use SIASE\Encoders\KardexEncoder;
use SIASE\Exceptions\KardexException;
use SIASE\Models\Model;
use SIASE\Models\Student;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
            /*new KardexNormalizer(),*/
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
     * @param Student $student
     * @return Kardex
     * @throws KardexException
     * @throws ExceptionInterface
     */
    public static function fetchFor(Student $student): self
    {
        /** @var ResponseInterface $response */
        $response = Request::make([
            'query' => [
                RequestArgument::STUDENT_ID => $student->getId(),
                RequestArgument::STUDENT_CAREER_CVE => $student->getCurrentCareer()->getCve(),
                RequestArgument::REQUEST_TYPE => RequestType::KARDEX,
            ],
        ]);

        /** @var Serializer $serializer */
        $serializer = static::serializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (isset($data['error']) && $data['error']) {
            throw new KardexException($student);
        }

        /** @var Kardex $kardex */
        $kardex = $serializer->denormalize($data, static::class/*, null, [
            AbstractNormalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [
                static::class => [
                    'grades' => [],
                ],
            ],
        ]*/);

        return $kardex;
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

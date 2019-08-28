<?php

namespace SIASE\Kardex;

use Psr\Http\Message\ResponseInterface;
use SIASE\Exceptions\KardexException;
use SIASE\Model;
use SIASE\Requests\Request;
use SIASE\Requests\RequestArgument;
use SIASE\Requests\RequestType;
use SIASE\Student;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
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
     * @param array $grades
     */
    public function __construct(array $grades)
    {
        $this->grades = $grades;
    }

    /**
     * @param Student $student
     * @return Kardex
     * @throws KardexException
     * @throws ExceptionInterface
     */
    public static function requestFor(Student $student): self
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
        $serializer = self::getSerializer();

        /** @var array $data */
        $data = $serializer->decode($response->getBody()->getContents(), 'xml');

        if (filter_var($data['vlError'], FILTER_VALIDATE_BOOLEAN)) {
            throw new KardexException($student);
        }

        /** @var Serializer $gradeSerializer */
        $gradeSerializer = Grade::getSerializer();
        /** @var Grade[] $grades */
        $grades = [];
        $gradesData = $data['ttKdx']['ttKdxRow'];

        foreach ($gradesData as $grade) {
            $grades[] = $gradeSerializer->denormalize($grade, Grade::class, null, [
                'default_constructor_arguments' => [
                    Grade::class => [
                        'semester' => 0,
                        'courseName' => '',
                        'grade' => 0,
                    ],
                ],
            ]);
        }

        /** @var Kardex $kardex */
        $kardex = $serializer->denormalize($data, self::class, null, [
            'default_constructor_arguments' => [
                self::class => [
                    'grades' => [],
                ],
            ],
        ]);
        $kardex->setGrades($grades);

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
        $this->grades = $grades;
    }
}

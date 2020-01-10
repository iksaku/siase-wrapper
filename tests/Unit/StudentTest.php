<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit;

use iksaku\SIASE\Models\Career;
use iksaku\SIASE\Models\Kardex\Kardex;
use iksaku\SIASE\Models\LatestGrades\LatestGrades;
use iksaku\SIASE\Models\Schedule\Schedule;
use iksaku\SIASE\Models\Student;

class StudentTest extends TestCase
{
    /**
     * @return array
     */
    public function student_provider(): array
    {
        return array_map(function (Student $student) {
            return compact('student');
        }, factory()->create(Student::class, 3));
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_id(Student $student)
    {
        $this->assertIsInt($student->getId());

        $student->setId($id = $this->getFaker()->numberBetween());
        $this->assertSame($id, $student->getId());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_name(Student $student)
    {
        $this->assertIsString($student->getName());

        $student->setName($name = $this->getFaker()->name);
        $this->assertSame($name, $student->getName());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_trim(Student $student)
    {
        $this->assertIsString($student->getToken());

        $student->setToken($trim = (string) $this->getFaker()->numberBetween());
        $this->assertSame($trim, $student->getToken());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_careers(Student $student)
    {
        $this->assertIsArray($student->getCareers());
        $this->assertEmpty($student->getCareers());

        $student->setCareers($careers = factory()->create(Career::class));
        $this->assertSame($careers, $student->getCareers());
        $this->assertNotEmpty($student->getCareers());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_current_career(Student $student)
    {
        $this->assertEmpty($student->getCurrentCareer());

        $student->setCareers($careers = factory()->create(Career::class, 2));
        $this->assertSame(array_value_last($careers), $student->getCurrentCareer());

        $student->setCurrentCareer(
            $new_career = array_value_first(factory()->create(Career::class))
        );
        $this->assertSame($new_career, $student->getCurrentCareer());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_active_grades(Student $student)
    {
        $this->assertEmpty($student->getLatestGrades());

        $student->setLatestGrades(
            $activeGrades = array_value_first(factory()->create(LatestGrades::class))
        );
        $this->assertSame($activeGrades, $student->getLatestGrades());
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_kardex(Student $student)
    {
        $this->assertEmpty($student->getKardex());

        $student->setCareers(factory()->create(Career::class, 2));

        $student->setKardex(
            $firstKardex = array_value_first(factory()->create(Kardex::class)),
            $firstCareer = array_value_first($student->getCareers())
        );
        $this->assertSame($firstKardex, $student->getKardex($firstCareer));

        $student->setKardex(
            $secondKardex = array_value_first(factory()->create(Kardex::class)),
            $lastCareer = array_value_last($student->getCareers())
        );
        $this->assertSame($secondKardex, $student->getKardex($lastCareer));
    }

    /**
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_schedule(Student $student)
    {
        $this->assertEmpty($student->getSchedule());

        $student->setSchedule(
            $schedule = array_value_first(factory()->create(Schedule::class))
        );
        $this->assertSame($schedule, $student->getSchedule());
    }
}

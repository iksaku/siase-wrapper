<?php

/** @noinspection PhpUnusedParameterInspection */

namespace SIASE\Tests\Unit;

use SIASE\Models\ActiveGrades\ActiveGrades;
use SIASE\Models\Career;
use SIASE\Models\Kardex\Grade;
use SIASE\Models\Kardex\Kardex;
use SIASE\Models\Schedule\Schedule;
use SIASE\Models\Student;

class StudentTest extends TestCase
{
    /**
     * @return array[]
     */
    public function student_provider(): array
    {
        $faker = $this->getFaker();

        return [
            [
                $id = $faker->numberBetween(),
                $name = $faker->name,
                $trim = (string) $faker->numberBetween(),
                $careers = [],
                new Student($id, $name, $trim, $careers),
            ],
        ];
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_id(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertSame($id, $student->getId());

        $student->setId($id = $this->getFaker()->numberBetween());
        $this->assertSame($id, $student->getId());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_name(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertSame($name, $student->getName());

        $student->setName($name = $this->getFaker()->name);
        $this->assertSame($name, $student->getName());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_trim(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertSame($trim, $student->getToken());

        $student->setToken($trim = (string) $this->getFaker()->numberBetween());
        $this->assertSame($trim, $student->getToken());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_careers(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertSame($careers, $student->getCareers());
        $this->assertEmpty($student->getCareers());

        $student->setCareers($careers = [
            new Career('', 'Magical Career', 'mc'),
        ]);
        $this->assertSame($careers, $student->getCareers());
        $this->assertNotEmpty($student->getCareers());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_current_career(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $student->setCurrentCareer(null);
        $this->assertEmpty($student->getCurrentCareer());

        $student->setCareers($careers = [
            new Career('', 'Imaginary Career', 'ic'),
            new Career('', 'Second Imaginary Career', 'sic'),
        ]);
        $this->assertSame($careers[1], $student->getCurrentCareer());

        $student->setCurrentCareer($new_career = new Career('', 'New Career', 'nc'));
        $this->assertSame($new_career, $student->getCurrentCareer());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param array $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_active_grades(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertEmpty($student->getActiveGrades());

        $student->setActiveGrades($activeGrades = new ActiveGrades([
            new Grade('Dark Nebula', 100, 1),
        ]));
        $this->assertSame($activeGrades, $student->getActiveGrades());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_kardex(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertEmpty($student->getKardex(false));

        $student->setKardex($kardex = new Kardex([
            new Grade('Party Hard', 101, 0),
        ]));
        $this->assertSame($kardex, $student->getKardex(false));
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $trim
     * @param Career[] $careers
     * @param Student $student
     * @dataProvider student_provider
     */
    public function test_student_schedule(int $id, string $name, string $trim, array $careers, Student $student)
    {
        $this->assertEmpty($student->getSchedule());

        $student->setSchedule($schedule = new Schedule([], '0-Infinity'));
        $this->assertSame($schedule, $student->getSchedule());
    }
}

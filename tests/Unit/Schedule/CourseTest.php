<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit\Schedule;

use Carbon\Carbon;
use iksaku\SIASE\Models\Schedule\Course;
use iksaku\SIASE\Tests\Unit\TestCase;

class CourseTest extends TestCase
{
    /**
     * @return array
     */
    public function course_provider(): array
    {
        return array_map(function (Course $course) {
            return compact('course');
        }, factory()->create(Course::class, 3));
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_id(Course $course)
    {
        $this->assertIsInt($course->getId());

        $course->setId($id = $this->getFaker()->numberBetween(10, 20));
        $this->assertSame($id, $course->getId());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_name(Course $course)
    {
        $this->assertIsString($course->getName());

        $course->setName($name = $this->getFaker()->words(3, true));
        $this->assertSame($name, $course->getName());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_short_name(Course $course)
    {
        $this->assertIsString($course->getShortName());

        $course->setShortName($short_name = 'ibm');
        $this->assertSame($short_name, $course->getShortName());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_days(Course $course)
    {
        $this->assertNotEmpty($course->getDays());
        $this->assertCount(3, $course->getDays());

        $this->assertTrue($course->shouldAttendOnMonday());
        $this->assertTrue($course->shouldAttendOnWednesday());
        $this->assertTrue($course->shouldAttendOnFriday());

        $this->assertFalse($course->shouldAttendOnTuesday());
        $this->assertFalse($course->shouldAttendOnThursday());
        $this->assertFalse($course->shouldAttendOnSaturday());
        $this->assertFalse($course->shouldAttendOnSunday());

        $course->setDays($days = [Carbon::TUESDAY, Carbon::THURSDAY]);
        $this->assertSame($days, $course->getDays());

        $this->assertTrue($course->shouldAttendOnTuesday());
        $this->assertTrue($course->shouldAttendOnThursday());

        $this->assertFalse($course->shouldAttendOnMonday());
        $this->assertFalse($course->shouldAttendOnWednesday());
        $this->assertFalse($course->shouldAttendOnFriday());
        $this->assertFalse($course->shouldAttendOnSaturday());
        $this->assertFalse($course->shouldAttendOnSunday());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_starts_at(Course $course)
    {
        $this->assertIsString($course->getStartsAt());

        $course->setStartsAt($starts_at = '12:00');
        $this->assertSame($starts_at, $course->getStartsAt());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_ends_at(Course $course)
    {
        $this->assertIsString($course->getEndsAt());

        $course->setEndsAt($ends_at = '17:00');
        $this->assertSame($ends_at, $course->getEndsAt());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_group(Course $course)
    {
        $this->assertIsInt($course->getGroup());

        $course->setGroup($group = $this->getFaker()->randomNumber(3));
        $this->assertSame($group, $course->getGroup());
    }

    /**
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_room(Course $course)
    {
        $this->assertIsString($course->getRoom());

        $course->setRoom($room = (string) $this->getFaker()->numberBetween(1000, 9000));
        $this->assertSame($room, $course->getRoom());
    }
}

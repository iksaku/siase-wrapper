<?php

/** @noinspection PhpUnusedParameterInspection */

namespace SIASE\Tests\Unit\Schedule;

use Carbon\Carbon;
use SIASE\Schedule\Course;
use SIASE\Tests\TestCase;

class CourseTest extends TestCase
{
    /**
     * @return array
     */
    public function course_provider(): array
    {
        $faker = $this->getFaker();

        $name = $faker->words(3, true);
        preg_match_all('/(?<=\s|^)(.)/', $name, $matches);
        $short_name = implode('', $matches[0]);

        return [
            [
                $id = $faker->numberBetween(),
                $name,
                $short_name,
                $days = [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY],
                $starts_at = '12:50',
                $ends_at = '13:40',
                $group = $faker->randomNumber(3),
                $room = (string) $faker->numberBetween(1000, 9000),
                new Course($id, $name, $short_name, $days, $starts_at, $ends_at, $group, $room),
            ],
        ];
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_id(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($id, $course->getId());

        $course->setId($id = $this->getFaker()->numberBetween(10, 20));
        $this->assertSame($id, $course->getId());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_name(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($name, $course->getName());

        $course->setName($name = $this->getFaker()->words(3, true));
        $this->assertSame($name, $course->getName());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_short_name(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($short_name, $course->getShortName());

        $course->setShortName($short_name = 'ibm');
        $this->assertSame($short_name, $course->getShortName());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_days(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($days, $course->getDays());

        array_push($days, ...[Carbon::TUESDAY, Carbon::THURSDAY]);
        $course->addDays(...$days);
        // Unordered $days in test, must be different by course's ordered.
        $this->assertNotSame($days, $course->getDays());
        // Ordered $days in test, must be same as course order.
        sort($days, SORT_NUMERIC);
        $this->assertSame($days, $course->getDays());

        $this->assertTrue($course->shouldAttendOnMonday());
        $this->assertTrue($course->shouldAttendOnTuesday());
        $this->assertTrue($course->shouldAttendOnWednesday());
        $this->assertTrue($course->shouldAttendOnThursday());
        $this->assertTrue($course->shouldAttendOnFriday());

        $this->assertFalse($course->shouldAttendOnSaturday());

        $course->setDays($days = [Carbon::SATURDAY]);
        $this->assertSame($days, $course->getDays());
        $this->assertTrue($course->shouldAttendOnSaturday());

        $this->assertFalse($course->shouldAttendOnSunday());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_starts_at(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($starts_at, $course->getStartsAt());

        $course->setStartsAt($starts_at = '12:00');
        $this->assertSame($starts_at, $course->getStartsAt());

        $course->adjustStartsAt($starts_at = '16:20');
        $this->assertNotSame($starts_at, $course->getStartsAt());

        $course->adjustStartsAt($starts_at = '07:00');
        $this->assertSame($starts_at, $course->getStartsAt());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_ends_at(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($ends_at, $course->getEndsAt());

        $course->setEndsAt($ends_at = '17:00');
        $this->assertSame($ends_at, $course->getEndsAt());

        $course->adjustEndsAt($ends_at = '09:11');
        $this->assertNotSame($ends_at, $course->getEndsAt());

        $course->adjustEndsAt($ends_at = '22:00');
        $this->assertSame($ends_at, $course->getEndsAt());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_group(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($group, $course->getGroup());

        $course->setGroup($group = $this->getFaker()->randomNumber(3));
        $this->assertSame($group, $course->getGroup());
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $short_name
     * @param array $days
     * @param string $starts_at
     * @param string $ends_at
     * @param int $group
     * @param string $room
     * @param Course $course
     * @dataProvider course_provider
     */
    public function test_course_room(int $id, string $name, string $short_name, array $days, string $starts_at, string $ends_at, int $group, string $room, Course $course)
    {
        $this->assertSame($room, $course->getRoom());

        $course->setRoom($room = (string) $this->getFaker()->numberBetween(1000, 9000));
        $this->assertSame($room, $course->getRoom());
    }
}

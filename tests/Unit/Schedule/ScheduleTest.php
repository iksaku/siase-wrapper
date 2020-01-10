<?php

/** @noinspection PhpUnusedParameterInspection */

namespace iksaku\SIASE\Tests\Unit\Schedule;

use iksaku\SIASE\Models\Schedule\Course;
use iksaku\SIASE\Models\Schedule\Schedule;
use iksaku\SIASE\Tests\Unit\TestCase;

class ScheduleTest extends TestCase
{
    /**
     * @return array
     */
    public function schedule_provider(): array
    {
        return array_map(function (Schedule $schedule) {
            return compact('schedule');
        }, factory()->create(Schedule::class, 3));
    }

    /**
     * @param Schedule $schedule
     * @dataProvider schedule_provider
     */
    public function test_schedule_period(Schedule $schedule)
    {
        $this->assertIsString($schedule->getPeriod());

        $schedule->setPeriod($period = 'Last Semester');
        $this->assertSame($period, $schedule->getPeriod());
    }

    /**
     * @param Schedule $schedule
     * @dataProvider schedule_provider
     */
    public function test_schedule_courses(Schedule $schedule)
    {
        $this->assertEmpty($schedule->getCourses());

        $schedule->setCourses($courses = factory()->create(Course::class, 2));
        sort($courses, SORT_REGULAR);
        $this->assertSame($courses, $schedule->getCourses());
    }
}

<?php

namespace SIASE\Tests\Unit\Schedule;

use Carbon\Carbon;
use SIASE\Schedule\Course;
use SIASE\Schedule\Schedule;
use SIASE\Tests\TestCase;

class ScheduleTest extends TestCase
{
    /**
     * @return array[]
     */
    public function schedule_provider(): array
    {
        return [
            [
                $period = 'First Semester',
                $courses = [],
                new Schedule($period, $courses),
            ],
        ];
    }

    /**
     * @param string $period
     * @param Course[] $courses
     * @param Schedule $schedule
     * @dataProvider schedule_provider
     */
    public function test_schedule_period(string $period, array $courses, Schedule $schedule)
    {
        $this->assertSame($period, $schedule->getPeriod());

        $schedule->setPeriod($period = 'Last Semester');
        $this->assertSame($period, $schedule->getPeriod());
    }

    /**
     * @param string $period
     * @param Course[] $courses
     * @param Schedule $schedule
     * @dataProvider schedule_provider
     */
    public function test_schedule_courses(string $period, array $courses, Schedule $schedule)
    {
        $this->assertSame($courses, $schedule->getCourses());

        $schedule->setCourses($courses = [
            new Course(0, 'First Course', 'FC', Carbon::MONDAY, '07:00', '12:00', 1, 1100),
            new Course(1, 'Second Course', 'SC', Carbon::MONDAY, '12:00', '17:00', 2, 1101),
        ]);
        $this->assertSame($courses, $schedule->getCourses());

        $courses[] = new Course(2, 'Third Course', 'TC', Carbon::MONDAY, '17:00', '22:00', 3, 1102);
        $schedule->addCourses(...$courses);
        $this->assertSame($courses, $schedule->getCourses());
    }
}
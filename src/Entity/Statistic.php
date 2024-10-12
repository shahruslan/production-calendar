<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity;

final class Statistic
{
    public function __construct(
        public readonly int $calendarDays,
        public readonly int $calendarDaysWithoutHolidays,
        public readonly int $workDays,
        public readonly int $weekends,
        public readonly int $holidays,
        public readonly int $workingHours,
    ) {}
}

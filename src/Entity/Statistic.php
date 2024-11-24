<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity;

/**
 * @api
 */
final class Statistic
{
    public readonly int $calendarDays;
    public readonly int $calendarDaysWithoutHolidays;
    public readonly int $workDays;
    public readonly int $weekends;
    public readonly int $holidays;
    public readonly int $workingHours;
}

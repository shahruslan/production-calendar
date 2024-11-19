<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity;

use DateTimeImmutable;
use Shahruslan\ProductionCalendar\Entity\Dictionary\DayType;
use Shahruslan\ProductionCalendar\Entity\Dictionary\WeekDay;

/**
 * @api
 */
final class Day
{
    public function __construct(
        public readonly DateTimeImmutable $date,
        public readonly DayType $type,
        public readonly WeekDay $weekDay,
        public readonly int $workingHours,
        public readonly bool $isProject,
    ) {}
}

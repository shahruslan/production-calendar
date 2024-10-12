<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity;

use DateTimeImmutable;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Country;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Region;

final class Period
{
    /**
     * @param array<Day> $days
     */
    public function __construct(
        public readonly Country $country,
        public readonly ?Region $region,
        public readonly DateTimeImmutable $dateStart,
        public readonly DateTimeImmutable $dateEnd,
        public readonly string $workWeekType,
        public readonly string $period,
        public readonly array $days,
        public readonly Statistic $statistic,
    ) {}
}

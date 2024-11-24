<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity;

use DateTimeImmutable;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Country;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Region;

/**
 * @api
 */
final class Period
{
    public readonly Country $country;
    public readonly ?Region $region;
    public readonly DateTimeImmutable $dateStart;
    public readonly DateTimeImmutable $dateEnd;
    public readonly string $workWeekType;
    public readonly string $period;
    public readonly Statistic $statistic;

    /**
     * @var array<array-key, Day>
     */
    public readonly array $days;
}

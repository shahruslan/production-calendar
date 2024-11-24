<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Factory;

use Shahruslan\ProductionCalendar\Entity\Period;
use Shahruslan\ProductionCalendar\Exception\PeriodException;

interface PeriodFactoryInterface
{
    /**
     * @throws PeriodException
     */
    public function createFromArray(array $data): Period;
}

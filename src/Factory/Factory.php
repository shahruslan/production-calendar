<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Factory;

use DateTimeImmutable;
use Shahruslan\ProductionCalendar\Entity\Day;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Country;
use Shahruslan\ProductionCalendar\Entity\Dictionary\DayType;
use Shahruslan\ProductionCalendar\Entity\Dictionary\Region;
use Shahruslan\ProductionCalendar\Entity\Dictionary\WeekDay;
use Shahruslan\ProductionCalendar\Entity\Period;
use Shahruslan\ProductionCalendar\Entity\Statistic;

final class Factory
{
    public static function createPeriod(object $data): Period
    {
        $country = new Country($data->country_code, $data->country_text);
        $region = property_exists($data, 'region_id') ? new Region($data->region_id, $data->region_text) : null;
        $dateStart = new DateTimeImmutable($data->dt_start);
        $dateEnd = new DateTimeImmutable($data->dt_end);

        $days = array_map(static function ($day) {
            $date = new DateTimeImmutable($day->date);
            $type = DayType::from($day->type_text);
            $week = WeekDay::from($day->week_day);
            $isProject =  (bool) ($day->is_project ?? false);
            return new Day($date, $type, $week, $day->working_hours, $isProject);
        }, $data->days);

        $statistic = new Statistic(
            $data->statistic->calendar_days,
            $data->statistic->calendar_days_without_holidays,
            $data->statistic->work_days,
            $data->statistic->weekends,
            $data->statistic->holidays,
            $data->statistic->shortened_working_days,
            $data->statistic->working_hours,
        );

        $period = new Period(
            $country,
            $region,
            $dateStart,
            $dateEnd,
            $data->work_week_type,
            $data->period,
            $days,
            $statistic,
        );

        return $period;
    }
}

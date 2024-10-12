<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Validator;

use InvalidArgumentException;

final class Validator
{
    public function validateYear(int $year): void
    {
        if ($year < 1000 || $year > 9999) {
            throw new InvalidArgumentException('Год указан неверно');
        }
    }

    public function validateMonth(int $month): void
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('Месяц указан неверно');
        }
    }

    public function validateQuarter(int $quarter): void
    {
        if ($quarter < 1 || $quarter > 4) {
            throw new InvalidArgumentException('Квартал указан неверно');
        }
    }
}

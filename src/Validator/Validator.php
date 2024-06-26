<?php

namespace Shahruslan\ProductionCalendar\Validator;

use InvalidArgumentException;

class Validator
{
    public function validateYear(int $year): void
    {
        if ($year < 1000 || $year > 9999) {
            throw new InvalidArgumentException('Год указан неверно');
        }
    }

    public function validateMonth($month): void
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('Месяц указан неверно');
        }
    }

    public function validateQuarter($quarter): void
    {
        if ($quarter < 1 || $quarter > 4) {
            throw new InvalidArgumentException('Квартал указан неверно');
        }
    }
}

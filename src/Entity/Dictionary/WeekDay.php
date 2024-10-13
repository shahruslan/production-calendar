<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

enum WeekDay: string
{
    case monday = 'пн';
    case tuesday = 'вт';
    case wednesday = 'ср';
    case thursday = 'чт';
    case friday = 'пт';
    case saturday = 'сб';
    case sunday = 'вс';
}

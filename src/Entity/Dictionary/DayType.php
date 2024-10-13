<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

enum DayType: string
{
    case workingDay = 'Рабочий день';
    case dayOff = 'Выходной день';
    case publicHoliday = 'Государственный праздник';
    case regionalHoliday = 'Региональный праздник';
    case shortenedWorkingDay = 'Предпраздничный сокращенный рабочий день';
    case additionalDayOff = 'Дополнительный / перенесенный выходной день';
}

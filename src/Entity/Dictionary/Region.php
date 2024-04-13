<?php

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

class Region
{
    public function __construct(
        public readonly int $number,
        public readonly string $text,
    ) {
    }
}

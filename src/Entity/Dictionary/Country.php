<?php

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

class Country
{
    public function __construct(
        public readonly string $code,
        public readonly string $text,
    ) {
    }
}

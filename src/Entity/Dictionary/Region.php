<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

/**
 * @api
 */
final class Region
{
    public function __construct(
        public readonly int $number,
        public readonly string $text,
    ) {}
}

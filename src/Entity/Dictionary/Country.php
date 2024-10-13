<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Entity\Dictionary;

/**
 * @api
 */
final class Country
{
    public function __construct(
        public readonly string $code,
        public readonly string $text,
    ) {}
}

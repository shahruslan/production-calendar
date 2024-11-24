<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Factory;

use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string, mixed>
 */
final class SourceTransforming implements IteratorAggregate
{
    private readonly iterable $source;

    public function __construct(array $source)
    {
        $this->source = $this->transform($source);
    }

    public function getIterator(): Traversable
    {
        yield from $this->source;
    }

    private function transform(array $source): iterable
    {
        $source['country'] = [
            'code' => $source['country_code'] ?? '',
            'text' => $source['country_text'] ?? '',
        ];

        $source['region'] = isset($source['region_id'], $source['region_text'])
            ? ['id' => $source['region_id'], 'text' => $source['region_text']]
            : null;

        return $source;
    }
}

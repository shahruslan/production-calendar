<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar\Factory;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use Shahruslan\ProductionCalendar\Entity\Period;
use Shahruslan\ProductionCalendar\Exception\PeriodException;

final class FactoryWithValinor implements PeriodFactoryInterface
{
    private readonly TreeMapper $mapper;

    public function __construct(
        TreeMapper $mapper = null,
    ) {
        $this->mapper = $mapper ?: $this->defaultMapper();
    }

    private function defaultMapper(): TreeMapper
    {
        $builder = new MapperBuilder();
        return $builder
            ->allowSuperfluousKeys()
            ->supportDateFormats('d.m.Y')
            ->mapper();
    }

    /**
     * @throws PeriodException
     */
    public function createFromArray(array $data): Period
    {
        $source = Source::iterable(new SourceTransforming($data))
            ->camelCaseKeys()
            ->map([
                'dtStart' => 'dateStart',
                'dtEnd' => 'dateEnd',
                'days.*.typeText' => 'type',
            ]);

        try {
            $period = $this->mapper->map(Period::class, $source);
        } catch (MappingError $mappingError) {
            throw new PeriodException('Ошибка при создании объекта', previous: $mappingError);
        }

        return $period;
    }
}

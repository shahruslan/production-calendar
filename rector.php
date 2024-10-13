<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withRootFiles()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withParallel()
    ->withCache(__DIR__ . '/var/rector')
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withPhpSets(php81: true);

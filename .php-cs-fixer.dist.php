<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([
        './src',
    ])
    ->append([
        __FILE__,
    ])
;

$config = (new PhpCsFixer\Config())
    ->setCacheFile('./var/php-cs-fixer.cache')
    ->setFinder($finder)
    ->setRules([
        '@PHP83Migration' => false,
        '@PHP81Migration' => true,
    ])
;

(new \PHPyh\CodingStandard\PhpCsFixerCodingStandard())->applyTo($config);

return $config;

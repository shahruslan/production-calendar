<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use PHPyh\CodingStandard\PhpCsFixerCodingStandard;

$finder = (new Finder())
    ->in([
        './src',
    ])
    ->append([
        __FILE__,
        './rector.php',
    ]);

$config = (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setCacheFile('./var/php-cs-fixer.cache')
    ->setFinder($finder);

(new PhpCsFixerCodingStandard())->applyTo($config, [
    '@PHP83Migration' => false,
    '@PHP81Migration' => true,
    'nullable_type_declaration_for_default_null_value' => false,
    'explicit_string_variable' => false,
    'native_function_invocation' => false,
    'global_namespace_import' => false,
    'blank_line_before_statement' => [
        'statements' => [
            'include',
            'include_once',
            'phpdoc',
            'require',
            'require_once',
            'switch',
            'try',
            'declare',
        ],
    ],
    'class_attributes_separation' => [
        'elements' => [
            'property' => 'none',

            // 'const' => 'only_if_meta',
            // 'method' => 'only_if_meta',
            // 'trait_import' => 'only_if_meta',
            // 'case' => 'only_if_meta'
        ],
    ],
]);

return $config;

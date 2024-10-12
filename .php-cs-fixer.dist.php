<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PHPyh\CodingStandard\PhpCsFixerCodingStandard;

$finder = (new Finder())
    ->in([
        './src',
    ])
    ->append([
        __FILE__,
    ]);

$config = (new Config())
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
        ],
    ],
    'class_attributes_separation' => [
        'elements' => [
            'property' => 'none',
        ],
    ],
]);

return $config;

<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bin')
    ->exclude('config')
    ->exclude('tests/App/config')
    ->exclude('tests/App/var')
    ->exclude('vendor')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'visibility_required' => false,
        'array_syntax' => [
            'syntax' => 'short',
        ],
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;

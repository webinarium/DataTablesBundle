<?php

$finder = (new PhpCsFixer\Finder())
    ->in(realpath(__DIR__ . '/src'))
    ->in(realpath(__DIR__ . '/tests'))
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([

        //--------------------------------------------------------------
        //  Rule sets
        //--------------------------------------------------------------
        '@PSR1'               => true,
        '@PSR2'               => true,
        '@Symfony'            => true,
        '@Symfony:risky'      => true,
        '@PhpCsFixer'         => true,
        '@PhpCsFixer:risky'   => true,
        '@DoctrineAnnotation' => true,
        '@PHP70Migration'     => true,

        //--------------------------------------------------------------
        //  Rules override
        //--------------------------------------------------------------
        'binary_operator_spaces'      => ['default' => 'align'],
        'native_function_invocation'  => false,
        'self_static_accessor'        => true,
        'single_line_comment_spacing' => false,
    ])
    ->setFinder($finder)
;

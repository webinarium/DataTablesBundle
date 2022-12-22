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

        'binary_operator_spaces'        => ['default' => 'align'],
        'blank_line_before_statement'   => false,
        'braces'                        => false,
        'concat_space'                  => ['spacing' => 'one'],
        'native_function_invocation'    => false,
        'no_superfluous_phpdoc_tags'    => false,
        'phpdoc_annotation_without_dot' => false,
        'self_static_accessor'          => true,
        'single_line_comment_spacing'   => false,
        'yoda_style'                    => false,
    ])
    ->setFinder($finder)
;
